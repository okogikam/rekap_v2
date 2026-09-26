<?php
declare(strict_types=1);

final class MahasiswaModel
{
    public function __construct(private PDO $db) {}

    public function all(string $search = '', string $status = '', string $angkatan = ''): array
    {
        $sql = "SELECT mahasiswa.*, tabel_pa.nama_dosen, tabel_pa.nip_dosen FROM mahasiswa LEFT JOIN tabel_pa ON mahasiswa.nim = tabel_pa.nim  WHERE 1=1";
        $params = [];

        if ($search !== '') {
            $sql .= " AND (nim LIKE ? OR nik LIKE ? OR nama LIKE ? OR program_studi LIKE ? OR email LIKE ? OR no_hp LIKE ? OR no_telepon LIKE ? OR asal_sekolah LIKE ? OR status_mahasiswa LIKE ?)";
            $like = '%' . $search . '%';
            $params = array_fill(0, 9, $like);
        }

        if ($status !== '') {
            $sql .= " AND status_mahasiswa = ?";
            $params[] = $status;
        }

        if ($angkatan !== '' && ctype_digit($angkatan)) {
            $sql .= " AND angkatan = ?";
            $params[] = (int)$angkatan;
        }

        $sql .= " ORDER BY nama ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT mahasiswa.*, tabel_pa.nama_dosen, tabel_pa.nip_dosen FROM mahasiswa LEFT JOIN tabel_pa ON mahasiswa.nim = tabel_pa.nim WHERE mahasiswa.id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public function query(string $query): ?array
    {
        $stmt = $this->db->prepare($query ?? '');
        $stmt->execute();
        return $stmt->fetchAll() ?: null;
    }

    public function save(array $d, ?int $id = null): int
    {
        $fields = [
            'nim', 'nik', 'nama', 'fakultas', 'program_studi', 'angkatan',
            'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir', 'agama',
            'status_nikah', 'no_telepon', 'no_hp', 'email', 'jalur_masuk',
            'alamat', 'kota', 'propinsi', 'kode_pos', 'status_tempat_tinggal',
            'pembiayaan_kuliah', 'tinggi_badan_cm', 'berat_badan_kg',
            'gol_darah', 'asal_sekolah', 'kota_sekolah', 'total_nilai_un',
            'rata_nilai_un', 'masuk_s1', 'tamat_s1', 'perguruan_tinggi_s1',
            'fakultas_s1', 'prodi_s1', 'ipk_s1', 'gelar_s1', 'nik_ayah',
            'nama_ayah', 'nik_ibu', 'nama_ibu', 'status_ayah', 'status_ibu',
            'telepon_ortu', 'alamat_ortu', 'pekerjaan_ayah', 'pekerjaan_ibu',
            'penghasilan_ortu', 'jumlah_tanggungan_ortu', 'nama_wali',
            'alamat_wali', 'telepon_wali', 'nomor_tes', 'semester_masuk',
            'jenis_pendaftaran', 'status_mahasiswa', 'semester_keluar',
            'beasiswa'
        ];        

        $values = [];
        foreach ($fields as $field) {
            $values[] = $d[$field] ?? null;
        }
       

        if ($id !== null) {
            // update data mahasiswa
            $set = implode(', ', array_map(fn(string $field) => "`{$field}` = ?", $fields));
            $stmt = $this->db->prepare("UPDATE mahasiswa SET {$set} WHERE id = ?");
            $stmt->execute([...$values, $id]);

            // update data dosen pa
            $stmt_pa = $this->db->prepare("UPDATE tabel_pa SET nama_dosen = ? , nip_dosen = ? WHERE nim = ?");
            $stmt_pa->execute([
                $d['nama_dosen'], 
                $d['nip_dosen'], 
                $d['nim']
            ]);    

            return $id;
        }
        // simpan data pa baru
        $stmt_pa = $this->db->prepare("INSERT INTO tabel_pa (nip_dosen,nama_dosen,nim,nama_mahasiswa) VALUES (?, ?, ?, ?)");
        $stmt_pa->execute([            
            $d['nip_dosen'], 
            $d['nama_dosen'], 
            $d['nim'],
            $d['nama'],
        ]);
        // simpan data mahasiswa baru
        $columns = implode(', ', array_map(fn(string $field) => "`{$field}`", $fields));
        $placeholders = implode(', ', array_fill(0, count($fields), '?'));
        $stmt = $this->db->prepare("INSERT INTO mahasiswa ({$columns}) VALUES ({$placeholders})");
        $stmt->execute($values);


        return (int)$this->db->lastInsertId();
    }

    public function delete(int $id, string $nim): void
    {
        //hapus data dosen pa
        $stmt_pa = $this->db->prepare("DELETE FROM tabel_pa WHERE nim = ?");
        $stmt_pa->execute([$nim]);

        //hapus data mahasiswa
        $stmt = $this->db->prepare("DELETE FROM mahasiswa WHERE id = ?");
        $stmt->execute([$id]);
    }
}
