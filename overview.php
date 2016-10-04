<?php
   if (empty($_SESSION['type'])) {
      header('location:./');
   }
?>

   <div class="row">
      <div class="col s12 m12">
         <div class="card grey lighten-4">
            <div class="card-content row">
               <div class="col s2 m2">
                  <img src="./assets/img/logo.png" class="profil">
               </div>
               <div class="col s9 m9 contents">
                  <span class="card-title">Selamat Datang di Aplikasi E-Learning <i>SMK Al-Husna</i></span>
                  <p>Anda Login Sebagai :
                  <h5><?php echo $data['fullname']; ?></h5></p>
                  <div class="card-action">
                     <a href="?page=profil" class="btn waves-effect waves-light blue">Ubah Profil</a>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <h5><i>Quick Menu</i></h5>
   <div class="row">
      <a href="./">
         <div class="col m2">
            <div class="card yellow darken-4 center">
               <div class="card-content white-text">
                  <i class="fa fa-desktop fa-2x"></i>
                  <p>&nbsp;</p>
                  <p>Dashboard</p>
               </div>
            </div>
         </div>
      </a>
      <a href="?page=materi">
         <div class="col m2">
            <div class="card deep-purple darken-1 center">
               <div class="card-content white-text">
                  <i class="fa fa-file-text-o fa-2x"></i>
                  <p>&nbsp;</p>
                  <p>Daftar Materi</p>
               </div>
            </div>
         </div>
      </a>
      <a href="?page=nilai">
         <div class="col m2">
            <div class="card blue accent-2 center">
               <div class="card-content white-text">
                  <i class="fa fa-file-text-o fa-2x"></i>
                  <p>&nbsp;</p>
                  <p>Daftar Nilai</p>
               </div>
            </div>
         </div>
      </a>
      <a href="?page=test">
         <div class="col m2">
            <div class="card teal darken-1 center">
               <div class="card-content white-text">
                  <i class="fa fa-file-text-o fa-2x"></i>
                  <p>&nbsp;</p>
                  <p>Daftar Test</p>
               </div>
            </div>
         </div>
      </a>
      <a href="?page=pass">
         <div class="col m2">
            <div class="card indigo darken-1 center">
               <div class="card-content white-text">
                  <i class="fa fa-key fa-2x"></i>
                  <p>Ganti Password</p>
               </div>
            </div>
         </div>
      </a>
      <a href="?page=logout" onclick="return confirm('Yakin Ingin Keluar?')">
         <div class="col m2">
            <div class="card red darken-2 center">
               <div class="card-content white-text">
                  <i class="fa fa-sign-out fa-2x"></i>
                  <p>&nbsp;</p>
                  <p>Sign Out</p>
               </div>
            </div>
         </div>
      </a>
   </div>
