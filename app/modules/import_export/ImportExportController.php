<?php
declare (strict_types = 1);

final class ImportExportController
{

    public function index(): void
    {
        // require_login();
        global $tabel_lists;
        render('import_export/views/index', [
            'title'       => 'Import / Export',
            'subtitle'    => 'Import data dari Excel/CSV dan export data',
            'active'      => 'import_export',
            'tables'      => $tabel_lists,
            'pageScripts' => [
                'https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js',
                'assets/js/excel-import.js',
            ],
        ]);
    }

    public function import(): void
    {
        // require_login();

        global $tabel_lists;
        global $tables;

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit('Method tidak diizinkan.');
        }

        $entity = $_POST['entity'] ?? '';
        if (! verify_csrf($_POST['_csrf'] ?? '')) {
            http_response_code(419);
            exit('CSRF token tidak valid.');
        }

        if (! array_key_exists($entity, $tables)) {
            flash('danger', 'Modul tidak falid.');
            redirect('import-export.php');
        }

        if (! isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
            flash('danger', 'File gagal diunggah.');
            redirect('import-export.php');
        }

        $tmp  = $_FILES['file']['tmp_name'];
        $name = $_FILES['file']['name'] ?? 'import.csv';
        $ext  = strtolower(pathinfo($name, PATHINFO_EXTENSION));

        // if (!in_array($ext, ['csv', 'xlsx', 'xls'], true)) {
        //     flash('danger', 'Format file harus CSV, XLSX, atau XLS.');
        //     redirect('import-export.php');
        // }

        if ($ext !== 'csv') {
            flash('warning', 'Untuk import XLS/XLSX, gunakan Preview & Validasi terlebih dahulu agar file dikonversi ke CSV oleh SheetJS.');
            redirect('import-export.php');
        }

        $rows = $this->readCsv($tmp);
        if (! $rows) {
            flash('danger', 'File CSV kosong atau tidak memiliki data.');
            redirect('import-export.php');
        }

        $db       = Database::connection();
        $count    = 0;
        $inserted = 0;
        $updated  = 0;
        $errors   = [];
        $message  = '';

        foreach ($rows as $i => $rawRow) {
            $line = $i + 2;

            try {

                $result = $this->importDataRow($db, $entity, $rawRow);
                $count++;

                $inserted += $result === 'inserted' ? 1 : 0;
                $updated  += $result === 'updated' ? 1 : 0;
            } catch (Throwable $e) {
                $errors[] = "Baris {$line}: " . $e->getMessage();
            }
        }

