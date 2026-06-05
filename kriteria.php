<?php
include 'koneksi.php';

if (isset($_POST['simpan'])) {
    $id = $_POST['id_kriteria'];
    $nama = $_POST['nama_kriteria'];
    $target = $_POST['nilai_target'];
    $bobot = $_POST['bobot_kriteria'];

    if ($id == "") {
        mysqli_query($conn, "INSERT INTO kriteria (nama_kriteria, nilai_target, bobot_kriteria) VALUES ('$nama', '$target', '$bobot')");
    } else {
        mysqli_query($conn, "UPDATE kriteria SET nama_kriteria='$nama', nilai_target='$target', bobot_kriteria='$bobot' WHERE id_kriteria='$id'");
    }
    header("Location: kriteria.php");
}

$edit_data = ['id_kriteria' => '', 'nama_kriteria' => '', 'nilai_target' => '', 'bobot_kriteria' => ''];
if (isset($_GET['edit'])) {
    $id_edit = $_GET['edit'];
    $res = mysqli_query($conn, "SELECT * FROM kriteria WHERE id_kriteria='$id_edit'");
    $edit_data = mysqli_fetch_assoc($res);
}

$check_bobot = mysqli_query($conn, "SELECT SUM(bobot_kriteria) as total FROM kriteria");
$row_bobot = mysqli_fetch_assoc($check_bobot);
$total_persen_sekarang = $row_bobot['total'] ?? 0;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Kelola Kriteria</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h1>Sistem Pendukung Keputusan Profile Matching - Kelola Kriteria</h1>
    <nav>
        <a href="index.php">[ Dashboard ]</a> | 
        <a href="kriteria.php" style="color: #2c3e50;"> <b>[ Kelola Kriteria ]</b></a> | 
        <a href="alternatif.php">[ Kelola Alternatif & Nilai ]</a> |
        <a href="ranking.php">[ Hasil Ranking ]</a>
    </nav>
    <div class="container">
        <?php include 'form_kriteria.php'; ?>

        <div class="box box-large">
            <h3>Daftar Kriteria</h3>
            
            <?php if($total_persen_sekarang == 100): ?>
                <div style="background:#d4edda; color:#155724; padding:10px; border-radius:5px; margin-bottom:15px; font-weight:bold;">
                    ✓ Total Bobot: 100% (Sistem Siap Digunakan)
                </div>
            <?php else: ?>
                <div style="background:#fff3cd; color:#856404; padding:10px; border-radius:5px; margin-bottom:15px; font-weight:bold;">
                    ⚠️ Total Bobot Saat Ini: <?= $total_persen_sekarang; ?>% (Harus bernilai 100% agar hasil akurat!)
                </div>
            <?php endif; ?>

            <table>
                <tr>
                    <th width="10%">No</th>
                    <th>Nama Kriteria</th>
                    <th>Nilai Target</th>
                    <th>Bobot Persen</th>
                    <th width="25%">Aksi</th>
                </tr>
                <?php
                $no = 1;
                $query = mysqli_query($conn, "SELECT * FROM kriteria");
                while ($row = mysqli_fetch_assoc($query)) {
                    echo "<tr>
                            <td>{$no}</td>
                            <td style='text-align:left;'>{$row['nama_kriteria']}</td>
                            <td>{$row['nilai_target']}</td>
                            <td><b>{$row['bobot_kriteria']}%</b></td>
                            <td>
                                <a href='kriteria.php?edit={$row['id_kriteria']}' class='btn-edit'>Edit</a> | 
                                <a href='hapus.php?type=kriteria&id={$row['id_kriteria']}' class='btn-hapus' onclick='return confirm(\"Hapus?\")'>Hapus</a>
                            </td>
                          </tr>";
                    $no++;
                }
                ?>
            </table>
        </div>
    </div>
</body>
</html>