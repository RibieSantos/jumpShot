<?php

namespace App\Http\Controllers;

use App\Models\HistoryTrainings;
use Illuminate\Http\Request;

class HistoryTrainingsController extends Controller
{
    public function show(Request $request){
        $query = HistoryTrainings::query();
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('training_date', 'like', "%$search%")
                ->orWhere('', 'like', "%$search%")
                ->orWhere('focus', 'like', "%$search%")
                ->orWhere('location', 'like', "%$search%");
        }

        $sortField = $request->input('sort', 'id');
        $sortOrder = $request->input('direction', 'asc');
        $training = $query->orderBy($sortField, $sortOrder)->paginate(10);
        return view('admin.training.training-history',compact('training','sortField','sortOrder'));
    }

    public function traininhistory(){
        $trainH = HistoryTrainings::all();
        return view('users.member.trainingHistory',compact('trainH'));
    }
}
