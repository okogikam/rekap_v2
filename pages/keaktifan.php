<?php
$angkatan = angkatan_mhs($conn);
$sts_angk = "";
if(isset($_GET['s'])){
    $sts_angk = $_GET['s'];
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="pt-5">
                <h2 class="text-center font-weight-light">Status keaftifan</h2>
            </div>
            <div class="row">
                <div class="col-sm-12 card">
                    <div class="card-header">
                    <div class="row">
                                <div class="col-sm-6">
                                    <h4 class="font-weight-light">Daftar Mahasiswa</h4>
                                </div>
                                <div class="col-sm-6">
                                    <form action="./" method="get" class="text-right">
                                        <span class="form-group">
                                            <select name="s">
                                                <?php 
                                                foreach ($angkatan as $sts){
                                                    if($sts_angk == $sts['ANGKATAN']){
                                                        echo "<option value='$sts[ANGKATAN]' selected>$sts[ANGKATAN]</option>";
                                                    }else{
        
                                                        echo "<option value='$sts[ANGKATAN]'>$sts[ANGKATAN]</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <input type="hidden" name="p" value="<?php echo $p; ?>">
                                            <input type="submit" value="Filter" class="btn btn-default">
                                        </span>
                                    </form>
                                </div>
                            </div>
                    </div>
                    <div class="card-body">
                        <?php
                        tabel_keaktifan_mhs($sts_angk,$conn);
                        ?>
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