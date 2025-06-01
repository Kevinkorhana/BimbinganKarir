<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            {{ __('Jadwal Periksa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white shadow-md rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Daftar Jadwal Periksa</h3>
                    <a href="{{ route('dokter.jadwal-periksa.create') }}"
                       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm">
                        Tambah Jadwal
                    </a>
                </div>

                @if (session('success'))
                    <div class="mb-4 text-green-600 text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                        <tr>
                            <th class="px-6 py-3">No</th>
                            <th class="px-6 py-3">Hari</th>
                            <th class="px-6 py-3">Jam Mulai</th>
                            <th class="px-6 py-3">Jam Selesai</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($jadwalPeriksas as $index => $jadwal)
                            <tr>
                                <td class="px-6 py-4">{{ $index + 1 }}</td>
                                <td class="px-6 py-4">{{ $jadwal->hari }}</td>
                                <td class="px-6 py-4">{{ $jadwal->jam_mulai }}</td>
                                <td class="px-6 py-4">{{ $jadwal->jam_selesai }}</td>
                                <td class="px-6 py-4">
                                    @if ($jadwal->status == 1)
                                        <span class="bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded">Aktif</span>
                                    @else
                                        <span class="bg-red-100 text-red-800 text-xs font-semibold px-2 py-1 rounded">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <form action="{{ route('dokter.jadwal-periksa.toggle-status', $jadwal->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            class="px-3 py-1 rounded text-xs font-medium text-white
                                                {{ $jadwal->status == 1 ? 'bg-red-600 hover:bg-red-700' : 'bg-green-600 hover:bg-green-700' }}">
                                            {{ $jadwal->status == 1 ? 'Nonaktifkan' : 'Aktifkan' }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">Belum ada jadwal periksa.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
