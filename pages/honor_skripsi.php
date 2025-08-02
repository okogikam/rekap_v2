<?php
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
                <h2 class="text-center">Honor Skripsi</h2>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
			<div class="card-header">
                            <div class="row">
                                <div class="col-sm-6">
                                    <h4 class="font-weight-light">Daftar Mahasiswa</h4>
                                </div>
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
                                            <input type="hidden" name="p" value="honor_skripsi">
                                            <input type="submit" value="Filter" class="btn btn-default">
                                        </span>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <table class="table tabel table-hover">
                                <thead>
				    <th>Opsi</th>
                                    <th>NIM</th>
                                    <th>Mahasiswa</th>
                                    <th>Status MHS</th>
                                    <th>Judul Skripsi</th>
                                    <th>Pembimbing</th>
                                    <th>Penguji</th>
                                </thead>
                                <tbody>
                                    <?php tabel_honor($sts_mhs,$conn); ?>
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