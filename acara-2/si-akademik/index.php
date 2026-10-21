<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>SI Akademik</title>
</head>
<body>
    <h1>Selamat datang di SI Akademik</h1>

    <hr>

    <h2>Form Pencarian</h2>
    <form action="tugas_mandiri.php" method="GET">
        <label for="keyword">Cari Mahasiswa/Mata Kuliah:</label>
        <input type="text" id="keyword" name="keyword" required>
        <button type="submit">Cari</button>
    </form>

    <hr>

    <h2>Form Login</h2>
    <form action="tugas_mandiri.php" method="POST">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" required><br><br>
        
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>
        
        <button type="submit">Login</button>
    </form>

</body>
</html>