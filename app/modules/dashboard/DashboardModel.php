<?php
declare(strict_types=1);

final class DashboardModel
{
    public function __construct(private PDO $db) {}

    public function count(string $table): int
    {
        $allowed = ['dosen', 'mahasiswa'];
        if (!in_array($table, $allowed, true)) {
            throw new InvalidArgumentException('Tabel tidak diizinkan.');
        }
        return (int)$this->db->query("SELECT COUNT(*) FROM `$table`")->fetchColumn();
    }

    public function countActive(string $table): int
    {
        $allowed = ['dosen', 'mahasiswa'];
        if (!in_array($table, $allowed, true)) {
            throw new InvalidArgumentException('Tabel tidak diizinkan.');
        }
        if ($table === 'mahasiswa') {
            return (int)$this->db->query("SELECT COUNT(*) FROM `mahasiswa` WHERE LOWER(status_mahasiswa) = 'aktif'")->fetchColumn();
        }
        return (int)$this->db->query("SELECT COUNT(*) FROM `dosen` WHERE LOWER(status) = 'aktif'")->fetchColumn();
    }
    public function countLulus(string $table): int
    {
        $allowed = ['dosen', 'mahasiswa'];
        if (!in_array($table, $allowed, true)) {
            throw new InvalidArgumentException('Tabel tidak diizinkan.');
        }
        if ($table === 'mahasiswa') {
            return (int)$this->db->query("SELECT COUNT(*) FROM `mahasiswa` WHERE LOWER(status_mahasiswa) = 'lulus'")->fetchColumn();
        }
        return (int)$this->db->query("SELECT COUNT(*) FROM `dosen` WHERE LOWER(status) = 'lulus'")->fetchColumn();
    }
    public function countPindah(string $table): int
    {
        $allowed = ['dosen', 'mahasiswa'];
        if (!in_array($table, $allowed, true)) {
            throw new InvalidArgumentException('Tabel tidak diizinkan.');
        }
        if ($table === 'mahasiswa') {
            return (int)$this->db->query("SELECT COUNT(*) FROM `mahasiswa` WHERE LOWER(status_mahasiswa) = 'pindah'")->fetchColumn();
        }
        return (int)$this->db->query("SELECT COUNT(*) FROM `dosen` WHERE LOWER(status) = 'pindah'")->fetchColumn();
    }
    public function countMundur(string $table): int
    {
        $allowed = ['dosen', 'mahasiswa'];
        if (!in_array($table, $allowed, true)) {
            throw new InvalidArgumentException('Tabel tidak diizinkan.');
        }
        if ($table === 'mahasiswa') {
            return (int)$this->db->query("SELECT COUNT(*) FROM `mahasiswa` WHERE LOWER(status_mahasiswa) LIKE '%mengundurkan%'")->fetchColumn();
        }
        return (int)$this->db->query("SELECT COUNT(*) FROM `dosen` WHERE LOWER(status) LIKE '%mengundurkan%'")->fetchColumn();
    }

    public function query(string $query = ''): array
    {
        $sql = "";

        if ($query !== '') {
            $sql .= $query;
        }

        // $sql .= " ORDER BY ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
