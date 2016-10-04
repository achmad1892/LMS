<?php
   //cek session
   if (!isset($_SESSION['type'])) {
      header('location:./');
   }

   //cek $_REQUEST['update'] apakah telah diset
   if (isset($_REQUEST['update'])) {
      $fullname   = addslashes($_REQUEST['nama']);
      $user       = addslashes($_REQUEST['user']);

      $sql = "UPDATE t_admin SET username = '$user', fullname = '$fullname' WHERE id_admin = '$_SESSION[id]'";
      //eksekusi
      mysqli_query($mysqli, $sql);
      header('location:../administrator/dashboard.php');
   }

   $data = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM t_admin WHERE id_admin = '$_SESSION[id]'"));
?>

   <h4>Edit Profil</h4>
   <br />

   <div class="row"> <!-- start row -->
      <form class="col s12" action="" method="post" id="form"> <!-- start form -->
         <input type="hidden" value="<?php echo $data['id_admin']; ?>" name="id"/>
         <div class="row jarak"> <!-- start row username -->
            <div class="input-field col s4">
               <input id="username" type="text" value="<?php echo $data['username']; ?>" length="35" maxlength="35" name="user" required="username" data-validation="length" data-validation-length="4-35"/>
               <label for="username">Username</label>
            </div>
         </div><!-- end row username -->
         <div class="row jarak"> <!-- start row fullname -->
            <div class="input-field col s4">
               <input id="fullname" type="text" value="<?php echo $data['fullname']; ?>" length="45" maxlength="45" name="nama" required="Fullname" data-validation="custom length" data-validation-regexp="^([a-zA-Z \.\']+)$" data-validation-length="3-45"/>
               <label for="fullname">Fullname</label>
            </div>
         </div> <!-- end row fullname -->
         <br />
         <div class="row"> <!-- start row button -->
            <div class="input-field col s8 right">
               <button class="btn waves-effect waves-light green lighten-1" type="submit" name="update">
                  Update <i class="fa fa-check right"></i>
               </button>
               <a href="./" class="btn waves-effect waves-light red">
                  Batal <i class="fa fa-times right"></i>
               </a>
            </div>
         </div> <!-- end row button -->
      </form> <!-- end form -->
   </div> <!-- end row -->
