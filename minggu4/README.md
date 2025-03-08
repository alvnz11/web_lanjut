# Laporan Praktikum Jobsheet 04

## Identitas
- **Mata Kuliah**: Pemrograman Web Lanjut 
- **Program Studi**: Teknik Informatika
- **Semester**: 4 
- **Praktikum**: Jobsheet 04 – Model dan Eloquent ORM
- **Nama**: Alvanza Saputra Yudha
- **NIM**: 2341720182
- **Kelas**: TI-2A

---

## A. Properti $fillable dan $guarded

### Praktikum 1 - $fillable

1. **Menambahkan $fillable pada model UserModel.php**
   ```php
   protected $fillable = ['username', 'nama', 'password', 'level_id'];
   ```

2. **Mengubah UserController.php untuk menambahkan data baru**
   ```php
   $data = [
       'username' => 'customer-1',
       'nama' => 'Pelanggan',
       'password' => Hash::make('12345'),
       'level_id' => 4
   ];
   UserModel::create($data);
   ```

3. **Hasil dari penggunaan fillable pada model**
   ![alt text](image.png)
   Data pada tabel user bertambah

4. **Mengubah $fillable dan menjalankan kembali**
   ```php
   protected $fillable = ['username', 'nama', 'level_id'];
   ```

5. **Hasil dari perubahan $fillable**
   ![alt text](image-1.png)
   Terjadi error karena password tidak dituliskan dalam fillable

---

## B. Retrieving Single Models

### Praktikum 2.1 - Retrieving Single Models

1. **Mengubah UserController.php untuk mengambil single model dengan find**
   ```php
   $user = UserModel::find(1);
   ```

2. **Mengubah user.blade.php untuk menampilkan single model**
   ```php
   <p>{{ $user->username }} - {{ $user->nama }}</p>
   ```

3. **Hasil dari penggunaan find**
   ![alt text](image-2.png)
   Program hanya menampilkan 1 data dengan id 1 karena kita mengisi fungsi find dengan angka 1

4. **Menggunakan method first() pada UserController.php**
   ```php
   $user = UserModel::where('level_id', 1)->first();
   ```

5. **Hasil penggunaan method first()**
   ![alt text](image-2.png)
   Program menampilkan data dengan user_id 1 menggunakan fungsi where

6. **Menggunakan method firstWhere()**
   ```php
   $user = UserModel::firstWhere('level_id', 2);
   ```

7. **Hasil penggunaan method firstWhere()**
    ![alt text](image-2.png)
    Program menampilkan data dengan user_id 1 menggunakan fungsi firstWhere

8. **Implementasi metode findOr**
   ```php
   $user = UserModel::findOr(1, ['username', 'nama'], function () {
       abort(404);
   });
   ```

9. **Hasil penggunaan findOr**
   ![alt text](image-4.png)
   Program hanya menampilkan username dan nama dari user_id 1

9. **Hasil penggunaan findOr untuk data yang tidak ditemukan**
   ![alt text](image-5.png)
   Hasilnya error 404 karena program tidak menemukan data dengan id 20

### Praktikum 2.2 - Not Found Exceptions

1. **Implementasi metode findOrFail**
   ```php
   $user = UserModel::findOrFail(1);
   ```
   ![alt text](image/gambar_2_12.png)

2. **Hasil penggunaan findOrFail**
   ![alt text](image/gambar_2_13.png)

3. **Implementasi metode findOrFail untuk data yang tidak ada**
   ```php
   $user = UserModel::findOrFail(20);
   ```
   ![alt text](image/gambar_2_14.png)

4. **Hasil error dari findOrFail**
   ![alt text](image/gambar_2_15.png)

### Praktikum 2.3 - Retreiving Aggregrates

1. **Menggunakan metode count() pada Model**
   ```php
   $user = UserModel::count();
   ```
   ![alt text](image/gambar_2_16.png)

2. **Hasil penggunaan metode count()**
   ![alt text](image/gambar_2_17.png)

3. **Menampilkan jumlah user pada halaman browser**
   ```php
   <p>Jumlah user: {{ $user }}</p>
   ```
   ![alt text](image/gambar_2_18.png)

### Praktikum 2.4 - Retreiving or Creating Models

