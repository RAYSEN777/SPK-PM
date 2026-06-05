<?php
include 'koneksi.php';

function konversi_nilai_asli($id_kriteria, $nilai_asli) {
    $nilai_asli = (float)$nilai_asli;

    switch ($id_kriteria) {
        case 1: 
            if ($nilai_asli <= 21) return 5;
            if ($nilai_asli <= 23) return 4; 
            if ($nilai_asli <= 25) return 3;
            if ($nilai_asli <= 27) return 2;
            if ($nilai_asli >= 28) return 1; 
            return 5;
        case 2: 
            if ($nilai_asli < 2.75) return 1;
            if ($nilai_asli >= 2.75 && $nilai_asli <= 3.00) return 2;
            if ($nilai_asli > 3.00 && $nilai_asli <= 3.25) return 3;
            if ($nilai_asli > 3.25 && $nilai_asli <= 3.50) return 4;
            if ($nilai_asli > 3.50) return 5;
            return 1;
        case 3: 
            if ($nilai_asli < 350) return 1;
            if ($nilai_asli >= 350 && $nilai_asli <= 400) return 2;
            if ($nilai_asli >= 401 && $nilai_asli <= 450) return 3;
            if ($nilai_asli >= 451 && $nilai_asli <= 500) return 4;
            if ($nilai_asli > 500) return 5;
            return 1;
        default:
            return $nilai_asli;
    }
}

if (isset($_POST['simpan'])) {
    $id_alt = $_POST['id_alternatif'];
    $nama = $_POST['nama_alternatif'];

    if ($id_alt == "") {        
        mysqli_query($conn, "INSERT INTO alternatif (nama_alternatif) VALUES ('$nama')");
        $id_baru = mysqli_insert_id($conn);
        
        foreach ($_POST['nilai'] as $id_krit => $nilai_val) {
            
            $nilai_konversi = konversi_nilai_asli($id_krit, $nilai_val);
            mysqli_query($conn, "INSERT INTO nilai_alternatif (id_alternatif, id_kriteria, nilai_aktual) VALUES ('$id_baru', '$id_krit', '$nilai_konversi')");
        }
    } else {
        mysqli_query($conn, "UPDATE alternatif SET nama_alternatif='$nama' WHERE id_alternatif='$id_alt'");
        
        foreach ($_POST['nilai'] as $id_krit => $nilai_val) {
            
            $nilai_konversi = konversi_nilai_asli($id_krit, $nilai_val);
            mysqli_query($conn, "DELETE FROM nilai_alternatif WHERE id_alternatif='$id_alt' AND id_kriteria='$id_krit'");
            mysqli_query($conn, "INSERT INTO nilai_alternatif (id_alternatif, id_kriteria, nilai_aktual) VALUES ('$id_alt', '$id_krit', '$nilai_konversi')");
        }
    }
    header("Location: alternatif.php");
    exit();
}

$edit_alt = ['id_alternatif' => '', 'nama_alternatif' => ''];
$nilai_terinput = [];
if (isset($_GET['edit'])) {
    $id_edit = $_GET['edit'];
    $res = mysqli_query($conn, "SELECT * FROM alternatif WHERE id_alternatif='$id_edit'");
    if (mysqli_num_rows($res) > 0) {
        $edit_alt = mysqli_fetch_assoc($res);
        
        
        $res_nilai = mysqli_query($conn, "SELECT * FROM nilai_alternatif WHERE id_alternatif='$id_edit'");
        while($r = mysqli_fetch_assoc($res_nilai)){
            $nilai_terinput[$r['id_kriteria']] = $r['nilai_aktual'];
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kelola Alternatif</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h1>Sistem Pendukung Keputusan - Kelola Alternatif & Nilai</h1>
    <nav>
        <a href="index.php">[ Dashboard ]</a> | 
        <a href="kriteria.php">[ Kelola Kriteria ]</a> | 
        <a href="alternatif.php" style="color: #2c3e50;"><b>[ Kelola Alternatif & Nilai ]</b></a> |
        <a href="ranking.php">[ Hasil Ranking ]</a>
    </nav>

    <div class="container">
        <?php include 'form_alternatif.php'; ?>
        <div class="box box-large">
            <h3>Daftar Alternatif</h3>
            <table>
                <thead>
                    <tr>
                        <th width="10%">No</th>
                        <th>Nama Alternatif</th>
                        <th width="35%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $query = mysqli_query($conn, "SELECT * FROM alternatif");
                    if (mysqli_num_rows($query) == 0) {
                        echo "<tr><td colspan='3' style='color:#7f8c8d; font-style:italic;'>Belum ada data alternatif.</td></tr>";
                    } else {
                        while ($row = mysqli_fetch_assoc($query)) {
                            echo "<tr>
                                    <td>{$no}</td>
                                    <td style='text-align:left;'><b>{$row['nama_alternatif']}</b></td>
                                    <td>
                                        <a href='alternatif.php?edit={$row['id_alternatif']}' class='btn-edit'>Edit & Nilai</a> | 
                                        <a href='hapus.php?type=alternatif&id={$row['id_alternatif']}' class='btn-hapus' onclick='return confirm(\"Hapus alternatif ini?\")'>Hapus</a>
                                    </td>
                                  </tr>";
                            $no++;
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>