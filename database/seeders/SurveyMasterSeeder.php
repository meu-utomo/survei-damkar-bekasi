<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SurveyMasterSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Opsi Parameter E, P, C (Standar Fine-Kinney)
        DB::table('parameter_options')->insert([
            // --- EXPOSURE (E) ---
            ['parameter_type' => 'E', 'score' => 10.00, 'label' => 'Terus-menerus (Continuous)', 'description' => 'Terjadi berkali-kali dalam sehari'],
            ['parameter_type' => 'E', 'score' => 6.00, 'label' => 'Sering (Frequent)', 'description' => 'Terjadi minimal sekali sehari'],
            ['parameter_type' => 'E', 'score' => 3.00, 'label' => 'Kadang-kadang (Occasional)', 'description' => 'Terjadi sekali seminggu sampai sekali sebulan'],
            ['parameter_type' => 'E', 'score' => 2.00, 'label' => 'Jarang (Unusual)', 'description' => 'Terjadi sekali sebulan sampai sekali setahun'],
            ['parameter_type' => 'E', 'score' => 1.00, 'label' => 'Sangat Jarang (Rare)', 'description' => 'Terjadi beberapa kali dalam setahun'],
            ['parameter_type' => 'E', 'score' => 0.50, 'label' => 'Sangat Mustahil (Very Rare)', 'description' => 'Terjadi sekali setahun atau kurang'],

            // --- PROBABILITY (P) ---
            ['parameter_type' => 'P', 'score' => 10.00, 'label' => 'Sangat Mungkin (Almost Certain)', 'description' => 'Sangat mungkin terjadi jika bahaya muncul'],
            ['parameter_type' => 'P', 'score' => 6.00, 'label' => 'Mungkin Terjadi (Quite Possible)', 'description' => 'Memiliki peluang terjadi 50:50'],
            ['parameter_type' => 'P', 'score' => 3.00, 'label' => 'Belum Pernah Terjadi (Unusual but Possible)', 'description' => 'Pernah terjadi sebelumnya di tempat lain'],
            ['parameter_type' => 'P', 'score' => 1.00, 'label' => 'Sangat Kecil Kemungkinannya (Remotely Possible)', 'description' => 'Belum pernah terjadi, namun masih masuk akal'],
            ['parameter_type' => 'P', 'score' => 0.50, 'label' => 'Sangat Mustahil (Conceivable but Impractical)', 'description' => 'Sangat sulit terjadi, hampir tidak mungkin'],
            ['parameter_type' => 'P', 'score' => 0.10, 'label' => 'Sangat Mustahil Sekali (Practically Impossible)', 'description' => 'Peluang satu banding satu juta'],

            // --- CONSEQUENCE (C) ---
            ['parameter_type' => 'C', 'score' => 100.00, 'label' => 'Malapetaka (Catastrophe)', 'description' => 'Banyak korban jiwa / kematian massal'],
            ['parameter_type' => 'C', 'score' => 40.00, 'label' => 'Sangat Serius (Disaster)', 'description' => 'Mengakibatkan beberapa korban jiwa sekaligus'],
            ['parameter_type' => 'C', 'score' => 15.00, 'label' => 'Sangat Buruk (Very Serious)', 'description' => 'Satu korban jiwa / cacat permanen seumur hidup'],
            ['parameter_type' => 'C', 'score' => 7.00, 'label' => 'Penting (Important)', 'description' => 'Luka parah / rawat inap lama di RS'],
            ['parameter_type' => 'C', 'score' => 3.00, 'label' => 'Sedang (Noticeable)', 'description' => 'Luka sedang, butuh penanganan IGD RSUD'],
        ]);

        // 2. Skenario Risiko Terklasifikasi per Kelompok Responden
        DB::table('hazard_scenarios')->insert([

            // ================== KELOMPOK TARGET: PASUKAN LAPANGAN ==================
            [
                'category' => 'umum',
                'target_group' => 'pasukan',
                'title' => 'Bahaya Asap Tebal & Gas Beracun Industri',
                'description' => 'Masuk ke area pabrik/gudang yang dipenuhi asap hitam pekat hasil pembakaran material plastik, kabel, atau bahan kimia industri berbahaya.',
                'is_approved' => true,
                'created_by_respondent_id' => null
            ],
            [
                'category' => 'pemadam',
                'target_group' => 'pasukan',
                'title' => 'Api Besar & Panas Ekstrem di Kawasan Industri',
                'description' => 'Menjinakkan kobaran api raksasa di pabrik atau gudang dengan radiasi suhu panas ekstrem yang berisiko merusak pakaian pelindung harian.',
                'is_approved' => true,
                'created_by_respondent_id' => null
            ],
            [
                'category' => 'pemadam',
                'target_group' => 'pasukan',
                'title' => 'Kebakaran di Gang Sempit / Permukiman Padat Penduduk',
                'description' => 'Memadamkan api di area padat rumah warga, gang sempit, dengan risiko tersengat kabel listrik instalasi liar yang belum diputus oleh PLN.',
                'is_approved' => true,
                'created_by_respondent_id' => null
            ],
            [
                'category' => 'rescue',
                'target_group' => 'pasukan',
                'title' => 'Evakuasi Tawon Vespa, Ular Kobra, dan Hewan Berbisa',
                'description' => 'Menangani sarang tawon vespa di atap rumah warga atau menangkap ular kobra tanpa perlengkapan penanganan satwa berbisa yang aman.',
                'is_approved' => true,
                'created_by_respondent_id' => null
            ],
            [
                'category' => 'rescue',
                'target_group' => 'pasukan',
                'title' => 'Penyelamatan & Evakuasi Korban Tenggelam di Arus Deras (Water Rescue)',
                'description' => 'Melakukan pencarian korban tenggelam di sungai beraliran deras atau saluran irigasi (Kalimalang) dengan risiko terbawa arus atau tenggelam.',
                'is_approved' => true,
                'created_by_respondent_id' => null
            ],

            // ================== KELOMPOK TARGET: KOMANDAN PELETON/REGU ==================
            [
                'category' => 'taktis',
                'target_group' => 'komandan',
                'title' => 'Pengambilan Keputusan Taktis di Bawah Tekanan Waktu',
                'description' => 'Mengambil keputusan strategi operasi pemadaman dalam hitungan detik di lokasi, sementara warga berteriak panik atau bertindak anarkis.',
                'is_approved' => true,
                'created_by_respondent_id' => null
            ],
            [
                'category' => 'taktis',
                'target_group' => 'komandan',
                'title' => 'Tanggung Jawab atas Keselamatan Nyawa Anggota Regu',
                'description' => 'Kecemasan, rasa bersalah, atau trauma batin berat saat harus memerintahkan anak buah masuk ke dalam gedung membara demi menyelamatkan korban.',
                'is_approved' => true,
                'created_by_respondent_id' => null
            ],
            [
                'category' => 'taktis',
                'target_group' => 'komandan',
                'title' => 'Mengejar Response Time di Tengah Kemacetan & Akuntabilitas Hukum',
                'description' => 'Stres kejar batas waktu penanganan (<15 menit) di tengah kemacetan ekstrem Bekasi, serta risiko pemeriksaan hukum jika penanganan terlambat.',
                'is_approved' => true,
                'created_by_respondent_id' => null
            ],

            // ================== KELOMPOK TARGET: STAF MANAJEMEN/KANTOR ==================
            [
                'category' => 'administrasi',
                'target_group' => 'manajemen',
                'title' => 'Beban Kerja Administrasi & Tekanan Deadline Pelaporan',
                'description' => 'Menghadapi tumpukan berkas laporan realisasi dinas dengan deadline yang sangat ketat dari Inspektorat, BPKAD, atau BKPSDM.',
                'is_approved' => true,
                'created_by_respondent_id' => null
            ],
            [
                'category' => 'administrasi',
                'target_group' => 'manajemen',
                'title' => 'Tanggung Jawab Hukum & Akuntabilitas Anggaran Dinas (DPA)',
                'description' => 'Kecemasan dalam menyusun dokumen RKA/DPA agar tidak menyalahi aturan keuangan negara di tengah pengawasan ketat anggaran daerah.',
                'is_approved' => true,
                'created_by_respondent_id' => null
            ],
            [
                'category' => 'administrasi',
                'target_group' => 'manajemen',
                'title' => 'Ketegangan Mental Tidak Langsung Akibat Kondisi Darurat (Indirect Crisis)',
                'description' => 'Stres psikologis harian akibat berada di lingkungan kerja Mako yang siaga 24 jam, sering mendengar sirine, dan mengoordinasikan logistik bencana.',
                'is_approved' => true,
                'created_by_respondent_id' => null
            ],
        ]);
    }
}