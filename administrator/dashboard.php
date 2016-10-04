<?php

   include_once('../include/connection.php');

   ob_start();

   //cek apakah $_SESSION['type'] memiliki nilai / bernilai 3
   if (empty($_SESSION['type']) || $_SESSION['type'] == 3) {
      header('location:./');
   }

   if (!cek_login()) {
      header('location:?page=logout');
   }

?>

<!DOCTYPE html>
<html>

   <head>
      <title>Dashboard</title>
      <link href="../assets/css/materialize.min.css" type="text/css" rel="stylesheet" />
      <link href="../assets/css/font-awesome.min.css" type="text/css" rel="stylesheet" />
      <link href="../assets/css/style.css" type="text/css" rel="stylesheet" />
      <link rel="shortcut icon" type="image/x-icon" href="../assets/img/favicon.ico" />
      <style type="text/css">
         .row-margin {
           padding: 5px 30px;
         }

         .btn {
           border-radius: 2px;
           height: 32px;
           line-height: 32px;
           padding: 0 10px;
         }

         body {
           background-image: url(../assets/img/back.jpg);
         }
      </style>
      <meta http-equiv="refresh" content="60">
      <noscript>
         <meta http-equiv="refresh" content="0;URL='../include/noscript.html'">
      </noscript>
   </head>

   <body class="green lighten-3">
      <header> <!-- start header -->
         <div class="navbar-fixed">
            <nav class="green">
               <div class="nav-wrapper">
                  <a href="#!" class="brand-logo">
                     <img src="../assets/img/nav.png" class="img_dashboard">
                  </a>
                  <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="fa fa-bars"></i></a>
               </div>
            </nav>
         </div>
      </header> <!-- end of header -->

      <main> <!-- main start -->
         <?php include_once('../include/side_nav.php'); ?>
         <div class="container"> <!-- container start -->
            <div class="card z-depth-1"> <!-- start card -->
               <div class="card-content"> <!-- start card-content -->
                  <?php
                  //cek apakah $_REQUEST['page'] mempunyai value
                  if (empty($_REQUEST['page'])) {

                    include_once('./overview.php');

                  } else {
                     //alihkan halaman berdasarkan value $_REQUEST['page']
                     switch ($_REQUEST['page']) {
                        case 'daftar_guru':
                           include_once('./admin/view_guru.php');
                           break;
                        case 'daftar_siswa':
                           include_once('./admin/view_siswa.php');
                           break;
                        case 'daftar_kelas':
                           include_once('./admin/view_kelas.php');
                           break;
                        case 'mapel':
                           include_once('./admin/view_mapel.php');
                           break;
                        case 'setting':
                           include_once('../setting/index.php');
                           break;
                        case 'user':
                           include_once('./user_online.php');
                           break;
                        case 'rekap':
                           include_once('./admin/rekap.php');
                           break;
                        case 'materi':
                           include_once('./guru/view_materi.php');
                           break;
                        case 'test':
                           include_once('./guru/view_topik.php');
                           break;
                        case 'nilai':
                           include_once('./guru/nilai.php');
                           break;
                        case 'logout':
                           if ($_SESSION['type'] == 1) {
                              mysqli_query($mysqli, "UPDATE t_admin SET login_status = 'N' WHERE id_admin = '$_SESSION[id]'");
                           } else {
                              mysqli_query($mysqli, "UPDATE t_guru SET login_status = 'N' WHERE id_guru = '$_SESSION[id]'");
                           }
                           session_destroy();
                           header('location:./');
                           break;
                     } //end switch

                  } //end if isset
                  ?>
               </div><!-- end card-content -->
            </div> <!-- end card -->
         </div> <!-- container end -->
         <center><b><?php echo date('Y'); ?> &copy SMK Al-Husna Loceret</b></center>
      </main> <!-- main end -->

      <script type="text/javascript" src="../assets/js/jquery.js"></script>
      <script type="text/javascript" src="../assets/js/inid.js"></script>
      <script type="text/javascript" src="../assets/js/jquery_validator.js"></script>
      <script type="text/javascript" src="../assets/js/materialize.min.js"></script>
      <script type="text/javascript">
      $.validate({
        form: '#form'
      });

      $('.datepicker').pickadate({
        selectMonths: true,
        selectYears: 100,
        format: 'yyyy-mm-dd'
      });

      $(document).ready(function() {
        $('select').material_select();
      });
      </script>
   </body>

</html>
  <?php
// kosongkan output buffer
ob_flush();
?>
