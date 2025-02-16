<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="pt-5">
                <h2 class="text-center font-weight-light">Alumni</h2>
            </div>
            <div class="row">
                <div class=" card col-5 bg-white">
                    <canvas id="canvas_1"></canvas>
                </div>
                <div class="card col-sm-12">
                    <div class="card-header">Data Alumni</div>
                    <div class="card-body">
                        <table class="table" id="tabel_default">
                            <thead>
                                <tr>
                                    <th>NIM</th>
                                    <th>Nama</th>
                                    <th>PIN Ijazah</th>
                                    <th>Yudisium</th>
                                    <th>Wisuda</th>
                                    <th>Masa Studi</th>
                                    <th>IPK</th>
                                    <th>TOEFL</th>
                                    <th>Status Pekerjaan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php tabel_alumni($conn); ?>
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

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  const ctx = document.getElementById('canvas_1');
  let datas =  {
      labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
      datasets: [{
        label: '# of Votes',
        data: [12, 19, 3, 5, 2, 3],
        borderWidth: 1
      }]
    }

  new Chart(ctx, {
    type: 'bar',
    data: datas,
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>