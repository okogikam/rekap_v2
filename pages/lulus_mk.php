<?php
$daftar_kurikulum = daftar_kurikulum($conn);
$daftar_mk = daftar_mk($conn);
$data_nilai = array();
$lulus = 0;
$tdk_lulus = 0;
$blm_mengambil = array();
if(isset($_GET['i'])){
    $i = get_input($_GET['i']);
    $p = get_input($_GET['p']);
    include_once "./pages/$i/".$i."_".$p.".php";
}else{

if(isset($_GET['k']) && isset($_GET['mk'])){

    $nama_kurikulum = get_input($_GET['k']);
    $nama_mk = explode("-",get_input($_GET['mk']));
    $data_nilai = read_data_nilai("tabel_nilai_mk",$nama_mk[1],$nama_kurikulum,$conn);
    if(is_array($data_nilai)){
        $lulus = lulusmk($data_nilai);
        $tdk_lulus = tdklulusmk($data_nilai);
        $blm_mengambil = blmlulusmk($nama_kurikulum,$data_nilai,$conn);
//test($data_nilai);
    }

}

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="pt-5">
                <h2 class="font-weight-light text-center">Lulus Matakuliah</h2>
            </div>
            <div class="row">
                <div class="col-sm-9">
                    <div class="card">
                        <div class="card-header">
                            <form action="#" method="GET">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <h4 class="font-weight-light text-center">Nilai Matakuliah</h4>
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="hidden" class="form-control" name="p" value="lulus_mk">
                                        <input list="daftar_kurikulum" type="text" id="kur" class="form-control"
                                            placeholder="Kurikulum" name="k" value="" required>
                                    </div>
                                    <div class="col-sm-5">
                                        <div class="row">
                                            <input type="text" class="form-control col-sm-10" id="mk"
                                                placeholder="Matakuliah" name="mk" required>
                                            <input type="submit" class="btn btn-info col-sm-2" value="Show">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-body">
                            <table class="table table-hover" id="tabel">
                                <thead>
                                    <tr>
                                        <th>NIM</th>
                                        <th>Nama</th>
                                        <th>Matakuliah</th>
                                        <th>Nilai Huruf</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php tabel_lulus_mk($data_nilai); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="card">
                        <div class="card-body">
                            <table class="table">
                                <tr>
                                    <td>Lulus</td>
                                    <td><?php echo $lulus; ?></td>
                                </tr>
                                <tr>
                                    <td>Tdk Lulus</td>
                                    <td><?php echo $tdk_lulus; ?></td>
                                </tr>
                                <tr>
                                    <td>Belum</td>
                                    <td><?php echo count($blm_mengambil); ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h4 class="font-weight-light text-center">Belum Mengambil</h4>
                        </div>
                        <div class="card-body">
                            <table class="table" id="tabel_default">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>NIM</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                   tabel_blm_mengambil($blm_mengambil);
                                   ?>
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
<datalist id="daftar_kurikulum">
    <?php
    foreach($daftar_kurikulum as $kurikulum){
        echo "<option value='$kurikulum[NAMA]'>$kurikulum[NAMA]</option>";
    }
    ?>
</datalist>
<?php
//test($daftar_mk);
foreach ($daftar_mk as $kur => $mk){
?>
<datalist id="<?php echo $kur; ?>">
    <?php
    foreach($mk as $m){
        echo "<option value='$m[KODE]-$m[NAMA_MATA_KULIAH]'>$m[KODE]-$m[NAMA_MATA_KULIAH]</option>";
    }
    ?>
</datalist>
<?php
}
?>
<script>
let daftarMK = document.querySelector("#mk")
let daftarKur = document.querySelector("#kur");
daftarKur.addEventListener("change", function() {
    daftarMK.value = "";
    daftarMK.setAttribute("list", this.value);
});
</script>
<?php
}
?>