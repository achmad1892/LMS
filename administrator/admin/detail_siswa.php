<?php

   if (empty($_SESSION['type']) || empty($_REQUEST['id']) || $_SESSION['type'] != 1) {
      header('location:./');
   }

   $id   = mysqli_real_escape_string($mysqli, $_REQUEST['id']);
   $sql  = "SELECT * FROM t_siswa INNER JOIN t_kelas ON t_kelas.id_kelas = t_siswa.id_kelas WHERE nis = '$id'";
   $data = mysqli_fetch_array(mysqli_query($mysqli, $sql));
?>

   <h4>Detail Siswa</h4>
   <br />
   <div class="row"> <!-- start row detail -->

      <div class="col s12 m4 l3 center"> <!-- start col kiri -->
         <img src="../assets/img/<?php echo $data['foto']; ?>" height="200" width="200" class="z-depth-2">
         <br />
         <h5><?php echo $data['username']; ?></h5>
      </div> <!-- end col kiri -->

      <div class="col s12 m8 l9"> <!-- start col kanan -->
         <table class="striped">
            <tr>
               <td width="150">NIS</td>
               <td>:</td>
               <td><?php echo $data['nis']; ?></td>
            </tr>
            <tr>
               <td width="150">Nama</td>
               <td>:</td>
               <td><?php echo $data['fullname']; ?></td>
            </tr>
            <tr>
               <td width="150">Kelas</td>
               <td>:</td>
               <td><?php echo $data['nama_kelas']; ?></td>
            </tr>
            <tr>
               <td width="150">Tanggal Lahir</td>
               <td>:</td>
               <td><?php echo date('d M Y ', strtotime($data['tgl'])); ?></td>
            </tr>
            <tr>
               <td width="150">Jenis Kelamin</td>
               <td>:</td>
               <td><?php if ($data['jk'] == 'L') { echo 'Laki - laki'; } else { echo 'Perempuan';} ?></td>
            </tr>
            <tr>
               <td width="150">Alamat</td>
               <td>:</td>
               <td><?php echo $data['alamat']; ?></td>
            </tr>
            <tr>
               <td width="150">Nama Ayah</td>
               <td>:</td>
               <td><?php echo $data['ayah']; ?></td>
            </tr>
            <tr>
               <td width="150">Nama Ibu</td>
               <td>:</td>
               <td><?php echo $data['ibu']; ?></td>
            </tr>
         </table>
      </div> <!-- end col kanan -->

   </div> <!-- end row detail -->
   <br />
   <br />
   <div class="row"> <!-- start row button -->
      <div class="col s12 m8 l5 offset-l7">
         <button class="btn waves-effect waves-light red" onclick="self.history.back()">
            <i class="fa fa-arrow-left"></i>
         </button>
         &nbsp;
         <a href="?page=daftar_siswa&aksi=edit&id=<?php echo $data['nis']; ?>" class="btn waves-effect waves-light blue lighten-1">
            <i class="fa fa-pencil"></i>
         </a>
      </div>
   </div>  <!-- end row button -->
