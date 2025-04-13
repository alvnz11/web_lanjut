@extends('layouts.template')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Keranjang Belanja</h3>
        <div class="card-tools">
            <a href="{{ url('/stok') }}" class="btn btn-secondary">
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

        @if(count(session('cart', [])) > 0)
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Produk</th>
                        <th class="text-right">Harga</th>
                        <th class="text-center">Jumlah</th>
                        <th class="text-right">Subtotal</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0 @endphp
                    @foreach(session('cart') as $id => $details)
                        @php $total += $details['harga'] * $details['quantity'] @endphp
                        <tr>
                            <td>{{ $details['barang_kode'] }}</td>
                            <td>{{ $details['barang_nama'] }}</td>
                            <td class="text-right">Rp {{ number_format($details['harga'], 0, ',', '.') }}</td>
                            <td class="text-center">
                                <div class="input-group input-group-sm">
                                    <input type="number" class="form-control quantity" data-id="{{ $id }}" value="{{ $details['quantity'] }}" min="1">
                                    <div class="input-group-append">
                                        <button class="btn btn-info btn-update-item" data-id="{{ $id }}"><i class="fa fa-sync-alt"></i></button>
                                    </div>
                                </div>
                            </td>
                            <td class="text-right">Rp {{ number_format($details['harga'] * $details['quantity'], 0, ',', '.') }}</td>
                            <td class="text-center">
                                <button class="btn btn-danger btn-sm btn-remove-item" data-id="{{ $id }}"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="text-right"><strong>Total</strong></td>
                        <td class="text-right"><strong>Rp {{ number_format($total, 0, ',', '.') }}</strong></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
            <div class="mt-3 text-right">
                <a href="{{ url('/stok') }}" class="btn btn-primary">Lanjut Belanja</a>
                <a href="{{ url('/checkout') }}" class="btn btn-success">Checkout</a>
            </div>
        @else
            <div class="alert alert-info">
                <h5><i class="icon fas fa-info"></i> Keranjang Kosong!</h5>
                Keranjang belanja Anda masih kosong. <a href="{{ url('/stok') }}">Klik disini</a> untuk mulai belanja.
            </div>
        @endif
    </div>
</div>
@endsection

@push('js')
<script>
$(document).ready(function() {
    // Update cart item
    $('.btn-update-item').click(function() {
        var id = $(this).data('id');
        var quantity = $(this).closest('tr').find('.quantity').val();
        
        $.ajax({
            url: '{{ url("/update-cart") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id: id,
                quantity: quantity
            },
            success: function(response) {
                window.location.reload();
            }
        });
    });
    
    // Remove cart item
    $('.btn-remove-item').click(function() {
        var id = $(this).data('id');
        
        $.ajax({
            url: '{{ url("/remove-from-cart") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id: id
            },
            success: function(response) {
                window.location.reload();
            }
        });
    });
});
</script>
@endpush