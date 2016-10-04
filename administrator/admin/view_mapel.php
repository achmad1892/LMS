<?php

   if (empty($_SESSION['type']) || $_SESSION['type'] == 3) {
      header('location:./');
   }

   //cek $_REQUEST['aksi']
   if (isset($_REQUEST['aksi'])) {
      switch ($_REQUEST['aksi']) {
         case 'add':
            include_once('add_mapel.php');
            break;
         case 'edit':
            include_once('edit_mapel.php');
            break;
         case 'delete':
            mysqli_query($mysqli, "DELETE FROM t_index_mapel WHERE id_index = '$_REQUEST[id]'");
            header('location:?page=mapel');
            break;
      }
   } else { // else if aksi
      if (isset($_REQUEST['hlm'])) {
         $hlm = $_REQUEST['hlm'];
         $no  = (6*$hlm) - 5;
      } else {
         $hlm = 1;
         $no  = 1;
      }

      if ($_SESSION['type'] == 1) {
         echo '<a class="btn waves-effect waves-light right blue lighten-1" href="?page=mapel&aksi=add"><i class="fa fa-plus left"></i>tambah data</a>';
      }
?>
   <h4>Manajemen Jadwal</h4>
   <br />

   <table class="striped">
      <thead>
         <tr>
            <th width="40" class="center">No</th>
            <th width="150" class="center">Nama Mapel</th>
            <th width="200" class="center">Kelas</th>
            <?php
            if ($_SESSION['type'] == 1){
               echo '<th width="200" class="center">Pengajar</th>';
               echo '<th width="120" class="center">Opsi</th>';
            }
            ?>
         </tr>
      </thead>

      <tbody>
         <?php
         $no     = 1;
         $start  = ($hlm - 1) * 5;

         if ($_SESSION['type'] == 1){
            $sql = "SELECT * FROM t_index_mapel JOIN t_mapel ON t_mapel.id_mapel = t_index_mapel.id_mapel ORDER BY t_index_mapel.id_kelas ASC LIMIT $start, 5";

            $row = mysqli_query($mysqli, $sql);
            $jml = mysqli_num_rows(mysqli_query($mysqli, "SELECT * FROM t_index_mapel"));
         } else {
            $sql = "SELECT * FROM t_index_mapel JOIN t_mapel ON t_mapel.id_mapel = t_index_mapel.id_mapel WHERE id_guru = '$_SESSION[id]' LIMIT $start, 5";

            $row = mysqli_query($mysqli, $sql);
            $jml = mysqli_num_rows(mysqli_query($mysqli, "SELECT * FROM t_index_mapel WHERE id_guru = '$_SESSION[id]'"));
         }

         if ($jml <= 0) {
            echo '<tr><td colspan="5" class="center"><i>BELUM ADA DATA</i></td></tr>';
         } else {
            while ($data = mysqli_fetch_array($row)) {
               echo '<tr>';
               echo '<td class="center">'.$no++.'</td>';
               echo '<td class="center">'.$data['nama_mapel'].'</td>';
               echo '<td class="center">';
               $kelas = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM t_kelas WHERE id_kelas = '$data[id_kelas]'"));

               if (!empty($kelas)) {
                  echo $kelas['nama_kelas'];
               }
               echo '</td>';

               if ($_SESSION['type'] == 1){
                  echo '<td class="center">';
                  $guru = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM t_guru WHERE id_guru = '$data[id_guru]'"));

                  if (!empty($guru)) {
                     echo $guru['fullname'];
                  }
                  echo '</td>';
                  echo '<td class="center">';
                  echo '<a href="?page=mapel&aksi=edit&id='.$data['id_index'].'" class="btn-floating blue lighten-1"><i class="fa fa-pencil"></i></a>';
                  echo '&nbsp;'; //hanya spasi
                  ?>
                  <a href="?page=mapel&aksi=delete&id=<?php echo $data['id_index']; ?>" class="btn-floating red" onclick="return confirm('Yakin Ingin Mengahapus data ini?')"><i class="fa fa-trash"></i></a>
                  <?php
                  echo '</td>';
               } //end if session type 1
               echo '</tr>';
            } //end while
         } //end else if $jml
         ?>
      </tbody>
   </table>

   <ul class="pagination"> <!-- start pagination -->
      <?php
      if($hlm > 1){
         $hlmn = $hlm - 1;
         echo "<li class='waves-effect'><a href='?page=daftar-kelas&hlm=$hlmn'><i class='fa fa-caret-left'></i> Prev</a></li>";
      }

      $hitung = mysqli_num_rows(mysqli_query($mysqli, "SELECT * FROM t_kelas")); //hitung jumlah kelas
      $total  = ceil($hitung / 5);

      for ($i=1; $i <= $total ; $i++) {
         ?>
         <li <?php if ($hlm != $i) { echo 'class="waves-effect"'; } else { echo 'class="active"';} ?>>
            <a href="?page=daftar-kelas&hlm=<?php echo $i; ?>">
               <?php echo $i; ?>
            </a>
         </li>

         <?php
      } //end for

      if ($hlm < $total) {
         $next = $hlm + 1;
         echo "<li class='waves-effect'><a href='?page=daftar-kelas&hlm=$next'>Next <i class='fa fa-caret-right'></i></a></li>";
      } //end if $hlm < $total

      echo '</ul>'; //end pagination
   } //end if aksi
?>
