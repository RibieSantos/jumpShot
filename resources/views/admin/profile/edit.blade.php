@extends('admin.layouts.navigation')
@section('title', 'Admin Profile')
@section('content')

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- Profile Information Card -->
            <div class="p-6 sm:p-8 bg-gray-800 rounded-xl shadow-2xl border border-gray-700">
                <div class="max-w-2xl mx-auto">
                    {{-- Change @extends to @include for partials --}}
                    @include('admin.profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Update Password Card -->
            <div class="p-6 sm:p-8 bg-gray-800 rounded-xl shadow-2xl border border-gray-700">
                <div class="max-w-2xl mx-auto">
                    {{-- Change @extends to @include for partials --}}
                    @include('admin.profile.partials.update-password-form')
                </div>
            </div>
        </div>
    </div>
@endsection