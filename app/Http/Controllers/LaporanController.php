<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LaporanController extends Controller
{
    public function index()
    {
        $laporans = Laporan::with('mahasiswa')->latest()->paginate(10);
        return view('laporan.index', compact('laporans'));
    }

    public function create()
    {
        // Sementara pilih mahasiswa dari dropdown (sebelum Auth)
        $mahasiswas = Mahasiswa::orderBy('nama')->get();
        return view('laporan.create', compact('mahasiswas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => ['required','string','max:150'],
            'deskripsi' => ['required','string','max:2000'],
+            'mahasiswa_id' => ['required','exists:mahasiswas,id'],
        ]);


        $nomorLaporan = $this->generateNomorLaporan();

        $laporan = \App\Models\Laporan::create([
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'],
            'nomor_laporan' => $nomorLaporan,
            'status' => 'baru',
-            'mahasiswa_id' => auth()->id(), // otomatis ambil user login
+            'mahasiswa_id' => $validated['mahasiswa_id'],
        ]);

        return redirect()->route('laporan.show', $laporan)
            ->with('success','Laporan berhasil dibuat dengan nomor tiket: '.$nomorLaporan);
    }

    private function generateNomorLaporan(): string
    {
        // Format: LAP-YYYYMMDD-HHMMSS-AB12
        return 'LAP-'.now()->format('Ymd-His').'-'.Str::upper(Str::random(4));
    }

    public function show(Laporan $laporan)
    {
        $laporan->load('mahasiswa');
        return view('laporan.show', compact('laporan'));
    }

    public function edit(Laporan $laporan)
    {
        $mahasiswas = Mahasiswa::orderBy('nama')->get();
        return view('laporan.edit', compact('laporan','mahasiswas'));
    }

    public function update(Request $request, Laporan $laporan)
    {
        $validated = $request->validate([
            'judul' => ['required','string','max:150'],
            'deskripsi' => ['required','string','max:2000'],
            'mahasiswa_id' => ['required','exists:mahasiswas,id'],
            'status' => ['required','in:baru,diproses,selesai'],
        ]);

        $laporan->update($validated);
            \App\Models\StatusHistory::create([
        'laporan_id' => $laporan->id,
        'status' => $validated['status'],
        ]);      

        return redirect()->route('laporan.show', $laporan)->with('success','Laporan berhasil diperbarui.');
    }

    public function destroy(Laporan $laporan)
    {
        $laporan->delete();
        return redirect()->route('laporan.index')->with('success','Laporan berhasil dihapus.');
    }
}