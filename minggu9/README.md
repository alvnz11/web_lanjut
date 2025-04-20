# Laporan Praktikum Jobsheet 10

## Identitas

- **Mata Kuliah**: Pemrograman Web Lanjut  
- **Program Studi**: Teknik Informatika  
- **Semester**: 4  
- **Praktikum**: Jobsheet 10 – RESTFUL API
- **Nama**: Alvanza Saputra Yudha  
- **NIM**: 2341720182  
- **Kelas**: TI-2A  

---

## Praktikum 1 - Membuat RESTful API Register

### Langkah-langkah:
1. **Mendownload aplikasi postman(tetapi disini saya menggunakan extension Thunder Client di VSCode sebagai gantinya)**
2. **Menginstall JWT**
    ```
    composer require tymon/jwt-auth:2.1.1
    ```
3. **Publish konfigurasi**
    ```
    php artisan jwt:secret
    ```
3. **Membuat secret key**
    ```
    php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
    ```
4. **Memodifikasi `config/auth.php`**
4. **Menambah kode di `UserModel.php`**
4. **Membuat controller di `controller/Api/RegisterController`**
7. **Hasil**
    - Uji coba tanpa data

        ![alt text](image.png)

    - Uji coba dengan data

        ![alt text](image-1.png)
