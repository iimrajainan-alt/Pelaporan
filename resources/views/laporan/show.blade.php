@extends('layouts.app')

@section('content')
<h2 class="text-xl font-semibold mb-4">Detail Laporan</h2>

<x-alert-success />

<div class="bg-white rounded shadow p-4">
  <div class="mb-2"><span class="font-semibold">Nomor Tiket:</span> <span class="font-mono">{{ $laporan->nomor_laporan }}</span></div>
  <div class="mb-2"><span class="font-semibold">Judul:</span> {{ $laporan->judul }}</div>
  <div class="mb-2"><span class="font-semibold">Pelapor:</span> {{ optional($laporan->mahasiswa)->nama }} ({{ optional($laporan->mahasiswa)->nim }})</div>
  <div class="mb-2"><span class="font-semibold">Status:</span> <span class="px-2 py-1 rounded bg-gray-100 border">{{ ucfirst($laporan->status) }}</span></div>
  <div class="mb-4"><span class="font-semibold">Deskripsi:</span><br>{{ $laporan->deskripsi }}</div>

  <div class="flex items-center gap-2">
    <a href="{{ route('laporan.edit', $laporan) }}" class="px-4 py-2 rounded bg-yellow-500 text-white hover:bg-yellow-600">Edit</a>
    <a href="{{ route('laporan.index') }}" class="px-4 py-2 rounded border hover:bg-gray-50">Kembali</a>
  </div>
</div>
@endsection