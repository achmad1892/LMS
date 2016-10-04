<?php

   if (empty($_SESSION['type']) || $_SESSION['type'] != 1) {
      header('location:./');
   }

   //cek $_REQUEST['add']
   if (isset($_REQUEST['add'])) {
      if($_REQUEST['nama'] == '' && $_REQUEST['kelas'] == ''){
         echo '<script type="text/javascript">alert("Harap isi form nama mapel / pilih dari daftar !");</script>';
         //cek apakah admin menginput nama mapel melalui form / list
      } elseif (empty($_REQUEST['nama'])) {
         $data     = "SELECT * FROM t_index_mapel WHERE id_mapel = '$_REQUEST[daftar]' && id_guru = '$_REQUEST[guru]'";

         $cek_data = mysqli_num_rows(mysqli_query($mysqli, $data));

         if ( $cek_data > 0 ) {
            echo '<script type="text/javascript">alert("Data ini sudah tersedia silahkan coba lagi");window.history.go(-1);</script>';
         } else {
            //melalui list
            $sql = "INSERT INTO t_index_mapel VALUES ('', '$_REQUEST[daftar]', '$_REQUEST[guru]', '$_REQUEST[kelas]')";

            mysqli_query($mysqli, $sql);
            header('location:?page=mapel');
         }

      } else { //jika melalui form

         $nama  = $_REQUEST['nama'];

         $cek   = mysqli_num_rows(mysqli_query($mysqli, "SELECT * FROM t_mapel WHERE nama_mapel = '$nama'"));
         //cek apakah ada penggandaan nama mapel
         if ($cek > 0) {
            echo '<script type="text/javascript">alert("Mapel Sudah Ada !! harap gunakan list !");</script>';
         } else {
            mysqli_query($mysqli, "INSERT INTO t_mapel (nama_mapel) VALUES ('$nama')");
         }

         //dapatkan id mapel
         $pilih  = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM t_mapel ORDER BY id_mapel DESC"));

         $simpan = mysqli_query($mysqli, "INSERT INTO t_index_mapel VALUES ('', '$pilih[id_mapel]', '$_REQUEST[guru]', '$_REQUEST[kelas]')");

         header('location:?page=mapel');
      }
   }
?>

   <h4>Tambah Jadwal</h4>
   <div class="row"> <!-- start row -->

      <form class="col s12 m10 l10 offset-l1" action="" method="post"> <!-- start form -->

         <div class="row jarak"> <!-- row form mapel -->
            <div class="input-field col s7">
               <i class="fa fa-pencil-square prefix"></i>
               <input id="mapel" type="text" length="20" maxlength="20" name="nama" />
               <label for="mapel">Mapel</label>
            </div>
         </div><!-- end form mapel -->

         <br />
         <label>
            <em>Anda Bisa memilih dari Daftar Mapel yang sudah ada dengan memilih pilihan dibawah ini</em>
         </label>

         <div class="row jarak"> <!-- start row daftar mapel -->
            <div class="col s8">
               <i class="fa fa-list prefix"></i> &nbsp;
               <label>Daftar Mapel</label>
               <select class="browser-default" name="daftar">
                  <option value="" selected="selected">Pilih Mapel</option>
                  <?php
                  $pilih = mysqli_query($mysqli, "SELECT * FROM t_mapel");

                  while ($key = mysqli_fetch_array($pilih)) {
                     echo '<option value="'.$key['id_mapel'].'" >'.$key['nama_mapel'].'</option>';
                  }
                  ?>
               </select>
            </div>
         </div> <!-- end row daftar mapel -->

         <br />

         <div class="row jarak"> <!-- start row daftar kelas -->
            <div class="col s8">
               <i class="fa fa-home prefix"></i> &nbsp;
               <label>Kelas</label>
               <select class="browser-default" name="kelas">
                  <option value="" selected="selected">Pilih Kelas</option>
                  <?php
                  $pilih = mysqli_query($mysqli, "SELECT * FROM t_kelas");

                  while ($key = mysqli_fetch_array($pilih)) {
                     echo '<option value="'.$key['id_kelas'].'" >'.$key['nama_kelas'].'</option>';
                  }
                  ?>
               </select>
            </div>
         </div> <!-- end row daftar kelas -->

         <br />

         <div class="row jarak"> <!-- start row daftar guru -->
            <div class="col s8">
               <i class="fa fa-user prefix"></i> &nbsp;
               <label>Pengajar</label>
               <select class="browser-default" name="guru">
                  <?php
                  $pilih = mysqli_query($mysqli, "SELECT * FROM t_guru");

                  while ($key = mysqli_fetch_array($pilih)) {
                     echo '<option value="'.$key['id_guru'].'" >'.$key['fullname'].'</option>';
                  }
                  ?>
               </select>
            </div>
         </div> <!-- end row daftar guru -->

         <div class="row"> <!-- start row button -->
            <div class="input-field col s7 right">
               <button class="btn waves-effect waves-light green lighten-1" type="submit" name="add">
                  Simpan <i class="fa fa-floppy-o right"></i>
               </button>
               <a href="?page=mapel" class="btn waves-effect waves-light red">
                  Batal <i class="fa fa-times right"></i>
               </a>
            </div>
         </div> <!-- end row button -->

      </form> <!-- end form -->

   </div> <!-- end row -->
