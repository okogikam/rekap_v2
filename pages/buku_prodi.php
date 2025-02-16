<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="pt-5">
                <h2 class="text-center">Buku Prodi / Ruang Baca</h2>
            </div>
            <div class="row">
                <div class="col-sm-10">
                    <div class="card">
                        <div class="card-body">
                            <table class="table" id="tabel">
                                <thead>
                                    <tr>
                                        <th>ISBN</th>
                                        <th>Judul Buku</th>
                                        <th style="width:200px">Pengarang</th>
                                        <th style="width:100px">Penerbit</th>
                                        <th>Copy</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php tabel_buku($conn); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="card">
                        <div class="card-body">
                            <p>Buku: </p>
                            <p>Penelitian:</p>
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