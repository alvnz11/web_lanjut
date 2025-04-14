@extends('layouts.template')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Stok Barang</h3>
            <div class="card-tools">
                <a href="{{ url('/stok/export_pdf') }}" class="btn btn-warning"><i class="fa fa-file-pdf"></i> Export PDF</a>
                <button onclick="modalAction('{{ url('/stok/create_ajax') }}')" class="btn btn-success">Tambah Stok</button>
            </div>
        </div>
        <div class="card-body">
            <!-- untuk Filter data -->
            <div id="filter" class="form-horizontal filter-date p-2 border-bottom mb-2">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="barang_id">Pilih Barang</label>
                            <select name="barang_id" id="barang_id" class="form-control" required>
                                <option value="">-- Pilih Barang --</option>
                                @foreach($barang as $b)
                                    <option value="{{ $b->barang_id }}">{{ $b->barang_kode }} - {{ $b->barang_nama }}</option>
                                @endforeach
                            </select>
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
            searchable: true,
            render: function(data, type, row) {
                if (type === 'display' || type === 'filter') {
                    const namaBulan = [
                        "Januari", "Februari", "Maret", "April", "Mei", "Juni",
                        "Juli", "Agustus", "September", "Oktober", "November", "Desember"
                    ];
                    const tanggal = data.substring(0, 10);
                    const parts = tanggal.split('-');
                    const namaBulanIndex = parseInt(parts[1]) - 1;
                    const namaBulanText = namaBulan[namaBulanIndex];
                    return parts[2] + ' ' + namaBulanText +  ' ' + parts[0];
                }
                return data;
            }
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