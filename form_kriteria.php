<div class="box">
    <h3>Form Tambah/Edit Kriteria</h3>
    <hr style="margin-bottom: 15px; border: 1px solid #eee;">
    
    <form method="POST" action="kriteria.php">
        <input type="hidden" name="id_kriteria" value="<?= isset($edit_data) ? $edit_data['id_kriteria'] : ''; ?>">
        
        <div class="form-group" style="margin-bottom: 15px;">
            <label style="display: block; font-weight: 600; margin-bottom: 5px; color: #4f5d73; font-size: 14px;">Nama Kriteria</label>
            <input type="text" name="nama_kriteria" value="<?= isset($edit_data) ? $edit_data['nama_kriteria'] : ''; ?>" style="width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: 5px;" required>
        </div>
        
        <div class="form-group" style="margin-bottom: 15px;">
            <label style="display: block; font-weight: 600; margin-bottom: 5px; color: #4f5d73; font-size: 14px;">Nilai Target (1 - 5)</label>
            <input type="number" 
                id="nilai_target" 
                name="nilai_target" 
                min="1" 
                max="5" 
                step="0.1" 
                placeholder="Contoh: 4.5" 
                value="<?= isset($edit_data) ? $edit_data['nilai_target'] : ''; ?>" 
                style="width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: 5px; font-size: 14px;" 
                required>
        </div>

        <div class="form-group" style="margin-bottom: 20px;">
            <label style="display: block; font-weight: 600; margin-bottom: 5px; color: #4f5d73; font-size: 14px;">Bobot Kriteria (%)</label>
            <input type="number" name="bobot_kriteria" min="1" max="100" placeholder="Contoh: 25" value="<?= isset($edit_data) ? $edit_data['bobot_kriteria'] : ''; ?>" style="width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: 5px;" required>
            <small style="color: #7f8c8d; font-size: 12px;">*Pastikan total bobot dari semua kriteria jika dijumlahkan bernilai 100%.</small>
        </div>
        
        <div class="form-actions">
            <button type="submit" name="simpan" class="btn-simpan"><?= isset($_GET['edit']) ? '💡 Perbarui' : '➕ Tambah' ?></button>
            <?php if (isset($_GET['edit'])): ?> <a href="kriteria.php">Batal</a> <?php endif; ?>
        </div>
    </form>
</div>