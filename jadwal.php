<?php

   if (empty($_SESSION['type']) || $_SESSION['type'] != 3) {
      header('location:./');
   }

   echo '<div class="card z-depth-1">';
   echo '<div class="card-content">';
   if (isset($_REQUEST['hlm'])) {
      $hlm = $_REQUEST['hlm'];
   } else {
      $hlm = 1;
   }
?>
   <h4>Jadwal Mata Pelajaran</h4>
   <br />

   <table class="striped">
      <thead>
         <tr>
            <th width="40" class="center">No</th>
            <th width="150" class="center">Nama Mapel</th>
            <th width="200" class="center">Pengajar</th>
            <th width="200" class="center">Jumlah Materi</th>
            <th width="120" class="center">Opsi</th>
         </tr>
      </thead>

      <tbody>
         <?php
         $no = 1;
         $start = ($hlm - 1) * 5;

         $sql   = "SELECT * FROM t_index_mapel JOIN t_mapel ON t_mapel.id_mapel = t_index_mapel.id_mapel JOIN t_guru ON t_index_mapel.id_guru = t_guru.id_guru WHERE id_kelas = '$data[id_kelas]' LIMIT $start, 5";

         $row = mysqli_query($mysqli, $sql);
         $jml = mysqli_num_rows(mysqli_query($mysqli, "SELECT * FROM t_index_mapel"));

         if ($jml <= 0) {
            echo '<tr><td colspan="5" class="center"><i>BELUM ADA JADWAL</i></td></tr>';
         } else {
            while ($data = mysqli_fetch_array($row)) {
               ?>

               <tr>
                  <td class="center"><?php echo $no++; ?></td>
                  <td class="center"><?php echo $data['nama_mapel']; ?></td>
                  <td class="center"><?php echo $data['fullname']; ?></td>
                  <td class="center">
                     <?php
                     $jumlah = mysqli_query($mysqli, "SELECT * FROM t_materi JOIN t_guru ON t_materi.id_guru = t_guru.id_guru JOIN t_kelas ON t_materi.id_kelas = t_kelas.id_kelas JOIN t_mapel ON t_materi.id_mapel = t_mapel.id_mapel WHERE t_materi.id_guru = '$data[id_guru]' && t_materi.id_mapel = '$data[id_mapel]'");
                     echo mysqli_num_rows($jumlah);
                     ?>
                  </td>
                  <td class="center">
                     <a class="btn waves-effect waves-light green lighten-1" href="./dashboard.php?page=materi&id=<?php echo $data['id_index']; ?>">
                        List Materi
                    </a>
                  </td>
               </tr>
               <?php
            }
         }
         ?>
      </tbody>
   </table>

   <ul class="pagination">
      <?php
      if($hlm > 1){
         $hlmn = $hlm - 1;
         echo "<li class='waves-effect'>";
         echo "<a href='?page=daftar-kelas&hlm=$hlmn'><i class='material-icons'>chevron_left</i> Prev</a>";
         echo "</li>";
      }

      $hitung = mysqli_num_rows($row);
      $total  = ceil($hitung / 5);

      for ($i=1; $i <= $total ; $i++) {
         ?>
         <li <?php if ($hlm != $i) { echo 'class="waves-effect"'; } else { echo 'class="active"';} ?>>
            <a href="?page=daftar-kelas&hlm=<?php echo $i; ?>"><?php echo $i; ?></a>
         </li>
         <?php
      }

      if ($hlm < $total) {
         $next = $hlm + 1;
         echo "<li class='waves-effect'>";
         echo "<a href='?page=daftar-kelas&hlm=$next'>Next <i class='material-icons'>chevron_right</i></a>";
         echo "</li>";
      }
      echo '</ul>';
      ?>
   </div>
</div>
