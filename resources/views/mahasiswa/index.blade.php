@extends('layouts.app')

@section('content')
<div class="flex items-center justify-between mb-4">
  <h2 class="text-xl font-semibold">Daftar Mahasiswa</h2>
  <a href="{{ route('mahasiswa.create') }}" class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700">+ Tambah Mahasiswa</a>
</div>

<x-alert-success />

<table class="w-full border-collapse bg-white rounded shadow">
  <thead>
    <tr class="bg-gray-100 text-left">
      <th class="px-4 py-2 border">#</th>
      <th class="px-4 py-2 border">Nama</th>
      <th class="px-4 py-2 border">NIM</th>
      <th class="px-4 py-2 border">Email</th>
      <th class="px-4 py-2 border">Aksi</th>
    </tr>
  </thead>
  <tbody>
    @forelse ($mahasiswas as $index => $mahasiswa)
      <tr>
        <td class="px-4 py-2 border">{{ $mahasiswas->firstItem() + $index }}</td>
        <td class="px-4 py-2 border">{{ $mahasiswa->nama }}</td>
        <td class="px-4 py-2 border">{{ $mahasiswa->nim }}</td>
        <td class="px-4 py-2 border">{{ $mahasiswa->email }}</td>
        <td class="px-4 py-2 border">
          <a href="{{ route('mahasiswa.show', $mahasiswa) }}" class="text-blue-700 hover:underline">Lihat</a>
          <a href="{{ route('mahasiswa.edit', $mahasiswa) }}" class="ml-3 text-yellow-600 hover:underline">Edit</a>
          <form action="{{ route('mahasiswa.destroy', $mahasiswa) }}" method="POST" class="inline-block ml-3" onsubmit="return confirm('Yakin hapus data?')">
            @csrf @method('DELETE')
            <button type="submit" class="text-red-600 hover:underline">Hapus</button>
          </form>
        </td>
      </tr>
    @empty
      <tr><td colspan="5" class="px-4 py-6 border text-center text-gray-500">Belum ada data</td></tr>
    @endforelse
  </tbody>
</table>

<div class="mt-4">
  {{ $mahasiswas->links() }}
</div>
@endsection