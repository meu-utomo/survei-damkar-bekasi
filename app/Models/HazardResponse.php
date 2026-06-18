<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HazardResponse extends Model
{
    protected $fillable = [
        'respondent_id',
        'hazard_scenario_id',
        'exposure_option_id',
        'probability_option_id',
        'consequence_option_id',
        'calculated_risk_score',
    ];

    /**
     * Otomatisasi perkalian nilai matematika Fine-Kinney dari opsi terpilih sebelum simpan.
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            // Ambil skor numerik dari database untuk masing-masing opsi
            $eScore = ParameterOption::find($model->exposure_option_id)?->score ?? 0;
            $pScore = ParameterOption::find($model->probability_option_id)?->score ?? 0;
            $cScore = ParameterOption::find($model->consequence_option_id)?->score ?? 0;

            // R = E x P x C
            $model->calculated_risk_score = $eScore * $pScore * $cScore;
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

    public function exposureOption(): BelongsTo
    {
        return $this->belongsTo(ParameterOption::class, 'exposure_option_id');
    }

    public function probabilityOption(): BelongsTo
    {
        return $this->belongsTo(ParameterOption::class, 'probability_option_id');
    }

    public function consequenceOption(): BelongsTo
    {
        return $this->belongsTo(ParameterOption::class, 'consequence_option_id');
    }
}