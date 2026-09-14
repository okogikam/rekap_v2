<?php
declare(strict_types=1);

final class ImportExportController
{
    public function index(): void
    {
        require_login();
        render('import_export/index', [
            'title'=>'Import / Export',
            'subtitle'=>'Import data dari Excel/CSV dan export data',
            'active'=>'import_export',
            'pageScripts'=>[
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
        $token = $_POST['_csrf'] ?? '';

        if (!verify_csrf($token)) {
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

        $rows = [];

        if ($ext === 'csv') {
            $fh = fopen($tmp, 'r');
            $headers = fgetcsv($fh);

            if (!$headers) {
                fclose($fh);
                flash('danger', 'File CSV kosong atau header tidak ditemukan.');
                redirect('import-export.php');
            }

            $headers = array_map(
                fn($v) => trim((string)$v),
                $headers
            );

            while (($r = fgetcsv($fh)) !== false) {
                if (count(array_filter($r, fn($v) => trim((string)$v) !== '')) === 0) {
                    continue;
                }

                $r = array_pad($r, count($headers), '');
                $r = array_slice($r, 0, count($headers));

                $combined = array_combine($headers, $r);
                if ($combined !== false) {
                    $rows[] = $combined;
                }
            }

            fclose($fh);
        } else {
            /*
             * XLS/XLSX dipreview dan dikonversi menjadi CSV oleh SheetJS
             * di browser sebelum dikirim ke endpoint ini.
             */
            flash(
                'warning',
                'Untuk import XLS/XLSX, gunakan Preview & Validasi terlebih dahulu.'
            );
            redirect('import-export.php');
        }

        $db = Database::connection();
        $count = 0;
        $inserted = 0;
        $updated = 0;
        $errors = [];

        /*
         * Prinsip import:
         *
         * 1. NIDN/NIM menjadi KEY pencarian data.
         * 2. Jika data belum ada -> INSERT.
         * 3. Jika data sudah ada -> UPDATE HANYA KOLOM YANG DIISI.
         * 4. Sel kosong pada file TIDAK akan menghapus data lama.
         *
         * Contoh:
         * Database:
         *   NIM=123, Nama=andi, Angkatan=2025
         *
         * File:
         *   NIM=123, Nama=Andi, Angkatan=
         *
         * Hasil:
         *   NIM=123, Nama=Andi, Angkatan=2025
         */

        $clean = static function (mixed $value): string {
            return trim((string)$value);
        };

        foreach ($rows as $i => $r) {
            $line = $i + 2;

            try {
                if ($entity === 'dosen') {
                    $key = $clean($r['NIDN'] ?? $r['nidn'] ?? '');
                    $nama = $clean($r['Nama'] ?? $r['nama'] ?? '');

                    if ($key === '' || $nama === '') {
                        throw new RuntimeException('NIDN dan Nama wajib diisi.');
                    }

                    $find = $db->prepare("SELECT id FROM dosen WHERE nidn = ? LIMIT 1");
                    $find->execute([$key]);
                    $existingId = $find->fetchColumn();

                    if ($existingId === false) {
                        $stmt = $db->prepare(
                            "INSERT INTO dosen
                            (nip, nidn, gelar_depan, nama, gelar_belakang, jabatan, pendidikan_terakhir, pangkat, status, homebase, email)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
                        );

                        $nip = $clean($r['NIP'] ?? '');
                        $gelarDepan = $clean($r['GELAR_DEPAN'] ?? '');
                        $gelarBelakang = $clean($r['GELAR_ELAKANG'] ?? '');
                        $jabatan = $clean($r['JABATAN_AKADEMIK'] ?? '');
                        $pendidikan = $clean($r['PENDIDIKAN_TERAKHIR'] ?? '');
                        $pangkat = $clean($r['GOLONGAN'] ?? '');
                        $status = $clean($r['STATUS'] ?? '');
                        $homebase = $clean($r['HOMEBASE'] ?? '');
                        $email = $clean($r['EMAIL'] ?? '');

                        $stmt->execute([
                            $nip !== '' ? $nip : null,
                            $key,
                            $gelarDepan !== '' ? $gelarDepan : null,
                            $nama,
                            $gelarBelakang !== '' ? $gelarBelakang : null,
                            $jabatan !== '' ? $jabatan : null,
                            $pendidikan !== '' ? $pendidikan : null,
                            $pangkat !== '' ? $pangkat : null,
                            $status !== '' ? $status : null,
                            $homebase !== '' ? $homebase : null,
                            $email !== '' ? $email : null
                        ]);

                        $inserted++;
                    } else {
                        $updates = [];
                        $params = [];

                        // Key NIDN tidak diubah. Hanya kolom yang benar-benar berisi.
                        $fields = [
                            'nama' => $nama,
                            'nip' => $clean($r['NIP'] ?? ''),
                            'gelar_depan' => $clean($r['GELAR_DEPAN'] ?? ''),
                            'gelar_belakang' => $clean($r['GELAR_ELAKANG'] ?? ''),
                            'email' => $clean($r['EMAIL'] ?? ''),
                            'jabatan' => $clean($r['JABATAN_AKADEMIK'] ?? ''),
                            'pendidikan_terakhir' => $clean($r['PENDIDIKAN_TERAKHIR'] ?? ''),
                            'pangkat' => $clean($r['GOLONGAN'] ?? ''),
                            'status' => $clean($r['STATUS'] ?? ''),
                            'homebase' => $clean($r['HOMEBASE'] ?? ''),
                        ];

                        foreach ($fields as $column => $value) {
                            if ($value === '') {
                                continue;
                            }

                            if ($column === 'jenis_kelamin' && !in_array($value, ['L', 'P'], true)) {
                                continue;
                            }

                            if ($column === 'status' && !in_array($value, ['aktif', 'nonaktif'], true)) {
                                continue;
                            }

                            $updates[] = "`{$column}` = ?";
                            $params[] = $value;
                        }

                        if ($updates) {
                            $params[] = (int)$existingId;
                            $stmt = $db->prepare(
                                "UPDATE dosen SET " . implode(', ', $updates) . " WHERE id = ?"
                            );
                            $stmt->execute($params);
                        }

                        $updated++;
                    }
                } else {
                    $key = $clean($r['NIM'] ?? $r['nim'] ?? '');
                    $nama = $clean($r['Nama'] ?? $r['nama'] ?? '');

                    if ($key === '' || $nama === '') {
                        throw new RuntimeException('NIM dan Nama wajib diisi.');
                    }

                    $find = $db->prepare("SELECT id FROM mahasiswa WHERE nim = ? LIMIT 1");
                    $find->execute([$key]);
                    $existingId = $find->fetchColumn();

                    if ($existingId === false) {
                        $email = $clean($r['Email'] ?? '');
                        $prodi = $clean($r['Prodi'] ?? '');
                        $angkatan = $clean($r['Angkatan'] ?? '');
                        $semester = $clean($r['Semester'] ?? '');
                        $jk = $clean($r['Jenis Kelamin'] ?? '');
                        $status = $clean($r['Status'] ?? '');

                        $stmt = $db->prepare(
                            "INSERT INTO mahasiswa
                            (nim, nama, email, prodi, angkatan, semester, jenis_kelamin, status)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
                        );

                        $stmt->execute([
                            $key,
                            $nama,
                            $email !== '' ? $email : null,
                            $prodi !== '' ? $prodi : null,
                            ctype_digit($angkatan) ? (int)$angkatan : null,
                            ctype_digit($semester) ? (int)$semester : null,
                            in_array($jk, ['L', 'P'], true) ? $jk : null,
                            in_array($status, ['aktif', 'cuti', 'lulus', 'nonaktif'], true)
                                ? $status
                                : 'aktif'
                        ]);

                        $inserted++;
                    } else {
                        $updates = [];
                        $params = [];

                        /*
                         * Untuk record yang sudah ada:
                         * - nilai kosong dilewati
                         * - nilai lama tetap dipertahankan
                         * - nilai baru yang berisi akan menggantikan nilai lama
                         */
                        $fields = [
                            'nama' => $nama,
                            'email' => $clean($r['Email'] ?? ''),
                            'prodi' => $clean($r['Prodi'] ?? ''),
                            'angkatan' => $clean($r['Angkatan'] ?? ''),
                            'semester' => $clean($r['Semester'] ?? ''),
                            'jenis_kelamin' => $clean($r['Jenis Kelamin'] ?? ''),
                            'status' => $clean($r['Status'] ?? ''),
                        ];

                        foreach ($fields as $column => $value) {
                            if ($value === '') {
                                continue;
                            }

                            if ($column === 'angkatan' && !ctype_digit($value)) {
                                continue;
                            }

                            if ($column === 'semester' && !ctype_digit($value)) {
                                continue;
                            }

                            if ($column === 'jenis_kelamin' && !in_array($value, ['L', 'P'], true)) {
                                continue;
                            }

                            if ($column === 'status' &&
                                !in_array($value, ['aktif', 'cuti', 'lulus', 'nonaktif'], true)) {
                                continue;
                            }

                            $updates[] = "`{$column}` = ?";
                            $params[] = $column === 'angkatan' || $column === 'semester'
                                ? (int)$value
                                : $value;
                        }

                        if ($updates) {
                            $params[] = (int)$existingId;
                            $stmt = $db->prepare(
                                "UPDATE mahasiswa SET " . implode(', ', $updates) . " WHERE id = ?"
                            );
                            $stmt->execute($params);
                        }

                        $updated++;
                    }
                }

                $count++;
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

    public function export(): void
    {
        require_login();
        $entity=$_GET['entity']??'';
        if(!in_array($entity,['dosen','mahasiswa'],true)){http_response_code(400);exit('Modul export tidak valid.');}

        $columns = $entity==='dosen'
            ? ['nip','nidn','gelar_depan','nama','gelar_belakang','jabatan','pendidikan_terakhir','pangkat','status','homebase','email']
            : ['nim','nama','email','prodi','angkatan','semester','jenis_kelamin','status'];

        $stmt=Database::connection()->query("SELECT ".implode(',', $columns)." FROM {$entity} ORDER BY nama ASC");
        $filename=$entity.'_export_'.date('Ymd_His').'.csv';

        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="'.$filename.'"');
        $out=fopen('php://output','w');
        fprintf($out, "\xEF\xBB\xBF");
        fputcsv($out, array_map(fn($v)=>strtoupper($v), $columns));
        while($row=$stmt->fetch(PDO::FETCH_ASSOC)) fputcsv($out,$row);
        fclose($out);
        exit;
    }

    public function template(): void
    {
        require_login();
        $entity=$_GET['entity']??'';
        $templates=[
            'dosen'=>[
                ['NIP','NIDN','GELAR_DEPAN','NAMA','GELAR_ELAKANG','JABATAN_AKADEMIK','PENDIDIKAN_TERAKHIR','GOLONGAN','STATUS','HOMEBASE','EMAIL'],
                ['1980000000000000','0012345678','','Contoh Dosen','','Lektor','S2','III/c (Penata)','Aktif','Pendidikan Komputer','dosen@example.ac.id']
            ],
            'mahasiswa'=>[
                ['NIM','Nama','Email','Prodi','Angkatan','Semester','Jenis Kelamin','Status'],
                ['20260001','Contoh Mahasiswa','mahasiswa@example.com','Pendidikan Komputer','2026','1','L','aktif']
            ],
        ];
        if(!isset($templates[$entity])){http_response_code(400);exit('Template tidak valid.');}
        header('Content-Type:text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="template_'.$entity.'.csv"');
        $out=fopen('php://output','w'); fprintf($out,"\xEF\xBB\xBF");
        foreach($templates[$entity] as $line) fputcsv($out,$line);
        fclose($out); exit;
    }
}
