<?php
declare(strict_types=1);

final class MahasiswaModel
{
    public function __construct(private PDO $db) {}

    public function all(string $search = '', string $status = '', string $angkatan = ''): array
    {
        $sql = "SELECT * FROM mahasiswa WHERE 1=1";
        $params = [];

        if ($search !== '') {
            $sql .= " AND (nim LIKE ? OR nama LIKE ? OR email LIKE ? OR prodi LIKE ?)";
            $like = '%' . $search . '%';
            $params = [$like, $like, $like, $like];
        }
        if (in_array($status, ['aktif','cuti','lulus','nonaktif'], true)) {
            $sql .= " AND status = ?";
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
        $stmt = $this->db->prepare("SELECT * FROM mahasiswa WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public function save(array $d, ?int $id = null): int
    {
        if ($id) {
            $stmt = $this->db->prepare("UPDATE mahasiswa SET nim=?,nama=?,email=?,prodi=?,angkatan=?,semester=?,jenis_kelamin=?,status=? WHERE id=?");
            $stmt->execute([$d['nim'],$d['nama'],$d['email'],$d['prodi'],$d['angkatan'],$d['semester'],$d['jenis_kelamin'],$d['status'],$id]);
            return $id;
        }
        $stmt = $this->db->prepare("INSERT INTO mahasiswa (nim,nama,email,prodi,angkatan,semester,jenis_kelamin,status) VALUES (?,?,?,?,?,?,?,?)");
        $stmt->execute([$d['nim'],$d['nama'],$d['email'],$d['prodi'],$d['angkatan'],$d['semester'],$d['jenis_kelamin'],$d['status']]);
        return (int)$this->db->lastInsertId();
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare("DELETE FROM mahasiswa WHERE id=?");
        $stmt->execute([$id]);
    }
}
