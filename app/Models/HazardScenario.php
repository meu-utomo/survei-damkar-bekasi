<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HazardScenario extends Model
{
    protected $fillable = [
        'category',
        'target_group',
        'title',
        'description',
        'is_approved',
        'created_by_respondent_id',
    ];
}
