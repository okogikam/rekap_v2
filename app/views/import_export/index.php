<div class="row g-4">
<div class="col-lg-7">
<div class="card border-0 shadow-sm h-100"><div class="card-body p-4">
<h5>Import Data</h5>
<p class="text-secondary">Pilih modul dan file. Excel akan dipreview di browser sebelum dikirim ke server.</p>
<form id="importForm" method="post" action="import-process.php" enctype="multipart/form-data">
<?= csrf_field() ?>
<div class="mb-3"><label class="form-label">Modul</label><select id="entity" name="entity" class="form-select" required><option value="dosen">Dosen</option><option value="mahasiswa">Mahasiswa</option></select></div>
<div class="mb-3"><label class="form-label">File Excel / CSV</label><input id="excelFile" class="form-control" type="file" name="file" accept=".xlsx,.xls,.csv" required></div>
<div class="alert alert-light border small">Format utama: <b>XLSX, XLS, CSV</b>. Kolom wajib: <b>NIDN + Nama</b> untuk dosen dan <b>NIM + Nama</b> untuk mahasiswa.</div>
<button type="button" id="previewBtn" class="btn btn-outline-primary"><i class="bi bi-eye"></i> Preview & Validasi</button>
<button type="submit" id="importBtn" class="btn btn-primary d-none"><i class="bi bi-cloud-upload"></i> Proses Import</button>
</form>
</div></div>
</div>

<div class="col-lg-5">
<div class="card border-0 shadow-sm mb-4"><div class="card-body p-4">
<h5>Export</h5><p class="text-secondary">Unduh data saat ini dalam CSV.</p>
<div class="d-flex gap-2 flex-wrap"><a class="btn btn-outline-success" href="export.php?entity=dosen"><i class="bi bi-download"></i> Export Dosen</a><a class="btn btn-outline-success" href="export.php?entity=mahasiswa"><i class="bi bi-download"></i> Export Mahasiswa</a></div>
</div></div>
<div class="card border-0 shadow-sm"><div class="card-body p-4">
<h5>Template</h5><p class="text-secondary">Gunakan template agar nama kolom sesuai.</p>
<div class="d-flex gap-2 flex-wrap"><a class="btn btn-outline-secondary" href="template.php?entity=dosen">Template Dosen</a><a class="btn btn-outline-secondary" href="template.php?entity=mahasiswa">Template Mahasiswa</a></div>
</div></div>
</div>
</div>

<div id="previewArea" class="card border-0 shadow-sm mt-4 d-none"><div class="card-body p-4">
<div class="d-flex justify-content-between align-items-center mb-3"><h5 class="mb-0">Preview</h5><span id="validationStatus" class="badge text-bg-secondary"></span></div>
<div id="validationMessage" class="mb-3"></div>
<div class="table-responsive"><table class="table table-sm table-bordered" id="previewTable"></table></div>
</div></div>
