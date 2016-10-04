<?php
   //cek session
   if (!isset($_SESSION['type']) || $_SESSION['type'] == 3) {
      header('location:./');
   }

   if ( $_SESSION['type'] == 1 ) {
      $sql   = mysqli_query($mysqli, "SELECT * FROM t_admin WHERE id_admin = '$_SESSION[id]'");
      $data  = mysqli_fetch_array($sql);
   } else {
      $sql   = mysqli_query($mysqli, "SELECT * FROM t_guru WHERE id_guru = '$_SESSION[id]'");
      $data  = mysqli_fetch_array($sql);
   }

?>
   <!-- start row message -->
   <div class="row row-margin">
      <div class="col s12 m12">
         <div class="card grey lighten-5">
            <div class="card-content">
               <span class="card-title">
                  Selamat datang di Dashboard <b><?php if ($_SESSION['type'] == 1) { echo "Admin"; } else { echo "Guru"; } ?></b> Aplikasi E-learning SMK Al-Husna
               </span>
               <p>
                  Anda Login Sebagai :
                  <h5><?php echo $data['fullname']; ?></h5>
               </p>
            </div>
         </div>
      </div>
   </div>
   <h5>Quick Menu</h5>
   <div class="card z-depth-1">
      <div class="card-content row">
         <?php
         if ($_SESSION['type'] == 1) { //cek value $_SESSION['type']

            include_once("./admin/menu.php");

         } else {

           include_once("./guru/menu.php");

         } //end if session
         ?>
      </div>
   </div>
