<?php

   if (empty($_SESSION['type']) || $_SESSION['type'] == 3) {
      header('location:./');
   }

   if (isset($_REQUEST['aksi'])) { //jika variabel $_REQUEST['aksi'] mempunyai nilai
      //alihkan berdasarkan value $_REQUEST['aksi']
      switch ($_REQUEST['aksi']) {
         case 'add':
            include_once('add_materi.php');
            break;
         case 'delete':
            mysqli_query($mysqli, "DELETE FROM t_materi WHERE id_materi = '$_REQUEST[id]'");
            unlink("../assets/materi/".$_REQUEST['mat']);
            header('location:?page=materi&mapel='.$_REQUEST['mapel']);
            break;
      } //end switch

   } else { //jika tidak mempunyai nilai eksekusi code dibawah
      if (isset($_REQUEST['view'])) {
         include_once('./guru/list.php');
      } else {
         if ($_SESSION['type'] == 2 && isset($_REQUEST['mapel'])) {
            echo '<a href="?page=materi&aksi=add" class="btn waves-effect waves-light right blue lighten-1">';
            echo '<i class="fa fa-plus"></i> Tambah Materi';
            echo '</a>';
         }
?>
   <h4>Daftar Materi</h4>
   <br />
   <table>
      <?php
      if (!isset($_REQUEST['mapel'])) { //jika variabel $_REQUEST['mapel'] tidak bernilai tampilkan daftar mapel
         echo "<tr>";
         echo '<th width="60" class="center">NO</th>';
         echo '<th class="center">Mata Pelajaran</th>';
         echo '<th class="center">Kelas</th>';
         echo '<th class="center">Jumlah</th>';
         echo '<th width="150" class="center">Opsi</th>';
         echo "</tr>";

         if ($_SESSION['type'] == 2) {
            $sql = "SELECT * FROM t_index_mapel JOIN t_mapel ON t_index_mapel.id_mapel = t_mapel.id_mapel JOIN t_kelas ON t_index_mapel.id_kelas = t_kelas.id_kelas WHERE t_index_mapel.id_guru = '$_SESSION[id]'";
         } else {
            $sql = "SELECT * FROM t_index_mapel JOIN t_mapel ON t_index_mapel.id_mapel = t_mapel.id_mapel JOIN t_kelas ON t_index_mapel.id_kelas = t_kelas.id_kelas";
         }

         $data = mysqli_query($mysqli, $sql);
         $i = 1;

         while ($key = mysqli_fetch_array($data)) { //start while mapel
            echo "<tr>";
            echo '<td class="center">'.$i++.'</td>';
            echo '<td class="pad">'.$key['nama_mapel'].'</td>';
            echo '<td class="center">'.$key['nama_kelas'].'</td>';
            echo '<td class="center">';
            echo mysqli_num_rows(mysqli_query($mysqli, "SELECT * FROM t_materi WHERE id_mapel = '$key[id_mapel]' && id_kelas = '$key[id_kelas]'"));
            echo '</td>';
            echo '<td class="center">
                  <a href="?page=materi&mapel='.$key['id_mapel'].'&kelas='.$key['id_kelas'].'" class="btn waves-effect waves-light right green lighten-1">
                     <i class="fa fa-eye"></i> Lihat
                  </a>
               </td>';
            echo "</tr>";
         } //end while mapel

      } else { // jika variabel $_REQUEST['mapel'] bernilai maka tampilkan daftar materi tiap mapel

         $mapel  = mysqli_real_escape_string($mysqli, $_REQUEST['mapel']);
         $kelas  = mysqli_real_escape_string($mysqli, $_REQUEST['kelas']);
         //hitung materi per mapel, jika berjumlah <= 0 munculkan pesan
         $materi = mysqli_query($mysqli, "SELECT * FROM t_materi WHERE id_mapel = '$mapel' && id_kelas = '$kelas'");
         if (mysqli_num_rows($materi) <= 0) {
            echo '<h4><i>"Belum Ada Materi pada Mata Pelajaran Ini!"</i></h4>';
            echo '<button onclick=self.history.back() class="btn waves-effect waves-light right red lighten-1">
               <i class="fa fa-arrow-left"></i> Kembali
            </button>';
         } else { //jika lebih dari 0 tampilkan daftar materi per mapel
            echo "<tr>";
            echo '<th width="60" class="center">NO</th>';
            echo '<th class="center">Judul Materi</th>';
            echo '<th class="center">Diakses Oleh</th>';
            echo '<th width="150" class="center">Opsi</th>';
            echo "</tr>";

            $i = 1;

            while ($key = mysqli_fetch_array($materi)) { //start while materi
               if ($key['download'] != '') {
                  $download = count(explode(',', $key['download']));
               } else {
                 $download = 0;
               }

               echo "<tr>";
               echo '<td class="center">'.$i++.'</td>';
               echo '<td class="pad">'.$key['judul_mat'].'</td>';
               echo '<td class="center"><a href="?page=materi&view='.$key['id_materi'].'">'.$download.' orang</a></td>';
               echo '<td class="center">';
               ?>
               <a href="../assets/materi/<?php echo $key['judul_mat']; ?>" class="btn-floating waves-effect waves-light green lighten-1">
                  <i class="fa fa-download"></i>
               </a>
               &nbsp; <!-- hanya spasi -->
               <a href="?page=materi&mapel=<?php echo $key['id_index']; ?>&aksi=delete&id=<?php echo $key['id_materi']; ?>&mat=<?php echo $key['judul_mat']; ?>" class="btn-floating waves-effect waves-light red lighten-1" onclick="return confirm('Yakin Ingin Mengahapus data ini?')">
                  <i class="fa fa-trash"></i>
               </a>
               <?php
               echo '</td>';
               echo "</tr>";
            } //end while materi
            echo "<tr><td></td></tr>";
            echo '<tr><td colspan="4">';
            echo '<a href="?page=materi" class="btn waves-effect waves-light right red lighten-1">';
            echo '<i class="fa fa-arrow-left"></i> Kembali';
            echo '</a>';
            echo '</td></tr>';
         } //end else hitung materi

      } //end !isset mapel
      echo '</table>';
      } //end if
   }
?>
