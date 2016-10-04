<?php

   if ($_SESSION['type'] != 2 || empty($_REQUEST['id_soal']) || empty($_SESSION['type'])) {
      header('location:./');
   }

   //cek apakah $_REQUEST['update'] telah diset
   if (isset($_REQUEST['update'])) {
      $foto   = $_FILES['gmb'];
      $a      = addslashes($_REQUEST['a']);
      $b      = addslashes($_REQUEST['b']);
      $c      = addslashes($_REQUEST['c']);
      $d      = addslashes($_REQUEST['d']);
      $kunci  = $_REQUEST['jwb'];
      $soal   = addslashes($_REQUEST['text']);
      //cek apakah semua form diisi
      if ($soal == '' || $a == '' || $b == '' || $c == '' || $d == '') {
         echo '<script type="text/javascript">alert("Semua Form Harus diisi!");</script>';
      } else {
         //daftar extensi yang diperbolehkan
         $ext  = array('image/jpg','image/jpeg','image/pjpeg','image/png','image/x-png');
         $tipe = $_FILES['gmb']['type']; //dapatkan extensi file yang diupload

         if (is_uploaded_file($foto['tmp_name'])) { //cek apakah ada file yang di upload
            if ($foto == '' && $_REQUEST['nama'] != 'default.png' || $foto != null && $_REQUEST['nama'] !== 'default.png') {
               unlink("../assets/img/soal/".$_REQUEST['nama']);
            }

            if (!in_array(($tipe),$ext)){ //cek extensi file
               echo '<script type="text/javascript">alert("Format gambar tidak diperbolehkan!");</script>';
            } else {
               $extractFile = pathinfo($foto['name']);
               $dir         = "../assets/img/soal/";
               $sameName    = 0;
               $handle      = opendir($dir);
               //looping isi directory tujuan
               while(false != ($file = readdir($handle))){
                  //apabila ditemukan nama file yang sama
                  if(strpos($file,$extractFile['filename']) != false) {
                     $sameName++; //tambah nilai variabel $sameName
                  }
               }
               /*bila tidak ditemukan nama file yang sama maka nama file asli dipakai,
               jika ditemukan nama file yang sama maka nama file memakai format namafile($sameName) */
               $newName = empty($sameName) ? $foto['name'] : $extractFile['filename'].'('.$sameName.').'.$extractFile['extension'];

               //pindah file yang di upload ke directory tujuan
               if (move_uploaded_file($foto['tmp_name'],$dir.$newName)) {
                  //jika berhasil lakukan update data
                  $sql   = "UPDATE t_soal SET soal = '$soal', gambar = '$newName', pil_a = '$a', pil_b = '$b', pil_c = '$c', pil_d = '$d', kunci = '$kunci' WHERE id_soal = '$_REQUEST[id_soal]'";
                  mysqli_query($mysqli, $sql);
                  header('location:?page=test&aksi=tambah_soal&id='.$_REQUEST['id_head']);
               }
            }
         } else {
            $sql   = "UPDATE t_soal SET soal = '$soal', pil_a = '$a', pil_b = '$b', pil_c = '$c', pil_d = '$d', kunci = '$kunci' WHERE id_soal = '$_REQUEST[id_soal]'";
            mysqli_query($mysqli, $sql);
            header('location:?page=test&aksi=tambah_soal&id='.$_REQUEST['id_head']);
         }
      }
   }

   $data = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM t_soal WHERE id_soal = '$_REQUEST[id_soal]'"));
?>

   <div class="row"> <!-- start row -->

      <form action="" method="post" enctype="multipart/form-data" class="col s12 m10 l10 offset-l1">

         <input type="hidden" name="id_head" value="<?php echo $_REQUEST['id']; ?>" />
         <input type="hidden" name="id_soal" value="<?php echo $data['id_soal']; ?>" />
         <input type="hidden" name="nama" value="<?php echo $data['gambar']; ?>" />

         <div class="row jarak"> <!-- start row soal -->
            <div class="input-field col s12">
               <textarea id="textarea1" class="materialize-textarea" name="text">
                  <?php echo $data['soal']; ?>
               </textarea>
               <label for="textarea1">Soal</label>
            </div>
         </div> <!-- end row soal -->

         <div class="row jarak"> <!-- start row upload -->
            <?php
            if($data['gambar'] != ''){
               echo '<div class="col s3">';
               echo '<img src="../assets/img/soal/'.$data['gambar'].'" width="150" height="150">';
               echo '</div>';
            }
            ?>
            <div class="file-field input-field col s8">
               <div class="btn blue lighten-2">
                  <span>Tambah Gambar</span>
                  <input type="file" name="gmb">
               </div>
               <div class="file-path-wrapper">
                  <input class="file-path validate" type="text">
               </div>
            </div>
         </div> <!-- end row upload -->

         <div class="row"> <!-- start row jawaban A dan B -->
            <div class="input-field col s6">
               <input id="A" type="text" class="validate" name="a" value="<?php echo $data['pil_a']; ?>">
               <label for="A">Opsi A</label>
            </div>
            <div class="input-field col s6">
               <input id="B" type="text" class="validate" name="b" value="<?php echo $data['pil_b']; ?>">
               <label for="B">Opsi B</label>
            </div>
         </div> <!-- end row jawaban A dan B -->
         <div class="row"> <!-- start row jawaban C dan D -->
            <div class="input-field col s6">
               <input id="C" type="text" class="validate" name="c" value="<?php echo $data['pil_c']; ?>">
               <label for="C">Opsi C</label>
            </div>
            <div class="input-field col s6">
               <input id="D" type="text" class="validate" name="d" value="<?php echo $data['pil_d']; ?>">
               <label for="D">Opsi D</label>
            </div>
         </div> <!-- end row jawaban C dan D -->
         <div class="row"> <!--start row kunci jawaban -->
            <p>Kunci Jawaban</p>
            <div class="input-field col s7">
               <input class="with-gap" name="jwb" type="radio" id="test1" value="A" <?php if($data[ 'kunci']=='A' ){ echo "checked";} ?> />
               <label for="test1">A</label>
               <input class="with-gap" name="jwb" type="radio" id="test2" value="B" <?php if($data[ 'kunci']=='B' ){ echo "checked";} ?>/>
               <label for="test2">B</label>
               <input class="with-gap" name="jwb" type="radio" id="test3" value="C" <?php if($data[ 'kunci']=='C' ){ echo "checked";} ?>/>
               <label for="test3">C</label>
               <input class="with-gap" name="jwb" type="radio" id="test4" value="D" <?php if($data[ 'kunci']=='D' ){ echo "checked";} ?>/>
               <label for="test4">D</label>
            </div>
         </div> <!-- end row kunci jawaban -->
         <div class="row"> <!-- start row button -->
            <div class="input-field col s6 right">
               <button class="btn waves-effect waves-light green lighten-1" type="submit" name="update">
                  Update <i class="fa fa-send right"></i>
               </button>
               <a href="?page=test&aksi=tambah_soal&id=<?php echo $_REQUEST['id']; ?>" class="btn waves-effect waves-light red">
                  Batal <i class="fa fa-times right"></i>
               </a>
            </div>
         </div> <!-- end row button -->

      </form>

   </div> <!-- end row -->
