
<!-- rekap data mahasiswa  -->
<div class="row g-4">
    <div class="col-md-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-label text-primary"><h4><i class="bi bi-person"></i> Mahasiswa AKtif</h4></div>
            <div class="stat-value"><?= e($stats['mahasiswa_aktif']) ?></div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-label text-success"><h4><i class="bi bi-mortarboard"></i> Mahasiswa Lulus</h4></div>
            <div class="stat-value"><?= e($stats['mahasiswa_lulus']) ?></div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-label text-danger"><h4><i class="bi bi-people"></i> Mengundurkan Diri</h4></div>
            <div class="stat-value"><?= e($stats['mahasiswa_mundur']) ?></div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-label text-warning"><h4><i class="bi bi-people"></i> Pindah</h4></div>
            <div class="stat-value"><?= e($stats['mahasiswa_pindah']) ?></div>
        </div>
    </div>
</div>
<div class="card border-0 shadow-sm mt-4">
<?php $jml_angkatan = ceil(count($angkatan) / 2); $data_angkatan = array_chunk($angkatan,$jml_angkatan); ?>
    <div class="card-body p-4">
<div class="row g-4">
    <div class="col-md-12 col-xl-6">
	<table class="table table-hover">
	  <thead>
	    <tr>
		<th>Angkatan</th>
		<th>Aktif</th>
		<th>Lulus</th>
		<th>Pindah</th>
		<th>Keluar</th>
		<th>Total</th>
	    </tr>
	  </thead>
	  <tbody>
	  <?php foreach($data_angkatan[0] as $akt): ?>
	   <tr>
		<td><?= $akt['angkatan'] ?></td>
		<td><?= $akt['aktif'] ?></td>
		<td><?= $akt['lulus'] ?></td>
		<td><?= $akt['pindah'] ?></td>
		<td><?= $akt['jml'] - $akt['aktif'] - $akt['lulus'] - $akt['pindah'] ?></td>
		<td><?= $akt['jml'] ?></td>
	    </tr>
	  <?php endforeach; ?>
	  </tbody>
	</table>
    </div>
<div class="col-md-12 col-xl-6">
	<table class="table table-hover">
	  <thead>
	    <tr>
		<th>Angkatan</th>
		<th>Aktif</th>
		<th>Lulus</th>
		<th>Pindah</th>
		<th>Keluar</th>
		<th>Total</th>
	    </tr>
	  </thead>
	  <tbody>
	  <?php foreach($data_angkatan[1] as $akt): ?>
	   <tr>
		<td><?= $akt['angkatan'] ?></td>
		<td><?= $akt['aktif'] ?></td>
		<td><?= $akt['lulus'] ?></td>
		<td><?= $akt['pindah'] ?></td>
		<td><?= $akt['jml'] - $akt['aktif'] - $akt['lulus'] - $akt['pindah'] ?></td>
		<td><?= $akt['jml'] ?></td>
	    </tr>
	  <?php endforeach; ?>
	  </tbody>
	</table>
    </div>
</div>
    </div>
</div>

<div class="card border-0 shadow-sm mt-4">
    <div class="card-body p-4">
        <h5 class="mb-2">Import / Export</h5>
        <p class="text-secondary mb-3">Gunakan Excel/CSV untuk memasukkan data dalam jumlah banyak atau mengunduh data.</p>
        <a href="import-export.php" class="btn btn-primary">
            <i class="bi bi-file-earmark-spreadsheet"></i> Buka Import / Export
        </a>
    </div>
</div> 