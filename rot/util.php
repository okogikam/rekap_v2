<?php

use function PHPSTORM_META\type;

$img = array(
    "sukses"=>"../dist/img/sukses.png",
    "gagal"=> "../dist/img/pngegg.png"
);
$satus = array("Aktif","Lulus","Mengundurkan Diri","Pindah","MBKM","All");
$result = "";


function destroy_session_and_data(){
    $_SESSION = array();
    setcookie(session_name(), '', time() - 2592000, '/');
    session_destroy();
}
function sql_query($sql,$conn){
    $result = $conn->query($sql);
    if(!$result){
        return "Data Gagal Ditambahkan :" . $conn->error;
    }else{
        return $result;
    }
}
function sql_query2($sql,$conn){
    $result = $conn->query($sql);
    if(!$result){
        return "Data Gagal Ditambahkan :" . $conn->error;
    }else{
        $rows = $result->num_rows;
        $hasil = array();
        if($rows > 1){
            for($i=0;$i<$rows;$i++){        
                $result->data_seek($i);
                $data = $result->fetch_array(MYSQLI_ASSOC);
                foreach($data as $n => $v){
                    $data[$n] = get_output($v);
                }
                $hasil += array($i=>$data);
            }
        }elseif($rows == 0){
            $hasil = 0;
        }else{
            $result->data_seek(0);
            $data = $result->fetch_array(MYSQLI_ASSOC);
            $hasil += array(0=>$data);
        }
        
        return $hasil;
    }
}
function make_array($tanda,$file_name){
    $data = explode($tanda,$file_name);
    return $data;
}
function cek_type($file_name){
    $types = array("xls","xlsx");
    $data = make_array(".",$file_name);
    if(in_array($data[1],$types)){
        return true;
    }else{
        return false;
    }
}

function get_input($input){
//$result = str_replace("&","dan",$input);
    $result = htmlentities($input);
    $result = str_replace("'","td_ptk",$result);

    return $result;
}
function get_output($input){
    $result = str_replace("td_ptk","'",$input);
    $result = html_entity_decode($result);
    return $result;
}
function select($tabel,$id,$conn){
    $query = "SELECT * FROM $tabel WHERE id='$id'";
    $result = sql_query($query,$conn);
    $result->data_seek(0);
    $hasil = $result->fetch_array(MYSQLI_ASSOC);
    return $hasil;
}
function select_where($tabel,$filter,$conn){
    $query = "SELECT * FROM $tabel WHERE $filter";
    $result = sql_query($query,$conn);
    $rows = $result->num_rows;
    $hasil = array();
    if($rows > 1){
        for($i=0;$i<$rows;$i++){        
            $result->data_seek($i);
            $data = $result->fetch_array(MYSQLI_ASSOC);
            foreach($data as $n => $v){
                $data[$n] = get_output($v);
            }
            $hasil += array($i=>$data);
        }
    }elseif($rows == 0){
        $hasil = 0;
    }else{
        $result->data_seek(0);
        $data = $result->fetch_array(MYSQLI_ASSOC);
        $hasil += array(0=>$data);
    }
    
    return $hasil;
}
function select_where_pst($tabel,$filter,$conn){
    $query = "SELECT * FROM $tabel WHERE $filter";
    $result = sql_query($query,$conn);
    $rows = $result->num_rows;
    $hasil = array();
    if($rows > 1){
        for($i=0;$i<$rows;$i++){        
            $result->data_seek($i);
            $data = $result->fetch_array(MYSQLI_ASSOC);
            
            $hasil[$i] =$data['NIM'] ;
        }
    }elseif($rows == 0){
        $hasil = 0;
    }else{
        $result->data_seek(0);
        $data = $result->fetch_array(MYSQLI_ASSOC);
        $hasil += array(0=>$data['NIM']);
    }
    
    return $hasil;
}
function select_all($tabel,$conn){
    $hasil = array();
    $query = "SELECT * FROM $tabel";
    $result = sql_query($query,$conn);
    $rows = $result->num_rows;
    for($i=0;$i<$rows;$i++){        
        $result->data_seek($i);
        $data = $result->fetch_array(MYSQLI_ASSOC);        
        $hasil += array($i=>$data);
    }
    return $hasil;
}
function cek_data($tabel,$id,$conn){
    $result = select_where($tabel,"Id_peserta",$id,$conn);  
    
    if($result == 0){
        $row = 0;
    }else{
        $row = count($result);
    }
    return $row;
}
function cek_detail($tabel,$id,$cek,$conn){
    $result = select_where($tabel,$cek,$id,$conn);
    if($result == 0){
        $row = 0;
    }else{
        $row = count($result);
    }
    return $row;
}

function show_result($result_upload){
    foreach($result_upload as $result){

        if($result['result'] == "Succes"){
            echo '<tr class="bg-info">
            <td>'.
                $result['NO'] .')  '.$result['catatan']
            .'.</td>
        </tr>';
        }else{
            echo '<tr class="bg-danger">
            <td>'.
                $result['NO'] .':(  '.$result['catatan']
            .'.</td>
        </tr>';
        }
    }
}

function update_data($tabel,$id,$kolom,$nilai,$conn){
    $koloms = explode(',',$kolom);
    $nilais = explode('#&#',$nilai);
    $row_kolom = count($koloms);
    $row_nilai = count($nilais);
    $hasil = "Berhasil Diupdate";
    if($row_kolom === $row_nilai){
        for($x=0;$x<$row_kolom;$x++){
            if($nilais[$x] != "''" && $nilais[$x] != '""' && $nilais[$x] != "" && $nilais[$x] != null){
                
                $query = "UPDATE $tabel SET $koloms[$x]=$nilais[$x] WHERE NO='$id'";
                $result = $conn->query($query);
                if(!$result){
                     $hasil = "Gagal Diupdate - ";
                    $hasil .= $conn->error;
                }                
            }
        }
    }else{
        $hasil = "Gagal disimpan - error didaftar kolom";
    }
    return $hasil;
}

function test($array){
	if(is_array($array) || is_object($array)){
    echo "<pre>";
    print_r($array);
    echo "</pre>";
}else { echo $array; }
}

// database 
function update_mhs($nim,$kolom,$value,$conn){
    $koloms = explode(',',$kolom);
    $nilais = explode('#&#',$value);
    $row_kolom = count($koloms);
    $row_nilai = count($nilais);
    if($row_kolom == $row_nilai){
        for($x=0;$x<$row_kolom;$x++){
            $query = "UPDATE tabel_mhs SET $koloms[$x]=$nilais[$x] WHERE NIM='$nim'";
            $result = $conn->query($query);
            if(!$result){
                 $hasil = "Gagal disimpan - ";
                $hasil .= $conn->error;
            }else{
                $hasil = "Berhasil disimpan";
            }
        }
    }else{
        $hasil = "Gagal disimpan - error didaftar kolom";
    }
    return $hasil;
}
function mhs($nim,$conn){
    $fil = "NIM='".$nim."'";
    $mhs = select_where("tabel_mhs",$fil,$conn);
    if(is_array($mhs)){
        $hasil = get_output($mhs[0]['NAMA']);
    }else{
        $hasil = "Mahasiswa Tidak Ditemukan";
    }
    return $hasil;
}
function sts_honor($nim,$i,$conn){
    $fil = "NIM='".$nim."'";
    $mhs = select_where("tabel_honor_skripsi",$fil,$conn);
    if(is_array($mhs)){
        if($i == "pem" || $i == "Pem"){
            $hasil = get_output($mhs[0]['Pembimbing']);
        }if($i == "peng" || $i == "Peng"){
            $hasil = get_output($mhs[0]['Penguji']);
        }
    }else{
        $hasil = "";
    }
    return $hasil;
}
function dsn($nip,$conn){
    $fil = "NIP='$nip'";
    $dsn = select_where("tabel_dosen",$fil,$conn);
    if(is_array($dsn)){
        $hasil = get_output($dsn[0]['NAMA']);
    }else{
        $hasil = "Mahasiswa Tidak Ditemukan";
    }
    return $hasil;

}
function daftar_kurikulum($conn){
    $data = select_all("tabel_kurikulum",$conn);
    return $data;
}

function get_pa($nim,$conn){
    $fil = "NIM ='".$nim."'";
    $data = select_where("tabel_pa",$fil,$conn);
    if(is_array($data)){
        $dosen_pa = dsn($data[0]['NIP_Dosen'],$conn);
        return $dosen_pa;
    }
}

