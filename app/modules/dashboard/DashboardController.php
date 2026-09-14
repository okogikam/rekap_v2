<?php
declare(strict_types=1);

final class DashboardController
{
    public function index(): void
    {
        require_login();

        $model = new DashboardModel(Database::connection());

        render('dashboard/index', [
            'title' => 'Dashboard',
            'subtitle' => 'Ringkasan administrasi dosen dan mahasiswa',
            'active' => 'dashboard',
            'stats' => [
                'dosen' => $model->count('dosen'),
                'dosen_aktif' => $model->countActive('dosen'),
                'mahasiswa' => $model->count('mahasiswa'),
                'mahasiswa_aktif' => $model->countActive('mahasiswa'),
            ],
        ]);
    }
}
