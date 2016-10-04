<?php
   //cek session
   if (empty($_SESSION['type']) || $_SESSION['type'] != 3) {
      header('location:./');
   }
   //cek apakah $_REQUEST['update'] telah diset
   if (isset($_REQUEST['update'])) {
      $user      = addslashes($_REQUEST['user']);
      $jk        = $_REQUEST['jk'];
      $tgl       = $_REQUEST['tgl'];
      $alamat    = addslashes($_REQUEST['alamat']);
      $fullname  = addslashes($_REQUEST['nama']);
      $ayah      = addslashes($_REQUEST['ayah']);
      $ibu       = addslashes($_REQUEST['ibu']);

      $sql = "UPDATE t_siswa SET username = '$user', fullname = '$fullname', ayah = '$ayah', ibu = '$ibu', jk = '$jk', tgl = '$tgl', alamat = '$alamat' WHERE nis = '$_SESSION[id]'";

      $cek = "SELECT * FROM t_siswa WHERE username = '$_REQUEST[user]'";
      //validasi umur
      if ((date("Y") - date("Y", strtotime($tgl))) < 14 || (date("Y") - date("Y", strtotime($tgl))) > 20){
         echo '<script type="text/javascript">alert("Umur tidak valid !");</script>';
         //cek apakah ada perubahan username
      } elseif ($_REQUEST['user'] == $_REQUEST['name']) {
         mysqli_query($mysqli, $sql);
         header('location:./dashboard.php');

      } elseif(mysqli_num_rows(mysqli_query($mysqli, $cek)) > 0){
         echo '<script type="text/javascript">alert("Username tidak tersedia silahkan coba lagi!")</script>';

      } else {
         mysqli_query($mysqli, $sql);
         header('location:./dashboard.php');
      }
   }

   $data = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM t_siswa WHERE nis = '$_SESSION[id]'"));
?>

   <h4>Edit Profil</h4>
   <br />

   <div class="row"> <!-- start row -->
      <form class="col s12 m10 l10 offset-l1" action="" method="post" id="form"> <!-- start form -->
         <input type="hidden" value="<?php echo $data['username']; ?>" name="name"/>
         <input type="hidden" value="<?php echo $data['nis']; ?>" name="nis"/>
         <div class="row jarak"> <!-- start row nis -->
            <div class="input-field col s7">
               <i class="fa fa-credit-card prefix"></i>
               <input type="text" value="<?php echo $data['nis']; ?>" disabled/>
               <label for="username">NIS</label>
            </div>
         </div> <!-- end row nis -->
         <div class="row jarak"> <!-- start row username -->
            <div class="input-field col s7">
               <i class="fa fa-user prefix"></i>
               <input id="username" type="text" value="<?php echo $data['username']; ?>" name="user" data-validation="length" data-validation-length="3-35"/>
               <label for="username">Username</label>
            </div>
         </div> <!-- end row username -->
         <div class="row jarak"> <!-- start row fullname -->
            <div class="input-field col s7">
               <i class="fa fa-user prefix"></i>
               <input id="fullname" type="text" value="<?php echo $data['fullname']; ?>" length="45" maxlength="45" name="nama" data-validation="custom length" data-validation-regexp="^([a-zA-Z \.\']+)$" data-validation-length="3-45"/>
               <label for="fullname">Fullname</label>
            </div>
         </div> <!-- end row fullname -->
         <div class="row jarak"> <!-- start row jenis kelamin -->
            <div class="col s7">
               <i class="fa fa-venus-mars prefix"></i>
               <label>Jenis Kelamin</label>
               <select class="browser-default" name="jk" required >
                  <option value="L">Laki - laki</option>
                  <option value="P" <?php if ($data['jk'] == 'P') { echo 'selected';} ?>>Perempuan</option>
               </select>
            </div>
         </div> <!-- end row jenis kelamin -->
         <div class="row jarak"> <!-- start row tgl -->
            <div class="input-field col s8">
               <i class="fa fa-calendar prefix"></i>
               <input type="text" class="datepicker" required="required" name="tgl" placeholder="tanggal lahir" value="<?php echo $data['tgl']; ?>"/>
            </div>
         </div> <!-- end row tgl -->
         <div class="row jarak"> <!-- start row alamat -->
            <div class="input-field col s8">
               <i class="fa fa-map prefix"></i>
               <textarea id="textarea1" class="materialize-textarea" required="alamat" length="120" maxlength="120" name="alamat"><?php echo $data['alamat']; ?></textarea>
               <label for="textarea1">Alamat</label>
            </div>
         </div> <!-- end row alamat -->
         <div class="row jarak"> <!-- start row ayah -->
            <div class="input-field col s8">
               <i class="fa fa-user prefix"></i>
               <input id="ayah" type="text" length="45" maxlength="45" name="ayah" value="<?php echo $data['ayah']; ?>" data-validation="custom length" data-validation-regexp="^([a-zA-Z \.\']+)$" data-validation-length="3-45"/>
               <label for="ayah">Nama Ayah</label>
            </div>
         </div> <!-- end row ayah -->
         <div class="row jarak"> <!-- start row ibu -->
            <div class="input-field col s8">
               <i class="fa fa-user prefix"></i>
               <input id="ibu" type="text" length="45" maxlength="45" name="ibu" value="<?php echo $data['ibu']; ?>" data-validation="custom length" data-validation-regexp="^([a-zA-Z \.\']+)$" data-validation-length="3-45"/>
               <label for="ibu">Nama Ibu</label>
            </div>
         </div> <!-- end row ibu -->
         <br />
         <div class="row"> <!-- start row button -->
            <div class="input-field col s6 right">
               <button class="btn waves-effect waves-light green lighten-1" type="submit" name="update">
                  Update <i class="fa fa-check right"></i>
               </button>
               <button class="btn waves-effect waves-light red" onclick=self.history.back()>
                  Batal <i class="fa fa-times right"></i>
               </button>
            </div>
         </div> <!-- end row button -->
      </form> <!-- end form -->
   </div> <!-- end row -->
