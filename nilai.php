<?php

   if($_SESSION['type'] != 3 || empty($_SESSION['type'])){
      header('location:./');
   }

   echo '<table>';

   if(empty($_REQUEST['id_mapel'])){
      echo "<tr>";
      echo '<th width="70" class="center">NO</th>';
      echo '<th width="200">Mata Pelajaran</th>';
      echo '<th width="150">Opsi</th>';
      echo '</tr>';

      $i   = 1;
      $sql = mysqli_query($mysqli, "SELECT * FROM t_index_mapel JOIN t_mapel ON t_index_mapel.id_mapel = t_mapel.id_mapel WHERE id_kelas = '$data[id_kelas]'");

      while ($key = mysqli_fetch_array($sql)) {
         echo "<tr>";
         echo '<td width="60" class="center">'.$i++.'</td>';
         echo '<td>'.$key['nama_mapel'].'</td>';
         echo '<td>';
         echo '<a href="?page=nilai&id_mapel='.$key['id_index'].'" class="btn waves-effect waves-light green lighten-1">Lihat Nilai</a>';
         echo '</td>';
         echo '</tr>';
      }

   } else {
      $id   = mysqli_real_escape_string($mysqli, $_REQUEST['id_mapel']);
      $sql  = "SELECT * FROM t_header_soal JOIN t_nilai ON t_header_soal.id_header = t_nilai.id_header WHERE nis = '$_SESSION[id]' && id_index = '$id'";
      $data = mysqli_query($mysqli, $sql);
      $i = 1;

      if (mysqli_num_rows(mysqli_query($mysqli, $sql)) > 0) {
         echo '<a href="./print.php?id='.$_REQUEST['id_mapel'].'" target="_blank" class="btn waves-effect waves-light blue lighten-1 right"><i class="fa fa-print"></i></a>';
      }
      echo "<tr>";
      echo '<th width="70" class="center">NO</th>';
      echo '<th width="300">Topik Test</th>';
      echo '<th width="100">Tanggal Test</th>';
      echo '<th width="100">Nilai</th>';
      echo '<th width="150">Keterangan</th>';
      echo '</tr>';

      if (mysqli_num_rows(mysqli_query($mysqli, $sql)) <= 0) {
         echo "<tr>";
         echo '<td colspan="5" class="center"><h4>"Belum Ada Nilai"</h4></td>';
         echo "</tr>";
      } else {
         while ($key = mysqli_fetch_array($data)) {
            echo "<tr>";
            echo '<td width="70" class="center">'.$i++.'</td>';
            echo '<td>'.$key['judul'].'</td>';
            echo '<td>'.date("d M Y", strtotime($key['tgl'])).'</td>';
            echo '<td>'.$key['nilai'].'</td>';
            echo '<td>';
            if($key['nilai'] < 70) { echo "remidi"; }else{ echo "Lulus"; }
            echo '</td>';
            echo '</tr>';
         }
      }
   }
   echo '</table>';
   if (isset($_REQUEST['id_mapel'])) {
      echo '<a href="?page=nilai" class="btn waves-light waves-effect red"><i class="fa fa-arrow-left"></i> Kembali</a>';
   } else {
      echo '<a href="./" class="btn waves-light waves-effect red"><i class="fa fa-arrow-left"></i> Kembali</a>';
   }
?>
