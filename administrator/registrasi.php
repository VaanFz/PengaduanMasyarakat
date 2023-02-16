<?php
SESSION_START();
    if ($_SESSION['level'] != 'admin') {
        header('Location:./logout.php');
    }


if(isset($_POST['registrasi'])){

    include '../lib/database.php';


$nama_petugas = $_POST['nama_petugas'];
$username = $_POST['username'];
$password = $_POST['password'];
$telp = $_POST['telp'];
$level = $_POST['level'];

$query = "INSERT INTO petugas (nama_petugas,username, password, telp, level) VALUE('$nama_petugas', '$username', '$password', '$telp', '$level');";
$execQuery = mysqli_query($koneksi, $query);
if ($execQuery) {
    echo '<script> alert("data berhasil Disimpan")</script>';
    header('Location:../administrator/index.php');
} else {
    echo '<script> alert("data ada yang salah")</script>';
}
// var_dump($query);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Admin</title>
    <link rel="stylesheet" type="text/css" href="../assets/dist/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <div class="navbar-nav">
            <li class="nav-item">
                <a href="./index.php" >Login</a>
            </li>
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
                    <input type="text" name="nama_petugas" placeholder="Nama Asli Anda"  class="form-control" required>
                </div>

                <div class="mb-3">
                    <input type="text" name="username" placeholder="Username Anda"  class="form-control" required>
                </div>

                <div class="mb-3">
                    <input type="password" name="password" placeholder="Password Anda"  class="form-control" required>
                </div>

                <div class="mb-3">
                    <input type="text" name="telp" placeholder="Nomor Telepon Anda"  class="form-control" required>
                </div>

                <div class="mb-3">
                    <select name="level" class="form-control">
                        <option value="">- Jabatan -</option>
                        <option value="petugas">Petugas</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>

                <div class="mb-3">
                     <input type="submit" name="registrasi" value="REGISTRASI"  class="form-control btn btn-success">
                </div>
            </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>