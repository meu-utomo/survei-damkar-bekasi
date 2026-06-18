<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Respondent extends Model
{
    protected $fillable = [
        'name_initial',
        'respondent_group',
        'employment_status',
        'class_rank',
        'age_group',
        'years_of_service',
        'work_unit',
        'role_type',
        'submited_at',
    ];
}
