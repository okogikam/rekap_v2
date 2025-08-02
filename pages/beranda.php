<?php
$rekap_data = rekap_data($conn);

if(isset($_POST['tambah'])){
    $isi = get_input($_POST['catatan']);
    $tipe = get_input($_POST['tipe']);
    $result = savecatatan($isi,$tipe,$conn);
}
if(isset($_GET['i']) && isset($_GET['id'])){
    $i = get_input($_GET['i']);
    $id = get_input($_GET['id']);
    if($i == "del_ctt"){
        $result = hapuscatatan($id,$conn);
    }
}

// $todo = todo($conn);
//$surat = surat($conn);
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="pt-5">
                <h2 class="text-center">Beranda</h2>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-user"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Aktif</span>
                                    <span class="info-box-number">
                                        <?php echo $rekap_data['sts_mhs']['Aktif']; ?>
                                    </span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-primary elevation-1"><i
                                        class="fas fa-user-graduate"></i></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Lulus</span>
                                    <span class="info-box-number">
                                        <?php echo $rekap_data['sts_mhs']['Lulus']; ?>
                                    </span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-user"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Mengundurkan Diri</span>
                                    <span class="info-box-number">
                                        <?php echo $rekap_data['sts_mhs']['Keluar']; ?>
                                    </span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-user"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Pindah</span>
                                    <span class="info-box-number">
                                        <?php echo $rekap_data['sts_mhs']['Pindah']; ?>
                                    </span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="font-weight-light">Peserta Aktif Pertahun</h4>
                                </div>
                                <div class="card-body row">
                                     <?php tabel_jumlah_mhs_angkatan($conn); ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="font-weight-light">Kota Asal Mahasiswa</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <?php tabel_kota_mhs($conn); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card card-row card-primary cttn">
                        <div class="card-header">
                            <h3 class="card-title">
                                To Do
                            </h3>
                            <span class="float-right">
                                <button id="tambah" class="btn btn-primary m-0 p-0" data-toggle="modal"
                                    data-target="#myToDo"><i class="fas fa-plus"></i></button>
                            </span>
                        </div>
                        <div class="card-body">
                            <?php // display_catatan($p,$todo); ?>
                        </div>
                    </div>
<div class="card card-row card-default cttn">
                        <div class="card-header bg-info">
                            <h3 class="card-title">
                                Surat
                            </h3>
                            <span class="float-right">
                                <button id="tambah" class="btn btn-info m-0 p-0" data-toggle="modal"
                                    data-target="#myToDo"><i class="fas fa-plus"></i></button>
                            </span>
                        </div>
                        <div class="card-body">
                            <?php // display_catatan($p,$surat); ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
    <aside>
        <div class="modal fade" tabindex="-1" role="dialog" id="myModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="#" method="POST">
                        <div class="modal-header">
                            <h4 class="modal-title">Tambah Catatan</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <textarea name="catatan" class="form-control" rows="10"></textarea>
                            <input type="hidden" name="tipe" value="todo">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <input type="submit" class="btn btn-primary" name="tambah" value="Tambah">
                        </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </aside>
</div>
<!-- /.content-wrapper -->