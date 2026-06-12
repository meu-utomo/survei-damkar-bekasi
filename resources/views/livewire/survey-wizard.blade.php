<div class="max-w-3xl mx-auto my-12 px-4">
    <!-- Indikator Kemajuan (Progress Bar) -->
    @if($currentStep < 11)
        <div class="mb-8">
            <div class="flex justify-between text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">
                <span>Kemajuan Pengisian</span>
                <span>Langkah {{ $currentStep }} dari {{ $totalSteps - 1 }}</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2">
                <div class="bg-orange-600 h-2 rounded-full transition-all duration-300"
                    style="width: {{ (($currentStep - 1) / ($totalSteps - 1)) * 100 }}%"></div>
            </div>
        </div>
    @endif

    <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">

        <!-- LANGKAH 1: IDENTITAS DIRI -->
        @if($currentStep === 1)
            <div class="p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Langkah 1: Identitas Diri Pasukan</h2>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Inisial (Untuk privasi)</label>
                        <input type="text" wire:model="name_initial"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status Kepegawaian *</label>
                            <select wire:model="employee_status"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option value="">-- Pilih --</option>
                                <option value="pns">PNS</option>
                                <option value="pppk">PPPK</option>
                            </select>
                            @error('employee_status') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Golongan / Kelas *</label>
                            <input type="text" wire:model="class_rank" placeholder="Contoh: III/b atau Kelas IX"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            @error('class_rank') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Kelompok Usia *</label>
                            <select wire:model="age_group" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option value="">-- Pilih --</option>
                                <option value="< 25">Di bawah 25 Tahun</option>
                                <option value="25-35">25 - 35 Tahun</option>
                                <option value="36-45">36 - 45 Tahun</option>
                                <option value="> 45">Di atas 45 Tahun</option>
                            </select>
                            @error('age_group') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Masa Kerja *</label>
                            <select wire:model="years_of_service"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option value="">-- Pilih --</option>
                                <option value="< 2">Kurang dari 2 Tahun</option>
                                <option value="2-5">2 - 5 Tahun</option>
                                <option value="6-10">6 - 10 Tahun</option>
                                <option value="> 10">Lebih dari 10 Tahun</option>
                            </select>
                            @error('years_of_service') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Pos Wilayah Piket *</label>
                        <input type="text" wire:model="work_unit" placeholder="Contoh: Mako Cikarang, Pos Tambun"
                            class="mt-1 block w-full rounded-md border-gray-300">
                        @error('work_unit') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tugas Harian Utama *</label>
                        <select wire:model="role_type" class="mt-1 block w-full rounded-md border-gray-300">
                            <option value="">-- Pilih --</option>
                            <option value="pemadam">Pemadam Kebakaran</option>
                            <option value="rescue">Penyelamatan (Rescue)</option>
                            <option value="keduanya">Keduanya (Pemadam & Rescue)</option>
                        </select>
                        @error('role_type') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
        @endif

        <!-- LANGKAH 2 SAMPAI 8: DINAMIS SCENARIOS -->
        @if($currentStep >= 2 && $currentStep <= 8)
            @php $sId = $currentStep - 1; @endphp
            <div class="p-8">
                <span class="text-orange-600 text-xs font-bold uppercase tracking-wider">Skenario Bahaya #{{ $sId }}</span>
                <h2 class="text-2xl font-bold text-gray-900 mt-1 mb-4">{{ $scenarios[$sId]['title'] }}</h2>

                <div class="space-y-6">
                    <!-- Penilaian E -->
                    <div class="bg-gray-50 p-5 rounded-2xl">
                        <label class="block text-sm font-bold text-gray-800 mb-3">1. Seberapa sering Anda menemui situasi
                            ini di lapangan? (E - Paparan) *</label>
                        <div class="grid grid-cols-1 gap-2">
                            <label
                                class="flex items-center gap-3 p-3 bg-white rounded-xl border border-gray-100 hover:border-orange-500 cursor-pointer">
                                <input type="radio" wire:model="scenarios.{{ $sId }}.E" value="1">
                                <span class="text-sm text-gray-700">Sangat Jarang (1-2 kali setahun)</span>
                            </label>
                            <label
                                class="flex items-center gap-3 p-3 bg-white rounded-xl border border-gray-100 hover:border-orange-500 cursor-pointer">
                                <input type="radio" wire:model="scenarios.{{ $sId }}.E" value="3">
                                <span class="text-sm text-gray-700">Kadang-kadang (1 kali sebulan)</span>
                            </label>
                            <label
                                class="flex items-center gap-3 p-3 bg-white rounded-xl border border-gray-100 hover:border-orange-500 cursor-pointer">
                                <input type="radio" wire:model="scenarios.{{ $sId }}.E" value="6">
                                <span class="text-sm text-gray-700">Sering (Beberapa kali sebulan)</span>
                            </label>
                            <label
                                class="flex items-center gap-3 p-3 bg-white rounded-xl border border-gray-100 hover:border-orange-500 cursor-pointer">
                                <input type="radio" wire:model="scenarios.{{ $sId }}.E" value="10">
                                <span class="text-sm text-gray-700">Sangat Sering (Setiap hari / setiap piket)</span>
                            </label>
                        </div>
                        @error("scenarios.{$sId}.E") <span class="text-red-500 text-xs mt-1 block">Wajib memilih tingkat
                        paparan.</span> @enderror
                    </div>

                    <!-- Penilaian P -->
                    <div class="bg-gray-50 p-5 rounded-2xl">
                        <label class="block text-sm font-bold text-gray-800 mb-3">2. Bagaimana tingkat kemungkinan terjadi
                            cedera fisik pada diri Anda? (P - Probabilitas) *</label>
                        <div class="grid grid-cols-1 gap-2">
                            <label
                                class="flex items-center gap-3 p-3 bg-white rounded-xl border border-gray-100 cursor-pointer">
                                <input type="radio" wire:model="scenarios.{{ $sId }}.P" value="1">
                                <span class="text-sm text-gray-700">Sangat Kecil (Alat pelindung memadai dan aman)</span>
                            </label>
                            <label
                                class="flex items-center gap-3 p-3 bg-white rounded-xl border border-gray-100 cursor-pointer">
                                <input type="radio" wire:model="scenarios.{{ $sId }}.P" value="6">
                                <span class="text-sm text-gray-700">Mungkin Terjadi (Peluang celaka 50:50 karena
                                    keterbatasan alat)</span>
                            </label>
                            <label
                                class="flex items-center gap-3 p-3 bg-white rounded-xl border border-gray-100 cursor-pointer">
                                <input type="radio" wire:model="scenarios.{{ $sId }}.P" value="10">
                                <span class="text-sm text-gray-700">Sangat Mudah Terjadi (Sangat rawan celaka)</span>
                            </label>
                        </div>
                        @error("scenarios.{$sId}.P") <span class="text-red-500 text-xs mt-1 block">Wajib memilih tingkat
                        kemungkinan.</span> @enderror
                    </div>

                    <!-- Penilaian C -->
                    <div class="bg-gray-50 p-5 rounded-2xl">
                        <label class="block text-sm font-bold text-gray-800 mb-3">3. Apa tingkat akibat cedera terburuk yang
                            paling mungkin Anda alami? (C - Dampak) *</label>
                        <div class="grid grid-cols-1 gap-2">
                            <label
                                class="flex items-center gap-3 p-3 bg-white rounded-xl border border-gray-100 cursor-pointer">
                                <input type="radio" wire:model="scenarios.{{ $sId }}.C" value="3">
                                <span class="text-sm text-gray-700">Sedang (Perlu perawatan IGD, libur kerja beberapa
                                    hari)</span>
                            </label>
                            <label
                                class="flex items-center gap-3 p-3 bg-white rounded-xl border border-gray-100 cursor-pointer">
                                <input type="radio" wire:model="scenarios.{{ $sId }}.C" value="7">
                                <span class="text-sm text-gray-700">Serius (Luka parah/bakar derajat tinggi, butuh rawat
                                    inap lama)</span>
                            </label>
                            <label
                                class="flex items-center gap-3 p-3 bg-white rounded-xl border border-gray-100 cursor-pointer">
                                <input type="radio" wire:model="scenarios.{{ $sId }}.C" value="100">
                                <span class="text-sm text-gray-700">Fatal (Menyebabkan hilangnya nyawa / kematian di
                                    tempat)</span>
                            </label>
                        </div>
                        @error("scenarios.{$sId}.C") <span class="text-red-500 text-xs mt-1 block">Wajib memilih tingkat
                        dampak terburuk.</span> @enderror
                    </div>
                </div>
            </div>
        @endif

        <!-- LANGKAH 9: RIWAYAT CEDERA MEDIS -->
        @if($currentStep === 9)
            <div class="p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Langkah 9: Riwayat Cedera Nyata</h2>
                <p class="text-sm text-gray-500 mb-6">Pernahkah Anda mengalami kecelakaan kerja berikut dalam 3 tahun
                    terakhir? (Boleh pilih lebih dari satu)</p>

                <div class="space-y-3 bg-gray-50 p-5 rounded-2xl">
                    <label class="flex items-center gap-3">
                        <input type="checkbox" wire:model="selected_injuries" value="Dehidrasi parah / heat exhaustion"
                            class="rounded text-orange-600 focus:ring-orange-500">
                        <span class="text-sm text-gray-700">Dehidrasi parah / lemas luar biasa akibat panas api</span>
                    </label>
                    <label class="flex items-center gap-3">
                        <input type="checkbox" wire:model="selected_injuries" value="Luka bakar"
                            class="rounded text-orange-600 focus:ring-orange-500">
                        <span class="text-sm text-gray-700">Luka bakar di kulit</span>
                    </label>
                    <label class="flex items-center gap-3">
                        <input type="checkbox" wire:model="selected_injuries" value="Sesak napas akut"
                            class="rounded text-orange-600 focus:ring-orange-500">
                        <span class="text-sm text-gray-700">Sesak napas akut akibat asap tebal zat kimia</span>
                    </label>
                    <label class="flex items-center gap-3">
                        <input type="checkbox" wire:model="selected_injuries" value="Gigitan hewan berbisa"
                            class="rounded text-orange-600 focus:ring-orange-500">
                        <span class="text-sm text-gray-700">Terkena gigitan ular kobra / sengatan tawon vespa</span>
                    </label>
                    <label class="flex items-center gap-3">
                        <input type="checkbox" wire:model="selected_injuries" value="Tidak pernah terluka"
                            class="rounded text-orange-600 focus:ring-orange-500">
                        <span class="text-sm font-bold text-emerald-700">Saya belum pernah mengalami cedera apa pun</span>
                    </label>
                    @error('selected_injuries') <span class="text-red-500 text-xs mt-1 block">Mohon centang salah satu
                    (pilih opsi tidak pernah jika memang belum pernah terluka).</span> @enderror

                    <div class="pt-4 border-t border-gray-200">
                        <label class="block text-sm font-medium text-gray-700">Tuliskan kecelakaan/cedera lain yang pernah
                            dialami (jika ada):</label>
                        <input type="text" wire:model="custom_injury" class="mt-1 block w-full rounded-md border-gray-300">
                    </div>
                </div>
            </div>
        @endif

        <!-- LANGKAH 10: KUALITATIF & HARAPAN (SUBMIT) -->
        @if($currentStep === 10)
            <div class="p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Langkah 10: Pendapat & Aspirasi</h2>

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-800 mb-2">Menurut Anda, apakah uang TPP Kondisi
                            Kerja yang berlaku saat ini sudah adil dibanding taruhan nyawa Anda harian? *</label>
                        <select wire:model="is_tpp_fair" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="">-- Pilih Pendapat --</option>
                            <option value="no">Belum Adil (Sangat kecil dibanding bahaya nyawa)</option>
                            <option value="yes">Sudah Adil dan Sesuai</option>
                        </select>
                        @error('is_tpp_fair') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-800 mb-2">Tuliskan cerita nyata kejadian paling
                            berbahaya yang pernah Anda hadapi selama bertugas di Bekasi: *</label>
                        <textarea wire:model="testimonial" rows="4"
                            placeholder="Ceritakan situasi genting Anda sebagai bahan pertimbangan Bapak Bupati..."
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                        @error('testimonial') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
        @endif

        <!-- LANGKAH 11: HALAMAN BERHASIL / SUKSES -->
        @if($currentStep === 11)
            <div class="p-12 text-center flex flex-col items-center justify-center">
                <div
                    class="h-20 w-20 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center text-4xl mb-6 shadow-inner animate-bounce">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <h2 class="text-3xl font-extrabold text-gray-950 mb-2">Terima Kasih, Rekan Juang!</h2>
                <p class="text-gray-500 text-sm max-w-md mx-auto leading-relaxed mb-6">
                    Jawaban dan kisah perjuangan nyata Anda telah berhasil kami rekam di dalam sistem. Data ini akan
                    langsung dikalkulasi menggunakan rumus risiko Fine-Kinney untuk dijadikan basis ilmiah pengajuan
                    kenaikan TPP Kondisi Kerja ke Bupati Bekasi.
                </p>
                <a href="/dashboard"
                    class="bg-orange-600 hover:bg-orange-500 text-white px-6 py-2.5 rounded-xl text-xs font-bold transition">
                    Kembali ke Dashboard
                </a>
            </div>
        @endif

        <!-- FOOTER NAVIGASI TOMBOL (HANYA MUNCUL DI LANGKAH 1 SAMPAI 10) -->
        @if($currentStep < 11)
            <div class="bg-gray-50 px-8 py-5 flex justify-between border-t border-gray-100">
                <!-- Tombol Kembali -->
                @if($currentStep > 1)
                    <button type="button" wire:click="prevStep"
                        class="px-5 py-2.5 rounded-xl text-xs font-bold text-gray-600 hover:bg-gray-150 transition">
                        Kembali
                    </button>
                @else
                    <div></div> <!-- Menjaga letak layout space-between tetap di kanan -->
                @endif

                <!-- Tombol Lanjut / Kirim -->
                @if($currentStep < 10)
                    <button type="button" wire:click="nextStep"
                        class="bg-orange-600 hover:bg-orange-500 text-white px-6 py-2.5 rounded-xl text-xs font-bold transition">
                        Lanjut
                    </button>
                @elseif($currentStep === 10)
                    <button type="button" wire:click="saveSurvey"
                        class="bg-emerald-600 hover:bg-emerald-500 text-white px-6 py-2.5 rounded-xl text-xs font-bold transition">
                        Kirim Jawaban Survei
                    </button>
                @endif
            </div>
        @endif

    </div>
</div>