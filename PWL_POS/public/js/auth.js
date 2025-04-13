$(document).ready(function() {
    // Set CSRF token for AJAX requests
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
        
    // Login form validation and submission
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
    
    // Register form validation
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
  
  // Function to show floating alerts
  function showFloatingAlert(icon, title, text) {
    const alertHtml = `
      <div class="alert alert-${icon === 'success' ? 'success' : icon === 'error' ? 'danger' : 'warning'} alert-dismissible fade show">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <h5><i class="icon fas fa-${icon === 'success' ? 'check' : icon === 'error' ? 'ban' : 'exclamation-triangle'}"></i> ${title}</h5>
        ${text}
      </div>
    `;
    
    $('.floating-alert').html(alertHtml);
    
    // Auto dismiss after 5 seconds
    setTimeout(function() {
      $('.floating-alert .alert').alert('close');
    }, 5000);
  }