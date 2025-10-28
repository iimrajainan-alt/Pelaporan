<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mahasiswas = \App\Models\Mahasiswa::orderBy('nama')->paginate(10);
        return view('mahasiswa.index', compact('mahasiswas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('mahasiswa.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(\Illuminate\Http\Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required','string','max:100'],
            'nim'  => ['required','string','max:20','unique:mahasiswas,nim'],
            'email'=> ['required','email','max:100','unique:mahasiswas,email'],
        ]);

        \App\Models\Mahasiswa::create($validated);

        return redirect()->route('mahasiswa.index')->with('success','Data mahasiswa berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(\App\Models\Mahasiswa $mahasiswa)
    {
        return view('mahasiswa.show', compact('mahasiswa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(\App\Models\Mahasiswa $mahasiswa)
    {
        return view('mahasiswa.edit', compact('mahasiswa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(\Illuminate\Http\Request $request, \App\Models\Mahasiswa $mahasiswa)
    {
        $validated = $request->validate([
            'nama' => ['required','string','max:100'],
            'nim'  => ['required','string','max:20','unique:mahasiswas,nim,'.$mahasiswa->id],
            'email'=> ['required','email','max:100','unique:mahasiswas,email,'.$mahasiswa->id],
        ]);

        $mahasiswa->update($validated);

        return redirect()->route('mahasiswa.index')->with('success','Data mahasiswa berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(\App\Models\Mahasiswa $mahasiswa)
    {
        $mahasiswa->delete();
        return redirect()->route('mahasiswa.index')->with('success','Data mahasiswa berhasil dihapus.');
    }
}
