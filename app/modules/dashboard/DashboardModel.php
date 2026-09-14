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
        return (int)$this->db->query("SELECT COUNT(*) FROM `$table` WHERE status = 'aktif'")->fetchColumn();
    }
}
