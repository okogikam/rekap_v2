<?php
header('Content-Type: application/json; charset=utf-8');

$result = array(
    "result"=>array()
);

if(isset($_GET['id'])){
    $hasil = array();
    $link =  $_GET['id'];
    $file = file_get_contents("https://scholar.google.com/citations?view_op=view_citation&hl=id&user=-NsFG-gAAAAJ&sortby=pubdate&citation_for_view=-NsFG-gAAAAJ:kWvqk_afx_IC");
    $json = explode("><",$file);
        foreach($json as $i => $j){
            if($i != 0 && $i != count($json) - 1){
            array_push($hasil,"<$j>");
        }
    }
 
    // echo json_encode($hasil);
}

echo "<pre>";
print_r($hasil);
echo "</pre>";
?>