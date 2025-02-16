<?php
// kumpulan fungsi untuk mengambil data dari database

// tabel mahasiswa tabel_mhs
function tabel_mahasiswa($filter,$conn){
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
        echo "<td>".$mhs['NIM']."</td>";
        echo "<td>".get_output($mhs['NAMA'])."</td>";
        echo "<td>".get_pa($mhs['NIM'],$conn)."</td>";
        echo "<td>".$mhs['STATUS_MAHASISWA']."</td>";
        echo "<td><a href='https://wa.me/62$telp?text=Assalamualaikum' target='_blank'>$mhs[NO_TELEPON]</a> / <a target='_blank' href='https://wa.me/62$hp?text=Assalamualaikum'>$mhs[NO_HP]</a> <a class='float-right' href='?p=mhs&&i=edit&&id=".$mhs['NIM']."'>detail</a></td>";
        echo "</tr>";
    }
}
// tabel dosen 
function tabel_dosen($homebase,$conn){
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
            echo "<tr>";
            echo "<td>".$no."</td>";
            echo "<td>".$dosen['NAMA']."</td>";
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
    $data_kurikulum = select_all("tabel_kurikulum",$conn);
    $no = 0;
    foreach($data_kurikulum AS $kur){
        $link = "?p=kurikulum&&i=edit&&name=".$kur['NAMA'];
        $no++;
        // test($data_mahasiswa);
        echo "<tr>";
        echo "<td>".$no."</td>";
        echo "<td>".$kur['ID_KURIKULUM']."</td>";
        echo "<td>".$kur['NAMA']."</td>";
        echo "<td><a class='btn btn-secondary' href='$link'>Daftar Matakuliah</a></td>";
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
        echo "<td>".$no."</td>";
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
            echo "<td>".$mhs['NAMA']."<span class='sts_mhs $mhs[STATUS_MAHASISWA]'>[$mhs[STATUS_MAHASISWA]]</span></td>";
            echo "<td>".$data_transkrip[0]['SKS_MK_WAJIB_L']."</td>";
            echo "<td>".$data_transkrip[0]['SKS_PILIHAN_L']."</td>";
		if($data_transkrip[0]['SKS_PILIHAN_L'] < 10 ){
                        $sks_total = $data_transkrip[0]['SKS_MK_WAJIB_L'] + 10;
                }else{
                    $sks_total = $data_transkrip[0]['SKS_MK_WAJIB_L'] + $data_transkrip[0]['SKS_PILIHAN_L'];
                } 
            if(count($data_transkrip) > 1){               
        
                if($data_transkrip[0]['IPK'] != 0){
                    $ipk = number_format((float)$data_transkrip[0]['IPK'],2);
                }else{
                    $ipk = number_format((float)$data_transkrip[1]['IPK'],2);
                }
            }else{
                // $sks_total = $data_transkrip[0]['SKS_TOTAL'];
                $ipk = $data_transkrip[0]['IPK'];
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
            $no++;
            $nilai_mk = nilai_mk($nim,$mk['KODE'],$mk['NAMA_KURIKULUM'],$conn);
            echo "<tr>";
            echo "<td>".$no."</td>";
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
function tabel_peserta_skripsi($conn){
    $fil = "STATUS_MAHASISWA='Aktif' OR STATUS_MAHASISWA='Lulus'";
    $data_mahasiswa = select_where("tabel_mhs",$fil,$conn);
    $no = 0;
    if(!is_array($data_mahasiswa)) {return;}
    foreach($data_mahasiswa as $mhs){        
        $fil_2= "NIM = '".$mhs['NIM']."'";
        $data_skripsi = select_where("tabel_skripsi",$fil_2,$conn);
        if(is_array($data_skripsi) && $data_skripsi[0]['JUDUL_SKRIPSI'] != ""){
        $no++;
        echo "<tr>";
        echo "<td>".$no."</td>";
        echo "<td>".$data_skripsi[0]['NIM']."</td>";
        echo "<td>".$data_skripsi[0]['NAMA']."<span class='sts_mhs $mhs[STATUS_MAHASISWA]'>[".$mhs['STATUS_MAHASISWA']."]</span></td>";
        echo "<td>".$data_skripsi[0]['PEMBIMBING_1']."</td>";
        echo "<td>".$data_skripsi[0]['PEMBIMBING_2']."</td>";
        echo "<td class='upper'>".$data_skripsi[0]['JUDUL_SKRIPSI']."</td>";
        echo "<td><a class='float-right' href='?p=peserta_skripsi&&i=edit&&id=".$data_skripsi[0]['NIM']."'><i class='fas fa-eye'></i></a></td>";
        echo "</tr>";
        }
    }
}
// tabel pembimbing skripsi 
function tabel_pembimbing_skripsi($conn){
    $data_dosen = get_pembimbing_skripsi($conn);   
    $no = 0;
    foreach($data_dosen as $dosen){
        
        $data_bimbingan = read_data_bimbingan($dosen,$conn);
        
        $jml = array_sum($data_bimbingan);
        // test($data_bimbingan);
        // echo count($data_bimbingan);
        if($jml != 0){
            $no++;
            echo "<tr>";
            echo "<td>".$no."</td>";
            echo "<td><a href='?p=pembimbing&&i=edit&&id=$dosen'>".$dosen."</a></td>";
            echo "<td>".$data_bimbingan['PEMB_1']."</td>";
            echo "<td>".$data_bimbingan['PEMB_2']."</td>";
            echo "<td>".$data_bimbingan['PENG_1']."</td>";
            echo "<td>".$data_bimbingan['PENG_2']."</td>";
            echo "<td>".$jml."</td>";
            echo "</tr>";
        }
    }
}
?>