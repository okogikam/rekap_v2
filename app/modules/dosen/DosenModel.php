<?php
declare(strict_types=1);

final class DosenModel
{
    public function __construct(private PDO $db) {}

    public function all(string $search = ''): array
    {
        $sql = "SELECT * FROM dosen WHERE 1=1";
        $params = [];

        if ($search !== '') {
            $sql .= " AND (nidn LIKE ? OR nama LIKE ? OR nip LIKE ? OR email LIKE ? OR jabatan LIKE ? OR pangkat LIKE ?)";
            $like = '%' . $search . '%';
            $params = [$like, $like, $like, $like, $like, $like];
        }

        $sql .= " ORDER BY nama ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM dosen WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public function save(array $data, ?int $id = null): int
    {
        if ($id) {
            $sql = "UPDATE dosen SET nip=?, nidn=?, gelar_depan=?, nama=?, gelar_belakang=?, jabatan=?, pendidikan_terakhir=?, pangkat=?, status=?, homebase=?, email=? WHERE id=?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                $data['nip'], $data['nidn'], $data['gelar_depan'], $data['nama'],
                $data['gelar_belakang'], $data['jabatan'], $data['pendidikan_terakhir'],
                $data['pangkat'], $data['status'], $data['homebase'], $data['email'], $id
            ]);
            return $id;
        }

        $sql = "INSERT INTO dosen
            (nip,nidn,gelar_depan,nama,gelar_belakang,jabatan,pendidikan_terakhir,pangkat,status,homebase,email)
            VALUES (?,?,?,?,?,?,?,?,?,?,?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $data['nip'], $data['nidn'], $data['gelar_depan'], $data['nama'],
            $data['gelar_belakang'], $data['jabatan'], $data['pendidikan_terakhir'],
            $data['pangkat'], $data['status'], $data['homebase'], $data['email']
        ]);
        return (int)$this->db->lastInsertId();
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare("DELETE FROM dosen WHERE id=?");
        $stmt->execute([$id]);
    }
}
