@if(session('success'))
  <div class="mb-4 p-3 rounded bg-green-100 text-green-800 border border-green-300">
    {{ session('success') }}
  </div>
@endif