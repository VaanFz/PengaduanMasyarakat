<?php

include '../lib/database.php';
SESSION_START();

if ($_SESSION['level'] != 'masyarakat') {
    header('Location:../logout.php');
}

$id_user = $_SESSION['id'];
$queryShowData = "SELECT * FROM pengaduan where nik = '$id_user'";
$execQueryShowData = mysqli_query($koneksi, $queryShowData);
$getAllData = mysqli_fetch_all($execQueryShowData, MYSQLI_ASSOC);


if(isset($_POST['adukan'])) {
    $laporan = $_POST['laporan'];

    /* Method untuk memindah file dari temp ke server */
    $locationTemp = $_FILES['foto']['tmp_name'];
    $destinationFile = '../assets/img/';

    //servername dibuat localhost jika kalian tidak menggunakan port
    $serverName = 'http://localhost/pengaduan_masyarakat/assets/img/';

    $fileName = str_replace(' ','',$_FILES['foto']['name']);
    $locationUpload = $destinationFile.$fileName;
    move_uploaded_file($locationTemp,$locationUpload);

    $query= "INSERT INTO pengaduan (tgl_pengaduan,nik,isi_laporan,foto,status) 
            VALUE (now(), '$id_user', '$laporan', '$serverName$fileName', NULL);";
    $execQuery = mysqli_query($koneksi, $query);
    var_dump($execQuery);
    if ($execQuery) {
        header ('Location:./menulis_pengaduan.php');
    } else {
        echo '<script>alert("Data aduan ada yang salah")</script>';
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aduan</title>
    <link rel="stylesheet" type="text/css" href="../assets/dist/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="./menulis_pengaduan.php" class="">Menulis Aduan</a>
                </li>
            </ul>
            <div class="row">
                <?php 
                 echo $_SESSION['nama']. '<a href="../logout.php" class="">Logout</a>'
                ?>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row justify-content-center aligen-midlle">
            <form method="POST" enctype="multipart/form-data">
                <div class="col-lg-6">
                    <div class="md-3">
                        <Label for="">Foto Penunjang</Label>
                        <input type="file" name="foto"  class="form-control" required>
                    </div>
                    <br>
                    <div class="md-3">
                        <label for="">Deskripsi Aduan</label>
                        <textarea name="laporan"  class="form-control" required></textarea>
                    </div>
                    <br>
                    <div class="md-3">
                        <input type="submit" name="adukan" value="Adukan" class="form-control btn btn-danger">
                    </div>
                </div>
            </form>
        </div>
        <br>
        <div class="col-lg-12">
        <table class="table table-striped" >
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tangal Aduan</th>
                    <th>Foto</th>
                    <th>Isi Laporan</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 0;
                    foreach ($getAllData as $data){
                        $no+=1;
                        if ($data['status'] == NULL) {
                            $status = 'belum valid';
                        } else if ($data['status'] == '0') {
                            $status = 'Valid';
                        } else {
                            $status = $data['status'];
                        }
                        echo "
                            <tr>
                                <td>$no</td>
                                <td>$data[tgl_pengaduan]</td>
                                <td>
                                    <img src = $data[foto] width = 100px height = 100px>
                                </td>
                                <td>$data[isi_laporan]</td>
                                <td>$status</td>
                            </tr>
                        ";
                    }
                ?>
            </tbody>
        </table>
        </div>
    </div>    
    
</body>
<script type="text/javascript" src="../assets/dist/css/bootstrap.min.js"></script>
</html>