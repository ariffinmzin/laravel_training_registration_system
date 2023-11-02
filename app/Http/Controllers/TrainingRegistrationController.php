<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Training;
use App\Models\TrainingRegistration;
use Auth;
use Illuminate\Support\Facades\File;

class TrainingRegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        //
        // $trainings = Training::find($id);
        // return view('trainingregistration_index', compact('trainings'));

        $training = Training::find($id);
        return view('trainingregistration_index', compact('training'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        // dd($request);
        $trainingRegistration = new TrainingRegistration();
        $user = auth()->user();
        $userId = auth()->user()->id;
        $this->validate($request, [
            'training_id' => 'required|exists:trainings,id',
            'proofofpayment' => 'required|mimes:jpeg,jpg,png,pdf|max:10000',

        ]);

        $trainingRegistration->user_id = $user->id;
        $trainingRegistration->training_id = $request['training_id'];

        if($request->hasFile('proofofpayment')){
          
            $proof_name = $request->file('proofofpayment');
            $filename = 'proof_'.$userId.'_'.time().'.'.$proof_name->getClientOriginalExtension();

            // Ensure the directory exists
            $path = public_path('uploads/proof');
            if(!File::isDirectory($path)){
                File::makeDirectory($path, 0777, true, true);
            }

            $file = $request['proofofpayment'];
            $file->move($path, $filename);
            $trainingRegistration->proofofpayment = $filename;
        }

        

        $trainingRegistration->save();

        Session()->flash('message', 'Your registration has been successfully submitted');

        return redirect()->route('training-list.index');

    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
