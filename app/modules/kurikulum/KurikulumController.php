<?php
declare (strict_types = 1);

final class KurikulumController
{
    private KurikulumModel $model;
    
    public function __construct()
    {
        $this->model = new KurikulumModel(Database::connection());
    }
    public function index(): void
    {
        // require_login();

        // $model = new KurikulumModel(Database::connection());

        render('kurikulum/views/index', [
            'title'         => 'Kurikulum',
            'subtitle'      => 'Halaman Kurikulum',
            'active'        => 'kurikulum',
            'kurikulumList' => $this->model->getKurikulum(),
        ]);
    }
    public function detail(): void
    {
        // require_login();

        $id_kurikulum = isset($_GET['id']) ? e($_GET['id']) : null;

        // $model = new KurikulumModel(Database::connection());

        render('kurikulum/views/detail', [
            'title'          => 'Detail Kurikulum',
            'subtitle'       => 'Halaman Detail Kurikulum',
            'active'         => 'kurikulum',
            'kurikulum'      => $id_kurikulum ? $this->model->getDataKurikulum($id_kurikulum) : null,
            'matakuliahList' => $id_kurikulum ? $this->model->getMatakuliah($id_kurikulum) : null,
        ]);
    }
    public function formKurikulum(): void
    {
        // require_login();
        $id_kurikulum = isset($_GET['id']) ? e($_GET['id']) : null;

        // $model = new KurikulumModel(Database::connection());

        render('kurikulum/views/form', [
            'title'    => 'Form Kurikulum',
            'subtitle' => 'Halaman form Kurikulum',
            'active'   => 'kurikulum',
            'formData' => $id_kurikulum ? $this->model->getDataKurikulum($id_kurikulum) : null,
        ]);
    }
    public function formMatakuliah(): void
    {
        // require_login();
        $id    = isset($_GET['id']) ? e($_GET['id']) : null;
        // $model = new KurikulumModel(Database::connection());

        render('kurikulum/views/matakuliah-form', [
            'title'         => 'Form Matakuliah',
            'subtitle'      => 'Halaman form Matakuliah',
            'active'        => 'kurikulum',
            'listKurikulum' => $this->model->getKurikulum(),
            'formData'      => $id ? $this->model->getDatamatakuliah($id) : null,
        ]);
    }
    public function tmpKurikulum(): void
    {
        // require_login();
        $id_kurikulum = isset($_GET['id']) ? e($_GET['id']) : null;

        // $model = new KurikulumModel(Database::connection());

        render('kurikulum/views/template', [
            'title'          => 'Laporan Kurikulum',
            'subtitle'       => 'Halaman Laporan Kurikulum',
            'active'         => 'kurikulum',
            'pageStyle'      => ['/assets/css/kurikulum.css'],
            'kurikulum'      => $id_kurikulum ? $this->model->getDataKurikulum($id_kurikulum) : null,
            'matakuliahList' => $id_kurikulum ? $this->model->getMatakuliah($id_kurikulum) : null,
        ]);
    }
    public function saveKurikulum(): void
    {
        // require_login();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || ! verify_csrf($_POST['_csrf'] ?? null)) {
            http_response_code(419);
            exit('Permintaan tidak valid.');
        }
        
        $data = [
            'id_kurikulum' => trim($_POST['id_kurikulum'] ?? '') ?: null, 
            'index_feeder' => trim($_POST['index_feeder'] ?? '') ?: null,
            'program_studi'=> trim($_POST['program_studi'] ?? '') ?: null,
            'tahun' => trim($_POST['tahun'] ?? '') ?: null,
            'nama' => trim($_POST['nama'] ?? '') ?: null, 
            'angkatan' => trim($_POST['angkatan'] ?? '') ?: null, 
            'obe' => trim($_POST['obe'] ?? '') ?: null, 
            'sks_wajib' => trim($_POST['sks_wajib'] ?? '') ?: null, 
            'sks_pilihan' => trim($_POST['sks_pilihan'] ?? '') ?: null,
            'sks_wajib_lulus' => trim($_POST['sks_wajib_lulus'] ?? '') ?: null,
            'sks_pilihan_lulus' => trim($_POST['sks_pilihan_lulus'] ?? '') ?: null,
            'sks_ditawarkan' => trim($_POST['sks_ditawarkan'] ?? '') ?: null,
            'status' => trim($_POST['status'] ?? '') ?: null,
        ];
        if ($data['id_kurikulum'] === '' || $data['nama'] === '') {
            flash('danger', 'ID Kurikulum dan nama wajib diisi.');
            redirect('kurikulum-form.php' . (isset($_POST['id']) ? '?id=' . (int)$_POST['id'] : ''));
        }
        try {
            $id = isset($_POST['id']) && $_POST['id'] !== '' ? (int)$_POST['id'] : null;
            $this->model->saveKurikulum($data, $id);
            flash('success', 'Data kurikulum berhasil disimpan.');
            redirect('kurikulum.php');
        } catch (Throwable $e) {
            flash('danger', 'Gagal menyimpan data. Pastikan ID kurikulum tidak duplikat.'. $e->getMessage());
            redirect('kurikulum-form.php' . ($id ? '?id=' . $id : ''));
        }
    }
}
