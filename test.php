<?php

   if(!isset($_SESSION['type']) || $_SESSION['type'] != 3) {
      header('location:./');
   }

   if (isset($_REQUEST['next'])) {
      $hal = $_REQUEST['hlm'];
      $hlm = $hal + 1;
      $_SESSION['id'.$hal]      = $_REQUEST['id'.$hal];
      $_SESSION['jawaban'.$hal] = $_REQUEST['jwb'.$hal];

      header('location:?page=test&id='.$_REQUEST['id_index'].'&hlm='.$hlm);
   }

   //cek apakah $_REQUEST['save'] telah diset
   if (isset($_REQUEST['save'])) {
      $hal = $_REQUEST['hal'];

      $_SESSION['id'.$hal]      = $_REQUEST['id'.$hal];
      $_SESSION['jawaban'.$hal] = $_REQUEST['jwb'.$hal];

      $benar = 0;
      $i     = 1;

      //lakukan perulangan pembacaan jawaban
      while ($i <= $_REQUEST['jml']) {
         $id  = $_SESSION['id'.$i];
         $cek = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM t_soal WHERE id_soal = '$id'"));
         if (!empty($_SESSION['jawaban'.$i])) {
            if ($_SESSION['jawaban'.$i] == $cek['kunci']) {
               $benar++;
            }
         }
         unset ($_SESSION['id'.$i]);
         unset ($_SESSION['jawaban'.$i]);
         $i++;
      }
      //hitung nilai
      $nilai  = ($benar / $_REQUEST['jml']) * 100;

      $data   = "INSERT INTO t_nilai (id_header, nis, nilai) VALUES ('$_REQUEST[id_index]', '$_SESSION[id]', '$nilai')";
      mysqli_query($mysqli, $data);

      header('location:./');
   }

?>
   <ul class="side-nav fixed blue lighten-1 center grey-text text-lighten-5">
      <img src="./assets/img/logo.png" width="240px" height="300px"><br />
      <h5><b>SISA WAKTU :</b></h5>
      <div id="divwaktu"></div>
   </ul>
   <div class="container">
      <div class="card z-depth-1">
         <div class="card-content">
            <?php

            $id   = mysqli_real_escape_string($mysqli, $dat['id_header']);
            if (isset($_SESSION['id'.$_REQUEST['hlm']])) {
               $id_soal = $_SESSION['id'.$_REQUEST['hlm']];
               $test = mysqli_query($mysqli, "SELECT * FROM t_soal WHERE id_header = '$dat[id_header]' && id_soal = '$id_soal' LIMIT 1");

            } else {
               $test = mysqli_query($mysqli, "SELECT * FROM t_soal WHERE id_header = '$dat[id_header]' ORDER BY RAND() LIMIT 1");
            }
            echo '<form action="" method="post" id="form">';
            echo '<input type="hidden" name="id_index" value="'.$id.'">';
            $i = $_REQUEST['hlm'];
            echo '<input type="hidden" name="hal" value="'.$i.'">';
            echo "<table>";
            $val = mysqli_fetch_array($test);
            echo '<input type="hidden" name="id'.$i.'" value="'.$val['id_soal'].'" />';
            ?>
               <tr>
                  <td><h3><?php echo $i; ?>. <?php echo $val['soal']; ?></h3></td>
               </tr>
               <?php
               if ($val['gambar']!=''){
                  ?>
                  <tr><td><img src="./assets/img/soal/<?php echo $val['gambar']; ?>"></td></tr>
                  <?php
               }
               ?>
               <tr><td>
                  <input type="radio" name="jwb<?php echo $i; ?>" value='A' id="label1<?php echo $i; ?>" <?php if (isset($_SESSION['jawaban'.$i]) && $_SESSION['jawaban'.$i] == 'A') { echo "checked"; } ?>>
                  <label for="label1<?php echo $i; ?>" class="black-text">A. <?php echo $val['pil_a'] ;?></label>
               </td></tr>
               <tr><td>
                  <input type="radio" name="jwb<?php echo $i; ?>" value='B' id="label2<?php echo $i; ?>" <?php if (isset($_SESSION['jawaban'.$i]) && $_SESSION['jawaban'.$i] == 'B') { echo "checked"; } ?>>
                  <label for="label2<?php echo $i; ?>" class="black-text">B. <?php echo $val['pil_b'] ;?></label>
               </td></tr>
               <tr><td>
                  <input type="radio" name="jwb<?php echo $i; ?>" value='C' id="label3<?php echo $i; ?>" <?php if (isset($_SESSION['jawaban'.$i]) && $_SESSION['jawaban'.$i] == 'C') { echo "checked"; } ?>>
                  <label for="label3<?php echo $i; ?>" class="black-text">C. <?php echo $val['pil_c'] ;?></label>
               </td></tr>
               <tr><td>
                  <input type="radio" name="jwb<?php echo $i; ?>" value='D' id="label4<?php echo $i; ?>" <?php if (isset($_SESSION['jawaban'.$i]) && $_SESSION['jawaban'.$i] == 'D') { echo "checked"; } ?>>
                  <label for="label4<?php echo $i; ?>" class="black-text">D. <?php echo $val['pil_d'] ;?></label>
               </td></tr>
               <?php
               $no   = mysqli_num_rows(mysqli_query($mysqli, "SELECT * FROM t_soal WHERE id_header = '$id'"));
               $hlm  = $_REQUEST['hlm'];
               echo '</table>';
               echo '<input type="hidden" name="jml" value="'.$no.'" />';
               echo '<br /><p class="garisbawah"></p><br />';
               echo '<div class="row">';
               echo '<div class="col m6 left">';
               if ($hlm >  1) {
                  $hal = $hlm - 1;
                  echo '<a href="?page=test&id='.$id.'&hlm='.$hal.'" class="btn red waves-effect waves-light">Kembali</a>';
               }
               echo "</div>";
               echo '<div class="col m6 right">';
               if ($hlm < $no) {
                  echo '<input type="submit" name="next" value="Next" class="btn green waves-effect waves-light"> &nbsp;';
               }
               echo '<input type="submit" name="save" id="save" value="Selesai" onclick="selesai()" class="btn blue waves-effect waves-light">';
               echo "</div>";
               echo "</div>";
               echo '</form>';
               ?>
            </div>
         </div>
      </div>
