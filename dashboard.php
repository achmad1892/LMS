<?php
   include_once('./include/connection.php');

   ob_start();

   if (empty($_SESSION['type']) || $_SESSION['type'] != 3) {
      header('location:./');
   }

   if (!isset($_SESSION['kerjakan'])) {
      if (!cek_login()) {
         header('location:?page=logout');
      }
   }

   $data  = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM t_siswa WHERE nis = '$_SESSION[id]'"));
?>
<!DOCTYPE html>
<html>
   <head>
      <title>Dashboard</title>
      <link href="./assets/css/materialize.min.css" type="text/css" rel="stylesheet" />
      <link href="./assets/css/font-awesome.min.css" type="text/css" rel="stylesheet" />
      <link href="./assets/css/styles.css" type="text/css" rel="stylesheet" />
      <link rel="shortcut icon" type="image/x-icon" href="./assets/img/favicon.ico" />
      <?php
      if (!isset($_SESSION['kerjakan'])) {
         ?>
         <meta http-equiv="refresh" content="60;">
         <?php
      }
      ?>
      <style type="text/css">
         .card-image {
           width: 190px;
         }
         .btn {
           border-radius: 4px;
           height: 30px;
           line-height: 30px;
           padding: 0 1rem;
         }
         body {
           background-image: url(./assets/img/back.jpg);
         }
      </style>
      <noscript>
         <meta http-equiv="refresh" content="0;URL='../include/noscript.html'">
      </noscript>
   </head>

   <body class="green lighten-3">
      <header>
         <div class="navbar-fixed">
            <nav class="green">
               <div class="nav-wrapper">
                  <a href="./dashboard.php" class="brand-logo">
                    <img src="./assets/img/nav.png" class="logo">
                  </a>
                  <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="fa fa-bars"></i></a>
                  <ul id="nav-mobile" class="right hide-on-med-and-down">
                     <li><a href="./dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                     <li><a class="dropdown-button" href="#!" data-activates="dropdown1">
                        <i class="fa fa-graduation-cap"></i> Course<i class="fa fa-angle-double-down right"></i>
                     </a></li>
                     <ul id="dropdown1" class="dropdown-content">
                        <li><a href="./dashboard.php?page=jadwal"><i class="fa fa-calendar"></i> Jadwal</a></li>
                        <li><a href="./dashboard.php?page=materi"><i class="fa fa-list-alt"></i> Materi</a></li>
                        <li><a href="./dashboard.php?page=test"><i class="fa fa-file-text-o"></i> Test</a></li>
                        <li><a href="./dashboard.php?page=nilai"><i class="fa fa-file-text-o"></i> Nilai</a></li>
                     </ul>
                     <li><a href="./forum/"><i class="fa fa-comments"></i> Forum</a></li>
                     <li>
                        <a class="dropdown-button row" href="#!" data-activates="dropdown2">
                           <div class="col s3">
                              <img src="./assets/img/<?php echo $data['foto']; ?>" class="image">
                           </div>
                           <div class="col s9">
                              <?php echo $data['username']; ?><i class="fa fa-angle-double-down right"></i>
                           </div>
                        </a>
                     </li>
                  </ul>
                  <ul id="dropdown2" class="dropdown-content">
                     <li><a href="./dashboard.php?page=foto"><i class="fa fa-photo"></i> Ganti Foto Profil</a></li>
                     <li><a href="./dashboard.php?page=profil"><i class="fa fa-user"></i> Edit Profil</a></li>
                     <li><a href="./dashboard.php?page=pass"><i class="fa fa-key"></i> Ganti Password</a></li>
                     <li><a href="./dashboard.php?page=logout" onclick="return confirm('Yakin Ingin Keluar?')"><i class="fa fa-sign-out"></i> Logout</a></li>
                  </ul>
                  <ul class="side-nav" id="mobile-demo">
                     <li><a href="./dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                     <li><a href="./dashboard.php?page=jadwal"><i class="fa fa-calendar"></i> Jadwal</a></li>
                     <li><a href="./dashboard.php?page=materi"><i class="fa fa-list-alt"></i> Materi</a></li>
                     <li><a href="./dashboard.php?page=test"><i class="fa fa-file-text-o"></i> Test</a></li>
                     <li><a href="./dashboard.php?page=nilai"><i class="fa fa-file-text-o"></i> Nilai</a></li>
                     <li><a href="./forum/"><i class="fa fa-comments"></i> Forum</a></li>
                     <li><a href="./dashboard.php?page=foto"><i class="fa fa-photo"></i> Ganti Foto Profil</a></li>
                     <li><a href="./dashboard.php?page=profil"><i class="fa fa-user"></i> Edit Profil</a></li>
                     <li><a href="./dashboard.php?page=pass"><i class="fa fa-key"></i> Ganti Password</a></li>
                     <li><a href="./dashboard.php?page=logout" onclick="return confirm('Yakin Ingin Keluar?')"><i class="fa fa-sign-out"></i> Logout</a></li>
                  </ul>
               </div>
            </nav>
         </div>
      </header>

      <main>
         <div class="container">
            <div class="card z-depth-1">
               <div class="card-content">
                  <?php
                  if (empty($_REQUEST['page'])) {
                     include_once("./overview.php");
                  } else {
                     switch ($_REQUEST['page']) {
                        case 'pass':
                        include_once('./setting/pswd.php');
                        break;
                     case 'profil':
                        include_once('./setting/profil_siswa.php');
                        break;
                     case 'jadwal':
                        include_once('./jadwal.php');
                        break;
                     case 'materi':
                        include_once('./materi.php');
                        break;
                     case 'foto':
                        include_once('./setting/foto.php');
                        break;
                     case 'test':
                        include_once('./soal.php');
                        break;
                     case 'nilai':
                        include_once('./nilai.php');
                        break;
                     case 'logout':
                        mysqli_query($mysqli, "UPDATE t_siswa SET login_status = 'N' WHERE nis = '$_SESSION[id]'");
                        session_destroy();
                        header('location:./');
                        break;
                     }
                  }
                  ?>
               </div>
            </div>
         </div>
         <center><b><?php echo date('Y'); ?> &copy SMK Al-Husna Loceret</b></center>
      </main>

      <script type="text/javascript" src="./assets/js/jquery.js"></script>
      <script type="text/javascript" src="./assets/js/jquery_validator.js"></script>
      <script type="text/javascript" src="./assets/js/inid.js"></script>
      <script type="text/javascript" src="./assets/js/materialize.min.js"></script>
      <script type="text/javascript">
      $.validate({
        form : '#form'
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
   //kosongkan memori penyimpanan sementara hasil output
   ob_flush();
?>
