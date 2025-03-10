<?php

if(isset($_GET['s'])){
    $sts_mhs = get_input($_GET['s']);
}else{
    $sts_mhs = "Aktif";
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
                <h2 class="text-center">Transkrip</h2>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="font-weight-light">Daftar Mahasiswa</h4>
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
                                    <input type="hidden" name="p" value="transkrip">
                                    <input type="submit" value="Filter" class="btn btn-default">
                                </span>
                            </form>
                        </div>
                        <div class="card-body">
                            <table id="tabel" class="table table-hover">
                                <thead>
                                    <th>NIM</th>
                                    <th>NAMA</th>
                                    <th>MK WAJIB LULUS</th>
                                    <th>MK PILIHAN LULUS</th>
                                    <th>SKS DIAMBIL</th>
                                    <th>IPK</th>

                                    <th></th>
                                </thead>
                                <tbody>
                                    <?php tabel_transkrip($sts_mhs,$conn); ?>
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