<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InjuryHistory extends Model
{
    protected $fillable = [
        'respondent_id',
        'injury_type',
        'description',
    ];
}
