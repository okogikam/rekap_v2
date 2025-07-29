<?php
// kumpulan fungsi untuk mengambil data dari database

// tabel mahasiswa tabel_mhs
function tabel_mahasiswa($filter,$conn){
    global $p;
    if($filter == "All"){
        $data_mahasiswa = select_all("tabel_mhs",$conn);
    }else{
        $fil = "STATUS_MAHASISWA='".$filter."'";
        $data_mahasiswa = select_where("tabel_mhs",$fil,$conn);
    }
    if(!is_array($data_mahasiswa)){return;}
    foreach($data_mahasiswa AS $mhs){
        $str = 1;
        $telp = "";
        $hp = "";

        if($mhs['NO_TELEPON'] != ""){
            $telp = $mhs['NO_TELEPON'];
            $telp = substr($telp,$str,$telp-$str);
        }
        
        if($mhs['NO_HP'] != ""){
            $hp = $mhs['NO_HP'];
            $hp = substr($hp,$str,$hp-$str);
        }

        echo "<tr>";
	echo "<td><div style='white-space: nowrap;'>
<button class='btn btn-xs btn-warning' data-id='$mhs[NIM]' onclick='showData({page:\"$p\",id:\"$mhs[NIM]\",type:\"view\"})'><i class='fa-solid fa-eye'></i></button>
<button class='btn btn-xs btn-primary' data-id='$mhs[NIM]' onclick='editData({page:\"$p\",id:\"$mhs[NIM]\",type:\"edit\"})'><i class='fa-solid fa-pen-to-square'></i></button>
<button class='btn btn-xs btn-danger' data-id='$dosen[NIP]' onclick='deleteData({page:\"$p\",id:\"$mhs[NIM]\",type:\"delete\"})'><i class='fa-solid fa-trash'></i></button></div></td>";
        echo "<td>".$mhs['NIM']."</td>";
        echo "<td>".get_output($mhs['NAMA'])."</td>";
        echo "<td>".get_pa($mhs['NIM'],$conn)."</td>";
        echo "<td>".$mhs['STATUS_MAHASISWA']."</td>";
        echo "<td><a href='https://wa.me/62$telp?text=Assalamualaikum' target='_blank'>$mhs[NO_TELEPON]</a> / <a target='_blank' href='https://wa.me/62$hp?text=Assalamualaikum'>$mhs[NO_HP]</a></td>";
        echo "</tr>";
    }
}
// tabel jumlah mahasiswa
function tabel_jumlah_mhs($conn){
    $data_status = array("Aktif","Lulus","Keluar","Pindah","Total");
    $mhs['Aktif'] = mhs_aktif($conn);
    $mhs['Lulus'] = mhs_lulus($conn);
    $mhs['Keluar'] = mhs_keluar($conn);
    $mhs['Pindah'] = mhs_pindah($conn);
    $mhs['Total'] = $mhs['Aktif'] + $mhs['Lulus'] + $mhs['Keluar'];
    // if($data_kegiatan == 0){$data_kegiatan = array();}
    foreach($data_status as $status){
        echo "<tr>";
        echo "<td>".$status."</td>";
        echo "<td class='text-right'>".$mhs[$status]."</td>";
        echo "</tr>";
    }
}
// tabel mahasiswa perangkatan
function tabel_jumlah_mhs_angkatan($conn){
    $data_angkatan = angkatan_mhs($conn);
    $tabel_header = array('Angkatan','Aktif','Lulus','Keluar','Pindah','Total');

    tabel_start($tabel_header);
    for($i=0;$i<ceil(count($data_angkatan)/2); $i++){
	$angkatan = $data_angkatan[$i];
$filter = "ANGKATAN ='".$angkatan['ANGKATAN']."' && STATUS_MAHASISWA !='mbkm'";
        $mhs_angkatan = select_where("tabel_mhs",$filter,$conn);
	$filter_aktif = "ANGKATAN ='".$angkatan['ANGKATAN']."' && STATUS_MAHASISWA='Aktif'";
        $mhs_aktif = select_where("tabel_mhs",$filter_aktif,$conn); 
	$filter_lulus = "ANGKATAN ='".$angkatan['ANGKATAN']."' && STATUS_MAHASISWA='Lulus'";
        $mhs_lulus = select_where("tabel_mhs",$filter_lulus,$conn); 
	$filter_pindah = "ANGKATAN ='".$angkatan['ANGKATAN']."' && STATUS_MAHASISWA='Pindah'";
        $mhs_pindah = select_where("tabel_mhs",$filter_pindah,$conn);        
	$jml = $mhs_angkatan? count($mhs_angkatan) : 0;
	$aktif = $mhs_aktif? count($mhs_aktif) : 0;
	$lulus = $mhs_lulus? count($mhs_lulus) : 0;
	$pindah = $mhs_pindah? count($mhs_pindah) : 0;
	$keluar = $jml - $aktif - $lulus - $pindah;
        
         echo "<tr>";
         echo "<td>".$angkatan['ANGKATAN']."</td>";
	 echo "<td class='text-right'>".$aktif."</td>";
	 echo "<td class='text-right'>".$lulus."</td>";
	 echo "<td class='text-right'>".$keluar."</td>";
	 echo "<td class='text-right'>".$pindah."</td>";
         echo "<td class='text-right'>".$jml."</td>";
         echo "</tr>";
    }
    tabel_end();
    tabel_start($tabel_header);
    for($j=ceil(count($data_angkatan)/2);$j<count($data_angkatan); $j++){
	$angkatan = $data_angkatan[$j];
$filter = "ANGKATAN ='".$angkatan['ANGKATAN']."' && STATUS_MAHASISWA !='mbkm'";
        $mhs_angkatan = select_where("tabel_mhs",$filter,$conn);
	$filter_aktif = "ANGKATAN ='".$angkatan['ANGKATAN']."' && STATUS_MAHASISWA='Aktif'";
        $mhs_aktif = select_where("tabel_mhs",$filter_aktif,$conn); 
	$filter_lulus = "ANGKATAN ='".$angkatan['ANGKATAN']."' && STATUS_MAHASISWA='Lulus'";
        $mhs_lulus = select_where("tabel_mhs",$filter_lulus,$conn);        
	$filter_pindah = "ANGKATAN ='".$angkatan['ANGKATAN']."' && STATUS_MAHASISWA='Pindah'";
        $mhs_pindah = select_where("tabel_mhs",$filter_pindah,$conn);        
	$jml = $mhs_angkatan? count($mhs_angkatan) : 0;
	$aktif = $mhs_aktif? count($mhs_aktif) : 0;
	$lulus = $mhs_lulus? count($mhs_lulus) : 0;
	$pindah = $mhs_pindah? count($mhs_pindah) : 0;
	$keluar = $jml - $aktif - $lulus - $pindah;
        
         echo "<tr>";
         echo "<td>".$angkatan['ANGKATAN']."</td>";
	 echo "<td class='text-right'>".$aktif."</td>";
	 echo "<td class='text-right'>".$lulus."</td>";
	 echo "<td class='text-right'>".$keluar."</td>";
	 echo "<td class='text-right'>".$pindah."</td>";
         echo "<td class='text-right'>".$jml."</td>";
         echo "</tr>";

    }

//    foreach($data_angkatan as $angkatan){
//        $filter = "ANGKATAN ='".$angkatan['ANGKATAN']."' && STATUS_MAHASISWA !='mbkm'";
//        $mhs_angkatan = select_where("tabel_mhs",$filter,$conn);
//	$filter_aktif = "ANGKATAN ='".$angkatan['ANGKATAN']."' && STATUS_MAHASISWA='Aktif'";
//        $mhs_aktif = select_where("tabel_mhs",$filter_aktif,$conn); 
//	$filter_lulus = "ANGKATAN ='".$angkatan['ANGKATAN']."' && STATUS_MAHASISWA='Lulus'";
//        $mhs_lulus = select_where("tabel_mhs",$filter_lulus,$conn);        
//	$jml = $mhs_angkatan? count($mhs_angkatan) : 0;
//	$aktif = $mhs_aktif? count($mhs_aktif) : 0;
//	$lulus = $mhs_lulus? count($mhs_lulus) : 0;
//	$keluar = $jml - $aktif - $lulus;
        
//         echo "<tr>";
//         echo "<td>".$angkatan['ANGKATAN']."</td>";
//	 echo "<td class='text-right'>".$aktif."</td>";
//	 echo "<td class='text-right'>".$lulus."</td>";
//	 echo "<td class='text-right'>".$keluar."</td>";
 //        echo "<td class='text-right'>".$jml."</td>";
 //        echo "</tr>";

//    }
    tabel_end();
}

