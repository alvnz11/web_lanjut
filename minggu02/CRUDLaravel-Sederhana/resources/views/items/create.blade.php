<!DOCTYPE html> <!-- Mendeklarasikan tipe dokumen HTML -->
<html>
<head>
    <title>Add Item</title> <!-- Menetapkan judul halaman -->
</head>
<body>
    <h1>Add Item</h1> <!-- Menampilkan judul utama -->
    
    <form action="{{ route('items.store') }}" method="POST"> <!-- Form untuk menambahkan item baru -->
        @csrf <!-- Menambahkan token CSRF untuk keamanan -->
        
        <label for="name">Name:</label> <!-- Label untuk input nama -->
        <input type="text" name="name" required> <!-- Input untuk nama, wajib diisi (required) -->
        <br>
        
        <label for="description">Description:</label> <!-- Label untuk input deskripsi -->
        <textarea name="description" required></textarea> <!-- Input textarea untuk deskripsi, wajib diisi (required) -->
        <br>
        
        <button type="submit">Add Item</button> <!-- Tombol untuk menambahkan item -->
    </form>
    
    <a href="{{ route('items.index') }}">Back to List</a> <!-- Link untuk kembali ke daftar item -->
</body>
</html>