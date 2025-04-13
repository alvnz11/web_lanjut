<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Akun YourShop</title>

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
  
  <style>
    body {
      background-color: #f9e8d2;
      font-family: 'Source Sans Pro', sans-serif;
      overflow-x: hidden;
    }
    
    .auth-container {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      padding: 20px;
      position: relative;
    }
    
    .auth-card {
      background-color: #fff;
      border-radius: 16px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.1);
      width: 100%;
      max-width: 1100px;
      display: flex;
      overflow: hidden;
      position: relative;
    }
    
    .auth-forms-container {
      background-color: #ffebee; 
      flex: 1;
      position: relative;
      overflow: hidden;
      height: 700px;
      padding: 40px;
    }
    
    .auth-image {
      background-color: #f9e8d2;
      flex: 1;
      padding: 40px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
      position: relative;
      overflow: hidden;
    }
    
    .auth-image-content {
      position: relative;
      z-index: 2;
      transition: transform 0.6s ease-in-out;
    }
    
    .auth-image-slide {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      padding: 40px;
      text-align: center;
      transform: translateX(100%);
      transition: transform 0.6s ease-in-out;
    }
    
    .auth-form {
      position: absolute;
      top: 0;
      width: 100%;
      height: 100%;
      padding: 40px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      transition: transform 0.6s ease-in-out;
    }
    
    .login-form {
      left: 0;
      transform: translateX(0);
    }
    
    .register-form {
      left: 0;
      transform: translateX(100%);
    }
    
    .auth-logo {
      font-size: 24px;
      text-align: center;
      margin-bottom: 30px;
    }
    
    .auth-title {
      font-size: 30px;
      font-weight: bold;
      margin-bottom: 10px;
      color: #333;
    }
    
    .auth-subtitle {
      color: #666;
      margin-bottom: 30px;
    }
    
    .form-control {
      border-radius: 8px;
      padding: 12px;
      height: auto;
      margin-bottom: 5px;
      border: 1px solid #ddd;
    }
    
    .btn-auth {
      background-color: #6b2c70;
      border: none;
      border-radius: 8px;
      padding: 12px;
      font-weight: bold;
      color: white;
      margin-top: 15px;
    }
    
    .btn-auth:hover {
      background-color: #5a2460;
    }
    
    .separator {
      display: flex;
      align-items: center;
      text-align: center;
      margin: 20px 0;
      color: #999;
    }
    
    .separator::before, .separator::after {
      content: '';
      flex: 1;
      border-bottom: 1px solid #ddd;
    }
    
    .separator::before {
      margin-right: 10px;
    }
    
    .separator::after {
      margin-left: 10px;
    }
    
    .error-text {
      font-size: 12px;
      margin-bottom: 15px;
    }
    
    .auth-switch {
      text-align: center;
      margin-top: 20px;
    }
    
    .auth-link {
      color: #6b2c70;
      text-decoration: none;
      font-weight: bold;
      cursor: pointer;
    }
    
    .remember-forgot {
      display: flex;
      justify-content: space-between;
      margin: 15px 0;
    }
    
    .form-row {
      display: flex;
      gap: 15px;
      margin-bottom: 0;
    }
    
    .form-row .form-group {
      flex: 1;
    }
    
    @media (max-width: 992px) {
      .auth-card {
        flex-direction: column;
      }
      
      .auth-image, .auth-forms-container {
        padding: 30px;
      }
      
      .auth-forms-container {
        height: auto;
        min-height: 650px;
      }
      
      .form-row {
        flex-direction: column;
        gap: 0;
      }
    }

    .slide-to-register .login-form {
      transform: translateX(-100%);
    }
    
    .slide-to-register .register-form {
      transform: translateX(0);
    }
    
    .slide-to-register .auth-image-content {
      transform: translateX(-100%);
    }
    
    .slide-to-register .auth-image-slide {
      transform: translateX(0);
    }
    
    .floating-alert {
      position: fixed;
      top: 20px;
      right: 20px;
      z-index: 9999;
      max-width: 400px;
    }
  </style>
