<?php
include 'koneksi.php';

$q_krit = mysqli_query($conn, "SELECT COUNT(*) as total FROM kriteria");
$r_krit = mysqli_fetch_assoc($q_krit);
$jumlah_kriteria = $r_krit['total'];

$q_alt = mysqli_query($conn, "SELECT COUNT(*) as total FROM alternatif");
$r_alt = mysqli_fetch_assoc($q_alt);
$jumlah_alternatif = $r_alt['total'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard SPK</title>
    <link rel="stylesheet" type="text/css" href="style.css"> 
</head>
<body>
    <h1>Sistem Pendukung Keputusan - Dashboard</h1>
    <nav>
        <a href="index.php" style="color: #2c3e50;"><b>[ Dashboard ]</b></a> | 
        <a href="kriteria.php">[ Kelola Kriteria ]</a> | 
        <a href="alternatif.php">[ Kelola Alternatif & Nilai ]</a> |
        <a href="ranking.php">[ Hasil Ranking ]</a>
    </nav>

    <h2>Dashboard Ringkasan Informasi</h2>

    <div class="container" style="margin-bottom: 25px;">
        <div class="box" style="border-left: 5px solid #3498db; text-align: center;">
            <h4 style="margin: 0; color: #7f8c8d; text-transform: uppercase; font-size: 12px;">Informasi Kriteria</h4>
            <h1 style="font-size: 36px; border: none; margin: 10px 0 0 0; padding: 0; color: #2c3e50;">
                <?= $jumlah_kriteria; ?> <span style="font-size: 16px; color:#95a5a6;">Data</span>
            </h1>
            <p style="font-size: 13px; margin-top: 5px;"><a href="kriteria.php">Lihat Detail Kriteria &raquo;</a></p>
        </div>

        <div class="box" style="border-left: 5px solid #2ecc71; text-align: center;">
            <h4 style="margin: 0; color: #7f8c8d; text-transform: uppercase; font-size: 12px;">Informasi Alternatif</h4>
            <h1 style="font-size: 36px; border: none; margin: 10px 0 0 0; padding: 0; color: #2c3e50;">
                <?= $jumlah_alternatif; ?> <span style="font-size: 16px; color:#95a5a6;">Kandidat</span>
            </h1>
            <p style="font-size: 13px; margin-top: 5px;"><a href="alternatif.php">Lihat Detail Alternatif &raquo;</a></p>
        </div>
    </div>

    <div class="box box-large" style="width: 100%;">
        <h3>Informasi Pembobotan Nilai GAP</h3>
        <p style="font-size: 14px; color: #7f8c8d; margin-bottom: 15px;">
            Sistem menggunakan rumus konversi selisih kompetensi berdasarkan aturan baku Profile Matching skala nilai 1 s/d 6:
        </p>
        
        <table style="margin-top: 10px;">
            <thead>
                <tr>
                    <th>Selisih (GAP)</th>
                    <th>Nilai Bobot</th>
                    <th>Keterangan Aturan Kompetensi</th>
                </tr>
            </thead>
            <tbody>
                <tr><td>0</td><td><b>6</b></td><td style="text-align:left;">Tidak ada GAP (Kompetensi sesuai yang dibutuhkan)</td></tr>
                <tr bgcolor="#f9f9f9"><td>1</td><td><b>5.5</b></td><td style="text-align:left;">Kompetensi individu kelebihan 1 tingkat/level</td></tr>
                <tr><td>-1</td><td><b>5</b></td><td style="text-align:left;">Kompetensi individu kekurangan 1 tingkat/level</td></tr>
                <tr bgcolor="#f9f9f9"><td>2</td><td><b>4.5</b></td><td style="text-align:left;">Kompetensi individu kelebihan 2 tingkat/level</td></tr>
                <tr><td>-2</td><td><b>4</b></td><td style="text-align:left;">Kompetensi individu kekurangan 2 tingkat/level</td></tr>
                <tr bgcolor="#f9f9f9"><td>3</td><td><b>3.5</b></td><td style="text-align:left;">Kompetensi individu kelebihan 3 tingkat/level</td></tr>
                <tr><td>-3</td><td><b>3</b></td><td style="text-align:left;">Kompetensi individu kekurangan 3 tingkat/level</td></tr>
                <tr bgcolor="#f9f9f9"><td>4</td><td><b>2.5</b></td><td style="text-align:left;">Kompetensi individu kelebihan 4 tingkat/level</td></tr>
                <tr><td>-4</td><td><b>2</b></td><td style="text-align:left;">Kompetensi individu kekurangan 4 tingkat/level</td></tr>
                <tr bgcolor="#f9f9f9"><td>5</td><td><b>1.5</b></td><td style="text-align:left;">Kompetensi individu kelebihan 5 tingkat/level</td></tr>
                <tr><td>-5</td><td><b>1</b></td><td style="text-align:left;">Kompetensi individu kekurangan 5 tingkat/level</td></tr>
            </tbody>
        </table>
    </div>
</body>
</html>