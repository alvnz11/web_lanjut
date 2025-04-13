@extends('layouts.template')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Produk Tersedia</h3>
        <div class="card-tools">
            <a href="{{ url('/cart') }}" class="btn btn-info">
                <i class="fas fa-shopping-cart"></i> Keranjang 
                <span class="badge badge-light">{{ count(session('cart', [])) }}</span>
            </a>
        </div>
    </div>
    <div class="card-body">
        <!-- Filter section -->
        <div id="filter" class="form-horizontal filter-date p-2 border-bottom mb-2">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group form-group-sm row text-sm mb-0">
                        <label class="col-md-1 col-form-label">Filter</label>
                        <div class="col-md-3">
                            <select id="filter_kategori" class="form-control form-control-sm">
                                <option value="">- Semua Kategori -</option>
                                @php
                                    $categories = $barang->pluck('kategori.kategori_nama', 'kategori.kategori_id')->unique();
                                @endphp
                                @foreach($categories as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Kategori Produk</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="row mt-4" id="product-container">
            @foreach($barang as $b)
            <div class="col-md-4 mb-4 product-item" data-category="{{ $b->kategori->kategori_id }}">
                <div class="card h-100">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">{{ $b->barang_nama }}</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Kode:</strong> {{ $b->barang_kode }}</p>
                        <p><strong>Kategori:</strong> {{ $b->kategori->kategori_nama }}</p>
                        <p><strong>Harga:</strong> Rp {{ number_format($b->harga_jual, 0, ',', '.') }}</p>
                        <p><strong>Stok Tersedia:</strong> 
                            @php
                                $stockAvailable = $b->stok->sum('stok_jumlah') ?? 0;
                            @endphp
                            {{ $stockAvailable }}
                        </p>
                    </div>
                    <div class="card-footer">
                        <form action="{{ url('/stok/add-to-cart') }}" method="POST">
                            @csrf
                            <input type="hidden" name="barang_id" value="{{ $b->barang_id }}">
                            <div class="input-group mb-3">
                                <input type="number" name="quantity" class="form-control" value="1" min="1" max="{{ $stockAvailable }}">
                                <div class="input-group-append">
                                    <button class="btn btn-success" type="submit" {{ $stockAvailable <= 0 ? 'disabled' : '' }}>
                                        <i class="fas fa-cart-plus"></i> Tambah
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
$(document).ready(function() {
    $('#filter_kategori').change(function() {
        var category = $(this).val();
        
        if (category === '') {
            $('.product-item').show();
        } else {
            $('.product-item').hide();
            $('.product-item[data-category="' + category + '"]').show();
        }
    });
});
</script>
@endpush