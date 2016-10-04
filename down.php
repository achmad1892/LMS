<?php
   include_once('./include/connection.php');

   if(!isset($_REQUEST['id'])){
      header("location:./");
   }

   $direktori = "./assets/materi/"; // folder tempat penyimpanan file yang boleh didownload
   $id        = mysqli_real_escape_string($mysqli, $_REQUEST['id']);
   $dat       = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM t_materi WHERE id_materi = '$id'"));
   $filename  = $dat['judul_mat'];


   $file_extension = strtolower(substr(strrchr($filename,"."),1));

   switch($file_extension){
      case "pdf": $ctype="application/pdf"; break;
      case "doc": $ctype="application/msword"; break;
      case "xls": $ctype="application/vnd.ms-excel"; break;
      case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
      default: $ctype="application/proses";
   }

   if ($file_extension=='php'){
      echo "<h1>Access forbidden!</h1>";
      echo "<p>Maaf, file yang Anda download sudah tidak tersedia atau filenya (direktorinya) telah diproteksi. <br /></p>";
      exit;
   } else {
      if ($dat['download'] != '') {
         $cek_array = explode(',', $dat['download']);
         if (!in_array(($_SESSION['id']), $cek_array)) {
            $akses = $dat['download'].','.$_SESSION['id'];
            mysqli_query($mysqli, "UPDATE t_materi SET download = '$akses' WHERE id_materi = '$id'");
         }
      } else {
         mysqli_query($mysqli, "UPDATE t_materi SET download = '$_SESSION[id]' WHERE id_materi = '$id'");
      }


      header("Content-Type: $ctype");
      header("Content-Disposition: attachment; filename=\"".basename($filename)."\";" );
      header("Content-Transfer-Encoding: binary");
      header("Content-Length: ".filesize($direktori.$filename));
      readfile("$direktori$filename");
      exit();
   }
?>
