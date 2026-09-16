<?php
declare(strict_types=1);

final class ImportExportController
{
    private const MAHASISWA_FIELDS = [
        'nim', 'nik', 'nama', 'fakultas', 'program_studi', 'angkatan', 'jenis_kelamin',
        'tempat_lahir', 'tanggal_lahir', 'agama', 'status_nikah', 'no_telepon', 'no_hp',
        'email', 'jalur_masuk', 'alamat', 'kota', 'propinsi', 'kode_pos',
        'status_tempat_tinggal', 'pembiayaan_kuliah', 'tinggi_badan_cm', 'berat_badan_kg',
        'gol_darah', 'asal_sekolah', 'kota_sekolah', 'total_nilai_un', 'rata_nilai_un',
        'masuk_s1', 'tamat_s1', 'perguruan_tinggi_s1', 'fakultas_s1', 'prodi_s1', 'ipk_s1',
        'gelar_s1', 'nik_ayah', 'nama_ayah', 'nik_ibu', 'nama_ibu', 'status_ayah', 'status_ibu',
        'telepon_ortu', 'alamat_ortu', 'pekerjaan_ayah', 'pekerjaan_ibu', 'penghasilan_ortu',
        'jumlah_tanggungan_ortu', 'nama_wali', 'alamat_wali', 'telepon_wali', 'nomor_tes',
        'semester_masuk', 'jenis_pendaftaran', 'status_mahasiswa', 'semester_keluar', 'beasiswa'
    ];

    private const MAHASISWA_HEADERS = [
        'nim' => 'NIM',
        'nik' => 'NIK',
        'nama' => 'Nama',
        'fakultas' => 'Fakultas',
        'program_studi' => 'Program Studi',
        'angkatan' => 'Angkatan',
        'jenis_kelamin' => 'Jenis Kelamin',
        'tempat_lahir' => 'Tempat Lahir',
        'tanggal_lahir' => 'Tanggal Lahir',
        'agama' => 'Agama',
        'status_nikah' => 'Status Nikah',
        'no_telepon' => 'No Telepon',
        'no_hp' => 'No HP',
        'email' => 'Email',
        'jalur_masuk' => 'Jalur Masuk',
        'alamat' => 'Alamat',
        'kota' => 'Kota',
        'propinsi' => 'Propinsi',
        'kode_pos' => 'Kode Pos',
        'status_tempat_tinggal' => 'Status Tempat Tinggal',
        'pembiayaan_kuliah' => 'Pembiayaan Kuliah',
        'tinggi_badan_cm' => 'Tinggi Badan (cm)',
        'berat_badan_kg' => 'Berat Badan (kg)',
        'gol_darah' => 'Gol Darah',
        'asal_sekolah' => 'Asal Sekolah',
        'kota_sekolah' => 'Kota Sekolah',
        'total_nilai_un' => 'Total Nilai UN',
        'rata_nilai_un' => 'Rata Nilai UN',
        'masuk_s1' => 'Masuk S1',
        'tamat_s1' => 'Tamat S1',
        'perguruan_tinggi_s1' => 'Perguruan Tinggi S1',
        'fakultas_s1' => 'Fakultas S1',
        'prodi_s1' => 'Prodi S1',
        'ipk_s1' => 'IPK S1',
        'gelar_s1' => 'Gelar S1',
        'nik_ayah' => 'NIK Ayah',
        'nama_ayah' => 'Nama Ayah',
        'nik_ibu' => 'NIK Ibu',
        'nama_ibu' => 'Nama Ibu',
        'status_ayah' => 'Status Ayah',
        'status_ibu' => 'Status Ibu',
        'telepon_ortu' => 'Telepon Ortu',
        'alamat_ortu' => 'Alamat Ortu',
        'pekerjaan_ayah' => 'Pekerjaan Ayah',
        'pekerjaan_ibu' => 'Pekerjaan Ibu',
        'penghasilan_ortu' => 'Penghasilan Ortu',
        'jumlah_tanggungan_ortu' => 'Jumlah Tanggungan Ortu',
        'nama_wali' => 'Nama Wali',
        'alamat_wali' => 'Alamat Wali',
        'telepon_wali' => 'Telepon Wali',
        'nomor_tes' => 'Nomor Tes',
        'semester_masuk' => 'Semester Masuk',
        'jenis_pendaftaran' => 'Jenis Pendaftaran',
        'status_mahasiswa' => 'Status Mahasiswa',
        'semester_keluar' => 'Semester Keluar',
        'beasiswa' => 'Beasiswa',
    ];