function get_kurukulum($nim,$conn){
    $fil = "NIM='".$nim."'";
    $mhs = select_where("tabel_mhs",$fil,$conn);
    if(is_array($mhs)){
        $angkatan = get_output($mhs[0]['ANGKATAN']);
        $fil_2 = "ANGKATAN LIKE '%".$angkatan."%'";
        $kur = select_where("tabel_kurikulum",$fil_2,$conn);
        $hasil = get_output($kur[0]['NAMA']);
    }else{
        $hasil = "Mahasiswa Tidak Ditemukan";
    }
    return $hasil;
}
function nilai_mk($nim,$Kode_mk,$kurikulum,$conn){
    $fil = "NIM='$nim' AND KODE_MATA_KULIAH='$Kode_mk' AND NAMA_KURIKULUM='$kurikulum' ORDER BY NILAI_INDEKS DESC";
    $data_nilai = select_where("tabel_nilai_mk",$fil,$conn);
    if(is_array($data_nilai)){
        $hasil = $data_nilai[0]['NILAI_HURUF'];
    }else{
        $hasil = "-";
    }
    return $hasil;
}
function mhs_aktif($conn){
    $query = "SELECT * FROM tabel_mhs WHERE STATUS_MAHASISWA='Aktif'";
    $result = sql_query($query,$conn);
    $rows = $result->num_rows;
    return $rows;
}
function mhs_lulus($conn){
    $query = "SELECT * FROM tabel_mhs WHERE STATUS_MAHASISWA='Lulus'";
    $result = sql_query($query,$conn);
    $rows = $result->num_rows;
    return $rows;
}
function mhs_keluar($conn){
    $query = "SELECT * FROM tabel_mhs WHERE STATUS_MAHASISWA='Mengundurkan Diri'";
    $result = sql_query($query,$conn);
    $rows = $result->num_rows;
    return $rows;
}
function mhs_pindah($conn){
    $query = "SELECT * FROM tabel_mhs WHERE STATUS_MAHASISWA='Pindah'";
    $result = sql_query($query,$conn);
    $rows = $result->num_rows;
    return $rows;
}
function angkatan_mhs($conn){
    // $query = "SELECT ANGKATAN FROM tabel_mhs WHERE STATUS_MAHASISWA='Aktif' GROUP BY ANGKATAN";
    $query = "SELECT ANGKATAN FROM tabel_mhs GROUP BY ANGKATAN";
    $result = sql_query($query,$conn);
    return $result;
}
function angkatan_mhs_lulus($conn){
    $query = "SELECT ANGKATAN FROM tabel_mhs WHERE STATUS_MAHASISWA='Lulus' GROUP BY ANGKATAN";
    $result = sql_query($query,$conn);
    return $result;
}
function daftar_mk($conn){
    $fil = "KODE !='' ORDER BY NAMA_KURIKULUM";
    $data = select_where("tabel_mk",$fil,$conn);
    $kur_1 = "";
    $no = 0;
    foreach($data as $d){
        $no++;
        $kur = $d['NAMA_KURIKULUM'];
        if($kur != $kur_1){
            $kur_1 = $kur;
            $no = 0;
            $hasil[$kur_1] = array();
        }
        $hasil[$kur_1] +=array($no => $d);
    }
    return $hasil;
}
function daftar_mk_khd($conn){
    $query = "SELECT PERIODE,KODE_MATA_KULIAH,NAMA_MATA_KULIAH,NAMA_KELAS FROM tabel_kehadiran GROUP BY KODE_MATA_KULIAH,NAMA_MATA_KULIAH ORDER BY PERIODE";
    $data = sql_query($query,$conn);
    $kur_1 = "";
    $no = 0;
    foreach($data as $d){
        $no++;
        $kur = $d['PERIODE'];
        if($kur != $kur_1){
            $kur_1 = $kur;
            $no = 0;
            $hasil[$kur_1] = array();
        }
        $hasil[$kur_1] +=array($no => $d);
    }
    return $hasil;
}
function read_data_matakuliah($kurikulum,$conn){
    $hasil_akhir = array();
    $query_2 = "SELECT * FROM tabel_mk WHERE NAMA_KURIKULUM ='$kurikulum'";
    $result_2 = sql_query($query_2,$conn);

    $rows = $result_2->num_rows;
    for($x=0;$x<$rows;$x++){
        $data_2 = $result_2->fetch_array(MYSQLI_ASSOC);
            $hasil = array();
            foreach($data_2 as $item =>$isi){
              $hasil  += array($item => $isi);
            }
            $hasil_akhir += array("$x"=>$hasil);        
    }
    return $hasil_akhir;
}
function read_data_bimbingan($dosen,$conn){
    $bimbingan = array("PEMB_1"=> 0, "PEMB_2"=> 0, "PENG_1"=> 0 , "PENG_2"=> 0);
    $fil = "STATUS_MAHASISWA='Aktif'";
    $data_mhs = select_where("tabel_mhs",$fil,$conn);
    foreach($data_mhs as $mhs){
        $fil_2= "NIM = '".$mhs['NIM']."'";
        $data_skripsi = select_where("tabel_skripsi",$fil_2,$conn);

        if(!is_array($data_skripsi)) continue;

        if($data_skripsi[0]['PEMBIMBING_1'] == $dosen){
            $bimbingan['PEMB_1'] += 1;
        }
        if($data_skripsi[0]['PEMBIMBING_2'] == $dosen){
            $bimbingan['PEMB_2'] += 1;
        }
        if($data_skripsi[0]['PENGUJI_1'] == $dosen){
            $bimbingan['PENG_1'] += 1;
        }
        if($data_skripsi[0]['PENGUJI_2'] == $dosen){
            $bimbingan['PENG_2'] += 1;
        }
    }
    return $bimbingan;
}
function get_pembimbing_skripsi($conn){
    $dosen = array();
    $fil = "PEMBIMBING_1 !='' GROUP BY PEMBIMBING_1";
    $data_dosen = select_where("tabel_skripsi",$fil,$conn);
    for($i = 0; $i < count($data_dosen); $i++){
        array_push($dosen,$data_dosen[$i]['PEMBIMBING_1']); 
    }
    $fil = "PEMBIMBING_2 !='' GROUP BY PEMBIMBING_2";
    $data_dosen = select_where("tabel_skripsi",$fil,$conn);
    for($i = 0; $i < count($data_dosen); $i++){
        array_push($dosen,$data_dosen[$i]['PEMBIMBING_2']); 
    }
    $fil = "PENGUJI_1 !='' GROUP BY PENGUJI_1";
    $data_dosen = select_where("tabel_skripsi",$fil,$conn);
    for($i = 0; $i < count($data_dosen); $i++){
        array_push($dosen,$data_dosen[$i]['PENGUJI_1']); 
    }
    $fil = "PENGUJI_2 !='' GROUP BY PENGUJI_2";
    $data_dosen = select_where("tabel_skripsi",$fil,$conn);
    for($i = 0; $i < count($data_dosen); $i++){
        array_push($dosen,$data_dosen[$i]['PENGUJI_2']); 
    }
    return array_unique($dosen);
}
function cek($whare,$tabel,$conn){
    $sql = "SELECT * FROM $tabel WHERE $whare";
    $result = $conn->query($sql);
    if($result->num_rows == 0){
        // data tidak ada 
        $hasil['result'] = "tdk_ada";
        $hasil['id'] = "";
        return $hasil;
    }else{
        // data ada 
        $result->data_seek(0);
        $data = $result->fetch_array(MYSQLI_ASSOC);
        $hasil['result'] = "ada";
        $hasil['id'] = $data['NO'];
        return $hasil;
    }

}

