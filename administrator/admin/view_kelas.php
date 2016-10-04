<?php

   if (empty($_SESSION['type']) || $_SESSION['type'] == 3) {
      header('location:./');
   }

   //cek apakah $_REQUEST['aksi'] telah diset
   if (isset($_REQUEST['aksi'])) {
      switch ($_REQUEST['aksi']) {
         case 'add':
            include_once('add_kelas.php');
            break;
         case 'edit':
            include_once('edit_kelas.php');
            break;
         case 'daftar_siswa':
            include_once('view_siswa.php');
            break;
         case 'delete':
            mysqli_query($mysqli, "DELETE FROM t_kelas WHERE id_kelas = '$_REQUEST[id]'");

            while ($key = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM t_siswa WHERE id_kelas = '$_REQUEST[id]'"))) {

               if ($key['foto'] != '' && $key['foto'] != 'default.png') {
                  mysqli_query($mysqli, "DELETE FROM t_siswa WHERE id_kelas = '$_REQUEST[id]'");
                  unlink("../assets/img/".$key['foto']);
               } else {
                  mysqli_query($mysqli, "DELETE FROM t_siswa WHERE id_kelas = '$_REQUEST[id]'");
               }

            }
            header('location:?page=daftar_kelas');
            break;
      }
   } else { //else if aksi
      //cek $_REQUEST['hlm']
      if (isset($_REQUEST['hlm'])) {
         $hlm = $_REQUEST['hlm'];
         $no  = (6*$hlm) - 5;
      } else {
         $hlm = 1;
         $no  = 1;
      }

      if ($_SESSION['type'] == 1) {
         echo '<a class="btn waves-effect waves-light right blue lighten-1" href="?page=daftar_kelas&aksi=add"><i class="fa fa-plus left"></i>tambah data</a>';
      }
?>
   <h4>Daftar Kelas</h4>
   <br />
   <table class="striped">
      <thead>
         <tr>
            <th width="40" class="center">No</th>
            <th width="150" class="center">Nama Kelas</th>
            <?php if ($_SESSION['type'] == 1) { echo '<th width="200" class="center">Wali Kelas</th>'; } ?>
            <th width="200" class="center">Ketua Kelas</th>
            <th width="120" class="center">Opsi</th>
         </tr>
      </thead>
      <tbody>
         <?php
         $no    = 1;
         $start = ($hlm - 1) * 5;
         if ($_SESSION['type'] == 1){
            $row = mysqli_query($mysqli, "SELECT * FROM t_kelas ORDER BY nama_kelas ASC LIMIT $start, 5");
         } else {
            $row = mysqli_query($mysqli, "SELECT * FROM t_kelas WHERE id_guru = '$_SESSION[id]' ORDER BY nama_kelas ASC LIMIT $start, 5");
         }

         if ( mysqli_num_rows(mysqli_query($mysqli, "SELECT * FROM t_kelas")) <= 0) {
            if ($_SESSION['type'] == 1) {
               echo '<tr><td colspan="5" class="center"><i>BELUM ADA DATA</i></td></tr>';
            } else {
               echo '<tr><td colspan="4" class="center"><i>BELUM ADA DATA</i></td></tr>';
            }
         } else {
            while ($data = mysqli_fetch_array($row)) { //start while
               ?>
               <tr>
                  <td class="center">
                     <?php echo $no++; ?>
                  </td>
                  <td class="center">
                     <?php echo $data['nama_kelas']; ?>
                  </td>
                  <?php
                  if ($_SESSION['type'] == 1) {
                     echo '<td class="center">';

                    $guru = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM t_guru WHERE id_guru = '$data[id_guru]'"));

                     if (!empty($guru)) {
                        echo $guru['fullname'];
                     }
                    echo '</td>';
                  }
                  ?>
                  <td class="center">
                     <?php
                     echo mysqli_num_rows(mysqli_query($mysqli, "SELECT * FROM t_siswa WHERE id_kelas = '$data[id_kelas]'")).' Siswa';
                     ?>
                  </td>
                  <td class="center">
                     <a href="?page=daftar_siswa&idkelas=<?php echo $data['id_kelas']; ?>" class="btn-floating green lighten-1"><i class="fa fa-list"></i></a>
                     &nbsp; <!-- spasi -->
                     <?php
                     if ($_SESSION['type'] == 1) { //start if session type
                        ?>
                        <a href="?page=daftar_kelas&aksi=edit&id=<?php echo $data['id_kelas']; ?>" class="btn-floating blue lighten-1"><i class="fa fa-pencil"></i></a>
                        &nbsp; <!-- spasi -->
                        <a href="?page=daftar_kelas&aksi=delete&id=<?php echo $data['id_kelas']; ?>" class="btn-floating red" onclick="return confirm('Yakin Ingin Mengahapus data ini?')"><i class="fa fa-trash"></i></a>
                        <?php
                     } //end if session type
                     ?>
                  </td>
               </tr>
               <?php
            } // end while

         } //end else
         ?>
      </tbody>
   </table>

   <ul class="pagination"> <!-- start pagination -->
      <?php
      if($hlm > 1){ //start if $hlm
         $hlmn = $hlm - 1;

         echo "<li class='waves-effect'><a href='?page=daftar_kelas&hlm=$hlmn'><i class='fa fa-caret-left'></i> Prev</a></li>";
      } // end if $hlm

      $hitung = mysqli_num_rows(mysqli_query($mysqli, "SELECT * FROM t_kelas")); // hitung jumlah kelas
      $total  = ceil($hitung / 5);

      for ($i=1; $i <= $total ; $i++) {
         ?>
         <li <?php if ($hlm != $i) { echo 'class="waves-effect"'; } else { echo 'class="active"';} ?>>
            <a href="?page=daftar_kelas&hlm=<?php echo $i; ?>">
               <?php echo $i; ?>
            </a>
         </li>
         <?php
      } //end for

      if ($hlm < $total) {
         $next = $hlm + 1;
         echo "<li class='waves-effect'><a href='?page=daftar_kelas&hlm=$next'>Next <i class='fa fa-caret-right'></i></a></li>";
      } //end if $hlm < $total

      echo '</ul>'; //end pagination
   } //end if aksi
?>
