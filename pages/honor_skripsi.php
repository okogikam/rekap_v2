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
                        <div class="card-body">
                            <table id="tabel" class="table table-hover">
                                <thead>
                                    <th>NIM</th>
                                    <th>Mahasiswa</th>
                                    <th>Status MHS</th>
                                    <th>Judul Skripsi</th>
                                    <th>Pembimbing</th>
                                    <th>Penguji</th>
                                </thead>
                                <tbody>
                                    <?php tabel_honor($conn); ?>
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