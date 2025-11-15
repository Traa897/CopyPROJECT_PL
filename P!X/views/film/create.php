<?php require_once 'views/layouts/header.php'; ?>

<div class="container">
    <div class="header-section">
        <h1>➕ Tambah Film Baru</h1>
        <a href="index.php?module=film" class="btn btn-secondary">⬅️ Kembali</a>
    </div>

    <?php if(isset($_GET['error'])): ?>
        <div class="alert alert-error">
            ❌ <?php echo htmlspecialchars($_GET['error']); ?>
        </div>
    <?php endif; ?>

    <div class="form-container">
        <form method="POST" action="index.php?module=film&action=store" class="movie-form">
            <div class="form-group">
                <label for="judul_film">Judul Film *</label>
                <input type="text" id="judul_film" name="judul_film" required 
                       placeholder="Masukkan judul film">
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="tahun_rilis">Tahun Rilis *</label>
                    <input type="number" id="tahun_rilis" name="tahun_rilis" required 
                           min="1900" max="2100" placeholder="2024">
                </div>

                <div class="form-group">
                    <label for="durasi_menit">Durasi (menit) *</label>
                    <input type="number" id="durasi_menit" name="durasi_menit" required 
                           min="1" placeholder="120">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="id_genre">Genre *</label>
                    <select id="id_genre" name="id_genre" required>
                        <option value="">Pilih Genre</option>
                        <?php foreach($genres as $genre): ?>
                            <option value="<?php echo $genre['id_genre']; ?>">
                                <?php echo htmlspecialchars($genre['nama_genre']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="rating">Rating (0.0 - 10.0) *</label>
                    <input type="number" id="rating" name="rating" step="0.1" 
                           min="0" max="10" placeholder="7.5" required>
                </div>
            </div>

            <div class="form-group">
                <label for="poster_url">URL Poster</label>
                <input type="url" id="poster_url" name="poster_url" 
                       placeholder="https://example.com/poster.jpg"
                       value="https://via.placeholder.com/300x450">
            </div>

            <div class="form-group">
                <label for="sipnosis">Sinopsis</label>
                <textarea id="sipnosis" name="sipnosis" rows="5" 
                          placeholder="Masukkan sinopsis film..."></textarea>
            </div>

            <div class="form-group">
                <label>Pilih Aktor (Multiple)</label>
                <div style="max-height: 200px; overflow-y: auto; border: 2px solid #e0e0e0; border-radius: 5px; padding: 15px;">
                    <?php foreach($aktors as $aktor): ?>
                        <div style="margin-bottom: 15px; padding: 10px; background: #f8f9fa; border-radius: 5px;">
                            <label style="display: flex; align-items: center; cursor: pointer;">
                                <input type="checkbox" name="actors[]" value="<?php echo $aktor['id_aktor']; ?>" 
                                       style="margin-right: 10px;">
                                <span style="font-weight: 600;"><?php echo htmlspecialchars($aktor['nama_aktor']); ?></span>
                            </label>
                            <input type="text" name="peran_<?php echo $aktor['id_aktor']; ?>" 
                                   placeholder="Peran (opsional)" 
                                   style="width: 100%; padding: 5px; margin-top: 5px; border: 1px solid #ddd; border-radius: 3px;">
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">💾 Simpan Film</button>
                <a href="index.php?module=film" class="btn btn-secondary">❌ Batal</a>
            </div>
        </form>
    </div>
</div>

<?php require_once 'views/layouts/footer.php'; ?>