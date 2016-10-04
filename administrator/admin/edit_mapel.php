<?php

   if (empty($_SESSION['type']) || $_SESSION['type'] != 1 || !isset($_REQUEST['id'])) {
      header('location:./');
   }

   //cek apakah $_REQUEST['update'] telah diset
   if (isset($_REQUEST['update'])) {
      //cek apakah admin menggunakan form mapel atau daftar mapel
      if (empty($_REQUEST['nama'])) {
         $data     = "SELECT * FROM t_index_mapel WHERE id_mapel = '$_REQUEST[daftar]' && id_guru = '$_REQUEST[guru]' && id_kelas = '$_REQUEST[kelas]'";

         $cek_data = mysqli_num_rows(mysqli_query($mysqli, $data));

         if ( $cek_data > 0) {
            echo '<script type="text/javascript">alert("Data sudah ada silahkan coba lagi");window.history.go(-1);</script>';
         } else {
            $sql = "UPDATE t_index_mapel SET id_mapel = '$_REQUEST[daftar]', id_guru = '$_REQUEST[guru]', id_kelas = '$_REQUEST[kelas]' WHERE id_index = '$_REQUEST[id]'";

            mysqli_query($mysqli, $sql);
            header('location:?page=mapel');
         }
      } else {
         $nama = $_REQUEST['nama'];
         $cek  = mysqli_query($mysqli, "SELECT * FROM t_mapel WHERE nama_mapel = '$nama'");

         //cek nama mapel agar tidak terduplikasi
         if (mysqli_num_rows($cek) > 0) {
            echo '<script type="text/javascript">alert("Mata Pelajaran sudah ada !! harap gunakan dari daftar saja !!!");window.history.go(-1);</script>';
         } else {
            mysqli_query($mysqli, "INSERT INTO t_mapel (nama_mapel) VALUES ('$nama')");
         }

         $pilih = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM t_mapel ORDER BY id_mapel DESC"));

         mysqli_query($mysqli, "UPDATE t_index_mapel SET id_mapel = '$pilih[id_mapel]', id_guru = '$_REQUEST[guru]', id_kelas = '$_REQUEST[kelas]' WHERE id_index = '$_REQUEST[id]'");
         header('location:?page=mapel');
      }
   }

   $id   = mysqli_real_escape_string($mysqli, $_REQUEST['id']);
   $data = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM t_index_mapel WHERE id_index = '$id'"));
?>

   <h4>Edit Jadwal</h4>
   <div class="row"> <!-- start row -->

      <form class="col s12 m10 l10 offset-l1" action="" method="post"> <!-- start form -->
         <input type="hidden" name="id_mapel" value="<?php echo $data['id_index']; ?>" />

         <div class="row jarak"> <!-- start row form nama mapel -->
            <div class="input-field col s7">
               <i class="fa fa-pencil-square prefix"></i>
               <input id="nip" type="text" length="20" maxlength="20" name="nama" />
               <label for="nip">Mapel</label>
            </div>
         </div> <!-- end row form nama mapel -->
         <br />
         <label>
            <em>Anda Bisa memilih dari Daftar Mapel yang sudah ada dengan memilih pilihan dibawah ini</em>
         </label>
         <div class="row jarak"> <!-- start daftar mapel -->
            <div class="col s8">
               <i class="fa fa-list prefix"></i> &nbsp;
               <label>Daftar Mapel</label>
               <select class="browser-default" name="daftar">
                  <?php
                  $pilih = mysqli_query($mysqli, "SELECT * FROM t_mapel");

                  while ($key = mysqli_fetch_array($pilih)) {
                     ?>
                    <option value="<?php echo $key['id_mapel'];?>" <?php if ($key[ 'id_mapel'] == $data[ 'id_mapel']) { echo "selected"; } ?> >
                       <?php echo $key['nama_mapel']; ?>
                    </option>
                    <?php
                  }
                  ?>
               </select>
            </div>
         </div> <!-- end daftar mapel -->
         <br />
         <div class="row jarak"> <!-- start row daftar kelas -->
            <div class="col s8">
               <i class="fa fa-home prefix"></i> &nbsp;
               <label>Kelas</label>
               <select class="browser-default" name="kelas">
                  <?php
                  $pilih = mysqli_query($mysqli, "SELECT * FROM t_kelas");

                  while ($key = mysqli_fetch_array($pilih)) {
                     ?>
                    <option value="<?php echo $key['id_kelas'];?>" <?php if ($key[ 'id_kelas'] == $data[ 'id_kelas']) { echo "selected"; } ?> >
                       <?php echo $key['nama_kelas']; ?>
                    </option>
                    <?php
                  }
                  ?>
               </select>
            </div>
         </div> <!-- end row daftar kelas -->
         <br />
         <div class="row jarak"> <!-- start row pengajar -->
            <div class="col s8">
               <i class="fa fa-user prefix"></i> &nbsp;
               <label>Pengajar</label>
               <select class="browser-default" name="guru">
                  <?php
                  $pilih = mysqli_query($mysqli, "SELECT * FROM t_guru");

                  while ($key = mysqli_fetch_array($pilih)) {
                     ?>
                    <option value="<?php echo $key['id_guru'];?>" <?php if ($key[ 'id_guru'] == $data[ 'id_guru']) { echo "selected"; } ?> >
                       <?php echo $key['fullname']; ?>
                    </option>
                    <?php
                  }
                  ?>
               </select>
            </div>
         </div> <!-- end row pengajar -->

         <div class="row"> <!-- start row button -->
            <div class="input-field col s7 right">
               <button class="btn waves-effect waves-light green lighten-1" type="submit" name="update">
                  Update <i class="fa fa-send"></i>
               </button>
               <a href="?page=mapel" class="btn waves-effect waves-light red">
                  Batal <i class="fa fa-times"></i>
               </a>
            </div>
         </div> <!-- end row button -->
      </form> <!-- end form -->

   </div> <!-- end row -->
