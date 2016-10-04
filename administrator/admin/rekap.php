<?php
   if (empty($_REQUEST['page'])) {
      header('location:./');
   }

   if (!isset($_REQUEST['daftar'])) {
?>
   <h5>Rekap Materi Guru</h5>
   <br />
   <div class="row" style="padding-left:50px;"> <!-- start row -->
      <form action="" method="post">
         <div class="row jarak"> <!-- start row kelas -->
            <div class="col s6">
               <i class="fa fa-user prefix"></i>
               <label>Guru</label>
               <select class="browser-default" name="guru" required="kelas">
                  <option value="" disabled selected> -- Pilih Guru -- </option>
                  <?php
                  $data = mysqli_query($mysqli, "SELECT * FROM t_guru");

                  while ($pilih = mysqli_fetch_array($data)) {
                     echo '<option value="'.$pilih['id_guru'].'">'.$pilih['fullname'].'</option>';
                  }
                  ?>
               </select>
            </div>
         </div> <!-- end row kelas -->
         <div class="row jarak"> <!-- start row kelas -->
            <div class="col s6">
               <i class="fa fa-calendar prefix"></i>
               <label>Bulan</label>
               <div class="row">
                  <div class="col s6">
                     <select class="browser-default" name="bulan" required="kelas">
                        <?php
                        $tanggal = date('m');
                        ?>
                        <option value="01" <?php if ($tanggal == '01') { echo 'selected'; } ?>> Januari </option>
                        <option value="02" <?php if ($tanggal == '02') { echo 'selected'; } ?>> Februari </option>
                        <option value="03" <?php if ($tanggal == '03') { echo 'selected'; } ?>> Maret </option>
                        <option value="04" <?php if ($tanggal == '04') { echo 'selected'; } ?>> April </option>
                        <option value="05" <?php if ($tanggal == '05') { echo 'selected'; } ?>> Mei </option>
                        <option value="06" <?php if ($tanggal == '06') { echo 'selected'; } ?>> Juni </option>
                        <option value="07" <?php if ($tanggal == '07') { echo 'selected'; } ?>> Juli </option>
                        <option value="08" <?php if ($tanggal == '08') { echo 'selected'; } ?>> Agustus </option>
                        <option value="09" <?php if ($tanggal == '09') { echo 'selected'; } ?>> September </option>
                        <option value="10" <?php if ($tanggal == '10') { echo 'selected'; } ?>> Oktober </option>
                        <option value="11" <?php if ($tanggal == '11') { echo 'selected'; } ?>> November </option>
                        <option value="12" <?php if ($tanggal == '12') { echo 'selected'; } ?>> Desember </option>
                     </select>
                  </div>
                  <div class="col s6">
                    <select class="browser-default" name="tahun" required="kelas">
                        <?php
                        $tahun = date('Y');
                        for ($i = 16; $i <= 30; $i++) {
                          ?>
                          <option value="20<?php echo $i; ?>" <?php if ( $tahun == '20'.$i) { echo 'selected'; } ?>> 20<?php echo $i; ?></option>
                          <?php
                        }
                        ?>
                     </select>
                  </div>
               </div>
            </div>
         </div> <!-- end row kelas -->
         <br />
         <div class="row">
            <div class="col s6 right">
               <button type="submit" name="daftar" class="btn green waves-light waves-effect">
                  <i class="fa fa-eye"></i> Lihat Rekap
               </button>
            </div>
         </div>
      </form>
   </div> <!-- end row -->
   <?php
   } else {
      $id_guru = mysqli_real_escape_string($mysqli, $_REQUEST['guru']);
      $bulan   = mysqli_real_escape_string($mysqli, $_REQUEST['bulan']);
      $tahun   = mysqli_real_escape_string($mysqli, $_REQUEST['tahun']);

      if ($id_guru == '' || $bulan == '' || $tahun == '') {
         echo '<script type="text/javascript">alert("Semua form harus dipilih !!!")</script>';
      } else {
         switch ($bulan) {
            case '01':
               $bul = "Januari";
               break;
            case '02':
               $bul = "Februari";
               break;
            case '03':
               $bul = "Maret";
               break;
            case '04':
               $bul = "April";
               break;
            case '05':
               $bul = "Mei";
               break;
            case '06':
               $bul = "Juni";
               break;
            case '07':
               $bul = "Juli";
               break;
            case '08':
               $bul = "Agustus";
               break;
            case '09':
               $bul = "September";
               break;
            case '10':
               $bul = "Oktober";
               break;
            case '11':
               $bul = "November";
               break;
            case '12':
               $bul = "Desember";
               break;
         }

         $guru = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM t_guru WHERE id_guru = '$id_guru'"));
         echo '<div class="row">';
         echo '<div class="col m10">';
         echo '<h5>Daftar Rekab Bulan '.$bul.' Tahun '.$tahun.'</h5>';
         echo '<h6>Nama Guru : '.$guru['fullname'].'</h6><br />';
         echo "</div>";
         echo '<div class="col m2" style="padding-top:30px;">';
         echo '<a href="./admin/print_rekap.php?gr='.$id_guru.'&bln='.$bulan.'&thn='.$tahun.'" target="_blank" class="btn blue waves-light waves-effect">';
         echo '<i class="fa fa-print"></i>';
         echo '</a>';
         echo "</div>";
         echo "</div>";

         $data = mysqli_query($mysqli, "SELECT * FROM t_materi JOIN t_kelas ON t_materi.id_kelas = t_kelas.id_kelas JOIN t_mapel ON t_materi.id_mapel = t_mapel.id_mapel WHERE t_materi.id_guru = '$id_guru' && tgl_up >= '$tahun-$bulan-01' && tgl_up <= '$tahun-$bulan-31'");

         echo '<div class="row" style="padding-left:50px; padding-right:50px;">';
         if (mysqli_num_rows($data) > 0) {
            echo '<table class="table striped">';
            echo "<tr>";
            echo "<th>No</th>";
            echo "<th>Tanggal</th>";
            echo "<th>Materi</th>";
            echo "<th>Mata Pelajaran</th>";
            echo "<th>Kelas</th>";
            echo "<th>Diakses</th>";
            echo "</tr>";
            $i = 1;
            while ($file = mysqli_fetch_array($data)) {
               echo "<tr>";
               echo '<td>'.$i.'</th>';
               echo '<td>'.date('d/m/Y', strtotime($file['tgl_up'])).'</td>';
               echo '<td>'.$file['judul_mat'].'</td>';
               echo '<td>'.$file['nama_mapel'].'</td>';
               echo '<td>'.$file['nama_kelas'].'</td>';
               echo '<td>'.count(explode(',', $file['download'])).' Siswa</td>';
               echo "</tr>";
               $i++;
            }
            echo '</table>';
         } else {
            echo '<h4>Belum Ada Data</h4>';
         }
         echo '<div class="right" style="padding-top:50px; padding-right:50px;">';
         echo '<a href="?page=rekap" class="btn waves-effect waves-light red">';
         echo '<i class="fa fa-arrow-left"></i> Kembali';
         echo '</a>';
         echo '</div>';
         echo '</div>';
      }
   }
?>
