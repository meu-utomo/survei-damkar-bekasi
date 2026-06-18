<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QualitativeResponse extends Model
{
    protected $fillable = [
        'respondent_id',
        'is_tpp_fair',
        'testimonial',
    ];
}
