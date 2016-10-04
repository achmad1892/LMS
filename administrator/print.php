<?php

   include_once('../include/connection.php');

   if (empty($_REQUEST['list']) || empty($_SESSION['type']) || $_SESSION['type'] != 2) {
      header('location:./');
   }

?>

<!DOCTYPE html>
<html>

   <head>
      <title>cetak nilai</title>
      <link href="../assets/css/materialize.min.css" type="text/css" rel="stylesheet" />
      <style type="text/css">
         tr td {
           padding-top: 3px;
           padding-bottom: 3px;
           border: 1px solid black;
         }

         tr th {
           padding-top: 5px;
           padding-bottom: 5px;
           border: 1px solid black;
           background-color: #b9b9b9;
         }
      </style>
   </head>

   <body>

      <?php
      $sql  = "SELECT * FROM t_header_soal JOIN t_nilai ON t_header_soal.id_header = t_nilai.id_header JOIN t_index_mapel ON t_header_soal.id_index = t_index_mapel.id_index JOIN t_mapel ON t_index_mapel.id_mapel = t_mapel.id_mapel JOIN t_siswa ON t_nilai.nis = t_siswa.nis WHERE t_nilai.id_header = '$_REQUEST[list]' ORDER BY t_siswa.nis ASC";

      $data = mysqli_query($mysqli, $sql);
      $head = mysqli_fetch_array(mysqli_query($mysqli, $sql));
      ?>
      <!-- start container -->
      <div class="container">

         <center>
            <div class="row"> <!-- start row -->
               <div class="col s3">
                  <img src="../assets/img/logo.png" width="86" height="100" />
               </div>
               <div class="col s6">
                  <h4>SMK AL-HUSNA</h4>
                  <p>Loceret - Nganjuk</p>
               </div>
            </div> <!-- end row -->
         </center>

         <h6>Mata Pelajaran : <?php echo $head['nama_mapel']; ?></h6>
         <h7><b><i>Daftar Nilai : <?php echo $head['judul']; ?></i></b></h7>
         <br />
         <br />
         <?php
         $i = 1;

         echo '<table class="bordered">';
         echo "<tr>";
         echo '<th width="70" class="center">NO</th>';
         echo '<th width="500" class="center">Nama Siswa</th>';
         echo '<th width="100" class="center">Nilai</th>';
         echo '<th width="150" class="center">Keterangan</th>';
         echo '</tr>';

         while ($key = mysqli_fetch_array($data)) {
            echo "<tr>";
            echo '<td class="center">'.$i++.'</td>';
            echo '<td class="center">'.$key['fullname'].'</td>';
            echo '<td class="center">'.$key['nilai'].'</td>';
            echo '<td class="center">';
               if ($key['nilai'] < 50) { echo "remidi"; } else { echo "Lulus"; }
            echo '</td>';
            echo '</tr>';
         }
         echo "</table>";
         ?>

      </div> <!-- end container -->
      <script type="text/javascript">
         window.print();
      </script>
   </body>

</html>
