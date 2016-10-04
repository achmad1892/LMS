<?php

   if (empty($_SESSION['type']) || $_SESSION['type'] != 3) {
      header('location:./');
   }

   echo '<div class="card z-depth-1">';
   echo '<div class="card-content">';
      if (isset($_REQUEST['test'])) {
         $dat = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM t_header_soal WHERE id_header = '$_REQUEST[test]'"));

         echo '<h4>Informasi Pengerjaan!</h4>';
         echo '<li>Waktu Pengerjaan '.($dat['waktu'] / 60).' menit </li>';
         echo '<li>Pastikan Koneksi Anda Stabil</li>';
         echo '<li>Jika Koneksi terputus hubungi Pengajar agar bisa mengerjakan test kembali</li>';
         echo "<br />";
         echo '<a href="./dashboard.php?page=test&id='.$dat['id_index'].'" class="btn red lighten-1">Kembali</a>&nbsp;';
         echo '<a href="./kerjakan.php?id='.$dat['id_header'].'&hlm=1" class="btn green lighten-1">Kerjakan</a>';
      } else {

         echo '<h4>Daftar Test</h4>';
         echo '<br />';

         echo '<table>';
         if (!isset($_REQUEST['id'])) { //jika variabel $_REQUEST['mapel'] tidak bernilai tampilkan daftar mapel
            echo "<tr>";
            echo '<th width="60" class="center">NO</th>';
            echo '<th class="center">Mata Pelajaran</th>';
            echo '<th class="center">Jumlah</th>';
            echo '<th width="150" class="center">Opsi</th>';
            echo "</tr>";

            $sql  = "SELECT * FROM t_index_mapel JOIN t_mapel ON t_index_mapel.id_mapel = t_mapel.id_mapel WHERE id_kelas = '$data[id_kelas]'";

            $data = mysqli_query($mysqli, $sql);
            $i = 1;

            while ($key = mysqli_fetch_array($data)) { //start while mapel
               echo "<tr>";
               echo '<td class="center">'.$i++.'</td>';
               echo '<td class="center">'.$key['nama_mapel'].'</td>';
               echo '<td class="center">';
               echo mysqli_num_rows(mysqli_query($mysqli, "SELECT * FROM t_header_soal WHERE id_index = '$key[id_index]' && publikasi = 'Y'"));
               echo '</td>';
               echo '<td class="center">';
               echo '<a href="./dashboard.php?page=test&id='.$key['id_index'].'" class="btn waves-effect waves-light right green lighten-1"><i class="fa fa-list"></i> List</a>';
               echo '</td>';
               echo "</tr>";
            } //end while mapel
            echo '<tr><td colspan="5">';
            echo '<a href="./dashboard.php" class="btn waves-effect waves-light right red lighten-1">';
            echo '<i class="fa fa-arrow-left"></i> Kembali';
            echo '</a>';
            echo '</td></tr>';
         } else { // jika variabel $_REQUEST['mapel'] bernilai maka tampilkan daftar materi tiap mapel
            $sql = "SELECT * FROM t_header_soal WHERE id_index = '$_REQUEST[id]' && publikasi = 'Y'";
            if (mysqli_num_rows(mysqli_query($mysqli, $sql)) <= 0) { //hitung materi per mapel, jika berjumlah <= 0 munculkan pesan
               echo '<h4><i>"Belum Ada Test / Quiz pada Mata Pelajaran Ini!"</i></h4>';
               echo '<button onclick=self.history.back() class="btn waves-effect waves-light right red lighten-1">';
               echo '<i class="fa fa-arrow-left"></i> Kembali';
               echo '</button>';
            } else { //jika lebih dari 0 tampilkan daftar test per mapel
               echo "<tr>";
               echo '<th width="60" class="center">NO</th>';
               echo '<th class="center">Judul Test</th>';
               echo '<th class="center">Tanggal Dibuat</th>';
               echo '<th class="center">Waktu</th>';
               echo '<th width="200" class="center">Opsi</th>';
               echo "</tr>";

               $data = mysqli_query($mysqli, "SELECT * FROM t_header_soal WHERE id_index = '$_REQUEST[id]' && publikasi = 'Y'");
               $i = 1;

               while ($key = mysqli_fetch_array($data)) { //start while judul soal
                  echo "<tr>";
                  echo '<td class="center">'.$i++.'</td>';
                  echo '<td class="pad">'.$key['judul'].'</td>';
                  echo '<td class="center">'.date("d M Y", strtotime($key['tgl_dibuat'])).'</td>';
                  echo '<td class="center">'.($key['waktu'] / 60).' menit</td>';
                  echo '<td class="center">';

                  $hitung = mysqli_query($mysqli, "SELECT * FROM t_nilai WHERE nis = '$_SESSION[id]' && id_header = '$key[id_header]'");

                  if (mysqli_num_rows($hitung) > 0) {
                     echo "Telah Dikerjakan";
                  } else {
                     echo '<a href="./dashboard.php?page=test&test='.$key['id_header'].'" class="btn waves-effect waves-light green lighten-1">';
                     echo '<i class="fa fa-pencil left"></i> Kerjakan';
                     echo '</a>';
                  }
                  echo '</td>';
                  echo "</tr>";
               } //end while soal

               echo '<tr><td colspan="5">';
               echo '<a href="./dashboard.php?page=test" class="btn waves-effect waves-light right red lighten-1">';
               echo '<i class="fa fa-arrow-left"></i> Kembali';
               echo '</a>';
               echo '</td></tr>';
            }
         }
         echo '</table>';
      }
      echo '</div>';
      echo '</div>';
?>
