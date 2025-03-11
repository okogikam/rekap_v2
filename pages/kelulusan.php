<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="pt-5">
                <h2 class="text-center font-weight-light">Data Lulusan</h2>
            </div>
            <div class="row">
                <div class="card col-12">
                    <div class="card-header">
                        <button class="btn btn-primary" id="btn-plus"> <i class="nav-icon fas fa-plus"></i></button>
                        <button class="btn btn-primary" id="btn-plus">
                           <a https://docs.google.com/spreadsheets/d/1dlYRaAqCzFgZmHJJeiCIZqpRYsUqLNrPImyKtikjP9s/edit?gid=0#gid=0" target="_blank">
                            <i class="nav-icon fas fa-external-link-alt"></i>
                           </a>
                        </button>
			<button class="btn btn-success" id="btn-plus"> <i class="fa-solid fa-rotate"></i></button>
                    </div>
                    <div class="card-body">
                        <table id="table" class="table table-hover">
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

<!-- DataTables  & Plugins -->
<!-- <script src="../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="../plugins/jszip/jszip.min.js"></script>
<script src="../plugins/pdfmake/pdfmake.min.js"></script>
<script src="../plugins/pdfmake/vfs_fonts.js"></script>
<script src="../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="../plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="../plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="../plugins/summernote/summernote-bs4.min.js"></script> -->
<script src="./pages/laporan/tabel.js"></script>
<script src="./pages/laporan/GAS.js"></script>

<script> 
 let btnPlus = document.querySelector('#btn-plus'); 
 let gsheet = new GAS({
    element: document.querySelector("#table"),
    id: "1dlYRaAqCzFgZmHJJeiCIZqpRYsUqLNrPImyKtikjP9s",
    dataShow: 8,
label:['NIM','Nama','Masuk','Lulus','Smt Lulus','Masa Studi','IPK'],
    url: "https://script.google.com/macros/s/AKfycbzsCr87ss_uUoORjNwK2lnsmDTwwK9LPwOA5w1M05MgaVNqrrbpbyU6NeqxoIm3uCGB/exec",
    name: "Sheet1"
   })

 gsheet.init();  

 btnPlus.addEventListener("click",()=>{
    gsheet.addData();
    console.log(gsheet.data)
 })    
   
    </script>