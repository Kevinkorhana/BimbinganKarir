@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Jadwal Periksa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8">
            <div class="p-4 bg-white shadow-sm sm:p-8 sm:rounded-lg" <section>
                <header class="flex items-center justify-between">
                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('Daftar Jadwal Periksa') }}
                    </h2>

                    <div class="flex-col items-center justify-center text-center">
                        <a href="{{route('dokter.jadwal-periksa.create')}}" class="btn btn-primary">Tambah Jadwal Periksa</a>

                        @if (session('status') === 'obat-created')
                            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                                class="text-sm text-gray-600">{{ __('Created.') }}</p>
                        @endif
                        @if (session('status') === 'obat-exists')
                            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                                class="text-sm text-gray-600">{{ __('Exists.') }}</p>
                        @endif
                    </div>
                </header>

                <table class="table mt-6 overflow-hidden rounded table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Hari</th>
                            <th scope="col">Mulai</th>
                            <th scope="col">Selesai</th>
                            <th scope="col">Status</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($jadwalPeriksas as $jadwalPeriksa)
                            <tr>
                                <th scope="row" class="align-middle text-start">{{ $loop->iteration }}</th>
                                <td class="align-middle text-start">{{ $jadwalPeriksa->hari }}</td>
                                <td class="align-middle text-start">{{ \Carbon\Carbon::parse($jadwalPeriksa->jam_mulai)->format('H.i') }}</td>
                                <td class="align-middle text-start">{{ \Carbon\Carbon::parse($jadwalPeriksa->jam_selesai)->format('H.i') }}</td>
                                <td class="align-middle text-start">
                                    @if ($jadwalPeriksa->status)
                                        <span class="badge badge-pi11 badge-success">Akif</span>
                                    @else
                                        <span class="badge badge-pi11 badge-danger">Nonakif</span>
                                    @endif
                                </td>
                                <td class="align-middle text-start">
                                    <form action="{{route('dokter.jadwal-periksa.update', $jadwalPeriksa->id)}}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        @if ($jadwalPeriksa->status)
                                            <button type="submit" class="btn btn-danger btn-sm">Nonaktifkan</button>
                                        @else
                                            <button type="submit" class="btn btn-success btn-sm">Aktifkan</button>
                                        @endif
                                    </form>
                                    <form action="{{ route('dokter.jadwal-periksa.destroy', $jadwalPeriksa->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm mt-1">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
</x-app-layout>
