<?php
if(isset($_GET['id'])){
$id = get_input($_GET['id']);
$filter = "NIM='".$id."'";
$data_mhs = select_where("tabel_mhs",$filter,$conn);
if(isset($_POST['simpan'])){
    $nim = get_input($_POST['nim']);
    $status = get_input($_POST['status']);
    $nama = get_input($_POST['nama']);
    $kolom = "NIM,NAMA,STATUS_MAHASISWA";
    $value = "'$nim'#&#'$nama'#&#'$status'";
    $hasil = update_mhs($nim,$kolom,$value,$conn);

    $data_mhs = select_where("tabel_mhs",$filter,$conn);
}else{
    $hasil = "";
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="pt-5">
                <h2 class="text-center">Judul Halaman</h2>
            </div>
            <form class="" action="" method="post">
                <div class="row">
                    <div class="col-sm-9">
                        <div class="card p-3">
                            <?php foreach($data_mhs as $mhs){
                                $std_mhs = $mhs['STATUS_MAHASISWA'];
                        ?>
                            <div class="form-gruop">
                                <p>Nama :
                                    <input class="form-control" type="text" name="nama"
                                        value="<?php echo get_output($mhs['NAMA']); ?>">
                                </p>
                                <p>NIM :
                                    <input class="form-control" type="text" name="nim"
                                        value="<?php echo $mhs['NIM']; ?>">
                                </p>
                                <p>Status :
                                    <select name="status" class="form-control">
                                        <?php 
                                        foreach ($satus as $std){
                                            if($std_mhs == $std){
                                                echo "<option value='$std' selected>$std</option>";
                                            }else{

                                                echo "<option value='$std'>$std</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </p>
				<p>SEMESTER KELUAR :
                                    <input class="form-control" type="text" name="smt_keluar"
                                        value="<?php echo $mhs['SEMESTER_KELUAR']; ?>">
                                </p>
                            </div>
                            <?php 
                        }
                        ?>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="card p-3">
                            <input type="submit" name="simpan" value="Simpan" class="btn btn-default">
                            <p><?php echo $hasil; ?></p>
                        </div>
                    </div>
                </div>
            </form>
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