<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Edit Stok Barang</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form id="formEditStok" action="{{ url('/stok/' . $stok->stok_id . '/update_ajax') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="form-group">
                    <label>Kode Barang</label>
                    <input type="text" class="form-control" value="{{ $stok->barang->barang_kode }} - {{ $stok->barang->barang_nama }}" readonly>
                </div>
                <div class="form-group">
                    <label for="stok_jumlah">Jumlah Stok</label>
                    <input type="number" name="stok_jumlah" id="stok_jumlah" class="form-control" value="{{ $stok->stok_jumlah }}" required>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>

<script>
$(function() {
    $('#formEditStok').submit(function(e) {
        e.preventDefault();
        
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.status) {
                    $('#myModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.message
                    }).then((result) => {
                        tableStok.draw();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: response.message
                    });
                }
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Terjadi kesalahan! Silahkan coba lagi.'
                });
            }
        });
    });
});
</script>