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
            'title'=>'Data Mahasiswa',
            'subtitle'=>'Kelola data mahasiswa',
            'active'=>'mahasiswa',
            'rows'=>$this->model->all(trim($_GET['q']??''),trim($_GET['status']??''),trim($_GET['angkatan']??'')),
            'q'=>trim($_GET['q']??''),
            'status'=>trim($_GET['status']??''),
            'angkatan'=>trim($_GET['angkatan']??''),
        ]);
    }

    public function form(): void
    {
        require_login();
        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;
        render('mahasiswa/form', [
            'title'=>$id?'Edit Mahasiswa':'Tambah Mahasiswa',
            'subtitle'=>$id?'Perbarui data mahasiswa':'Masukkan data mahasiswa baru',
            'active'=>'mahasiswa',
            'row'=>$id?$this->model->find($id):null,
        ]);
    }

    public function save(): void
    {
        require_login();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !verify_csrf($_POST['_csrf']??null)) {
            http_response_code(419); exit('Permintaan tidak valid.');
        }
        $semester = trim($_POST['semester']??'');
        $angkatan = trim($_POST['angkatan']??'');
        $data = [
            'nim'=>trim($_POST['nim']??''),
            'nama'=>trim($_POST['nama']??''),
            'email'=>trim($_POST['email']??'')?:null,
            'prodi'=>trim($_POST['prodi']??'')?:null,
            'angkatan'=>ctype_digit($angkatan)?(int)$angkatan:null,
            'semester'=>ctype_digit($semester)?(int)$semester:null,
            'jenis_kelamin'=>in_array($_POST['jenis_kelamin']??'', ['L','P'], true)?$_POST['jenis_kelamin']:null,
            'status'=>in_array($_POST['status']??'', ['aktif','cuti','lulus','nonaktif'], true)?$_POST['status']:'aktif',
        ];
        if ($data['nim']==='' || $data['nama']==='') {
            flash('danger','NIM dan nama wajib diisi.');
            redirect('mahasiswa-form.php'.(isset($_POST['id'])?'?id='.(int)$_POST['id']:''));
        }
        try {
            $id = isset($_POST['id']) && $_POST['id']!==''?(int)$_POST['id']:null;
            $this->model->save($data,$id);
            flash('success','Data mahasiswa berhasil disimpan.');
            redirect('mahasiswa.php');
        } catch (Throwable $e) {
            flash('danger','Gagal menyimpan data. Pastikan NIM tidak duplikat.');
            redirect('mahasiswa-form.php'.($id?'?id='.$id:''));
        }
    }

    public function delete(): void
    {
        require_login();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !verify_csrf($_POST['_csrf']??null)) {
            http_response_code(419); exit('Permintaan tidak valid.');
        }
        $id=(int)($_POST['id']??0);
        if($id>0){$this->model->delete($id);flash('success','Data mahasiswa berhasil dihapus.');}
        redirect('mahasiswa.php');
    }
}
