<?php
if(isset($_POST['simpan'])){
    $file = $_FILES['file'];

    if($file['name'] != ""){
        if(cek_type($file['name'])){
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
            $spreadsheet = $reader->load($file['tmp_name']);
        
            $data = $spreadsheet->getSheet(0)->toArray();
            $result = upload_nilai_mk($data, $conn);
        }else{
            $result = "type file harus xlx atau xlxs";
        }
    }    
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="pt-5">
                <h2 class="text-center">Upload Data Nilai Matakuliah</h2>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <form method="POST" action="#" enctype="multipart/form-data">
                        <div class="card">
                            <div class="card-header">
                                <input type="file" name="file">
                                <input onclick="loading_upload()" class="btn btn-primary" value="Upload" type="submit"
                                    name="simpan">
                                <a href="../template/template_<?php echo $id; ?>.xlsx" class="btn btn-default"
                                    download>Template</a>
                            </div>
                            <div class="card-body" id="hasil_upload">
                                <table class="table">
                                    <?php 
                                    if(is_array($result)){
                                        show_result($result);
                                    }else{
                                        echo "<tr><td>";
                                        echo $result;
                                        echo "</td></tr>";
                                    }
                                    ?>
                                </table>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->