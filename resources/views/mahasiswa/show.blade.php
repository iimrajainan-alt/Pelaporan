@extends('layouts.app')

@section('content')
<h2 class="text-xl font-semibold mb-4">Detail Mahasiswa</h2>

<div class="bg-white rounded shadow p-4 max-w-xl">
  <div class="mb-2"><span class="font-semibold">Nama:</span> {{ $mahasiswa->nama }}</div>
  <div class="mb-2"><span class="font-semibold">NIM:</span> {{ $mahasiswa->nim }}</div>
  <div class="mb-4"><span class="font-semibold">Email:</span> {{ $mahasiswa->email }}</div>

  <a href="{{ route('mahasiswa.index') }}" class="px-4 py-2 rounded border hover:bg-gray-50">Kembali</a>
</div>
@endsection