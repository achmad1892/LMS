<?php

   if (empty($_SESSION['type']) || $_SESSION['type'] != 1 || empty($_REQUEST['id'])) {
      header('location:../');
   }

   //cek apakah $_REQUEST['update'] diset
   if (isset($_REQUEST['update'])) {
      $id         = mysqli_real_escape_string($mysqli, $_REQUEST['id']);
      $nip        = addslashes($_REQUEST['nip']);
      $fullname   = addslashes($_REQUEST['nama']);
      $user       = addslashes($_REQUEST['user']);
      $jk         = $_REQUEST['jk'];

      $sql  = "UPDATE t_guru SET nip = '$nip', username = '$user', fullname = '$fullname', jk = '$jk' WHERE id_guru = '$id'";

      if ($user == '' || $fullname == '') { //cek apakah username / fullname memiliki value
         echo '<script type="text/javascript">alert("NIP / Fullname tidak boleh KOSONG !!!")</script>';

      } elseif (!preg_match("/^[0-9 ]*$/",$nip)){ //validasi nip agar hanya berisi angka dan spasi
         echo '<script type="text/javascript">alert("NIP Hanya boleh berisi angka dan spasi!");</script>';

      } else {
         if($_REQUEST['nip1'] != $nip && $nip != ''|| $_REQUEST['name'] != $user) { //cek apakah admin menset NIP baru
            if ($nip != '') {
               $cek = mysqli_num_rows(mysqli_query($mysqli, "SELECT * FROM t_guru WHERE username = '$user' || nip = '$nip'"));
            } else {
               $cek = mysqli_num_rows(mysqli_query($mysqli, "SELECT * FROM t_guru WHERE username = '$user'"));
            }

            if($cek > 0) {
               echo '<script type="text/javascript">alert("NIP / username Sudah Digunakan !");</script>';
            } else {
               $exe = mysqli_query($mysqli, $sql);
               if ($exe) {
                  header('location:?page=daftar_guru');
               } else {
                  echo '<script type="text/javascript">alert("Nama Guru Sudah Ada, Silahkan Inputkan yang lain");</script>';
               }
            }
         } else {
            $exe = mysqli_query($mysqli, $sql);
            if ($exe) {
               header('location:?page=daftar_guru');
            } else {
               echo '<script type="text/javascript">alert("Nama Guru Sudah Ada, Silahkan Inputkan yang lain");</script>';
            }
         }
      }
   } // end if isset $_REQUEST['update']

   $id     = mysqli_real_escape_string($mysqli, $_REQUEST['id']);
   $data   = mysqli_query($mysqli, "SELECT * FROM t_guru WHERE id_guru = '$id'");
   $hasil  = mysqli_fetch_array($data);
?>

   <h4>Edit Data Guru</h4>
   <br />
   <div class="row"> <!-- start row -->
      <form class="col s12 m10 l10 offset-l1" action="" method="post" id="form"> <!-- start form -->

         <input type="hidden" value="<?php echo $hasil['id_guru']; ?>" name="id" />
         <input type="hidden" name="nip1" value="<?php echo $hasil['nip']; ?>" />
         <input type="hidden" name="name" value="<?php echo $hasil['username']; ?>" />

         <div class="row jarak"> <!-- start row nip -->
            <div class="input-field col s7">
               <i class="fa fa-credit-card prefix"></i>
               <input id="nip" type="text" value="<?php echo $hasil['nip']; ?>" length="22" maxlength="22" name="nip" />
               <label for="nip">NIP</label>
            </div>
         </div> <!-- end row nip -->

         <div class="row jarak"> <!-- start row username -->
            <div class="input-field col s7">
               <i class="fa fa-user prefix"></i>
               <input id="username" type="text" value="<?php echo $hasil['username']; ?>" name="user" data-validation="length" data-validation-length="3-35" required="username" />
               <label for="username">Username</label>
            </div>
         </div> <!-- end row username -->

         <div class="row jarak"> <!-- start row fullname -->
            <div class="input-field col s7">
               <i class="fa fa-user prefix"></i>
               <input id="fullname" type="text" value="<?php echo $hasil['fullname']; ?>" length="50" maxlength="50" name="nama" required="Fullname" data-validation="custom length" data-validation-regexp="^([a-zA-Z \.\'\,]+)$" data-validation-length="3-45" />
               <label for="fullname">Fullname</label>
            </div>
         </div> <!-- end row fullname -->

         <div class="row jarak"> <!-- start row jenis kelamin -->
            <div class="col s7">
               <i class="fa fa-venus-mars prefix"></i>
               <label>Jenis Kelamin</label>
               <select class="browser-default" name="jk" required>
                  <option value="1">Laki - laki</option>
                  <option value="0" <?php if ($hasil[ 'jk'] == 'P') { echo 'selected';} ?>>Perempuan</option>
               </select>
            </div>
         </div> <!-- end row jenis kelamin -->
         <br />
         <div class="row"> <!-- start row button -->
            <div class="input-field col s6 right">
               <button class="btn waves-effect waves-light green lighten-1" type="submit" name="update">
                  Update <i class="fa fa-send"></i>
               </button>
               <a href="?page=daftar_guru" class="btn waves-effect waves-light red">
                  Batal <i class="fa fa-times"></i>
               </a>
            </div>
         </div> <!-- end row button -->

      </form> <!-- end form -->

   </div> <!-- end row -->
