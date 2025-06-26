@extends('layouts.app')

@section('title', 'Produk - Hallyu Haven')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Daftar Produk Kpop Terbaru</h2>
    <div class="row" id="product-list">
        <!-- Produk akan muncul di sini lewat JS -->
    </div>
</div>
<script src="{{ asset('pages/js/plp.js') }}"></script>
@endsection