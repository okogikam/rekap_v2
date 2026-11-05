<?php
declare(strict_types=1);

final class KurikulumModel
{
    public function __construct(private PDO $db) {}

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
