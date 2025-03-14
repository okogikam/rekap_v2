<?php
if(isset($_GET['i'])){
    $i = get_input($_GET['i']);
    $p = get_input($_GET['p']);
    include_once "./pages/$i/".$i."_".$p.".php";
}else{
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="pt-5">
                <h2 class="text-center">Kurikulum</h2>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="font-weight-light">Daftar Kurikulum <button class='btn btn-sm btn-primary'><i class='fa-solid fa-plus'></i></button></h4>
                        </div>
                        <div class="card-body">
                            <table id="tabel" class="table  table-hover">
                                <thead>
                                    <tr>
                                        <th>OPSI</th>
                                        <th>ID</th>
                                        <th>NAMA</th>
                                        <th>ANGKATAN</th>
					<th>SKS DITAWARKAN</th>
					<th>SKS WAJIB</th>
					<th>SKS PILIHAN (MIN)</th>
					<th>MATA KULIAH</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php tabel_kurikulum($conn); ?>
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