    public function index(): void
    {
        require_login();
        render('import_export/index', [
            'title' => 'Import / Export',
            'subtitle' => 'Import data dari Excel/CSV dan export data',
            'active' => 'import_export',
            'pageScripts' => [
                'https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js',
                'assets/js/excel-import.js'
            ],
        ]);
    }

    public function import(): void
    {
        require_login();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit('Method tidak diizinkan.');
        }

        $entity = $_POST['entity'] ?? '';
        if (!verify_csrf($_POST['_csrf'] ?? '')) {
            http_response_code(419);
            exit('CSRF token tidak valid.');
        }

        if (!in_array($entity, ['dosen', 'mahasiswa'], true)) {
            http_response_code(400);
            exit('Modul import tidak valid.');
        }

        if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
            flash('danger', 'File gagal diunggah.');
            redirect('import-export.php');
        }

        $tmp = $_FILES['file']['tmp_name'];
        $name = $_FILES['file']['name'] ?? 'import.csv';
        $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));

        if (!in_array($ext, ['csv', 'xlsx', 'xls'], true)) {
            flash('danger', 'Format file harus CSV, XLSX, atau XLS.');
            redirect('import-export.php');
        }

        if ($ext !== 'csv') {
            flash('warning', 'Untuk import XLS/XLSX, gunakan Preview & Validasi terlebih dahulu agar file dikonversi ke CSV oleh SheetJS.');
            redirect('import-export.php');
        }

        $rows = $this->readCsv($tmp);
        if (!$rows) {
            flash('danger', 'File CSV kosong atau tidak memiliki data.');
            redirect('import-export.php');
        }

        $db = Database::connection();
        $count = 0;
        $inserted = 0;
        $updated = 0;
        $errors = [];

        foreach ($rows as $i => $rawRow) {
            $line = $i + 2;
            try {
                if ($entity === 'dosen') {
                    $result = $this->importDosenRow($db, $rawRow);
                } else {
                    $result = $this->importMahasiswaRow($db, $rawRow);
                }

                $count++;
                $inserted += $result === 'inserted' ? 1 : 0;
                $updated += $result === 'updated' ? 1 : 0;
            } catch (Throwable $e) {
                $errors[] = "Baris {$line}: " . $e->getMessage();
            }
        }

        $message = "{$count} baris berhasil diproses. {$inserted} data baru, {$updated} data diperbarui.";
        if ($errors) {
            $message .= ' ' . count($errors) . ' baris gagal.';
            $_SESSION['_import_errors'] = $errors;
        }

        flash($errors ? 'warning' : 'success', $message);
        redirect('import-export.php');
    }

    private function readCsv(string $tmp): array
    {
        $fh = fopen($tmp, 'r');
        if ($fh === false) {
            throw new RuntimeException('CSV tidak dapat dibaca.');
        }

        $headers = fgetcsv($fh);
        if (!$headers) {
            fclose($fh);
            return [];
        }

        $headers = array_map(fn($v) => $this->normalizeHeader((string)$v), $headers);
        $rows = [];

        while (($row = fgetcsv($fh)) !== false) {
            if (count(array_filter($row, fn($v) => trim((string)$v) !== '')) === 0) {
                continue;
            }

            $row = array_pad($row, count($headers), '');
            $row = array_slice($row, 0, count($headers));
            $combined = [];

            foreach ($headers as $index => $header) {
                if ($header === '') {
                    continue;
                }
                $combined[$header] = trim((string)($row[$index] ?? ''));
            }

            $rows[] = $combined;
        }

        fclose($fh);
        return $rows;
    }

    private function normalizeHeader(string $header): string
    {
        $header = preg_replace('/^\xEF\xBB\xBF/', '', $header) ?? $header;
        $header = trim($header);
        return strtoupper(preg_replace('/\s+/', ' ', $header) ?? $header);
    }

    private function importDosenRow(PDO $db, array $r): string
    {
        $key = $this->clean($this->get($r, ['NIDN']));
        $nama = $this->clean($this->get($r, ['NAMA', 'NAMA DOSEN']));

        if ($key === '' || $nama === '') {
            throw new RuntimeException('NIDN dan Nama wajib diisi.');
        }

        $find = $db->prepare('SELECT id FROM dosen WHERE nidn = ? LIMIT 1');
        $find->execute([$key]);
        $existingId = $find->fetchColumn();

        $fields = [
            'nip' => $this->get($r, ['NIP']),
            'gelar_depan' => $this->get($r, ['GELAR_DEPAN']),
            'nama' => $nama,
            'gelar_belakang' => $this->get($r, ['GELAR_ELAKANG', 'GELAR BELAKANG']),
            'jabatan' => $this->get($r, ['JABATAN_AKADEMIK', 'JABATAN AKADEMIK']),
            'pendidikan_terakhir' => $this->get($r, ['PENDIDIKAN_TERAKHIR', 'PENDIDIKAN TERAKHIR']),
            'pangkat' => $this->get($r, ['GOLONGAN', 'PANGKAT']),
            'status' => $this->get($r, ['STATUS']),
            'homebase' => $this->get($r, ['HOMEBASE']),
            'email' => $this->get($r, ['EMAIL']),
        ];

        if ($existingId === false) {
            $stmt = $db->prepare(
                'INSERT INTO dosen (nip, nidn, gelar_depan, nama, gelar_belakang, jabatan, pendidikan_terakhir, pangkat, status, homebase, email)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'
            );
            $stmt->execute([
                $this->nullIfEmpty($fields['nip']),
                $key,
                $this->nullIfEmpty($fields['gelar_depan']),
                $fields['nama'],
                $this->nullIfEmpty($fields['gelar_belakang']),
                $this->nullIfEmpty($fields['jabatan']),
                $this->nullIfEmpty($fields['pendidikan_terakhir']),
                $this->nullIfEmpty($fields['pangkat']),
                $this->nullIfEmpty($fields['status']),
                $this->nullIfEmpty($fields['homebase']),
                $this->nullIfEmpty($fields['email']),
            ]);
            return 'inserted';
        }

        $this->partialUpdate($db, 'dosen', $fields, (int)$existingId);
        return 'updated';
    }

    private function importMahasiswaRow(PDO $db, array $r): string
    {
        $key = $this->clean($this->get($r, ['NIM']));
        $nama = $this->clean($this->get($r, ['NAMA']));

        if ($key === '' || $nama === '') {
            throw new RuntimeException('NIM dan Nama wajib diisi.');
        }

        $find = $db->prepare('SELECT id FROM mahasiswa WHERE nim = ? LIMIT 1');
        $find->execute([$key]);
        $existingId = $find->fetchColumn();

        $values = $this->studentValues($r, $nama);

        if ($existingId === false) {
            $columns = implode(', ', array_map(fn($field) => "`{$field}`", self::MAHASISWA_FIELDS));
            $placeholders = implode(', ', array_fill(0, count(self::MAHASISWA_FIELDS), '?'));
            $params = [];
            foreach (self::MAHASISWA_FIELDS as $field) {
                $params[] = $values[$field] ?? null;
            }

            $stmt = $db->prepare("INSERT INTO mahasiswa ({$columns}) VALUES ({$placeholders})");
            $stmt->execute($params);
            return 'inserted';
        }

        $this->partialUpdate($db, 'mahasiswa', $values, (int)$existingId);
        return 'updated';
    }

    private function studentValues(array $r, string $nama): array
    {
        $raw = [
            'nim' => $this->get($r, ['NIM']),
            'nik' => $this->get($r, ['NIK']),
            'nama' => $nama,
            'fakultas' => $this->get($r, ['FAKULTAS']),
            'program_studi' => $this->get($r, ['PROGRAM STUDI', 'PRODI']),
            'angkatan' => $this->get($r, ['ANGKATAN']),
            'jenis_kelamin' => $this->get($r, ['JENIS KELAMIN', 'JK']),
            'tempat_lahir' => $this->get($r, ['TEMPAT LAHIR']),
            'tanggal_lahir' => $this->get($r, ['TANGGAL LAHIR']),
            'agama' => $this->get($r, ['AGAMA']),
            'status_nikah' => $this->get($r, ['STATUS NIKAH']),
            'no_telepon' => $this->get($r, ['NO TELEPON']),
            'no_hp' => $this->get($r, ['NO HP']),
            'email' => $this->get($r, ['EMAIL']),
            'jalur_masuk' => $this->get($r, ['JALUR MASUK']),
            'alamat' => $this->get($r, ['ALAMAT']),
            'kota' => $this->get($r, ['KOTA']),
            'propinsi' => $this->get($r, ['PROPINSI', 'PROVINSI']),
            'kode_pos' => $this->get($r, ['KODE POS']),
            'status_tempat_tinggal' => $this->get($r, ['STATUS TEMPAT TINGGAL']),
            'pembiayaan_kuliah' => $this->get($r, ['PEMBIAYAAN KULIAH']),
            'tinggi_badan_cm' => $this->get($r, ['TINGGI BADAN (CM)', 'TINGGI BADAN']),
            'berat_badan_kg' => $this->get($r, ['BERAT BADAN (KG)', 'BERAT BADAN']),
            'gol_darah' => $this->get($r, ['GOL DARAH', 'GOLONGAN DARAH']),
            'asal_sekolah' => $this->get($r, ['ASAL SEKOLAH']),
            'kota_sekolah' => $this->get($r, ['KOTA SEKOLAH']),
            'total_nilai_un' => $this->get($r, ['TOTAL NILAI UN']),
            'rata_nilai_un' => $this->get($r, ['RATA NILAI UN', 'RATA-RATA NILAI UN', 'RATA RATA NILAI UN']),
            'masuk_s1' => $this->get($r, ['MASUK S1']),
            'tamat_s1' => $this->get($r, ['TAMAT S1']),
            'perguruan_tinggi_s1' => $this->get($r, ['PERGURUAN TINGGI S1']),
            'fakultas_s1' => $this->get($r, ['FAKULTAS S1']),
            'prodi_s1' => $this->get($r, ['PRODI S1']),
            'ipk_s1' => $this->get($r, ['IPK S1']),
            'gelar_s1' => $this->get($r, ['GELAR S1']),
            'nik_ayah' => $this->get($r, ['NIK AYAH']),
            'nama_ayah' => $this->get($r, ['NAMA AYAH']),
            'nik_ibu' => $this->get($r, ['NIK IBU']),
            'nama_ibu' => $this->get($r, ['NAMA IBU']),
            'status_ayah' => $this->get($r, ['STATUS AYAH']),
            'status_ibu' => $this->get($r, ['STATUS IBU']),
            'telepon_ortu' => $this->get($r, ['TELEPON ORTU', 'TELEPON ORANG TUA']),
            'alamat_ortu' => $this->get($r, ['ALAMAT ORTU', 'ALAMAT ORANG TUA']),
            'pekerjaan_ayah' => $this->get($r, ['PEKERJAAN AYAH']),
            'pekerjaan_ibu' => $this->get($r, ['PEKERJAAN IBU']),
            'penghasilan_ortu' => $this->get($r, ['PENGHASILAN ORTU', 'PENGHASILAN ORANG TUA']),
            'jumlah_tanggungan_ortu' => $this->get($r, ['JUMLAH TANGGUNGAN ORTU', 'JUMLAH TANGGUNGAN ORANG TUA']),
            'nama_wali' => $this->get($r, ['NAMA WALI']),
            'alamat_wali' => $this->get($r, ['ALAMAT WALI']),
            'telepon_wali' => $this->get($r, ['TELEPON WALI']),
            'nomor_tes' => $this->get($r, ['NOMOR TES']),
            'semester_masuk' => $this->get($r, ['SEMESTER MASUK']),
            'jenis_pendaftaran' => $this->get($r, ['JENIS PENDAFTARAN']),
            'status_mahasiswa' => $this->get($r, ['STATUS MAHASISWA', 'STATUS']),
            'semester_keluar' => $this->get($r, ['SEMESTER KELUAR']),
            'beasiswa' => $this->get($r, ['BEASISWA']),
        ];

        $result = [];
        foreach ($raw as $field => $value) {
            $value = $this->clean($value);
            if ($value === '') {
                $result[$field] = null;
                continue;
            }

            $result[$field] = match ($field) {
                'angkatan', 'masuk_s1', 'tamat_s1' => $this->yearOrNull($value),
                'tanggal_lahir' => $this->dateOrNull($value),
                'tinggi_badan_cm', 'berat_badan_kg', 'total_nilai_un', 'rata_nilai_un', 'ipk_s1' => $this->decimalOrNull($value),
                'jumlah_tanggungan_ortu' => ctype_digit($value) ? (int)$value : null,
                default => $value,
            };
        }

        // NIM and Nama are required; do not allow an invalid converted value.
        if ($result['nim'] === null || $result['nama'] === null) {
            throw new RuntimeException('NIM dan Nama wajib diisi.');
        }

        return $result;
    }

    private function partialUpdate(PDO $db, string $table, array $fields, int $id): void
    {
        $allowed = $table === 'mahasiswa'
            ? self::MAHASISWA_FIELDS
            : ['nip', 'gelar_depan', 'nama', 'gelar_belakang', 'jabatan', 'pendidikan_terakhir', 'pangkat', 'status', 'homebase', 'email'];

        $updates = [];
        $params = [];
        foreach ($fields as $column => $value) {
            if (!in_array($column, $allowed, true) || $column === 'nim' || $column === 'nidn') {
                continue;
            }

            // Empty cells never erase existing values during import.
            if ($value === null || trim((string)$value) === '') {
                continue;
            }

            $updates[] = "`{$column}` = ?";
            $params[] = $value;
        }

        if (!$updates) {
            return;
        }

        $params[] = $id;
        $stmt = $db->prepare("UPDATE `{$table}` SET " . implode(', ', $updates) . ' WHERE id = ?');
        $stmt->execute($params);
    }

    private function get(array $row, array $keys): string
    {
        foreach ($keys as $key) {
            $normalized = $this->normalizeHeader($key);
            if (array_key_exists($normalized, $row)) {
                return (string)$row[$normalized];
            }
        }
        return '';
    }

    private function clean(mixed $value): string
    {
        return trim((string)$value);
    }

    private function nullIfEmpty(mixed $value): mixed
    {
        $value = $this->clean($value);
        return $value === '' ? null : $value;
    }

    private function yearOrNull(string $value): ?int
    {
        $value = trim($value);
        if ($value === '' || !is_numeric($value)) {
            return null;
        }
        $year = (int)$value;
        return ($year >= 1900 && $year <= 2200) ? $year : null;
    }

    private function decimalOrNull(string $value): ?float
    {
        $value = trim(str_replace(',', '.', $value));
        if ($value === '' || !is_numeric($value)) {
            return null;
        }
        return (float)$value;
    }

    private function dateOrNull(string $value): ?string
    {
        $value = trim($value);
        if ($value === '') {
            return null;
        }

        foreach (['Y-m-d', 'd/m/Y', 'd-m-Y', 'm/d/Y'] as $format) {
            $date = DateTime::createFromFormat($format, $value);
            if ($date && $date->format($format) === $value) {
                return $date->format('Y-m-d');
            }
        }

        return null;
    }

    public function export(): void
    {
        require_login();
        $entity = $_GET['entity'] ?? '';

        if (!in_array($entity, ['dosen', 'mahasiswa'], true)) {
            http_response_code(400);
            exit('Modul export tidak valid.');
        }

        if ($entity === 'mahasiswa') {
            $columns = self::MAHASISWA_FIELDS;
            $headers = array_map(fn($field) => self::MAHASISWA_HEADERS[$field], $columns);
        } else {
            $columns = ['nip', 'nidn', 'gelar_depan', 'nama', 'gelar_belakang', 'jabatan', 'pendidikan_terakhir', 'pangkat', 'status', 'homebase', 'email'];
            $headers = ['NIP', 'NIDN', 'GELAR_DEPAN', 'NAMA', 'GELAR_ELAKANG', 'JABATAN_AKADEMIK', 'PENDIDIKAN_TERAKHIR', 'GOLONGAN', 'STATUS', 'HOMEBASE', 'EMAIL'];
        }

        $stmt = Database::connection()->query(
            'SELECT ' . implode(',', array_map(fn($column) => "`{$column}`", $columns)) . " FROM `{$entity}` ORDER BY nama ASC"
        );

        $filename = $entity . '_export_' . date('Ymd_His') . '.csv';
        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $out = fopen('php://output', 'w');
        fprintf($out, "\xEF\xBB\xBF");
        fputcsv($out, $headers);
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            fputcsv($out, $row);
        }
        fclose($out);
        exit;
    }

    public function template(): void
    {
        require_login();
        $entity = $_GET['entity'] ?? '';

        if ($entity === 'mahasiswa') {
            $headers = array_values(self::MAHASISWA_HEADERS);
            $sample = array_fill(0, count($headers), '');
            $sample[0] = '20260001';
            $sample[2] = 'Contoh Mahasiswa';
            $sample[4] = 'Pendidikan Komputer';
            $sample[5] = '2026';
            $sample[6] = 'L';
            $sample[12] = '081234567890';
            $sample[13] = 'mahasiswa@example.com';
            $sample[50] = '1';
            $sample[53] = 'Aktif';
            $lines = [$headers, $sample];
        } elseif ($entity === 'dosen') {
            $lines = [
                ['NIP', 'NIDN', 'GELAR_DEPAN', 'NAMA', 'GELAR_ELAKANG', 'JABATAN_AKADEMIK', 'PENDIDIKAN_TERAKHIR', 'GOLONGAN', 'STATUS', 'HOMEBASE', 'EMAIL'],
                ['1980000000000000', '0012345678', '', 'Contoh Dosen', '', 'Lektor', 'S2', 'III/c (Penata)', 'Aktif', 'Pendidikan Komputer', 'dosen@example.ac.id']
            ];
        } else {
            http_response_code(400);
            exit('Template tidak valid.');
        }

        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="template_' . $entity . '.csv"');
        $out = fopen('php://output', 'w');
        fprintf($out, "\xEF\xBB\xBF");
        foreach ($lines as $line) {
            fputcsv($out, $line);
        }
        fclose($out);
        exit;
    }
}
