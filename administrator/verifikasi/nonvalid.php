<?php
include '../../lib/database.php';
SESSION_START();
if (($_SESSION['level'] != 'admin') AND ($_SESSION['level'] != 'petugas')) {
    header('Location:../logout.php');
}

$query = "SELECT p.id_pengaduan as id_pengaduan, m.nama as nama, p.tgl_pengaduan as tgl_pengaduan, p.foto as foto, p.isi_laporan as isi_laporan, p.status as status
         FROM pengaduan p JOIN masyarakat m WHERE p.nik = m.nik AND p.status is NULL;";
$execQuery = mysqli_query($koneksi, $query);
$getData = mysqli_fetch_all($execQuery, MYSQLI_ASSOC);

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $queryValid = "UPDATE pengaduan SET status = '0' WHERE id_pengaduan = $id";
    $execQueryValid = mysqli_query($koneksi, $queryValid);
    if ($execQueryValid) {
        header('Location:./nonvalid.php');
    }else {
        echo '<script>alert("ada proses yang salah</script>")'; 
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaduan Non Valid</title>
    <link rel="stylesheet" type="text/css" href="../../assets/dist/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <ul class="navbar-nav">
                <li class="navbar-item">
                    <a href="./nonvalid.php" class="nav-link">Pengaduan Nonvalid</a>
                </li>
                <li class="navbar-item">
                    <a href="./valid.php" class="nav-link">Pengaduan Valid</a>
                </li>
                <li class="navbar-item">
                    <a href="./proses.php" class="nav-link">Pengaduan Proses</a>
                </li>
                <li class="navbar-item">
                    <a href="./selesai.php" class="nav-link">Pengaduan Selesai</a>
                </li>
                <li class="navbar-item">
                    <a href="../generate_laporan.php" class="nav-link">Generate Laporan</a>
                </li>
            </ul>
            <div>
                <?php
                echo $_SESSION['nama']. ' <a href="../logout.php">Logout</a> ';
                ?>
            </div>
        </div>
    </nav>

    <div class="container">
        <center>
            <h2>List Pengaduan Nonvalid</h2>
        </center>
        <div class="row justify-content-center align-middle">
            <table class="table table-striped">
                <thead>
                    <th>No</th>
                    <th>Nama Pengadu</th>
                    <th>Tanggal Pengaduan</th>
                    <th>Foto Penunjang</th>
                    <th>Isi Aduan</th>
                    <th>Status</th>
                    <th>verifikasi</th>
                </thead>
                <tbody>
                    <?php
                    $no = 0 ;
                        foreach($getData as $data) {
                            
                            $no+=1;
                            if ($data['status'] == NULL) {
                                $status = 'Belum Valid';
                            } else if ($data['status'] == '0') {
                                $status = 'Valid';
                            } else {
                                $status = 'status tidak diketahui';
                            }
                            echo "
                                <tr>
                                    <td>$no</td>
                                    <td>$data[nama]</td>
                                    <td>$data[tgl_pengaduan]</td>
                                    <td>
                                        <img src=$data[foto] width = 100px height 100px>
                                    </td>
                                    <td>$data[isi_laporan]</td>
                                    <td>$status</td>
                                    <td>
                                    <a href = ?id=$data[id_pengaduan]>
                                        <button class='btn btn-success'>
                                            Validasi
                                        </button>
                                    </td>
                                </tr>
                                ";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
<script type="text/javascript" src="../assets/js/dist/bootstrap.min.js"></script>
</html>