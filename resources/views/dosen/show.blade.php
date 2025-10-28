@extends('layouts.app')

@section('content')
<h2 class="text-xl font-semibold mb-4">Detail Dosen</h2>

<div class="bg-white rounded shadow p-4 max-w-xl">
  <div class="mb-2"><span class="font-semibold">Nama:</span> {{ $dosen->nama }}</div>
  <div class="mb-2"><span class="font-semibold">NIDN:</span> {{ $dosen->nidn }}</div>
  <div class="mb-4"><span class="font-semibold">Email:</span> {{ $dosen->email }}</div>

  <a href="{{ route('dosen.index') }}" class="px-4 py-2 rounded border hover:bg-gray-50">Kembali</a>
</div>
@endsection