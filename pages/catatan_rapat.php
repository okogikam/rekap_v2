<?php
include_once "./plugins/parsedown/Parsedown.php";
$parseMd = new Parsedown();
//list file
$dir = "./pages/rapat prodi/";
$dir_list = scandir($dir);

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="pt-5">
                <h2 class="text-center font-weight-light">Catatan Rapat</h2>
            </div>
            <div class="row">
	      <div class="col-12">
		<div class="card">
		  <div class="card-header">
		  <form class="form row" method="GET" action="./">
		   <div class="col-4">
		  <select name="id" class="form-control select2" style="width: 100%;" required>
		    <option></option>

<?php
//buat link
for($i=2;$i<count($dir_list);$i++){
  echo "<option value='$i'>$dir_list[$i]</option>";
}
?>

                  </select>
		  </div>
		  <input type="hidden" name="p" value="catatan_rapat">
		  <button class="btn btn-sm btn-primary" type="submit">Buka</button>
		  </form>
		  </div>
		  <div class="card-body">
<?php
if(isset($_GET['id'])){
$id = $_GET['id'];
// membaca file
$file = fopen("./pages/rapat prodi/".$dir_list[$id],"r");
$text = fgets($file);

$parseMd = new Parsedown();

while(! feof($file)) {
  $text = fgets($file);
  echo $parseMd->text($text);
}

fclose($file);
}
?>
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