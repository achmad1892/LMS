<?php
   //cek session
   if (empty($_SESSION['type'])) {
      header('location:./');
   }

   //cek apakah $_REQUEST['update'] telah diset
   if (isset($_REQUEST['update'])) {
      $nfoto   = $_REQUEST['nfoto'];
      $foto    = $_FILES['foto'];
      //daftar ekstensi yang diperbolehkan
      $ext  = array('image/jpg','image/jpeg','image/pjpeg','image/png','image/x-png');
      $tipe = $_FILES['foto']['type']; //dapatkan ekstensi file yang diupload
      //cek validasi ekstensi
      if(!in_array(($tipe),$ext)) {
         echo '<script type="text/javascript">alert("Format foto tidak diperbolehkan !!!")</script>';
      } else {
         if (!in_array(($tipe),$ext)){ //cek ekstensi file
            echo '<script type="text/javascript">alert("Format gambar tidak diperbolehkan!");</script>';
         } else {
            if ($foto == '' && $nfoto != 'default.png' || $foto != null && $nfoto !== 'default.png') {
               unlink("../assets/img/".$nfoto);
            }

            $extractFile = pathinfo($foto['name']);
            if ( $_SESSION['type'] != 3 ) {
               $dir = "../assets/img/";
            } else {
               $dir = "./assets/img/";
            }

            $sameName    = 0;
            $handle      = opendir($dir);
            //looping isi directory tujuan
            while(false != ($files = readdir($handle))){
               //apabila ditemukan nama file yang sama
               if(strpos($files,$extractFile['filename']) !== false) {
                  $sameName++; //tambah nilai variabel $sameName
               }
            }
            /*apabila tidak ditemukan nama file yang sama maka nama file asli dipakai,
            jika ditemukan nama file yang sama maka nama file menggunakan format namafile($sameName)*/
            $newName = empty($sameName) ? $foto['name'] : $extractFile['filename'].'('.$sameName.').'.$extractFile['extension'];

            //pindahkan file yang di upload ke directory tujuan bila berhasil jalankan perintah query untuk mennyimpan ke database
            if(move_uploaded_file($foto['tmp_name'],$dir.$newName)){
               if ($_SESSION['type'] == 1) {
                  mysqli_query($mysqli, "UPDATE t_admin SET foto = '$newName' WHERE id_admin = '$_SESSION[id]'");
               } elseif ($_SESSION['type'] == 2) {
                  mysqli_query($mysqli, "UPDATE t_guru SET foto = '$newName' WHERE id_guru = '$_SESSION[id]'");
               } else {
                  mysqli_query($mysqli, "UPDATE t_siswa SET foto = '$newName' WHERE nis = '$_SESSION[id]'");
               }
            }
            header('location:./');
         }
      }
   } // end isset $_REQUEST['update']

   //cek session type
   if ($_SESSION['type'] == 1) {
      $data = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM t_admin WHERE id_admin = '$_SESSION[id]'"));
   } elseif ($_SESSION['type'] == 2) {
      $data = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM t_guru WHERE id_guru = '$_SESSION[id]'"));
   } else {
      $data = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM t_siswa WHERE nis = '$_SESSION[id]'"));
   }
?>

   <h4>Ganti Foto Profil</h4>
   <br />

   <div class="row"> <!-- start row -->
      <form class="col s12" action="" method="post" enctype="multipart/form-data"> <!-- start form -->
         <input type="hidden" value="<?php echo $_SESSION['id']; ?>" name="id"/>
         <input type="hidden" value="<?php echo $data['foto']; ?>" name="nfoto"/>
         <div class="row"> <!-- start row form -->
            <div class="col s4 center"> <!-- start col foto -->
               <?php
               if ( $_SESSION['type'] != 3 ) {
                  echo '<img src="../assets/img/'.$data['foto'].'" height="200" width="200" class="z-depth-1" />';
               } else {
                  echo '<img src="./assets/img/'.$data['foto'].'" height="200" width="200" class="z-depth-1" />';
               }
               ?>
            </div> <!-- end col foto -->
            <div class="file-field input-field col s6" style="padding-top:120px;"> <!-- start col form upload -->
               <div class="btn blue lighten-2">
                  <span>Foto Profil</span>
                  <input type="file" name="foto">
               </div>
               <div class="file-path-wrapper">
                  <input class="file-path validate" type="text">
               </div>
            </div> <!-- end form upload -->
         </div> <!-- end row form -->
         <br />
         <div class="row"> <!-- start row button -->
            <div class="input-field col s8 right">
               <button class="btn waves-effect waves-light green lighten-1" type="submit" name="update">
                  Update <i class="fa fa-check"></i>
               </button>
               <button class="btn waves-effect waves-light red" onclick=self.history.back()>
                  Batal <i class="fa fa-times"></i>
               </button>
            </div>
         </div> <!-- end row button -->
      </form> <!-- end form -->
   </div> <!-- end row -->
