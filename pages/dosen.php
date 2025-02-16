<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="pt-5">
                <h2 class="text-center">Daftar Dosen</h2>
            </div>
            <div class="row">
                <div class="col-sm-10">
                <div class="card">
                 <div class="card-header"><h3>Dosen PS</h3></div>
                 <div class="card-body">
                        <table class="table tabel table-hover">
                            <thead>
                                <th>NO</th>
                                <th>NAMA</th>
                                <th>NIP</th>
                                <th>NIDN</th>
                                <th>EMAIL </th>
                                <th>GOLONGAN</th>
                                <th>HOMEBASE</th>
                            </thead>
                            <tbody>
                                <?php tabel_dosen(true,$conn); ?>
                            </tbody>
                        </table>
                </div>
                </div>

                <div class="card">
 		 <div class="card-header"><h3>Dosen non-PS</h3></div>
                 <div class="card-body">

                <h3>Dosen non-PS </h3>
                <table class="table tabel table-hover">
                    <thead>
                        <th>NO</th>
                        <th>NAMA</th>
                        <th>NIP</th>
                        <th>NIDN</th>
                        <th>EMAIL </th>
                        <th>GOLONGAN</th>
                        <th>HOMEBASE</th>
                    </thead>
                    <tbody>
                        <?php tabel_dosen(false,$conn); ?>
                    </tbody>
                </table>
                 </div>

                </div>
                </div>

                <div class="col-sm-2">
                    <div class="card p-1">
                        <div class="card-body">
                            <p class="font-weight-light">Dosen Homebase : </p>
                            <p class="font-weight-light">Dosen Luar: </p>
                            <p class="font-weight-light">Rasio Dosen-Mhs: </p>
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