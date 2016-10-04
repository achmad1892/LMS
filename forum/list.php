<?php
   if(empty($_SESSION['type'])){
      header('location:../');
   }

   if(isset($_REQUEST['aksi'])){
      switch ($_REQUEST['aksi']) {
         case 'edit':
            include_once('./edit.php');
            break;
         case 'delete':
            $id   = mysqli_real_escape_string($mysqli, $_REQUEST['id']);
            $key  = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM t_forum WHERE id_forum = '$id'"));

            if ($key['foto_topik'] != '') {
               unlink("../assets/img/".$key['foto_topik']);
            }
            mysqli_query($mysqli, "DELETE FROM t_forum WHERE id_forum = '$id'");

            $data = mysqli_query($mysqli, "SELECT * FROM t_komentar WHERE id_forum = '$id'");
            while ($hapus = mysqli_fetch_array($data)) {
               if ($hapus['gambar'] != '') {
                  unlink("../assets/img/".$hapus['gambar']);
               }
               mysqli_query($mysqli, "DELETE FROM t_komentar WHERE id_komentar = '$hapus[id_komentar]'");
            }
            header('location:index.php');
            break;
         }
      } else {
         $i = 1;
         echo '<table class="highlight">';
         echo '<tr>';
         echo '<th>No</th>';
         echo '<th>Judul</th>';
         echo '<th class="center">Tanggapan</th>';
         echo '<th>Tanggal Post</th>';
         echo '<th class="center">Opsi</th>';
         echo '</tr>';

         $list = mysqli_query($mysqli, "SELECT * FROM t_forum WHERE user = '$_SESSION[id]'");
         if(mysqli_num_rows($list) > 0){
            while($key = mysqli_fetch_array($list)) {
               echo '<tr>';
               echo '<td>'.$i++.'</td>';
               echo '<td>'.$key['judul'].'</td>';
               echo '<td class="center">';
               $query = mysqli_query($mysqli, "SELECT * FROM t_komentar WHERE id_forum = '$key[id_forum]'");
               echo mysqli_num_rows($query).' <i class="fa fa-comment"></i>';
               echo '</td>';
               echo '<td>'.date("d M Y",strtotime($key['tgl_forum'])).'</td>';
               echo '<td class="center">';
               echo '<a href="index.php?page=comment&id='.$key['id_forum'].'" class="btn-floating waves-effect waves-light green lighten-1"><i class="fa fa-commenting"></i></a>&nbsp;';
               echo '<a href="index.php?page=list&aksi=edit&id='.$key['id_forum'].'" class="btn-floating waves-effect waves-light blue lighten-1"><i class="fa fa-pencil"></i></a>';
               ?>
               <a href="index.php?page=list&aksi=delete&id=<?php echo $key['id_forum']; ?>" onclick="return confirm('Yakin Ingin Mengahapus Thread ini?')" class="btn-floating waves-effect waves-light red lighten-1">
                  <i class="fa fa-trash"></i>
               </a>
            </td>
         </tr>
         <?php
         }
      } else {
         echo '<tr><td class="center" colspan="5"><h4><i>" Anda Belum Membuat Thread "</i></h4></td></tr>';
      }
      echo "</table>";
      echo '<a href="./" class="btn waves-effect waves-light red lighten-1"><i class="fa fa-arrow-left"></i> Kembali<a>';
   }
?>