1. **Implementasi metode firstOrCreate**
   ```php
   $user = UserModel::firstOrCreate(
       ['username' => 'manager'],
       ['nama' => 'Manager', 'password' => Hash::make('12345'), 'level_id' => 2]
   );
   ```
   ![alt text](image/gambar_2_19.png)

2. **Hasil penggunaan firstOrCreate**
   ![alt text](image/gambar_2_20.png)

3. **Hasil data di database setelah firstOrCreate**
   ![alt text](image/gambar_2_21.png)

4. **Implementasi metode firstOrCreate untuk data yang sudah ada**
   ```php
   $user = UserModel::firstOrCreate(
       ['username' => 'manager'],
       ['nama' => 'Manager Baru', 'password' => Hash::make('12345'), 'level_id' => 2]
   );
   ```
   ![alt text](image/gambar_2_22.png)

5. **Hasil firstOrCreate untuk data yang sudah ada**
   ![alt text](image/gambar_2_23.png)

6. **Implementasi metode firstOrNew**
   ```php
   $user = UserModel::firstOrNew(
       ['username' => 'kasir2'],
       ['nama' => 'Kasir Dua', 'password' => Hash::make('12345'), 'level_id' => 3]
   );
   ```
   ![alt text](image/gambar_2_24.png)

7. **Hasil penggunaan firstOrNew tanpa save()**
   ![alt text](image/gambar_2_25.png)

8. **Implementasi metode firstOrNew dengan save()**
   ```php
   $user = UserModel::firstOrNew(
       ['username' => 'kasir2'],
       ['nama' => 'Kasir Dua', 'password' => Hash::make('12345'), 'level_id' => 3]
   );
   $user->save();
   ```
   ![alt text](image/gambar_2_26.png)

9. **Hasil data di database setelah firstOrNew dengan save()**
   ![alt text](image/gambar_2_27.png)

### Praktikum 2.5 - Attribute Changes

1. **Implementasi metode isDirty dan isClean**
   ```php
   $user = UserModel::create([
       'username' => 'manager2',
       'nama' => 'Manager Dua',
       'password' => Hash::make('12345'),
       'level_id' => 2
   ]);
   
   $user->username = 'manager3';
   
   $isDirty = $user->isDirty();
   $isDirtyUsername = $user->isDirty('username');
   $isDirtyCreatedAt = $user->isDirty('created_at');
   $isClean = $user->isClean();
   $isCleanUsername = $user->isClean('username');
   $isCleanCreatedAt = $user->isClean('created_at');
   ```
   ![alt text](image/gambar_2_28.png)

2. **Hasil penggunaan isDirty dan isClean**
   ![alt text](image/gambar_2_29.png)

3. **Implementasi metode wasChanged**
   ```php
   $user = UserModel::create([
       'username' => 'manager4',
       'nama' => 'Manager Empat',
       'password' => Hash::make('12345'),
       'level_id' => 2
   ]);
   
   $user->username = 'manager5';
   $user->save();
   
   $wasChanged = $user->wasChanged();
   $wasChangedUsername = $user->wasChanged('username');
   $wasChangedPassword = $user->wasChanged('password');
   ```
   ![alt text](image/gambar_2_30.png)

4. **Hasil penggunaan wasChanged**
   ![alt text](image/gambar_2_31.png)

### Praktikum 2.6 - Create, Read, Update, Delete (CRUD)

1. **Membuat tampilan untuk Read pada user.blade.php**
   ```php
   <table class="table">
       <thead>
           <tr>
               <th>ID</th>
               <th>Username</th>
               <th>Nama</th>
               <th>Level</th>
               <th>Aksi</th>
           </tr>
       </thead>
       <tbody>
           @foreach($data as $d)
           <tr>
               <td>{{ $d->user_id }}</td>
               <td>{{ $d->username }}</td>
               <td>{{ $d->nama }}</td>
               <td>{{ $d->level_id }}</td>
               <td>
                   <a href="{{ url('/user/ubah', $d->user_id) }}" class="btn btn-warning">Ubah</a>
                   <a href="{{ url('/user/hapus', $d->user_id) }}" class="btn btn-danger">Hapus</a>
               </td>
           </tr>
           @endforeach
       </tbody>
   </table>
   ```
   ![alt text](image/gambar_2_32.png)

2. **Update controller untuk Read**
   ```php
   public function index()
   {
       $data = UserModel::all();
       return view('user', ['data' => $data]);
   }
   ```
   ![alt text](image/gambar_2_33.png)

