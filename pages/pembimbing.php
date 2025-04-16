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
                <h2 class="text-center">Pembimbing Skripsi</h2>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
			<div class="card-header">
			  <div class="row">
			   <div class="col-sm-6"><h3>Daftar Bimbingan Skripsi</h3></div>
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
                                            <input type="hidden" name="p" value="pembimbing">
                                            <input type="submit" value="Filter" class="btn btn-default">
                                        </span>
                                    </form>
                                </div>
			   </div>
			</div>
                        <div class="card-body">
                            <table id="tabel" class="table table-hover">
                                <thead>
                                    <th>Opsi</th>
                                    <th>Dosen</th>
                                    <th>Pembimbing 1</th>
                                    <th>Pembimbing 2</th>
                                    <th>Penguji 1</th>
                                    <th>Penguji 2</th>
                                    <th>Total</th>
                                </thead>
                                <tbody>
                                    <?php tabel_pembimbing_skripsi($sts_mhs,$conn); ?>
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