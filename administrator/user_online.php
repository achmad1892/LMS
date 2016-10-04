<?php
   //cek session
   if (empty($_SESSION['type']) || $_SESSION['type'] == 3) {
      header('location:../');
   }

   if (isset($_REQUEST['aksi'])) {
      switch ($_REQUEST['aksi']) {
         case 'siswa':
            $id = mysqli_real_escape_string($mysqli, $_REQUEST['id']);
            mysqli_query($mysqli, "UPDATE t_siswa SET login_status = 'N' WHERE nis = '$id'");
            header('location:?page=user');
            break;
         case 'guru':
            $id = mysqli_real_escape_string($mysqli, $_REQUEST['id']);
            mysqli_query($mysqli, "UPDATE t_guru SET login_status = 'N' WHERE id_guru = '$id'");
            header('location:?page=user');
            break;
      }
   }

   $siswa  = mysqli_query($mysqli, "SELECT * FROM t_siswa JOIN t_kelas ON t_siswa.id_kelas = t_kelas.id_kelas WHERE login_status = 'Y' ORDER BY t_siswa.id_kelas ASC");
   $guru  = mysqli_query($mysqli, "SELECT * FROM t_guru WHERE login_status ='Y'");
?>
   <div class="row"> <!-- start row -->

      <?php
      if ($_SESSION['type'] == 1) {
         ?>
         <div class="col m6"> <!-- start col guru -->
            <b>Guru Online</b>
            <br />
            <?php
            echo '<table>';
            if (mysqli_num_rows($guru) <= 0) {
               echo '<tr><td>Tidak Ada Guru Yang Online</td></tr>';
            }

            while ($g = mysqli_fetch_array($guru)) { //start while
               echo "<tr>";
               echo '<td class="jarak" width="50px"><img src="../assets/img/'.$g['foto'].'" width="30px" height="30px" class="circle"></td>';
               echo '<td class="jarak"><b>'.$g['fullname'].'</b></td>';
               echo '<td class="jarak"><a href="?page=user&aksi=guru&id='.$g['id_guru'].'" class="btn-floating red"><i class="fa fa-sign-out"></i></a></td>';
               echo "</tr>";
            } // end of while
            echo "</table>";
            ?>
         </div> <!-- end col guru -->
         <?php
      }
      ?>
      <div class="col m6"> <!-- start col siswa -->
         <b>Siswa Online</b>
         <br />
         <?php
         echo '<table>';
         if (mysqli_num_rows($siswa) <= 0) {
            echo '<tr><td>Tidak Ada Siswa Yang Online</td></tr>';
         }

         while ($s = mysqli_fetch_array($siswa)) { //start while
            echo "<tr>";
            echo '<td class="jarak" width="50px"><img src="../assets/img/'.$s['foto'].'" width="30px" height="30px" class="circle"></td>';
            echo '<td class="jarak"><b>'.$s['fullname'].'</b></td>';
            if ($_SESSION['type'] == 1) {
               echo '<td class="jarak"><a href="?page=user&aksi=siswa&id='.$s['nis'].'" class="btn-floating red"><i class="fa fa-sign-out"></i></a></td>';
            }
            echo "</tr>";
         } // end of while
         echo "</table>";
         ?>
      </div> <!-- end col siswa -->

   </div> <!-- end row -->
