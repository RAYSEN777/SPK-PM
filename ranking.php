<?php
include 'koneksi.php';

function hitung_bobot_gap($gap) {
    $gap = (float)$gap;
    if ($gap == 0) return 6;
    if ($gap == 1) return 5.5;
    if ($gap == -1) return 5;
    if ($gap == 2) return 4.5;
    if ($gap == -2) return 4;
    if ($gap == 3) return 3.5;
    if ($gap == -3) return 3;
    if ($gap == 4) return 2.5;
    if ($gap == -4) return 2;
    if ($gap == 5) return 1.5;
    if ($gap == -5) return 1;
    return 0;
}

$kriteria_arr = [];
$total_persen = 0;
$q_krit = mysqli_query($conn, "SELECT * FROM kriteria");
while($rk = mysqli_fetch_assoc($q_krit)) {
    $kriteria_arr[$rk['id_kriteria']] = $rk;
    $total_persen += $rk['bobot_kriteria'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Halaman Ranking SPK</title>
    <link rel="stylesheet" type="text/css" href="style.css"> 
</head>
<body>
    <h1>Sistem Pendukung Keputusan - Hasil Ranking</h1>
    <nav>
        <a href="index.php">[ Dashboard ]</a> | 
        <a href="kriteria.php">[ Kelola Kriteria ]</a> | 
        <a href="alternatif.php">[ Kelola Alternatif & Nilai ]</a> |
        <a href="ranking.php" style="color: #2c3e50;"><b>[ Hasil Ranking ]</b></a>
    </nav>

    <h2>Hasil Perhitungan & Urutan Ranking</h2>
    <?php if($total_persen != 100): ?>
        <div style="background:#f8d7da; color:#721c24; padding:15px; border-radius:5px; font-weight:bold;">
            ⚠️ Perhitungan dikunci. Total bobot kriteria saat ini adalah <?= $total_persen; ?>%. Silakan sesuaikan kembali di menu Kelola Kriteria agar tepat 100%.
        </div>
    <?php elseif(count($kriteria_arr) == 0): ?>
        <p style="color:red">Sistem belum siap. Mohon isi data Kriteria dan Alternatif terlebih dahulu.</p>
    <?php else: ?>

    <table>
        <tr>
            <th rowspan="2">Nama Alternatif</th>
            <?php foreach($kriteria_arr as $k): ?>
                <th><?= $k['nama_kriteria']; ?></th>
            <?php endforeach; ?>
            <th rowspan="2">Total Nilai Akhir</th>
            <th rowspan="2">Peringkat</th>
        </tr>
        <tr>
            <?php foreach($kriteria_arr as $k): ?>
                <th>Target: <?= $k['nilai_target']; ?> (<?= $k['bobot_kriteria']; ?>%)</th>
            <?php endforeach; ?>
        </tr>

        <?php
        $hasil_ranking = [];
        $q_alt = mysqli_query($conn, "SELECT * FROM alternatif");
        while($ra = mysqli_fetch_assoc($q_alt)) {
            $id_alt = $ra['id_alternatif'];
            
            $q_nilai = mysqli_query($conn, "SELECT * FROM nilai_alternatif WHERE id_alternatif='$id_alt'");
            $nilai_aktual_alt = [];
            while($rn = mysqli_fetch_assoc($q_nilai)){
                $nilai_aktual_alt[$rn['id_kriteria']] = $rn['nilai_aktual'];
            }

            $nilai_akhir = 0;
            $rincian_per_kriteria = [];

            foreach($kriteria_arr as $id_kr => $k_data) {
                $nilai_aktual = isset($nilai_aktual_alt[$id_kr]) ? $nilai_aktual_alt[$id_kr] : 0;
                $gap = $nilai_aktual - $k_data['nilai_target'];
                $gap = round($gap);
                $bobot_gap = hitung_bobot_gap($gap);
                
                $kontribusi_nilai = $bobot_gap * ($k_data['bobot_kriteria'] / 100);
                $nilai_akhir += $kontribusi_nilai;
                
                $rincian_per_kriteria[$id_kr] = "Aktual: <b>$nilai_aktual</b><br>B.Gap: $bobot_gap<br>Kontribusi: <b>".round($kontribusi_nilai, 3)."</b>";
            }

            $hasil_ranking[] = [
                'nama' => $ra['nama_alternatif'],
                'rincian' => $rincian_per_kriteria,
                'skor_akhir' => round($nilai_akhir, 3)
            ];
        }
        
        usort($hasil_ranking, function($a, $b) {
            return $b['skor_akhir'] <=> $a['skor_akhir'];
        });
        
        $rank = 1;
        foreach($hasil_ranking as $hr):
        ?>
            <tr>
                <td style="text-align: left;"><b><?= $hr['nama']; ?></b></td>
                <?php foreach($kriteria_arr as $id_kr => $v): ?>
                    <td><?= $hr['rincian'][$id_kr]; ?></td>
                <?php endforeach; ?>
                <td class="highlight-skor"><?= $hr['skor_akhir']; ?></td>
                <td><span class="badge-rank">Rank <?= $rank; ?></span></td>
            </tr>
        <?php 
            $rank++;
        endforeach; 
        ?>
    </table>
    <?php endif; ?>
</body>
</html>