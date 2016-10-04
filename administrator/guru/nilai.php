<?php

   if (empty($_SESSION['type']) || $_SESSION['type'] != 2) {
      header("location:./");
   }
   //cek variabel $_REQUEST['hapus']
   if (isset($_REQUEST['hapus'])) {
      $list  = mysqli_real_escape_string($mysqli, $_REQUEST['list']);
      $hapus = mysqli_real_escape_string($mysqli, $_REQUEST['hapus']);

      mysqli_query($mysqli, "DELETE FROM t_nilai WHERE nis = '$hapus'");
      header('location:?page=nilai&list='.$list);
   }

   if (isset($_REQUEST['list'])) { //list nilai
      $sql  = "SELECT * FROM t_index_mapel JOIN t_header_soal ON t_index_mapel.id_index = t_header_soal.id_index JOIN t_nilai ON t_header_soal.id_header = t_nilai.id_header JOIN t_mapel ON t_index_mapel.id_mapel = t_mapel.id_mapel WHERE t_nilai.id_header= '$_REQUEST[list]'";
      $data = mysqli_query($mysqli, $sql);

      if (mysqli_num_rows($data) > 0) {
         $i     = 1;
         $hasil = mysqli_fetch_array($data);

         echo '<a href="./print.php?list='.$_REQUEST['list'].'" target="_blank" class="btn waves-effect waves-light blue lighten-1 right"><i class="fa fa-print"></i></a>';
         echo '<h5>Mata Pelajaran : '.$hasil['nama_mapel'].'</h5>';
         echo '<h6>Judul Test : '.$hasil['judul'].'</h6>';
         echo '<br />';
      } else {
         ?>
         <script type="text/javascript">alert('Belum Ada Nilai');window.history.go(-1);</script>
         <?php
      }
   }

   echo '<table class="striped">';
   //cek variabel $_REQUEST['mapel'] untuk daftar test yang sudah dibuat
   if (isset($_REQUEST['mapel'])) {
      $sql  = "SELECT * FROM t_index_mapel JOIN t_header_soal ON t_index_mapel.id_index = t_header_soal.id_index WHERE id_mapel= '$_REQUEST[mapel]'";
      $data = mysqli_query($mysqli, $sql);
      $i    = 1;

      echo '<thead>';
      echo '<tr>';
      echo '<th width="30px" class="center">No</th>';
      echo '<th width="400px" class="center">Mata Pelajaran</th>';
      echo '<th class="center">Opsi</th>';
      echo '</tr>';
      echo '</thead>';

      echo '<tbody>';
      if (mysqli_num_rows($data) > 0) {
         while ($key = mysqli_fetch_array($data)) {
            echo '<tr>';
            echo '<td class="center">'.$i++.'</td>';
            echo '<td class="center">'.$key['judul'].'</td>';
            echo '<td class="center"><a href="?page=nilai&list='.$key['id_header'].'" class="btn">Lihat Nilai</a></td>';
            echo '</tr>';
         }
      } else {
         echo '<tr>';
         echo '<td class="center" colspan="3"><h5>Belum Ada Test</h5></td>';
         echo '</tr>';
      }
      echo '</tbody>';
   } elseif (isset($_REQUEST['list'])) { //list nilai
      echo '<thead>';
      echo '<tr>';
      echo '<th width="30px" class="center">No</th>';
      echo '<th width="500px" class="center">Nama Siswa</th>';
      echo '<th class="center">Nilai</th>';
      echo '<th class="center">Opsi</th>';
      echo '</tr>';
      echo '</thead>';

      echo '<tbody>';
      $sql  = "SELECT * FROM t_index_mapel JOIN t_header_soal ON t_index_mapel.id_index = t_header_soal.id_index JOIN t_nilai ON t_header_soal.id_header = t_nilai.id_header JOIN t_siswa ON t_nilai.nis = t_siswa.nis JOIN t_mapel ON t_index_mapel.id_mapel = t_mapel.id_mapel WHERE t_nilai.id_header= '$_REQUEST[list]' ORDER BY t_nilai.nis ASC";

      $data = mysqli_query($mysqli, $sql);
      while ($key = mysqli_fetch_array($data)) {
         echo '<tr>';
         echo '<td class="center">'.$i++.'</td>';
         echo '<td class="center">'.$key['fullname'].'</td>';
         echo '<td class="center">'.$key['nilai'].'</td>';
         ?>
         <td class="center">
            <a href="?page=nilai&list=<?php echo $key['id_header']; ?>&hapus=<?php echo $key['nis']; ?>" class="btn waves-effect waves-light red" onclick="return confirm('Yakin Ingin Menghapus data ini ?')">Hapus Nilai</a>
         </td>
         <?php
         echo '</tr>';
      }
      echo '<tbody>';
   } else {
      //daftar mapel per guru
      $sql  = "SELECT * FROM t_index_mapel JOIN t_mapel ON t_index_mapel.id_mapel = t_mapel.id_mapel WHERE id_guru = '$_SESSION[id]'";

      $data = mysqli_query($mysqli, $sql);
      $i    = 1;

      echo '<thead>';
      echo '<tr>';
      echo '<th width="30px" class="center">No</th>';
      echo '<th width="400px" class="center">Mata Pelajaran</th>';
      echo '<th class="center">Opsi</th>';
      echo '</tr>';
      echo '</thead>';

      echo '<tbody>';
      while ($key = mysqli_fetch_array($data)) {
         echo '<tr>';
         echo '<td class="center">'.$i++.'</td>';
         echo '<td class="center">'.$key['nama_mapel'].'</td>';
         echo '<td class="center"><a href="?page=nilai&mapel='.$key['id_mapel'].'" class="btn">Lihat Test</a></td>';
         echo '</tr>';
      }
      echo '</tbody>';
   }
   echo '</table>';

   if (isset($_REQUEST['list']) || isset($_REQUEST['mapel'])) {
      echo '<br />';
      echo '<a href="?page=nilai" class="btn waves-effect waves-light red"><i class="fa fa-arrow-left"></i> Kembali</a>';
   }
?>
