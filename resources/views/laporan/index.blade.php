@extends('layouts.app')

@section('content')
<div class="flex items-center justify-between mb-4">
  <h2 class="text-xl font-semibold">Daftar Laporan</h2>
  <a href="{{ route('laporan.create') }}" class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700">+ Buat Laporan</a>
</div>

<x-alert-success />

<table class="w-full border-collapse bg-rounded shadow">
  <thead>
    <tr class="bg-gray-100 text-left">
      <th class="px-4 py-2 border">#</th>
      <th class="px-4 py-2 border">Nomor</th>
      <th class="px-4 py-2 border">Judul</th>
      <th class="px-4 py-2 border">Pelapor</th>
      <th class="px-4 py-2 border">Status</th>
      <th class="px-4 py-2 border">Aksi</th>
    </tr>
  </thead>
  <tbody>
    @forelse ($laporans as $index => $laporan)
      <tr>
        <td class="px-4 py-2 border">{{ $laporans->firstItem() + $index }}</td>
        <td class="px-4 py-2 border font-mono">{{ $laporan->nomor_laporan }}</td>
        <td class="px-4 py-2 border">{{ $laporan->judul }}</td>
        <td class="px-4 py-2 border">{{ optional($laporan->mahasiswa)->nama }}</td>
        <td class="px-4 py-2 border">
          @php
            $color = $laporan->status === 'selesai' ? 'green' : ($laporan->status === 'diproses' ? 'yellow' : 'red');
          @endphp
          <span class="px-2 py-1 rounded bg-{{ $color }}-100 text-{{ $color }}-800 border border-{{ $color }}-200 text-sm">
            {{ ucfirst($laporan->status) }}
          </span>        
        </td>
        <td class="px-4 py-2 border">
          <a href="{{ route('laporan.show', $laporan) }}" class="text-blue-700 hover:underline">Lihat</a>
          <a href="{{ route('laporan.edit', $laporan) }}" class="ml-3 text-yellow-600 hover:underline">Edit</a>
          
          <!-- Tombol Ubah Status Cepat -->
          <form action="{{ route('laporan.update', $laporan) }}" method="POST" class="inline-block ml-3">
            @csrf @method('PUT')
            <input type="hidden" name="judul" value="{{ $laporan->judul }}">
            <input type="hidden" name="deskripsi" value="{{ $laporan->deskripsi }}">
            <input type="hidden" name="mahasiswa_id" value="{{ $laporan->mahasiswa_id }}">
            <input type="hidden" name="status" value="{{ $laporan->status === 'baru' ? 'diproses' : 'selesai' }}">
            <button type="submit" class="text-green-600 hover:underline">
              {{ $laporan->status === 'baru' ? 'Proses' : ($laporan->status === 'diproses' ? 'Selesaikan' : '') }}
            </button>
          </form>

          <!-- Hapus -->
          <form action="{{ route('laporan.destroy', $laporan) }}" method="POST" class="inline-block ml-3" onsubmit="return confirm('Yakin hapus laporan?')">
            @csrf @method('DELETE')
            <button type="submit" class="text-red-600 hover:underline">Hapus</button>
          </form>
        </td>
      </tr>
    @empty
      <tr><td colspan="6" class="px-4 py-6 border text-center text-gray-500">Belum ada laporan</td></tr>
    @endforelse
  </tbody>
</table>

<div class="mt-4">
  {{ $laporans->links() }}
</div>
@endsection