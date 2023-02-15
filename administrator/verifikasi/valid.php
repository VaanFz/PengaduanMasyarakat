<?php
SESSION_START();
include '../../lib/database.php';
if (($_SESSION['level'] != 'admin') AND ($_SESSION['level'] != 'petugas')) {
    header('Location:../logout.php');
}

$query = "SELECT p.id_pengaduan as id_pengaduan, m.nama as nama, p.tgl_pengaduan as tgl_pengaduan, p.foto as foto, p.isi_laporan as isi_laporan, p.status as status
         FROM pengaduan p JOIN masyarakat m WHERE p.nik = m.nik AND p.status = '0';";
$execQuery = mysqli_query($koneksi, $query);
$getData = mysqli_fetch_all($execQuery, MYSQLI_ASSOC);

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $queryValid = "UPDATE pengaduan SET status = 'proses' WHERE id_pengaduan = $id";
    $execQueryValid = mysqli_query($koneksi, $queryValid);
    if ($execQueryValid) {
        header('Location:./valid.php');
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
    <title>Pengaduan Valid</title>
</head>
<body>
    <table border="1">
        <thead>
            <th>#</th>
            <th>Nama Pengadu</th>
            <th>Tanggal Pengaduan</th>
            <th>Foto Penunjang</th>
            <th>Isi Aduan</th>
            <th>Status</th>
            <th>Tanggapan</th>
            <th>verifikasi</th>
        </thead>
        <tbody>
            <?php
            $no = 0 ;
                foreach($getData as $data) {
                    
                    $no+=1;
                    if ($data['status'] == 'proses') {
                        $status = 'Proses';
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
                                <a href=../tanggapan.php?id=$data[id_pengaduan]>
                                <button>
                                    Tanggapan
                                </button>
                            </td>
                            <td>
                             <a href = ?id=$data[id_pengaduan]>
                                <button>
                                    Telah Di Proses
                                </button>
                            </td>
                        </tr>
                        ";
                }
            ?>
        </tbody>
    </table>
</body>
</html>