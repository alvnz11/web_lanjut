@extends('layouts.template')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Stok Barang</h3>
            <div class="card-tools">
                <button onclick="modalAction('{{ url('/stok/create_ajax') }}')" class="btn btn-success">Tambah Stok</button>
            </div>
        </div>
        <div class="card-body">
            <!-- untuk Filter data -->
            <div id="filter" class="form-horizontal filter-date p-2 border-bottom mb-2">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-group-sm row text-sm mb-0">
                            <label for="filter_date" class="col-md-1 col-form-label">Filter</label>
                            <div class="col-md-3">
                                <select name="filter_barang" class="form-control form-control-sm filter_barang">
                                    <option value="">- Semua Barang -</option>
                                    @foreach($barang as $b)
                                    <option value="{{ $b->barang_id }}">{{ $b->barang_kode }} - {{ $b->barang_nama }}</option>
                                    @endforeach
                                </select>
                                <small class="form-text text-muted">Barang</small>
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

            <table class="table table-bordered table-sm table-striped table-hover" id="table-stok">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Jumlah</th>
                        <th>Petugas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
    <div id="myModal" class="modal fade animate shake" tabindex="-1" data-backdrop="static" data-keyboard="false" data-width="75%"></div>
@endsection

@push('js')
<script>
function modalAction(url = ''){
    $('#myModal').load(url,function(){
        $('#myModal').modal('show');
    });
}

function editStok(id) {
    modalAction('{{ url('/stok') }}/' + id + '/edit_ajax');
}

var tableStok;
$(document).ready(function(){
    tableStok = $('#table-stok').DataTable({
        processing: true,
        serverSide: true,
        ajax:{
            "url": "{{ url('/stok/list') }}",
            "dataType": "json",
            "type": "POST",
            "data": function (d) {
                d.filter_barang = $('.filter_barang').val();
            }
        },
        columns: [{
            data: "DT_RowIndex",
            className: "text-center",
            width: "5%",
            orderable: false,
            searchable: false
        },{
            data: "stok_tanggal",
            className: "",
            width: "15%",
            orderable: true,
            searchable: true
        },{
            data: "barang.barang_kode",
            className: "",
            width: "10%",
            orderable: true,
            searchable: true
        },{
            data: "barang.barang_nama",
            className: "",
            width: "30%",
            orderable: true,
            searchable: true
        },{
            data: "stok_jumlah",
            className: "text-right",
            width: "10%",
            orderable: true,
            searchable: false
        },{
            data: "user.nama",
            className: "",
            width: "15%",
            orderable: true,
            searchable: false
        },{
            data: "aksi",
            className: "text-center",
            width: "15%",
            orderable: false,
            searchable: false
        }]
    });

    $('#table-stok_filter input').unbind().bind().on('keyup', function(e){
        if(e.keyCode == 13){ // enter key
            tableStok.search(this.value).draw();
        }
    });

    $('.filter_barang').change(function(){
        tableStok.draw();
    });
});
</script>
@endpush