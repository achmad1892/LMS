<?php

   if ($_SESSION['type'] != 2 || empty($_SESSION['type'])) {
      header('location:./');
   }

   //cek apakah $_REQUEST['add'] telah diset
   if (isset($_REQUEST['add'])) {
      $foto   = $_FILES['gmb'];
      $a      = addslashes($_REQUEST['a']);
      $b      = addslashes($_REQUEST['b']);
      $c      = addslashes($_REQUEST['c']);
      $d      = addslashes($_REQUEST['d']);
      $header = $_REQUEST['id'];
      $soal   = addslashes($_REQUEST['text1']);
      $kunci  = $_REQUEST['jwb'];

      //cek apakah semua fm diisi
      if ($soal == '' || $a == '' || $b == '' || $c == '' || $d == '' || $kunci == '') {
         echo '<script type="text/javascript">alert("Semua Form Harus diisi!");</script>';
      } else {
         //daftar extensi gambar yang diperbolehkan
         $ext  = array('image/jpg','image/jpeg','image/pjpeg','image/png','image/x-png');
         //dapatkan extensi file yang diupload
         $tipe = $_FILES['gmb']['type'];

         if (is_uploaded_file($foto['tmp_name'])) { //cek apakah ada file yang di upload
            if (!in_array(($tipe),$ext)){ //cek ekstensi file
               echo '<script type="text/javascript">alert("Format gambar tidak diperbolehkan!");</script>';
            } else {
               $extractFile = pathinfo($foto['name']);
               $dir         = "../assets/img/soal/";
               $sameName    = 0;
               $handle      = opendir($dir);
               //looping isi directory tujuan
               while(false != ($files = readdir($handle))){
                  //apabila ditemukan nama file yang sama
                  if (strpos($files,$extractFile['filename']) !== false) {
                     $sameName++; //tambah nilai variabel $sameName
                  }
               }
               /*apabila tidak ditemukan nama file yang sama maka nama file asli dipakai,
               jika ditemukan nama file yang sama maka nama file menggunakan format namafile($sameName)*/
               $newName = empty($sameName) ? $foto['name'] : $extractFile['filename'].'('.$sameName.').'.$extractFile['extension'];

               //pindahkan file yang di upload ke directory tujuan bila berhasil jalankan perintah query untuk mennyimpan ke database
               if (move_uploaded_file($foto['tmp_name'],$dir.$newName)) {
                  $sql = "INSERT INTO t_soal VALUES ('', '$header', '$soal', '$newName', '$a', '$b', '$c', '$d', '$kunci')";
                  mysqli_query($mysqli, $sql);
                  header('location:?page=test&aksi=tambah_soal&id='.$_REQUEST['id']);
               }
            }
         } else {
            $sql = "INSERT INTO t_soal VALUES ('', '$header', '$soal', '', '$a', '$b', '$c', '$d', '$kunci')";

            mysqli_query($mysqli, $sql);
            header('location:?page=test&aksi=tambah_soal&id='.$_REQUEST['id']);
         }
      }
   } //end if isset
?>
   <h5>Tambah Soal</h5>
   <div class="row"> <!-- start row -->

      <form action="" method="post" enctype="multipart/form-data" class="col s12 m10 l10 offset-l1">

         <input type="hidden" name="id_head" value="<?php echo $_REQUEST['id']; ?>" />

         <div class="row jarak"> <!-- start row soal -->
            <div class="input-field col s12">
               <textarea id="textarea" class="materialize-textarea" name="text1"></textarea>
               <label for="textarea">Soal</label>
            </div>
         </div> <!-- end row soal -->

         <div class="row jarak"> <!-- start row form upload gambar -->
            <div class="file-field input-field col s8">
               <div class="btn blue lighten-2">
                  <span>Tambah Gambar</span>
                  <input type="file" name="gmb" />
               </div>
               <div class="file-path-wrapper">
                  <input class="file-path validate" type="text" />
               </div>
            </div>
         </div> <!-- end row upload -->

         <div class="row"> <!--start row jawaban A dan B -->
            <div class="input-field col s6">
               <input id="A" type="text" class="validate" name="a">
               <label for="A">Opsi A</label>
            </div>
            <div class="input-field col s6">
               <input id="B" type="text" class="validate" name="b">
               <label for="B">Opsi B</label>
            </div>
         </div> <!-- end jawaban A dan B -->

         <div class="row"> <!-- start row jawaban C dan D -->
            <div class="input-field col s6">
               <input id="C" type="text" class="validate" name="c">
               <label for="C">Opsi C</label>
            </div>
            <div class="input-field col s6">
               <input id="D" type="text" class="validate" name="d">
               <label for="D">Opsi D</label>
            </div>
         </div> <!-- end jawaban C dan D -->

         <div class="row"> <!-- row kunci jawaban -->
            <p>Kunci Jawaban</p>
            <div class="input-field col s7">
               <input class="with-gap" name="jwb" type="radio" id="test1" value="A" checked />
               <label for="test1">A</label>
               <input class="with-gap" name="jwb" type="radio" id="test2" value="B" />
               <label for="test2">B</label>
               <input class="with-gap" name="jwb" type="radio" id="test3" value="C" />
               <label for="test3">C</label>
               <input class="with-gap" name="jwb" type="radio" id="test4" value="D" />
               <label for="test4">D</label>
            </div>
         </div> <!-- end row kunci jawaban -->

         <div class="row"> <!-- start row button -->
            <div class="input-field col s6 right">
               <button class="btn waves-effect waves-light green lighten-1" type="submit" name="add">
                  Tambah <i class="fa fa-send right"></i>
               </button>
               <a href="?page=test&aksi=tambah_soal&id=<?php echo $_REQUEST['id']; ?>" class="btn waves-effect waves-light red">
                  Batal <i class="fa fa-times right"></i>
               </a>
            </div>
         </div> <!-- end row button -->

      </form>

   </div> <!-- end row -->
