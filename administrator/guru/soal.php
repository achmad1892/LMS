<?php

   if (empty($_SESSION['type']) || $_SESSION['type'] != 2 || empty($_REQUEST['id'])) {
      header('location:./');
   }

   //cek $_REQUEST['soal'] apakah telah diset
   if (isset($_REQUEST['soal'])) {
      //alihkan sesuai value dari $_REQUEST['soal']
      switch ($_REQUEST['soal']) {
         case 'tambah':
            include_once('add_soal.php');
            break;
         case 'inport':
            include_once('inport_soal.php');
            break;
         case 'edit':
            include_once('edit_soal.php');
            break;
         case 'hapus':
            mysqli_query($mysqli, "DELETE FROM t_soal WHERE id_soal = '$_REQUEST[id_soal]'");
            if ($_REQUEST['ft'] != '' && $_REQUEST['ft'] != 'default.png'){
               unlink("../assets/img/soal/".$_REQUEST['ft']);
            }
            header('location:?page=test&aksi=tambah_soal&id='.$_REQUEST['id']);
            break;
      }

   } else {

      echo '<div class="row">'; //start div header
      echo '<div class="col s9" style="padding-top:16px;">';
      echo '<a href="?page=test" class="btn waves-effect waves-light red lighten-1"><i class="fa fa-arrow-left"></i> Kembali</a>';
      echo '</div>';
      echo '<div class="col s1" style="padding-top:16px;">';
      echo '<a href="?page=test&aksi=tambah_soal&id='.$_REQUEST['id'].'&soal=tambah" class="btn-floating waves-effect waves-light right blue lighten-1"><i class="fa fa-plus"></i></a>';
      echo '</div>';
      echo '<div class="col s1" style="padding-top:16px; padding-right:40px;">';
      echo '<a href="?page=test&aksi=tambah_soal&id='.$_REQUEST['id'].'&soal=inport" class="btn-floating waves-effect waves-light right green lighten-1"><i class="fa fa-upload"></i></a>';
      echo '</div>';
      echo "</div>"; //end div header
      echo "<br />"; //hanya enter

      $data = mysqli_query($mysqli, "SELECT * FROM t_soal WHERE id_header = '$_REQUEST[id]'");
      echo '<table>'; //start table

      if (mysqli_num_rows($data) <= 0) { //hitung jumlah soal
         echo "<h4>Belum Ada Soal</h4>";
      } else {
         $i = 1;
         while ($key = mysqli_fetch_array($data)) { //start foreach
            echo '<tr><td class="jarak">('.$i++.') </td><td class="jarak">Soal</td><td class="jarak">: '.$key['soal'].'</td></tr>';

            if ($key['gambar'] != '') { //cek apakah ada gambar
               echo '<tr><td class="jarak"></td><td class="jarak">Gambar</td><td class="jarak">: <img src="../assets/img/soal/'.$key['gambar'].'" width="200" height="200"></td></tr>';
            }

            echo '<tr><td class="jarak"></td><td class="jarak">Opsi A</td><td class="jarak">: '.$key['pil_a'].'</td></tr>';
            echo '<tr><td class="jarak"></td><td class="jarak">Opsi B</td><td class="jarak">: '.$key['pil_b'].'</td></tr>';
            echo '<tr><td class="jarak"></td><td class="jarak">Opsi C</td><td class="jarak">: '.$key['pil_c'].'</td></tr>';
            echo '<tr><td class="jarak"></td><td class="jarak">Opsi D</td><td class="jarak">: '.$key['pil_d'].'</td></tr>';
            echo '<tr><td class="jarak"></td><td class="jarak">Kunci Jawaban</td><td class="jarak">: '.$key['kunci'].'</td></tr>';
            echo '<tr><td class="jarak" colspan="3">';

            echo '<a href="?page=test&aksi=tambah_soal&id='.$_REQUEST['id'].'&id_soal='.$key['id_soal'].'&soal=edit" class="link waves-effect waves-light green lighten-1">edit</a>';
            ?>
            <a onclick="return confirm('Yakin Ingin Mengahapus soal ini?')" href="?page=test&aksi=tambah_soal&id=<?php echo $_REQUEST['id']; ?>&id_soal=<?php echo $key['id_soal'];?>&soal=hapus&ft=<?php echo $key['gambar']; ?>" class="link waves-effect waves-light red lighten-1">hapus</a>
         </td>
      </tr>
         <?php
         } //end while
      } //end if hitung
      echo '</table>';
   }
?>
