<?php
   if (empty($_SESSION['type']) || $_SESSION['type'] != 1) {
      header('location:./');
      die();
   }

   if (isset($_REQUEST['submit'])) {
      $file = $_FILES['file_siswa']['tmp_name'];
      $kls  = $_REQUEST['kls'];
      if ($file == '') {
         echo '<script type="text/javascript">alert("Form tidak boleh kosong !");</script>';
      } else {
         $x    = explode('.', $_FILES['file_siswa']['name']);
         $ext  = strtolower(end($x));

         if ($ext == 'csv') {
            $handle = fopen($file, "r");
            while(($data = fgetcsv($handle, 1000, ";")) !== FALSE){
               $username = addslashes($data[1]);
               $fullname = addslashes($data[2]);
               $ayah     = addslashes($data[6]);
               $ibu      = addslashes($data[7]);
               $alamat   = addslashes($data[8]);
               //insert data ke dalam database
               $query = mysqli_query($mysqli, "INSERT INTO t_siswa(nis, username, fullname, password, jk, tgl, ayah, ibu, alamat, id_kelas) VALUES('$data[0]','$username','$fullname', md5(md5('$data[3]')), '$data[4]', '$data[5]', '$ayah', '$ibu', '$alamat', '$kls')");
            }
            fclose($handle);
            header("Location:?page=daftar_siswa");
            die();
         }
      }
   }
?>
   <h4>Inport Data Siswa</h4>
   <br />
   <div class="row"> <!-- start row -->

      <form class="col s12 m10 l10 offset-l1" action="" method="post" enctype="multipart/form-data"> <!-- start form -->
         <div class="row jarak"> <!-- start row kelas -->
            <div class="col s8">
               <i class="fa fa-home prefix"></i>
               <label>Kelas</label>
               <select class="browser-default" name="kls" required="kelas">
                  <option value="" disabled selected>Pilih Kelas</option>
                  <?php
                  $data = mysqli_query($mysqli, "SELECT * FROM t_kelas");

                  while ($pilih = mysqli_fetch_array($data)) {
                     echo '<option value="'.$pilih['id_kelas'].'">'.$pilih['nama_kelas'].'</option>';
                  }
                  ?>
               </select>
            </div>
         </div> <!-- end row kelas -->

         <div class="row jarak">
            <div class="col m8 file-field input-field">
               <div class="btn green lighten-1">
                  <span>Pilih File</span>
                  <input type="file" name="file_siswa" required />
               </div>
               <div class="file-path-wrapper">
                  <input class="file-path validate" type="text">
                  <small><i>* File barus berformat *.csv</i></small>
               </div>
            </div>
         </div>
         <br />
         <br />
         <div class="row">
            <div class="col m6 right">
               <a href="?page=daftar_siswa" class="btn red waves-light waves-effect">
                  <i class="fa fa-arrow-left"></i> Kembali
               </a>
               <button type="submit" name="submit" class="btn green waves-light waves-effect">
                  <i class="fa fa-upload"></i> Upload
               </button>
            </div>
         </div>
      </form> <!-- end form -->

   </div> <!-- end row -->
