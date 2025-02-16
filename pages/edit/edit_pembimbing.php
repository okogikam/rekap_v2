<?php
if(isset($_GET['id'])){
    $id_dsn = get_input($_GET['id']);
    // $data = tabel_data_pem("Aktif",$id_dsn,$conn);
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="pt-5">
                <h2 class="text-center">Dosen<br> <?php echo $id_dsn; ?></h2>
            </div>
            <h2 class="font-weight-light">Mahasiswa Aktif</h2>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="font-weight-light">Pembimbing Mahasiswa Aktif</h4>
                        </div>
                        <div class="card-body">
                            <table class="table tabel table-hover" id="tabel_1">
                                <thead>
                                    <tr>
                                        <th>NIM</th>
                                        <th>Nama</th>
                                        <th>Status</th>
                                        <th>Judul</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php tabel_data_pem("Aktif",$id_dsn,$conn); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="font-weight-light">Penguji Mahasiswa Aktif</h4>
                        </div>
                        <div class="card-body">
                            <table class="table tabel table-hover" id="tabel_2">
                                <thead>
                                    <tr>
                                        <th>NIM</th>
                                        <th>Nama</th>
                                        <th>Status</th>
                                        <th>Judul</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php tabel_data_peng("Aktif",$id_dsn,$conn); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
            <h2 class="font-weight-light">Mahasiswa Lulus</h2>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="font-weight-light">Pembimbing Mahasiswa Lulus</h4>
                        </div>
                        <div class="card-body">
                            <table class="table tabel table-hover" id="tabel_3">
                                <thead>
                                    <tr>
                                        <th>NIM</th>
                                        <th>Nama</th>
                                        <th>Status</th>
                                        <th>Judul</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php tabel_data_pem("Lulus",$id_dsn,$conn); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="font-weight-light">Penguji Mahasiswa Lulus</h4>
                        </div>
                        <div class="card-body">
                            <table class="table tabel table-hover" id="tabel_4">
                                <thead>
                                    <tr>
                                        <th>NIM</th>
                                        <th>Nama</th>
                                        <th>Status</th>
                                        <th>Judul</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php tabel_data_peng("Lulus",$id_dsn,$conn); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->