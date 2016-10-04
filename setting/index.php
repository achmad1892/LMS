<?php
   //cek session
   if (!isset($_SESSION['type']) || empty($_REQUEST['set'])) {
      header('location:../');
   }

   echo '<div class="card z-depth-1">';
   echo '<div class="card-content">';
   // cek apakah $_REQUEST['set'] telah diset
   switch ($_REQUEST['set']) {
      case 'foto-profil':
         include_once('../setting/foto.php');
         break;
      case 'key':
         include_once('../setting/pswd.php');
         break;
      case 'profil':
         //cek session type
         if ($_SESSION['type'] == 1) {
            include_once('../setting/profil_admin.php');
         } elseif ($_SESSION['type'] == 2) {
            include_once('../setting/profil_guru.php');
         }else{
            include_once('../setting/profil_siswa.php');
         }
         break;
   } //end switch
   echo '</div>';
   echo '</div>';
?>
