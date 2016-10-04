<?php
   include_once('../../include/connection.php');
   $gr   = mysqli_real_escape_string($mysqli, $_REQUEST['gr']);
   $bln  = mysqli_real_escape_string($mysqli, $_REQUEST['bln']);
   $thn  = mysqli_real_escape_string($mysqli, $_REQUEST['thn']);

   $data = mysqli_query($mysqli, "SELECT * FROM t_materi JOIN t_kelas ON t_materi.id_kelas = t_kelas.id_kelas JOIN t_mapel ON t_materi.id_mapel = t_mapel.id_mapel WHERE t_materi.id_guru = '$gr' && tgl_up >= '$thn-$bln-01' && tgl_up <= '$thn-$bln-31'");

   $guru = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM t_guru WHERE id_guru = '$gr'"));

   switch ($bln) {
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
?>
<!DOCTYPE html>
<html>
<head>
   <title>Cetak Rekap</title>
   <link type="text/css" rel="stylesheet" href="../../assets/css/materialize.min.css" />
   <style type="text/css">
      tr td {
         padding-top: 3px;
         padding-bottom: 3px;
         border: 1px solid black;
      }

      tr th {
         padding-top: 5px;
         padding-bottom: 5px;
         border: 1px solid black;
         background-color: #b9b9b9;
      }
   </style>
</head>

<body>
   <div class="container">
      <h5>Rekap Bulan <?php echo $bul; ?> Tahun <?php echo $thn; ?></h5>
      <h6>Nama Guru : <?php echo $guru['fullname']; ?></h6>

      <table class="bordered">
         <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Materi</th>
            <th>Mata Pelajaran</th>
            <th>Kelas</th>
            <th>Diakses</th>
         </tr>
         <?php
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
         ?>
      </table>
   </div>
   <script type="text/javascript">
      window.print();
   </script>
</body>
</html>
