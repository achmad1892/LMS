<?php
   if (empty($_SESSION['type']) || $_SESSION['type'] != 2) {
      header('location:./');
      die();
   }

   if (isset($_REQUEST['submit'])) {
      $file = $_FILES['file_soal']['tmp_name'];
      $id   = mysqli_real_escape_string($mysqli, $_REQUEST['id']);

      if ($file == '') {
         echo '<script type="text/javascript">alert("Form tidak boleh kosong !");</script>';
      } else {
         $x    = explode('.', $_FILES['file_soal']['name']);
         $ext  = strtolower(end($x));

         if ($ext == 'csv') {
            $handle = fopen($file, "r");
            while(($data = fgetcsv($handle, 1000, ";")) !== FALSE){
               $soal   = addslashes($data[0]);
               $a      = addslashes($data[1]);
               $b      = addslashes($data[2]);
               $c      = addslashes($data[3]);
               $d      = addslashes($data[4]);
               $kunci  = addslashes(strtoupper($data[5]));

               //insert data ke dalam database
               $query = mysqli_query($mysqli, "INSERT INTO t_soal(id_header, soal, pil_a, pil_b, pil_c, pil_d, kunci) VALUES('$id','$soal','$a','$b','$c','$d','$kunci')");
            }
            fclose($handle);
            header("Location:?page=test&aksi=tambah_soal&id=".$id);
            die();
         }
      }
   }
?>
   <h4>Inport Soal</h4>
   <br />
   <div class="row"> <!-- start row -->

      <form class="col s12 m10 l10 offset-l1" action="" method="post" enctype="multipart/form-data"> <!-- start form -->
         <input type="hidden" name="id" value="<?php echo $_REQUEST['id']; ?>" />
         <div class="row jarak">
            <div class="col m8 file-field input-field">
               <div class="btn green lighten-1">
                  <span>Pilih File</span>
                  <input type="file" name="file_soal" required />
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
