<?php

namespace App\Http\Controllers\dokter;

use App\Http\Controllers\Controller;
use App\Models\JadwalPeriksa;
use App\Models\JanjiPeriksa;
use App\Models\Obat;
use App\Models\Periksa;
use App\Models\DetailPeriksa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MemeriksaController extends Controller
{
    public function index()
    {
        $jadwalPeriksa = JadwalPeriksa::where('id_dokter', Auth::user()->id)
            ->where('status', true)
            ->first();

        $janjiPeriksas = JanjiPeriksa::where('id_jadwal_periksa', $jadwalPeriksa->id)->get();

        return view('dokter.memeriksa.index')->with([
            'janjiPeriksas' => $janjiPeriksas,
        ]);
    }

    public function periksa($id)
    {
        $janjiPeriksa = JanjiPeriksa::findOrFail($id);
        $obats = Obat::all();

        return view('dokter.memeriksa.periksa')->with([
            'janjiPeriksa' => $janjiPeriksa,
            'obats' => $obats
        ]);
    }

    public function store($id, Request $request)
    {
        $validatedData = $request->validate([
            'tgl_periksa' => 'required|date',
            'catatan' => 'nullable|string|max:255',
            'biaya_periksa' => 'required|numeric|min:0',
            'obats' => 'array',
            'obats.*' => 'exists:obats,id'
        ]);

        $janjiPeriksa = JanjiPeriksa::findOrFail($id);

        $tanggalPeriksa = Carbon::parse($validatedData['tgl_periksa']);

        $periksa = Periksa::create([
            'id_janji_periksa' => $janjiPeriksa->id,
            'tgl_periksa' => $tanggalPeriksa,
            'catatan' => $validatedData['catatan'],
            'biaya_periksa' => $validatedData['biaya_periksa']
        ]);

        foreach ($validatedData['obats'] as $obatId) {
            DetailPeriksa::create([
                'id_periksa' => $periksa->id,
                'id_obat' => $obatId
            ]);
        }

        return redirect()->route('dokter.memeriksa.index');
    }


    public function edit($id)
    {
        $janjiPeriksa = JanjiPeriksa::findOrFail($id);
        $obats = Obat::all();

        return view('dokter.memeriksa.edit')->with([
            'janjiPeriksa' => $janjiPeriksa,
            'obats' => $obats
        ]);
    }

    public function update($id, Request $request)
    {
        $validatedData = $request->validate([
            'tgl_periksa' => 'required|date',
            'catatan' => 'nullable|string|max:255',
            'biaya_periksa' => 'required|numeric|min:0',
            'obats' => 'array',
            'obats.*' => 'exists:obats,id'
        ]);

        $janjiPeriksa = JanjiPeriksa::findOrFail($id);

        $periksa = Periksa::where('id_janji_periksa', $janjiPeriksa->id)->first();

        $periksa->update([
            'tgl_periksa' => $validatedData['tgl_periksa'],
            'catatan' => $validatedData['catatan'],
            'biaya_periksa' => $validatedData['biaya_periksa']
        ]);

        DetailPeriksa::where('id_periksa', $periksa->id)->delete();

        foreach ($validatedData['obats'] as $obatId) {
            DetailPeriksa::create([
                'id_periksa' => $periksa->id,
                'id_obat' => $obatId
            ]);
        }

        return redirect()->route('dokter.memeriksa.index');
    }

}
