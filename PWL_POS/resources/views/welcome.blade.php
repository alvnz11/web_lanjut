<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PWL POS - Sistem Manajemen Inventori & Penjualan</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
    <style>
        body {
            background-color: #f9e8d2;
            font-family: 'Source Sans Pro', sans-serif;
        }
        
        .landing-container {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        .hero-section {
            padding: 100px 0;
            background-color: #6b2c70;
            color: white;
        }
        
        .hero-title {
            font-size: 48px;
            font-weight: bold;
        }
        
        .features-section {
            padding: 80px 0;
            background-color: #f9e8d2;
        }
        
        .feature-card {
            height: 100%;
            transition: transform 0.3s;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
        }
        
        .feature-icon {
            font-size: 48px;
            margin-bottom: 20px;
            color: #6b2c70;
        }
        
        .btn-login {
            background-color: #ffffff;
            color: #6b2c70;
            font-weight: bold;
            padding: 10px 30px;
            font-size: 18px;
            border-radius: 30px;
            transition: all 0.3s;
            border: 2px solid #f9e8d2;
        }
        
        .btn-login:hover {
            background-color: transparent;
            color: #f9e8d2;
            border: 2px solid #f9e8d2;
        }
        
        .logo {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .logo-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2px;
            width: 24px;
            height: 24px;
            margin-right: 10px;
        }
        
        .logo-grid div {
            background-color: #f9e8d2;
            width: 10px;
            height: 10px;
        }
    </style>
</head>
<body>
    <div class="landing-container">
        <section class="hero-section">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="mb-4">
                            <div class="logo">
                                <div class="logo-grid">
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                </div>
                                <h1><b>PWL_POS</b></h1>
                            </div>
                        </div>
                        <h1 class="hero-title mb-4">UTS Semester 4 Pemrograman Web Lanjut</h1>
                        <p class="lead mb-5">Sistem Transaksi Penjualan Barang dengan Manajemen Inventori</p>
                        <a href="{{ url('/login') }}" class="btn btn-login btn-lg">Login</a>
                    </div>
                    <div class="col-md-6 text-center">
                        <img src="{{ asset('adminlte/dist/img/AdminLTELogo.png') }}" alt="POS System" class="img-fluid" style="max-width: 300px;">
                    </div>
                </div>
            </div>
        </section>
        
        <section class="features-section">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="mb-3">Fitur-Fitur</h2>
                </div>
                
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <div class="card feature-card h-100">
                            <div class="card-body text-center p-4">
                                <div class="feature-icon">
                                    <i class="fas fa-box"></i>
                                </div>
                                <h4 class="text-center">Manajemen Inventori</h4>
                                <p class="card-text">Kelola stok barang dengan mudah, pantau persediaan, dan hindari kehabisan stok.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4 mb-4">
                        <div class="card feature-card h-100">
                            <div class="card-body text-center p-4">
                                <div class="feature-icon">
                                    <i class="fas fa-cash-register"></i>
                                </div>
                                <h4 class="text-center">Transaksi Penjualan</h4>
                                <p class="card-text">Proses transaksi dengan cepat dan efisien. Buat invoice dan kelola pesanan dengan mudah.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4 mb-4">
                        <div class="card feature-card h-100">
                            <div class="card-body text-center p-4">
                                <div class="feature-icon">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <h4 class="text-center">Laporan & Analisis</h4>
                                <p class="card-text">Dapatkan insight bisnis melalui laporan penjualan, produk terlaris, dan analisis inventori.</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row mt-4">
                    <div class="col-md-4 mb-4">
                        <div class="card feature-card h-100">
                            <div class="card-body text-center p-4">
                                <div class="feature-icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <h4 class="text-center">Manajemen Pengguna</h4>
                                <p class="card-text">Atur akses pengguna dengan sistem role-based, untuk keamanan data bisnis Anda.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4 mb-4">
                        <div class="card feature-card h-100">
                            <div class="card-body text-center p-4">
                                <div class="feature-icon">
                                    <i class="fas fa-truck"></i>
                                </div>
                                <h4 class="text-center">Manajemen Supplier</h4>
                                <p class="card-text">Kelola supplier dan hubungan bisnis dengan sistem yang terintegrasi dengan inventori.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4 mb-4">
                        <div class="card feature-card h-100">
                            <div class="card-body text-center p-4">
                                <div class="feature-icon">
                                    <i class="fas fa-mobile-alt"></i>
                                </div>
                                <h4 class="text-center">Responsif & Mobile</h4>
                                <p class="card-text">Akses sistem dari berbagai perangkat, baik dari komputer, tablet, maupun smartphone.</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="text-center mt-5">
                    <a href="{{ url('/login') }}" class="btn btn-login btn-lg">Daftar Sekarang</a>
                </div>
            </div>
        </section>
        
        <footer class="bg-dark text-white text-center py-4">
            <div class="container">
                <p class="mb-0">&copy; 2025 PWL_POS. Alvanza Saputra Yudha.</p>
            </div>
        </footer>
    </div>
    
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>