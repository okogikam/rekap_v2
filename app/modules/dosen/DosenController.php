<?php
declare(strict_types=1);

final class DosenController
{
    private DosenModel $model;

    public function __construct()
    {
        $this->model = new DosenModel(Database::connection());
    }

    public function index(): void
    {
        require_login();
        $q = trim($_GET['q'] ?? '');
	$status = trim($_GET['status'] ?? '');

        render('dosen/index', [
            'title' => 'Data Dosen',
            'subtitle' => 'Kelola data dosen',
            'active' => 'dosen',
            'rows' => $this->model->all($q),
            'q' => $q,
        ]);
    }

    public function form(): void
    {
        require_login();
        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;

        render('dosen/form', [
            'title' => $id ? 'Edit Dosen' : 'Tambah Dosen',
            'subtitle' => $id ? 'Perbarui data dosen' : 'Masukkan data dosen baru',
            'active' => 'dosen',
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

        $data = [
            'nip' => trim($_POST['nip'] ?? '') ?: null,
            'nidn' => trim($_POST['nidn'] ?? ''),
            'gelar_depan' => trim($_POST['gelar_depan'] ?? '') ?: null,
            'nama' => trim($_POST['nama'] ?? ''),
            'gelar_belakang' => trim($_POST['gelar_belakang'] ?? '') ?: null,
            'jabatan' => trim($_POST['jabatan'] ?? '') ?: null,
            'pendidikan_terakhir' => trim($_POST['pendidikan_terakhir'] ?? '') ?: null,
            'pangkat' => trim($_POST['pangkat'] ?? '') ?: null,
            'status' => trim($_POST['status'] ?? '') ?: null,
            'homebase' => trim($_POST['homebase'] ?? '') ?: null,
            'email' => trim($_POST['email'] ?? '') ?: null,
        ];

        if ($data['nidn'] === '' || $data['nama'] === '') {
            flash('danger', 'NIDN dan nama wajib diisi.');
            redirect('dosen-form.php' . (isset($_POST['id']) ? '?id=' . (int)$_POST['id'] : ''));
        }

        try {
            $id = isset($_POST['id']) && $_POST['id'] !== '' ? (int)$_POST['id'] : null;
            $this->model->save($data, $id);
            flash('success', 'Data dosen berhasil disimpan.');
            redirect('dosen.php');
        } catch (Throwable $e) {
            flash('danger', 'Gagal menyimpan data. Pastikan NIDN tidak duplikat.');
            redirect('dosen-form.php' . ($id ? '?id=' . $id : ''));
        }
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
            flash('success', 'Data dosen berhasil dihapus.');
        }

        redirect('dosen.php');
    }
}
