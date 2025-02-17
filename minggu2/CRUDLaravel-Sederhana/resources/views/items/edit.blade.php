<!DOCTYPE html> <!-- Mendeklarasikan tipe dokumen HTML -->
<html>
<head>
    <title>Edit Item</title> <!-- Menetapkan judul halaman -->
</head>
<body>
    <h1>Edit Item</h1> <!-- Menampilkan judul -->
    
    <form action="{{ route('items.update', $item) }}" method="POST"> <!-- Form untuk update item -->
        @csrf <!-- Menambahkan token CSRF untuk keamanan -->
        @method('PUT') <!-- Menggunakan metode PUT untuk update data -->
        
        <label for="name">Name:</label> <!-- Label untuk input nama -->
        <input type="text" name="name" value="{{ $item->name }}" required> <!-- Input untuk nama items -->
        <br>
        
        <label for="description">Description:</label> <!-- Label untuk input deskripsi -->
        <textarea name="description" required>{{ $item->description }}</textarea> <!-- Textarea untuk deskripsi items -->
        <br>
        
        <button type="submit">Update Item</button> <!-- Tombol untuk memperbarui item -->
    </form>
    
    <a href="{{ route('items.index') }}">Back to List</a> <!-- Link untuk kembali ke daftar item -->
</body>
</html>
