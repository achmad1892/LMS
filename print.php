<?php
   include_once('./include/connection.php');

   if (empty($_REQUEST['id']) || empty($_SESSION['type']) || $_SESSION['type'] != 3) {
      header('location:./');
   }
?>
<!DOCTYPE html>
<html>
   <head>
      <title>cetak nilai</title>
      <link href="./assets/css/materialize.min.css" type="text/css" rel="stylesheet" />
   </head>

   <body>
      <?php
      $id   = mysqli_real_escape_string($mysqli, $_REQUEST['id']);
      $data = mysqli_query($mysqli, "SELECT * FROM t_header_soal JOIN t_nilai ON t_header_soal.id_header = t_nilai.id_header WHERE nis = '$_SESSION[id]' && id_index = '$id'");

      $sql  = "SELECT * FROM t_siswa JOIN t_index_mapel ON t_index_mapel.id_kelas = t_siswa.id_kelas JOIN t_mapel ON t_index_mapel.id_mapel = t_mapel.id_mapel WHERE nis = '$_SESSION[id]' && id_index = '$id'";

      $nama = mysqli_fetch_array(mysqli_query($mysqli, $sql));
      ?>

      <div class="container">
         <center>
            <div class="row">
               <div class="col s2">
                  <img src="./assets/img/logo.png" width="83" height="100" />
               </div>
               <div class="col s8">
                  <h4>Daftar Nilai <?php echo $nama['nama_mapel']; ?></h4>
                  <h6><?php echo $nama['fullname']; ?></h6>
               </div>
            </div>
         </center>
         <br />
         <?php
         $i = 1;

         echo '<table class="bordered">';
         echo "<tr>";
         echo '<th width="70" class="center">NO</th>';
         echo '<th width="300" class="center">Topik Test</th>';
         echo '<th width="100" class="center">Tanggal Test</th>';
         echo '<th width="100" class="center">Nilai</th>';
         echo '<th width="150" class="center">Keterangan</th>';
         echo '</tr>';

         while ($key = mysqli_fetch_array($data)) {
            echo "<tr>";
            echo '<td width="70" class="center">'.$i++.'</td>';
            echo '<td class="center">'.$key['judul'].'</td>';
            echo '<td class="center">'.date("d M Y", strtotime($key['tgl'])).'</td>';
            echo '<td class="center">'.$key['nilai'].'</td>';
            echo '<td class="center">';
            if($key['nilai'] < 50) { echo "remidi"; }else{ echo "Lulus"; }
            echo '</td>';
            echo '</tr>';
         }
         echo "</table>";
         ?>
      </div>
      <script type="text/javascript">
         window.print();
      </script>
   </body>
</html>
