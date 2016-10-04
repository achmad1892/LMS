<?php

   if (empty($_SESSION['type']) || $_SESSION['type'] != 2) {
      header('location:./');
   }

   if (isset($_REQUEST['aksi'])) { //jika variabel $_REQUEST['aksi'] mempunyai nilai
      //alihkan berdasar value $_REQUEST['aksi']
      switch ($_REQUEST['aksi']) {
         case 'add':
            include_once('topik.php');
            break;
         case 'edit':
            include_once('edit_topik.php');
            break;
         case 'tambah_soal':
            include_once('soal.php');
            break;
         case 'publish':
            if ($_REQUEST['status'] == 'Y') {
               mysqli_query($mysqli, "UPDATE t_header_soal SET publikasi = 'N' WHERE id_header = '$_REQUEST[id]'");
               header("location:?page=test");
            } else {
               $cek = mysqli_query($mysqli, "SELECT * FROM t_soal WHERE id_header = '$_REQUEST[id]'");

               if (mysqli_num_rows($cek) <= 0) {
                  echo '<script type="text/javascript">alert("Belum ada soal, Status tidak bisa diubah !"); window.history.back(-1)</script>';
               } else {
                  mysqli_query($mysqli, "UPDATE t_header_soal SET publikasi = 'Y' WHERE id_header = '$_REQUEST[id]'");
                  header("location:?page=test");
               }
            }
            break;
         case 'delete':
            $id = mysqli_real_escape_string($mysqli, $_REQUEST['id']);
            //hitung jumlah soal
            $data = mysqli_query($mysqli, "SELECT * FROM t_soal WHERE id_header = '$id'");
            if(mysqli_num_rows($data) > 0 ){
               //looping penghapusan soal
               while ($key = mysqli_fetch_array($data)) {
                  if ($key['gambar'] != '') { //cek apakah soal memiliki gambar
                     unlink("../assets/img/soal/".$key['gambar']);
                  }
               } //end looping
            } //end if hitung soal
            mysqli_query($mysqli, "DELETE FROM t_soal WHERE id_header = '$id'");
            mysqli_query($mysqli, "DELETE FROM t_header_soal WHERE id_header = '$id'");
            mysqli_query($mysqli, "DELETE FROM t_nilai WHERE id_header = '$id'");
            header('location:?page=test');
            break;
         } //end switch

      } else { //jika tidak mempunyai nilai eksekusi code dibawah

?>
   <a href="?page=test&aksi=add" class="btn waves-effect waves-light right blue lighten-1">
      <i class="fa fa-plus"></i> Tambah Test
   </a>
   <h4>Daftar Test</h4>
   <br />

   <table>
      <?php
      $sql = "SELECT * FROM t_index_mapel JOIN t_header_soal ON t_index_mapel.id_index = t_header_soal.id_index JOIN t_mapel ON t_index_mapel.id_mapel = t_mapel.id_mapel JOIN t_kelas ON t_index_mapel.id_kelas = t_kelas.id_kelas WHERE t_index_mapel.id_guru = '$_SESSION[id]'";

      $data = mysqli_query($mysqli, $sql);
      if (mysqli_num_rows($data) > 0) {

         echo "<tr>";
         echo '<th width="60" class="center">NO</th>';
         echo '<th width="150" class="center">Judul</th>';
         echo '<th width="60" class="center">Mapel</th>';
         echo '<th width="60" class="center">Kelas</th>';
         echo '<th width="60" class="center">Waktu</th>';
         echo '<th width="60" class="center">Tgl dibuat</th>';
         echo '<th width="150" class="center">Opsi</th>';
         echo "</tr>";

         $i = 1;
         while ($key = mysqli_fetch_array($data)) { //start while topik test
            echo "<tr>";
            echo '<td class="center">'.$i++.'</td>';
            echo '<td class="pad">'.$key['judul'].'</td>';
            echo '<td class="center">'.$key['nama_mapel'].'</td>';
            echo '<td class="center">'.$key['nama_kelas'].'</td>';
            echo '<td class="center">'.($key['waktu']/60).' Menit</td>';
            echo '<td class="center">'.date('d M Y', strtotime($key['tgl_dibuat'])).'</td>';
            echo '<td class="center">';
            echo '<a href="?page=test&aksi=tambah_soal&id='.$key['id_header'].'" class="link waves-effect waves-light blue lighten-1">soal</a>';
            echo "&nbsp;"; //hanya spasi
            echo '<a href="?page=test&aksi=edit&id='.$key['id_header'].'" class="link waves-effect waves-light green lighten-1">Edit</a>';
            echo "&nbsp;"; //hanya spasi
            ?>
            <a href="?page=test&aksi=delete&id=<?php echo $key['id_header']; ?>" onclick="return confirm('Yakin Ingin Mengahapus Topik ini?')" class="link waves-effect waves-light red lighten-1">hapus</a>
            <br />
            <?php
            if ($key['publikasi'] == 'Y') {
               echo '<a href="?page=test&aksi=publish&id='.$key['id_header'].'&status='.$key['publikasi'].'" class="link waves-effect waves-light green lighten-1">Terbitkan</a>';
            } else {
               echo '<a href="?page=test&aksi=publish&id='.$key['id_header'].'&status='.$key['publikasi'].'" class="link waves-effect waves-light green lighten-1">Belum diterbitkan</a>';
            }
            echo "</td>";
            echo "</tr>";
         } //end while topik

      } else { //else hitung test

         echo '<tr><td colspan="7" class="center"><h4><i>Anda belum membuat Test</i></h4></td></tr>';

      } //end if hitung
      echo "</table>";
   } //end if isset
?>
