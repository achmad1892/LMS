<?php
   include_once('../include/connection.php');

   ob_start();

   if (empty($_SESSION['type'])){
      header('location:../');
   }

   if (!cek_login()) {
      if ($_SESSION['type'] == 3) {
         header('location:../dashboard.php?page=logout');
      } else {
         header('location:../administrator/dashboard.php?page=logout');
      }

   }
?>

<!DOCTYPE html>
<html>

   <head>
      <title>Forum E-Learning</title>
      <link href="../assets/css/materialize.min.css" type="text/css" rel="stylesheet" />
      <link href="../assets/css/styles.css" type="text/css" rel="stylesheet" />
      <link href="../assets/css/font-awesome.min.css" type="text/css" rel="stylesheet" />
      <link rel="shortcut icon" type="image/x-icon" href="../assets/img/favicon.ico" />
      <meta http-equiv="refresh" content="60">
      <style type="text/css">
         .back {
           background-color: transparent;
           border-style: none;
         }

         .back:hover {
           background-color: transparent;
         }

         .ukur {
           height: 64px !important;
         }

         body {
           background-image: url(../assets/img/back.jpg);
         }

         .back1 {
           background-color: #4caf50;
           border: 3px solid;
           border-color: #66bb6a #43a047 #43a047 #66bb6a;
           border-radius: 12px;
           color: #f1f6ef;
         }

         .back2 {
           background-color: #b0bec5;
           border: 3px solid;
           border-color: #cfd8dc #90a4ae #90a4ae #cfd8dc;
           border-radius: 12px;
         }

         .border {
           border: solid 2px #b0bec5;
         }

         .modal {
           width: 500px;
           z-index: 999;
           margin-top: 75px;
           background-color: rgba(255, 255, 255, 0.95);
         }
      </style>
      <noscript>
         <meta http-equiv="refresh" content="0;URL='../include/noscript.html'">
      </noscript>
   </head>

   <body class="green lighten-3">
      <?php
      include_once('../include/navbar.php');

      echo '<div class="container">'; //start container
      echo '<div class="card z-depth-1">'; //start card
      echo '<div class="card-content">'; //start card-content
      //cek $_REQUEST['page']
      if (isset($_REQUEST['page'])) {
         //alihkan berdasarkan value $_REQUEST['page']
         switch ($_REQUEST['page']) {
            case 'add':
               include_once('./input.php');
               break;
            case 'list':
               include_once('./list.php');
               break;
            case 'comment':
               include_once('./comment.php');
               break;
         } //end switch
      } else { //else $_REQUEST['page']
         include_once('./menu.php');
         $i = 1;
         echo '<table class="highlight">';
         echo '<tr>';
         echo '<th>No</th>';
         echo '<th>Judul</th>';
         echo '<th class="center">Tanggapan</th>';
         echo '<th class="center">Pengirim</th>';
         echo '<th>Tanggal Post</th>';
         echo '<th>Opsi</th>';
         echo '</tr>';
         //cek $_REQUEST['submit']
         if (isset($_REQUEST['submit'])) {
            if ($_REQUEST['search'] != '') { //cek $_REQUEST['search']
               switch ($_SESSION['type']) {
                  case '1':
                     $data = mysqli_query($mysqli, "SELECT * FROM t_forum WHERE judul LIKE '%$_REQUEST[search]%'");
                     break;
                  case '2':
                     $data = mysqli_query($mysqli, "SELECT * FROM t_forum JOIN t_index_mapel ON t_forum.id_index = t_index_mapel.id_index WHERE id_guru = '$_SESSION[id]' && judul LIKE '%$_REQUEST[search]%'");
                     break;
                  case '3':
                     $data = mysqli_query($mysqli, "SELECT * FROM t_forum JOIN t_index_mapel ON t_forum.id_index = t_index_mapel.id_index WHERE id_kelas = '$_SESSION[kelas]' && judul LIKE '%$_REQUEST[search]%'");
                     break;
               }

               if (mysqli_num_rows($data) > 0) {
                  while ($key = mysqli_fetch_array($data)) { //start looping
                     echo '<tr>';
                     echo '<td>'.$i++.'</td>';
                     echo '<td>'.$key['judul'].'</td>';
                     echo '<td class="center">';
                     echo mysqli_num_rows(mysqli_query($mysqli, "SELECT * FROM t_komentar WHERE id_forum = '$key[id_forum]'")).' <i class="fa fa-comment"></i>';
                     echo '</td>';
                     echo '<td class="center">';
                     $guru = mysqli_query($mysqli, "SELECT * FROM t_guru WHERE id_guru = '$key[user]'");

                     if (mysqli_num_rows($guru) > 0) {
                        $dat = mysqli_fetch_array($guru);
                        echo $dat['username'];
                     } else {
                        $dat = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM t_siswa WHERE nis = '$key[user]'"));
                        echo $dat['username'];
                     }
                     echo '</td>';
                     echo '<td>'.date("d M Y",strtotime($key['tgl_forum'])).'</td>';
                     echo '<td><a href="" class="btn-floating waves-effect waves-light green lighten-1"><i class="fa fa-commenting"></i><a></td>';
                     echo '</tr>';
                  } //end while
               } else {
                  echo '<tr>';
                  echo '<td colspan="5" class="center"><h5><i>"Judul Thread tidak ditemukan"</i></h5></td>';
                  echo '</tr>';
               }
            } else { //else $_REQUEST['search']
               switch ($_SESSION['type']) {
                  case '1':
                     $data = mysqli_query($mysqli, "SELECT * FROM t_forum");
                     break;
                  case '2':
                     $data = mysqli_query($mysqli, "SELECT * FROM t_forum JOIN t_index_mapel ON t_forum.id_index = t_index_mapel.id_index WHERE id_guru = '$_SESSION[id]'");
                     break;
                  case '3':
                     $data = mysqli_query($mysqli, "SELECT * FROM t_forum JOIN t_index_mapel ON t_forum.id_index = t_index_mapel.id_index WHERE id_kelas = '$_SESSION[kelas]'");
                     break;
               }

               if (mysqli_num_rows($data)> 0) {
                  while ($key = mysqli_fetch_array($data)) { //start foreach
                     echo '<tr>';
                     echo '<td>'.$i++.'</td>';
                     echo '<td>'.$key['judul'].'</td>';
                     echo '<td class="center">';
                     $sql = "SELECT * FROM t_komentar WHERE id_forum = '$key[id_forum]'";
                     echo mysqli_num_rows(mysqli_query($mysqli, $sql)).' <i class="fa fa-comment"></i>';
                     echo '</td>';
                     echo '<td class="center">';
                     $guru = mysqli_query($mysqli, "SELECT * FROM t_guru WHERE id_guru = '$key[user]'");

                     if (mysqli_num_rows($guru) > 0) {
                        $dat = mysqli_fetch_array($guru);
                        echo $dat['username'];
                     } else {
                        $dat = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM t_siswa WHERE nis = '$key[user]'"));
                        echo $dat['username'];
                     }
                     echo '</td>';
                     echo '<td>'.date("d M Y",strtotime($key['tgl_forum'])).'</td>';
                     echo '<td><a href="./index.php?page=comment&id='.$key['id_forum'].'" class="btn-floating waves-effect waves-light green lighten-1"><i class="fa fa-commenting"></i><a></td>';
                     echo '</tr>';
                  } //end while
               } else {
                  echo '<tr>';
                  echo '<td colspan="5" class="center"><h5><i>"Belum Ada Thread"</i></h5></td>';
                  echo '</tr>';
               }
            } //end $_REQUEST['search']

         } else { //else $_REQUEST['submit']
            switch ($_SESSION['type']) {
               case '1':
                  $data = mysqli_query($mysqli, "SELECT * FROM t_forum");
                  break;
               case '2':
                  $data = mysqli_query($mysqli, "SELECT * FROM t_forum JOIN t_index_mapel ON t_forum.id_index = t_index_mapel.id_index WHERE id_guru = '$_SESSION[id]'");
                  break;
               case '3':
                  $data = mysqli_query($mysqli, "SELECT * FROM t_forum JOIN t_index_mapel ON t_forum.id_index = t_index_mapel.id_index WHERE id_kelas = '$_SESSION[kelas]'");
                  break;
            }
            if (mysqli_num_rows($data) > 0) {
               while ($key = mysqli_fetch_array($data)) { //start foreach
                  echo '<tr>';
                  echo '<td>'.$i++.'</td>';
                  echo '<td>'.$key['judul'].'</td>';
                  echo '<td class="center">';
                  $sql = "SELECT * FROM t_komentar WHERE id_forum = '$key[id_forum]'";
                  echo mysqli_num_rows(mysqli_query($mysqli, $sql)).' <i class="fa fa-comment"></i>';
                  echo '</td>';
                  echo '<td class="center">';
                  $guru = mysqli_query($mysqli, "SELECT * FROM t_guru WHERE id_guru = '$key[user]'");
                  if (mysqli_num_rows($guru) > 0) {
                     $dat = mysqli_fetch_array($guru);
                     echo $dat['username'];
                  } elseif (mysqli_num_rows(mysqli_query($mysqli, "SELECT * FROM t_siswa WHERE nis = '$key[user]'")) > 0) {
                     $dat = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM t_siswa WHERE nis = '$key[user]'"));
                     echo $dat['username'];
                  } else {
                     $dat = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM t_admin WHERE id_admin = '$key[user]'"));
                     echo $dat['username'];
                  }
                  echo '</td>';
                  echo '<td>'.date("d M Y",strtotime($key['tgl_forum'])).'</td>';
                  echo '<td><a href="./index.php?page=comment&id='.$key['id_forum'].'" class="btn-floating waves-effect waves-light green lighten-1"><i class="fa fa-commenting"></i><a></td>';
                  echo '</tr>';
               } //end while
            } else {
               echo '<tr>';
               echo '<td colspan="6" class="center"><h5><i>"Belum Ada Thread"</i></h5></td>';
               echo '</tr>';
            }
         } //end else $_REQUEST['submit']
         echo "</table>";
      } //end $_REQUEST['page']
      echo '</div>'; //end card-content
      echo '</div>'; //end card
      echo '<center><b>'.date('Y').' &copy SMK Al-Husna Loceret</b></center>';
      echo '</div>'; //end container
      ?>

      <script type="text/javascript" src="../assets/js/jquery.js"></script>
      <script type="text/javascript" src="../assets/js/inid.js"></script>
      <script type="text/javascript" src="../assets/js/materialize.min.js"></script>
      <script type="text/javascript" src="../assets/plugin/ckeditor/ckeditor.js"></script>
      <script type="text/javascript" src="../assets/plugin/ckeditor/style.js"></script>
      <script type="text/javascript">
      $(document).ready(function() {
        $('select').material_select();
      });
      </script>
   </body>

</html>
<?php
  ob_flush();
?>
