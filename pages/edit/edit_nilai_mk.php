<?php
if(isset($_GET['id']) AND isset($_GET['s'])){
    $kode_mk = get_input($_GET['id']);
    $s = get_input($_GET['s']);
    $kls = get_input($_GET['kls']);
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="pt-5">
                <h2 class="text-center">Nilai Per Matakuliah</h2>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="table" id="tabel">
                                <thead>
                                    <tr>
                                        <th>NO</th>
                                        <th>NIM</th>
                                        <th>NAMA</th>
                                        <th>NAMA MATAKULIAH</th>
                                        <th>KODE MATAKULIAH</th>
                                        <th>KELAS</th>
                                        <th>PERIODE</th>
                                        <th>NILAI HURUF</th>
                                        <th>NILAI ANGKA</th>
                                        <th>BOBOT</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php detail_nilai_mk($kode_mk,$kls,$s,$conn); ?>
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