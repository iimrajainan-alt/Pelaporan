@extends('layouts.app')

@section('content')
<h2 class="text-xl font-semibold mb-4">Dashboard {{ ucfirst($user->role) }}</h2>

@if($user->role === 'mahasiswa')
  <p class="mb-3">Selamat datang, {{ $user->name }}. Berikut laporan yang kamu buat:</p>
@else
  <p class="mb-3">Selamat datang Admin DPA, berikut semua laporan mahasiswa:</p>
@endif

@php
  // ringkasan (safe untuk paginator)
  $total = method_exists($laporans, 'total') ? $laporans->total() : $laporans->count();
  $collection = method_exists($laporans, 'getCollection') ? $laporans->getCollection() : collect($laporans);
  $countBaru = $collection->where('status','baru')->count();
  $countDiproses = $collection->where('status','diproses')->count();
  $countSelesai = $collection->where('status','selesai')->count();
@endphp

<div class="grid grid-cols-4 gap-4 mb-6">
  <div class="bg-white p-4 rounded shadow">
    <div class="text-sm text-gray-500">Total Laporan</div>
    <div class="text-2xl font-bold">{{ $total }}</div>
  </div>
  <div class="bg-white p-4 rounded shadow">
    <div class="text-sm text-gray-500">Baru</div>
    <div class="text-2xl font-bold text-yellow-600">{{ $countBaru }}</div>
  </div>
  <div class="bg-white p-4 rounded shadow">
    <div class="text-sm text-gray-500">Diproses</div>
    <div class="text-2xl font-bold text-blue-600">{{ $countDiproses }}</div>
  </div>
  <div class="bg-white p-4 rounded shadow">
    <div class="text-sm text-gray-500">Selesai</div>
    <div class="text-2xl font-bold text-green-600">{{ $countSelesai }}</div>
  </div>
</div>

<table class="w-full border-collapse bg-white rounded shadow">
  <thead>
    <tr class="bg-gray-100 text-left">
      <th class="px-4 py-2 border">Nomor</th>
      <th class="px-4 py-2 border">Judul</th>
      <th class="px-4 py-2 border">Pelapor</th>
      <th class="px-4 py-2 border">Status</th>
      <th class="px-4 py-2 border">Aksi</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($laporans as $laporan)
      <tr>
        <td class="px-4 py-2 border font-mono">{{ $laporan->nomor_laporan }}</td>
        <td class="px-4 py-2 border">{{ $laporan->judul }}</td>
        <td class="px-4 py-2 border">{{ optional($laporan->mahasiswa)->nama }}</td>

        {{-- badge warna --}}
        @php
          $badge = match($laporan->status) {
            'baru' => 'bg-yellow-100 text-yellow-800',
            'diproses' => 'bg-blue-100 text-blue-800',
            'selesai' => 'bg-green-100 text-green-800',
            default => 'bg-gray-100 text-gray-800',
          };
        @endphp
        <td class="px-4 py-2 border">
          <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold {{ $badge }}">
            {{ ucfirst($laporan->status) }}
          </span>
        </td>

        {{-- aksi --}}
        <td class="px-4 py-2 border">
          @can('isDPA')
            <form action="{{ route('laporan.update', $laporan) }}" method="POST" class="inline-block mr-3">
              @csrf @method('PUT')
              <input type="hidden" name="judul" value="{{ $laporan->judul }}">
              <input type="hidden" name="deskripsi" value="{{ $laporan->deskripsi }}">
              <input type="hidden" name="mahasiswa_id" value="{{ $laporan->mahasiswa_id }}">
              <input type="hidden" name="status" value="{{ $laporan->status === 'baru' ? 'diproses' : 'selesai' }}">
              <button type="submit" class="text-green-600 hover:underline">
                {{ $laporan->status === 'baru' ? 'Proses' : ($laporan->status === 'diproses' ? 'Selesaikan' : '') }}
              </button>
            </form>

            <button
              class="text-red-600 hover:underline"
              data-action="{{ route('laporan.destroy', $laporan) }}"
              onclick="showDeleteModal(this.dataset.action)"
            >
              Hapus
            </button>
          @else
            <a href="{{ route('laporan.show', $laporan) }}" class="text-blue-600 hover:underline">Detail</a>
          @endcan
        </td>
      </tr>
    @endforeach
  </tbody>
</table>

{{-- modal konfirmasi hapus --}}
<div id="confirmModal" class="fixed inset-0 hidden items-center justify-center z-50">
  <div class="absolute inset-0 bg-black opacity-50"></div>
  <div class="bg-white rounded p-6 z-10 max-w-md w-full">
    <h3 class="text-lg font-semibold mb-4">Konfirmasi Hapus</h3>
    <p class="mb-4">Apakah Anda yakin ingin menghapus laporan ini? Tindakan ini tidak dapat dibatalkan.</p>
    <div class="flex justify-end gap-2">
      <button class="px-4 py-2 rounded border" onclick="closeModal()">Batal</button>
      <form id="deleteForm" method="POST" action="">
        @csrf
        @method('DELETE')
        <button type="submit" class="px-4 py-2 rounded bg-red-600 text-white">Hapus</button>
      </form>
    </div>
  </div>
</div>

{{-- modal JS --}}
<script>
  function showDeleteModal(action) {
    const modal = document.getElementById('confirmModal');
    const form = document.getElementById('deleteForm');
    if (!modal || !form) return;
    form.action = action;
    modal.classList.remove('hidden');
    modal.classList.add('flex');
  }
  function closeModal() {
    const modal = document.getElementById('confirmModal');
    if (!modal) return;
    modal.classList.remove('flex');
    modal.classList.add('hidden');
  }
  const modalEl = document.getElementById('confirmModal');
  if (modalEl) {
    modalEl.addEventListener('click', (e) => {
      if (e.target.id === 'confirmModal') closeModal();
    });
  }
</script>
@endsection