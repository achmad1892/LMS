<?php

   if(empty($_SESSION['type']) || empty($_REQUEST['id'])){
      header('location:../');
   }

   if (isset($_REQUEST['aksi'])) {
      switch ($_REQUEST['aksi']) {
         case 'delete':
            $forum = mysqli_real_escape_string($mysqli, $_REQUEST['id']);
            $key   = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM t_forum WHERE id_forum = '$forum'"));

            if ($key['foto_topik'] != '') {
               unlink("../assets/img/".$key['foto_topik']);
            }
            mysqli_query($mysqli, "DELETE FROM t_forum WHERE id_forum = '$forum'");

            $data = mysqli_query($mysqli, "SELECT * FROM t_komentar WHERE id_forum = '$forum'");

            while ($hapus = mysqli_fetch_array($data)) {
               if ($hapus['gambar'] != '') {
                  unlink("../assets/img/".$hapus['gambar']);
               }
               mysqli_query($mysqli, "DELETE FROM t_komentar WHERE id_komentar = '$hapus[id_komentar]'");
            }
            header('location:index.php');
            break;
         case 'akses':
            include_once('./diakses.php');
            break;
      }
   } else {

      //cek apakah $_REQUEST['kirim'] telah diset
      if (isset($_REQUEST['kirim'])){
         //cek form isi
         if ($_REQUEST['isi'] == ''){
            echo '<script type="text/javascript">alert("Anda belum mengisi form tanggapan !");</script>';
         } else {
            $id_forum   = mysqli_real_escape_string($mysqli, $_REQUEST['id']);
            $isi        = trim(addslashes($_REQUEST['isi']));
            $foto       = $_FILES['foto'];

            //daftar ekstensi gambar yang diperbolehkan
            $ext  = array('image/jpg','image/jpeg','image/pjpeg','image/png','image/x-png');
            $tipe = $_FILES['foto']['type']; //dapatkan ekstensi file yang diupload
            //cek apakah ada file yang diupload
            if (is_uploaded_file($foto['tmp_name'])){
               if (!in_array(($tipe),$ext)){ //cek apakah ekstensi file diperbolehkan
                  echo '<script type="text/javascript">alert("Format foto tidak diperbolehkan!")</script>';
               } else {
                  $extractFile = pathinfo($foto['name']);
                  $dir         = "../assets/img/";
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
                  $newName = empty($sameName) ? $foto['name'] : $extractFile['filename'].'('.$sameName.').'.$extractFile['extension'];

                  //pindahkan file yang di upload ke directory tujuan bila berhasil jalankan perintah query untuk mennyimpan ke database
                  if (move_uploaded_file($foto['tmp_name'],$dir.$newName)) {
                     $sql   = "INSERT INTO t_komentar (id_forum, komentar, gambar, user) VALUES('$id_forum', '$isi', '$newName', '$_SESSION[id]')";
                     mysqli_query($mysqli, $sql);
                     header('location:./index.php?page=comment&id='.$id_forum);
                  }
               }
            } else {
               //eksekusi perintah berikut jika tidak ada file yang diupload
               $sql   = "INSERT INTO t_komentar(id_forum, komentar, user) VALUES('$id_forum','$isi', '$_SESSION[id]')";
               mysqli_query($mysqli, $sql);
               header('location:./index.php?page=comment&id='.$id_forum);
            }
         }
      }

      $id_forum = mysqli_real_escape_string($mysqli, $_REQUEST['id']);
      $data     = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM t_forum WHERE id_forum = '$id_forum'"));
      $id       = $data['user'];
      if ($_SESSION['id'] != $id) {
         if ($data['diakses'] != '') {
            $cek_array = explode(',', $data['diakses']);
            if (!in_array(($_SESSION['id']), $cek_array)) {
               $akses = $data['diakses'].','.$_SESSION['id'];
               mysqli_query($mysqli, "UPDATE t_forum SET diakses = '$akses' WHERE id_forum = '$id_forum'");
            }
         } else {
            mysqli_query($mysqli, "UPDATE t_forum SET diakses = '$_SESSION[id]' WHERE id_forum = '$id_forum'");
         }
      }

      if ($_SESSION['id'] == $id || $_SESSION['type'] == 1) {
         ?>
         <a href="?page=comment&aksi=delete&id=<?php echo $id_forum; ?>" class="btn-floating red right" onclick="return confirm('Yakin Ingin Menghapus Thread ini?')"><i class="fa fa-trash"></i></a>
         <?php
      }
      ?>
      <div class="row"> <!-- start row -->
         <div class="col s2 center"> <!-- start col foto -->
            <?php
            $guru = mysqli_query($mysqli, "SELECT * FROM t_guru WHERE id_guru = '$id'");

            if (mysqli_num_rows($guru) > 0) {
               $fot = mysqli_fetch_array($guru);
            } elseif(mysqli_num_rows(mysqli_query($mysqli, "SELECT * FROM t_siswa WHERE nis = '$id'")) > 0) {
               $fot = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM t_siswa WHERE nis = '$id'"));
            } else {
               $fot = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM t_admin WHERE id_admin = '$id'"));
            }
            echo '<img src="../assets/img/'.$fot['foto'].'" width="80" height="80">';
            echo '<br />';
            echo '<h6>'.$fot['fullname'].'<h6>';
            ?>
         </div> <!-- end col foto -->
         <div class="col s8"> <!-- start col thread -->
            <h4><?php echo $data['judul']; ?></h4>
            <p><?php echo $data['isi']; ?></p>
            <?php
            if ($data['foto_topik'] != '') {
               echo '<img src="../assets/img/'.$data['foto_topik'].'" width="250" height="100">';
            }
            ?>
            <br />
            <li class="divider"></li> <!-- hanya pembatas -->
            <?php
            if ($data['diakses'] != '') {
               echo '<a class="right modal-trigger" href="#modal1">';
               echo '<p>dilihat oleh '.count(explode(',',$data['diakses'])).' orang</p>';
               echo '</a>';
            } else {
               echo '<p class="right">dilihat oleh 0 orang</p>';
            }
            ?>
            <br />
         </div><!-- end col thread -->
      </div> <!-- end row -->
      <!--komentar-->
      <?php
      $komen = mysqli_query($mysqli, "SELECT * FROM t_komentar WHERE id_forum = '$id_forum'");
      if (mysqli_num_rows($komen) > 0) {
         //start foreach
         while ($key = mysqli_fetch_array($komen)) {

            $guru = mysqli_query($mysqli, "SELECT * FROM t_guru WHERE id_guru = '$key[user]'");

            if (mysqli_num_rows($guru) > 0) {
               $foto   = mysqli_fetch_array($guru);
            } elseif (mysqli_num_rows(mysqli_query($mysqli, "SELECT * FROM t_siswa WHERE nis = '$key[user]'")) > 0) {
               $foto   = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM t_siswa WHERE nis = '$key[user]'"));
            } else {
               $foto   = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM t_admin WHERE id_admin = '$key[user]'"));
            }

            if ($key['user'] == $_SESSION['id']) {
               echo '<div class="row">';
               echo '<div class="col s2 center">';
               echo '<img src="../assets/img/'.$foto['foto'].'" class="circle border" width="50" height="50"><br />';
               echo '<h6>'.$foto['username'].'</h6>';
               echo '</div>';
               echo '<div class="col m7 offset m2 left back1"><br />';
               echo $key['komentar'].'<br />';
               if ($key['gambar'] != '') {
                  echo '<br /><img src="../assets/img/'.$key['gambar'].'" width="200" height="200">';
               }
               echo '</div></div>';
            } else {
               echo '<div class="row">';
               echo '<div class="col m7 offset-m2 back2"><br />'.$key['komentar'].'<br />';
               if ($key['gambar'] != '') {
                  echo '<br /><img src="../assets/img/'.$key['gambar'].'" width="200" height="200">';
               }
               echo '</div>';
               echo '<div class="col m2 center">';
               echo '<img src="../assets/img/'.$foto['foto'].'" class="circle border" width="50" height="50">';
               echo '<h6>'.$foto['username'].'</h6>';
               echo '</div></div>';
            }
         } //end while
      } //end if hitung
      ?>
      <br />
      <form action="" method="post" enctype="multipart/form-data">
         <input type="hidden" name="id" value="<?php echo $id_forum; ?>" />
         <div class="row">
            <div class="col s10 push-s1">
               <label for="textarea1"><i class="fa fa-pencil-square"></i> Tanggapi :</label>
               <textarea id="textarea1" class="ckeditor" name="isi" required></textarea>
            </div>
            <br />
            <div class="file-field input-field col s10 push-s1">
               <div class="btn blue lighten-2">
                  <span>Tambah Foto</span>
                  <input type="file" name="foto">
               </div>
               <div class="file-path-wrapper">
                  <input class="file-path validate" type="text">
               </div>
            </div>
            <div class="row">
               <div class="input-field col s4 push-s8">
                  <button type="submit" name="kirim" class="btn waves-effect waves-light green lighten-1">
                     Tanggapi <i class="fa fa-send right"></i>
                  </button>
               </div>
            </div>
         </div>
      </form>
      <a href="./" class="btn waves-effect waves-light red lighten-1">
         Kembali <i class="fa fa-arrow-left right"></i>
      </a>
      <?php
   }
   $id       = mysqli_real_escape_string($mysqli, $_REQUEST['id']);
   $id_user  = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM t_forum WHERE id_forum = '$id'"));
   $user     = explode(',', $id_user['diakses']);
   ?>
   <div id="modal1" class="modal modal-fixed-footer">
      <div class="modal-content">
         <h6>Dilihat Oleh :</h6>
         <?php
         echo '<table class="highlight">';
         for ($i = 0; $i < count($user); $i++) { //start looping
            echo "<tr>";
            if (mysqli_num_rows(mysqli_query($mysqli, "SELECT * FROM t_admin WHERE id_admin = '$user[$i]'")) > 0) {
               $data = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM t_admin WHERE id_admin = '$user[$i]'"));
               echo '<td class="jarak center" width="100px" style="padding-top:0px; padding-bottom:0px;"><img src="../assets/img/'.$data['foto'].'" width="30px" height="30px" class="circle" style="border: 1px solid #cccccc"></td>';
               echo '<td style="padding-top:0px; padding-bottom:0px;">'.$data['fullname'].'</td>';
            } elseif (mysqli_num_rows(mysqli_query($mysqli, "SELECT * FROM t_guru WHERE id_guru = '$user[$i]'")) > 0) {
               $data = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM t_guru WHERE id_guru = '$user[$i]'"));
               echo '<td class="jarak center" width="100px" style="padding-top:0px; padding-bottom:0px;"><img src="../assets/img/'.$data['foto'].'" width="30px" height="30px" class="circle" style="border: 1px solid #cccccc"></td>';
               echo '<td style="padding-top:0px; padding-bottom:0px;">'.$data['fullname'].'</td>';
            } elseif (mysqli_num_rows(mysqli_query($mysqli, "SELECT * FROM t_siswa WHERE nis = '$user[$i]'")) > 0) {
               $data = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM t_siswa WHERE nis = '$user[$i]'"));
               echo '<td class="jarak center" width="100px" style="padding-top:0px; padding-bottom:0px;"><img src="../assets/img/'.$data['foto'].'" width="30px" height="30px" class="circle" style="border: 1px solid #cccccc"></td>';
               echo '<td style="padding-top:0px; padding-bottom:0px;">'.$data['fullname'].'</td>';
            }
            echo "</tr>";
         } // end lopping
         echo "</table>";
         ?>
      </div>
      <div class="modal-footer">
         <a href="#!" class="modal-action modal-close waves-effect waves-light btn red">Tutup</a>
      </div>
   </div>
