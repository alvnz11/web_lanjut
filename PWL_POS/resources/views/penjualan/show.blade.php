<!-- penjualan/show.blade.php -->
@extends('layouts.template')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Detail Penjualan</h3>
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

        <div class="row">
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tr>
                        <th width="30%">Kode Transaksi</th>
                        <td>: {{ $penjualan->penjualan_kode }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal</th>
                        <td>: {{ \Carbon\Carbon::parse($penjualan->penjualan_tanggal)->format('d/m/Y H:i:s') }}</td>
                    </tr>
                    <tr>
                        <th>Pembeli</th>
                        <td>: {{ $penjualan->pembeli }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tr>
                        <th width="30%">Petugas</th>
                        <td>: {{ $penjualan->user->nama }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>: <span class="badge badge-success">Selesai</span></td>
                    </tr>
                </table>
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
                    @foreach($penjualan->detail as $index => $detail)
                    @php 
                        $subtotal = $detail->harga * $detail->jumlah;
                        $total += $subtotal;
                    @endphp
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $detail->barang->barang_kode }}</td>
                        <td>{{ $detail->barang->barang_nama }}</td>
                        <td class="text-right">Rp {{ number_format($detail->harga, 0, ',', '.') }}</td>
                        <td class="text-center">{{ $detail->jumlah }}</td>
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
    </div>
</div>
@endsection