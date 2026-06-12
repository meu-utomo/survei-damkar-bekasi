<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
            <span class="text-orange-600"><i class="fa-solid fa-circle-nodes"></i></span>
            {{ __('Dashboard Responden') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Pengumuman & Instruksi Utama -->
            <div
                class="bg-white overflow-hidden shadow-sm sm:rounded-3xl border border-gray-100 p-8 grid grid-cols-1 md:grid-cols-12 gap-8 items-center">
                <div class="md:col-span-8 space-y-4">
                    <span
                        class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">
                        <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span> Sesi Pengisian Dibuka
                    </span>
                    <h3 class="text-2xl font-black text-gray-950">
                        Halo Rekan-Rekan Juang Damkar Kabupaten Bekasi,
                    </h3>
                    <p class="text-sm text-gray-600 leading-relaxed text-justify">
                        Kuesioner ini merupakan bagian dari Kajian Resmi untuk mengusulkan penyesuaian Tambahan
                        Penghasilan Pegawai (TPP) berbasis risiko tinggi bagi seluruh pasukan pemadam kebakaran di
                        Kabupaten Bekasi. Tujuannya adalah untuk memastikan bahwa setiap rekan yang bertugas di lapangan
                        mendapatkan kompensasi yang adil sesuai dengan tingkat risiko yang dihadapi.
                    </p>
                    <p class="text-sm text-gray-600 leading-relaxed text-justify">
                        Rekan-Rekan sekalian, Kajian ini bukan sekadar administrasi pengajuan kenaikan penghasilan
                        pegawai biasa. Di tengah tantangan ketat anggaran belanja pegawai daerah Kabupaten Bekasi yang
                        telah <strong>melampaui 40%</strong> (batas regulasi nasional 30%), satu-satunya langkah agar
                        usulan kompensasi risiko tinggi kita diloloskan adalah melalui <strong>analisis keadilan
                            berbasis risiko</strong> (risk-based compensation) yang objektif.
                    </p>
                    <p class="text-sm text-gray-600 leading-relaxed text-justify">
                        Oleh karena itu, kami memohon kejujuran Anda dalam mengisi setiap lembar skenario risiko ini.
                        Data yang Anda masukkan akan dipetakan untuk mendapatkan indeks koefisien "Kondisi Kerja" yang
                        adil dan aman dari audit pertanggungjawaban hukum daerah.
                    </p>
                    <p class="text-sm text-gray-600 leading-relaxed text-justify">
                        Terima kasih atas partisipasi aktif Anda dalam upaya kolektif ini. Bersama-sama, kita akan
                        memperjuangkan hak dan kesejahteraan seluruh pasukan pemadam kebakaran di Kabupaten Bekasi.
                    </p>
                    <div class="pt-2">
                        <a href="{{ route('survey') }}"
                            class="inline-flex items-center gap-2 bg-orange-600 hover:bg-orange-500 text-white font-bold px-6 py-3 rounded-2xl text-xs transition shadow-md shadow-orange-600/20">
                            <i class="fa-solid fa-file-signature"></i> Mulai Mengisi Kuesioner Sekarang
                        </a>
                    </div>
                </div>
                <!-- Box Statistik Slovin -->
                <div class="md:col-span-4 bg-gray-50 p-6 rounded-2xl border border-gray-100 space-y-4">
                    <div class="text-xs font-bold text-gray-400 uppercase tracking-wider">Target Keterwakilan Sampel
                        (Slovin)</div>
                    <div class="space-y-2">
                        <div class="flex justify-between items-center text-xs">
                            <span class="text-gray-600 font-medium">Pasukan Lapangan</span>
                            <span class="font-bold text-gray-900">65 Responden</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-1.5">
                            <div class="bg-orange-500 h-1.5 rounded-full" style="width: 30%"></div>
                        </div>
                        <div class="flex justify-between items-center text-xs">
                            <span class="text-gray-600 font-medium">Komandan Regu/Peleton</span>
                            <span class="font-bold text-gray-900">10 Responden</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-1.5">
                            <div class="bg-orange-500 h-1.5 rounded-full" style="width: 50%"></div>
                        </div>
                        <div class="flex justify-between items-center text-xs">
                            <span class="text-gray-600 font-medium">Staf Administrasi</span>
                            <span class="font-bold text-gray-900">5 Responden</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-1.5">
                            <div class="bg-orange-500 h-1.5 rounded-full" style="width: 30%"></div>
                        </div>
                    </div>
                    <p class="text-[11px] text-gray-400 leading-relaxed italic">
                        *Jumlah target berdasarkan Rumus Slovin dari total populasi 255 pegawai Disdamkar Bekasi dengan
                        toleransi kesalahan 10%.
                    </p>
                </div>
            </div>

            <!-- Kartu Petunjuk Pengisian Pintar -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Petunjuk 1 -->
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex gap-4">
                    <span class="text-orange-500 text-lg shrink-0 mt-1"><i class="fa-solid fa-user-shield"></i></span>
                    <div>
                        <h4 class="font-bold text-gray-950 text-sm">Privasi & Anonimitas Terjamin</h4>
                        <p class="text-xs text-gray-500 mt-1 leading-relaxed">Identitas Anda dijamin aman. Sistem hanya
                            menyimpan nama inisial demi keabsahan data penelitian ilmiah.</p>
                    </div>
                </div>
                <!-- Petunjuk 2 -->
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex gap-4">
                    <span class="text-orange-500 text-lg shrink-0 mt-1"><i
                            class="fa-solid fa-hourglass-half"></i></span>
                    <div>
                        <h4 class="font-bold text-gray-950 text-sm">Fleksibilitas Waktu Pengisian</h4>
                        <p class="text-xs text-gray-500 mt-1 leading-relaxed">Pengerjaan hanya membutuhkan waktu 10
                            menit. Anda dapat mengisinya saat selesai piket (lepas piket) agar tidak mengganggu siaga
                            aktif.</p>
                    </div>
                </div>
                <!-- Petunjuk 3 -->
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex gap-4">
                    <span class="text-orange-500 text-lg shrink-0 mt-1"><i class="fa-solid fa-circle-check"></i></span>
                    <div>
                        <h4 class="font-bold text-gray-950 text-sm">Satu Kali Pengiriman Saja</h4>
                        <p class="text-xs text-gray-500 mt-1 leading-relaxed">Setiap responden yang terdaftar hanya
                            diperkenankan mengirimkan jawaban kuesioner satu kali untuk keakuratan analisis statistik.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>