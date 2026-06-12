<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HazardResponse extends Model
{
    protected $fillable = [
        'respondent_id',
        'hazard_scenario_id',
        'is_custom',
        'custom_title',
        'custom_description',
        'exposure_score',
        'probability_score',
        'consequence_score',
        'calculated_risk_score',
    ];

    /**
     * Boot function untuk menghitung skor otomatis sebelum menyimpan data.
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            // Rumus Fine-Kinney: R = E x P x C
            $model->calculated_risk_score = $model->exposure_score * $model->probability_score * $model->consequence_score;
        });
    }

    public function respondent(): BelongsTo
    {
        return $this->belongsTo(Respondent::class);
    }

    public function scenario(): BelongsTo
    {
        return $this->belongsTo(HazardScenario::class, 'hazard_scenario_id');
    }
}