3. **Hasil tampilan Read**
   ![alt text](image/gambar_2_34.png)

4. **Membuat form untuk Create pada user_tambah.blade.php**
   ```php
   <form method="post" action="{{ url('/user/tambah_simpan') }}">
       @csrf
       <div class="form-group">
           <label>Username</label>
           <input type="text" name="username" class="form-control">
       </div>
       <div class="form-group">
           <label>Nama</label>
           <input type="text" name="nama" class="form-control">
       </div>
       <div class="form-group">
           <label>Password</label>
           <input type="password" name="password" class="form-control">
       </div>
       <div class="form-group">
           <label>Level ID</label>
           <input type="number" name="level_id" class="form-control">
       </div>
       <div class="form-group">
           <button type="submit" class="btn btn-primary">Simpan</button>
       </div>
   </form>
   ```
   ![alt text](image/gambar_2_35.png)

5. **Menambahkan route untuk halaman tambah**
   ```php
   Route::get('/user/tambah', [UserController::class, 'tambah']);
   ```
   ![alt text](image/gambar_2_36.png)

6. **Menambahkan method tambah pada UserController**
   ```php
   public function tambah()
   {
       return view('user_tambah');
   }
   ```
   ![alt text](image/gambar_2_37.png)

7. **Hasil tampilan form Create**
   ![alt text](image/gambar_2_38.png)

8. **Menambahkan route untuk proses penyimpanan data**
   ```php
   Route::post('/user/tambah_simpan', [UserController::class, 'tambah_simpan']);
   ```
   ![alt text](image/gambar_2_39.png)

9. **Menambahkan method tambah_simpan pada UserController**
   ```php
   public function tambah_simpan(Request $request)
   {
       UserModel::create([
           'username' => $request->username,
           'nama' => $request->nama,
           'password' => Hash::make($request->password),
           'level_id' => $request->level_id
       ]);
       return redirect('/user');
   }
   ```
   ![alt text](image/gambar_2_40.png)

10. **Hasil setelah Create data user baru**
    ![alt text](image/gambar_2_41.png)

11. **Membuat form untuk Update pada user_ubah.blade.php**
    ```php
    <form method="post" action="{{ url('/user/ubah_simpan', $data->user_id) }}">
        @csrf
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" class="form-control" value="{{ $data->username }}">
        </div>
        <div class="form-group">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" value="{{ $data->nama }}">
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control">
        </div>
        <div class="form-group">
            <label>Level ID</label>
            <input type="number" name="level_id" class="form-control" value="{{ $data->level_id }}">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
    ```
    ![alt text](image/gambar_2_42.png)

12. **Menambahkan route untuk halaman ubah**
    ```php
    Route::get('/user/ubah/{id}', [UserController::class, 'ubah']);
    ```
    ![alt text](image/gambar_2_43.png)

13. **Menambahkan method ubah pada UserController**
    ```php
    public function ubah($id)
    {
        $user = UserModel::find($id);
        return view('user_ubah', ['data' => $user]);
    }
    ```
    ![alt text](image/gambar_2_44.png)

14. **Hasil tampilan form Update**
    ![alt text](image/gambar_2_45.png)

15. **Menambahkan route untuk proses update data**
    ```php
    Route::post('/user/ubah_simpan/{id}', [UserController::class, 'ubah_simpan']);
    ```
    ![alt text](image/gambar_2_46.png)

16. **Menambahkan method ubah_simpan pada UserController**
    ```php
    public function ubah_simpan(Request $request, $id)
    {
        $user = UserModel::find($id);
        $user->username = $request->username;
        $user->nama = $request->nama;
        if (!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }
        $user->level_id = $request->level_id;
        $user->save();
        return redirect('/user');
    }
    ```
    ![alt text](image/gambar_2_47.png)

17. **Hasil setelah Update data user**
    ![alt text](image/gambar_2_48.png)

18. **Menambahkan route untuk Delete**
    ```php
    Route::get('/user/hapus/{id}', [UserController::class, 'hapus']);
    ```
    ![alt text](image/gambar_2_49.png)

19. **Menambahkan method hapus pada UserController**
    ```php
    public function hapus($id)
    {
        $user = UserModel::find($id);
        $user->delete();
        return redirect('/user');
    }
    ```
    ![alt text](image/gambar_2_50.png)

