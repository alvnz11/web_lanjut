<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profil Pengguna</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .profile-container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 350px;
        }

        h2 {
            color: #333;
            margin-bottom: 15px;
        }

        p {
            font-size: 16px;
            margin: 5px 0;
            color: #555;
        }

        .back-button-container {
            margin-top: 20px;
        }

        .btn-back {
            text-decoration: none;
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            transition: 0.3s;
            display: inline-block;
        }

        .btn-back:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <h2>Profil Pengguna</h2>
        <p><strong>ID:</strong> {{ $id }}</p>
        <p><strong>Nama:</strong> {{ $name }}</p>
        
        <div class="back-button-container">
            <a href="{{ url('/category') }}" class="btn-back">Kembali ke Category</a>
        </div>
    </div>
</body>
</html>
