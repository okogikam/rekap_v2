<?php
$row = $row ?? [];

$value = static function (string $key) use ($row): string {
    return e((string)($row[$key] ?? ''));
};
?>

<form method="post" action="mahasiswa-save.php">
    <?= csrf_field() ?>
    <?php if (!empty($row['id'])): ?>
        <input type="hidden" name="id" value="<?= (int)$row['id'] ?>">
    <?php endif; ?>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <h5 class="mb-3">Identitas Mahasiswa</h5>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">NIM *</label>
                    <input class="form-control" name="nim" required value="<?= $value('nim') ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">NIK</label>
                    <input class="form-control" name="nik" value="<?= $value('nik') ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Nama *</label>
                    <input class="form-control" name="nama" required value="<?= $value('nama') ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Fakultas</label>
                    <input class="form-control" name="fakultas" value="<?= $value('fakultas') ?>">
                </div>
                <div class="col-md-5">
                    <label class="form-label">Program Studi</label>
                    <input class="form-control" name="program_studi" value="<?= $value('program_studi') ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Angkatan</label>
                    <input type="number" min="1900" max="2200" class="form-control" name="angkatan" value="<?= $value('angkatan') ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Jenis Kelamin</label>
                    <select class="form-select" name="jenis_kelamin">
                        <option value="">-</option>
                        <option value="L" <?= ($row['jenis_kelamin'] ?? '') === 'L' ? 'selected' : '' ?>>Laki-laki (L)</option>
                        <option value="P" <?= ($row['jenis_kelamin'] ?? '') === 'P' ? 'selected' : '' ?>>Perempuan (P)</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tempat Lahir</label>
                    <input class="form-control" name="tempat_lahir" value="<?= $value('tempat_lahir') ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tanggal Lahir</label>
                    <input type="date" class="form-control" name="tanggal_lahir" value="<?= $value('tanggal_lahir') ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Agama</label>
                    <input class="form-control" name="agama" value="<?= $value('agama') ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Status Nikah</label>
                    <input class="form-control" name="status_nikah" value="<?= $value('status_nikah') ?>">
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <h5 class="mb-3">Kontak & Alamat</h5>
            <div class="row g-3">
                <div class="col-md-4"><label class="form-label">No. Telepon</label><input class="form-control" name="no_telepon" value="<?= $value('no_telepon') ?>"></div>
                <div class="col-md-4"><label class="form-label">No. HP</label><input class="form-control" name="no_hp" value="<?= $value('no_hp') ?>"></div>
                <div class="col-md-4"><label class="form-label">Email</label><input type="email" class="form-control" name="email" value="<?= $value('email') ?>"></div>
                <div class="col-md-6"><label class="form-label">Jalur Masuk</label><input class="form-control" name="jalur_masuk" value="<?= $value('jalur_masuk') ?>"></div>
                <div class="col-md-6"><label class="form-label">Alamat</label><textarea class="form-control" name="alamat" rows="2"><?= $value('alamat') ?></textarea></div>
                <div class="col-md-3"><label class="form-label">Kota</label><input class="form-control" name="kota" value="<?= $value('kota') ?>"></div>
                <div class="col-md-3"><label class="form-label">Propinsi</label><input class="form-control" name="propinsi" value="<?= $value('propinsi') ?>"></div>
                <div class="col-md-3"><label class="form-label">Kode Pos</label><input class="form-control" name="kode_pos" value="<?= $value('kode_pos') ?>"></div>
                <div class="col-md-3"><label class="form-label">Status Tempat Tinggal</label><input class="form-control" name="status_tempat_tinggal" value="<?= $value('status_tempat_tinggal') ?>"></div>
                <div class="col-md-4"><label class="form-label">Pembiayaan Kuliah</label><input class="form-control" name="pembiayaan_kuliah" value="<?= $value('pembiayaan_kuliah') ?>"></div>
                <div class="col-md-4"><label class="form-label">Tinggi Badan (cm)</label><input type="number" step="0.01" class="form-control" name="tinggi_badan_cm" value="<?= $value('tinggi_badan_cm') ?>"></div>
                <div class="col-md-4"><label class="form-label">Berat Badan (kg)</label><input type="number" step="0.01" class="form-control" name="berat_badan_kg" value="<?= $value('berat_badan_kg') ?>"></div>
                <div class="col-md-3"><label class="form-label">Golongan Darah</label><input class="form-control" name="gol_darah" value="<?= $value('gol_darah') ?>"></div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <h5 class="mb-3">Asal Sekolah</h5>
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label">Asal Sekolah</label><input class="form-control" name="asal_sekolah" value="<?= $value('asal_sekolah') ?>"></div>
                <div class="col-md-6"><label class="form-label">Kota Sekolah</label><input class="form-control" name="kota_sekolah" value="<?= $value('kota_sekolah') ?>"></div>
                <div class="col-md-6"><label class="form-label">Total Nilai UN</label><input type="number" step="0.01" class="form-control" name="total_nilai_un" value="<?= $value('total_nilai_un') ?>"></div>
                <div class="col-md-6"><label class="form-label">Rata-rata Nilai UN</label><input type="number" step="0.01" class="form-control" name="rata_nilai_un" value="<?= $value('rata_nilai_un') ?>"></div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <h5 class="mb-3">Riwayat S1</h5>
            <div class="row g-3">
                <div class="col-md-2"><label class="form-label">Masuk S1</label><input type="number" min="1900" max="2200" class="form-control" name="masuk_s1" value="<?= $value('masuk_s1') ?>"></div>
                <div class="col-md-2"><label class="form-label">Tamat S1</label><input type="number" min="1900" max="2200" class="form-control" name="tamat_s1" value="<?= $value('tamat_s1') ?>"></div>
                <div class="col-md-8"><label class="form-label">Perguruan Tinggi S1</label><input class="form-control" name="perguruan_tinggi_s1" value="<?= $value('perguruan_tinggi_s1') ?>"></div>
                <div class="col-md-4"><label class="form-label">Fakultas S1</label><input class="form-control" name="fakultas_s1" value="<?= $value('fakultas_s1') ?>"></div>
                <div class="col-md-4"><label class="form-label">Prodi S1</label><input class="form-control" name="prodi_s1" value="<?= $value('prodi_s1') ?>"></div>
                <div class="col-md-2"><label class="form-label">IPK S1</label><input type="number" step="0.01" min="0" max="4" class="form-control" name="ipk_s1" value="<?= $value('ipk_s1') ?>"></div>
                <div class="col-md-2"><label class="form-label">Gelar S1</label><input class="form-control" name="gelar_s1" value="<?= $value('gelar_s1') ?>"></div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <h5 class="mb-3">Orang Tua / Wali</h5>
            <div class="row g-3">
                <div class="col-md-3"><label class="form-label">NIK Ayah</label><input class="form-control" name="nik_ayah" value="<?= $value('nik_ayah') ?>"></div>
                <div class="col-md-5"><label class="form-label">Nama Ayah</label><input class="form-control" name="nama_ayah" value="<?= $value('nama_ayah') ?>"></div>
                <div class="col-md-4"><label class="form-label">Status Ayah</label><input class="form-control" name="status_ayah" value="<?= $value('status_ayah') ?>"></div>
                <div class="col-md-3"><label class="form-label">NIK Ibu</label><input class="form-control" name="nik_ibu" value="<?= $value('nik_ibu') ?>"></div>
                <div class="col-md-5"><label class="form-label">Nama Ibu</label><input class="form-control" name="nama_ibu" value="<?= $value('nama_ibu') ?>"></div>
                <div class="col-md-4"><label class="form-label">Status Ibu</label><input class="form-control" name="status_ibu" value="<?= $value('status_ibu') ?>"></div>
                <div class="col-md-4"><label class="form-label">Telepon Orang Tua</label><input class="form-control" name="telepon_ortu" value="<?= $value('telepon_ortu') ?>"></div>
                <div class="col-md-8"><label class="form-label">Alamat Orang Tua</label><textarea class="form-control" name="alamat_ortu" rows="2"><?= $value('alamat_ortu') ?></textarea></div>
                <div class="col-md-4"><label class="form-label">Pekerjaan Ayah</label><input class="form-control" name="pekerjaan_ayah" value="<?= $value('pekerjaan_ayah') ?>"></div>
                <div class="col-md-4"><label class="form-label">Pekerjaan Ibu</label><input class="form-control" name="pekerjaan_ibu" value="<?= $value('pekerjaan_ibu') ?>"></div>
                <div class="col-md-4"><label class="form-label">Penghasilan Orang Tua</label><input class="form-control" name="penghasilan_ortu" value="<?= $value('penghasilan_ortu') ?>"></div>
                <div class="col-md-4"><label class="form-label">Jumlah Tanggungan</label><input type="number" min="0" class="form-control" name="jumlah_tanggungan_ortu" value="<?= $value('jumlah_tanggungan_ortu') ?>"></div>
                <div class="col-md-4"><label class="form-label">Nama Wali</label><input class="form-control" name="nama_wali" value="<?= $value('nama_wali') ?>"></div>
                <div class="col-md-4"><label class="form-label">Telepon Wali</label><input class="form-control" name="telepon_wali" value="<?= $value('telepon_wali') ?>"></div>
                <div class="col-md-8"><label class="form-label">Alamat Wali</label><textarea class="form-control" name="alamat_wali" rows="2"><?= $value('alamat_wali') ?></textarea></div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <h5 class="mb-3">Registrasi & Status Akademik</h5>
            <div class="row g-3">
                <div class="col-md-3"><label class="form-label">Nomor Tes</label><input class="form-control" name="nomor_tes" value="<?= $value('nomor_tes') ?>"></div>
                <div class="col-md-3"><label class="form-label">Semester Masuk</label><input class="form-control" name="semester_masuk" value="<?= $value('semester_masuk') ?>"></div>
                <div class="col-md-3"><label class="form-label">Jenis Pendaftaran</label><input class="form-control" name="jenis_pendaftaran" value="<?= $value('jenis_pendaftaran') ?>"></div>
                <div class="col-md-3"><label class="form-label">Status Mahasiswa</label><input class="form-control" name="status_mahasiswa" value="<?= $value('status_mahasiswa') ?>"></div>
                <div class="col-md-3"><label class="form-label">Semester Keluar</label><input class="form-control" name="semester_keluar" value="<?= $value('semester_keluar') ?>"></div>
                <div class="col-md-9"><label class="form-label">Beasiswa</label><input class="form-control" name="beasiswa" value="<?= $value('beasiswa') ?>"></div>
            </div>
        </div>
    </div>

    <div class="d-flex gap-2 mb-4">
        <a href="mahasiswa.php" class="btn btn-light">Batal</a>
        <button class="btn btn-primary"><i class="bi bi-save"></i> Simpan Data Mahasiswa</button>
    </div>
</form>
