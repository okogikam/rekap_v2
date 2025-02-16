<?php
if(isset($_GET['s'])){
$data = select_all("tabel_kegiatan_mhs",$conn);
}
else{
$data = array();
}
$periode[0][PERIODE] = "2020";
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="pt-5">
                <h2 class="text-center font-weight-light">Kegiatan Mahasiswa</h2>
            </div>
            <div class="row">
			<div class="card col-12">
<div class="card-header">
                            <form action="./" method="get" class="text-right">
                                <span class="form-group">
                                    <select name="s">
                                        <?php 
                                        
                                        foreach ($periode as $per){
                                            if($per_now == $per['PERIODE']){
                                                echo "<option value='$per[PERIODE]' selected>$per[PERIODE]</option>";
                                            }else{

                                                echo "<option value='$per[PERIODE]'>$per[PERIODE]</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                    <input type="hidden" name="p" value="kegiatan_mhs">
                                    <input type="submit" value="Filter" class="btn btn-default">
                                </span>
                            </form>
                        </div>
<div class="card-body">
<?php cetak_tabel($data); ?>
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