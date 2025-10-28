@extends('layouts.app')

@section('content')
<h2 class="text-xl font-semibold mb-4">Buat Laporan Baru</h2>

@if ($errors->any())
  <div class="mb-4 rounded border border-red-200 bg-red-50 p-3 text-red-700">
    <ul class="list-disc pl-5">
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif

<form action="{{ route('laporan.store') }}" method="POST" class="bg-white p-4 rounded shadow max-w-2xl">
  @csrf

  <div class="mb-3">
    <label class="block mb-1">Mahasiswa (Pelapor)</label>
    <select name="mahasiswa_id" class="w-full border rounded px-3 py-2" required>
      <option value="" disabled selected>-- Pilih Mahasiswa --</option>
      @foreach ($mahasiswas as $mhs)
        <option value="{{ $mhs->id }}" {{ old('mahasiswa_id') == $mhs->id ? 'selected' : '' }}>
          {{ $mhs->nama }} ({{ $mhs->nim }})
        </option>
      @endforeach
    </select>
  </div>

  <div class="mb-3">
    <label class="block mb-1">Judul Laporan</label>
    <input type="text" name="judul" value="{{ old('judul') }}" class="w-full border rounded px-3 py-2" required>
  </div>

  <div class="mb-4">
    <label class="block mb-1">Deskripsi</label>
    <textarea name="deskripsi" rows="5" class="w-full border rounded px-3 py-2" required>{{ old('deskripsi') }}</textarea>
  </div>

  <div class="flex items-center gap-2">
    <button type="submit" class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700">Kirim Laporan</button>
    <a href="{{ route('laporan.index') }}" class="px-4 py-2 rounded border hover:bg-gray-50">Batal</a>
  </div>
</form>
@endsection