<?php

   if (empty($_SESSION['type']) || $_SESSION['type'] != 3) {
      header('location:./');
   }

   if (isset($_REQUEST['view'])) {
      include_once('./administrator/guru/list.php');
   } elseif (isset($_REQUEST['baca'])) {
      $id    = mysqli_real_escape_string($mysqli, $_REQUEST['baca']);
      $pilih = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM t_materi WHERE id_materi = '$id'"));

      if ($pilih['download'] != '') {
         $cek_array = explode(',', $pilih['download']);
         if (!in_array(($_SESSION['id']), $cek_array)) {
            $akses = $pilih['download'].','.$_SESSION['id'];
            mysqli_query($mysqli, "UPDATE t_materi SET download = '$akses' WHERE id_materi = '$id'");
         }
      } else {
         mysqli_query($mysqli, "UPDATE t_materi SET download = '$_SESSION[id]' WHERE id_materi = '$id'");
      }

      header('location:./assets/materi/'.$pilih['judul_mat']);
   } else {

?>

   <div class="card z-depth-1">
      <div class="card-content">
         <h4>Daftar Materi</h4>
         <br />
         <table>
            <?php
            if (!isset($_REQUEST['mapel'])) { //jika variabel $_REQUEST['mapel'] tidak bernilai tampilkan daftar mapel
               echo "<tr>";
               echo '<th width="60" class="center">NO</th>';
               echo '<th class="center">Mata Pelajaran</th>';
               echo '<th class="center">Pengajar</th>';
               echo '<th class="center">Jumlah</th>';
               echo '<th width="150" class="center">Opsi</th>';
               echo "</tr>";

               $sql  = "SELECT * FROM t_index_mapel JOIN t_mapel ON t_index_mapel.id_mapel = t_mapel.id_mapel JOIN t_guru ON t_index_mapel.id_guru = t_guru.id_guru WHERE id_kelas = '$data[id_kelas]'";
               $data = mysqli_query($mysqli, $sql);
               $i    = 1;

               while ($key = mysqli_fetch_array($data)) { //start while mapel
                  echo "<tr>";
                  echo '<td class="center">'.$i++.'</td>';
                  echo '<td class="center">'.$key['nama_mapel'].'</td>';
                  echo '<td class="center">'.$key['fullname'].'</td>';
                  echo '<td class="center">';
                  echo mysqli_num_rows(mysqli_query($mysqli, "SELECT * FROM t_materi WHERE id_mapel = '$key[id_mapel]' && id_kelas = '$key[id_kelas]'"));
                  echo '</td>';
                  echo '<td class="center">';
                  echo '<a href="./dashboard.php?page=materi&mapel='.$key['id_mapel'].'" class="btn waves-effect waves-light right green lighten-1">List Materi</a>';
                  echo '</td>';
                  echo "</tr>";
               } //end while mapel
            } else { // jika variabel $_REQUEST['id'] bernilai maka tampilkan daftar materi tiap mapel
               $mapel = mysqli_query($mysqli, "SELECT * FROM t_materi WHERE id_mapel = '$_REQUEST[mapel]' && id_kelas = '$_SESSION[kelas]'");
               if (mysqli_num_rows($mapel) <= 0) { //hitung materi per mapel, jika berjumlah <= 0 munculkan pesan
                  echo '<h4><i>"Belum Ada Materi pada Mata Pelajaran Ini!"</i></h4>';
                  echo '<button onclick=self.history.back() class="btn waves-effect waves-light right red lighten-1">';
                  echo '<i class="fa fa-arrow-left"></i> Kembali';
                  echo '</button>';
               } else { //jika lebih dari 0 tampilkan daftar materi per mapel
                  echo "<tr>";
                  echo '<th width="60" class="center">NO</th>';
                  echo '<th class="center">Judul Materi</th>';
                  echo '<th class="center">Diakses</th>';
                  echo '<th width="150" class="center">Opsi</th>';
                  echo "</tr>";

                  $data = mysqli_query($mysqli, "SELECT * FROM t_materi WHERE id_mapel = '$_REQUEST[mapel]' && id_kelas = '$_SESSION[kelas]'");
                  $i = 1;

                  while ($key = mysqli_fetch_array($data)) { //start foreach materi
                     if ($key['download'] != '') {
                        $download = count(explode(',',$key['download']));
                     } else {
                        $download = 0;
                     }
                     echo "<tr>";
                     echo '<td class="center">'.$i++.'</td>';
                     echo '<td class="pad">'.$key['judul_mat'].'</td>';
                     echo '<td class="center"><a href="?page=materi&view='.$key['id_materi'].'">'.$download.' Orang</a></td>';
                     echo '<td class="center">';

                     $x    = explode('.', $key['judul_mat']);
                     $ext  = strtolower(end($x));

                     if ($ext == 'pdf') {
                        ?>
                        <a href="?page=materi&baca=<?php echo $key['id_materi'];?>" class="btn-floating waves-effect waves-light blue lighten-1">
                           <i class="fa fa-eye"></i>
                        </a>
                        <?php
                     }
                     ?>
                     <a href="./down.php?id=<?php echo $key['id_materi'];?>" class="btn-floating waves-effect waves-light green lighten-1">
                        <i class="fa fa-download"></i>
                     </a>
                     <?php
                     echo '</td>';
                     echo "</tr>";
                  } //end while materi

                  echo '<tr><td colspan="4">';
                  echo '<a href="./dashboard.php?page=materi" class="btn waves-effect waves-light right red lighten-1"><i class="fa fa-arrow-left"></i> Kembali</a>';
                  echo '</td></tr>';
               }
            }
            ?>
         </table>
      </div>
   </div>
   <?php
   }
?>
