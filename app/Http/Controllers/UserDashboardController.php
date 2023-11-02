<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TrainingRegistration;

class UserDashboardController extends Controller
{
    //
    public function index()
    {
        $user = auth()->user(); // Retrieve the authenticated user
        $trainingRegistrations = TrainingRegistration::where('user_id', $user->id)->get(); // Retrieve all training registrations for the authenticated user')
        return view('user_dashboard', compact('trainingRegistrations')); // Pass the trainings to the dashboard view
    }
}