20. **Hasil setelah Delete data user**
    ![alt text](image/gambar_2_51.png)

### Praktikum 2.7 - Relationships

1. **Menambahkan relasi pada model UserModel.php**
   ```php
   public function level()
   {
       return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
   }
   ```
   ![alt text](image/gambar_2_52.png)

2. **Mengubah UserController.php untuk menggunakan relasi level**
   ```php
   public function index()
   {
       $data = UserModel::with('level')->get();
       return view('user', ['data' => $data]);
   }
   ```
   ![alt text](image/gambar_2_53.png)

3. **Hasil dari penggunaan relasi level**
   ![alt text](image/gambar_2_54.png)

4. **Mengubah tampilan user untuk menampilkan level**
   ```php
   <td>{{ $d->level->level_nama }}</td>
   ```
   ![alt text](image/gambar_2_55.png)

5. **Hasil tampilan dengan relasi level**
   ![alt text](image/gambar_2_56.png)

---

## C. Jawaban Pertanyaan

1. **Pada Praktikum 1, apa perbedaan antara $fillable dan $guarded pada model Laravel?**
   - $fillable adalah daftar atribut yang diizinkan untuk assignment massal (mass assignment), sedangkan $guarded adalah daftar atribut yang tidak diizinkan untuk assignment massal. Keduanya berfungsi untuk keamanan mass assignment, tetapi cara kerjanya berkebalikan.

2. **Apa kegunaan dari property $table pada model di Laravel?**
   - Property $table digunakan untuk menentukan nama tabel dalam database yang terkait dengan model. Jika tidak ditentukan, Laravel akan menggunakan bentuk jamak snake_case dari nama model.

3. **Pada Praktikum 2.1, apa perbedaan antara method find() dan first() pada model Eloquent Laravel?**
   - Method find() digunakan untuk mencari record berdasarkan primary key, sedangkan first() digunakan untuk mengambil record pertama yang sesuai dengan query.

4. **Pada Praktikum 2.2, jelaskan perbedaan antara findOrFail() dan firstOrFail() pada Laravel?**
   - Keduanya akan melempar ModelNotFoundException jika data tidak ditemukan. findOrFail() mencari berdasarkan primary key, sedangkan firstOrFail() mengambil record pertama yang sesuai dengan query.

5. **Pada Praktikum 2.4, apa perbedaan antara firstOrCreate() dan firstOrNew()?**
   - firstOrCreate() akan mencari record atau membuat dan menyimpannya ke database jika tidak ditemukan, sedangkan firstOrNew() mencari record atau membuat instance model baru tanpa menyimpannya ke database (perlu memanggil save() secara manual).

6. **Pada Praktikum 2.5, jelaskan perbedaan metode isDirty(), isClean(), dan wasChanged() dalam model Eloquent?**
   - isDirty(): Memeriksa apakah atribut model telah diubah sejak model diambil
   - isClean(): Kebalikan dari isDirty(), memeriksa apakah atribut model tidak berubah sejak diambil
   - wasChanged(): Memeriksa apakah atribut model berubah saat terakhir kali model disimpan

7. **Pada Praktikum 2.7, jelaskan mengapa kita perlu mendefinisikan relasi belongsTo() untuk mengakses model induk?**
   - Relasi belongsTo() diperlukan untuk mendefinisikan hubungan invers dari hasOne() atau hasMany(), yang memungkinkan model anak untuk mengakses model induk melalui foreign key.

8. **Apa perbedaan utama antara metode hasOne() dan hasMany() dalam mendefinisikan relasi di Laravel?**
   - hasOne() mendefinisikan relasi satu-ke-satu di mana model memiliki tepat satu model terkait, sedangkan hasMany() mendefinisikan relasi satu-ke-banyak di mana model memiliki banyak model terkait.

9. **Bagaimana cara mengakses data relasi (eager loading) agar menghindari masalah N+1 query di Laravel?**
   - Menggunakan metode with() untuk melakukan eager loading relasi, contoh: UserModel::with('level')->get()

10. **Apa keuntungan menggunakan Eloquent ORM dibandingkan dengan Query Builder atau DB Facade?**
    - Eloquent ORM mempermudah pengelolaan relasi antar tabel, memiliki banyak fitur yang lebih OOP, menyediakan event dan observer, serta lebih ekspresif dan mudah dibaca.

---