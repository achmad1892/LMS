<?php
   //cek session dan id
   if (empty($_REQUEST['id']) || empty($_SESSION['type'])) {
      header('location"./');
   }

   //cek apakah $_REQUEST['update'] telah diset
   if (isset($_REQUEST['update'])){
      //cek apakah semua form telah diisi
      if ($_REQUEST['judul'] == '' || $_REQUEST['isi'] == '' || $_REQUEST['daftar'] == ''){
         echo '<script type="text/javascript">alert("Judul Topik / isi / mapel tidak boleh kosong !");</script>';
      } else {
         $judul  = addslashes($_REQUEST['judul']);
         $isi    = $_REQUEST['isi'];
         $foto   = $_FILES['foto'];
         $mapel  = $_REQUEST['daftar'];
         $id     = mysqli_real_escape_string($mysqli, $_REQUEST['id']);

         //daftar ekstensi gambar yang diperbolehkan
         $ext     = array('image/jpg','image/jpeg','image/pjpeg','image/png','image/x-png');
         $tipe    = $_FILES['foto']['type']; //dapatkan ekstensi file yang diupload

         if(isset($_REQUEST['hapus'])){ //cek apakah $_REQUEST['hapus'] diset
            unlink("../assets/img/".$_REQUEST['nama']);

            $sql = "UPDATE t_forum SET judul = '$judul', isi = '$isi', foto_topik = '', id_mapel = '$mapel' WHERE id_forum = '$id'";
            mysqli_query($mysqli, $sql);
            header('location:./index.php?page=list');
         } else {

            if (is_uploaded_file($foto['tmp_name'])){ //cek apakah ada file yang diupload
               if (!in_array(($tipe),$ext)){ //cek validasi ekstensi file
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

                  //pindahkan file yang di upload ke directory tujuan bila berhasil jalankan perintah query untuk mennyimpan ke database
                  if(move_uploaded_file($foto['tmp_name'],$dir.$newName)){
                     $sql = "UPDATE t_forum SET judul = '$judul', isi = '$isi', foto_topik = '$newName', id_index = '$mapel' WHERE id_forum = '$id'";

                     mysqli_query($mysqli, $sql);
                     header('location:./index.php?page=list');
                  }
               }
            } else {
               $sql = "UPDATE t_forum SET judul = '$judul', isi = '$isi', id_index = '$mapel' WHERE id_forum = '$id'";

               mysqli_query($mysqli, $sql);
               header('location:./index.php?page=list');
            }
         }
      }
   }

   $id   = mysqli_real_escape_string($mysqli, $_REQUEST['id']);
   $data = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM t_forum WHERE id_forum = '$id'"));
?>

   <form action="" method="post" enctype="multipart/form-data"> <!-- start form -->
      <input type="hidden" name="id" value="<?php echo $data['id_forum']; ?>" />
      <input type="hidden" name="nama" value="<?php echo $data['foto_topik']; ?>" />
      <div class="row"> <!-- start row -->
         <div class="input-field col s10 push-s1">
            <input id="judul" name="judul" type="text" class="validate" required value="<?php echo $data['judul']; ?>"/>
            <label for="judul" data-error="wrong" data-success="right">Judul Topik</label>
         </div>
         <div class="input-field col s10 push-s1">
            <textarea class="ckeditor" name="isi" required><?php echo $data['isi']; ?></textarea>
         </div>
         <?php
         if($data['foto_topik'] != ''){
            echo '<div class="col s3" style="padding-top:50px;">';
            echo '<img src="../assets/img/'.$data['foto_topik'].'" width="200" height="200">
                  <input type="checkbox" name="hapus" id="cb"/>
                  <label for="cb">hapus gambar</label>';
            echo '</div>';
         }
         ?>
         <div class="file-field input-field col s8" <?php if ($data['foto_topik'] != '') { echo 'style="padding-top:150px;"';} ?> >
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

                        $siswa = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM t_siswa WHERE nis = '$_SESSION[id]'"));

                        $pilih = mysqli_query($mysqli, "SELECT * FROM t_index_mapel JOIN t_mapel ON t_index_mapel.id_mapel = t_mapel.id_mapel WHERE id_kelas = '$siswa[id_kelas]'");

                     } elseif ($_SESSION['type'] == 2) {

                        $pilih = mysqli_query($mysqli, "SELECT * FROM t_index_mapel JOIN t_mapel ON t_index_mapel.id_mapel = t_mapel.id_mapel WHERE id_guru = '$_SESSION[id]'");
                     } else {

                        $pilih = mysqli_query($mysqli, "SELECT * FROM t_index_mapel JOIN t_mapel ON t_index_mapel.id_mapel = t_mapel.id_mapel");

                     }
                     while ($key = mysqli_fetch_array($pilih)) { //start foreach mapel
                        ?>
                        <option value="<?php echo $key['id_index']; ?>" <?php if($data['id_index'] == $key['id_index']){ echo "selected";} ?>>
                           <?php echo $key['nama_mapel']; ?>
                        </option>
                        <?php
                     } // end foreach mapel
                     ?>
                  </select>
               </div>
               <div class="input-field col s6 push-s3">
                  <button type="submit" name="update" class="btn waves-effect waves-light green lighten-1">
                     Update <i class="fa fa-send right"></i>
                  </button>
                  <a href="./index.php?page=list" class="btn waves-effect waves-light red lighten-1">
                     Kembali <i class="fa fa-arrow-left"></i>
                  </a>
               </div>
            </div>
         </div>
      </div> <!-- end row -->
   </form> <!-- end form -->
