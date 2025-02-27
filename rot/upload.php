<?php
// fungsi untuk upload data 
// upload data mahasiswa 
function upload_mhs($data, $conn){    
    $mak = count($data);
    $cols = "NO,NIM,NIK,NAMA,FAKULTAS,PROGRAM_STUDI,ANGKATAN,JENIS_KELAMIN,TEMPAT_LAHIR,TANGGAL_LAHIR,AGAMA,STATUS_NIKAH,NO_TELEPON,NO_HP,EMAIL,JALUR_MASUK,ALAMAT,KOTA,PROPINSI,KODE_POS,STATUS_TEMPAT_TINGGAL,PEMBIAYAAN_KULIAH,TINGGI_BADAN_CM,BERAT_BADAN_KG,GOL_DARAH,ASAL_SEKOLAH,KOTA_SEKOLAH,TOTAL_NILAI_UN,RATA_NILAI_UN,MASUK_S1,TAMAT_S1,PERGURUAN_TINGGI_S1,FAKULTAS_S1,PRODI_S1,IPK_S1,GELAR_S1,NIK_AYAH,NAMA_AYAH,NIK_IBU,NAMA_IBU,STATUS_AYAH,STATUS_IBU,TELEPON_ORTU,ALAMAT_ORTU,PEKERJAAN_AYAH,PEKERJAAN_IBU,PENGHASILAN_ORTU,JUMLAH_TANGGUNGAN_ORTU,NAMA_WALI,ALAMAT_WALI,TELEPON_WALI,NOMOR_TES,SEMESTER_MASUK,JENIS_PENDAFTARAN,STATUS_MAHASISWA,SEMESTER_KELUAR";
    $header = explode(",",$cols);
    if($data[0] == $header){        
        for($x=2;$x<$mak;$x++){
            $d = $data[$x];
            $no = $x;
            foreach($d as $i=>$v){
                $d[$i] = get_input($v);
            }
            if($d['1'] != ""){
                $whare = "NIM = '$d[1]'";
                $tabel = "tabel_mhs";
                $cek = cek($whare,$tabel,$conn);
                if($cek['result'] == "tdk_ada"){
                    $col = "NIM";
                    $value = "'$d[1]'";
                    $query = "INSERT INTO $tabel($col) VALUES($value)";
                    $result = $conn->query($query);
                    if(!$result){
                        $hasil[$no]['NO'] = $d[0];
                        $hasil [$no]['result'] = "Failed";
                        $hasil[$no]['catatan'] = $conn->error;
                    }

                    $cek = cek($whare,$tabel,$conn);
                }

                for($y = 2; $y < count($d); $y++){
                    $hsl_update = update_data($tabel,$cek['id'],$header[$y],"'$d[$y]'",$conn);
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
// upload data dosen 
function upload_dsn($data, $conn){    
    $mak = count($data);
    $cols = "NO,NIP,NIDN,GELAR_DEPAN,NAMA,GELAR_ELAKANG,JABATAN_AKADEMIK,PENDIDIKAN_TERAKHIR,GOLONGAN,STATUS,HOMEBASE,EMAIL";
    $header = explode(",",$cols);
    if($data[0] == $header){        
        for($x=2;$x<$mak;$x++){
            $d = $data[$x];
            $no = $x;
            foreach($d as $i=>$v){
                $d[$i] = get_input($v);
            }
            if($d['1'] != ""){
                $whare = "NIP ='$d[1]'";
                $tabel = "tabel_dosen";
                $cek = cek($whare,$tabel,$conn);
                if($cek['result'] == "tdk_ada"){
                    $col = "NIP";
                    $value = "'$d[1]'";
                    $query = "INSERT INTO $tabel($col) VALUES($value)";
                    $result = $conn->query($query);
                    if(!$result){
                        $hasil[$no]['NO'] = $d[0];
                        $hasil [$no]['result'] = "Failed";
                        $hasil[$no]['catatan'] = $conn->error;
                    }
                    $cek = cek($whare,$tabel,$conn);
                }

                for($y = 2; $y < count($d); $y++){
                    $hsl_update = update_data($tabel,$cek['id'],$header[$y],"'$d[$y]'",$conn);

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
// upload matakuliah
function upload_mk($data, $conn){    
    $mak = count($data);
    $header = array("NO","KELOMPOK","KODE","NAMA_MATA_KULIAH","SKS","PRASYARAT","SEMESTER","NAMA_KURIKULUM","SIFAT_MATA_KULIAH");
    if($data[0] == $header){        
        for($x=2;$x<$mak;$x++){
            $d = $data[$x];
            $no = $x;
            foreach($d as $i=>$v){
                $d[$i] = get_input($v);
            }
            if($d['2'] != ""){
                $whare = "KODE='$d[2]' AND NAMA_KURIKULUM = '$d[7]'";
                $tabel = "tabel_mk";
                $cek = cek($whare,$tabel,$conn);
                
                if($cek['result'] == "tdk_ada"){
                    $col = "KELOMPOK,KODE,NAMA_MATA_KULIAH,SKS,PRASYARAT,SEMESTER,NAMA_KURIKULUM,SIFAT_MATA_KULIAH";
                    $value = "'$d[1]','$d[2]','$d[3]','$d[4]','$d[5]','$d[6]','$d[7]','$d[8]'";
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
                    $col = "KELOMPOK,KODE,NAMA_MATA_KULIAH,SKS,PRASYARAT,SEMESTER,NAMA_KURIKULUM,SIFAT_MATA_KULIAH";
                    $value = "'$d[1]'#&#'$d[2]'#&#'$d[3]'#&#'$d[4]'#&#'$d[5]'#&#'$d[6]'#&#'$d[7]'#&#'$d[8]'";
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
// upload dosen PA
function upload_dsn_pa($data, $conn){    
    $mak = count($data);
    $header = array("NO","NIP_Dosen","Nama_Dosen","NIM","Nama_Mahasiswa");
    if($data[0] == $header){        
        for($x=2;$x<$mak;$x++){
            $d = $data[$x];
            $no = $x;
            foreach($d as $i=>$v){
                $d[$i] = get_input($v);
            }
            if($d['3'] != ""){
                $whare = "NIM ='$d[3]'";
                $tabel = "tabel_pa";
                $cek = cek($whare,$tabel,$conn);
                if($cek['result'] == "tdk_ada"){
                    $col = "NIP_Dosen,Nama_Dosen,NIM,Nama_Mahasiswa";
                    $value = "'$d[1]','$d[2]','$d[3]','$d[4]'";
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
                    $col = "NIP_Dosen,Nama_Dosen,NIM,Nama_Mahasiswa";
                    $value = "'$d[1]'#&#'$d[2]'#&#'$d[3]'#&#'$d[4]'";
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
// upload transkrip 
function upload_ipk($data, $conn){    
    $mak = count($data);
    $text = "NO,PERIODE,NIM,NAMA,ANGKATAN,IPK,BOBOT,JUMLAH_SKS,SKS_LULUS,SKS_TIDAK_LULUS,SKS_MK_WAJIB_L,SKS_PILIHAN_L,STATUS_MAHASISWA,IP_SEMESTER,SKS_SEMESTER,SKS_TOTAL,Terakhir_Update";
    $header = explode(",",$text);
    if($data[0] == $header){        
        for($x=2;$x<$mak;$x++){
            $d = $data[$x];
            $no = $x;
            foreach($d as $i=>$v){
                $d[$i] = get_input($v);
            }
            if($d['1'] != ""){
                $whare = "PERIODE ='$d[1]' AND NIM = '$d[2]'";
                $tabel = "tabel_nilai_ipk";
                $cek = cek($whare,$tabel,$conn);
                if($cek['result'] == "tdk_ada"){
                    $col = "PERIODE,NIM";
                    $value = "'$d[1]','$d[2]'";
                    $query = "INSERT INTO $tabel($col) VALUES($value)";
                    $result = $conn->query($query);
                    $cek = cek($whare,$tabel,$conn);
                    if(!$result){
                        $hasil[$no]['NO'] = $d[0];
                        $hasil [$no]['result'] = "Failed";
                        $hasil[$no]['catatan'] = $conn->error;
                    }
                }else{
                    for($y = 2; $y < count($d); $y++){
                        $hsl_update = update_data($tabel,$cek['id'],$header[$y],"'$d[$y]'",$conn);
                        $hasil[$no]['NO'] = $d[0];
                        $hasil [$no]['result'] = "Succes";
                        $hasil[$no]['catatan'] = "Data sudah Ada: $hsl_update";
                    }
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
// upload kehadiran 
function upload_kehadiran($data, $conn){    
    $mak = count($data);
    $text = "NO,PERIODE,NIM,NAMA_MAHASISWA,KODE_MATA_KULIAH,NAMA_MATA_KULIAH,NAMA_KELAS,DOSEN_PENGAMPU,JUMLAH_PERTEMUAN,HADIR,TANPA_KETERANGAN,IZIN,SAKIT";
    $header = explode(",",$text);
    if($data[0] === $header){        
        for($x=2;$x<$mak;$x++){
            $d = $data[$x];
            $no = $x;
            foreach($d as $i=>$v){
                $d[$i] = get_input($v);
            }
            if($d['1'] != "" && $d['2'] != "" && $d['4'] != ""){
                $whare = "NIM = '$d[2]' AND PERIODE='$d[1]' AND KODE_MATA_KULIAH = '$d[4]'";
                $tabel = "tabel_kehadiran";
                $cek = cek($whare,$tabel,$conn);
                if($cek['result'] == "tdk_ada"){
                    $col = "PERIODE,NIM,NAMA_MAHASISWA,KODE_MATA_KULIAH,NAMA_MATA_KULIAH,NAMA_KELAS,DOSEN_PENGAMPU,JUMLAH_PERTEMUAN,HADIR,TANPA_KETERANGAN,IZIN,SAKIT";
                    $value = "'$d[1]','$d[2]','$d[3]','$d[4]','$d[5]','$d[6]','$d[7]','$d[8]','$d[9]','$d[10]','$d[11]','$d[12]'";
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
                    $col = "PERIODE,NIM,NAMA_MAHASISWA,KODE_MATA_KULIAH,NAMA_MATA_KULIAH,NAMA_KELAS,DOSEN_PENGAMPU,JUMLAH_PERTEMUAN,HADIR,TANPA_KETERANGAN,IZIN,SAKIT";
                    $value = "'$d[1]'#&#'$d[2]'#&#'$d[3]'#&#'$d[4]'#&#'$d[5]'#&#'$d[6]'#&#'$d[7]'#&#'$d[8]'#&#'$d[9]'#&#'$d[10]'#&#'$d[11]'#&#'$d[12]'";
                    $hsl_update = update_data($tabel,$cek['id'],$col,$value,$conn);
                    $hasil[$no]['NO'] = $d[0];
                    $hasil [$no]['result'] = "Succes";
                    $hasil[$no]['catatan'] = "Data sudah Ada: $hsl_update";
                }
            }
        }
    }else{
        $new_array = array_diff($data[0],$header);
        $hasil[0]['NO'] = "";
        $hasil [0]['result'] = "Failed";
        $hasil[0]['catatan'] = "Gunakan template yang ada ". implode($new_array);
    }
    return  $hasil;
}
// upload nilai matakuliah persemester
function upload_nilai_mk($data, $conn){    
    $mak = count($data);
    $header = array("NO","NIM","NILAI_ANGKA","NILAI_HURUF","NILAI_INDEKS","NAMA_KURIKULUM","PERIODE","NAMA_KELAS","KODE_MATA_KULIAH","NAMA_MATA_KULIAH","SKS_MATA_KULIAH","JENIS_MATA_KULIAH");
    if($data[0] == $header){        
        for($x=2;$x<$mak;$x++){
            $d = $data[$x];
            $no = $x;
            foreach($d as $i=>$v){
                $d[$i] = get_input($v);
            }
            if($d['1'] != ""){
                $whare = "NIM ='$d[1]' AND PERIODE = '$d[6]' AND KODE_MATA_KULIAH='$d[8]'";
                $tabel = "tabel_nilai_mk";
                $cek = cek($whare,$tabel,$conn);
                if($cek['result'] == "tdk_ada"){
                    $col = "NIM,NILAI_ANGKA,NILAI_HURUF,NILAI_INDEKS,NAMA_KURIKULUM,PERIODE,NAMA_KELAS,KODE_MATA_KULIAH,NAMA_MATA_KULIAH,SKS_MATA_KULIAH,JENIS_MATA_KULIAH";
                    $value = "'$d[1]','$d[2]','$d[3]','$d[4]','$d[5]','$d[6]','$d[7]','$d[8]','$d[9]','$d[10]','$d[11]'";
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
                    $col = "NIM,NILAI_ANGKA,NILAI_HURUF,NILAI_INDEKS,NAMA_KURIKULUM,PERIODE,NAMA_KELAS,KODE_MATA_KULIAH,NAMA_MATA_KULIAH,SKS_MATA_KULIAH,JENIS_MATA_KULIAH";
                    $value = "'$d[1]'#&#'$d[2]'#&#'$d[3]'#&#'$d[4]'#&#'$d[5]'#&#'$d[6]'#&#'$d[7]'#&#'$d[8]'#&#'$d[9]'#&#'$d[10]'#&#'$d[11]'";
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
?>