</head>
<body>
  <div class="floating-alert"></div>

  <div class="auth-container">
    <div class="auth-card">
      <div class="auth-forms-container">
        <!-- Login form -->
        <div class="auth-form login-form">
          <div class="auth-logo">
            <div style="font-size: 28px; display: flex; justify-content: center; align-items: center;">
              <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2px; width: 24px; height: 24px; margin-right: 10px;">
                <div style="background-color: #6b2c70; width: 10px; height: 10px;"></div>
                <div style="background-color: #6b2c70; width: 10px; height: 10px;"></div>
                <div style="background-color: #6b2c70; width: 10px; height: 10px;"></div>
                <div style="background-color: #6b2c70; width: 10px; height: 10px;"></div>
              </div>
              <b>PWL</b>_POS
            </div>
          </div>
          
          <h1 class="auth-title text-center">Masuk ke Aplikasi</h1>
          
          
          <form action="{{ url('login') }}" method="POST" id="form-login">
            @csrf
            <div class="form-group">
              <label for="username">Username</label>
              <input type="text" id="username" name="username" class="form-control" placeholder="Masukkan username Anda">
              <small id="error-username" class="error-text text-danger"></small>
            </div>
            
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan password Anda">
              <small id="error-password" class="error-text text-danger"></small>
            </div>
            
            <div class="remember-forgot">
              <div class="icheck-primary">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">Ingat Saya</label>
              </div>
              <a href="#" class="auth-link">Lupa Password?</a>
            </div>
            
            <button type="submit" class="btn btn-block btn-auth">Masuk</button>
            
            <div class="auth-switch">
              Belum punya akun? <a class="auth-link" id="switch-to-register">Buat akun</a>
            </div>
          </form>
        </div>
        
        <!-- Register form -->
        <div class="auth-form register-form">
          <div class="auth-logo">
            <div style="font-size: 28px; display: flex; justify-content: center; align-items: center;">
              <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2px; width: 24px; height: 24px; margin-right: 10px;">
                <div style="background-color: #6b2c70; width: 10px; height: 10px;"></div>
                <div style="background-color: #6b2c70; width: 10px; height: 10px;"></div>
                <div style="background-color: #6b2c70; width: 10px; height: 10px;"></div>
                <div style="background-color: #6b2c70; width: 10px; height: 10px;"></div>
              </div>
              <b>PWL</b>_POS
            </div>
          </div>
          
          <h1 class="auth-title text-center mb-4">Daftar Akun Pelanggan Baru</h1>
          
          <form action="{{ route('register.store') }}" method="POST" id="form-register">
            @csrf
            
            <div class="form-row">
              <div class="form-group">
                <label for="reg-username">Username</label>
                <input type="text" id="reg-username" name="username" class="form-control" placeholder="Pilih username Anda" required>
              </div>
              
              <div class="form-group">
                <label for="nama">Nama Lengkap</label>
                <input type="text" id="nama" name="nama" class="form-control" placeholder="Masukkan nama lengkap Anda" required>
              </div>
            </div>
            
            <div class="form-row">
              <div class="form-group">
                <label for="reg-password">Password</label>
                <input type="password" id="reg-password" name="password" class="form-control" placeholder="Buat password" required>
              </div>
              
              <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Konfirmasi password Anda" required>
              </div>
            </div>
            
            <button type="submit" class="btn btn-block btn-auth">Buat Akun</button>
            
            <div class="auth-switch">
              Sudah punya akun? <a class="auth-link" id="switch-to-login">Masuk</a>
            </div>
          </form>
        </div>
      </div>
      
      <div class="auth-image">
        <div class="auth-image-content">
          <h2 style="font-size: 32px; font-weight: bold; color: #6b2c70; margin-bottom: 20px;">Wujudkan Keinginan Anda menjadi nyata.</h2>
        </div>
        <div class="auth-image-slide">
          <h2 style="font-size: 32px; font-weight: bold; color: #6b2c70; margin-bottom: 20px;">Bergabunglah dengan komunitas kami</h2>
        </div>
      </div>
    </div>
  </div>

  <!-- jQuery -->
  <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
  <!-- Bootstrap 4 -->
  <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <!-- jquery-validation -->
  <script src="{{ asset('adminlte/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
  <script src="{{ asset('adminlte/plugins/jquery-validation/additional-methods.min.js') }}"></script>
  <!-- SweetAlert2 -->
  <script src="{{ asset('adminlte/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
  <!-- AdminLTE App -->
  <script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>

  <script>
    $(document).ready(function() {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      
      // Handle form switching
      $('#switch-to-register').click(function(e) {
        e.preventDefault();
        $('.auth-card').addClass('slide-to-register');
      });
      
      $('#switch-to-login').click(function(e) {
        e.preventDefault();
        $('.auth-card').removeClass('slide-to-register');
      });
      
      @if(session('success'))
        showFloatingAlert('success', 'Berhasil!', "{{ session('success') }}");
      @endif
      
      @if(session('error'))
        showFloatingAlert('error', 'Gagal!', "{{ session('error') }}");
      @endif
      
      @if($errors->any())
        showFloatingAlert('warning', 'Peringatan!', "{!! implode('<br>', $errors->all()) !!}");
      @endif

      $("#form-login").validate({
        rules: {
          username: {required: true, minlength: 4, maxlength: 20},
          password: {required: true, minlength: 6, maxlength: 20}
        },
        messages: {
          username: {
            required: "Username harus diisi",
            minlength: "Username minimal 4 karakter",
            maxlength: "Username maksimal 20 karakter"
          },
          password: {
            required: "Password harus diisi",
            minlength: "Password minimal 6 karakter",
            maxlength: "Password maksimal 20 karakter"
          }
        },
        submitHandler: function(form) {
          $.ajax({
            url: form.action,
            type: form.method,
            data: $(form).serialize(),
            success: function(response) {
              if(response.status) {
                showFloatingAlert('success', 'Berhasil', response.message);
                setTimeout(function() {
                  window.location = response.redirect;
                }, 1500);
              } else {
                $('.error-text').text('');
                $.each(response.msgField, function(prefix, val) {
                  $('#error-'+prefix).text(val[0]);
                });
                showFloatingAlert('error', 'Terjadi Kesalahan', response.message);
              }
            }
          });
          return false;
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
          error.addClass('invalid-feedback');
          element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
          $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
          $(element).removeClass('is-invalid');
        }
      });
      
      $("#form-register").validate({
        rules: {
          level_id: {required: true},
          username: {required: true, minlength: 4, maxlength: 20},
          nama: {required: true},
          password: {required: true, minlength: 6},
          password_confirmation: {required: true, equalTo: "#reg-password"}
        },
        messages: {
          level_id: {
            required: "Tipe akun harus dipilih"
          },
          username: {
            required: "Username harus diisi",
            minlength: "Username minimal 4 karakter",
            maxlength: "Username maksimal 20 karakter"
          },
          nama: {
            required: "Nama lengkap harus diisi"
          },
          password: {
            required: "Password harus diisi",
            minlength: "Password minimal 6 karakter"
          },
          password_confirmation: {
            required: "Konfirmasi password harus diisi",
            equalTo: "Konfirmasi password tidak cocok"
          }
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
          error.addClass('invalid-feedback');
          element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
          $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
          $(element).removeClass('is-invalid');
        }
      });
    });
    
    function showFloatingAlert(icon, title, text) {
      const alertHtml = `
        <div class="alert alert-${icon === 'success' ? 'success' : icon === 'error' ? 'danger' : 'warning'} alert-dismissible fade show">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <h5><i class="icon fas fa-${icon === 'success' ? 'check' : icon === 'error' ? 'ban' : 'exclamation-triangle'}"></i> ${title}</h5>
          ${text}
        </div>
      `;
      
      $('.floating-alert').html(alertHtml);
      
      setTimeout(function() {
        $('.floating-alert .alert').alert('close');
      }, 5000);
    }
  </script>
</body>
</html>