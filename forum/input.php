<?php

   if(empty($_SESSION['type'])) {
      header("location:./");
   }

   //cek $_REQUEST['kirim']
   if (isset($_REQUEST['kirim'])){
      //cek apakah semua form terisi
      if ($_REQUEST['judul'] == '' || $_REQUEST['isi'] == '' || $_REQUEST['daftar'] == ''){
         echo '<script type="text/javascript">alert("Judul Topik / isi / mapel tidak boleh kosong !");</script>';
      } else {
         $judul  = addslashes($_REQUEST['judul']);
         $isi    = $_REQUEST['isi'];
         $foto   = $_FILES['foto'];
         $mapel  = $_REQUEST['daftar'];
         $tgl    = date('Y-m-d');

         //daftar ekstensi yang diperbolehkan
         $ext    = array('image/jpg','image/jpeg','image/pjpeg','image/png','image/x-png');
         $tipe   = $_FILES['foto']['type']; //dapatkan ekstensi file yang diupload

         if (is_uploaded_file($foto['tmp_name'])){ //cek apakah ada file yang diupload
            if (!in_array(($tipe),$ext)){ //cek validasi ekstensi
               echo '<script type="text/javascript">alert("Format foto tidak diperbolehkan!")</script>';
            } else {
               $extractFile = pathinfo($foto['name']);
               $dir         = "../assets/img/";
               $sameName    = 0;
               $handle      = opendir($dir);
               //looping isi directory tujuan
               while(false != ($files = readdir($handle))){
                  //apabila ditemukan nama file yang sama
                  if(strpos($files,$extractFile['filename']) != false) {
                     $sameName++; //tambah nilai variabel $sameName
                  }
               }
               /*apabila tidak ditemukan nama file yang sama maka nama file asli dipakai,
               jika ditemukan nama file yang sama maka nama file menggunakan format namafile($sameName)*/
               $newName = empty($sameName) ? $foto['name'] : $extractFile['filename'].'('.$sameName.').'.$extractFile['extension'];

               if(move_uploaded_file($foto['tmp_name'],$dir.$newName)){
                  $sql   = "INSERT INTO t_forum VALUES ('', '$judul', '$isi', '$tgl', '$newName', '$mapel', '$_SESSION[id]', '')";

                  mysqli_query($mysqli, $sql);
                  header('location:./');
               }
            }
         } else { //else is_uploaded_file
            $sql   = "INSERT INTO t_forum VALUES ('', '$judul', '$isi', '$tgl', '', '$mapel', '$_SESSION[id]', '')";

            mysqli_query($mysqli, $sql);
            header('location:./');
         } //end is_uploaded_file
      } //end cek form
   } //end $_REQUEST['kirim']
?>

   <form action="" method="post" enctype="multipart/form-data">

      <div class="row"> <!-- start row -->

         <div class="input-field col s10 push-s1">
            <input id="judul" name="judul" type="text" class="validate" required />
            <label for="judul" data-error="wrong" data-success="right">Judul Topik</label>
         </div>
         <div class="input-field col s10 push-s1">
            <textarea class="ckeditor" name="isi" required></textarea>
         </div>
         <br />
         <div class="file-field input-field col s10 push-s1">
            <div class="btn blue lighten-2">
               <span>Foto Topik</span>
               <input type="file" name="foto">
            </div>
            <div class="file-path-wrapper">
               <input class="file-path validate" type="text">
            </div>
         </div>
         <div class="col s10 push-s1">
            <div class="row">
               <div class="col s5">
                  <label>Daftar Mapel</label>
                  <select class="browser-default" name="daftar" required>
                     <option value="" selected="selected">Pilih Mapel</option>
                     <?php
                     if($_SESSION['type'] == 3){
                        $data  = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM t_siswa WHERE nis = '$_SESSION[id]'"));

                        $pilih = mysqli_query($mysqli, "SELECT * FROM t_index_mapel JOIN t_mapel ON t_index_mapel.id_mapel = t_mapel.id_mapel WHERE id_kelas = '$data[id_kelas]'");
                     } elseif($_SESSION['type'] == 2) {
                        $pilih = mysqli_query($mysqli, "SELECT * FROM t_index_mapel JOIN t_mapel ON t_index_mapel.id_mapel = t_mapel.id_mapel WHERE id_guru = '$_SESSION[id]'");
                     } else {
                        $pilih = mysqli_query($mysqli, "SELECT * FROM t_index_mapel JOIN t_mapel ON t_index_mapel.id_mapel = t_mapel.id_mapel");
                     }

                     while ($key = mysqli_fetch_array($pilih)) { //start looping
                        echo '<option value="'.$key['id_index'].'" >'.$key['nama_mapel'].'</option>';
                     } //end looping
                     ?>
                  </select>
               </div>
               <div class="input-field col s6 push-s3">
                  <button type="submit" name="kirim" class="btn waves-effect waves-light green lighten-1">
                     Post <i class="fa fa-send right"></i>
                  </button>
                  <a href="./" class="btn waves-effect waves-light red lighten-1">
                     Kembali <i class="fa fa-arrow-left"></i>
                  </a>
               </div>
            </div>
         </div>
      </div> <!-- end row -->

   </form>
