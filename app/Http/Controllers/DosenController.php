<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use Illuminate\Http\Request;

class DosenController extends Controller
{
    public function index()
    {
        $dosens = \App\Models\Dosen::orderBy('nama')->paginate(10);
        return view('dosen.index', compact('dosens'));
    }

    public function create()
    {
        return view('dosen.create');
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required','string','max:100'],
            'nidn' => ['required','string','max:20','unique:dosens,nidn'],
            'email'=> ['required','email','max:100','unique:dosens,email'],
        ]);
        \App\Models\Dosen::create($validated);
        return redirect()->route('dosen.index')->with('success','Data dosen berhasil ditambahkan.');
    }

    public function edit(\App\Models\Dosen $dosen)
    {
        return view('dosen.edit', compact('dosen'));
    }

    public function update(\Illuminate\Http\Request $request, \App\Models\Dosen $dosen)
    {
        $validated = $request->validate([
            'nama' => ['required','string','max:100'],
            'nidn' => ['required','string','max:20','unique:dosens,nidn,'.$dosen->id],
            'email'=> ['required','email','max:100','unique:dosens,email,'.$dosen->id],
        ]);
        $dosen->update($validated);
        return redirect()->route('dosen.index')->with('success','Data dosen berhasil diperbarui.');
    }

    public function show(\App\Models\Dosen $dosen)
    {
        return view('dosen.show', compact('dosen'));
    }

    public function destroy(\App\Models\Dosen $dosen)
    {
        $dosen->delete();
        return redirect()->route('dosen.index')->with('success','Data dosen berhasil dihapus.');
    }
}
