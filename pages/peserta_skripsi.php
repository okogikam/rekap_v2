<?php 
if(isset($_GET['i'])){
    $i = get_input($_GET['i']);
    $p = get_input($_GET['p']);
    include_once "./pages/$i/".$i."_".$p.".php";
}else{
   $sts_mhs = 'Aktif';
   if(isset($_GET['s'])){
      $sts_mhs = get_input($_GET['s']);
   }
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
			<div class="card-header">
                            <div class="row">
                                <div class="col-sm-6">
                                    <h4 class="font-weight-light">Daftar Mahasiswa <button class='btn btn-sm btn-primary'><i class='fa-solid fa-plus'></i></button></h4>
                                </div>
                                <div class="col-sm-6">
                                    <form action="./" method="get" class="text-right">
                                        <span class="form-group">
                                            <select name="s">
                                                <?php 
                                                foreach ($satus as $sts){
                                                    if($sts_mhs == $sts){
                                                        echo "<option value='$sts' selected>$sts</option>";
                                                    }else{
        
                                                        echo "<option value='$sts'>$sts</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <input type="hidden" name="p" value="peserta_skripsi">
                                            <input type="submit" value="Filter" class="btn btn-default">
                                        </span>
                                    </form>
                                </div>
                            </div>
                        </div>

			<div class="card-body">
				<table class="table tabel table-hover">
                            <thead>
                                <th>OPSI</th>
                                <th>NIM</th>
                                <th>NAMA</th>
                                <th>PEMB.1</th>
                                <th>PEMB.2</th>
                                <th>JUDUL</th>
                            </thead>
                            <tbody>
                                <?php tabel_peserta_skripsi($sts_mhs,$conn); ?>
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