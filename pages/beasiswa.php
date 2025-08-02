<?php
if(isset($_GET['op']) && $_GET['op'] == 'del'){
    $nim = get_input($_GET['nim']);
    $sql = "UPDATE tabel_mhs SET BEASISWA = '' WHERE NIM = '$nim'";
    sql_query($sql,$conn);
}
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="pt-5">
                <h2 class="text-center font-weight-light">Beasiswa</h2>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header"></div>
                        <div class="card-body">
                            <table class="table tabel table-hover">
                                <thead>
                                    <tr>
                                        <th>Opsi</th>
                                        <th>NIM</th>
                                        <th>Nama</th>
                                        <th>Angkatan</th>
                                        <th>Beasiswa</th>
                                        <th>IPK</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php tabel_beasiswa(); ?>
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