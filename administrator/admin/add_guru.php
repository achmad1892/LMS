<?php

   if (empty($_SESSION['type']) || $_SESSION['type'] != 1) {
      header('location:./');
   }
   if (isset($_REQUEST['add'])) {

      if ($_REQUEST['nip'] != '') {
         if (!preg_match("/^[0-9 ]*$/",$_REQUEST['nip'])) {
            echo '<script type="text/javascript">alert("Nip hanya boleh angka dan spasi");window.history.go(-1);</script>';
         }

         $cek = mysqli_num_rows(mysqli_query($mysqli, "SELECT * FROM t_guru WHERE username = '$_REQUEST[user]' || nip = '$_REQUEST[nip]'"));
      } else {
         $cek = mysqli_num_rows(mysqli_query($mysqli, "SELECT * FROM t_guru WHERE username = '$_REQUEST[user]'"));
      }

      if ($cek > 0) {
         echo '<script type="text/javascript">alert("Nip / Username Tidak Tersedia");</script>';
      } else {
         $cek = mysqli_query($mysqli, "SELECT * FROM t_guru ORDER BY id_guru DESC LIMIT 1");

         if (mysqli_num_rows($cek) > 0) {
            $idg      = mysqli_fetch_array($cek);
            $no       = (intval(substr($idg['id_guru'], 1))) + 1;
            $id_guru  = "G".sprintf("%02d", $no);
         } else {
            $id_guru  = "G01";
         }

         $nip        = addslashes($_REQUEST['nip']);
         $fullname   = addslashes($_REQUEST['nama']);
         $user       = addslashes($_REQUEST['user']);
         $jk         = $_REQUEST['jk'];
         $pass       = MD5(MD5($_REQUEST['pass']));

         $exe = mysqli_query($mysqli, "INSERT INTO t_guru (id_guru, nip, username, fullname, password, jk) VALUES ('$id_guru', '$nip', '$user', '$fullname', '$pass', '$jk')");

         if ($exe) {
            header('location:?page=daftar_guru');
         } else {
            echo '<script type="text/javascript">alert("Nama Guru Sudah Ada, Silahkan Inputkan yang lain");</script>';
         }
      }
   } // end if $_REQUEST['add']
?>

   <h4>Tambah Data Guru</h4>
   <br />
   <div class="row"> <!-- start row -->
      <form class="col s12 m10 l10 offset-l1" action="" method="post" id="form"> <!-- form start -->
         <div class="row jarak">
            <div class="input-field col s7">
               <i class="fa fa-credit-card prefix"></i>
               <input id="nip" type="text" length="22" maxlength="22" name="nip" />
               <label for="nip">NIP</label>
            </div>
         </div>
         <div class="row jarak">
            <div class="input-field col s7">
               <i class="fa fa-user prefix"></i>
               <input id="fullname" type="text" length="45" maxlength="45" name="nama" required="Fullname" data-validation="custom length" data-validation-regexp="^([a-zA-Z \,\.\']+)$" data-validation-length="3-45" />
               <label for="fullname">Fullname</label>
            </div>
         </div>
         <div class="row jarak">
            <div class="input-field col s7">
               <i class="fa fa-user prefix"></i>
               <input id="username" type="text" length="35" maxlength="35" name="user" required="username" data-validation="length" data-validation-length="4-35" />
               <label for="username">Username</label>
            </div>
         </div>
         <div class="row jarak">
            <div class="col s7">
               <i class="fa fa-venus-mars prefix"></i>
               <label>Jenis Kelamin</label>
               <select class="browser-default" name="jk" required="jenis kelamin">
                  <option value="" disabled selected>Jenis Kelamin</option>
                  <option value="L">Laki - laki</option>
                  <option value="P">Perempuan</option>
               </select>
            </div>
         </div>
         <div class="row jarak">
            <div class="input-field col s7">
               <i class="fa fa-lock prefix"></i>
               <input id="password" type="password" name="pass" required="Password" data-validation="length" data-validation-length="min5" />
               <label for="password">Password</label>
            </div>
         </div>
         <br />
         <div class="row">
            <div class="input-field col s7 right">
               <button class="btn waves-effect waves-light green lighten-1" type="submit" name="add">
                  Simpan <i class="fa fa-floppy-o right"></i>
               </button>
               <a href="?page=daftar_guru" class="btn waves-effect waves-light red">
                  Batal <i class="fa fa-times right"></i>
               </a>
            </div>
         </div>
      </form> <!--form end -->

  </div> <!-- end row -->
