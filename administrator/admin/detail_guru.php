<?php

   if (empty($_SESSION['type']) || empty($_REQUEST['id']) || $_SESSION['type'] != 1) {
      header('location:../');
   }

   $id     = mysqli_real_escape_string($mysqli, $_GET['id']);
   $data   = mysqli_query($mysqli, "SELECT * FROM t_guru WHERE id_guru = '$id'");
   $hasil  = mysqli_fetch_array($data);
?>

   <h4>Detail Guru</h4>
   <br />
   <div class="row"> <!-- start row detail -->

      <div class="col s12 m4 l3 center">  <!-- start col kiri -->
         <img src="../assets/img/<?php echo $hasil['foto']; ?>" height="200" width="200" class="z-depth-2">
         <br />
         <h5><?php echo $hasil['fullname']; ?></h5>
      </div> <!-- end col kiri -->

      <div class="col s12 m8 l9"> <!-- start col kanan -->
         <table class="striped">
            <tr>
               <td width="150">Username</td>
               <td>:</td>
               <td><?php echo $hasil['username']; ?></td>
            </tr>
            <tr>
               <td width="150">NIP</td>
               <td>:</td>
               <td><?php echo $hasil['nip']; ?></td>
            </tr>
            <tr>
               <td width="150">Jenis Kelamin</td>
               <td>:</td>
               <td><?php if ($hasil['jk'] == 'L') { echo 'Laki - laki'; } else { echo 'Perempuan';} ?></td>
            </tr>
         </table>
      </div> <!-- end col kanan -->

   </div> <!-- end row detail -->
   <br />
   <br />
   <div class="row"> <!-- start row button -->
      <div class="col s12 m8 l5 offset-l7">
         <button class="btn waves-effect waves-light red" onclick=self.history.back()>
            <i class="fa fa-arrow-left"></i>
         </button>
         &nbsp;
         <a href="?page=daftar_guru&aksi=edit&id=<?php echo $hasil['id_guru']; ?>" class="btn waves-effect waves-light blue lighten-1">
            <i class="fa fa-pencil"></i>
         </a>
      </div>
   </div> <!-- end row button -->
