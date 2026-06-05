<?php
global $conn;

if (!isset($nilai_terinput)) {
    $nilai_terinput = [];
}
?>

<div class="box">
    <h3><?= isset($_GET['edit']) ? '💡 Edit Alternatif & Nilai' : '➕ Tambah Alternatif Baru' ?></h3>
    <hr style="margin-bottom: 15px; border: 1px solid #eee;">
    
    <form method="POST" action="alternatif.php">
        <input type="hidden" name="id_alternatif" value="<?= isset($edit_alt) ? $edit_alt['id_alternatif'] : ''; ?>">
        
        <div class="form-group" style="margin-bottom: 20px;">
            <label for="nama_alternatif" style="display: block; font-weight: 600; margin-bottom: 5px; color: #4f5d73; font-size: 14px;">
                Nama Alternatif / Kandidat
            </label>
            <input type="text" 
                   id="nama_alternatif" 
                   name="nama_alternatif" 
                   placeholder="Contoh: Andi Wijaya" 
                   value="<?= isset($edit_alt) ? $edit_alt['nama_alternatif'] : ''; ?>" 
                   style="width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: 5px; font-size: 14px;" 
                   required>
        </div>

        <h4 style="margin-top: 25px; margin-bottom: 10px; color: #2c3e50; font-size: 15px;">Input Nilai Aktual Kompetensi:</h4>
        <p style="font-size: 12px; color: #7f8c8d; margin-bottom: 15px;">Silakan masukkan nilai asli (Usia, IPK, TOEFL). Sistem akan mengonversi secara otomatis ke skala 1-5.</p>
        <hr style="margin-bottom: 15px; border: 1px solid #f4f6f9;">
        
        <?php
        $kriteria_query = mysqli_query($conn, "SELECT * FROM kriteria");
        
        if (mysqli_num_rows($kriteria_query) == 0) {
            echo "<p style='color: #e74c3c; font-size: 13px; font-style: italic;'>Belum ada data kriteria. Silakan isi kriteria terlebih dahulu.</p>";
        } else {
            $i = 1; 
            while ($k = mysqli_fetch_assoc($kriteria_query)) {
                $val_aktual = isset($nilai_terinput[$k['id_kriteria']]) ? $nilai_terinput[$k['id_kriteria']] : '';
                
                $min = "1";
                $max = "5";
                $step = "0.1";
                $placeholder = "Masukkan skor (1-5)";

                if ($i == 1) { // C1 - Usia
                    $min = "15";
                    $max = "60";
                    $step = "1";
                    $placeholder = "Contoh: 24 (Tahun)";
                } elseif ($i == 2) { // C2 - IPK
                    $min = "0.00";
                    $max = "4.00";
                    $step = "0.01";
                    $placeholder = "Contoh: 3.50";
                } elseif ($i == 3) { // C3 - TOEFL
                    $min = "200";
                    $max = "677";
                    $step = "1";
                    $placeholder = "Contoh: 450";
                }
                ?>
                <div class="form-group" style="margin-bottom: 15px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 3px; color: #2c3e50; font-size: 13px;">
                        <?= $k['nama_kriteria']; ?> 
                        <span style="font-weight: normal; color: #7f8c8d; font-size: 12px;">
                            (Target: <b><?= $k['nilai_target']; ?></b> | Bobot: <?= $k['bobot_kriteria']; ?>%)
                        </span>
                    </label>
                    <input type="number" 
                           name="nilai[<?= $k['id_kriteria']; ?>]" 
                           min="<?= $min; ?>" 
                           max="<?= $max; ?>" 
                           step="<?= $step; ?>" 
                           placeholder="<?= $placeholder; ?>" 
                           value="<?= $val_aktual; ?>" 
                           style="width: 100%; padding: 8px 10px; border: 1px solid #ced4da; border-radius: 5px; font-size: 13px;" 
                           required>
                </div>
                <?php
                $i++;
            }
        }
        ?>
        
        <div class="form-actions" style="margin-top: 25px;">
            <button type="submit" name="simpan" class="btn-simpan" style="background: #2ecc71; color: white; border: none; padding: 10px 20px; font-weight: bold; border-radius: 5px; cursor: pointer;">
                <?= isset($_GET['edit']) ? '💡 Perbarui Alternatif' : '➕ Simpan Alternatif' ?>
            </button>
            
            <?php if (isset($_GET['edit'])): ?> 
                <a href="alternatif.php" style="color: #e74c3c; text-decoration: none; margin-left: 15px; font-size: 14px; font-weight: 600;">
                    Batal
                </a> 
            <?php endif; ?>
        </div>
    </form>
</div>