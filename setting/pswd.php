<?php
   //cek session
   if (!isset($_SESSION['type'])) {
      header('location:./');
   }

   //cek $_REQUEST['update'] apakah telah diset
   if (isset($_REQUEST['update'])) {
      $npass   = MD5(MD5($_REQUEST['npass']));
      $pass    = MD5(MD5($_REQUEST['pass']));

      //cek session type
      if ($_SESSION['type'] == 1) {
         $cek = mysqli_query($mysqli, "SELECT * FROM t_admin WHERE password = '$pass' && id_admin = '$_REQUEST[id]'");
         if (mysqli_num_rows($cek) <= 0) {
            echo '<script type="text/javascript">alert("Password Lama Ditolak !!! Akses Illegal !");window.location = "?page=logout";</script>';
         } else {
            mysqli_query($mysqli, "UPDATE t_admin SET password = '$npass' WHERE id_admin = '$_SESSION[id]'");
         }
      } elseif ($_SESSION['type'] == 2) {
         $cek = mysqli_query($mysqli, "SELECT * FROM t_guru WHERE password = '$pass' && id_guru = '$_REQUEST[id]'");
         if (mysqli_num_rows($cek) <= 0) {
            echo '<script type="text/javascript">alert("Password Lama Ditolak !!! Akses Illegal !");window.location = "?page=logout";</script>';
         } else {
            mysqli_query($mysqli, "UPDATE t_admin SET password = '$npass' WHERE id_admin = '$_SESSION[id]'");
         }
      } else {
         $cek = mysqli_query($mysqli, "SELECT * FROM t_siswa WHERE password = '$pass' && nis = '$_SESSION[id]'");
         if (mysqli_num_rows($cek) <= 0) {
            echo '<script type="text/javascript">alert("Password Lama Ditolak !!! Akses Illegal !");window.location = "?page=logout";</script>';
         } else {
            mysqli_query($mysqli, "UPDATE t_siswa SET password = '$npass' WHERE nis = '$_SESSION[id]'");
            header('location:?page=logout');
         }
      }
   }
?>

   <h4>Ganti Password</h4>
   <br />
   <br />
   <div class="row"> <!-- start row -->
      <form class="col l8 m6 s12 offset-l1 offset-m3" action="" method="post" id="form"> <!-- start form -->
         <div class="row jarak"> <!-- start row pass lama -->
            <div class="input-field col s12">
               <i class="fa fa-key prefix"></i>
               <input id="pass_prefix1" type="password" class="validate" name="pass" required="password" data-validation="length" data-validation-length="min5"/>
               <label for="pass_prefix1">Password Lama</label>
            </div>
         </div> <!-- end pass lama -->
         <div class="row jarak"> <!-- start pass baru -->
            <div class="input-field col s12">
               <i class="fa fa-key prefix"></i>
               <input id="pass_prefix" type="password" class="validate" name="npass" required="password" data-validation="length" data-validation-length="min5"/>
               <label for="pass_prefix">Password</label>
            </div>
         </div> <!-- end pass baru -->
         <br />
         <div class="row"> <!-- start row button -->
            <div class="input-field right">
               <button class="btn waves-effect waves-light green lighten-1" type="submit" name="update" onclick="return confirm('Anda akan diminta login kembali setelah merubah password, lanjut ?')">
                  Update <i class="fa fa-check"></i>
               </button>
               <a href="./" class="btn waves-effect waves-light red">
                  Batal <i class="fa fa-arrow-left"></i>
               </a>
            </div>
         </div> <!-- end row button -->
      </form> <!-- end form -->
   </div> <!-- end row -->
