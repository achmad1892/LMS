<?php

   if (empty($_SESSION['type']) || $_SESSION['type'] != 2 || empty($_REQUEST['id'])) {
      header('location:./');
   }

   //cek $_REQUEST['update'] apakah telah diset
   if (isset($_REQUEST['update'])) {
      //cek apakah form sudah terisi
      if ($_REQUEST['judul'] == '' || $_REQUEST['waktu'] == '' || $_REQUEST['kls'] == '') {
         echo '<script type="text/javascript">alert("Judul / Waktu / Kelas tidak boleh kosong !");</script>';
      } elseif (!preg_match("/^[0-9]*$/",$_REQUEST['waktu'])) { //validasi waktu agar hanya berisi angka
         echo '<script type="text/javascript">alert("Waktu harus menggunakan angka !");</script>';
         //cek apakah $_REQUEST['status'] diubah
      } elseif ($_REQUEST['status'] == 'Y') {
         if (mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM t_soal WHERE id_header = '$_REQUEST[id]'")) <= 0) {
            echo '<script type="text/javascript">alert("Belum Ada soal, Status tidak bisa diubah!");</script>';
         } else {
            $judul  = addslashes($_REQUEST['judul']);
            $tgl    = date('Y-m-d');
            $wkt    = ($_REQUEST['waktu'] * 60);
            $kls    = $_REQUEST['kls'];
            $publik = $_REQUEST['status'];

            $sql = "UPDATE t_header_soal SET judul = '$judul', tgl_dibuat = '$tgl', waktu = '$wkt', id_index = '$kls', publikasi = '$publik' WHERE id_header = '$_REQUEST[id]'";

            mysqli_query($mysqli, $sql);
            header('location:?page=test');
         }
      }
   }
   $id   = mysqli_real_escape_string($mysqli, $_REQUEST['id']);
   $data = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM t_header_soal WHERE id_header = '$id'"));
?>

   <h4>Edit Test</h4>
   <br />

   <div class="row"> <!-- start row -->

      <form action="" method="post" class="col s12 m10 l10 offset-l1">

         <input type="hidden" value="<?php echo $data['id_header']; ?>" name="id" />

         <div class="row"> <!-- start row judul -->
            <div class="input-field col s7">
               <input id="judul" type="text" value="<?php echo $data['judul']; ?>" length="255" maxlength="255" name="judul" required />
               <label for="judul">Judul Test</label>
            </div>
         </div> <!-- end row judul -->

         <div class="row"> <!-- start row waktu -->
            <div class="input-field col s7">
               <input id="waktu" type="text" value="<?php echo ($data['waktu'] / 60); ?>" length="4" maxlength="4" name="waktu" required />
               <label for="waktu">Waktu Pengerjaan</label>
               <p><small><i>* dalam menit</i></small></p>
            </div>
         </div> <!-- end row waktu -->

         <div class="col s7"> <!-- start row kelas -->
            <i class="fa fa-list"></i>
            <label>Kelas :</label>
            <select class="browser-default" name="kls" required>
               <option value="" disabled selected>--Pilih--</option>
               <?php
               $sql  = "SELECT * FROM t_index_mapel JOIN t_kelas ON t_index_mapel.id_kelas = t_kelas.id_kelas JOIN t_mapel ON t_index_mapel.id_mapel = t_mapel.id_mapel WHERE t_index_mapel.id_guru = '$_SESSION[id]'";
               $mapel = mysqli_query($mysqli, $sql);

               while ($key = mysqli_fetch_array($mapel)) { //start while
                  ?>
                  <option value="<?php echo $key['id_index']; ?>" <?php if($key['id_index'] == $data[ 'id_index']){ echo "selected";} ?>>
                     <?php echo $key['nama_mapel']; ?> ( <?php echo $key['nama_kelas'];?> )
                  </option>
                  <?php
               } //end while
               ?>
            </select>
         </div> <!-- end row Kelas -->

         <div class="row"> <!--start row status -->
            <div class="input-field col s7">
               <input class="with-gap" name="status" type="radio" id="test1" value="Y" <?php if($data[ 'publikasi']=='Y' ){ echo "checked"; } ?>/>
               <label for="test1">Publish</label>
               <input class="with-gap" name="status" type="radio" id="test2" value="N" <?php if($data[ 'publikasi']=='N' ){ echo "checked"; } ?>/>
               <label for="test2">Tidak</label>
            </div>
         </div> <!-- end row status -->

         <div class="row"> <!-- start row button -->
            <div class="input-field col s6 right">
               <button class="btn waves-effect waves-light green lighten-1" type="submit" name="update">
                  Update <i class="fa fa-send right"></i>
               </button>
               <a href="?page=test" class="btn waves-effect waves-light red">
                  Batal <i class="fa fa-times right"></i>
               </a>
            </div>
         </div> <!-- end row button -->

      </form>

   </div> <!-- end row -->
