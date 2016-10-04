<?php

   if (empty($_SESSION['type']) || $_SESSION['type'] == 3) {
      header('location:./');
   }

   if ($_SESSION['type'] == 1) {
      $sql  = mysqli_query($mysqli, "SELECT * FROM t_admin WHERE id_admin = '$_SESSION[id]'");
      $data = mysqli_fetch_array($sql);
   } else {
      $sql  = mysqli_query($mysqli, "SELECT * FROM t_guru WHERE id_guru = '$_SESSION[id]'");
      $data = mysqli_fetch_array($sql);
   }

?>
   <ul id="mobile-demo" class="side-nav fixed">
      <li class="green lighten-2 row">
         <div class="col s2">
            <img class="image z-depth-3" src="../assets/img/<?php echo $data['foto']; ?>" />
         </div>
         <div class="col s8" style="padding-left:20px; padding-top:20px;">
            <a class="btn-flat dropdown-button waves-effect waves-light white-text" href="#!" data-activates="dropdown1">
               <span><?php echo $data['username']; ?></span><i class="fa fa-caret-down right"></i>
            </a>
            <span class="white-text" style="padding-left:15px;"><?php if ($_SESSION['type'] == 1) { echo "Administrator"; } else { echo "Guru"; } ?></span>
         </div>
      </li>
      <ul id="dropdown1" class="dropdown-content">
         <li><a href="?page=setting&set=foto-profil"><i class="fa fa-photo left"></i> Ubah Foto Profil</a></li>
         <li><a href="?page=setting&set=key"><i class="fa fa-key left"></i> Ubah Password</a></li>
         <li><a href="?page=setting&set=profil"><i class="fa fa-user left"></i> Ubah Profil</a></li>
         <li>
            <a href="?page=logout" onclick="return confirm('Yakin Ingin Keluar?')"><i class="fa fa-sign-out left"></i> Logout</a>
         </li>
      </ul>
      <li class="bold <?php if (!isset($_REQUEST['page'])) { echo 'active'; } ?>">
         <a href="./dashboard.php" class="waves-effect waves-teal"><i class="fa fa-dashboard"></i> Dashboard</a>
      </li>
      <li class="bold" >
         <a href="../forum" class="waves-effect waves-teal"><i class="fa fa-comments"></i> Diskusi</a>
      </li>
      <?php
      if ($_SESSION['type'] == 1) { //jika session type bernilai 1 maka tampilkan menu
         ?>
         <li class="bold <?php if ($_REQUEST['page'] == 'daftar_guru') { echo 'active'; } ?>">
            <a href="?page=daftar_guru" class="waves-effect waves-teal"><i class="fa fa-user"></i> Manajemen Guru</a>
         </li>
         <li class="bold <?php if ($_REQUEST['page'] == 'daftar_siswa') { echo 'active'; } ?>">
            <a href="?page=daftar_siswa" class="waves-effect waves-teal"><i class="fa fa-user"></i> Manajemen Siswa</a>
         </li>
         <li class="bold <?php if ($_REQUEST['page'] == 'mapel') { echo 'active'; } ?>">
            <a href="?page=mapel" class="waves-effect waves-teal"><i class="fa fa-list"></i> Manajemen Mapel</a>
         </li>
         <li class="bold <?php if ($_REQUEST['page'] == 'rekap') { echo 'active'; } ?>">
            <a href="?page=rekap" class="waves-effect waves-teal"><i class="fa fa-book"></i> Rekap Materi</a>
         </li>
         <?php
      } else { //jika session type tidak bernilai 1 maka menu yang ditampilkan dibawah ini
         ?>
         <li class="bold <?php if ($_REQUEST['page'] == 'mapel') { echo 'active'; } ?>">
            <a href="?page=mapel" class="waves-effect waves-teal"><i class="fa fa-calendar-o"></i> Lihat Jadwal</a>
         </li>
         <li class="bold <?php if ($_REQUEST['page'] == 'test') { echo 'active'; } ?>">
            <a href="?page=test" class="waves-effect waves-teal"><i class="fa fa-file-text-o"></i> Manajemen Test</a>
         </li>
         <li class="bold <?php if ($_REQUEST['page'] == 'nilai') { echo 'active'; } ?>">
            <a href="?page=nilai" class="waves-effect waves-teal"><i class="fa fa-list"></i> Daftar Nilai</a>
         </li>
         <?php
      }
      ?>
      <li class="bold <?php if ($_REQUEST['page'] == 'user') { echo 'active'; } ?>">
         <a href="?page=user" class="waves-effect waves-teal"><i class="fa fa-group"></i> Daftar User Online</a>
      </li>
      <li class="bold <?php if ($_REQUEST['page'] == 'materi') { echo 'active'; } ?>">
         <a href="?page=materi" class="waves-effect waves-teal"><i class="fa fa-book"></i> Manajemen Materi</a>
      </li>
      <li class="bold <?php if ($_REQUEST['page'] == 'daftar_kelas') { echo 'active'; } ?>">
         <a href="?page=daftar_kelas" class="waves-effect waves-teal"><i class="fa fa-home"></i> Daftar Kelas</a>
      </li>
   </ul>
