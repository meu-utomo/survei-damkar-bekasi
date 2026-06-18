<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Respondent;
use App\Models\HazardScenario;
use App\Models\ParameterOption;
use App\Models\HazardResponse;
use App\Models\InjuryHistory;
use App\Models\QualitativeResponse;
use Illuminate\Support\Facades\DB;

class SurveyWizard extends Component
{
    // Pengendali Langkah Wizard (1: Diri, 2: Soal Dinamis, 3: Risiko Kustom, 4: Evaluasi Kustom, 5: Cedera, 6: Aspirasi, 11: Sukses)
    public $currentStep = 1;
    public $totalSteps = 6;

    // Profil Responden
    public $name_initial;
    public $respondent_group = 'pasukan'; // Default, akan diubah responden di Step 1
    public $employee_status;
    public $class_rank;
    public $age_group;
    public $years_of_service;
    public $work_unit;
    public $role_type;

    // Parameter Opsi (Dimuat dari DB)
    public $exposureOptions = [];
    public $probabilityOptions = [];
    public $consequenceOptions = [];

    // Kuesioner Skenario Terpilih (Dimuat dinamis setelah Step 1)
    public $activeScenarios = [];
    public $answers = [];

    // Risiko Kustom Responden (Step 3 & 4)
    public $hasCustomRisk = 'no';
    public $customTitle;
    public $customDescription;
    public $customScenarios = [];

    // Cedera & Aspirasi (Step 5 & 6)
    public $selected_injuries = [];
    public $custom_injury;
    public $is_tpp_fair;
    public $testimonial;

    /**
     * Memuat daftar parameter pilihan di awal aplikasi dijalankan
     */
    public function mount()
    {
        $this->exposureOptions = ParameterOption::where('parameter_type', 'E')->get()->toArray();
        $this->probabilityOptions = ParameterOption::where('parameter_type', 'P')->get()->toArray();
        $this->consequenceOptions = ParameterOption::where('parameter_type', 'C')->get()->toArray();
    }

    /**
     * Memfilter dan memuat pertanyaan kuesioner secara dinamis setelah Step 1 Selesai
     */
    public function loadDynamicQuestions()
    {
        // Kueri database menyaring soal yang memiliki target_group sesuai dengan pilihan responden
        $this->activeScenarios = HazardScenario::where('is_approved', true)
            ->whereIn('target_group', [$this->respondent_group, 'umum'])
            ->get()
            ->toArray();

        // Inisialisasi ulang array jawaban
        $this->answers = [];
        foreach ($this->activeScenarios as $scenario) {
            $this->answers[$scenario['id']] = [
                'E' => null,
                'P' => null,
                'C' => null
            ];
        }

        // Reset riwayat cedera agar tidak tumpang tindih saat responden mengubah status grup
        $this->selected_injuries = [];
    }

    public function addCustomScenario()
    {
        $this->validate([
            'customTitle' => 'required|string|max:150',
            'customDescription' => 'required|string|min:10',
        ]);

        $newScenario = HazardScenario::create([
            'category' => 'tambahan',
            'target_group' => $this->respondent_group,
            'title' => $this->customTitle,
            'description' => $this->customDescription,
            'is_approved' => false,
        ]);

        $this->customScenarios[] = [
            'id' => $newScenario->id,
            'title' => $newScenario->title,
            'description' => $newScenario->description,
            'E' => null,
            'P' => null,
            'C' => null
        ];

        $this->customTitle = '';
        $this->customDescription = '';
    }

    public function removeCustomScenario($index)
    {
        $scenarioId = $this->customScenarios[$index]['id'];
        HazardScenario::destroy($scenarioId);

        unset($this->customScenarios[$index]);
        $this->customScenarios = array_values($this->customScenarios);
    }

    /**
     * Mengembalikan daftar opsi cedera yang dinonaktifkan/diaktifkan berdasarkan kelompok
     */
    public function getInjuryOptionsProperty()
    {
        if ($this->respondent_group === 'manajemen') {
            return [
                'Mata Lelah / Perih (Terlalu lama menatap layar komputer)',
                'Nyeri Otot Punggung / Low Back Pain (Duduk menyusun berkas laporan)',
                'Sakit Kepala Kronis / Migrain (Tekanan deadline laporan keuangan)',
                'Asam Lambung Naik / Mag (Stres menyusun berkas pertanggungjawaban dinas)',
                'Kecemasan Berlebih / Ansietas (Khawatir temuan atau audit anggaran)',
            ];
        }

        return [
            'Dehidrasi parah / heat exhaustion akibat panas kobaran api',
            'Luka bakar di bagian wajah atau kulit luar',
            'Luka robek / tertusuk material paku dan kawat bangunan runtuh',
            'Sesak napas akut akibat menghirup asap tebal zat kimia',
            'Penyakit paru-paru basah / sesak napas kronis jangka panjang',
            'Digigit ular kobra berbisa / sengatan tawon vespa saat evakuasi',
            'Patah tulang / dislokasi sendi akibat jatuh dari ketinggian',
            'Stres fisik ekstrem / pusing kepala akibat piket siaga darurat',
        ];
    }

