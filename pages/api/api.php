<?php
include_once "../../rot/function.php";
header("Content-Type: application/json;");
$data_tabel = array(
"dosen"=>array(
	"tabel"=>"tabel_dosen",
	"index"=>"NIP"
	),
"mhs"=>array(
	"tabel"=>"tabel_mhs",
	"index"=>"NIM"
	),
"kurikulum"=>array(
	"tabel"=>"tabel_kurikulum",
	"index"=>"ID_KURIKULUM"
	)
);
if(isset($_GET['p']) && isset($_GET['id']) && isset($_GET['type'])){
$hasil = array(
  "hasil"=>"0",
  "data"=>"",
  "pesan"=>"gagal"
);
try{

   $p = get_input($_GET['p']);
   $tabel = $data_tabel[$p]['tabel'];
   $id = $data_tabel[$p]['index'];
   $hasil['hasil'] = 1;
   $hasil['pesan'] = "sukses";
   $hasil['data'] = select_where("$tabel","$id = '$_GET[id]'",$conn);

}catch(Exception $e){
   $hasil['pesan'] = $e;
}
echo json_encode($hasil);
}
?>