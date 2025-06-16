<?php

namespace App\Http\Controllers\dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JadwalPeriksa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class JadwalPeriksaController extends Controller
{
    public function index()
    {
        $jadwalPeriksas = JadwalPeriksa::with('dokter')->where('id_dokter', Auth::user()->id)->get();

        return view('dokter.jadwal-periksa.index')->with([
            'jadwalPeriksas' => $jadwalPeriksas
        ]);
    }

    public function create()
    {
        return view('dokter.jadwal-periksa.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
        ]);

        // Cek bentrok
        $bentrok = JadwalPeriksa::where('id_dokter', Auth::user()->id)
            ->where('hari', $validatedData['hari'])
            ->where(function ($query) use ($validatedData) {
                $query->whereBetween('jam_mulai', [$validatedData['jam_mulai'], $validatedData['jam_selesai']])
                    ->orWhereBetween('jam_selesai', [$validatedData['jam_mulai'], $validatedData['jam_selesai']])
                    ->orWhere(function ($query2) use ($validatedData) {
                        $query2->where('jam_mulai', '<=', $validatedData['jam_mulai'])
                                ->where('jam_selesai', '>=', $validatedData['jam_selesai']);
                    });
            })
            ->exists();

        if ($bentrok) {
            return redirect()->back()->withInput()->with('error', 'Jadwal bentrok dengan jadwal lain.');
        }

        JadwalPeriksa::create([
            'id_dokter' => Auth::user()->id,
            'hari' => $validatedData['hari'],
            'jam_mulai' => $validatedData['jam_mulai'],
            'jam_selesai' => $validatedData['jam_selesai'],
            'status' => 0
        ]);

        return redirect()->route('dokter.jadwal-periksa.index')->with('success', 'Jadwal periksa berhasil ditambahkan.');
    }



    public function update($id)
    {
        $jadwalPeriksa = JadwalPeriksa::findOrFail($id);

        if (!$jadwalPeriksa->status) {
            // Nonaktifkan semua jadwal milik dokter
            JadwalPeriksa::where('id_dokter', Auth::user()->id)->update(['status' => false]);

            // Aktifkan jadwal yang dipilih
            $jadwalPeriksa->status = true;
            $jadwalPeriksa->save();

            return redirect()->route('dokter.jadwal-periksa.index')
                            ->with('success', 'Jadwal berhasil diaktifkan.');
        }

        // Jika sudah aktif, nonaktifkan
        $jadwalPeriksa->status = false;
        $jadwalPeriksa->save();

        return redirect()->route('dokter.jadwal-periksa.index')
                        ->with('success', 'Jadwal berhasil dinonaktifkan.');
    }

    public function destroy($id)
    {
        $jadwalPeriksa = JadwalPeriksa::findOrFail($id);

        // Hanya dokter yang bersangkutan yang boleh menghapus
        if ($jadwalPeriksa->id_dokter != Auth::user()->id) {
            return redirect()->route('dokter.jadwal-periksa.index')
                            ->with('error', 'Anda tidak memiliki izin untuk menghapus jadwal ini.');
        }

        $jadwalPeriksa->delete();

        return redirect()->route('dokter.jadwal-periksa.index')
                        ->with('success', 'Jadwal berhasil dihapus.');
    }

}
