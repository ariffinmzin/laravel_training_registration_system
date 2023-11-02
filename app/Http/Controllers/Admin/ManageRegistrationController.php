<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TrainingRegistration;

class ManageRegistrationController extends Controller
{
    //
    public function index()
    {
        //
        $trainingRegistrations = TrainingRegistration::all();
        return view('admin.manage_registration', compact('trainingRegistrations'));
    }

    public function updateStatus(Request $request, string $id)
    {
        // TrainingRegistration $trainingRegistration
        // dd($request);

        $trainingRegistrations = TrainingRegistration::find($id);

        $this->validate($request, [
            'submit' => 'required|in:approve,reject',
        ]);

        if($request['submit']=='approve') {

            $trainingRegistrations->status = 1;

        }
        else {

            $trainingRegistrations->status = 0;

        }

        $trainingRegistrations->save();
        Session()->flash('message', 'Status updated successfully');
        return redirect()->route('manage-registration.index');

    }
}
