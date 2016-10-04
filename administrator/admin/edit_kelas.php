<?php
   if (!isset($_REQUEST['id']) || empty($_SESSION['type']) || $_SESSION['type'] != 1) {
      header('location:./');
   }

   if (isset($_REQUEST['update'])) {
      $id   = mysqli_real_escape_string($mysqli, $_REQUEST['id_kelas']);
      $guru = mysqli_real_escape_string($mysqli, $_REQUEST['guru']);

      $exe  = mysqli_query($mysqli, "UPDATE t_kelas SET id_guru = '$guru' WHERE id_kelas = '$id'");

      if ($exe) {
         header('location:?page=daftar_kelas');
      } else {
         mysqli_error();
      }
   }

   $id_kelas = mysqli_real_escape_string($mysqli, $_REQUEST['id']);
   $kelas    = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM t_kelas WHERE id_kelas = '$id_kelas'"));
?>
   <h4>Edit Kelas</h4>
   <br />
   <div class="row"> <!-- start row -->

      <form class="col s12 m10 l10 offset-l1" action="" method="post"> <!-- start form -->
         <input type="hidden" name="id_kelas" value="<?php echo $kelas['id_kelas']; ?>" />

         <div class="input-field col s7">
            <i class="fa fa-home prefix"></i>
            <input id="kls" type="text" value="<?php echo $kelas['nama_kelas']; ?>" disabled/>
            <label for="kls">Nama Kelas</label>
         </div>

         <div class="row jarak"><!-- start row nama guru -->
            <div class="col s7">
               <i class="fa fa-user prefix"></i>
               <label>Wali Kelas</label>
               <select class="browser-default" name="guru">
                  <option value="" selected="selected">Pilih Wali Kelas</option>
                  <?php

                  $pilih = mysqli_query($mysqli, "SELECT * FROM t_guru");

                  while ($key = mysqli_fetch_array($pilih)) {
                     echo '<option value="'.$key['id_guru'].'" >'.$key['fullname'].'</option>';
                  }

                  ?>
               </select>
            </div>
         </div><!-- end row nama guru -->
         <br />
         <div class="row"><!-- start row button -->

            <div class="input-field col s7 right">
               <button class="btn waves-effect waves-light green lighten-1" type="submit" name="update">
                  Update <i class="fa fa-send"></i>
               </button>
               <a href="?page=daftar_kelas" class="btn waves-effect waves-light red">
                  Batal <i class="fa fa-times right"></i>
               </a>
            </div>

         </div> <!-- end row button -->
      </form> <!-- end form -->

   </div> <!-- end row -->
