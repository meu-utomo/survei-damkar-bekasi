<div class="max-w-4xl mx-auto my-12 px-4">
    
    <!-- Progress Bar -->
    @if($currentStep < 6)
        <div class="mb-8">
            <div class="flex justify-between text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">
                <span>Tahap Pengisian (Sesi Grup: {{ Str::upper($respondent_group) }})</span>
                <span>Fase {{ $currentStep }} dari 5</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2">
                <div class="bg-orange-600 h-2 rounded-full transition-all duration-300" style="width: {{ (($currentStep - 1) / 5) * 100 }}%"></div>
            </div>
        </div>
    @endif

    <div class="bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden">
        
        <!-- FASE 1: PROFIL RESPONDEN (Dengan Pemilihan Grup) -->
        @if($currentStep === 1)
            <div class="p-8">
                <h2 class="text-2xl font-extrabold text-gray-900 mb-6 flex items-center gap-2">
                    <span class="text-orange-600"><i class="fa-solid fa-user-shield"></i></span> Langkah 1: Profil Responden
                </h2>

                <div class="space-y-4">
                    <!-- Penentu Kelompok Responden -->
                    <div class="bg-orange-50/50 p-4 rounded-2xl border border-orange-100">
                        <label class="block text-sm font-bold text-gray-800 mb-2">Pilih Kelompok Tugas Anda *</label>
                        <select wire:model.live="respondent_group" class="w-full text-sm rounded-md border-gray-300 focus:ring-orange-500">
                            <option value="pasukan">Pasukan Lapangan / Pelaksana (Pemadam & Rescue)</option>
                            <option value="komandan">Komandan Peleton (Danton) / Komandan Regu (Danru)</option>
                            <option value="manajemen">Staf Manajemen / Administrasi Kantor</option>
                        </select>
                        <p class="text-[10px] text-gray-500 mt-1 leading-relaxed">Pilihan kelompok ini akan menyesuaikan draf pertanyaan risiko khusus pada langkah berikutnya agar relevan.</p>
                        @error('respondent_group') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700">Status Kepegawaian *</label>
                            <select wire:model="employee_status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-orange-500 focus:border-orange-500">
                                <option value="">-- Pilih --</option>
                                <option value="pns">PNS</option>
                                <option value="pppk">PPPK</option>
                            </select>
                            @error('employee_status') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700">Golongan / Kelas Jabatan *</label>
                            <input type="text" wire:model="class_rank" placeholder="Contoh: III/b atau Kelas IX" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            @error('class_rank') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700">Kelompok Usia *</label>
                            <select wire:model="age_group" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option value="">-- Pilih --</option>
                                <option value="< 25">Di bawah 25 Tahun</option>
                                <option value="25-35">25 - 35 Tahun</option>
                                <option value="36-45">36 - 45 Tahun</option>
                                <option value="> 45">Di atas 45 Tahun</option>
                            </select>
                            @error('age_group') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700">Masa Kerja di Damkar *</label>
                            <select wire:model="years_of_service" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option value="">-- Pilih --</option>
                                <option value="< 2">Kurang dari 2 Tahun</option>
                                <option value="2-5">2 - 5 Tahun</option>
                                <option value="6-10">6 - 10 Tahun</option>
                                <option value="> 10">Lebih dari 10 Tahun</option>
                            </select>
                            @error('years_of_service') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Pos Wilayah / Unit Penempatan Kerja *</label>
                        <input type="text" wire:model="work_unit" placeholder="Contoh: Mako Cikarang, Pos Tambun, Pos Cibitung" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        @error('work_unit') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Tugas Harian Utama *</label>
                        <select wire:model="role_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="">-- Pilih --</option>
                            <option value="pemadam">Pemadam Kebakaran</option>
                            <option value="rescue">Penyelamatan (Rescue)</option>
                            <option value="keduanya">Keduanya (Pemadam & Rescue)</option>
                            <option value="staf">Staf Kantor / Administrasi Umum</option>
                        </select>
                        @error('role_type') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
        @endif

        <!-- FASE 2: SOAL DINAMIS BERDASARKAN KELOMPOK RESIDEN -->
        @if($currentStep === 2)
            <div class="p-8">
                <h2 class="text-2xl font-extrabold text-gray-900 mb-2 flex items-center gap-2">
                    <span class="text-orange-600"><i class="fa-solid fa-list-check"></i></span> Langkah 2: Evaluasi Skenario Risiko Kelompok {{ Str::upper($respondent_group) }}
                </h2>
                <p class="text-xs text-gray-500 mb-6 leading-relaxed">Berikut adalah daftar skenario bahaya harian yang relevan dengan tugas kedinasan kelompok Anda.</p>

                <div class="space-y-8">
                    @foreach($activeScenarios as $scenario)
                        @php $id = $scenario['id']; @endphp
                        <div class="p-6 border border-gray-100 rounded-2xl bg-gray-50/50 space-y-4">
                            <div>
                                <span class="text-xs font-bold text-orange-600 uppercase tracking-wider">Klaster: {{ $scenario['category'] }}</span>
                                <h3 class="text-base font-bold text-gray-900 mt-0.5">{{ $scenario['title'] }}</h3>
                                <p class="text-xs text-gray-500 mt-1 leading-relaxed">{{ $scenario['description'] }}</p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-2 border-t border-gray-100">
                                <div>
                                    <label class="block text-xs font-bold text-gray-800 mb-2">1. Seberapa Sering? (E)</label>
                                    <select wire:model="answers.{{ $id }}.E" class="w-full text-xs rounded-md border-gray-300 shadow-sm">
                                        <option value="">-- Pilih --</option>
                                        @foreach($exposureOptions as $opt)
                                            <option value="{{ $opt['id'] }}">{{ $opt['label'] }} (Skor: {{ $opt['score'] }})</option>
                                        @endforeach
                                    </select>
                                    @error("answers.{$id}.E") <span class="text-red-500 text-[10px] mt-1 block">Wajib dipilih</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-gray-800 mb-2">2. Kemungkinan Cedera? (P)</label>
                                    <select wire:model="answers.{{ $id }}.P" class="w-full text-xs rounded-md border-gray-300 shadow-sm">
                                        <option value="">-- Pilih --</option>
                                        @foreach($probabilityOptions as $opt)
                                            <option value="{{ $opt['id'] }}">{{ $opt['label'] }} (Skor: {{ $opt['score'] }})</option>
                                        @endforeach
                                    </select>
                                    @error("answers.{$id}.P") <span class="text-red-500 text-[10px] mt-1 block">Wajib dipilih</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-gray-800 mb-2">3. Dampak Terburuk? (C)</label>
                                    <select wire:model="answers.{{ $id }}.C" class="w-full text-xs rounded-md border-gray-300 shadow-sm">
                                        <option value="">-- Pilih --</option>
                                        @foreach($consequenceOptions as $opt)
                                            <option value="{{ $opt['id'] }}">{{ $opt['label'] }} (Skor: {{ $opt['score'] }})</option>
                                        @endforeach
                                    </select>
                                    @error("answers.{$id}.C") <span class="text-red-500 text-[10px] mt-1 block">Wajib dipilih</span> @enderror
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- FASE 3: INPUT RISIKO KUSTOM TAMBAHAN -->
        @if($currentStep === 3)
            <div class="p-8">
                <h2 class="text-2xl font-extrabold text-gray-900 mb-2 flex items-center gap-2">
                    <span class="text-orange-600"><i class="fa-solid fa-circle-plus"></i></span> Langkah 3: Tambah Risiko Lapangan Kustom
                </h2>
                <p class="text-xs text-gray-500 mb-6 leading-relaxed">Apakah ada kejadian berbahaya, situasi eksternal ekstrem, atau ancaman fisik lainnya yang Anda alami di lapangan namun **belum tercantum** pada daftar risiko di halaman sebelumnya?</p>

                <div class="space-y-6">
                    <div class="bg-gray-50 p-5 rounded-2xl border border-gray-100 flex items-center justify-between">
                        <span class="text-sm font-bold text-gray-800">Ada risiko lain yang ingin ditambahkan?</span>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-2 cursor-pointer text-sm font-semibold text-gray-700">
                                <input type="radio" wire:model.live="hasCustomRisk" value="yes" class="text-orange-600 focus:ring-orange-500"> Ya
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer text-sm font-semibold text-gray-700">
                                <input type="radio" wire:model.live="hasCustomRisk" value="no" class="text-orange-600 focus:ring-orange-500"> Tidak Ada
                            </label>
                        </div>
                    </div>

                    @if($hasCustomRisk === 'yes')
                        <div class="p-6 border-2 border-dashed border-gray-200 rounded-2xl space-y-4">
                            <h3 class="text-sm font-bold text-gray-800 flex items-center gap-2">
                                <span class="h-2 w-2 rounded-full bg-orange-600 animate-pulse"></span> Form Tambah Risiko Kustom
                            </h3>
                            <div>
                                <label class="block text-xs font-bold text-gray-700">Judul Skenario Risiko Tambahan *</label>
                                <input type="text" wire:model="customTitle" placeholder="Contoh: Terjebak runtuhan atap logam saat pemadaman di gang sempit" class="mt-1 block w-full rounded-md border-gray-300 text-sm focus:ring-orange-500">
                                @error('customTitle') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700">Deskripsi / Kronologi Kejadian Bahaya *</label>
                                <textarea wire:model="customDescription" rows="3" placeholder="Jelaskan bagaimana risiko bahaya tersebut terjadi dan apa ancamannya bagi fisik petugas..." class="mt-1 block w-full rounded-md border-gray-300 text-sm focus:ring-orange-500"></textarea>
                                @error('customDescription') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            <button type="button" wire:click="addCustomScenario" class="w-full bg-slate-900 hover:bg-slate-800 text-white font-bold py-2 px-4 rounded-xl text-xs transition flex items-center justify-center gap-2 shadow-md">
                                <i class="fa-solid fa-plus"></i> Tambahkan Ke Daftar Evaluasi
                            </button>
                        </div>

                        @if(count($customScenarios) > 0)
                            <div class="space-y-3">
                                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Daftar Antrean Risiko Kustom Anda ({{ count($customScenarios) }} Risiko)</h4>
                                @foreach($customScenarios as $index => $cs)
                                    <div class="flex justify-between items-center p-4 border border-gray-100 bg-orange-50/20 rounded-xl">
                                        <div class="max-w-[85%]">
                                            <h5 class="text-sm font-bold text-gray-900">{{ $cs['title'] }}</h5>
                                            <p class="text-xs text-gray-500 mt-0.5 truncate">{{ $cs['description'] }}</p>
                                        </div>
                                        <button type="button" wire:click="removeCustomScenario({{ $index }})" class="text-red-500 hover:text-red-700 transition"><i class="fa-solid fa-trash"></i></button>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        @endif

        <!-- FASE 4: EVALUASI E, P, C KHUSUS UNTUK RISIKO KUSTOM -->
        @if($currentStep === 4 && count($customScenarios) > 0)
            <div class="p-8">
                <h2 class="text-2xl font-extrabold text-gray-900 mb-2 flex items-center gap-2">
                    <span class="text-orange-600"><i class="fa-solid fa-calculator"></i></span> Langkah 4: Evaluasi Parameter Risiko Kustom Anda
                </h2>
                <p class="text-xs text-gray-500 mb-6 leading-relaxed">Berikan penilaian $E$, $P$, dan $C$ secara spesifik untuk setiap risiko kustom baru yang baru saja Anda masukkan.</p>

                <div class="space-y-8">
                    @foreach($customScenarios as $index => $cs)
                        <div class="p-6 border-2 border-orange-100 rounded-2xl bg-orange-50/10 space-y-4">
                            <div>
                                <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded-full text-[10px] font-bold bg-orange-100 text-orange-700">
                                    Risiko Kustom #{{ $index + 1 }}
                                </span>
                                <h3 class="text-base font-bold text-gray-900 mt-2">{{ $cs['title'] }}</h3>
                                <p class="text-xs text-gray-500 mt-1 leading-relaxed">{{ $cs['description'] }}</p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-2 border-t border-gray-100">
                                <div>
                                    <label class="block text-xs font-bold text-gray-800 mb-2">1. Seberapa Sering? (E)</label>
                                    <select wire:model="customScenarios.{{ $index }}.E" class="w-full text-xs rounded-md border-gray-300 shadow-sm">
                                        <option value="">-- Pilih --</option>
                                        @foreach($exposureOptions as $opt)
                                            <option value="{{ $opt['id'] }}">{{ $opt['label'] }} (Skor: {{ $opt['score'] }})</option>
                                        @endforeach
                                    </select>
                                    @error("customScenarios.{$index}.E") <span class="text-red-500 text-[10px] mt-1 block">Wajib dipilih</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-gray-800 mb-2">2. Kemungkinan? (P)</label>
                                    <select wire:model="customScenarios.{{ $index }}.P" class="w-full text-xs rounded-md border-gray-300 shadow-sm">
                                        <option value="">-- Pilih --</option>
                                        @foreach($probabilityOptions as $opt)
                                            <option value="{{ $opt['id'] }}">{{ $opt['label'] }} (Skor: {{ $opt['score'] }})</option>
                                        @endforeach
                                    </select>
                                    @error("customScenarios.{$index}.P") <span class="text-red-500 text-[10px] mt-1 block">Wajib dipilih</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-gray-800 mb-2">3. Dampak Terburuk? (C)</label>
                                    <select wire:model="customScenarios.{{ $index }}.C" class="w-full text-xs rounded-md border-gray-300 shadow-sm">
                                        <option value="">-- Pilih --</option>
                                        @foreach($consequenceOptions as $opt)
                                            <option value="{{ $opt['id'] }}">{{ $opt['label'] }} (Skor: {{ $opt['score'] }})</option>
                                        @endforeach
                                    </select>
                                    @error("customScenarios.{$index}.C") <span class="text-red-500 text-[10px] mt-1 block">Wajib dipilih</span> @enderror
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- FASE 5: DAFTAR CEDERA ADAPTIF SESUAI KELOMPOK RESPONDEN -->
        @if($currentStep === 5)
            <div class="p-8">
                <h2 class="text-2xl font-extrabold text-gray-900 mb-4 flex items-center gap-2">
                    <span class="text-orange-600"><i class="fa-solid fa-kit-medical"></i></span> Langkah 5: Catatan Riwayat Kesehatan & Cedera Kerja
                </h2>
                <p class="text-sm text-gray-500 mb-6">Pernahkah Anda mengalami kecelakaan kerja atau masalah kesehatan berikut dalam 3 tahun terakhir? (Centang semua yang pernah dialami)</p>

                <div class="space-y-3 bg-gray-50 p-5 rounded-2xl border border-gray-100">
                    <!-- Melakukan loop daftar cedera dari properti dinamis (computed property) Livewire -->
                    @foreach($this->injuryOptions as $injury)
                        <label class="flex items-center gap-3 cursor-pointer p-1 rounded hover:bg-white transition">
                            <input type="checkbox" wire:model="selected_injuries" value="{{ $injury }}" class="rounded text-orange-600 focus:ring-orange-500">
                            <span class="text-sm text-gray-700">{{ $injury }}</span>
                        </label>
                    @endforeach

                    <label class="flex items-center gap-3 cursor-pointer p-1 rounded hover:bg-white transition pt-4 border-t border-gray-200">
                        <input type="checkbox" wire:model="selected_injuries" value="Lainnya" class="rounded text-orange-600 focus:ring-orange-500">
                        <span class="text-sm font-bold text-gray-800">Lainnya (Tuliskan secara manual di bawah)</span>
                    </label>

                    @if(in_array('Lainnya', $selected_injuries))
                        <div class="pt-2">
                            <input type="text" wire:model="custom_injury" placeholder="Tuliskan keluhan atau jenis cedera Anda di sini..." class="w-full text-sm rounded-md border-gray-300">
                        </div>
                    @endif

                    @error('selected_injuries') <span class="text-red-500 text-xs mt-1 block">Mohon pilih minimal satu opsi cedera di atas.</span> @enderror
                </div>
            </div>
        @endif

        <!-- FASE 6: ASPIRASI KUALITATIF & HARAPAN -->
        @if($currentStep === 6)
            <div class="p-8">
                <h2 class="text-2xl font-extrabold text-gray-900 mb-4 flex items-center gap-2">
                    <span class="text-orange-600"><i class="fa-solid fa-paper-plane"></i></span> Tahap Akhir: Pendapat & Aspirasi
                </h2>

                <div class="space-y-6">
                    <div class="bg-gray-50 p-5 rounded-2xl border border-gray-100">
                        <label class="block text-sm font-bold text-gray-800 mb-2">Menurut Anda, apakah nilai uang TPP Kondisi Kerja yang berlaku saat ini sudah adil dibanding tanggung jawab tugas dan risiko Anda harian?</label>
                        <select wire:model="is_tpp_fair" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-orange-500">
                            <option value="">-- Pilih Pendapat --</option>
                            <option value="no">Belum Adil (Sangat kecil dibanding bahaya / tanggung jawab harian)</option>
                            <option value="yes">Sudah Adil dan Sesuai</option>
                        </select>
                        @error('is_tpp_fair') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="bg-gray-50 p-5 rounded-2xl border border-gray-100">
                        <label class="block text-sm font-bold text-gray-800 mb-2">Tuliskan cerita nyata kejadian paling berbahaya / stres tertinggi yang pernah Anda hadapi selama bertugas di Bekasi: *</label>
                        <textarea wire:model="testimonial" rows="4" placeholder="Ceritakan situasi atau kejadian batin paling berat sebagai bahan pertimbangan Bapak Bupati..." class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-orange-500"></textarea>
                        @error('testimonial') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
        @endif

        <!-- FASE SUKSES / TERIMA KASIH -->
        @if($currentStep === 11)
            <div class="p-12 text-center flex flex-col items-center justify-center">
                <div class="h-20 w-20 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center text-4xl mb-6 shadow-inner animate-bounce">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <h2 class="text-3xl font-extrabold text-gray-950 mb-2">Terima Kasih, Rekan Juang!</h2>
                <p class="text-gray-500 text-sm max-w-md mx-auto leading-relaxed mb-6">
                    Jawaban dan kisah perjuangan nyata Anda telah berhasil kami rekam di dalam sistem database relasional. Data ini akan langsung dikalkulasi menggunakan rumus risiko Fine-Kinney untuk dijadikan basis ilmiah pengajuan kenaikan TPP Kondisi Kerja ke Bupati Bekasi.
                </p>
                <a href="/dashboard" class="bg-orange-600 hover:bg-orange-500 text-white px-6 py-2.5 rounded-xl text-xs font-bold transition">
                    Kembali ke Dashboard
                </a>
            </div>
        @endif

        <!-- FOOTER NAVIGASI TOMBOL (HANYA MUNCUL DI LANGKAH AKTIF) -->
        @if($currentStep < 11)
            <div class="bg-gray-50 px-8 py-5 flex justify-between border-t border-gray-100">
                @if($currentStep > 1)
                    <button type="button" wire:click="prevStep" class="px-5 py-2.5 rounded-xl text-xs font-bold text-gray-600 hover:bg-gray-150 transition">
                        Kembali
                    </button>
                @else
                    <div></div>
                @endif

                @if($currentStep < 6)
                    <button type="button" wire:click="nextStep" class="bg-orange-600 hover:bg-orange-500 text-white px-6 py-2.5 rounded-xl text-xs font-bold transition">
                        Lanjut
                    </button>
                @elseif($currentStep === 6)
                    <button type="button" wire:click="saveSurvey" class="bg-emerald-600 hover:bg-emerald-500 text-white px-6 py-2.5 rounded-xl text-xs font-bold transition">
                        Kirim Jawaban Survei
                    </button>
                @endif
            </div>
        @endif

    </div>
</div>