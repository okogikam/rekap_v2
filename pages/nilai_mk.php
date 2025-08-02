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
                <h2 class="text-center">Nilai Per Matakuliah</h2>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                        <span>
                            <a href="./?p=nilai" class="btn btn-primary">Rekap Nilai</a>
                            <a href="./?p=nilai_mk" class="btn btn-primary">Detail Nilai</a>
                        </span>
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
                                    <input type="hidden" name="p" value="nilai_mk">
                                    <input type="submit" value="Filter" class="btn btn-default">
                                </span>
                            </form>
                        </div>
                        <div class="card-body">
                            <table id="tabel" class="table table-hover">
                                <thead>
                                    <th>NO</th>
                                    <th>Matakuliah</th>
                                    <th>Kelas</th>
                                    <th>A</th>
                                    <th>A-</th>
                                    <th>B+</th>
                                    <th>B</th>
                                    <th>B-</th>
                                    <th>C+</th>
                                    <th>C</th>
                                    <th>D+</th>
                                    <th>D</th>
                                    <th>E</th>
                                    <th>Lulus</th>
                                </thead>
                                <tbody>
                                    <?php tabel_nilai_mk($per_now,$conn); ?>
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