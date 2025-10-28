@extends('layouts.app')

@section('content')
<h2 class="text-xl font-semibold mb-4">Edit Laporan</h2>

@if ($errors->any())
  <div class="mb-4 rounded border border-red-200 bg-red-50 p-3 text-red-700">
    <ul class="list-disc pl-5">
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif

<form action="{{ route('laporan.update', $laporan) }}" method="POST" class="bg-white p-4 rounded shadow max-w-2xl">
  @csrf @method('PUT')

  <div class="mb-3">
    <label class="block mb-1">Mahasiswa (Pelapor)</label>
    <select name="mahasiswa_id" class="w-full border rounded px-3 py-2" required>
      @foreach ($mahasiswas as $mhs)
        <option value="{{ $mhs->id }}" {{ old('mahasiswa_id', $laporan->mahasiswa_id) == $mhs->id ? 'selected' : '' }}>
          {{ $mhs->nama }} ({{ $mhs->nim }})
        </option>
      @endforeach
    </select>
  </div>

  <div class="mb-3">
    <label class="block mb-1">Judul Laporan</label>
    <input type="text" name="judul" value="{{ old('judul', $laporan->judul) }}" class="w-full border rounded px-3 py-2" required>
  </div>

  <div class="mb-3">
    <label class="block mb-1">Deskripsi</label>
    <textarea name="deskripsi" rows="5" class="w-full border rounded px-3 py-2" required>{{ old('deskripsi', $laporan->deskripsi) }}</textarea>
  </div>

  <div class="mb-4">
    <label class="block mb-1">Status</label>
    <select name="status" class="w-full border rounded px-3 py-2" required>
      @foreach (['baru','diproses','selesai'] as $st)
        <option value="{{ $st }}" {{ old('status', $laporan->status) == $st ? 'selected' : '' }}>{{ ucfirst($st) }}</option>
      @endforeach
    </select>
  </div>

  <div class="flex items-center gap-2">
    <button type="submit" class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700">Update</button>
    <a href="{{ route('laporan.show', $laporan) }}" class="px-4 py-2 rounded border hover:bg-gray-50">Batal</a>
  </div>
</form>
@endsection