<?php
require_once "../rot/function.php";

?>

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />

    <title>Dasbor Admin</title>

    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/a121d47811.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css" />
    <!-- DataTables -->
    <link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/adminlte.min.css" />
    <link rel="stylesheet" href="../plugins/summernote/summernote-bs4.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet" />
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="./laporan/GAS.css">
    <style>
    table a,
    .content-wrapper a {
        color: white;
    }


    .modal-content {
        width: 50vw;
    }

    .note-editable {
        min-height: 300px;
        max-height: 300px;
        overflow: auto;
    }
    .cttn .card-body{
    max-height: 600px;
    overflow:auto;
    }

    .D,.E{
    color:red;
    }
    [class*="sidebar-dark-"] .nav-treeview > .nav-item > .nav-link {
        color: #6c757d !important;
    }
    [class*="sidebar-dark-"] .nav-treeview > .nav-item > .nav-link.active {
        color: #080808 !important;
        font-weight: 600;
    }
    </style>
</head>

<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <!-- <div class="aside">
        <img src="../dist/img/loading_3.gif" alt="">
    </div> -->
    <div class="wrapper">
        <!-- Navbar -->
        <?php include_once "./topnav.php"; ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php include_once "./sidenav.php"; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="d-print-block">
            <?php 
                if(isset($_GET['p'])){
                $p = $_GET['p'];
                include_once "./".$p.".php";
                }else{
                $p = "beranda";
                include_once "./beranda.php";
                }
            ?>
        </div>
        <!-- /.content-wrapper -->

        <!-- Main Footer -->
        <footer class="main-footer">

        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../dist/js/adminlte.min.js"></script>
    <!-- DataTables  & Plugins -->
    <script src="../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="../plugins/jszip/jszip.min.js"></script>
    <script src="../plugins/pdfmake/pdfmake.min.js"></script>
    <script src="../plugins/pdfmake/vfs_fonts.js"></script>
    <script src="../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="../plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="../plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <script src="../plugins/summernote/summernote-bs4.min.js"></script>

    <script>
    $(function() {
        $('textarea').summernote({
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['Insert', ['link']]
            ]
        });
    })
    </script>

    <script>
    $(function() {
        $("#tambah").on("click", function() {
            $('#myModal').modal();
        })
        $("#tabel").DataTable({
            responsive: true,
            lengthChange: true,
            autoWidth: false,
            lengthMenu: [
                [30, 50, 100, -1],
                [30, 50, 100, "ALL"],
            ],
            order: [
                [0, 'asc']
            ],
            buttons: ["copy", "excel", "pdf",
                {
                    extend: 'print',
                    autoPrint: true,
                    title: '<?php echo $p; ?>',

                }
            ]
        }).buttons().container().appendTo('#tabel_wrapper .col-md-6:eq(0)');
        $(".tabel").DataTable({
            destroy: true,
            responsive: true,
            autoWidth: false,
            ordering: true,
            lengthMenu: [
                [10, 50, 100, -1],
                [10, 50, 100, "ALL"],
            ],
            order: [
                [0, 'asc']
            ],
            buttons: ["copy", "excel", "pdf",
                {
                    extend: 'print',
                    autoPrint: true,
                    title: '<?php echo $p; ?>',

                }
            ]
        }).buttons().container().appendTo('#tabel_1_wrapper .col-md-6:eq(0)');
        
        $("#tabel_default").DataTable({
            responsive: true,
            autoWidth: false,
            ordering: false,
            lengthChange: false,
            searching: false,
buttons: ["copy", "excel", "pdf",
                {
                    extend: 'print',
                    autoPrint: true,
                    title: '<?php echo $p; ?>',

                }
            ]
        });

        let pages = $(".nav-link");
        let pageNow = "<?php echo $p; ?>";
        jQuery.each(pages, (i, val) => {
            val.classList.remove("active");
            if (val.dataset.page == pageNow) {
                val.classList.add("active");
            }
        })
        let menus = $(".active");
        let divMenu = menus.closest(".has-treeview");
        divMenu[0].classList.add("menu-open")

    });
    </script>
    <script>
    // var load = document.querySelector(".aside");
    // var content = document.querySelector(".wrapper");
    // window.onload = function() {
    //     load.classList.add("d-fade");
    //     console.log("taload sudah");
    // }

    function konfirmasi() {
        var x = confirm("Are you sure you want to delete?");
        if (x) {
            return true;
        } else {
            return false;
        }
        return x;
    }

    function loading_upload() {
        var x = document.querySelector("#hasil_upload");
        var imgload = document.createElement("img");
        imgload.src = "../dist/img/Loading_2.gif";
        x.innerHTML = "";
        x.append(imgload);
        // console.log(imgload);
    }
    </script>
</body>

</html>