<?php

namespace App\Console\Commands;

use App\Models\Member;
use App\Models\MembershipHistory;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CheckMembershipExpiration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-membership-expiration';
    protected $description = 'Check for memberships that are about to expire or have expired.';

    /**
     * The console command description.
     *
     * @var string
     */

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = now()->startOfDay();
        $warningDate = $today->copy()->addDays(5);

        $members = Member::whereNotNull('membership_expiration_date')->get();

        foreach ($members as $member) {
            $expiration = \Carbon\Carbon::parse($member->membership_expiration_date);

            // 🔔 Warning 5 days before expiration
            if ($expiration->isSameDay($warningDate)) {
                Log::info("Membership of Member ID {$member->id} will expire in 5 days.");
                // You could also dispatch an email notification or event
            }

            // ⛔ If expired
            if ($expiration->isPast()) {
                MembershipHistory::create([
                    'member_id' => $member->id,
                    'start_date' => $member->membership_start_date,
                    'expiration_date' => $member->membership_expiration_date,
                ]);

                // Reset member’s active membership fields
                $member->update([
                    'membership_start_date' => null,
                    'membership_expiration_date' => null,
                ]);

                // Inactivate user
                $user = $member->user;
                if ($user) {
                    $user->status = 'inactive';
                    $user->save();
                }

                Log::info("Membership expired and logged for Member ID {$member->id}");
            }
            return Command::SUCCESS;
        }
    }
}