    public function validateStep()
    {
        if ($this->currentStep === 1) {
            $this->validate([
                'respondent_group' => 'required',
                'employee_status' => 'required',
                'class_rank' => 'required|string',
                'age_group' => 'required',
                'years_of_service' => 'required',
                'work_unit' => 'required|string',
                'role_type' => 'required',
            ]);

            // Pemicu pemuatan soal dinamis
            $this->loadDynamicQuestions();
        }

        if ($this->currentStep === 2) {
            foreach ($this->activeScenarios as $scenario) {
                $id = $scenario['id'];
                $this->validate([
                    "answers.{$id}.E" => 'required',
                    "answers.{$id}.P" => 'required',
                    "answers.{$id}.C" => 'required',
                ], [
                    "answers.{$id}.E.required" => "Penilaian Paparan untuk '{$scenario['title']}' wajib dipilih.",
                    "answers.{$id}.P.required" => "Penilaian Kemungkinan untuk '{$scenario['title']}' wajib dipilih.",
                    "answers.{$id}.C.required" => "Penilaian Dampak untuk '{$scenario['title']}' wajib dipilih.",
                ]);
            }
        }

        if ($this->currentStep === 4 && count($this->customScenarios) > 0) {
            foreach ($this->customScenarios as $index => $cs) {
                $this->validate([
                    "customScenarios.{$index}.E" => 'required',
                    "customScenarios.{$index}.P" => 'required',
                    "customScenarios.{$index}.C" => 'required',
                ], [
                    "customScenarios.{$index}.E.required" => "Paparan untuk risiko tambahan '{$cs['title']}' wajib dipilih.",
                    "customScenarios.{$index}.P.required" => "Kemungkinan untuk risiko tambahan '{$cs['title']}' wajib dipilih.",
                    "customScenarios.{$index}.C.required" => "Konsekuensi untuk risiko tambahan '{$cs['title']}' wajib dipilih.",
                ]);
            }
        }

        if ($this->currentStep === 5) {
            $this->validate([
                'selected_injuries' => 'required|array|min:1',
            ]);
        }
    }

    public function nextStep()
    {
        $this->validateStep();

        if ($this->currentStep === 3) {
            if ($this->hasCustomRisk === 'no' || count($this->customScenarios) === 0) {
                $this->currentStep = 5; // Langsung lompat ke riwayat cedera
                return;
            }
        }

        if ($this->currentStep < $this->totalSteps) {
            $this->currentStep++;
        }
    }

    public function prevStep()
    {
        if ($this->currentStep === 5 && ($this->hasCustomRisk === 'no' || count($this->customScenarios) === 0)) {
            $this->currentStep = 3;
            return;
        }

        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    public function saveSurvey()
    {
        $this->validate([
            'is_tpp_fair' => 'required',
            'testimonial' => 'required|string|min:10',
        ]);

        DB::transaction(function () {
            // 1. Simpan Responden
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

            // Kaitkan ID draf kustom dengan ID responden
            if (count($this->customScenarios) > 0) {
                $createdIds = collect($this->customScenarios)->pluck('id');
                HazardScenario::whereIn('id', $createdIds)->update([
                    'created_by_respondent_id' => $respondent->id
                ]);
            }

            // 2. Simpan Jawaban Soal Master
            foreach ($this->answers as $scenarioId => $data) {
                HazardResponse::create([
                    'respondent_id' => $respondent->id,
                    'hazard_scenario_id' => $scenarioId,
                    'exposure_option_id' => $data['E'],
                    'probability_option_id' => $data['P'],
                    'consequence_option_id' => $data['C'],
                ]);
            }

            // 3. Simpan Jawaban Soal Kustom
            if ($this->hasCustomRisk === 'yes' && count($this->customScenarios) > 0) {
                foreach ($this->customScenarios as $cs) {
                    HazardResponse::create([
                        'respondent_id' => $respondent->id,
                        'hazard_scenario_id' => $cs['id'],
                        'exposure_option_id' => $cs['E'],
                        'probability_option_id' => $cs['P'],
                        'consequence_option_id' => $cs['C'],
                    ]);
                }
            }

            // 4. Simpan Riwayat Cedera
            foreach ($this->selected_injuries as $injury) {
                InjuryHistory::create([
                    'respondent_id' => $respondent->id,
                    'injury_type' => $injury,
                    'description' => $injury === 'Lainnya' ? $this->custom_injury : null,
                ]);
            }

            // 5. Simpan Aspirasi
            QualitativeResponse::create([
                'respondent_id' => $respondent->id,
                'is_tpp_fair' => $this->is_tpp_fair === 'yes',
                'testimonial' => $this->testimonial,
            ]);
        });

        $this->currentStep = 11; // Halaman sukses
    }

    public function render()
    {
        return view('livewire.survey-wizard')->layout('layouts.app');
    }
}