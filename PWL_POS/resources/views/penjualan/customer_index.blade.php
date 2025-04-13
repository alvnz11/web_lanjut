@extends('layouts.template')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Riwayat Pembelian</h3>
        <div class="card-tools">
            <a href="{{ url('/stok') }}" class="btn btn-primary">Belanja Lagi</a>
        </div>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if(count($penjualan) > 0)
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Transaksi</th>
                            <th>Tanggal</th>
                            <th>Total Item</th>
                            <th>Total Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($penjualan as $index => $p)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $p->penjualan_kode }}</td>
                            <td>{{ \Carbon\Carbon::parse($p->penjualan_tanggal)->format('d/m/Y') }}</td>
                            <td>{{ $p->detail->sum('jumlah') }} item</td>
                            <td class="text-right">
                                Rp {{ number_format($p->detail->sum(function($detail) {
                                    return $detail->harga * $detail->jumlah;
                                }), 0, ',', '.') }}
                            </td>
                            <td class="text-center">
                                <a href="{{ url('/penjualan/' . $p->penjualan_id) }}" class="btn btn-sm btn-info">
                                    <i class="fa fa-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info">
                <h5><i class="icon fas fa-info"></i> Belum Ada Pembelian!</h5>
                Anda belum melakukan pembelian. <a href="{{ url('/stok') }}">Klik disini</a> untuk mulai belanja.
            </div>
        @endif
    </div>
</div>
@endsection