// tabel dosen 
function tabel_dosen($homebase,$conn){
    global $p;
    if($homebase){
        $fill = "HOMEBASE LIKE '%Komputer%' GROUP BY NIP";
    }else{
        $fill = "HOMEBASE NOT LIKE '%Komputer%' GROUP BY NIP";
    }
       $data_dosen = select_where("tabel_dosen",$fill,$conn);
       $no = 0;
    if(!is_array($data_dosen)){ return; }
        foreach($data_dosen as $dosen){ 
            $no++;
	    $depan = $dosen['GELAR_DEPAN']? $dosen['GELAR_DEPAN'].". ":"" ;
	    $belakang = $dosen['GELAR_ELAKANG']? ", ".$dosen['GELAR_ELAKANG']:""; 
	    $nama_dsn =  $depan . ucwords(strtolower($dosen['NAMA'])) . $belakang;
            echo "<tr>";
            echo "<td><div style='white-space: nowrap;'>
<button class='btn btn-xs btn-warning' data-id='$dosen[NIP]' onclick='showData({page:\"$p\",id:\"$dosen[NIP]\",type:\"view\"})'><i class='fa-solid fa-eye'></i></button>
<button class='btn btn-xs btn-primary' data-id='$dosen[NIP]' onclick='editData({page:\"$p\",id:\"$dosen[NIP]\",type:\"edit\"})'><i class='fa-solid fa-pen-to-square'></i></button>
<button class='btn btn-xs btn-danger' data-id='$dosen[NIP]' onclick='deleteData({page:\"$p\",id:\"$dosen[NIP]\",type:\"delete\"})'><i class='fa-solid fa-trash'></i></button></div></td>";
            echo "<td>$nama_dsn.</td>";
            echo "<td>".$dosen['NIP']."</td>";
            echo "<td>".$dosen['NIDN']."</td>";
            echo "<td>".$dosen['EMAIL']."</td>";
            echo "<td>".$dosen['GOLONGAN']."</td>";
            echo "<td>".$dosen['HOMEBASE']."</td>";
            echo "</tr>";
        }
}
// tabel kurikulum 
function tabel_kurikulum($conn){   
    global $p; 
    $data_kurikulum = select_all("tabel_kurikulum",$conn);
    $no = 0;
    foreach($data_kurikulum AS $kur){
        $link = "?p=kurikulum&i=edit&name=".$kur['NAMA'];
        $no++;
        // test($data_mahasiswa);
        echo "<tr>";
        echo "<td><div style='white-space: nowrap;'>
<button class='btn btn-xs btn-warning' data-id='$kur[ID_KURIKULUM]' onclick='showData({page:\"$p\",id:\"$kur[ID_KURIKULUM]\",type:\"view\"})'><i class='fa-solid fa-eye'></i></button>
<button class='btn btn-xs btn-primary' data-id='$kur[ID_KURIKULUM]' onclick='editData({page:\"$p\",id:\"$kur[ID_KURIKULUM]\",type:\"edit\"})'><i class='fa-solid fa-pen-to-square'></i></button>
<button class='btn btn-xs btn-danger' data-id='$kur[ID_KURIKULUM]' onclick='deleteData({page:\"$p\",id:\"$kur[ID_KURIKULUM]\",type:\"delete\"})'><i class='fa-solid fa-trash'></i></button></div></td></td>";
        echo "<td>".$kur['ID_KURIKULUM']."</td>";
        echo "<td>".$kur['NAMA']."</td>";
	echo "<td>".$kur['ANGKATAN']."</td>";
        echo "<td>$kur[SKS_DITAWARKAN]</td>";
        echo "<td>$kur[SKS_WAJIB_LULUS]</td>";
        echo "<td>$kur[SKS_PILIHAN_LULUS]</td>";
        echo "<td><a class='btn btn-secondary' href='$link'><i class='fa-solid fa-eye'></i></a></td></td>";
        echo "</tr>";
    }
}
// tabel matakuliah 
function tabel_mk($kurikulum,$conn){
    $data_mk = read_data_matakuliah($kurikulum,$conn);
    // test($data_mk);
    $no = 0;
    foreach($data_mk as $mk){
        $no++;
        echo "<tr>";
        echo "<td><button class='btn btn-sm btn-default'><i class='fa-solid fa-pen-to-square'></i></button></td></td>";
        echo "<td>".$mk['KODE']."</td>";
        echo "<td>".$mk['NAMA_MATA_KULIAH']."</td>";
        if($mk['SIFAT_MATA_KULIAH'] == "1"){
            echo "<td>Wajib</td>";
        }else{echo "<td>Pilihan</td>";}
        echo "<td>".$mk['SKS']."</td>";
        echo "<td>".$mk['SEMESTER']."</td>";
        echo "<td>".$mk['PRASYARAT']."</td>";
        echo "</tr>";
    }
}

