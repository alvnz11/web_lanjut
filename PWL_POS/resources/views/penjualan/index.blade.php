@extends('layouts.template')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Penjualan</h3>
        <div class="card-tools">
            <a href="{{ url('/penjualan/export_pdf') }}" class="btn btn-warning"><i class="fa fa-file-pdf"></i> Export PDF</a>
            <a href="{{ url('/penjualan/create') }}" class="btn btn-success">Tambah Penjualan</a>
        </div>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <table class="table table-bordered table-striped" id="table-penjualan">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Transaksi</th>
                    <th>Tanggal</th>
                    <th>Pembeli</th>
                    <th>Petugas</th>
                    <th>Total</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>
@endsection

@push('js')
<script>
$(document).ready(function(){
    $('#table-penjualan').DataTable({
        processing: true,
        serverSide: true,
        ajax:{
            "url": "{{ url('/penjualan/list') }}",
            "dataType": "json",
            "type": "POST",
        },
        columns: [{
            data: "DT_RowIndex",
            className: "text-center",
            width: "5%",
            orderable: false,
            searchable: false
        },{
            data: "penjualan_kode",
            className: "",
            width: "15%",
        },{
            data: "tanggal",
            className: "",
            width: "10%",
        },{
            data: "pembeli",
            className: "",
            width: "20%",
        },{
            data: "user.nama",
            className: "",
            width: "15%",
        },{
            data: "total",
            className: "text-right",
            width: "15%",
        },{
            data: "aksi",
            className: "text-center",
            width: "10%",
            orderable: false,
            searchable: false
        }]
    });
});
</script>
@endpush