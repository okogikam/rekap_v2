<?php
declare(strict_types=1);

final class DashboardController
{
    public function index(): void
    {
        // require_login();

        $model = new DashboardModel(Database::connection());

        render('dashboard/views/index', [
            'title' => 'Dashboard',
            'subtitle' => 'Ringkasan administrasi dosen dan mahasiswa',
            'active' => 'dashboard',
            'pageScripts' => ['https://cdn.jsdelivr.net/npm/chart.js'],
            'stats' => [
                'mahasiswa_lulus' => $model->countLulus('mahasiswa'),
                'mahasiswa_pindah' => $model->countPindah('mahasiswa'),
                'mahasiswa_mundur' => $model->countMundur('mahasiswa'),
                'mahasiswa_aktif' => $model->countActive('mahasiswa'),
            ],
            'angkatan' => $model->query("SELECT angkatan, COUNT(nim) AS jml, COUNT(CASE WHEN LOWER(status_mahasiswa) = 'aktif' THEN 1 ELSE null END) AS aktif, COUNT(CASE WHEN LOWER(status_mahasiswa) = 'lulus' THEN 1 ELSE null END) AS lulus, COUNT(CASE WHEN LOWER(status_mahasiswa) = 'pindah' THEN 1 ELSE null END) AS pindah FROM mahasiswa GROUP BY angkatan DESC"),
        ]);
    }
}
