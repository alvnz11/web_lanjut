# Laporan Praktikum Jobsheet 05

## Identitas

- **Mata Kuliah**: Pemrograman Web Lanjut
- **Program Studi**: Teknik Informatika
- **Semester**: 4
- **Praktikum**: Jobsheet 05 – Blade View, Web Templating (AdminLTE), DataTables
- **Nama**: Alvanza Saputra Yudha
- **NIM**: 2341720182
- **Kelas**: TI-2A

---

## Praktikum 1 - Integrasi AdminLTE

### Langkah-langkah:
1. **Menginstal AdminLTE**
   - Jalankan perintah berikut untuk menginstal AdminLTE:
    ```bash
    composer require jeroennoten/laravel-adminlte

    php artisan adminlte:install
    ```

2. **Mengonfigurasi Layout AdminLTE**
   - Buat file layout di `resources/views/layouts/app.blade.php`:
    ```php
    @extends('adminlte::page')
    @section('title', 'Dashboard')
    @section('content')
        <h1>Selamat datang di Dashboard</h1>
    @endsection
    ```

2. **Mengonfigurasi halaman welcome**
   - Buat file layout di `resources/views/welcome.blade.php`:
    ```php
    @extends('layout.app')

    {{-- Customize layout sections --}}
    @section('subtitle', 'Welcome')
    @section('content_header_title', 'Home')
    @section('content_header_subtitle', 'Welcome')

    {{-- Content body: main page content --}}
    @section('content_body')
        <p>Welcome to this beautiful admin panel.</p>
    @stop

    {{-- Push extra CSS --}}
    @push('css')
        {{-- Add here extra stylesheets --}}
        {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
    @endpush

    {{-- Push extra scripts --}}
    @push('js')
        <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
    @endpush
    ```
    - Hasil

    ![alt text](image/image.png)


---

## Praktikum 2 - Integrasi DataTables

### Langkah-langkah:
1. **Menginstal Yajra DataTables**
   - Jalankan perintah berikut:
    ```bash
    composer require laravel/ui --dev

    composer require yajra/laravel-datatables:^10.0

    npm i laravel-datatables-vite --save-dev

    npm install -D sass
    ```

2. **Membuat KategoriDatable**
    ```php
    public function getColumns(): array
    {
        return [
            Column::make('kategori_id')->addClass('text-start'),
            Column::make('kategori_kode'),
            Column::make('kategori_nama'),
            Column::make('created_at'),
            Column::make('updated_at'),
        ];
    }
    ```

3. **Update Model Kategori**
    ```php
    class KategoriModel extends Model
    {
        use HasFactory;

        protected $table = 'm_kategori';
        protected $primaryKey = 'kategori_id';

        protected $fillable = ['kategori_kode', 'kategori_nama'];
        

        public function barang(): HasMany
        {
            return $this->hasMany(BarangModel::class, 'barang_id', 'barang_id');
        }
    }
    ```

4. **Ubah Controller Kategori**
    ```php
    public function index(KategoriDataTable $dataTable)
    {
        return $dataTable->render('kategori.index');
    }
    ```

5. **Membuat Tabel Data dengan DataTables**
   - Buat view di `resources/views/kategori/index.blade.php`:
    ```php
    @extends('layout.app')

        {{-- Customize layout sections --}}

        @section('subtitle', 'Kategori')
        @section('content_header_title', 'Home')
        @section('content_header_subtitle', 'Kategori')

        @section('content')
            <div class="container">
                <div class="card">
                    <div class="card-header">Manage Kategori</div>
                    <div class="card-body">
                        {{ $dataTable->table() }}
                    </div>
                </div>
            </div>
        @endsection

        @push('scripts')
            {{ $dataTable->scripts() }}
        @endpush

    @endsection
    ```

   - Tambahkan route di `routes/web.php`:
    ```php
    Route::get('/kategori/data', [KategoriController::class, 'data'])->name('kategori.data');
    ```

   - Hasil 

   ![alt text](image/image-1.png)


## Praktikum 3 - – Membuat form kemudian menyimpan data dalam database

