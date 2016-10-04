<?php

   if (empty($_SESSION['type']) || $_SESSION['type'] != 1) {
      header('location:./');
   }

   //cek $_REQUEST['add']
   if (isset($_REQUEST['add'])) {

      $nama   = $_REQUEST['nama'];
      $wali   = $_REQUEST['guru'];

      //cek value $nama
      if ($nama == '') {
         echo '<script type="text/javascript">alert("Nama Kelas tidak boleh kosong !");</script>';
      } else {
         $cek = mysqli_num_rows(mysqli_query($mysqli, "SELECT * FROM t_kelas WHERE nama_kelas = '$nama'"));

         //hitung kelas dengan nama yang diinputkan
         if ($cek > 0) {
            echo '<script type="text/javascript">alert("Kelas Sudah Ada !");</script>';
         } else {
            mysqli_query($mysqli, "INSERT INTO t_kelas VALUES ('', '$nama', '$wali')");
            header('location:?page=daftar_kelas');
         }
      }
   } //end isset($_REQUEST['add']
?>

   <h4>Tambah Kelas</h4>
   <br />
   <div class="row"><!-- start row -->

      <form class="col s12 m10 l10 offset-l1" action="" method="post" id="form"><!-- start form -->

         <div class="row jarak"><!-- start row nama kelas -->
            <div class="input-field col s7">
               <i class="fa fa-home prefix"></i>
               <input id="kls" type="text" length="20" maxlength="20" name="nama" required="Nama Kelas" data-validation="custom length" data-validation-regexp="^([a-zA-Z -]+)$" data-validation-length="5-20" />
               <label for="kls">Nama Kelas</label>
            </div>
         </div><!-- end row nama kelas -->

         <div class="row jarak"><!-- start row nama guru -->
            <div class="col s8">
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
               <button class="btn waves-effect waves-light green lighten-1" type="submit" name="add">
                  Simpan <i class="fa fa-floppy-o right"></i>
               </button>
               <a href="?page=daftar_kelas" class="btn waves-effect waves-light red">
                  Batal <i class="fa fa-times right"></i>
               </a>
            </div>

         </div> <!-- end row button -->

      </form> <!-- end form -->

   </div> <!-- end row -->