function upload_alumni($data, $conn){    
    $mak = count($data);
    $header = array("NO","NIM","Nama","Email",
    "Status_Pekerjaan","Alamat_Instansi","No_HP","Tahun_Yudisium",
    "Tahun_Wisuda","Tahun_Pertama_Bekerja","Waktu_tunggu","Instansi_Kerja_Pertama",
    "Gaji_Pertama","Pekerjaan_Terakhir","Nilai_Toefl","Lama_Studi","PIN_Ijazah");
    if($data[0] == $header){        
        for($x=2;$x<$mak;$x++){
            $d = $data[$x];
            $no = $x;
            foreach($d as $i=>$v){
                $d[$i] = get_input($v);
            }
            if($d['1'] != ""){
                $whare = "NIM ='$d[1]'";
                $tabel = "tabel_alumni";
                $cek = cek($whare,$tabel,$conn);
                if($cek['result'] == "tdk_ada"){
                    $col = "NIM,Nama,Email,Status_Pekerjaan,Alamat_Instansi,No_HP,Tahun_Yudisium,Tahun_Wisuda,Tahun_Pertama_Bekerja,Waktu_tunggu,Instansi_Kerja_Pertama,Gaji_Pertama,Pekerjaan_Terakhir,Nilai_Toefl,Lama_Studi,PIN_Ijazah";
                    $value = "'$d[1]','$d[2]','$d[3]','$d[4]','$d[5]','$d[6]','$d[7]','$d[8]','$d[9]','$d[10]','$d[11]','$d[12]','$d[13]','$d[14]','$d[15]','$d[16]'";
                    $query = "INSERT INTO $tabel($col) VALUES($value)";
                    $result = $conn->query($query);
                    if(!$result){
                        $hasil[$no]['NO'] = $d[0];
                        $hasil [$no]['result'] = "Failed";
                        $hasil[$no]['catatan'] = $conn->error;
                    }else{
                        $hasil[$no]['NO'] = $d[0];
                        $hasil [$no]['result'] = "Succes";
                        $hasil[$no]['catatan'] = "Data berhasil disimpan";
                    }
                }else{
                    $col = "NIM,Nama,Email,Status_Pekerjaan,Alamat_Instansi,No_HP,Tahun_Yudisium,Tahun_Wisuda,Tahun_Pertama_Bekerja,Waktu_tunggu,Instansi_Kerja_Pertama,Gaji_Pertama,Pekerjaan_Terakhir,Nilai_Toefl,Lama_Studi,PIN_Ijazah";
                    $value = "'$d[1]'#&#'$d[2]'#&#'$d[3]'#&#'$d[4]'#&#'$d[5]'#&#'$d[6]'#&#'$d[7]'#&#'$d[8]'#&#'$d[9]'#&#'$d[10]'#&#'$d[11]'#&#'$d[12]'#&#'$d[13]'#&#'$d[14]'#&#'$d[15]'#&#'$d[16]'";
                    $hsl_update = update_data($tabel,$cek['id'],$col,$value,$conn);
                    $hasil[$no]['NO'] = $d[0];
                    $hasil [$no]['result'] = "Succes";
                    $hasil[$no]['catatan'] = "Data sudah Ada: $hsl_update";
                   
                }
            }
        }
    }else{
        $hasil[0]['NO'] = "";
        $hasil [0]['result'] = "Failed";
        $hasil[0]['catatan'] = "Gunakan template yang ada";
    }
    return  $hasil;
}



function upload_hnr_skripsi($data, $conn){    
    $mak = count($data);
    $header = array("NO","NIM","Nama","Pembimbing","Penguji","penguji_semhas");
    if($data[0] == $header){        
        for($x=2;$x<$mak;$x++){
            $d = $data[$x];
            $no = $x;
            foreach($d as $i=>$v){
                $d[$i] = get_input($v);
            }
            if($d['1'] != ""){
                $whare = "NIM ='$d[1]'";
                $tabel = "tabel_honor_skripsi";
                $cek = cek($whare,$tabel,$conn);
                if($cek['result'] == "tdk_ada"){
                    $col = "NIM,Nama,Pembimbing,Penguji,penguji_semhas";
                    $value = "'$d[1]','$d[2]','$d[3]','$d[4]','$d[5]'";
                    $query = "INSERT INTO $tabel($col) VALUES($value)";
                    $result = $conn->query($query);
                    if(!$result){
                        $hasil[$no]['NO'] = $d[0];
                        $hasil [$no]['result'] = "Failed";
                        $hasil[$no]['catatan'] = $conn->error;
                    }else{
                        $hasil[$no]['NO'] = $d[0];
                        $hasil [$no]['result'] = "Succes";
                        $hasil[$no]['catatan'] = "Data berhasil disimpan";
                    }
                }else{
                    $col = "NIM,Nama,Pembimbing,Penguji,penguji_semhas";
                    $value = "'$d[1]'#&#'$d[2]'#&#'$d[3]'#&#'$d[4]'#&#'$d[5]'";
                    $hsl_update = update_data($tabel,$cek['id'],$col,$value,$conn);
                    $hasil[$no]['NO'] = $d[0];
                    $hasil [$no]['result'] = "Succes";
                    $hasil[$no]['catatan'] = "Data sudah Ada: $hsl_update";
                   
                }
            }
        }
    }else{
        $hasil[0]['NO'] = "";
        $hasil [0]['result'] = "Failed";
        $hasil[0]['catatan'] = "Gunakan template yang ada";
    }
    return  $hasil;
}

function upload_skripsi($data, $conn){    
    $mak = count($data);
    $header = array("NO","NIM","NAMA","JUDUL_SKRIPSI","PEMBIMBING_1","PEMBIMBING_2","PENGUJI_1","PENGUJI_2","SK_PEMBIMBING","SK_PENGUJI","TGL_SEMPRO","TGL_SEMHAS");
    if($data[0] == $header){        
        for($x=2;$x<$mak;$x++){
            $d = $data[$x];
            $no = $x;
            foreach($d as $i=>$v){
                $d[$i] = get_input($v);
            }
            if($d['1'] != ""){
                $whare = "NIM ='$d[1]'";
                $tabel = "tabel_skripsi";
                $cek = cek($whare,$tabel,$conn);
                if($cek['result'] == "tdk_ada"){
                    $col = "NIM,NAMA,JUDUL_SKRIPSI,PEMBIMBING_1,PEMBIMBING_2,PENGUJI_1,PENGUJI_2,TGL_SEMPRO,TGL_SEMHAS";
                    $value = "'$d[1]','$d[2]','$d[3]','$d[4]','$d[5]','$d[6]','$d[7]','$d[8]','$d[9]'";
                    $query = "INSERT INTO $tabel($col) VALUES($value)";
                    $result = $conn->query($query);
                    if(!$result){
                        $hasil[$no]['NO'] = $d[0];
                        $hasil [$no]['result'] = "Failed";
                        $hasil[$no]['catatan'] = $conn->error;
                    }else{
                        $hasil[$no]['NO'] = $d[0];
                        $hasil [$no]['result'] = "Succes";
                        $hasil[$no]['catatan'] = "Data berhasil disimpan";
                    }
                }else{
                    $col = "NIM,NAMA,JUDUL_SKRIPSI,PEMBIMBING_1,PEMBIMBING_2,PENGUJI_1,PENGUJI_2,TGL_SEMPRO,TGL_SEMHAS";
                    $value = "'$d[1]'#&#'$d[2]'#&#'$d[3]'#&#'$d[4]'#&#'$d[5]'#&#'$d[6]'#&#'$d[7]'#&#'$d[8]'#&#'$d[9]'";
                    $hsl_update = update_data($tabel,$cek['id'],$col,$value,$conn);
                    $hasil[$no]['NO'] = $d[0];
                    $hasil [$no]['result'] = "Succes";
                    $hasil[$no]['catatan'] = "Data sudah Ada: $hsl_update";
                }
            }
        }
    }else{
        $hasil[0]['NO'] = "";
        $hasil [0]['result'] = "Failed";
        $hasil[0]['catatan'] = "Gunakan template yang ada";
    }
    return  $hasil;
}

