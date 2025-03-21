<!DOCTYPE html>
<html>
<head>
    <title>Tambah User</title>
</head>
<body>
    <h1>Form Tambah User</h1>
    <form method="post" action="/user/tambah_simpan">
        {{ csrf_field() }}
        
        <label for="username">Username</label>
        <input type="text" name="username" placeholder="Masukkan Username">

        <label for="nama">Nama</label>
        <input type="text" name="nama" placeholder="Masukkan Nama">

        <label for="password">Password</label>
        <input type="password" name="password" placeholder="Masukkan Password">

        <label for="level_id">Level ID</label>
        <input type="number" name="level_id" placeholder="Masukkan ID Level">
        <br><br>

        <input type="submit" class="btn btn-success" value="Simpan">
    </form>
</body>
</html>