<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Respondent;
use App\Models\HazardResponse;
use App\Models\InjuryHistory;
use App\Models\QualitativeResponse;
use Illuminate\Support\Facades\DB;

class SurveyWizard extends Component
{
    // Mengatur halaman aktif (Step 1: Diri, Step 2-8: Skenario, Step 9: Cedera, Step 10: Aspirasi, Step 11: Sukses)
    public $currentStep = 1;
    public $totalSteps = 11;

    // Profil Responden
    public $name_initial;
    public $respondent_group = 'pasukan';
    public $employee_status;
    public $class_rank;
    public $age_group;
    public $years_of_service;
    public $work_unit;
    public $role_type;

    // Data Penilaian Risiko 7 Skenario Bahaya Lapangan
    public $scenarios = [
        1 => ['title' => 'Asap Tebal & Gas Beracun Industri', 'E' => null, 'P' => null, 'C' => null],
        2 => ['title' => 'Api Besar & Panas Ekstrem di Kawasan Industri', 'E' => null, 'P' => null, 'C' => null],
        3 => ['title' => 'Ancaman Beton/Atap Runtuh & Ledakan Susulan', 'E' => null, 'P' => null, 'C' => null],
        4 => ['title' => 'Kebakaran di Gang Sempit & Kawasan Padat Penduduk', 'E' => null, 'P' => null, 'C' => null],
        5 => ['title' => 'Risiko Kecelakaan Kecepatan Tinggi Saat Evakuasi di Jalan Tol', 'E' => null, 'P' => null, 'C' => null],
        6 => ['title' => 'Evakuasi Tawon Vespa, Ular Kobra, dan Hewan Liar Berbisa', 'E' => null, 'P' => null, 'C' => null],
        7 => ['title' => 'Penyelamatan & Evakuasi Korban Tenggelam di Arus Deras (Water Rescue)', 'E' => null, 'P' => null, 'C' => null],
    ];

    // Riwayat Cedera Medis
    public $selected_injuries = [];
    public $custom_injury;

    // Aspirasi Akhir
    public $is_tpp_fair;
    public $testimonial;

    // Aturan Validasi Khusus per Langkah Aktif
    public function getRules()
    {
        if ($this->currentStep === 1) {
            return [
                'employee_status' => 'required',
                'class_rank' => 'required|string|max:50',
                'age_group' => 'required',
                'years_of_service' => 'required',
                'work_unit' => 'required|string|max:100',
                'role_type' => 'required',
            ];
        }

        // Validasi Skenario (Langkah 2 sampai 8)
        if ($this->currentStep >= 2 && $this->currentStep <= 8) {
            $scenarioId = $this->currentStep - 1;
            return [
                "scenarios.{$scenarioId}.E" => 'required|numeric',
                "scenarios.{$scenarioId}.P" => 'required|numeric',
                "scenarios.{$scenarioId}.C" => 'required|numeric',
            ];
        }

        // Validasi Riwayat Cedera (Langkah 9 - Opsional, boleh kosong jika mencentang 'Tidak pernah')
        if ($this->currentStep === 9) {
            return [
                'selected_injuries' => 'required|array|min:1',
            ];
        }

        return [];
    }

    public function nextStep()
    {
        // Validasi data sebelum diizinkan pindah ke langkah berikutnya
        $this->validate($this->getRules());

        if ($this->currentStep < $this->totalSteps) {
            $this->currentStep++;
        }
    }

    public function prevStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    /**
     * Menyimpan seluruh berkas jawaban survei ke dalam database secara transaksional.
     */
    public function saveSurvey()
    {
        $this->validate([
            'is_tpp_fair' => 'required',
            'testimonial' => 'required|string|min:10',
        ]);

        DB::transaction(function () {
            // 1. Simpan Identitas Responden
            $respondent = Respondent::create([
                'name_initial' => $this->name_initial ?: 'ANON',
                'respondent_group' => $this->respondent_group,
                'employee_status' => $this->employee_status,
                'class_rank' => $this->class_rank,
                'age_group' => $this->age_group,
                'years_of_service' => $this->years_of_service,
                'work_unit' => $this->work_unit,
                'role_type' => $this->role_type,
                'submitted_at' => now(),
            ]);

            // 2. Simpan Jawaban 7 Skenario Risiko (Kalkulasi otomatis dipicu oleh event Model)
            foreach ($this->scenarios as $id => $data) {
                HazardResponse::create([
                    'respondent_id' => $respondent->id,
                    'hazard_scenario_id' => $id,
                    'exposure_score' => $data['E'],
                    'probability_score' => $data['P'],
                    'consequence_score' => $data['C'],
                ]);
            }

            // 3. Simpan Riwayat Cedera Medis
            foreach ($this->selected_injuries as $injury) {
                InjuryHistory::create([
                    'respondent_id' => $respondent->id,
                    'injury_type' => $injury,
                    'is_custom' => false,
                ]);
            }
            if ($this->custom_injury) {
                InjuryHistory::create([
                    'respondent_id' => $respondent->id,
                    'injury_type' => $this->custom_injury,
                    'is_custom' => true,
                ]);
            }

            // 4. Simpan Aspirasi Finansial Kualitatif
            QualitativeResponse::create([
                'respondent_id' => $respondent->id,
                'is_tpp_fair' => $this->is_tpp_fair === 'yes',
                'testimonial' => $this->testimonial,
            ]);
        });

        $this->currentStep = 11; // Pengalihan akhir ke halaman Sukses
    }

    public function render()
    {
        return view('livewire.survey-wizard')->layout('layouts.app');
    }
}