function upload_buku($data, $conn){    
    $mak = count($data);
    $header = array("NO","ISBN","JUDUL_BUKU","PENERBIT","PENGARANG","COPY","TAHUN_TERBIT","KODE_BUKU");
    if($data[0] == $header){        
        for($x=2;$x<$mak;$x++){
            $d = $data[$x];
            $no = $x;
            foreach($d as $i=>$v){
                $d[$i] = get_input($v);
            }
            if($d['1'] != ""){
                $whare = "ISBN = '$d[1]' ";
                $tabel = "tabel_buku";
                $cek = cek($whare,$tabel,$conn);
                if($cek['result'] == "tdk_ada"){
                    $col = "ISBN,JUDUL_BUKU,PENERBIT,PENGARANG,COPY,TAHUN_TERBIT,KODE_BUKU";
                    $value = "'$d[1]','$d[2]','$d[3]','$d[4]','$d[5]','$d[6]','$d[7]'";
                    $query = "INSERT INTO $tabel($col) VALUES($value)";
                    $result = $conn->query($query);
                    if(!$result){
                        $hasil[$no]['NO'] = $d[0];
                        $hasil [$no]['result'] = "Failed";
                        $hasil[$no]['catatan'] = $conn->error;
                    }else{
                        $hasil[$no]['NO'] = $d[0];
                        $hasil [$no]['result'] = "Succes";
                        $hasil[$no]['catatan'] = "Data berhasil disimpan";
                    }
                }else{
                    $col = "ISBN,JUDUL_BUKU,PENERBIT,PENGARANG,COPY,TAHUN_TERBIT,KODE_BUKU";
                    $value = "'$d[1]'#&#'$d[2]'#&#'$d[3]'#&#'$d[4]'#&#'$d[5]'#&#'$d[6]'#&#'$d[7]'";
                    $hsl_update = update_data($tabel,$cek['id'],$col,$value,$conn);
                    $hasil[$no]['NO'] = $d[0];
                    $hasil [$no]['result'] = "Succes";
                    $hasil[$no]['catatan'] = "Data sudah Ada: $hsl_update";
                }
            }
        }
    }else{
        $hasil[0]['NO'] = "";
        $hasil [0]['result'] = "Failed";
        $hasil[0]['catatan'] = "Gunakan template yang ada";
    }
    return  $hasil;
}

function upload_barang($data, $conn){    
    $mak = count($data);
    $header = array("NO","Kode","Nama_Barang","Tipe_Merk","Jumlah","Tempat","Foto","Kondisi");
    if($data[0] == $header){        
        for($x=2;$x<$mak;$x++){
            $d = $data[$x];
            $no = $x;
            foreach($d as $i=>$v){
                $d[$i] = get_input($v);
            }
            if($d['1'] != ""){
                $whare = "Kode = '$d[1]' AND Nama_Barang='$d[2]' AND Tipe_Merk = '$d[3]'";
                $tabel = "tabel_inventaris";
                $cek = cek($whare,$tabel,$conn);
                if($cek['result'] == "tdk_ada"){
                    $col = "Kode,Nama_Barang,Tipe_Merk,Jumlah,Tempat,Foto,Kondisi";
                    $value = "'$d[1]','$d[2]','$d[3]','$d[4]','$d[5]','$d[6]','$d[7]'";
                    $query = "INSERT INTO $tabel($col) VALUES($value)";
                    $result = $conn->query($query);
                    if(!$result){
                        $hasil[$no]['NO'] = $d[0];
                        $hasil [$no]['result'] = "Failed";
                        $hasil[$no]['catatan'] = $conn->error;
                    }else{
                        $hasil[$no]['NO'] = $d[0];
                        $hasil [$no]['result'] = "Succes";
                        $hasil[$no]['catatan'] = "Data berhasil disimpan";
                    }
                }else{
                    $col = "Kode,Nama_Barang,Tipe_Merk,Jumlah,Tempat,Foto,Kondisi";
                    $value = "'$d[1]'#&#'$d[2]'#&#'$d[3]'#&#'$d[4]'#&#'$d[5]'#&#'$d[6]'#&#'$d[7]'";
                    $hsl_update = update_data($tabel,$cek['id'],$col,$value,$conn);
                    $hasil[$no]['NO'] = $d[0];
                    $hasil [$no]['result'] = "Succes";
                    $hasil[$no]['catatan'] = "Data sudah Ada: $hsl_update";
                }
            }
        }
    }else{
        $hasil[0]['NO'] = "";
        $hasil [0]['result'] = "Failed";
        $hasil[0]['catatan'] = "Gunakan template yang ada";
    }
    return  $hasil;
}



function dosen_homebase($conn){
    $sql = "SELECT * FROM tabel_dosen WHERE HOMEBASE LIKE '%Komputer%' AND JABATAN='Dosen' GROUP BY NIP";
    $result = sql_query($sql,$conn);
    return $result->num_rows;
}
function rasio_dosen($conn){
    $dosen = dosen_homebase($conn);
$mhs = mhs_aktif($conn);
if($dosen === 0) {return;}
$rasio = ($dosen/$dosen) .":". floor($mhs/$dosen);
return $rasio;

}
function dosen_luar($conn){
    $sql = "SELECT * FROM tabel_dosen WHERE HOMEBASE != 'Pend. Komputer' AND JABATAN='Dosen'";
    $result = sql_query($sql,$conn);
    return $result->num_rows;
}

function read_data_nilai($tabel_1,$nama_mk,$nama_kurikulum,$conn){
    $hasil_akhir = array();
    // $nim = array();
    $query_1 = "SELECT ANGKATAN FROM tabel_kurikulum WHERE NAMA='$nama_kurikulum'";
    $result_1 = sql_query($query_1,$conn);
    // $result_1->data_seek(0);
    $data_angkatan = $result_1->fetch_array(MYSQLI_ASSOC);
    $angkatan = explode(',',$data_angkatan['ANGKATAN']);
    foreach($angkatan as $ang){        
        $query_2 = "SELECT NIM,NAMA,STATUS_MAHASISWA FROM tabel_mhs WHERE ANGKATAN='$ang' AND STATUS_MAHASISWA='Aktif' ORDER BY NIM";
        $result_2 = sql_query($query_2,$conn);
        $rows_2 = $result_2->num_rows;
        if($rows_2 <= 0){
            continue;
        }
        for($i=0;$i<$rows_2;$i++){
            $hasil = array();
            $result_2->data_seek($i);
            $data_mahasiswa = $result_2->fetch_array(MYSQLI_ASSOC);
            // $hasil['NAMA']= $data_mahasiswa['NAMA'];
            // $hasil['NIM']=$data_mahasiswa['NIM'];
            $nim = $data_mahasiswa['NIM'];
            $query_3 = "SELECT * FROM $tabel_1 WHERE NIM = '$nim' AND NAMA_MATA_KULIAH='$nama_mk'AND NAMA_KURIKULUM ='$nama_kurikulum' ORDER BY NILAI_INDEKS DESC";
            $result_3 = sql_query($query_3,$conn);
            $rows_3 = $result_3->num_rows;
            // $rows_3 = 0;
            if($rows_3 > 0){
                $result_3->data_seek(0);
                $data_nilai = $result_3->fetch_array(MYSQLI_ASSOC);
                $hasil = array();
                foreach($data_nilai as $item =>$isi){
                    $hasil  += array($item => $isi);
                }
                if($hasil['NILAI_HURUF'] == "E" || $hasil['NILAI_HURUF'] == "D" || $hasil['NILAI_HURUF'] == "D+" || $hasil['NILAI_HURUF']==""){
                    $hasil += array("STATUS_LULUS"=>"TL");
                }else{
                    $hasil += array("STATUS_LULUS"=>"L");
                }
                $hasil += array('NAMA' => $data_mahasiswa['NAMA']);
                $hasil += array('STATUS_MAHASISWA' => $data_mahasiswa['STATUS_MAHASISWA']);
                $hasil_akhir += array("$nim"=>$hasil);    
            }
        }
    }
    return $hasil_akhir; //hasil berupa array
}

function lulusmk($data){
    $jml = 0;
    foreach($data as $isi_data){
        if($isi_data['NILAI_INDEKS'] >= 2.00 OR $isi_data['NILAI_ANGKA'] >= 60){
            $jml++;
        }
    }
    return $jml;
}
function tdklulusmk($data){
    $jml = 0;
    foreach($data as $isi_data){
        if($isi_data['NILAI_INDEKS'] <2.00 AND $isi_data['NILAI_HURUF'] != "C"){
            $jml++;
        }
    }
    return $jml;
}
function blmlulusmk($kurikulum,$data,$conn){
    $query_1 = "SELECT ANGKATAN FROM tabel_kurikulum WHERE NAMA='$kurikulum'";
    $result_1 = sql_query($query_1,$conn);
    $data_angkatan = $result_1->fetch_array(MYSQLI_ASSOC);
    $angkatan = explode(',',$data_angkatan['ANGKATAN']);
    
    $blm_mengambil = array();
    foreach($angkatan as $ang){        
        $query_2 = "ANGKATAN='$ang' AND STATUS_MAHASISWA='Aktif' GROUP BY NIM";
        $result_2 = select_where("tabel_mhs",$query_2,$conn);
        foreach($result_2 as $r2){
            $jumlah = 0;	
            foreach($data as $d){
                if(in_array($r2['NIM'],$d)){                      
                    $jumlah += 1;
                }
            }
            if($jumlah == 0){
                $nim = $r2['NIM'];
                $nama = $r2['NAMA'];                  
                $blm_mengambil += array($nim=>$nama);
            }
        }
    }    
    return $blm_mengambil;
}

