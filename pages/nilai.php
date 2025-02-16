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
                <h2 class="text-center font-weight-light">Nilai Permatakuliah</h2>
            </div>
            <div class="row">
                <div class="card col-sm-12">
                    <div class="card-header">
                        <span>
                            <a href="./?p=nilai" class="btn btn-primary">Rekap Nilai</a>
                            <a href="./?p=nilai_mk" class="btn btn-primary">Detail Nilai</a>
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
                                    <input type="hidden" name="p" value="nilai">
                                    <input type="submit" value="Filter" class="btn btn-default">
                                </span>
                            </form>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="tabel" class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Kurikulum</th>
                                    <th>Nama MK</th>
                                    <th>Jml Lulus</th>
                                    <th>Jml Tidak Lulus</th>
                                    <th>Persen Lulus</th>
                                    <th>Persen Tidak Lulus</th>
                                    <th>Nilai Rata-rata</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php tabel_rekap_nilai($per_now,$conn); ?>
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