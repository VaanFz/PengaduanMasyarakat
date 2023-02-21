<?php
if(isset($_POST['registrasi'])){

    include '../lib/database.php';

$nik = $_POST['nik'];
$nama = $_POST['nama'];
$username = $_POST['username'];
$password = $_POST['password'];
$telp = $_POST['telp'];

$query = "INSERT INTO masyarakat (nik, nama,username, password, telp) VALUE('$nik', '$nama', '$username', '$password', '$telp');";
$execQuery = mysqli_query($koneksi, $query);
if ($execQuery) {
    echo '<script> alert("data berhasil Disimpan")</script>';
    header('Location:../index.php');
} else {
    echo '<script> alert("data ada yang salah")</script>';
}
var_dump($query);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Masyarakat</title>
    <link rel="stylesheet" type="text/css" href="../assets/dist/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <div class="navbar-nav">
        </div>
    </div>
</nav>
<div class="container">
    <div class="row justify-content-center align-midlle">
        <div class="card col-lg-6">
            <div class="card-header">
                <center>Registrasi Masyarakat</center>
            </div>
            <div class="card-body">
            <form method="POST">
                <div class="mb-3">
                <input type="text" name="nik" placeholder="Nomor Induk Kepundukan" class="form-control" required>
                </div>

                <div class="mb-3">
                <input type="text" name="nama" placeholder="Nama Asli Anda" class="form-control" required>
                </div>

                <div class="mb-3">
                <input type="text" name="username" placeholder="Username Anda" class="form-control" required>
                </div>

                <div class="mb-3">
                <input type="password" name="password" placeholder="Password Anda" class="form-control" required>
                </div>

                <div class="mb-3">
                <input type="text" name="telp" placeholder="Nomor Telepon Anda" class="form-control" required>
                </div>

                <div class="mb-3">
                <input type="submit" name="registrasi" value="registrasi" class="form-control btn btn-primary">
                </div>
                <div>
                    <span>Sudah Punya Akun? </span><a href="../index.php" >Login</a>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>
</body>
<script type="text/javascript" src="./assets/dist/css/bootstrap.min.js"></script>
</html>