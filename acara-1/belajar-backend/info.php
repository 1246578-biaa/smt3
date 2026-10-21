<?php
$nama = "Wahyu Oktavia";
$nim  = "E41251105";

date_default_timezone_set("Asia/Jakarta");
$waktu = date("Y-m-d H:i:s");
$versiPHP = phpversion();
$osServer = PHP_OS;
?>
<!DOCTYPE html>
<html>
<head><title>Info Server</title></head>
<body>
    <h2>Informasi Identitas & Server</h2>
    <table border="1" cellpadding="8">
        <tr><th>Item</th><th>Nilai</th></tr>
        <tr><td>Nama</td><td><?php echo $nama; ?></td></tr>
        <tr><td>NIM</td><td><?php echo $nim; ?></td></tr>
        <tr><td>Waktu Server</td><td><?php echo $waktu; ?></td></tr>
        <tr><td>Versi PHP</td><td><?php echo $versiPHP; ?></td></tr>
        <tr><td>OS Server</td><td><?php echo $osServer; ?></td></tr>
    </table>
</body>
</html>