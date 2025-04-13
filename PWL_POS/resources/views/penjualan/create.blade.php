@extends('layouts.template')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Tambah Penjualan</h3>
        <div class="card-tools">
            <a href="{{ url('/penjualan') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="{{ url('/penjualan') }}" method="POST" id="form-penjualan">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="pembeli">Nama Pembeli</label>
                        <input type="text" name="pembeli" id="pembeli" class="form-control" required>
                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title">Daftar Barang</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="product-table">
                            <thead>
                                <tr>
                                    <th>Barang</th>
                                    <th>Harga</th>
                                    <th>Stok</th>
                                    <th>Jumlah</th>
                                    <th>Subtotal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr id="row-1">
                                    <td>
                                        <select name="barang_id[]" class="form-control barang-select" data-row="1" required>
                                            <option value="">-- Pilih Barang --</option>
                                            @foreach($barang as $b)
                                            @php
                                                $stockAvailable = $b->stok->sum('stok_jumlah') ?? 0;
                                            @endphp
                                            <option value="{{ $b->barang_id }}" data-harga="{{ $b->harga_jual }}" data-stok="{{ $stockAvailable }}">
                                                {{ $b->barang_kode }} - {{ $b->barang_nama }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <span id="harga-1">Rp 0</span>
                                        <input type="hidden" id="harga-val-1" value="0">
                                    </td>
                                    <td>
                                        <span id="stok-1">0</span>
                                    </td>
                                    <td>
                                        <input type="number" name="jumlah[]" id="jumlah-1" class="form-control jumlah-input" data-row="1" min="1" value="1" required>
                                    </td>
                                    <td>
                                        <span id="subtotal-1">Rp 0</span>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm btn-remove-row" data-row="1" disabled>
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="6">
                                        <button type="button" class="btn btn-success btn-sm" id="btn-add-row">
                                            <i class="fa fa-plus"></i> Tambah Barang
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="4" class="text-right">Total</th>
                                    <th id="grand-total">Rp 0</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <div class="mt-4 text-right">
                <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('js')
<script>
$(document).ready(function() {
    // Row counter
    var rowCount = 1;
    
    // Add row button
    $('#btn-add-row').click(function() {
        rowCount++;
        var newRow = `
            <tr id="row-${rowCount}">
                <td>
                    <select name="barang_id[]" class="form-control barang-select" data-row="${rowCount}" required>
                        <option value="">-- Pilih Barang --</option>
                        @foreach($barang as $b)
                        @php
                            $stockAvailable = $b->stok->sum('stok_jumlah') ?? 0;
                        @endphp
                        <option value="{{ $b->barang_id }}" data-harga="{{ $b->harga_jual }}" data-stok="{{ $stockAvailable }}">
                            {{ $b->barang_kode }} - {{ $b->barang_nama }}
                        </option
                        @endphp
                        <option value="{{ $b->barang_id }}" data-harga="{{ $b->harga_jual }}" data-stok="{{ $stockAvailable }}">
                            {{ $b->barang_kode }} - {{ $b->barang_nama }}
                        </option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <span id="harga-${rowCount}">Rp 0</span>
                    <input type="hidden" id="harga-val-${rowCount}" value="0">
                </td>
                <td>
                    <span id="stok-${rowCount}">0</span>
                </td>
                <td>
                    <input type="number" name="jumlah[]" id="jumlah-${rowCount}" class="form-control jumlah-input" data-row="${rowCount}" min="1" value="1" required>
                </td>
                <td>
                    <span id="subtotal-${rowCount}">Rp 0</span>
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm btn-remove-row" data-row="${rowCount}">
                        <i class="fa fa-trash"></i>
                    </button>
                </td>
            </tr>
        `;
        $('#product-table tbody').append(newRow);
    });
    
    // Remove row button
    $(document).on('click', '.btn-remove-row', function() {
        var row = $(this).data('row');
        $('#row-' + row).remove();
        calculateGrandTotal();
    });
    
    // Product selection
    $(document).on('change', '.barang-select', function() {
        var row = $(this).data('row');
        var harga = $(this).find(':selected').data('harga') || 0;
        var stok = $(this).find(':selected').data('stok') || 0;
        
        $('#harga-' + row).text('Rp ' + formatNumber(harga));
        $('#harga-val-' + row).val(harga);
        $('#stok-' + row).text(stok);
        
        // Update jumlah max value
        $('#jumlah-' + row).attr('max', stok);
        
        // Calculate subtotal
        calculateSubtotal(row);
        calculateGrandTotal();
    });
    
    // Quantity change
    $(document).on('input', '.jumlah-input', function() {
        var row = $(this).data('row');
        calculateSubtotal(row);
        calculateGrandTotal();
    });
    
    // Calculate subtotal for a row
    function calculateSubtotal(row) {
        var harga = parseInt($('#harga-val-' + row).val()) || 0;
        var jumlah = parseInt($('#jumlah-' + row).val()) || 0;
        var subtotal = harga * jumlah;
        
        $('#subtotal-' + row).text('Rp ' + formatNumber(subtotal));
    }
    
    // Calculate grand total
    function calculateGrandTotal() {
        var total = 0;
        
        $('#product-table tbody tr').each(function() {
            var row = $(this).attr('id').split('-')[1];
            var harga = parseInt($('#harga-val-' + row).val()) || 0;
            var jumlah = parseInt($('#jumlah-' + row).val()) || 0;
            total += harga * jumlah;
        });
        
        $('#grand-total').text('Rp ' + formatNumber(total));
    }
    
    // Format number to currency
    function formatNumber(num) {
        return new Intl.NumberFormat('id-ID').format(num);
    }
    
    // Form validation
    $('#form-penjualan').submit(function(e) {
        var valid = true;
        
        // Check if there are products
        if ($('#product-table tbody tr').length === 0) {
            alert('Silakan tambahkan minimal 1 produk');
            valid = false;
        }
        
        // Check stock availability
        $('#product-table tbody tr').each(function() {
            var row = $(this).attr('id').split('-')[1];
            var stok = parseInt($('#stok-' + row).text()) || 0;
            var jumlah = parseInt($('#jumlah-' + row).val()) || 0;
            
            if (jumlah > stok) {
                alert('Jumlah melebihi stok yang tersedia');
                $('#jumlah-' + row).focus();
                valid = false;
                return false;
            }
        });
        
        if (!valid) {
            e.preventDefault();
        }
    });
});
</script>
@endpush