1. **Menyesuaikan routing**
    ```php
    Route::post('/kategori', [KategoriController::class, 'store']);
    Route::get('/kategori/create', [KategoriController::class, 'create']);
    ```

2. **Menambahkan 2 function di KategoriController**
    ```php
    public function create() {
        return view('kategori.create');
    }

    public function store(Request $request) {
        KategoriModel::crete([
            'kategori_kode' => $request->kodeKategori,
            'kategori_nama' => $request->namaKategori,
        ]);
        return redirect('/kategori');
    }
    ```

3. **Membuat form untuk create**
    ```php
    <form method="post" action="../kategori">
        <div class="card-body">
            <div class="form-group">
                <label for="kodeKategori">Kode Kategori</label>
                <input type="text" class="form-control" id="kodeKategori" name="kodeKategori" placeholder>
            </div>
            <div class="form-group">
                <label for="namaKategori">Nama Kategori</label>
                <input type="text" class="form-control" id="namaKategori" name="namaKategori" placeholder>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
    ```

    - Hasil

    ![alt text](image/image-2.png)

    ![alt text](image/image-3.png)
    
---

## Tugas Praktikum

1. Tambahkan button Add di halam manage kategori, yang mengarah ke create kategori baru.
    - Menambahkan div untuk tombol add di kategori/index.blade.php

    ```php
    <div class="d-flex justify-content-between align-items-center p-3">
        <span>Manage Kategori</span>
        <a href="{{ route('kategori.create') }}" class="btn btn-primary">Add</a>
    </div>
    ```

    - Hasil

    ![alt text](image/image-4.png)

2. Tambahkan menu untuk halaman manage kategori, di daftar menu navbar
    - Menambahkan data di config/adminlte.php
    ```php
    [
        'text' => 'Kategori',
        'url' => 'kategori',
        'icon' => 'fas fa-tags',
    ],
    ```

    - Hasil

    ![alt text](image/image-5.png)

3. Tambahkan action edit di datatables dan buat halaman edit serta controllernya
    - Menambahkan 2 function di Controller
    ```php
        public function edit($id)
    {
        $kategori = KategoriModel::findOrFail($id);
        return view('kategori.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kodeKategori' => 'required|max:255',
            'namaKategori' => 'required|max:255',
        ]);

        $kategori = KategoriModel::findOrFail($id);
        $kategori->update([
            'kategori_kode' => $request->kodeKategori, 
            'kategori_nama' => $request->namaKategori,
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui');
    }
    ```

    - Menambahkan form edit
    ```php
    <form action="{{ route('kategori.update', $kategori->kategori_id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="kodeKategori">Kode Kategori</label>
            <input type="text" class="form-control" name="kodeKategori" id="kodeKategori" value="{{ $kategori->kategori_kode }}" required>
        </div>

        <div class="form-group">
            <label for="namaKategori">Nama Kategori</label>
            <input type="text" class="form-control" name="namaKategori" id="namaKategori" value="{{ $kategori->kategori_nama }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>
    ```

    - Hasil

    ![alt text](image/image-6.png)

    ![alt text](image/image-7.png)



4. Tambahkan action delete di datatables serta controllernya
    - Menambahkan function delete di controller
    ```php
    public function destroy($id)
    {
        $kategori = KategoriModel::findOrFail($id);
        $kategori->delete();

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus');
    }
    ```

    - Menambah button di index
    ```php
    ->addColumn('action', function ($row) {
        $editUrl = route('kategori.edit', ['id' => $row->kategori_id]);
        $deleteUrl = route('kategori.destroy', ['id' => $row->kategori_id]);

        return '<a href="'.$editUrl.'" class="btn btn-warning btn-sm">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <form action="'.$deleteUrl.'" method="POST" style="display:inline;" onsubmit="return confirm(\'Apakah Anda yakin ingin menghapus kategori ini?\');">
                    '.csrf_field().'
                    '.method_field("DELETE").'
                    <button type="submit" class="btn btn-danger btn-sm">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                </form>';
    })
    ```

    - Hasil

    ![alt text](image/image-9.png)

    ![alt text](image/image-10.png)

---