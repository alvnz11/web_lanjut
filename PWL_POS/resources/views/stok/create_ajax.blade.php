<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Tambah Stok Barang</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form id="formStok" action="{{ url('/stok/ajax') }}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label for="barang_id">Pilih Barang</label>
                    <select name="barang_id" id="barang_id" class="form-control" required>
                        <option value="">-- Pilih Barang --</option>
                        @foreach($barang as $b)
                        <option value="{{ $b->barang_id }}">{{ $b->barang_kode }} - {{ $b->barang_nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="stok_jumlah">Jumlah Stok</label>
                    <input type="number" name="stok_jumlah" id="stok_jumlah" class="form-control" min="1" required>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
$(function() {
    $('#formStok').validate({
        rules: {
            barang_id: {
                required: true
            },
            stok_jumlah: {
                required: true,
                min: 1
            }
        },
        messages: {
            barang_id: {
                required: "Silakan pilih barang"
            },
            stok_jumlah: {
                required: "Jumlah stok harus diisi",
                min: "Jumlah stok minimal 1"
            }
        },
        submitHandler: function(form) {
            $.ajax({
                url: $(form).attr('action'),
                method: 'POST',
                data: $(form).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status) {
                        $('#myModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message
                        }).then((result) => {
                            tableStok.ajax.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: response.message,
                            footer: response.errors ? Object.values(response.errors).join('<br>') : ''
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
            return false;
        }
    });
});
</script>