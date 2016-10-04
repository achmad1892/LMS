<?php
   session_start();

   $host = "localhost";
   $user = "root";
   $pass = "1234YnWa";
   $db   = "LMS";

   $mysqli = mysqli_connect($host, $user, $pass, $db) or die ("Konenksi Gagal !!!");

   function timer() {
      $timeout = 60;
      $_SESSION['timeout'] = time() + $timeout;
   }

   function cek_login() {
      $exp_time = $_SESSION['timeout'];
      if (time() < $exp_time) {
         timer();
         return true;
      } else {
         return false;
      }
   }
?>
