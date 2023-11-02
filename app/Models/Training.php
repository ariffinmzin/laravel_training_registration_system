<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    use HasFactory;

    public function trainingregistration()
    {
        return $this->hasMany('App\Models\TrainingRegistration');
    }
}
