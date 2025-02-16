<?php
if(isset($_GET['id'])){
    $nim = get_input($_GET['id']);
    $nilai = get_nilai_mhs($nim,$conn);
	$sks_blm_lulus = sks_belum_lulus($nim,$conn);
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="pt-5">
                <h2 class="text-center">Transkrip</h2>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <h2><?php echo mhs($nim,$conn); ?></h2>
                            <p>NIM : <?php echo $nim; ?></p>
    <div class="row">
    <div class="col-6 col-sm-3">
    <p class="m-0 p-0">SKS Diambil : <?php echo $nilai['SKS_TOTAL']; ?></p>
    <p class="m-0 p-0">IPK : <?php echo number_format((float)$nilai['IPK'],2); ?></p>
    </div>
    <div class="col-6 col-sm-3">
    <p class="m-0 p-0">SKS Belum [wajib] : <?php echo $sks_blm_lulus['wajib']; ?></p>
    <p class="m-0 p-0">SKS Belum [pilihan] : <?php echo $sks_blm_lulus['pilihan']; ?></p>
    </div>
    </div>                            
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h3>Wajib</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <?php tabel_mk_wajib($nim,$conn); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h3>Pilihan</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <?php tabel_mk_pilihan($nim,$conn); ?>
                            </div>
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
<?php
}
?>