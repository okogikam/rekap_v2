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
                <h2 class="text-center">Peserta Skripsi</h2>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card p-3">
                        <table id="tabel" class="table table-hover">
                            <thead>
                                <th>NO</th>
                                <th>NIM</th>
                                <th>NAMA</th>
                                <th>PEMB.1</th>
                                <th>PEMB.2</th>
                                <th>JUDUL</th>
                                <th></th>
                            </thead>
                            <tbody>
                                <?php tabel_peserta_skripsi($conn); ?>
                            </tbody>
                        </table>
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