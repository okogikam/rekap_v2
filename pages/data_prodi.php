<?php
$rekap_data = rekap_data($conn);
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="pt-5">
                <h2 class="text-center font-weight-light">Data Prodi</h2>
            </div>
            <div class="row">
                <section class="col-sm-12">
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-user"></i></span>
    
                                <div class="info-box-content">
                                    <span class="info-box-text">Aktif</span>
                                    <span class="info-box-number">
                                        <?php echo $rekap_data['sts_mhs']['Aktif']; ?>
                                    </span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-primary elevation-1"><i
                                        class="fas fa-user-graduate"></i></i></span>
    
                                <div class="info-box-content">
                                    <span class="info-box-text">Lulus</span>
                                    <span class="info-box-number">
                                        <?php echo $rekap_data['sts_mhs']['Lulus']; ?>
                                    </span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-user"></i></span>
    
                                <div class="info-box-content">
                                    <span class="info-box-text">Mengundurkan Diri</span>
                                    <span class="info-box-number">
                                        <?php echo $rekap_data['sts_mhs']['Keluar']; ?>
                                    </span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-user"></i></span>
    
                                <div class="info-box-content">
                                    <span class="info-box-text">Pindah</span>
                                    <span class="info-box-number">
                                        <?php echo $rekap_data['sts_mhs']['Pindah']; ?>
                                    </span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                    </div>
                </section>
                <section class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Kode Prodi</th>
                                        <th>Kode Univ</th>
                                        <th>Nama Prodi</th>
                                        <th>Fakultas</th>
                                        <th>Jenjang</th>
                                        <th>Aktif</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php tabel_prodi($conn); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
                <section class="col-sm-6">
                    <div class="card">
                        <div class="card-header">
                            <p>Perbandingand Dosen dan Mahasiswa</p>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Periode</th>
                                        <th>Mahasiswa</th>
                                        <th>Dosen</th>
                                        <th>Rasio</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php tabel_rasio_dosen($conn); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
                <section class="col-sm-6">
                    <div class="card">
                        <div class="card-header">
                            <p>Perbandingand Tendik dan Mahasiswa</p>
                        </div>
                        <div class="card-body">
                        <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Periode</th>
                                        <th>Mahasiswa</th>
                                        <th>Tendik</th>
                                        <th>Rasio</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php tabel_rasio_tendik($conn); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script src="./plugins/chart.js/Chart.min.js"></script>
<!-- <script>
    let chartDosen = document.getElementById('chart-rasio-dosen');
    let chartTendik = document.getElementById('chart-rasio-tendik');

    new Chart(chartDosen, {
    type: 'bar',
    data: {
      <?php
      echo "labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],";
      echo "datasets: [{
        label: '# of Votes 1',
        data: [12, 19, 3, 5, 2, 3],
        borderWidth: 1, 
        borderColor: '#36A2EB',
        backgroundColor: '#9BD0F5',
      },{
        label: '# of Votes 2',
        data: [12, 19, 3, 5, 2, 3],
        borderWidth: 1,
        borderColor: '#1662EB',
        backgroundColor: '#1662EB',
      },{
        label: '# of Votes 3',
        data: [12, 19, 3, 5, 2, 3],
        borderWidth: 1,
        borderColor: '#09A288',
        backgroundColor: '#09A288',
      }]";
      ?>      
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script> -->