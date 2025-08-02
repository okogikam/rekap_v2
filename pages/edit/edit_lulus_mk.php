<?php
if(isset($_GET['id']) && isset($_GET['mk'])){
$nim = get_input($_GET['id']);
$mk = get_input($_GET['mk']);

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="pt-5">
                <h2 class="text-center font-weight-light">Detail Lulus Matakuliah</h2>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="font-weight-light"><?php echo $nim . " - ". mhs($nim,$conn); ?></h4>
                        </div>
                        <div class="card-body">
                            <table class="table" id="tabel_default">
                                <?php detail_lulus_mk($nim,$mk,$conn); ?>
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
<?php
}
?>