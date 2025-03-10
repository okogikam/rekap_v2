<?php
// $satus = array("Aktif","Lulus","Mengundurkan Diri","Pindah","MBKM");
$sts_mhs = "Aktif";
if(isset($_GET['s'])){
    $sts_mhs = get_input($_GET['s']);
}
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
                <h2 class="text-center">Mahasiswa</h2>
            </div>
            <div class="row">  
		<div class="col-sm-12">
                    <div class="card">
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
                                            <input type="hidden" name="p" value="mhs">
                                            <input type="submit" value="Filter" class="btn btn-default">
                                        </span>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="tabel table table-hover">
                                <thead>
                                    <tr>
					<th>OPSI</th>
                                        <th>NIM</th>
                                        <th>NAMA</th>
                                        <th>DOSEN PA</th>
                                        <th>STATUS</th>
                                        <th>NO HP</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php tabel_mahasiswa($sts_mhs,$conn); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
              
                <div class="col-sm-12">
		  <div class="row">
		    <div class="col-sm-3">
			<div class="card">
                        <div class="card-header">
                            <h5 class="font-weight-light">Jumlah Mahasiswa</h5>
                        </div>
                        <div class="card-body">
                            <table class="table  table-hover">
                                <thead>
                                    <tr>
                                        <th>Status Mahsiswa</th>
                                        <th class="text-right">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php tabel_jumlah_mhs($conn); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
		   </div>
		    <div class="col-sm-9">
			<div class="card">
                        <div class="card-header">
                            <h5 class="font-weight-light">Peserta Aktif Perangkatan</h5>
                        </div>
                        <div class="card-body row">
                           <?php tabel_jumlah_mhs_angkatan($conn); ?>
                        </div>
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