<!-- LOGIN ADMINISTRATOR -->

<?php
// melakukan Query dari username dan password yang didapatkan di form (html) ke mysql
if(isset($_POST['login'])) {
    SESSION_START();
/*melakukan konseksi ke database*/
include '../lib/database.php';

$username = $_POST['username'];
$password = $_POST['password'];
$query = "SELECT * FROM petugas WHERE username = '$username' AND password = '$password';";
$execQuery = mysqli_query($koneksi, $query);

$getData = mysqli_fetch_all($execQuery, MYSQLI_ASSOC);
$numRows = mysqli_num_rows($execQuery);

if ($numRows == 1) {
    foreach ($getData as $data) {
        $_SESSION['id'] = $data['id_petugas'];
        $_SESSION['nama'] = $data['nama_petugas'];
        $_SESSION['level'] = $data['level'];
    }
    header('Location:./verifikasi/nonvalid.php');
} else {
    echo '<script> alert("data Anda Salah")</script>';
}

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Administrator</title>
    <link rel="stylesheet" type="text/css" href="../assets/dist/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar">

    </nav>
    <div class="container">
        <div class="row justify-content-center align-center">
            <div class="card col-lg-6">
                <div class="card-header">
                    <center>Login Admin</center>
                </div>
                <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <input type="text" name="username" placeholder="Username" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <input type="password" name="password" placeholder="password" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <input type="submit" name="login" value="Login" class="form-control btn btn-success" > 
                    </div>
                </form>
                <a href="./registrasi.php">Daftar</a>
                </div>
            </div>
        </div>
    </div>
</body>
<script type="text/javascript" src="../assets/dist/css/bootstrap.min.js"></script>
</html>