<?php
header("Content-Type: application/json; charset=UTF-8");

include_once "./connect.php";
include_once "./function.php";


$datas = select_all("tabel_alumni",$conn);

foreach($datas as $i=>$data){
	$v = $data['Status_Pekerjaan'];
	if(isset($rekap['Status_Pekerjaan'][$v])){
	$rekap['Status_Pekerjaan'][$v] += 1;
	}else{
	$rekap['Status_Pekerjaan'][$v] = 1;
	}

$v = $data['Tahun_Yudisium'];
	if(isset($rekap['Tahun_Yudisium'][$v])){
	$rekap['Tahun_Yudisium'][$v] += 1;
	}else{
	$rekap['Tahun_Yudisium'][$v] = 1;
	}

$v = $data['Tahun_Wisuda'];
	if(isset($rekap['Tahun_Wisuda'][$v])){
	$rekap['Tahun_Wisuda'][$v] += 1;
	}else{
	$rekap['Tahun_Wisuda'][$v] = 1;
	}

$v = $data['Waktu_tunggu'];
	if(isset($rekap['Waktu_tunggu'][$v])){
	$rekap['Waktu_tunggu'][$v] += 1;
	}else{
	$rekap['Waktu_tunggu'][$v] = 1;
	}

$v = $data['Nilai_Toefl'];
	if(isset($rekap['Nilai_Toefl'][$v])){
	$rekap['Nilai_Toefl'][$v] += 1;
	}else{
	$rekap['Nilai_Toefl'][$v] = 1;
	}

$v = $data['Lama_Studi'];
	if(isset($rekap['Lama_Studi'][$v])){
	$rekap['Lama_Studi'][$v] += 1;
	}else{
	$rekap['Lama_Studi'][$v] = 1;
	}
}

$output = data_grafik($rekap);
echo json_encode($output);

?>