<?php
header('Content-Type: application/json; charset=utf-8');

require_once "./util.php";

function saveData($conn,$tabel,$data,$id){
    $datas = json_decode($data,true);
    $result = array(
        "tabel"=> $tabel,
        "id"=> $id,
    );

    return $result;
}

?>