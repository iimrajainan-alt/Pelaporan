@if(session('success'))
  <div class="mb-4 rounded border border-green-200 bg-green-50 p-3 text-green-700">
    {{ session('success') }}
  </div>
@endif