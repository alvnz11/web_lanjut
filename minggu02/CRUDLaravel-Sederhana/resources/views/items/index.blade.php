<!DOCTYPE html> <!-- Mendeklarasikan tipe dokumen HTML -->
<html>
<head>
    <title>Item List</title> <!-- Menetapkan judul halaman -->
</head>
<body>
    <h1>Items</h1> <!-- Menampilkan judul utama -->
    
    @if(session('success')) <!-- Mengecek apakah ada pesan sukses dalam sesi -->
        <p>{{ session('success') }}</p> <!-- Menampilkan pesan jika sesi sukses -->
    @endif
    
    <a href="{{ route('items.create') }}">Add Item</a> <!-- Link untuk menambahkan item baru -->
    
    <ul>
        @foreach ($items as $item) <!-- Melakukan perulangan untuk item dalam daftar -->
            <li>
                {{ $item->name }} - <!-- Menampilkan nama item -->
                <a href="{{ route('items.edit', $item) }}">Edit</a> <!-- Link untuk mengedit item -->
                
                <form action="{{ route('items.destroy', $item) }}" method="POST" style="display:inline;"> <!-- Form untuk menghapus item -->
                    @csrf <!-- Menambahkan token CSRF untuk keamanan -->
                    @method('DELETE') <!-- Menggunakan method DELETE -->
                    <button type="submit">Delete</button> <!-- Button untuk menghapus item -->
                </form>
            </li>
        @endforeach
    </ul>
</body>
</html>
