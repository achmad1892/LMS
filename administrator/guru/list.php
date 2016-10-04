<?php
   $id       = mysqli_real_escape_string($mysqli, $_REQUEST['view']);

   $id_user  = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM t_materi WHERE id_materi = '$id'"));
   $user     = explode(',', $id_user['download']);
?>
   <div class="row"> <!-- start row -->

      <div class="col m8 offset-m1">
         <h6>Diakses Oleh :</h6>
         <br />
         <?php
         echo '<table class="striped">';
         for ($i = 0; $i < count($user); $i++) { //start looping
            if (mysqli_num_rows(mysqli_query($mysqli, "SELECT * FROM t_admin WHERE id_admin = '$user[$i]'")) > 0) {
               $data = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM t_admin WHERE id_admin = '$user[$i]'"));
               echo "<tr>";
               echo '<td class="jarak center" width="100px">';
               if ($_SESSION['type'] == 3 ) {
                  echo '<img src="./assets/img/'.$data['foto'].'" width="30px" height="30px" class="circle" style="border: 1px solid #cccccc">';
               } else {
                  echo '<img src="../assets/img/'.$data['foto'].'" width="30px" height="30px" class="circle" style="border: 1px solid #cccccc">';
               }
               echo '</td>';
               echo '<td>'.$data['fullname'].'</td>';
               echo "</tr>";
            } elseif (mysqli_num_rows(mysqli_query($mysqli, "SELECT * FROM t_guru WHERE id_guru = '$user[$i]'")) > 0) {
               $data = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM t_guru WHERE id_guru = '$user[$i]'"));
               echo "<tr>";
               echo '<td class="jarak center" width="100px">';
               if ($_SESSION['type'] == 3 ) {
                  echo '<img src="./assets/img/'.$data['foto'].'" width="30px" height="30px" class="circle" style="border: 1px solid #cccccc">';
               } else {
                  echo '<img src="../assets/img/'.$data['foto'].'" width="30px" height="30px" class="circle" style="border: 1px solid #cccccc">';
               }
               echo '</td>';
               echo '<td>'.$data['fullname'].'</td>';
               echo "</tr>";
            } else {
               $data = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM t_siswa WHERE nis = '$user[$i]'"));
               echo "<tr>";
               echo '<td class="jarak center" width="100px">';
               if ($_SESSION['type'] == 3 ) {
                  echo '<img src="./assets/img/'.$data['foto'].'" width="30px" height="30px" class="circle" style="border: 1px solid #cccccc">';
               } else {
                  echo '<img src="../assets/img/'.$data['foto'].'" width="30px" height="30px" class="circle" style="border: 1px solid #cccccc">';
               }
               echo '</td>';
               echo '<td>'.$data['fullname'].'</td>';
               echo "</tr>";
            }
         } // end lopping
         echo "</table>";
         ?>
         <br />
         <button class="btn red waves-light waves-effect right" onclick="self.history.back()">
            <i class="fa fa-arrow-left"></i> Kembali
         </button>
      </div>

   </div> <!-- end row -->
