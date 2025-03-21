<!DOCTYPE html>
<html>
<head>
    <title>Update User</title>
</head>
<body>
    <h1>Form Update User</h1>
    <form method="post" action="/user/ubah_simpan/{{ $data->user_id }}">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        
        <label for="username">Username</label>
        <input type="text" name="username" placeholder="Masukkan Username" value="{{ $data->username }}">

        <label for="nama">Nama</label>
        <input type="text" name="nama" placeholder="Masukkan Nama" value="{{ $data->nama }}">

        <label for="password">Password</label>
        <input type="password" name="password" placeholder="Masukkan Password" value="{{ $data->password }}">

        <label for="level_id">Level ID</label>
        <input type="number" name="level_id" placeholder="Masukkan ID Level" value="{{ $data->level_id }}">
        <br><br>

        <input type="submit" class="btn btn-success" value="Ubah">
    </form>
</body>
</html>