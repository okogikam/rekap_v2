<?php
$query = "PERIODE != '' GROUP BY PERIODE ORDER BY PERIODE DESC";
$periode = select_where("tabel_kehadiran",$query,$conn);
$per_now = "";
if(isset($_GET['s'])){
    $per_now = get_input($_GET['s']);
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
                <h2 class="text-center font-weight-light">Data Kehadiran</h2>
            </div>
            <div class="row">
<div class="card col-sm-12">
    <div class="card-header">
        <span>
            <button data-display="perMhs" class="btn btn-primary btn-display">Per Mhs</button>
            <button data-display="perkelas" href="./?p=kehadiran" class="btn btn-primary btn-display">Per MK</button>
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
                    <input type="hidden" name="p" value="kehadiran">
                    <input type="submit" value="Filter" class="btn btn-default">
                </span>
            </form>
        </div>
    </div>
    <div class="card-body display-mhs">
        <table class="table tabel table-hover">
            <thead>
                <tr>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Mata Kuliah</th>
                    <th>Pertemuan (min)</th>
                    <th>Hadir (min)</th>
                    <th>Tidak hadir (maks)</th>
                    <th>Persentase Kehadiran (min)</th>
                    <th>Opsi</th>
                </tr>
            </thead>
            <tbody>
                <?php tabel_kehadiran_mhs($per_now,$conn); ?>
            </tbody>
        </table>
    </div>
    <div class="card-body display-kls d-none">
        <table class="tabel table table-hover">
            <thead>
                <tr>
                    <th>Mata Kuliah</th>
                    <th>Pertemuan (min)</th>
                    <th>Hadir (min)</th>
                    <th>Tidak hadir (maks)</th>
                    <th>Persentase Kehadiran (min)</th>
                    <th>Opsi</th>
                </tr>
            </thead>
            <tbody>
                <?php tabel_kehadiran_kls($per_now,$conn); ?>
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
<script>
    let btnMenu = document.querySelectorAll('.btn-display');
    let displayNow = "perMhs";
    let display = {
        "perMhs": document.querySelector(".display-mhs"),
        "perkelas": document.querySelector(".display-kls")
    };
    btnMenu.forEach((btn)=>{
        btn.addEventListener("click",()=>{
            Object.values(display).forEach((d)=>{
                d.classList.add("d-none");
            })
            display[btn.dataset.display].classList.remove('d-none');            
        })
    })
</script>


<?php
}
?>