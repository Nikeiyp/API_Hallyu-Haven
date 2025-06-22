@extends('layout.app-public')

@section('content')
<section class="hero text-center py-8 bg-pink-100">
    <h1 class="text-3xl font-bold mb-2">Selamat datang di Hallyu Haven</h1>
    <p class="text-lg text-gray-700">Toko online K-Pop terlengkap dan terpercaya!</p>

    {{-- 🔍 Search Input --}}
    <div class="my-6">
        <input type="text" id="searchInput" placeholder="Cari merchandise..." 
            class="w-1/2 p-2 border border-gray-300 rounded" />
    </div>

    {{-- 🛒 List Produk --}}
    <div id="merchList" class="grid grid-cols-3 gap-4 p-4">
        <!-- Produk akan dimuat oleh JavaScript -->
    </div>

    {{-- 🔢 Pagination --}}
    <div id="pagination" class="flex justify-center gap-2 mt-4">
        <!-- Tombol pagination diisi oleh JavaScript -->
    </div>
</section>
@endsection

@push('scripts')
<script src="{{ asset('asset/pages/js/home.js') }}"></script>
@endpush
