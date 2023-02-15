<?php
include '../lib/database.php';
SESSION_START();
if (($_SESSION['level'] != 'admin') AND ($_SESSION['level'] != 'petugas')) {
    header('Location:../logout.php');
}

if (empty($_GET['id'])) {
    header('Location:./index.php');
}
if (isset($_POST['tanggapi'])) {
    $id_pengaduan = $_GET['id'];
    $tanggapan = $_POST['tanggapan'];
    $id_petugas = $_SESSION['id'];
    $queryTanggapi = " INSERT INTO tanggapan (id_pengaduan, tgl_tanggapan, tanggapan, id_petugas) VALUE
                      ($id_pengaduan, now(), '$tanggapan', $id_petugas);
                     ";
                    
    $execQueryTanggapan = mysqli_query($koneksi, $queryTanggapi);
    if ($execQueryTanggapan) {
        header('Location:./verifikasi/proses.php');
    }else {
        echo '<script>alert("tanggapan ada yang salah")</script>';
    }
    // var_dump($execQueryTanggapan);
}

// untuk menampilkan data Aduan
$id_pengaduan = $_GET['id'];
$queryAduan = "SELECT * FROM pengaduan WHERE id_pengaduan = $id_pengaduan";
$execQueryAduan = mysqli_query($koneksi, $queryAduan);
$getDataAduan = mysqli_fetch_all($execQueryAduan, MYSQLI_ASSOC);

foreach ($getDataAduan as $data) {
    if (($data['status'] != '0') AND ($data['status'] != 'proses')){
        header('Location:./verifikasi/valid.php');
    }
}

//untuk menampilkan data tanggapan dari aduan
$id_pengaduan = $_GET['id'];
$queryTanggapan = "SELECT t.id_tanggapan as id_tanggapan, t.id_pengaduan as id_pengaduan, t.tgl_tanggapan as tgl_tanggapan,
                    t.tanggapan as tanggapan, p.nama_petugas as nama_petugas FROM tanggapan t JOIN petugas p 
                    WHERE t.id_petugas = p.id_petugas AND id_pengaduan = $id_pengaduan";
$execQueryTanggapanShowData = mysqli_query($koneksi, $queryTanggapan);
$getDataTanggapan = mysqli_fetch_all($execQueryTanggapanShowData, MYSQLI_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tanggapan</title>
</head>
<body>
    <table border="1">
        <thead>
            <tr>
                <th>Foto Penunjang</th>
                <th>Tanggal Aduan</th>
                <th>Aduan</th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach ($getDataAduan as $data) {
                    echo "
                    <tr>
                        <td>
                            <img src=$data[foto] width=100px>
                        </td>
                        <td>$data[tgl_pengaduan]</td>
                        <td>$data[isi_laporan]</td>
                    </tr>
                    ";
                }
            ?>
        </tbody>
    </table>
    <form method="POST">
        <textarea name="tanggapan" ></textarea>
        <input type="submit" name="tanggapi" value="Tanggapi">
    </form>

    <table border="1">
        <thead>
            <tr>
                <th>#</th>
                <th>Tanggal Tanggapan</th>
                <th>Tanggapan</th>
                <th>Nama Penanggap</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no=0;
                foreach ($getDataTanggapan as $data) {
                    $no+=1;
                    echo "
                    <tr>
                        <td>$no</td>
                        <td>$data[tgl_tanggapan]</td>
                        <td>$data[tanggapan]</td>
                        <td>$data[nama_petugas]</td>
                    </tr>
                    ";
                }
            ?>
        </tbody>
    </table>
</body>
</html>