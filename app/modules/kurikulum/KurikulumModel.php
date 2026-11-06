<?php
declare (strict_types = 1);

final class KurikulumModel
{
    public function __construct(private PDO $db)
    {}

    public function getKurikulum(): array
    {
        $stmt = $this->db->prepare("SELECT * FROM kurikulum ORDER BY tahun DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function getMatakuliah(string $id): array
    {
        $stm    = "SELECT * FROM matakuliah WHERE id_kurikulum = '$id' ORDER BY semester ASC";
        $result = $this->query($stm);
        return $result;
    }
    public function getDataKurikulum(string $id): array
    {
        $stmt = $this->db->prepare("SELECT * FROM kurikulum WHERE id_kurikulum = ? ORDER BY tahun DESC");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    public function saveKurikulum(array $data, ?int $id = null): int
    {
        if ($id) {
            $sql  = "UPDATE kurikulum SET id_kurikulum=?, index_feeder=?, program_studi=?, tahun=?, nama=?, angkatan=?, obe=?, sks_wajib=?, sks_pilihan=?, sks_wajib_lulus=?, sks_pilihan_lulus=?, sks_ditawarkan=?, status=? WHERE id=?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                $data['id_kurikulum'], $data['index_feeder'], $data['program_studi'], $data['tahun'],
                $data['nama'], $data['angkatan'], $data['obe'],
                $data['sks_wajib'], $data['sks_pilihan'], $data['sks_wajib_lulus'], $data['sks_pilihan_lulus'],
                $data['sks_ditawarkan'], $data['status'], $id
            ]);
            return $id;
        }

        $sql = "INSERT INTO kurikulum
            (id_kurikulum, index_feeder, program_studi, tahun, nama, angkatan, obe, sks_wajib, sks_pilihan, sks_wajib_lulus, sks_pilihan_lulus, sks_ditawarkan, status)
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $data['id_kurikulum'], $data['index_feeder'], $data['program_studi'], $data['tahun'],
            $data['nama'], $data['angkatan'], $data['obe'],
            $data['sks_wajib'], $data['sks_pilihan'], $data['sks_wajib_lulus'], $data['sks_pilihan_lulus'],
            $data['sks_ditawarkan'], $data['status']
        ]);
        return (int) $this->db->lastInsertId();
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
