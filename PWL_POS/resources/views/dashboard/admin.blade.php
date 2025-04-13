@extends('layouts.template')

@section('content')
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $totalUsers }}</h3>
                <p>Total Pengguna</p>
            </div>
            <div class="icon">
                <i class="fas fa-users"></i>
            </div>
            <a href="{{ url('/user') }}" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
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
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{  $totalBarang }}</h3>
                <p>Total Produk</p>
            </div>
            <div class="icon">
                <i class="fas fa-boxes"></i>
            </div>
            <a href="{{ url('/barang') }}" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $totalSuppliers }}</h3>
                <p>Total Supplier</p>
            </div>
            <div class="icon">
                <i class="fas fa-truck"></i>
            </div>
            <a href="/supplier" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Registrasi Pengguna Bulanan</h3>
            </div>
            <div class="card-body">
                <canvas id="registrationChart" style="min-height: 300px;"></canvas>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Pengguna berdasarkan Level</h3>
            </div>
            <div class="card-body">
                <canvas id="userLevelChart" style="min-height: 300px;"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Pengguna Terbaru</h3>
                <div class="card-tools">
                    <a href="{{ url('/user') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Level</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentUsers as $user)
                            <tr>
                                <td>{{ $user->nama }}</td>
                                <td>{{ $user->username }}</td>
                                <td><span class="badge bg-primary">{{ $user->level_nama }}</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">Belum ada data pengguna</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
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
                           <th>Pembeli</th>
                           <th>Petugas</th>
                       </tr>
                   </thead>
                   <tbody>
                       @forelse($recentTransactions as $transaction)
                           <tr>
                               <td>
                                   <a href="{{ url('/penjualan/' . $transaction->penjualan_id) }}">
                                       {{ $transaction->penjualan_kode }}
                                   </a>
                               </td>
                               <td>{{ \Carbon\Carbon::parse($transaction->penjualan_tanggal)->format('d M Y') }}</td>
                               <td>{{ $transaction->pembeli }}</td>
                               <td>{{ $transaction->user->nama }}</td>
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
   var ctx = document.getElementById('registrationChart').getContext('2d');
   var chartData = {!! json_encode($chartData) !!};
   
   new Chart(ctx, {
       type: 'line',
       data: {
           labels: chartData.map(item => item.month),
           datasets: [{
               label: 'Pengguna Baru',
               data: chartData.map(item => item.total),
               backgroundColor: 'rgba(60,141,188,0.9)',
               borderColor: 'rgba(60,141,188,0.8)',
               pointRadius: 3,
               pointColor: '#3b8bba',
               pointStrokeColor: 'rgba(60,141,188,1)',
               pointHighlightFill: '#fff',
               pointHighlightStroke: 'rgba(60,141,188,1)',
               fill: false,
               borderWidth: 3
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
   
   var levelNames = {!! json_encode($levelNames) !!};
   var levelTotals = {!! json_encode($levelTotals) !!};
   
   var ctxPie = document.getElementById('userLevelChart').getContext('2d');
   new Chart(ctxPie, {
       type: 'pie',
       data: {
           labels: levelNames,
           datasets: [{
               data: levelTotals,
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
});
</script>
@endpush