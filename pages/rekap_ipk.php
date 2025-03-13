<?php
$query = "NILAI_HURUF != '' GROUP BY PERIODE ORDER BY PERIODE DESC";
$periode = select_where("tabel_nilai_mk",$query,$conn);
$per_now = "";
if(isset($_GET['s'])){
    $per_now = get_input($_GET['s']);
}
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
                <h2 class="text-center font-weight-light">Rekap IPK Mahasiswa</h2>
            </div>
            <div class="row">
                <div class="card col-sm-12">
                    <div class="card-header">
                        <span>
                           Daftar Nilai
                        </span>
                        <div class="float-right">
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
                                    <input type="hidden" name="p" value="rekap_ipk">
                                    <input type="submit" value="Filter" class="btn btn-default">
                                </span>
                            </form>
                        </div>
                    </div>
                    <div class="card-body">
			<div class="row">
			    <div class="col-sm-9">
			    <table id="tabel" class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Opsi</th>
                                    <th>NIM</th>
                                    <th>Nama</th>
                                    <th>IP</th>
                                    <th>IPK</th>
                                </tr>
                            </thead>
                            <tbody>
				
                            </tbody>
                        </table>
			</div>
			    <div class="col-sm-3">
				<table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>IPK</th>
                                    <th>Jumlah</th>
                                    <th>Persen</th>
                                </tr>
                            </thead>
                            <tbody>
				<tr>
				   <td>&gt; 3,00</td>
	    			   <td></td>
				   <td></td>
				</tr>
				<tr>
				   <td>2,76 - 3,00</td>
	    			   <td></td>
				   <td></td>
				</tr>
				<tr>
				   <td>&lt; 2,76</td>
	    			   <td></td>
				   <td></td>
				</tr>
                            </tbody>
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