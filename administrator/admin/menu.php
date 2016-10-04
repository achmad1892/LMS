<?php
   if (empty($_SESSION['id'])) {
      header('location:./');
   }
?>

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
   <a href="?page=daftar_guru&aksi=add">
      <div class="col m2">
         <div class="card blue accent-2 center">
            <div class="card-content white-text">
               <i class="fa fa-user-plus fa-2x"></i>
               <p>&nbsp;</p>
               <p>Tambah Guru</p>
            </div>
         </div>
      </div>
   </a>
   <a href="?page=daftar_siswa&aksi=add">
      <div class="col m2">
         <div class="card teal darken-1 center">
            <div class="card-content white-text">
               <i class="fa fa-user-plus fa-2x"></i>
               <p>&nbsp;</p>
               <p>Tambah Siswa</p>
            </div>
         </div>
      </div>
   </a>
   <a href="?page=setting&set=profil">
      <div class="col m2">
         <div class="card indigo darken-4 center">
            <div class="card-content white-text">
               <i class="fa fa-user fa-2x"></i>
               <p>&nbsp;</p>
               <p>Ubah Profil</p>
            </div>
         </div>
      </div>
   </a>
   <a href="?page=setting&set=key">
      <div class="col m2">
         <div class="card green darken-3 center">
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
