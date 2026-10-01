<?php

$method = $_SERVER['REQUEST_METHOD'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cek Method Request</title>
</head>
<body>
    <h2>Deteksi Method Request</h2>

    <p>Method yang digunakan saat ini: <strong><?php echo htmlspecialchars($method); ?></strong></p>

    <?php if ($method === 'GET'): ?>
        <p>Ini adalah request GET. Kalau ada data, biasanya dikirim lewat parameter URL (query string).</p>
        <?php if (!empty($_GET)): ?>
            <p>Data GET yang diterima:</p>
            <ul>
                <?php foreach ($_GET as $key => $value): ?>
                    <li><?php echo htmlspecialchars($key); ?>: <?php echo htmlspecialchars($value); ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

    <?php elseif ($method === 'POST'): ?>
        <p>Ini adalah request POST. Data dikirim lewat body, tidak terlihat di URL.</p>
        <?php if (!empty($_POST)): ?>
            <p>Data POST yang diterima:</p>
            <ul>
                <?php foreach ($_POST as $key => $value): ?>
                    <li><?php echo htmlspecialchars($key); ?>: <?php echo htmlspecialchars($value); ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    <?php endif; ?>

    <hr>

    <h3>Uji Coba</h3>
    <form action="tugas-mandiri.php" method="GET">
        <input type="text" name="contoh_get" placeholder="Isi lalu submit (GET)">
        <button type="submit">Kirim via GET</button>
    </form>

    <form action="tugas-mandiri.php" method="POST">
        <input type="text" name="contoh_post" placeholder="Isi lalu submit (POST)">
        <button type="submit">Kirim via POST</button>
    </form>
</body>
</html>