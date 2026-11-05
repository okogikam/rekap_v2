<?php
declare(strict_types=1);

final class KurikulumController
{
    public function index(): void
    {
        // require_login();

        $model = new KurikulumModel(Database::connection());

        render('kurikulum/views/index', [
            'title' => 'Kurikulum',
            'subtitle' => 'Halaman Kurikulum',
            'active' => 'kurikulum',
        ]);
    }
	public function detail(): void
    {
        // require_login();

        $model = new KurikulumModel(Database::connection());

        render('kurikulum/views/detail', [
            'title' => 'Detail Kurikulum',
            'subtitle' => 'Halaman Detail Kurikulum',
            'active' => 'kurikulum',
        ]);
    }
    public function formKurikulum(): void
    {
        // require_login();

        $model = new KurikulumModel(Database::connection());

        render('kurikulum/views/form', [
            'title' => 'Form Kurikulum',
            'subtitle' => 'Halaman form Kurikulum',
            'active' => 'kurikulum',
        ]);
    }
    public function formMatakuliah(): void
    {
        // require_login();

        $model = new KurikulumModel(Database::connection());

        render('kurikulum/views/matakuliah-form', [
            'title' => 'Form Matakuliah',
            'subtitle' => 'Halaman form Matakuliah',
            'active' => 'kurikulum',
        ]);
    }
    public function tmpKurikulum(): void
    {
        // require_login();

        $model = new KurikulumModel(Database::connection());

        render('kurikulum/views/template', [
            'title' => 'Laporan Kurikulum',
            'subtitle' => 'Halaman Laporan Kurikulum',
            'active' => 'kurikulum',
            'pageStyle' => ['/assets/css/kurikulum.css'],
        ]);
    }
}
