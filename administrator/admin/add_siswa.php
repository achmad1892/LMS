<?php

   if (empty($_SESSION['type']) || $_SESSION['type'] != 1) {
      header('location:./');
   }

   //cek $_REQUEST['add']
   if (isset($_REQUEST['add'])) {

      $nis        = addslashes($_REQUEST['nis']);
      $user       = addslashes($_REQUEST['user']);
      $fullname   = addslashes($_REQUEST['nama']);
      $ayah       = addslashes($_REQUEST['ayah']);
      $ibu        = addslashes($_REQUEST['ibu']);
      $jk         = $_REQUEST['jk'];
      $kls        = $_REQUEST['kls'];
      $tgl        = $_REQUEST['tgl'];
      $alamat     = addslashes($_REQUEST['alamat']);
      $pass       = MD5(MD5($_REQUEST['pass']));
      $angkatan   = date("Y");

      $sql = "INSERT INTO t_siswa (nis, username, fullname, password, jk, tgl, ayah, ibu, alamat, id_kelas, angkatan) VALUES ('$nis', '$user', '$fullname', '$pass', '$jk', '$tgl', '$ayah', '$ibu', '$alamat', '$kls', '$angkatan')";

      //validasi tanggal lahir
      if ((date("Y") - date("Y", strtotime($tgl))) < 14 || (date("Y") - date("Y", strtotime($tgl))) > 20){
         echo '<script type="text/javascript">alert("Umur siswa tidak valid !");</script>';
         //validasi jumlah username / nis
      } elseif (mysqli_num_rows(mysqli_query($mysqli, "SELECT * FROM t_siswa WHERE username = '$user' || nis = '$nis'")) > 0){
         echo '<script type="text/javascript">alert("Username / Nis sudah ada !");</script>';
      } else {
         mysqli_query($mysqli, $sql);
         header('location:?page=daftar_siswa');
      }
   }
?>

   <h4>Tambah Data Siswa</h4>
   <br />
   <div class="row"> <!-- start row -->

      <form class="col s12 m10 l10 offset-l1" action="" method="post" id="form"> <!-- start form -->

         <div class="row jarak"> <!-- start row nis -->
            <div class="input-field col s8">
               <i class="fa fa-credit-card prefix"></i>
               <input id="nis" type="text" length="10" maxlength="10" name="nis" required="NIS" data-validation="number" data-validation-allowing="float" />
               <label for="nis">NIS</label>
            </div>
         </div> <!-- end row nis -->

         <div class="row jarak"> <!-- start row fullname -->
            <div class="input-field col s8">
               <i class="fa fa-user prefix"></i>
               <input id="fullname" type="text" length="45" maxlength="45" name="nama" required="fullname" data-validation="custom length" data-validation-regexp="^([a-zA-Z \.\']+)$" data-validation-length="3-45" />
               <label for="fullname">Fullname</label>
            </div>
         </div> <!-- end row fullname -->

         <div class="row jarak"> <!-- start row username -->
            <div class="input-field col s8">
               <i class="fa fa-user prefix"></i>
               <input id="username" type="text" length="35" maxlength="35" name="user" required="username" data-validation="length" data-validation-length="min4" />
               <label for="username">Username</label>
            </div>
         </div> <!-- end row username -->

         <div class="row jarak"> <!-- start row jenis kelamin -->
            <div class="col s8">
               <i class="fa fa-venus-mars prefix"></i>
               <label>Jenis Kelamin</label>
               <select class="browser-default" name="jk" required="jenis kelamin">
                  <option value="" disabled selected>Jenis Kelamin</option>
                  <option value="L">Laki - laki</option>
                  <option value="P">Perempuan</option>
               </select>
            </div>
         </div> <!-- end row jenis kelamin -->

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

         <div class="row jarak"> <!-- start row tgl lahir -->
            <div class="input-field col s8">
               <i class="fa fa-calendar prefix"></i>
               <input type="text" class="datepicker" required="tanggal lahir" name="tgl" placeholder="tanggal lahir" />
            </div>
         </div> <!-- end row tgl lahir -->

         <div class="row jarak"> <!-- start row alamat -->
            <div class="input-field col s8">
               <i class="fa fa-map prefix"></i>
               <textarea id="textarea1" class="materialize-textarea" length="120" maxlength="120" name="alamat" required="alamat" data-validation="length" data-validation-length="4-120"></textarea>
               <label for="textarea1">Alamat</label>
            </div>
         </div> <!-- end row alamat -->

         <div class="row jarak"> <!-- start row password -->
            <div class="input-field col s8">
               <i class="fa fa-lock prefix"></i>
               <input id="password" type="password" name="pass" required="password" data-validation="length" data-validation-length="min5" />
               <label for="password">Password</label>
            </div>
         </div> <!-- end row password -->

         <div class="row jarak"> <!-- start row nama ayah -->
            <div class="input-field col s8">
               <i class="fa fa-user prefix"></i>
               <input id="ayah" type="text" length="45" maxlength="45" name="ayah" required="nama ayah" data-validation="custom length" data-validation-regexp="^([a-zA-Z \.\']+)$" data-validation-length="3-45" />
               <label for="ayah">Nama Ayah</label>
            </div>
         </div> <!-- end row nama ayah -->

         <div class="row jarak"> <!-- start row nama ibu -->
            <div class="input-field col s8">
               <i class="fa fa-user prefix"></i>
               <input id="ibu" type="text" length="45" maxlength="45" name="ibu" required="nama ibu" data-validation="custom length" data-validation-regexp="^([a-zA-Z \.\']+)$" data-validation-length="3-45" />
               <label for="ibu">Nama Ibu</label>
            </div>
         </div> <!-- end row nama ibu -->
         <br />
         <div class="row"> <!-- start row button -->
            <div class="input-field col s7 right">
               <button class="btn waves-effect waves-light green lighten-1" type="submit" name="add">
                  Simpan <i class="fa fa-floppy-o right"></i>
               </button>
               <a href="?page=daftar_siswa" class="btn waves-effect waves-light red">
                  Batal <i class="fa fa-times right"></i>
               </a>
            </div>
         </div> <!-- end row button -->

      </form> <!-- end form -->

   </div> <!-- end row -->
