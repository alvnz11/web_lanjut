<form action="{{ url('/user/ajax') }}" method="POST" id="form-tambah" enctype="multipart/form-data">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4 text-center">
                        <div class="profile-photo-container mb-3">
                            <div id="preview-container">
                                <img id="preview-image" src="{{ asset('images/default-avatar.png') }}" alt="Preview Foto Profil" class="img-thumbnail rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                            </div>
                            <div class="mt-2">
                                <label for="foto_profil" class="btn btn-sm btn-outline-secondary">
                                    <i class="fa fa-upload"></i> Upload Foto Profil
                                </label>
                                <input type="file" class="custom-file-input d-none" id="foto_profil" name="foto_profil" accept="image/*">
                            </div>
                            <small id="error-foto_profil" class="error-text form-text text-danger"></small>
                            <div class="text-center mt-1">
                                <small class="text-muted">Klik untuk Upload Foto Profil</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label>Level Pengguna</label>
                            <select name="level_id" id="level_id" class="form-control" required>
                                <option value="">- Pilih Level -</option>
                                @foreach($level as $l)
                                <option value="{{ $l->level_id }}">{{ $l->level_nama }}</option>
                                @endforeach
                            </select>
                            <small id="error-level_id" class="error-text form-text text-danger"></small>
                        </div>
                        <div class="form-group">
                            <label>Username</label>
                            <input value="" type="text" name="username" id="username" class="form-control"
                                required>
                            <small id="error-username" class="error-text form-text text-danger"></small>
                        </div>
                        <div class="form-group">
                            <label>Nama</label>
                            <input value="" type="text" name="nama" id="nama" class="form-control"
                                required>
                            <small id="error-nama" class="error-text form-text text-danger"></small>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input value="" type="password" name="password" id="password" class="form-control" required>
                            <small id="error-password" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</form>
<script>
    $(document).ready(function() {
        // Preview gambar saat file dipilih
        $("#foto_profil").change(function() {
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                
                reader.onload = function(e) {
                    $('#preview-image').attr('src', e.target.result);
                }
                
                reader.readAsDataURL(this.files[0]);
            }
        });

        // Validasi form
        $("#form-tambah").validate({
            rules: {
                level_id: {
                    required: true,
                    number: true
                },
                username: {
                    required: true,
                    minlength: 3,
                    maxlength: 20
                },
                nama: {
                    required: true,
                    minlength: 3,
                    maxlength: 100
                },
                password: {
                    required: true,
                    minlength: 6,
                    maxlength: 20
                },
                foto_profil: {
                    extension: "jpg|jpeg|png|gif"
                }
            },
            messages: {
                foto_profil: {
                    extension: "Harap pilih file gambar (jpg, jpeg, png, atau gif)"
                }
            },
            submitHandler: function(form) {
                var formData = new FormData(form);
                
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.status) {
                            $('#myModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            });
                            dataUser.ajax.reload();
                        } else {
                            $('.error-text').text('');
                            $.each(response.msgField, function(prefix, val) {
                                $('#error-' + prefix).text(val[0]);
                            });
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: response.message
                            });
                        }
                    }
                });
                return false;
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>