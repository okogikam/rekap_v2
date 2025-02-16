<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if(isset($_GET['id'])){
$id = get_input($_GET['id']);
include "./upload/upload_".$id.".php";
}else{
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="pt-5">
                <h2 class="text-center">Upload Data
                    <a href="http://localhost/phpmyadmin/"><i class="fas fa-database"></i></a>
                </h2>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <h4 class="font-weight-light">Data Matakuliah</h4>
                        </div>
                        <a href="?p=upload&&i=upload&&id=mk" class="btn btn-default">Upload</a>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <h4 class="font-weight-light">Data Mahasiswa</h4>
                        </div>
                        <a href="?p=upload&&i=upload&&id=mhs" class="btn btn-default">Upload</a>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <h4 class="font-weight-light">Data Dosen</h4>
                        </div>
                        <a href="?p=upload&&i=upload&&id=dsn" class="btn btn-default">Upload</a>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <h4 class="font-weight-light">Data IPK</h4>
                        </div>
                        <a href="?p=upload&&i=upload&&id=ipk" class="btn btn-default">Upload</a>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <h4 class="font-weight-light">Data Nilai Matakuliah</h4>
                        </div>
                        <a href="?p=upload&&i=upload&&id=nilai_mk" class="btn btn-default">Upload</a>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <h4 class="font-weight-light">Data Mahasiswa Skripsi</h4>
                        </div>
                        <a href="?p=upload&&i=upload&&id=skripsi" class="btn btn-default">Upload</a>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="card disabled">
                        <div class="card-body text-center">
                            <h4 class="font-weight-light">Data Honor SKripsi</h4>
                        </div>
                        <a href="?p=upload&&i=upload&&id=hnr_skripsi" class="btn btn-default">Upload</a>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="card disabled">
                        <div class="card-body text-center">
                            <h4 class="font-weight-light">Data Barang Prodi</h4>
                        </div>
                        <a href="?p=upload&&i=upload&&id=barang" class="btn btn-default">Upload</a>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="card disabled">
                        <div class="card-body text-center">
                            <h4 class="font-weight-light">Data Buku Prodi</h4>
                        </div>
                        <a href="?p=upload&&i=upload&&id=buku" class="btn btn-default">Upload</a>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="card disabled">
                        <div class="card-body text-center">
                            <h4 class="font-weight-light">Data Dosen PA</h4>
                        </div>
                        <a href="?p=upload&&i=upload&&id=dsn_pa" class="btn btn-default">Upload</a>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="card disabled">
                        <div class="card-body text-center">
                            <h4 class="font-weight-light">Data Alumni</h4>
                        </div>
                        <a href="?p=upload&&i=upload&&id=alumni" class="btn btn-default">Upload</a>
                    </div>
                </div>
<div class="col-sm-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <h4 class="font-weight-light">Data Kehadiran</h4>
                        </div>
                        <a href="?p=upload&&i=upload&&id=kehadiran" class="btn btn-default">Upload</a>
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
<?php
}
?>