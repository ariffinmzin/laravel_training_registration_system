<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Training;
use Image;
use Illuminate\Support\Facades\File;

class TrainingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $trainings = Training::all();
        return view('admin.trainings_index', compact('trainings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.trainings_create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $userId = auth()->user()->id;
        $training = new Training();
        
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'trainer' => 'required|string|max:255',
            'photo' => 'nullable|mimes:jpeg,jpg,png|max:10000',
            'price' => 'required|numeric|min:0',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'place' => 'required|string|max:255',
            'capacity' => 'required|integer|min:0',
            'duration' => 'required|integer|min:0',
            'status' => 'required|string|max:255',
        ]);

        //save photo
        if($request->hasFile('photo')){
            $image = $request->file('photo');
            $filename = 'training_'.$userId.'_'.time().'.'.$image->getClientOriginalExtension();

            // Ensure the directory exists
            $path = public_path('images/trainings');
            if(!File::isDirectory($path)){
                File::makeDirectory($path, 0777, true, true);
            }

            Image::make($image)->resize(300,300)->save($path.'/'.$filename);
            $training->photo = $filename;

        }

        $training->name = $request['name'];
        $training->description = $request['description'];
        $training->trainer = $request['trainer'];
        $training->price = $request['price'];
        $training->date = $request['date'];
        $training->time = $request['time'];
        $training->place = $request['place'];
        $training->capacity = $request['capacity'];
        $training->duration = $request['duration'];
        $training->status = $request['status'];
        $training->save();

        Session()->flash('message', 'Training successfully added');
        
        return redirect()->route('trainings.index');
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
        $training = Training::find($id);
        return view('admin.trainings_edit',compact('training'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $userId = auth()->user()->id;
        $training = Training::find($id);
        
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'trainer' => 'required|string|max:255',
            'photo' => 'nullable|mimes:jpeg,jpg,png|max:10000',
            'price' => 'required|numeric|min:0',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'place' => 'required|string|max:255',
            'capacity' => 'required|integer|min:0',
            'duration' => 'required|integer|min:0',
            'status' => 'required|string|max:255',
        ]);

        //save photo
        if($request->hasFile('photo')){
            $image = $request->file('photo');
            $filename = 'training_'.$userId.'_'.time().'.'.$image->getClientOriginalExtension();

            // Ensure the directory exists
            $path = public_path('images/trainings');
            if(!File::isDirectory($path)){
                File::makeDirectory($path, 0777, true, true);
            }

            Image::make($image)->resize(300,300)->save($path.'/'.$filename);
            $training->photo = $filename;

        }

        $training->name = $request['name'];
        $training->description = $request['description'];
        $training->trainer = $request['trainer'];
        $training->price = $request['price'];
        $training->date = $request['date'];
        $training->time = $request['time'];
        $training->place = $request['place'];
        $training->capacity = $request['capacity'];
        $training->duration = $request['duration'];
        $training->status = $request['status'];
        $training->save();

        Session()->flash('message', 'Training has been successfully updated');
        
        return redirect()->route('trainings.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $training = Training::find($id);
        $training->delete();
        Session()->flash('message', 'Training has been successfully deleted');

        return redirect()->route('trainings.index');
    }
}