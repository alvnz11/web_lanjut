@extends('layouts.template')

@section('content')
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $totalTransactions }}</h3>
                <p>Total Transaksi</p>
            </div>
            <div class="icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <a href="{{ url('/penjualan') }}" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>Rp {{ number_format($totalSpent, 0, ',', '.') }}</h3>
                <p>Total Belanja</p>
            </div>
            <div class="icon">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            <a href="{{ url('/penjualan') }}" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $mostPurchased->count() > 0 ? $mostPurchased[0]->barang_nama : 'Belum ada' }}</h3>
                <p>Produk Favorit</p>
            </div>
            <div class="icon">
                <i class="fas fa-star"></i>
            </div>
            <a href="{{ url('/stok') }}" class="small-box-footer">Belanja <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Transaksi Bulanan</h3>
            </div>
            <div class="card-body">
                <canvas id="transactionChart" style="min-height: 300px;"></canvas>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Produk Paling Sering Dibeli</h3>
            </div>
            <div class="card-body">
                @if($mostPurchased->count() > 0)
                    <div class="chart-responsive">
                        <canvas id="mostPurchasedChart" style="min-height: 300px;"></canvas>
                    </div>
                @else
                    <p class="text-center">Belum ada data pembelian</p>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Transaksi Terakhir</h3>
                <div class="card-tools">
                    <a href="{{ url('/penjualan') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Tanggal</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentTransactions as $transaction)
                            @php
                                $total = App\Models\PenjualanDetailModel::where('penjualan_id', $transaction->penjualan_id)
                                    ->sum(DB::raw('harga * jumlah'));
                            @endphp
                            <tr>
                                <td>
                                    <a href="{{ url('/penjualan/' . $transaction->penjualan_id) }}">
                                        {{ $transaction->penjualan_kode }}
                                    </a>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($transaction->penjualan_tanggal)->format('d M Y H:i') }}</td>
                                <td>Rp {{ number_format($total, 0, ',', '.') }}</td>
                                <td><span class="badge bg-success">Selesai</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Belum ada transaksi</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var ctx = document.getElementById('transactionChart').getContext('2d');
    var chartData = {!! json_encode($chartData) !!};
    
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: chartData.map(item => item.month),
            datasets: [{
                label: 'Jumlah Transaksi',
                data: chartData.map(item => item.total),
                backgroundColor: 'rgba(60,141,188,0.9)',
                borderColor: 'rgba(60,141,188,0.8)',
                pointRadius: 3,
                pointColor: '#3b8bba',
                pointStrokeColor: 'rgba(60,141,188,1)',
                pointHighlightFill: '#fff',
                pointHighlightStroke: 'rgba(60,141,188,1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
    
    // Most purchased products chart
    var mostPurchased = {!! json_encode($mostPurchased) !!};
    
    if (mostPurchased.length > 0) {
        var ctxPie = document.getElementById('mostPurchasedChart').getContext('2d');
        new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: mostPurchased.map(item => item.barang_nama),
                datasets: [{
                    data: mostPurchased.map(item => item.total_qty),
                    backgroundColor: [
                        '#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    }
});
</script>
@endpush