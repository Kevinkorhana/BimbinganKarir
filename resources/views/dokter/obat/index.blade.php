<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Obat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">
                        {{ __('Daftar Obat') }}
                    </h2>

                    <div class="flex flex-col items-end space-y-1 text-right">
                        <a href="{{ route('dokter.obat.create') }}"
                           class="inline-block px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded hover:bg-blue-700 transition">
                            Tambah Obat
                        </a>

                        @if (session('status') === 'obat-created')
                            <p x-data="{ show: true }" x-show="show" x-transition
                               x-init="setTimeout(() => show = false, 2000)"
                               class="text-sm text-green-600">Obat berhasil ditambahkan.</p>
                        @endif
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 border border-gray-200 rounded-lg shadow-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">No</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Nama Obat</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Kemasan</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Harga</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse ($obats as $obat)
                                <tr>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-900">{{ $obat->nama_obat }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-900">{{ $obat->kemasan }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-900">
                                        {{ 'Rp' . number_format($obat->harga, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-900 flex items-center space-x-2">
                                        {{-- Edit Button --}}
                                        <a href="{{ route('dokter.obat.edit', $obat->id) }}"
                                           class="inline-block px-3 py-1 text-xs font-medium text-white bg-yellow-500 rounded hover:bg-yellow-600 transition">
                                            Edit
                                        </a>

                                        {{-- Delete Button --}}
                                        <form action="{{ route('dokter.obat.destroy', $obat->id) }}" method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus obat ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="inline-block px-3 py-1 text-xs font-medium text-white bg-red-600 rounded hover:bg-red-700 transition">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-6 text-center text-sm text-gray-500">
                                        Tidak ada data obat tersedia.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
