<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParameterOption extends Model
{
    protected $fillable = ['parameter_type', 'score', 'label', 'description'];
}