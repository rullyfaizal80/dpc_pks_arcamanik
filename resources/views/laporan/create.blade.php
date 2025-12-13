{{-- resources/views/laporan/create.blade.php (VERSI FINAL PERBAIKAN TAMPILAN) --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laporan Amalan Harian Anggota UPA') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <h3 class="text-lg font-medium text-gray-900 mb-4">Input Data Laporan Amalan Sepekan (Senin-Ahad)</h3>
                
                {{-- Form action sudah benar: route('laporan-amalan.store') --}}
                <form method="POST" action="{{ route('laporan-amalan.store') }}">
                    @csrf
                    
                    {{-- DATA IDENTITAS & PERIODE --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        
                        {{-- Tanggal UPA (tanggal_upa) --}}
                        <div class="mt-4">
                            <x-input-label for="tanggal_upa" :value="__('Tanggal Pelaksanaan UPA *')" />
                            <x-text-input id="tanggal_upa" class="block mt-1 w-full" type="date" name="tanggal_upa" required value="{{ old('tanggal_upa') }}" />
                            <x-input-error :messages="$errors->get('tanggal_upa')" class="mt-2" />
                        </div>
                        
                        {{-- Jenjang Keanggotaan (jenjang) --}}
                        <div class="mt-4">
                            <x-input-label for="jenjang" :value="__('Jenjang Keanggotaan *')" />
                            <select id="jenjang" name="jenjang" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>
                                <option value="">Pilih Jenjang</option>
                                <option value="Muda" {{ old('jenjang') == 'Muda' ? 'selected' : '' }}>Muda</option>
                                <option value="Pratama" {{ old('jenjang') == 'Pratama' ? 'selected' : '' }}>Pratama</option>
                            </select>
                            <x-input-error :messages="$errors->get('jenjang')" class="mt-2" />
                        </div>

                        {{-- Periode Awal & Akhir --}}
                        <div class="mt-4 col-span-1">
                            <x-input-label :value="__('Periode Laporan (Senin-Ahad)')" />
                            <div class="flex space-x-2">
                                <x-text-input id="periode_awal" type="date" name="periode_awal" required value="{{ old('periode_awal') }}" placeholder="Senin" />
                                <x-text-input id="periode_akhir" type="date" name="periode_akhir" required value="{{ old('periode_akhir') }}" placeholder="Ahad" />
                            </div>
                            <x-input-error :messages="$errors->get('periode_awal') || $errors->get('periode_akhir')" class="mt-2" />
                        </div>
                    </div>

                    <hr class="my-8">
                    <h4 class="text-md font-semibold text-gray-700 mb-4">9 Poin Amalan Harian</h4>

                    {{-- 1. Sholat Berjamaah di Mesjid (amal_1_sholat_berjamaah) - Input Number --}}
                    <div class="mt-4 p-4 border rounded-md">
                        <x-input-label for="amal_1_sholat_berjamaah" :value="__('1. Sholat Berjamaah di Mesjid pekan ini (untuk Laki-laki) * (Max 35x)')" />
                        <x-text-input id="amal_1_sholat_berjamaah" class="block mt-2 w-1/3" type="number" name="amal_1_sholat_berjamaah" min="0" max="35" required value="{{ old('amal_1_sholat_berjamaah') }}" />
                        <x-input-error :messages="$errors->get('amal_1_sholat_berjamaah')" class="mt-2" />
                    </div>

                    {{-- 2. Sholat Malam Pekan ini (amal_2_sholat_malam) - Radio Button --}}
                    <div class="mt-4 p-4 border rounded-md">
                        <x-input-label :value="__('2. Sholat Malam Pekan ini * (0-7x)')" />
                        <div class="mt-2 grid grid-cols-8 gap-2">
                            @for ($i = 0; $i <= 7; $i++)
                                <label class="inline-flex items-center">
                                    <input type="radio" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="amal_2_sholat_malam" value="{{ $i }}" required {{ old('amal_2_sholat_malam') == $i ? 'checked' : '' }}>
                                    <span class="ms-2 text-sm text-gray-600">{{ $i }}</span>
                                </label>
                            @endfor
                        </div>
                        <x-input-error :messages="$errors->get('amal_2_sholat_malam')" class="mt-2" />
                    </div>

                    {{-- 3. Membaca AL-Quran (amal_3_baca_quran) - Radio Button --}}
                    <div class="mt-4 p-4 border rounded-md">
                        <x-input-label :value="__('3. Membaca AL-Quran (Juz) pekan ini *')" />
                        <div class="mt-2 flex flex-wrap gap-4">
                            <label class="inline-flex items-center">
                                <input type="radio" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="amal_3_baca_quran" value="0.5" required {{ old('amal_3_baca_quran') == '0.5' ? 'checked' : '' }}>
                                <span class="ms-2 text-sm text-gray-600">kurang dari 1 juz</span>
                            </label>
                            @for ($i = 1; $i <= 7; $i++)
                                <label class="inline-flex items-center">
                                    <input type="radio" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="amal_3_baca_quran" value="{{ $i }}" required {{ old('amal_3_baca_quran') == $i ? 'checked' : '' }}>
                                    <span class="ms-2 text-sm text-gray-600">{{ $i }} juz</span>
                                </label>
                            @endfor
                        </div>
                        <x-input-error :messages="$errors->get('amal_3_baca_quran')" class="mt-2" />
                    </div>

                    {{-- 4. Shaum Sunnah Pekan ini (amal_4_shaum_sunnah) - Radio Button --}}
                    <div class="mt-4 p-4 border rounded-md">
                        <x-input-label :value="__('4. Shaum Sunnah Pekan ini *')" />
                        <div class="mt-2 flex flex-wrap space-x-4">
                            @for ($i = 0; $i <= 3; $i++)
                                <label class="inline-flex items-center">
                                    <input type="radio" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="amal_4_shaum_sunnah" value="{{ $i }}" required {{ old('amal_4_shaum_sunnah') == $i ? 'checked' : '' }}>
                                    <span class="ms-2 text-sm text-gray-600">{{ $i }}</span>
                                </label>
                            @endfor
                        </div>
                        <x-input-error :messages="$errors->get('amal_4_shaum_sunnah')" class="mt-2" />
                    </div>

                    {{-- 5. Al-Ma'tsurat Pekan ini (amal_5_almatsurat) - Input Number --}}
                    <div class="mt-4 p-4 border rounded-md">
                        <x-input-label for="amal_5_almatsurat" :value="__('5. Al-Ma\'tsurat Pekan ini * (standar 2x sehari / 14x sepekan)')" />
                        <x-text-input id="amal_5_almatsurat" class="block mt-2 w-1/3" type="number" name="amal_5_almatsurat" min="0" max="14" required value="{{ old('amal_5_almatsurat') }}" />
                        <x-input-error :messages="$errors->get('amal_5_almatsurat')" class="mt-2" />
                    </div>

                    {{-- 6. Sholat Dhuha Pekan ini (amal_6_sholat_dhuha) - Radio Button --}}
                    <div class="mt-4 p-4 border rounded-md">
                        <x-input-label :value="__('6. Sholat Dhuha Pekan ini * (0-7x)')" />
                        <div class="mt-2 grid grid-cols-8 gap-2">
                            @for ($i = 0; $i <= 7; $i++)
                                <label class="inline-flex items-center">
                                    <input type="radio" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="amal_6_sholat_dhuha" value="{{ $i }}" required {{ old('amal_6_sholat_dhuha') == $i ? 'checked' : '' }}>
                                    <span class="ms-2 text-sm text-gray-600">{{ $i }}</span>
                                </label>
                            @endfor
                        </div>
                        <x-input-error :messages="$errors->get('amal_6_sholat_dhuha')" class="mt-2" />
                    </div>

                    {{-- 7. Olahraga Pekan ini (amal_7_olahraga) - Radio Button --}}
                    <div class="mt-4 p-4 border rounded-md">
                        <x-input-label :value="__('7. Olahraga Pekan ini * (standar 7x per pekan)')" />
                        <div class="mt-2 grid grid-cols-8 gap-2">
                            @for ($i = 0; $i <= 7; $i++)
                                <label class="inline-flex items-center">
                                    <input type="radio" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="amal_7_olahraga" value="{{ $i }}" required {{ old('amal_7_olahraga') == $i ? 'checked' : '' }}>
                                    <span class="ms-2 text-sm text-gray-600">{{ $i }}</span>
                                </label>
                            @endfor
                        </div>
                        <x-input-error :messages="$errors->get('amal_7_olahraga')" class="mt-2" />
                    </div>

                    {{-- 8. Membaca Istighfar Pekan ini (amal_8_istighfar) - Radio Button --}}
                    <div class="mt-4 p-4 border rounded-md">
                        <x-input-label :value="__('8. Membaca Istighfar Pekan ini * (standar 7x per pekan)')" />
                        <div class="mt-2 grid grid-cols-8 gap-2">
                            @for ($i = 0; $i <= 7; $i++)
                                <label class="inline-flex items-center">
                                    <input type="radio" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="amal_8_istighfar" value="{{ $i }}" required {{ old('amal_8_istighfar') == $i ? 'checked' : '' }}>
                                    <span class="ms-2 text-sm text-gray-600">{{ $i }}</span>
                                </label>
                            @endfor
                        </div>
                        <x-input-error :messages="$errors->get('amal_8_istighfar')" class="mt-2" />
                    </div>

                    {{-- 9. Membaca Shalawat Pekan ini (amal_9_shalawat) - Radio Button --}}
                    <div class="mt-4 p-4 border rounded-md">
                        <x-input-label :value="__('9. Membaca Shalawat Pekan ini * (standar 7x per pekan)')" />
                        <div class="mt-2 grid grid-cols-8 gap-2">
                            @for ($i = 0; $i <= 7; $i++)
                                <label class="inline-flex items-center">
                                    <input type="radio" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="amal_9_shalawat" value="{{ $i }}" required {{ old('amal_9_shalawat') == $i ? 'checked' : '' }}>
                                    <span class="ms-2 text-sm text-gray-600">{{ $i }}</span>
                                </label>
                            @endfor
                        </div>
                        <x-input-error :messages="$errors->get('amal_9_shalawat')" class="mt-2" />
                    </div>


                    {{-- Tombol Kirim --}}
                    <div class="flex items-center justify-end mt-6">
                        <x-primary-button>
                            {{ __('Kirim Laporan') }}
                        </x-primary-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>