// tabel transkript 
function tabel_transkrip($status,$conn){
    $no = 0;
    if($status == "All"){
        $data_mahasiswa = select_all("tabel_mhs",$conn);
    }else{
        $fil_2 = "STATUS_MAHASISWA ='".$status."' ORDER BY NIM DESC";
        $data_mahasiswa = select_where("tabel_mhs",$fil_2,$conn);
    }
    // test($data_mahasiswa);
    if(!is_array($data_mahasiswa)){
        return;
    }
    foreach($data_mahasiswa as $mhs){
        $no++;
        $nim = $mhs['NIM'];

        $fil = "NIM='".$nim."' ORDER BY PERIODE DESC";
        $data_transkrip =  select_where("tabel_nilai_ipk",$fil,$conn);
        if(is_array($data_transkrip)){
            echo "<tr>";
            echo "<td>".$mhs['NIM']."</td>";
            echo "<td>".$mhs['NAMA']."</td>";
            echo "<td>".$data_transkrip[0]['SKS_MK_WAJIB_L']."</td>";
            echo "<td>".$data_transkrip[0]['SKS_PILIHAN_L']."</td>";
            $sks_total = (int)$data_transkrip[0]['SKS_MK_WAJIB_L'] + (int)$data_transkrip[0]['SKS_PILIHAN_L'] + (int)$data_transkrip[0]['SKS_TIDAK_LULUS'];
            if(count($data_transkrip) > 1){               
                $nilai = get_nilai_mhs($mhs['NIM'],$conn);

		$ipk = number_format((float)$nilai['IPK'],2);

                //if($data_transkrip[0]['IPK'] != 0){
                //    $ipk = number_format((float)$data_transkrip[0]['IPK'],2);
                //}else{
                //    $ipk = number_format((float)$data_transkrip[1]['IPK'],2);
                //}

            }else{
                // $sks_total = $data_transkrip[0]['SKS_TOTAL'];
                $ipk = number_format((float)$data_transkrip[0]['IPK'],2);
            }
            echo "<td>".$sks_total."</td>";
            echo "<td>".$ipk."</td>";
	// echo "<td>".array_sum(sks_belum_lulus($mhs['NIM'],$conn))."</td>";
            echo "<td><a class='btn btn-default' href='?p=transkrip&&i=edit&&id=".$mhs['NIM']."'><i class='fa fa-pen-square'></i></a></td>";        
            echo "</tr>";
        }
    }
    
}
// tabel mk lulus 
function tabel_lulus_mk($data){
    if(is_array($data)){
        foreach($data as $d){
            echo "<tr>";
            echo "<td>$d[NIM]</td>";
            echo "<td>$d[NAMA]<span class='sts_mhs $d[STATUS_MAHASISWA]'>$d[STATUS_MAHASISWA]</span></td>";
            echo "<td>$d[NAMA_MATA_KULIAH]</td>";
            echo "<td>$d[NILAI_HURUF]</td>";
            // echo "<td>".."</td>";
            if($d['STATUS_LULUS'] == "L"){
                echo "<td class='Lulus text-center'>$d[STATUS_LULUS]<a href='?p=lulus_mk&i=edit&id=$d[NIM]&mk=$d[KODE_MATA_KULIAH]'><i class='float-right fa-solid fa-pen-to-square'></i></a></td>";
            }else{
                echo "<td class='Mengundurkan text-center'>$d[STATUS_LULUS]<a href='?p=lulus_mk&i=edit&id=$d[NIM]&mk=$d[KODE_MATA_KULIAH]'><i class='float-right fa-solid fa-pen-to-square'></i></a></td>";
            }
            echo "</tr>";
        }
    }
    // echo $data;
}
// tabel mk wajib 
function tabel_mk_wajib($nim,$conn){
    $no = 0;
    $kur = get_kurukulum($nim,$conn);
    $fil_1 = "NAMA_KURIKULUM ='$kur' AND SIFAT_MATA_KULIAH='1'";
    $data_mk = select_where("tabel_mk",$fil_1,$conn);
    if(is_array($data_mk)){
       tabel_start_mk();
        foreach($data_mk as $mk){
	    $status_mengulang = select_where('tabel_nilai_mk',"NIM='$nim' AND KODE_MATA_KULIAH='$mk[KODE]'",$conn);
            $no++;
            $nilai_mk = nilai_mk($nim,$mk['KODE'],$mk['NAMA_KURIKULUM'],$conn);
            echo "<tr>";
	    if($status_mengulang != 0  && count($status_mengulang) > 1){
            echo "<td class='bg-warning'>".$no."</td>";
	    }else{
            echo "<td>".$no."</td>";
	    }
            echo "<td>".$mk['KODE']."</td>";
            echo "<td><a href='?p=lulus_mk&i=edit&id=$nim&mk=$mk[KODE]&k=$mk[NAMA_KURIKULUM]'>".$mk['NAMA_MATA_KULIAH']."</a></td>";
            echo "<td>".$mk['SKS']."</td>";
            echo "<td class='".trim_nilai($nilai_mk)."'>".$nilai_mk."</td>";
            echo "</tr>"; 
            if($no == round(count($data_mk) / 2)){
                tabel_end_mk();
                tabel_start_mk();
            }
        }
        tabel_end_mk();
    }
}
//tabel peserta skripsi
function tabel_peserta_skripsi($status,$conn){
    $fil = "STATUS_MAHASISWA='$status'";
    $data_mahasiswa = select_where("tabel_mhs",$fil,$conn);
    $no = 0;
    if(!is_array($data_mahasiswa)) {return;}
    foreach($data_mahasiswa as $mhs){        
        $fil_2= "NIM = '".$mhs['NIM']."'";
        $data_skripsi = select_where("tabel_skripsi",$fil_2,$conn);
        if(is_array($data_skripsi) && $data_skripsi[0]['JUDUL_SKRIPSI'] != ""){
        $no++;
        echo "<tr>";
        echo "<td><a class='btn btn-sm btn-default' href='?p=peserta_skripsi&&i=edit&&id=".$data_skripsi[0]['NIM']."'><i class='fa-solid fa-pen-to-square'></i></a></td>";
        echo "<td>".$data_skripsi[0]['NIM']."</td>";
        echo "<td>".$data_skripsi[0]['NAMA']."<span class='sts_mhs $mhs[STATUS_MAHASISWA]'>[".$mhs['STATUS_MAHASISWA']."]</span></td>";
        echo "<td>".$data_skripsi[0]['PEMBIMBING_1']."</td>";
        echo "<td>".$data_skripsi[0]['PEMBIMBING_2']."</td>";
        echo "<td class='upper'>".$data_skripsi[0]['JUDUL_SKRIPSI']."</td>";
        echo "</tr>";
        }
    }
}
// tabel pembimbing skripsi 
function tabel_pembimbing_skripsi($sts_mhs,$conn){
    $data_dosen = get_pembimbing_skripsi($conn);   
    $no = 0;
    
    foreach($data_dosen as $dosen){
	
        $data_bimbingan = read_data_bimbingan($sts_mhs,$dosen['NAMA'],$conn);

        $jml = array_sum($data_bimbingan);

        if($jml != 0){
            $no++;
            echo "<tr>";
            echo "<td><a class='btn btn-sm btn-default' href='?p=pembimbing&i=edit&id=$dosen[NAMA]'><i class='fa-solid fa-pen-to-square'></i></a></td>";
            echo "<td>$dosen[NAMA]</td>";
            echo "<td>".$data_bimbingan['PEMB_1']."</td>";
            echo "<td>".$data_bimbingan['PEMB_2']."</td>";
            echo "<td>".$data_bimbingan['PENG_1']."</td>";
            echo "<td>".$data_bimbingan['PENG_2']."</td>";
            echo "<td>".$jml."</td>";
            echo "</tr>";
        }
    }
}
//tabel prodi
function tabel_prodi($conn){
    try{
        $data_prodi = select_all("tabel_prodi",$conn);
        $no = 0;
        foreach($data_prodi as $prodi){
            echo "<tr>";
            echo "<td>$prodi[KODE_PRODI]</td>";
            echo "<td>$prodi[KODE_UNIV]</td>";
            echo "<td>$prodi[PRODI]</td>";
            echo "<td>$prodi[FAKULTAS]</td>";
            echo "<td>$prodi[JENJANG]</td>";
            echo "<td>$prodi[STATUS]</td>";
            echo "</tr>";
        }
    }catch(Exception $e){
        return;
    }
}
// tabel rasio 
function tabel_rasio_dosen($conn){
    $query = "SELECT PERIODE, COUNT(NIM) AS jml FROM tabel_nilai_ipk WHERE STATUS_MAHASISWA='A' GROUP BY PERIODE ORDER BY PERIODE DESC";
    $data = sql_query2($query,$conn);
    $fil = "HOMEBASE='Pendidikan Komputer' AND STATUS='Aktif'";
    $dosen = select_where('tabel_dosen',$fil,$conn);
    for($i = 0; $i < 10;$i++){
        $d = $data[$i];
        $jml_dosen = count($dosen);
        echo "<tr>";
        echo "<td>$d[PERIODE]</td>";
        echo "<td>$d[jml]</td>";
        echo "<td>$jml_dosen</td>";
        echo "<td>1:".floor($d['jml']/$jml_dosen)."</td>";
        echo "</td>";
    }
}
function tabel_rasio_tendik($conn){
    $query = "SELECT PERIODE, COUNT(NIM) AS jml FROM tabel_nilai_ipk WHERE STATUS_MAHASISWA='A' GROUP BY PERIODE ORDER BY PERIODE DESC";
    $data = sql_query2($query,$conn);
    for($i = 0; $i < 10;$i++){
        $d = $data[$i];
        echo "<tr>";
        echo "<td>$d[PERIODE]</td>";
        echo "<td>$d[jml]</td>";
        echo "<td>1</td>";
        echo "<td>1:".floor($d['jml']/1)."</td>";
        echo "</td>";
    }
}
// tabel kehadiran permahasiswa 
function tabel_kehadiran_mhs($periode,$conn){
    if($periode !="" && $periode !=null){
        $fil = "PERIODE ='".$periode."' ORDER BY NIM";
        $data = select_where("tabel_kehadiran",$fil,$conn);
        foreach($data as $d){
            $nim = $d['NIM']."_".$d['KODE_MATA_KULIAH']."_".$d['NAMA_KELAS'];
            if($d['DOSEN_PENGAMPU'] != '' && $d['DOSEN_PENGAMPU'] != null){
		if($d['JUMLAH_PERTEMUAN'] == 0) {
			$d['JUMLAH_PERTEMUAN'] = 1; 
			$d['HADIR'] = 1; 
		}
                $per = number_format((float)($d['HADIR'] * 100 / $d['JUMLAH_PERTEMUAN']),2);
		$per2 = number_format((float)(100 - $per),2);
                $kh[$nim]['NIM'] = $d['NIM'];
                $kh[$nim]['NAMA'] = $d['NAMA_MAHASISWA'];
	        $kh[$nim]['KELAS'] = $d['NAMA_KELAS'];
                $kh[$nim]['PER'] = $per;
		$kh[$nim]['PER2'] = $per2;
                $kh[$nim]['HADIR'] = $d['HADIR'];
		$kh[$nim]['IZIN'] = $d['IZIN'];
		$kh[$nim]['TANPA_KETERANGAN'] = $d['TANPA_KETERANGAN'];
		$kh[$nim]['SAKIT'] = $d['SAKIT'];
                $kh[$nim]['TIDAK_HADIR'] = $d['IZIN'] + $d['TANPA_KETERANGAN'] + $d['SAKIT'];
                $kh[$nim]['MK'] = $d['NAMA_MATA_KULIAH'] . "<br> (". $d['KODE_MATA_KULIAH'].")";
                $kh[$nim]['JML'] = $d['JUMLAH_PERTEMUAN'];
                
            }
            
        }
        foreach($kh as $k){
            echo "<tr>";
            echo "<td>".$k['NIM']."</td>";
            echo "<td>".$k['NAMA']."</td>";
            echo "<td>".$k['KELAS']."</td>";
            echo "<td>".$k['MK']."</td>";
            echo "<td>".$k['JML']."</td>";
            echo "<td>".$k['HADIR']."</td>";
	    echo "<td>".$k['IZIN']."</td>";
	    echo "<td>".$k['SAKIT']."</td>";
	    echo "<td>".$k['TANPA_KETERANGAN']."</td>";
            echo "<td>".$k['TIDAK_HADIR']."</td>";
            echo "<td>".$k['PER']."%</td>";
            echo "<td>".$k['PER2']."%</td>";
            echo "</tr>";
        }
    }
}
//tabel honor skripsi
function tabel_honor($status,$conn){
    $fil = "tabel_skripsi.NIM = tabel_mhs.NIM AND tabel_mhs.STATUS_MAHASISWA = '$status' GROUP BY tabel_mhs.NIM";
    $data = select_where("tabel_skripsi,tabel_mhs",$fil,$conn);

    foreach($data as $d){
        $sts = $d['STATUS_MAHASISWA'];
        echo "<tr>";
        echo "<td><button class='btn btn-sm btn-default'><i class='fa-solid fa-pen-to-square'></i></button></td>";
        echo "<td>$d[NIM]</td>";
        echo "<td>$d[NAMA]</td>";
        echo "<td><span class='sts_mhs $sts'>$sts<span></td>";
        echo "<td>$d[JUDUL_SKRIPSI]</td>";
        echo "<td>".sts_honor($d['NIM'],"pem",$conn)."</td>";
        echo "<td>".sts_honor($d['NIM'],"peng",$conn)."</td>";
        echo "</tr>";
    }
}
// tabel rekap IPK mahasiswa persemester
function tabel_rekap_nilai_ipk($periode,$conn){
    if($periode == "" || $periode == null){ return; }
    $fil = "PERIODE = '$periode' AND  STATUS_MAHASISWA != '' ORDER BY IPK DESC";
    $data = select_where("tabel_nilai_ipk",$fil,$conn);

    foreach($data as $d){
        echo "<tr>";
        echo "<td><a class='btn btn-sm btn-default' href='?p=rekap_ipk&i=edit&id=$d[NIM]'><i class='fa-solid fa-pen-to-square'></i></a></td>";
        echo "<td>$d[NIM]</td>";
        echo "<td>$d[NAMA]</td>";
        echo "<td>".number_format((float)$d['IP_SEMESTER'],2)."</td>";
        echo "<td>".number_format((float)$d['IPK'],2)."</td>";
        echo "</tr>";
    }
}
function tabel_rekap_ipk($periode,$conn){
    if($periode == "" || $periode == null){ return; }
    $fil = "PERIODE = '$periode' AND STATUS_MAHASISWA != '' ORDER BY IPK DESC";
    $data = select_where("tabel_nilai_ipk",$fil,$conn);
    $rekap_ipk = array('&gt; 3,00'=>0,'2,76 - 3,00'=>0,'&lt; 2,76'=>0);
    $jml = count($data);
    foreach($data as $d){
	$ipk = number_format((float)$d['IPK'],2);
        switch($ipk){
	    case($ipk < 2.76):
		$rekap_ipk['&lt; 2,76']++;
		break;
	    case($ipk > 3):
		$rekap_ipk['&gt; 3,00']++;
		break;	    
	    default:
		$rekap_ipk['2,76 - 3,00']++;
		break;
	}
    }
    foreach($rekap_ipk as $ket=>$nilai){
	echo "<tr>";
        echo "<td>$ket</td>";
        echo "<td>$nilai</td>";
	echo "<td>".number_format((float)($nilai/$jml)*100 ,2)."&percnt;</td>";
        echo "</tr>";
    }
}
 function tabel_detail_ipk($nim,$conn){
   $fill = "NIM = '$nim' AND STATUS_MAHASISWA !='' ORDER BY PERIODE";
   $data_ipk = select_where("tabel_nilai_ipk",$fill,$conn);

   echo "<div>";
   echo "<table class='table tabel table-hover'>";
   echo "<thead><tr><th>Keterangan</th>";

   foreach($data_ipk as $d_ipk){
	echo "<th>$d_ipk[PERIODE]</th>";
   }
   echo "</tr></thead>";
   echo "</tbody>";
   echo "<tr><td>SKS Semester</td>";
   foreach($data_ipk as $d_ipk){
	echo "<td>".$d_ipk['SKS_SEMESTER']."</td>";
   }
   echo "</tr>";
   echo "<tr><td>Status</td>";
   foreach($data_ipk as $d_ipk){
	echo "<td>".$d_ipk['STATUS_MAHASISWA']."</td>";
   }
   echo "</tr>";
   echo "</tr>";
   echo "<tr><td>IP Semester</td>";
   foreach($data_ipk as $d_ipk){
	echo "<td>".number_format((float)$d_ipk['IP_SEMESTER'],2)."</td>";
   }
   echo "</tr>";
   echo "<tr><td>IPK</td>";
   foreach($data_ipk as $d_ipk){
	echo "<td>".number_format((float)$d_ipk['IPK'],2)."</td>";
   }
   echo "</tr>";
   
   tabel_end();
}
// tabel laporan 
function tabel_link_laporan($conn){
   $laporan = select_all('tabel_gsheet',$conn);
   Foreach($laporan as $l){
      echo "<div class='col-3'>";
	echo "<a href='?p=laporan&i=edit&id=$l[ID_SHEET]'>";
	echo "<div class='card'>";
	echo "<div class='card-header text-center' style='background-color: var(--primary)' >$l[NAMA_SHEET]</div>";
	echo "<div class='card-body'>$l[KETERANGAN]</div>";
	echo "</div>";
	echo "</a>";
      echo "</div>";
   }
}
// tabel mahasiswa beasiswa
function tabel_beasiswa(){
    global $conn;
    $data = select_where("tabel_mhs","STATUS_MAHASISWA='Aktif' AND BEASISWA !='' AND BEASISWA !='-'",$conn);
    foreach($data as $mhs){
        $ipk = get_nilai_mhs($mhs['NIM'],$conn);
        $ipk = number_format((float)$ipk['IPK'],2);
        echo "<tr>";
        echo "<td><a href='?p=beasiswa&op=del&nim=$mhs[NIM]' class='btn btn-sm btn-primary' onclick='return confirm()'><i class='fa-solid fa-trash'></i></a></td>";
        echo "<td>$mhs[NIM]</td>";
        echo "<td>$mhs[NAMA]</td>";
        echo "<td>$mhs[ANGKATAN]</td>";
        echo "<td>$mhs[BEASISWA]</td>";
        echo "<td>$ipk</td>";
        echo "</tr>";
    }
}

?>