function tabel_blm_mengambil($data){
    if(!is_array($data)){
        return;
    }
    foreach($data as $nim => $nama){
        echo "<tr>";
        echo "<td>$nama</td>";
        echo "<td>$nim</td>";
        echo "</tr>";
       } 
}
function tabel_keaktifan_mhs($angk,$conn){
    if($angk != ""){
       // $fill = "ANGKATAN = $angk AND STATUS_MAHASISWA='Aktif'";
	$fill = "ANGKATAN = $angk";
        $data_mhs = select_where("tabel_mhs",$fill,$conn);
        foreach($data_mhs as $mhs){
            $nim = $mhs['NIM'];
            $fil_1 = "NIM='$nim' AND STATUS_MAHASISWA !='null' ORDER BY periode ASC";
            $data_1 = select_where("tabel_nilai_ipk",$fil_1,$conn);
            foreach($data_1 as $d){
                // $nim = $d['NIM'];
                $p = $d['PERIODE'];
                $data[$nim][$p] = $d['STATUS_MAHASISWA'];
                $per[$p] = 1;
            }
        }
        echo "<table id='tabel' class='table'>";
        echo "<thead><tr><th>NIM</th><th>Nama</th>";
        foreach($per as $p=>$v){
            echo "<th>$p</th>";
        }
        echo "</tr></thead>";
        echo "<tbody>";
        foreach($data_mhs as $mhs){
            $nim = $mhs['NIM'];
            echo "<tr>
            <td>$nim</td>
            <td>$mhs[NAMA]</td>";
            foreach($per as $p=>$v){
                if(isset($data[$nim][$p])){
                    $sts = $data[$nim][$p];
                    echo "<td style='width:84px;' class='bg-info text-center'>$sts</td>";
                }else{
                    echo "<td style='width:84px;' class='bg-danger text-center'>-</td>";
                }
            }
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
        // return test($data);
    }
    return;
}


function daftar_dsn_skripsi($conn){
    $f_1 = "PEMBIMBING_1 !='' GROUP BY PEMBIMBING_1";
    $h_1 = select_where("tabel_skripsi",$f_1,$conn);
    $f_2 = "PEMBIMBING_2 !='' GROUP BY PEMBIMBING_2";
    $h_2 = select_where("tabel_skripsi",$f_2,$conn);
    $f_3 = "PENGUJI_1 !='' GROUP BY PENGUJI_1";
    $h_3 = select_where("tabel_skripsi",$f_3,$conn);
    $f_4 = "PENGUJI_2 !='' GROUP BY PENGUJI_2";
    $h_4 = select_where("tabel_skripsi",$f_4,$conn);
    $hasil = array();
    
    foreach($h_1 as $h){
        $no = count($hasil);
        $hasil[$no] = $h['PEMBIMBING_1'];
    }
    foreach($h_2 as $h){
        $no = count($hasil);
        $hasil[$no] = $h['PEMBIMBING_2'];
    }
    foreach($h_3 as $h){
        $no = count($hasil);
        $hasil[$no] = $h['PENGUJI_1'];
    }
    foreach($h_4 as $h){
        $no = count($hasil);
        $hasil[$no] = $h['PENGUJI_2'];
    }

    return array_unique($hasil);
}

function tabel_data_pem($sts_mhs,$id_dosen,$conn){
    //$fil_1 = "NIP='$id_dosen'";
    //$data_dosen = select_where("tabel_dosen",$fil_1,$conn);
    //$nama = $data_dosen[0]['NAMA'];
    $fil_2 = "tabel_skripsi.NIM = tabel_mhs.NIM AND tabel_mhs.STATUS_MAHASISWA='$sts_mhs' AND tabel_skripsi.PEMBIMBING_1='$id_dosen' GROUP BY tabel_skripsi.NIM";
    $data_1 = select_where("tabel_skripsi,tabel_mhs",$fil_2,$conn);
    
    $fil_3 = "tabel_skripsi.NIM = tabel_mhs.NIM AND tabel_mhs.STATUS_MAHASISWA='$sts_mhs' AND tabel_skripsi.PEMBIMBING_2='$id_dosen' GROUP BY tabel_skripsi.NIM";
    $data_2 = select_where("tabel_skripsi,tabel_mhs",$fil_3,$conn);
    
    if(is_array($data_1)){
        foreach($data_1 as $d){
            echo "<tr>";
            echo "<td>$d[NIM]</td>";
            echo "<td>".get_output($d['NAMA'])."</td><td><p class='ml-0 sts_mhs Aktif'>Pembimbing_1</p></td>";
            echo "<td>$d[JUDUL_SKRIPSI]</td>";
            echo "</tr>";
        }
    }
    if(is_array($data_2)){
        foreach($data_2 as $d){
            echo "<tr>";
            echo "<td>$d[NIM]</td>";
            echo "<td>".get_output($d['NAMA'])."</td><td><p class='ml-0 sts_mhs'>Pembimbing_2</p></td>";
            echo "<td>$d[JUDUL_SKRIPSI]</td>";
            echo "</tr>";
        }
    }
}
function tabel_data_peng($sts_mhs,$id_dosen,$conn){
    //$fil_1 = "NIP='$id_dosen'";
    //$data_dosen = select_where("tabel_dosen",$fil_1,$conn);
    //$nama = $data_dosen[0]['NAMA'];
    $fil_2 = "tabel_skripsi.NIM = tabel_mhs.NIM AND tabel_mhs.STATUS_MAHASISWA='$sts_mhs' AND tabel_skripsi.PENGUJI_1='$id_dosen' GROUP BY tabel_skripsi.NIM";
    $data_1 = select_where("tabel_skripsi,tabel_mhs",$fil_2,$conn);
    
    $fil_3 = "tabel_skripsi.NIM = tabel_mhs.NIM AND tabel_mhs.STATUS_MAHASISWA='$sts_mhs' AND tabel_skripsi.PENGUJI_2='$id_dosen' GROUP BY tabel_skripsi.NIM";
    $data_2 = select_where("tabel_skripsi,tabel_mhs",$fil_3,$conn);
    if(is_array($data_1)){
        foreach($data_1 as $d){
            echo "<tr>";
            echo "<td>$d[NIM]</td>";
            echo "<td>".get_output($d['NAMA'])."</td><td><p class='ml-0 sts_mhs Aktif'>Penguji_1</p></td>";
            echo "<td>$d[JUDUL_SKRIPSI]</td>";
            echo "</tr>";
        }
    }
    if(is_array($data_2)){
        foreach($data_2 as $d){
            echo "<tr>";
            echo "<td>$d[NIM]</td>";
            echo "<td>".get_output($d['NAMA'])."</td><td><p class='ml-0 sts_mhs'>Penguji_2</p></td>";
            echo "<td>$d[JUDUL_SKRIPSI]</td>";
            echo "</tr>";
        }
    }
}
function cetak_tabel($data){
 //test($data);
if($data == null){
return ; 
}else{
 echo "<table id='tabel' class='table table-hover'>";
 echo "<thead>";
  echo "<tr>";
  foreach($data[0] as $i=>$v){   
    echo "<th>$i</th>";
  }
  echo "</tr>";
 echo "<tbody>";
foreach($data as $d){
echo "<tr>";
  foreach($d as $i=>$v){   
    echo "<td>$v</td>";
  }
  echo "</tr>";
}
echo "</tbody>";
 echo "</thead>";
 echo "</table>";
}
}
function tabel_kegiatan_mhs($angkatan,$conn){
}
function jml_nilai($periode,$kur,$kode,$kelas,$nilai,$conn){
    $query = "SELECT * FROM tabel_nilai_mk WHERE PERIODE='$periode' AND NAMA_KURIKULUM='$kur' AND KODE_MATA_KULIAH='$kode' AND NAMA_KELAS='$kelas' AND NILAI_HURUF='$nilai'";
    $result = sql_query($query,$conn);
    return $result->num_rows;
}
function peserta($array,$conn){
    $query_1 = "PERIODE='".$array['pr']."' AND NAMA_MATA_KULIAH='".$array['mk1']."'";
    $hasil_1 = select_where_pst("tabel_kehadiran",$query_1,$conn);
    $query_2 = "PERIODE='".$array['pr']."' AND NAMA_MATA_KULIAH='".$array['mk2']."'";
    $hasil_2 = select_where_pst("tabel_kehadiran",$query_2,$conn);

    $hasil = array_intersect($hasil_1,$hasil_2);
    
    return $hasil;
}
function tabel_buku($conn){
    $data_buku  = select_all("tabel_buku",$conn);
    $no = 0;
    foreach($data_buku as $b){
        $no++;
        echo "<tr>";
        echo "<td>$b[ISBN]<br><span class='sts_mhs Aktif'>$b[KODE_BUKU]</span></td>";
        echo "<td>".get_output($b["JUDUL_BUKU"])."</td>";
        echo "<td>".get_output($b["PENGARANG"])."</td>";
        echo "<td>".get_output($b["PENERBIT"])."</td>";
        echo "<td>$b[COPY]</td>";
        echo "</tr>";
    }
}
function tabel_nilai_mk($periode,$conn){
    $no = 0;
if($periode == ""){return;}
    if($periode == "All"){
        $data_nilai = select_all("tabel_nilai_mk",$conn);
    }else{
        $fil_2 = "PERIODE ='".$periode."' GROUP BY NAMA_KURIKULUM,KODE_MATA_KULIAH,NAMA_KELAS ORDER BY NAMA_MATA_KULIAH DESC";
        $data_nilai = select_where("tabel_nilai_mk",$fil_2,$conn);
    }
    // test($data_mahasiswa);
    foreach($data_nilai as $n){
        $no++;
        // $nim = $n['NIM'];
        // $fil = "NIM='".$n."' ORDER BY PERIODE DESC";
        // $data_transkrip =  select_where("tabel_nilai_ipk",$fil,$conn);
        $nilai[0] = jml_nilai($periode,$n['NAMA_KURIKULUM'],$n['KODE_MATA_KULIAH'],$n['NAMA_KELAS'],'A',$conn);
        $nilai[1] = jml_nilai($periode,$n['NAMA_KURIKULUM'],$n['KODE_MATA_KULIAH'],$n['NAMA_KELAS'],'A-',$conn);
        $nilai[2] = jml_nilai($periode,$n['NAMA_KURIKULUM'],$n['KODE_MATA_KULIAH'],$n['NAMA_KELAS'],'B+',$conn);  
        $nilai[3] = jml_nilai($periode,$n['NAMA_KURIKULUM'],$n['KODE_MATA_KULIAH'],$n['NAMA_KELAS'],'B',$conn);
        $nilai[4] = jml_nilai($periode,$n['NAMA_KURIKULUM'],$n['KODE_MATA_KULIAH'],$n['NAMA_KELAS'],'B-',$conn);
        $nilai[5] = jml_nilai($periode,$n['NAMA_KURIKULUM'],$n['KODE_MATA_KULIAH'],$n['NAMA_KELAS'],'C+',$conn);  
        $nilai[6] = jml_nilai($periode,$n['NAMA_KURIKULUM'],$n['KODE_MATA_KULIAH'],$n['NAMA_KELAS'],'C',$conn);
        $nilai[7] = jml_nilai($periode,$n['NAMA_KURIKULUM'],$n['KODE_MATA_KULIAH'],$n['NAMA_KELAS'],'D+',$conn);
        $nilai[8] = jml_nilai($periode,$n['NAMA_KURIKULUM'],$n['KODE_MATA_KULIAH'],$n['NAMA_KELAS'],'D',$conn);  
        $nilai[9] = jml_nilai($periode,$n['NAMA_KURIKULUM'],$n['KODE_MATA_KULIAH'],$n['NAMA_KELAS'],'E',$conn);
        echo "<tr>";
        echo "<td>".$no."</td>";
        echo "<td><span><a href='?p=nilai_mk&i=edit&id=$n[KODE_MATA_KULIAH]&s=$n[PERIODE]&k=$n[NAMA_KURIKULUM]&kls=$n[NAMA_KELAS]'>".$n['NAMA_MATA_KULIAH']." (".$n['KODE_MATA_KULIAH'].")</a></span><br><span class='ml-0 sts_mhs'>[$n[NAMA_KURIKULUM]]</span></td>";
        echo "<td>".$n['NAMA_KELAS']."</td>";
        echo "<td>".$nilai[0]."</td>";
        echo "<td>".$nilai[1]."</td>";
        echo "<td>".$nilai[2]."</td>";   
        echo "<td>".$nilai[3]."</td>";
        echo "<td>".$nilai[4]."</td>";
        echo "<td>".$nilai[5]."</td>";  
        echo "<td>".$nilai[6]."</td>";
        echo "<td>".$nilai[7]."</td>";
        echo "<td>".$nilai[8]."</td>";  
        echo "<td>".$nilai[9]."</td>";
        echo "<td>".persentasi_lulus($nilai)."%</td>";    
        echo "</tr>";
    }
}
function tabel_rekap_nilai($periode,$conn){
    if($periode != null && $periode != ""){
	$no=0;
        $pr = $periode;
        $fil = "PERIODE = '".$pr."' ORDER BY NAMA_MATA_KULIAH";
        $data = select_where("tabel_nilai_mk",$fil,$conn);
        foreach($data as $d){
             $id = $d['NAMA_KURIKULUM'] ."-". $d['NAMA_MATA_KULIAH']." (".$d['KODE_MATA_KULIAH'].")";
             $new_array[$id][$no] = $d['NILAI_ANGKA'];
		$no++;
        }
foreach($new_array as $i=>$d){
$mk = explode("-",$i);
$per_lulus = round((jml_lulus($d) / count($d)) * 100,2);
$per_tdk_lulus = round((jml_tdk_lulus($d) / count($d)) * 100,2);
$rata2 = round(array_sum($d) / count($d),2);
echo "<tr>";
echo "<td>$mk[0]</td>";
echo "<td>$mk[1]</td>";
echo "<td>".jml_lulus($d)."</td>";
echo "<td>".jml_tdk_lulus($d)."</td>";
echo "<td>".$per_lulus." % </td>";
echo "<td>".$per_tdk_lulus." %</td>";
echo "<td>$rata2</td>";
echo "</tr>";
}
        //test($new_array);
    }
}
function tabel_kehadiran_mhs($periode,$conn){
    if($periode !="" && $periode !=null){
        $fil = "PERIODE ='".$periode."' ORDER BY NIM";
        $data = select_where("tabel_kehadiran",$fil,$conn);
        foreach($data as $d){
            $nim = $d['NIM'];
            if($d['JUMLAH_PERTEMUAN'] != 0){
                $per = number_format((float)($d['HADIR'] * 100 / $d['JUMLAH_PERTEMUAN']),2);
                if(!isset($kh[$nim])){
                    $kh[$nim]['NIM'] = $d['NIM'];
                    $kh[$nim]['NAMA'] = $d['NAMA_MAHASISWA'];
                    $kh[$nim]['PER'] = $per;
                    $kh[$nim]['HADIR'] = $d['HADIR'];
                    $kh[$nim]['TIDAK_HADIR'] = $d['IZIN'] + $d['TANPA_KETERANGAN'] + $d['SAKIT'];
                    $kh[$nim]['MK'] = $d['NAMA_MATA_KULIAH'];
                    $kh[$nim]['JML'] = $d['JUMLAH_PERTEMUAN'];
                }else{
                    if($per < $kh[$nim]['PER']){
                        $kh[$nim]['NIM'] = $d['NIM'];
                        $kh[$nim]['NAMA'] = $d['NAMA_MAHASISWA'];
                        $kh[$nim]['PER'] = $per;
                        $kh[$nim]['HADIR'] = $d['HADIR'];
                        $kh[$nim]['TIDAK_HADIR'] = $d['IZIN'] + $d['TANPA_KETERANGAN'] + $d['SAKIT'];
                        $kh[$nim]['MK'] = $d['NAMA_MATA_KULIAH'];
                        $kh[$nim]['JML'] = $d['JUMLAH_PERTEMUAN'];
                    }
                }
            }
            
        }
        foreach($kh as $k){
            echo "<tr>";
            echo "<td>".$k['NIM']."</td>";
            echo "<td>".$k['NAMA']."</td>";
            echo "<td>".$k['MK']."</td>";
            echo "<td>".$k['JML']."</td>";
            echo "<td>".$k['HADIR']."</td>";
            echo "<td>".$k['TIDAK_HADIR']."</td>";
            echo "<td>".$k['PER']."</td>";
            echo "<td><a class='float-right' href='?p=kehadiran&&i=edit&&id=".$nim."'><i class='fas fa-eye'></i></a></td>";
            echo "</tr>";
        }
    }
}
function jml_lulus($nilais){
	$jml = 0;
if(is_array($nilais)){
	foreach($nilais as $n){
if($n >= 60){$jml +=1; }
}
}
return $jml;
}
function jml_tdk_lulus($nilais){
	$jml = 0;
if(is_array($nilais)){
	foreach($nilais as $n){
if($n < 60){$jml +=1; }
}
}
return $jml;
}
function detail_nilai_mk($kode_mk,$kelas,$s,$conn){
    $fil = "tabel_nilai_mk.NIM = tabel_mhs.NIM AND KODE_MATA_KULIAH='$kode_mk' AND NAMA_KELAS='$kelas' AND PERIODE='$s' ORDER BY NILAI_INDEKS DESC";
    $data = select_where("tabel_nilai_mk,tabel_mhs",$fil,$conn);
    $no = 0;
    foreach($data as $d){
        if($d['NILAI_HURUF'] != ""){
            $no++;
            echo "<tr>";
            echo "<td>$no</td>";
            echo "<td>$d[NIM]</td>";
            echo "<td>".get_output($d['NAMA'])."</td>";
            echo "<td>$d[NAMA_MATA_KULIAH]</td>";
            echo "<td>$d[KODE_MATA_KULIAH]</td>";
            echo "<td>$d[NAMA_KELAS]</td>";
            echo "<td>$d[PERIODE]</td>";
            echo "<td>$d[NILAI_HURUF]</td>";
            echo "<td>$d[NILAI_ANGKA]</td>";
            echo "<td>$d[NILAI_INDEKS]</td>";
            echo "</tr>";
        }
    }
}
function detail_lulus_mk($nim,$mk,$conn){
    $fil = "NIM='$nim' AND KODE_MATA_KULIAH='$mk' ORDER BY PERIODE";
    $data = select_where("tabel_nilai_mk",$fil,$conn);
    if($data == 0){
        return;
    }
    foreach($data as $d){
        $p = $d['PERIODE'];
        $hasil['MATAKULIAH'] = $d['NAMA_MATA_KULIAH'];
        $hasil['KODE'] = $d['KODE_MATA_KULIAH'];
        $hasil[$p] = $d['NILAI_HURUF'];
    }
    echo "<thead>";
    echo "<tr>";
    foreach ($hasil as $i => $v){
        echo "<th>$i</th>";
    }
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    echo "<tr>";
    foreach ($hasil as $i => $v){
        echo "<td>$v</td>";
    }
    echo "</tr>";
    echo "</tbody>";
    // test($data);
}
function persentasi_lulus($array){
    $l = 0;
    for($x=0;$x<7;$x++){
        $l += $array[$x];
    }
    $jml = array_sum($array);
    if($jml != 0){
        $i = ($l/$jml) * 100;
        $i = number_format((float)$i,2);
    }else{
        $i = 0;
    }
    return $i;
}
function get_nilai_mhs($nim,$conn){    
        $fil = "NIM='".$nim."' ORDER BY PERIODE DESC";
        $data_transkrip =  select_where("tabel_nilai_ipk",$fil,$conn);
        if(!is_array($data_transkrip)){return;}
        if($data_transkrip[0]['IP_SEMESTER'] == 0 && count($data_transkrip) > 1){
           return $data_transkrip[1];
        }
        return $data_transkrip[0];
}
function savecatatan($catatan,$tipe,$conn){
    $query = "INSERT INTO catatan(catatan,kepentingan) VALUES('$catatan','$tipe')";
    $result = sql_query($query,$conn);
    return $result;
}
function hapuscatatan($id,$conn){
    $query = "UPDATE catatan SET status = '0' WHERE id='$id'";
    $result = sql_query($query,$conn);
    return $result;
}
function show_todo($conn){
    $fill = "kepentingan LIKE '%todo%' AND status = '1' ORDER BY time_update DESC";
    $data_catatan = select_where("catatan",$fill,$conn);

    foreach($data_catatan as $cttn){
        echo '<div class="col-12">
        <div class="card card-primary card-outline"> 
            <div class="card-header">        
                <div class="card-tools float-right ">
                    <a href="?i=del_ctt&id='.$cttn['id'].'" class="btn btn-tool"
                    onclick="return(konfirmasi())">
                    <i class="fas fa-times"></i>
                    </a>
                </div>
            </div>           
            <div class="card-body">
            '.get_output($cttn['catatan']).'
            </div>
        </div>
    </div>';
    }
}
function tabel_tautan($tautan){
    if(is_array($tautan)){
        foreach($tautan as $app){
            echo "<div class='col-sm-3'>";
            echo "<div class='card tautan'>";
            echo "<div class='card-body'>";
            echo "<img src='$app[icon]' class='tautan_img'>";
            echo "</div>";
            echo "<div class='card-footer'>";
            echo "<h4>$app[title]</h4>";
            echo "<div class='app_link'>";
            echo "<a class='btn btn-primary' href='$app[link]' target='_blank'>Website</a>";
            echo "<a class='btn btn-default' href='$app[admin]' target='_blank'>Admin</a>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
        }
    }
}
function tabel_header_mk(){
    echo "<thead>
    <th>NO</th>
    <th>KODE</th>
    <th>MATAKULIAH</th>
    <th>SKS</th>
    <th>NILAI</th>
    </thead>";
}
function tabel_start_mk(){
    echo "<div class='col-sm-6'>";
    echo "<table class='table table-hover table-bordered'>";
    tabel_header_mk();
    echo "</tbody>";
}
function tabel_end_mk(){
    echo "</tbody>";
    echo "</table>";
    echo "</div>";
}
function sks_belum_lulus($nim,$conn){
	$sks['wajib'] = 0;
	$kur = get_kurukulum($nim,$conn);
if($kur == 'Kurikulum MBKM 2020'){
	$sks['pilihan'] = 9;
}else{
	$sks['pilihan'] = 10;
}
    $fil_1 = "NAMA_KURIKULUM ='$kur' AND SIFAT_MATA_KULIAH='1'";
    $data_mk = select_where("tabel_mk",$fil_1,$conn);
 foreach($data_mk as $mk){
	$nilai = nilai_mk($nim,$mk['KODE'],$mk['NAMA_KURIKULUM'],$conn);
	if($nilai == "" || $nilai =="-" || $nilai == "E" || $nilai == "D" || $nilai == "D+"){
	$sks['wajib'] += $mk['SKS'];
	}
 }
$fil_1 = "NAMA_KURIKULUM ='$kur' AND SIFAT_MATA_KULIAH='0'";
    $data_mk = select_where("tabel_mk",$fil_1,$conn);
 foreach($data_mk as $mk){
	$nilai = nilai_mk($nim,$mk['KODE'],$mk['NAMA_KURIKULUM'],$conn);
	if($nilai == "A" || $nilai =="A-" || $nilai == "B+" || $nilai == "B" || $nilai == "B-" || $nilai == "C+" || $nilai == "C"){
	$sks['pilihan'] -= $mk['SKS'];
if($sks['pilihan'] < 0){$sks['pilihan'] = 0;}
	}
 }

return $sks;
}

function trim_nilai($value){
	$v = str_replace("+","",$value);
	$v = str_replace("-","E",$v);
	return $v;
}
function tabel_mk_pilihan($nim,$conn){
    $no = 0;
    $kur = get_kurukulum($nim,$conn);
    $fil_1 = "NAMA_KURIKULUM LIKE '%".$kur."%' AND SIFAT_MATA_KULIAH='0'";
    $data_mk = select_where("tabel_mk",$fil_1,$conn);
    if(is_array($data_mk)){
        tabel_start_mk();
        foreach($data_mk as $mk){
            $no++;
$nilai_mk = nilai_mk($nim,$mk['KODE'],$mk['NAMA_KURIKULUM'],$conn);
            echo "<tr>";
            echo "<td>".$no."</td>";
            echo "<td>".$mk['KODE']."</td>";
            echo "<td><a href='?p=lulus_mk&i=edit&id=$nim&mk=$mk[KODE]'>".$mk['NAMA_MATA_KULIAH']."</a></td>";
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
function tabel_jumlah_mhs_angkatan_lulus($conn){
    $data_angkatan = angkatan_mhs_lulus($conn);
    foreach($data_angkatan as $angkatan){
        $filter = "ANGKATAN ='".$angkatan['ANGKATAN']."' && STATUS_MAHASISWA='Lulus'";
        $mhs_angkatan = select_where("tabel_mhs",$filter,$conn);
        $jml = count($mhs_angkatan);
        echo "<tr>";
        echo "<td>".$angkatan['ANGKATAN']."</td>";
        echo "<td class='text-right'>".$jml."</td>";
        echo "</tr>";
    }
}

function rekap_data($conn){
    $rekap = array();
    // status mahasiswa 
    
    $rekap['sts_mhs']['Aktif'] = mhs_aktif($conn);
    $rekap['sts_mhs']['Lulus'] = mhs_lulus($conn);
    $rekap['sts_mhs']['Keluar'] = mhs_keluar($conn);
    $rekap['sts_mhs']['Pindah'] = mhs_pindah($conn);

    return $rekap;
}

function catatan($conn){
    $fil = "kepentingan='catatan' AND status = '1' ORDER BY time_update DESC";
    $data = select_where("catatan",$fil,$conn);
    return $data;
}
function todo($conn){
    $fil = "kepentingan='todo' AND status = '1' ORDER BY time_update DESC";
    $data = select_where("catatan",$fil,$conn);
    return $data;
}
function surat($conn){
    $fil = "kepentingan='surat' AND status = '1' ORDER BY time_update DESC";
    $data = select_where("catatan",$fil,$conn);
    return $data;
}

function display_catatan($p,$data){
$pesan= "'anda yakin?'";
    if(is_array($data)){
        foreach($data as $d){
            echo  '<div class="card card-info card-outline">
            <div class="card-body">
                <div class="card-tools">
                    <font href="#" class="btn btn-tool btn-link">'.$d['time_update'].'</font>
                    <a onclick="return(confirm('.$pesan.'))" href="?p='.$p.'&i=del_ctt&id='.$d['id'].'" class="btn btn-tool" title="tandai selesai">
                        <i class="fas fa-check"></i>
                    </a>
                </div>
                '.get_output($d['catatan']).'</div>
        </div>';
        }
    }
}

function tabel_kota_mhs($conn){
    $fill = "KOTA !='' GROUP BY KOTA";
    $mhs = select_where("tabel_mhs",$fill,$conn);
    $no = 0;
    foreach($mhs as $m){
        $kota = strtoupper($m['KOTA']);
        $fil = "KOTA = '".$kota."'";
        $jml = select_where("tabel_mhs",$fil,$conn);
        $asal_mhs[$kota]['nama'] = $kota;
        $asal_mhs[$kota]['jml'] = count($jml);
    }

    echo '<div class="col-sm-6"> <table class="table  table-hover">
    <thead>
        <tr>
            <th>Kota Asal</th>
            <th class="text-right">Jumlah</th>
        </tr>
    </thead>
    <tbody>';

        foreach($asal_mhs as $k){
            $no++;
            echo "<tr>";
            echo "<td>$k[nama]</td>";
            echo "<td>$k[jml]</td>";
            echo "</tr>";
            if($no == round(count($asal_mhs) / 2)){
                echo '</tbody></table></div>';
                echo '<div class="col-sm-6"> <table class="table  table-hover">
                    <thead>
                        <tr>
                            <th>Kota Asal</th>
                            <th class="text-right">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>';
            }
        }

    echo '</tbody></table></div>';
}

function masa_studi($nim,$conn){
    $fil = "NIM = '".$nim."'";
    $mhs = select_where("tabel_mhs",$fil,$conn);
    $alumni = select_where("tabel_alumni",$fil,$conn);
    $angkatan = $mhs[0]['ANGKATAN'];
    $yudisium = $alumni[0]['Tahun_Yudisium'];
    $tahun_lulus = explode("-",$yudisium);
    $tahun = $tahun_lulus[0] - $angkatan;

    $hasil = $tahun ." tahun";
    return $hasil;
}

function tabel_alumni($conn){
    $fil = "NIM !='' GROUP BY NIM";
    $data = select_where("tabel_alumni",$fil,$conn);
    if(!is_array($data)){ return;}
    foreach($data as $d){
        $ipk = get_nilai_mhs($d['NIM'],$conn);
        echo "<tr>";
        echo "<td>$d[NIM]</td>";
        echo "<td>$d[Nama]</td>";
        echo "<td>$d[PIN_Ijazah]</td>";
        if($d['Tahun_Yudisium'] != 0){echo "<td>$d[Tahun_Yudisium]</td>";}else{ echo "<td></td>"; }
        if($d['Tahun_Wisuda'] != 0){echo "<td>$d[Tahun_Wisuda]</td>";}else{ echo "<td></td>"; }
        if($d['Lama_Studi'] != 0){echo "<td> ".$d['Lama_Studi']." tahun</td>";}else{ echo "<td></td>"; }

        echo "<td>".round($ipk['IPK'],2)."</td>";
        echo "<td>$d[Nilai_Toefl]</td>";
        echo "<td>$d[Status_Pekerjaan]</td>";
        echo "</tr>";
    }
}
function tabel_honor($conn){
    $fil = "tabel_skripsi.NIM = tabel_mhs.NIM AND tabel_mhs.STATUS_MAHASISWA != 'Mengundurkan Diri' GROUP BY tabel_mhs.NIM";
    $data = select_where("tabel_skripsi,tabel_mhs",$fil,$conn);

    foreach($data as $d){
        $sts = $d['STATUS_MAHASISWA'];
        echo "<tr>";
        echo "<td>$d[NIM]</td>";
        echo "<td>$d[NAMA]</td>";
        echo "<td><span class='sts_mhs $sts'>$sts<span></td>";
        echo "<td>$d[JUDUL_SKRIPSI]</td>";
        echo "<td>".sts_honor($d['NIM'],"pem",$conn)."</td>";
        echo "<td>".sts_honor($d['NIM'],"peng",$conn)."</td>";
        echo "</tr>";
    }
}

function tabel_barang($conn){
    $fil = "Jumlah !='0' OR Jumlah != ''";
    $data = select_where("tabel_inventaris",$fil,$conn);
if(!is_array($data)){return;}
    foreach($data as $d){
        echo "<tr>";
        echo "<td>$d[Kode]</td>";
        echo "<td>$d[Nama_Barang]</td>";
        echo "<td>$d[Tipe_Merk]</td>";
        echo "<td>$d[Jumlah]</td>";
        echo "<td>$d[Tempat]</td>";
        echo "<td>$d[Kondisi]</td>";
        echo "<td><button class='btn btn-default' title='edit'><i class='fa fa-pen-square'></i></button></td>";
        echo "</tr>";
    }
}

function rekap_barang($conn){
    $data = select_all("tabel_inventaris",$conn);
if(!is_array($data)){return;}
    foreach($data as $d){
       
        $tempat = $d['Tempat'];
        $kondisi = $d['Kondisi'];
        // $rekap[$tempat]["Tempat"] = $d['Tempat'];
        if(isset($rekap[$tempat][$kondisi])){
            $rekap[$tempat][$kondisi] += $d['Jumlah'];
        }else{
            $rekap[$tempat][$kondisi] = $d['Jumlah'];
        }
    }
    if(!isset($rekap)) return; 
    foreach($rekap as $y=>$r){
        $jml = 0;
        echo "<h4 class='font-weight-light'>$y</h4>";
        echo "<table class='table'>";
        echo "<tr>";
        echo "<th>Kondisi</th>";
        echo "<th>Jumlah</th>";
        echo "</tr>";
        foreach($r as $i=>$v){
            $jml += $v;
            echo "<tr>";
            echo "<td>$i</td>";
            echo "<td>$v</td>";
            echo "</tr>";
        }
        echo "<tr>";
        echo "<td>total</td>";
        echo "<td>$jml</td>";
        echo "</tr>";
        echo "</table><br>";
    }
}

function data_grafik($datas){
$x = 0;
	foreach($datas as $title=>$data){		
		$a['title'] = $title;
		$a['label'] = array();
		$a['dataset'] = array();
		foreach($data as $i=>$v){
		array_push($a['label'],$i);
		array_push($a['dataset'],$v);
		}

	$out[$x] = $a;
	$x++;
	}
return $out;
}

?>