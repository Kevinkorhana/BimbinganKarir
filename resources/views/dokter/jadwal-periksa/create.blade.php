<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            {{ __('Tambah Jadwal Periksa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Form Jadwal Periksa</h3>

                @if (session('error'))
                    <div class="mb-4 text-red-600 text-sm">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('dokter.jadwal-periksa.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label for="hari" class="block text-sm font-medium text-gray-700">Hari</label>
                        <select name="hari" id="hari" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="">-- Pilih Hari --</option>
                            @foreach (['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'] as $day)
                                <option value="{{ $day }}">{{ $day }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="jam_mulai" class="block text-sm font-medium text-gray-700">Jam Mulai</label>
                            <input type="time" name="jam_mulai" id="jam_mulai" required
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>

                        <div>
                            <label for="jam_selesai" class="block text-sm font-medium text-gray-700">Jam Selesai</label>
                            <input type="time" name="jam_selesai" id="jam_selesai" required
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                    </div>

                    <div class="flex justify-end gap-3">
                        <a href="{{ route('dokter.jadwal-periksa.index') }}"
                           class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 text-sm">
                            Batal
                        </a>
                        <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
