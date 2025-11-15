<?php require_once 'views/layouts/header.php'; ?>

<div class="container">
    <div class="header-section">
        <h1>✏️ Edit Film</h1>
        <a href="index.php?module=film" class="btn btn-secondary">⬅️ Kembali</a>
    </div>

    <div class="form-container">
        <form method="POST" action="index.php?module=film&action=update" class="movie-form">
            <input type="hidden" name="id_film" value="<?php echo $this->film->id_film; ?>">

            <div class="form-group">
                <label>Judul Film *</label>
                <input type="text" name="judul_film" required value="<?php echo htmlspecialchars($this->film->judul_film); ?>">
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Tahun Rilis *</label>
                    <input type="number" name="tahun_rilis" required value="<?php echo $this->film->tahun_rilis; ?>">
                </div>
                <div class="form-group">
                    <label>Durasi (menit) *</label>
                    <input type="number" name="durasi_menit" required value="<?php echo $this->film->durasi_menit; ?>">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Genre *</label>
                    <select name="id_genre" required>
                        <?php foreach($genres as $genre): ?>
                            <option value="<?php echo $genre['id_genre']; ?>" <?php echo ($this->film->id_genre == $genre['id_genre']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($genre['nama_genre']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Rating *</label>
                    <input type="number" name="rating" step="0.1" min="0" max="10" required value="<?php echo $this->film->rating; ?>">
                </div>
            </div>

            <div class="form-group">
                <label>URL Poster</label>
                <input type="url" name="poster_url" value="<?php echo htmlspecialchars($this->film->poster_url); ?>">
            </div>

            <div class="form-group">
                <label>Sinopsis</label>
                <textarea name="sipnosis" rows="5"><?php echo htmlspecialchars($this->film->sipnosis); ?></textarea>
            </div>

            <div class="form-group">
                <label>Pilih Aktor</label>
                <div style="max-height: 200px; overflow-y: auto; border: 2px solid #e0e0e0; padding: 15px;">
                    <?php 
                    $current_actor_ids = array_column($current_actors, 'id_aktor');
                    foreach($aktors as $aktor): 
                        $is_checked = in_array($aktor['id_aktor'], $current_actor_ids);
                        $current_peran = '';
                        foreach($current_actors as $ca) {
                            if($ca['id_aktor'] == $aktor['id_aktor']) {
                                $current_peran = $ca['peran'];
                                break;
                            }
                        }
                    ?>
                        <div style="margin-bottom: 15px; padding: 10px; background: #f8f9fa;">
                            <label>
                                <input type="checkbox" name="actors[]" value="<?php echo $aktor['id_aktor']; ?>" <?php echo $is_checked ? 'checked' : ''; ?>>
                                <?php echo htmlspecialchars($aktor['nama_aktor']); ?>
                            </label>
                            <input type="text" name="peran_<?php echo $aktor['id_aktor']; ?>" value="<?php echo htmlspecialchars($current_peran); ?>" placeholder="Peran" style="width: 100%; margin-top: 5px;">
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">💾 Update Film</button>
                <a href="index.php?module=film" class="btn btn-secondary">❌ Batal</a>
            </div>
        </form>
    </div>
</div>

<?php require_once 'views/layouts/footer.php'; ?>