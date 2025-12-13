{{-- resources/views/laporan/create.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laporan Amalan Harian Anggota') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <h3 class="text-lg font-medium text-gray-900 mb-4">Input Data Laporan Amalan</h3>

                {{-- Form POST ke route store --}}
                <form method="POST" action="{{ route('laporan-amalan.store') }}">
                    @csrf

                    {{-- Field Tanggal --}}
                    <div class="mt-4">
                        <x-input-label for="tanggal" :value="__('Tanggal Laporan')" />
                        <x-text-input id="tanggal" class="block mt-1 w-full" type="date" name="tanggal" required />
                    </div>

                    {{-- Field Sholat Subuh Berjamaah --}}
                    <div class="mt-4">
                        <x-input-label for="sholat_subuh_berjamaah" :value="__('Sholat Subuh Berjamaah')" />
                        <select id="sholat_subuh_berjamaah" name="sholat_subuh_berjamaah" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>
                            <option value="1">Ya</option>
                            <option value="0">Tidak</option>
                        </select>
                    </div>

                    {{-- Field Tilawah --}}
                    <div class="mt-4">
                        <x-input-label for="tilawah" :value="__('Tilawah (Halaman)')" />
                        <x-text-input id="tilawah" class="block mt-1 w-full" type="number" name="tilawah" min="0" required />
                    </div>

                    {{-- Tombol Kirim --}}
                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button>
                            {{ __('Kirim Laporan') }}
                        </x-primary-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>