<?php
include "../rot/function.php";
include "../plugins/parsedown/Parsedown.php";

//list file
$dir = "./rapat prodi/";
$a = scandir($dir);


//buat link
for($i=2;$i<count($a);$i++){
  echo "<a href='?id=$i'><button>$a[$i]</button></a>";
}
echo "<hr>";
if(isset($_GET['id'])){
$id = $_GET['id'];
// membaca file
$file = fopen("./rapat prodi/".$a[$id],"r");
$text = fgets($file);

$parseMd = new Parsedown();

while(! feof($file)) {
  $text = fgets($file);
  echo $parseMd->text($text);
}

fclose($file);
}
?>