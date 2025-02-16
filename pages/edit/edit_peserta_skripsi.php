<?php
if(isset($_GET['id'])){
    $nim = get_input($_GET['id']);
    $fil_2= "NIM = '".$nim."'";
    $data_skripsi = select_where("tabel_skripsi",$fil_2,$conn);
    $data = $data_skripsi[0];
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="pt-5">
                <h3 class="text-center"><?php echo $data['NIM']; ?> - <?php echo $data['NAMA']; ?></h3>
            </div>
            <div class="row">
                <div class="col-sm-12 p-3">
                    <form action="" method="POST" class="card">
                        <div class="card-header">
                            <a href="?p=peserta_skripsi" class="btn btn-default">Kembali</a>
                            <input class="btn btn-primary" type="submit" value="Simpan">
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <p>NIM
                                        <input type="text" class="form-control" value="<?php echo $data['NIM']; ?>">
                                    </p>
                                    <p>NAMA
                                        <input type="text" class="form-control" value="<?php echo $data['NAMA']; ?>">
                                    </p>
                                    <p>JUDUL
                                        <textarea name="" id="" class="form-control" cols="30"
                                            rows="10"><?php echo $data['JUDUL_SKRIPSI']; ?></textarea>
                                    </p>
                                </div>
                                <div class="col-sm-6">
                                    <p>Pembimbing 1
                                        <input type="text" class="form-control"
                                            value="<?php echo $data['PEMBIMBING_1']; ?>">
                                    </p>
                                    <p>Pembimbing 2
                                        <input type="text" class="form-control"
                                            value="<?php echo $data['PEMBIMBING_2']; ?>">
                                    </p>
                                    <p>Penguji 1
                                        <input type="text" class="form-control"
                                            value="<?php echo $data['PENGUJI_1']; ?>">
                                    </p>
                                    <p>Penguji 2
                                        <input type="text" class="form-control"
                                            value="<?php echo $data['PENGUJI_2']; ?>">
                                    </p>
                                    <p>Seminar Proposal
                                        <input type="text" class="form-control"
                                            value="<?php echo $data['TGL_SEMPRO']; ?>">
                                    </p>
                                    <p>Seminar Hasil
                                        <input type="text" class="form-control"
                                            value="<?php echo $data['TGL_SEMHAS']; ?>">
                                    </p>
                                </div>
                            </div>
                        </div>
                    </form>
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