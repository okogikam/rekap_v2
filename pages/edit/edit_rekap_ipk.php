<?php
if(isset($_GET['id'])){
$nim = get_input($_GET['id']);
$fill = "NIM = '$nim'";
$data_mhs = select_where("tabel_mhs",$fill,$conn);
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="pt-5">
                <h2 class="text-center font-weight-light">Rekap IPK <br><?= $data_mhs[0]['NAMA']; ?></h2>
            </div>
            <div class="row">
		<div class="card col-12">
		   <div class="card-header"><button class="btn btn-default" onclick="history.back()">Kembali</button></div>
		   <div class="card-body">
			<?php tabel_detail_ipk($nim,$conn); ?>
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