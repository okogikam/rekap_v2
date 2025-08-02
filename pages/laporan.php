<?php
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
                <h2 class="text-center font-weight-light">Laporan </h2>
            </div>
	    <div class="row">
		<div class="card col-12">
		    <div class="card-header">Tambah <button class='btn btn-sm btn-primary'><i class='fa-solid fa-plus'></i></button></div>
		    <div class="card-body">
			<div class="row">
             		    <?php tabel_link_laporan($conn); ?>
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
<script src="./laporan/tabel.js"></script>
<script src="./laporan/GAS.js"></script>

<script> 
 let btnPlus = document.querySelector('#btn-plus'); 
 let gsheet = new GAS({
    element: document.querySelector("#table"),
    id: "1iyvnm16Z5F96RSv31_Mb20TMHu_PUOWBIEq-3OZKpQ4",
    dataShow: 8,
label:['Tahun','Nama kegiatan','Ketua','Anggota','Anggaran','Laporan','Ket'],
    url: "https://script.google.com/macros/s/AKfycbzsCr87ss_uUoORjNwK2lnsmDTwwK9LPwOA5w1M05MgaVNqrrbpbyU6NeqxoIm3uCGB/exec",
    name: "Sheet1"
   })

 gsheet.init();  

 btnPlus.addEventListener("click",()=>{
    gsheet.addData();
    console.log(gsheet.data)
 })    
   
    </script>
<?php
}
?>