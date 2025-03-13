<?php
if(isset($_GET['name'])){
$kurikulum = get_input($_GET['name']);

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="pt-5">
                <h2 class="text-center">Detail <?= $_GET['name']; ?> </h2>
            </div>
            <div class="row">
                <div class="card col-sm-12 p-3">
		   <div class="card-header"><h3>Daftar Matakuliah <button class='btn btn-sm btn-primary'><i class='fa-solid fa-plus'></i></button></h3></div>
		   <div class="card-body">
			<table id="tabel" class="table table-hover">
                        <thead>
                            <tr>
                                <th>Opsi</th>
                                <th>Kode</th>
                                <th>Nama MK</th>
                                <th>Sifat MK</th>
                                <th>SKS</th>
                                <th>Semester</th>
                                <th>Syarat</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php tabel_mk($kurikulum,$conn);?>
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