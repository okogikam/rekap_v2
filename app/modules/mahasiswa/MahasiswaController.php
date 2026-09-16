<?php
declare(strict_types=1);

final class MahasiswaController
{
    private MahasiswaModel $model;

    public function __construct()
    {
        $this->model = new MahasiswaModel(Database::connection());
    }

    public function index(): void
    {
        require_login();
        render('mahasiswa/index', [
            'title' => 'Data Mahasiswa',
            'subtitle' => 'Kelola data mahasiswa',
            'active' => 'mahasiswa',
            'rows' => $this->model->all(
                trim($_GET['q'] ?? ''),
                trim($_GET['status'] ?? ''),
                trim($_GET['angkatan'] ?? '')
            ),
            'q' => trim($_GET['q'] ?? ''),
            'status' => trim($_GET['status'] ?? ''),
            'angkatan' => trim($_GET['angkatan'] ?? ''),
        ]);
    }

    public function form(): void
    {
        require_login();
        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;

        render('mahasiswa/form', [
            'title' => $id ? 'Edit Mahasiswa' : 'Tambah Mahasiswa',
            'subtitle' => $id ? 'Perbarui data mahasiswa' : 'Masukkan data mahasiswa baru',
            'active' => 'mahasiswa',
            'row' => $id ? $this->model->find($id) : null,
        ]);
    }

    public function save(): void
    {
        require_login();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !verify_csrf($_POST['_csrf'] ?? null)) {
            http_response_code(419);
            exit('Permintaan tidak valid.');
        }

        $id = isset($_POST['id']) && $_POST['id'] !== '' ? (int)$_POST['id'] : null;
        $data = $this->collectFormData();

        if ($data['nim'] === '' || $data['nama'] === '') {
            flash('danger', 'NIM dan nama wajib diisi.');
            redirect('mahasiswa-form.php' . ($id ? '?id=' . $id : ''));
        }

        try {
            $this->model->save($data, $id);
            flash('success', 'Data mahasiswa berhasil disimpan.');
            redirect('mahasiswa.php');
        } catch (Throwable $e) {
            flash('danger', 'Gagal menyimpan data. Pastikan NIM tidak duplikat dan format data sudah benar.');
            redirect('mahasiswa-form.php' . ($id ? '?id=' . $id : ''));
        }
    }

    private function collectFormData(): array
    {
        $textFields = [
            'nim', 'nik', 'nama', 'fakultas', 'program_studi', 'jenis_kelamin',
            'tempat_lahir', 'agama', 'status_nikah', 'no_telepon', 'no_hp', 'email',
            'jalur_masuk', 'alamat', 'kota', 'propinsi', 'kode_pos',
            'status_tempat_tinggal', 'pembiayaan_kuliah', 'gol_darah', 'asal_sekolah',
            'kota_sekolah', 'perguruan_tinggi_s1', 'fakultas_s1', 'prodi_s1',
            'gelar_s1', 'nik_ayah', 'nama_ayah', 'nik_ibu', 'nama_ibu',
            'status_ayah', 'status_ibu', 'telepon_ortu', 'alamat_ortu',
            'pekerjaan_ayah', 'pekerjaan_ibu', 'penghasilan_ortu', 'nama_wali',
            'alamat_wali', 'telepon_wali', 'nomor_tes', 'semester_masuk',
            'jenis_pendaftaran', 'status_mahasiswa', 'semester_keluar', 'beasiswa'
        ];

        $data = [];
        foreach ($textFields as $field) {
            $value = trim((string)($_POST[$field] ?? ''));
            $data[$field] = $value !== '' ? $value : null;
        }

        $data['nim'] = trim((string)($_POST['nim'] ?? ''));
        $data['nama'] = trim((string)($_POST['nama'] ?? ''));

        $data['angkatan'] = $this->yearOrNull($_POST['angkatan'] ?? null);
        $data['tanggal_lahir'] = $this->dateOrNull($_POST['tanggal_lahir'] ?? null);
        $data['masuk_s1'] = $this->yearOrNull($_POST['masuk_s1'] ?? null);
        $data['tamat_s1'] = $this->yearOrNull($_POST['tamat_s1'] ?? null);

        $data['tinggi_badan_cm'] = $this->decimalOrNull($_POST['tinggi_badan_cm'] ?? null);
        $data['berat_badan_kg'] = $this->decimalOrNull($_POST['berat_badan_kg'] ?? null);
        $data['total_nilai_un'] = $this->decimalOrNull($_POST['total_nilai_un'] ?? null);
        $data['rata_nilai_un'] = $this->decimalOrNull($_POST['rata_nilai_un'] ?? null);
        $data['ipk_s1'] = $this->decimalOrNull($_POST['ipk_s1'] ?? null);

        $tanggungan = trim((string)($_POST['jumlah_tanggungan_ortu'] ?? ''));
        $data['jumlah_tanggungan_ortu'] = ctype_digit($tanggungan) ? (int)$tanggungan : null;

        return $data;
    }

    private function yearOrNull(mixed $value): ?int
    {
        $value = trim((string)$value);
        if ($value === '' || !ctype_digit($value)) {
            return null;
        }
        $year = (int)$value;
        return ($year >= 1900 && $year <= 2200) ? $year : null;
    }

    private function decimalOrNull(mixed $value): ?float
    {
        $value = trim((string)$value);
        if ($value === '' || !is_numeric($value)) {
            return null;
        }
        return (float)$value;
    }

    private function dateOrNull(mixed $value): ?string
    {
        $value = trim((string)$value);
        if ($value === '') {
            return null;
        }
        $date = DateTime::createFromFormat('Y-m-d', $value);
        return ($date && $date->format('Y-m-d') === $value) ? $value : null;
    }

    public function delete(): void
    {
        require_login();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !verify_csrf($_POST['_csrf'] ?? null)) {
            http_response_code(419);
            exit('Permintaan tidak valid.');
        }
        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) {
            $this->model->delete($id);
            flash('success', 'Data mahasiswa berhasil dihapus.');
        }
        redirect('mahasiswa.php');
    }
}
