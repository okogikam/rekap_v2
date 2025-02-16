<?php
$daftar_kurikulum = daftar_kurikulum($conn);
$query = "PERIODE != '' GROUP BY PERIODE ORDER BY PERIODE DESC";
$periode = select_where("tabel_kehadiran",$query,$conn);

$daftar_mk = daftar_mk_khd($conn);
$hasil = "";

if(isset($_GET['mk1'])&& isset($_GET['mk2'])){
    $get['pr'] = get_input($_GET['pr']);
    // $get['k'] = get_input($_GET['k']);
    $get['mk1']= get_input($_GET['mk1']);
    $get['mk2'] = get_input($_GET['mk2']);

    $hasil = peserta($get,$conn);
}
$a = array(1=>array(0,2),2,3);
$b = array(1=>array(3,4),4,5,3);
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="pt-5">
                <h2 class="text-center font-weight-light">Peserta MK</h2>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <form action="" method="GET">
                                <div class="row">
                                    <div class="col-2">
                                        <input type="text" placeholder="periode" name="pr" class="form-control"
                                            list="daftar_periode" id="pr">
                                        <input type="hidden" name="p" value="peserta_mk">
                                    </div>
                                    <div class="col-3">
                                        <input type="text" placeholder="Matakuliah 1" name="mk1" class="form-control"
                                            id="mk1">
                                    </div>
                                    <div class="col-3">
                                        <input type="text" placeholder="Matakuliah 2" name="mk2" class="form-control"
                                            id="mk2">
                                    </div>
                                    <div class="col-1">
                                        <input type="submit" value="View" name="v" class="btn btn-default">
                                    </div>
                                </div>
                            </form>
<div>
    <?php
    if(isset($_GET['pr']) && isset($_GET['mk1']) && isset($_GET['mk2'])){
        ?>
<p>Semester : <?php echo $_GET['pr']; ?> , MK1 : <?php echo $_GET['mk1']; ?> dan
MK2 : <?php echo $_GET['mk2']; ?> </p>
<?php
    }
    ?>
</div>
                        </div>
                        <div class="card-header">
                            <table class="table" id="tabel">
                                <thead>
                                    <tr>
                                        <th>NO</th>
                                        <th>NIM</th>
                                        <th>Nama</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if(is_array($hasil)){
                                        $no = 0;
                                        foreach($hasil as $h){
                                            $no++;
                                            echo "<tr>";
                                            echo "<td>$no</td>";
                                            echo "<td>$h</td>";
                                            echo "<td>".mhs($h,$conn)."</td>";
                                            echo "</tr>";
                                        }
                                    }
                                        // test($hasil);
                                    
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-2">
                    <?php
                    // print_r(array_intersect($a,$b));
                    ?>
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
        echo "<option value='$kurikulum[nama_kurikulum]'>$kurikulum[nama_kurikulum]</option>";
    }
    ?>
</datalist>
<datalist id="daftar_periode">
    <?php
 foreach ($periode as $per){
        echo "<option value='$per[PERIODE]'>$per[PERIODE]</option>";
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
        echo "<option value='$m[NAMA_MATA_KULIAH]'>$m[KODE_MATA_KULIAH]-$m[NAMA_MATA_KULIAH]</option>";
    }
    ?>
</datalist>
<?php
}
?>
<script>
let daftarMK1 = document.querySelector("#mk1")
let daftarMK2 = document.querySelector("#mk2")
let daftarPr = document.querySelector("#pr");
daftarPr.addEventListener("change", function() {
    daftarMK1.value = "";
    daftarMK2.value = "";
    daftarMK1.setAttribute("list", this.value);
    daftarMK2.setAttribute("list", this.value);
});
</script>