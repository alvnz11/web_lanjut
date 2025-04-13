@extends('layouts.template')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Checkout</h3>
        <div class="card-tools">
            <a href="{{ url('/cart') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali ke Keranjang
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

        <form action="{{ url('/checkout/process') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nama Penerima</label>
                        <input type="text" name="pembeli" class="form-control" value="{{ Auth::user()->nama }}" readonly>
                    </div>
                </div>
            </div>

            <div class="table-responsive mt-4">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th class="text-right">Harga</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total = 0; @endphp
                        @foreach($cart as $id => $details)
                        @php 
                            $subtotal = $details['harga'] * $details['quantity'];
                            $total += $subtotal;
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $details['barang_kode'] }}</td>
                            <td>{{ $details['barang_nama'] }}</td>
                            <td class="text-right">Rp {{ number_format($details['harga'], 0, ',', '.') }}</td>
                            <td class="text-center">{{ $details['quantity'] }}</td>
                            <td class="text-right">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="5" class="text-right">Total</th>
                            <th class="text-right">Rp {{ number_format($total, 0, ',', '.') }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="mt-4 text-right">
                <button type="submit" class="btn btn-primary">Proses Pesanan</button>
            </div>
        </form>
    </div>
</div>
@endsection