<?php
if(isset($_GET['i'])){
    $i = get_input($_GET['i']);
    $p = get_input($_GET['p']);
    include_once "./$i/".$i."_".$p.".php";
}else{
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="pt-5">
                <h2 class="text-center">Pembimbing Skripsi</h2>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="tabel" class="table table-hover">
                                <thead>
                                    <th>NO</th>
                                    <th>Dosen</th>
                                    <th>Pembimbing 1</th>
                                    <th>Pembimbing 2</th>
                                    <th>Penguji 1</th>
                                    <th>Penguji 2</th>
                                    <th>Total</th>
                                </thead>
                                <tbody>
                                    <?php 
                                    tabel_pembimbing_skripsi($conn); ?>
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
<?php
}
?>