<?php

   if (empty($_SESSION['type']) || $_SESSION['type'] != 2) {
      header('location:./');
   }

   //cek $_REQUEST['add'] apakah diset
   if (isset($_REQUEST['add'])) {
      //cek apakah form materi / kelas mempunyai value
      if ($_FILES['materi'] == '' || $_REQUEST['kelas'] == '' || $_REQUEST['mapel'] == '') {
         echo '<script type="text/javascript">alert("Semua form tidak boleh kosong !");</script>';
      } else {
         $materi  = $_FILES['materi'];
         $kelas   = $_REQUEST['kelas'];
         $mapel   = $_REQUEST['mapel'];

         //cek extensi file
         if ($materi['type'] != 'application/pdf'){
            //pisah nama berdasarkan .
            $type    = explode('.' , $materi['name']);
            //dapatkan tipe file dengan menghitung array
            $explode = $type[count($type)-1];
         } else {
            $explode = $materi['type'];
         }
         //daftar extensi yang diperbolehkan
         $ext  = array('doc','docx','application/pdf','ppt','pptx', 'xls', 'xlsx');

         //validasi extensi
         if (!in_array(($explode),$ext)) {
            echo '<script type="text/javascript">alert("Format file tidak diperbolehkan !!!")</script>';
         } else {
            $extractFile = pathinfo($materi['name']);
            $dir         = "../assets/materi/";

            $sameName    = 0;
            $handle      = opendir($dir);
            //looping isi directory tujuan
            while (false != ($files = readdir($handle))) {
               //apabila ditemukan nama file yang sama
               if (strpos($files,$extractFile['filename']) != false) {
                  $sameName++; //tambah nilai variabel $sameName
               }
            }
            /*apabila tidak ditemukan nama file yang sama maka nama file asli dipakai,
            jika ditemukan nama file yang sama maka nama file menggunakan format namafile($sameName)*/
            $newName = empty($sameName) ? $materi['name'] : $extractFile['filename'].'('.$sameName.').'.$extractFile['extension'];

            //pindahkan file yang di upload ke directory tujuan bila berhasil jalankan perintah query untuk mennyimpan ke database
            if (move_uploaded_file($materi['tmp_name'],$dir.$newName)) {
               $sql = "INSERT INTO t_materi(judul_mat, id_kelas, id_guru, id_mapel) VALUES('$newName', '$kelas', '$_SESSION[id]', '$mapel')";
               mysqli_query($mysqli, $sql);
               header('location: ?page=materi');
            }
         }
      }
   }
?>

   <h4>Tambah Materi</h4>
   <br />

   <div class="row"> <!-- start row -->

      <form action="" method="post" enctype="multipart/form-data" class="col s12 m10 l10 offset-l1">

         <div class="file-field input-field col s8"> <!-- start form upload -->
            <div class="btn blue lighten-2">
               <span>File Materi</span>
               <input type="file" name="materi">
            </div>
            <div class="file-path-wrapper">
               <input class="file-path validate" type="text">
            </div>
         </div> <!-- end form upload -->
         <small><i>* File barus berformat *.doc / *.docx / *.pdf / *.ppt / *.pptx / *.xls / *.xlsx</i></small>
         <div class="col s7"> <!-- start col select kelas -->
            <i class="fa fa-list"></i>
            <label>Kelas :</label>
            <select class="browser-default" name="kelas" required>
               <option value="" disabled selected>--Pilih Kelas--</option>
               <?php
               $sql  = mysqli_query($mysqli, "SELECT * FROM t_index_mapel JOIN t_kelas ON t_index_mapel.id_kelas = t_kelas.id_kelas WHERE t_index_mapel.id_guru = '$_SESSION[id]'");

               while ($key = mysqli_fetch_array($sql)) {
                  echo '<option value="'.$key['id_kelas'].'">'.$key['nama_kelas'].'</option>';
               }
               ?>
            </select>
         </div> <!-- end col select kelas -->
         <div class="col s7"> <!-- start col select Mapel -->
            <p>&nbsp;</p>
         </div> <!-- end col select Mapel -->
         <div class="col s7"> <!-- start col select Mapel -->
            <i class="fa fa-list"></i>
            <label>Mapel :</label>
            <select class="browser-default" name="mapel" required>
               <option value="" disabled selected>--Pilih Mapel--</option>
               <?php
               $data  = mysqli_query($mysqli, "SELECT * FROM t_index_mapel JOIN t_mapel ON t_index_mapel.id_mapel = t_mapel.id_mapel WHERE t_index_mapel.id_guru = '$_SESSION[id]'");

               while ($mapel = mysqli_fetch_array($data)) {
                  echo '<option value="'.$mapel['id_mapel'].'">'.$mapel['nama_mapel'].'</option>';
               }
               ?>
            </select>
         </div> <!-- end col select Mapel -->
         <div class="row"> <!-- start row button -->
            <div class="input-field col s6 right">
               <button class="btn waves-effect waves-light green lighten-1" type="submit" name="add">
                  Upload <i class="fa fa-upload right"></i>
               </button>
               <a href="?page=materi" class="btn waves-effect waves-light red">
                  Batal <i class="fa fa-times right"></i>
               </a>
            </div>
         </div> <!-- end row button -->

      </form>

   </div> <!-- end row -->