        $message = "{$count} baris berhasil diproses. {$inserted} data baru, {$updated} data diperbarui.";
        if ($errors) {
            $message                    .= ' ' . count($errors) . ' baris gagal. ' . implode($errors);
            $_SESSION['_import_errors']  = $errors;
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
        if (! $headers) {
            fclose($fh);
            return [];
        }

        $headers      = array_map(fn($v) => $this->normalizeHeader((string) $v), $headers);
        $rows         = [];
        $currentIndex = 0;

        while (($row = fgetcsv($fh)) !== false) {
            // Abaikan jika indeks kurang dari 2
            if ($currentIndex < 1) {
                $currentIndex++;
                continue;
            }

            if (count(array_filter($row, fn($v) => trim((string) $v) !== '')) === 0) {
                continue;
            }

            $row      = array_pad($row, count($headers), '');
            $row      = array_slice($row, 0, count($headers));
            $combined = [];

            foreach ($headers as $index => $header) {
                if ($header === '') {
                    continue;
                }
                $combined[$header] = trim((string) ($row[$index] ?? ''));
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
    private function importDataRow(PDO $db, string $table, array $r): string
    {
        global $tables;
        $d   = $tables[$table];
        $key = $this->clean($this->get($r, $d['key']));
        if ($key === '') {
            throw new RuntimeException(implode($d['key']) . " wajib diisi.");
        }
	$kunci = '';
	$key_parm = [];
	foreach($d['key'] as $i => $key_col){
		$kunci .= "$key_col = ?";
		if($i < count($d['key'])-1){
		$kunci .= " && ";
		}
		$key_parm[$i] = $this->clean($this->get($r, [$key_col]));
		
	}
        $find = $db->prepare("SELECT id FROM $table WHERE " . $kunci . " LIMIT 1");
        $find->execute($key_parm);
        $existingId = $find->fetchColumn();
        $fields     = [];

        foreach ($d['field'] as $f) {
            $row        = strtoupper($f);
            $fields[$f] = $this->clean($this->get($r, [$row]));
        }

        if ($existingId === false) {
            $columns      = implode(',', $d['field']);
            $placeholders = implode(',', array_fill(0, count($d['field']), '?'));
            $params       = implode('&;&', $fields);
            $value        = explode('&;&', $params);
            $stmt         = $db->prepare("INSERT INTO $table ({$columns}) VALUES ({$placeholders})");
            $stmt->execute($value);
            return 'inserted';
        }
        $this->partialUpdate($db, $table, $fields, (int) $existingId);
        return 'updated';
    }

    private function partialUpdate(PDO $db, string $table, array $fields, int $id): void
    {
	global $tables;
        $allowed = $tables[$table]['field'];

        $updates = [];
        $params  = [];
        foreach ($fields as $column => $value) {
            if (! in_array($column, $allowed, true) || $column === 'nim' || $column === 'nidn') {
                continue;
            }

            // Empty cells never erase existing values during import.
            if ($value === null || trim((string) $value) === '') {
                continue;
            }

            $updates[] = "`{$column}` = ?";
            $params[]  = $value;
        }

        if (! $updates) {
            return;
        }

        $params[] = $id;
        $stmt     = $db->prepare("UPDATE `{$table}` SET " . implode(', ', $updates) . ' WHERE id = ?');
        $stmt->execute($params);
    }

    private function get(array $row, array $keys): string
    {
        foreach ($keys as $key) {
            $normalized = $this->normalizeHeader($key);
            if (array_key_exists($normalized, $row)) {
                return (string) $row[$normalized];
            }
        }
        return '';
    }

    private function clean(mixed $value): string
    {
        return trim((string) $value);
    }

    private function nullIfEmpty(mixed $value): mixed
    {
        $value = $this->clean($value);
        return $value === '' ? null : $value;
    }

    private function yearOrNull(string $value): ?int
    {
        $value = trim($value);
        if ($value === '' || ! is_numeric($value)) {
            return null;
        }
        $year = (int) $value;
        return ($year >= 1900 && $year <= 2200) ? $year : null;
    }

    private function decimalOrNull(string $value): ?float
    {
        $value = trim(str_replace(',', '.', $value));
        if ($value === '' || ! is_numeric($value)) {
            return null;
        }
        return (float) $value;
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
        // require_login();

        global $tables;

        $entity = $_GET['entity'] ?? '';
        $d      = $tables[$entity];

        if (! array_key_exists($entity, $tables)) {
            flash('danger', 'File gagal diexport.');
            redirect('import-export.php');
        }

        //  untuk $columns = $tables[$entity][$field], untuk $header = Upper $columns;
        $columns = $d['field'];
        $headers = array_map('strtoupper', $columns);

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet;

        // Paksa semua nilai cell menjadi string
        \PhpOffice\PhpSpreadsheet\Cell\Cell::setValueBinder(
            new \PhpOffice\PhpSpreadsheet\Cell\StringValueBinder()
        );

        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Tabel ' . $entity);

        // Ambil data
        $stmt = Database::connection()->query(
            'SELECT ' . implode(',', $columns) .
            " FROM `{$entity}` ORDER BY `{$columns[0]}` ASC"
        );

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Masukkan data
        $sheet->fromArray($headers, null, 'A1');
        $sheet->fromArray($rows, null, 'A2');
        $lastColumn = $sheet->getHighestColumn();

        foreach (range('A', $lastColumn) as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Download
        $filename = $entity . '_export_' . date('Ymd_His') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter(
            $spreadsheet,
            'Xlsx'
        );

        $writer->save('php://output');
        exit;
    }

}
