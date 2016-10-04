<?php

   if (empty($_SESSION['type']) || $_SESSION['type'] != 2) {
      header('location:./');
   }

   //cek apakah $_REQUEST['add'] telah diset
   if (isset($_REQUEST['add'])) {
      //cek apakah semua form terisi
      if ($_REQUEST['judul'] == '' || $_REQUEST['waktu'] == '' || $_REQUEST['kls'] == '') {
         echo '<script type="text/javascript">alert("Judul / Waktu / Kelas tidak boleh kosong !");</script>';
      } elseif(!preg_match("/^[0-9]*$/",$_REQUEST['waktu'])) { //validasi waktu agar menggunkan angka
         echo '<script type="text/javascript">alert("Waktu harus menggunakan angka !")</script>';
      } else {
         $judul  = addslashes($_REQUEST['judul']);
         $tgl    = date('Y-m-d');
         $wkt    = ($_REQUEST['waktu'] * 60);
         $kls    = $_REQUEST['kls'];

         $sql    = "INSERT INTO t_header_soal (judul, tgl_dibuat, waktu, id_index, publikasi) VALUES ('$judul', '$tgl', '$wkt', '$kls', 'N')";

         mysqli_query($mysqli, $sql);

         $data = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM t_header_soal ORDER BY id_header DESC"));
         header('location:?page=test&aksi=tambah_soal&id='.$data['id_header']);
      }
   }
?>

   <h4>Tambah Test</h4>
   <br />
   <div class="row"> <!-- start row -->

      <form action="" method="post" class="col s12 m10 l10 offset-l1">

         <div class="row"> <!-- start row judul -->
            <div class="input-field col s7">
               <input id="judul" type="text" length="255" maxlength="255" name="judul" required />
               <label for="judul">Judul Test</label>
            </div>
         </div> <!-- end row judul -->

         <div class="row"> <!-- start row waktu -->
            <div class="input-field col s7">
               <input id="waktu" type="text" length="4" maxlength="4" name="waktu" required />
               <label for="waktu">Waktu Pengerjaan</label>
               <p><small><i>* dalam menit</i></small></p>
            </div>
         </div> <!-- end row waktu -->

         <div class="col s7"> <!-- start row kelas -->
            <i class="fa fa-list"></i>
            <label>Kelas :</label>
            <select class="browser-default" name="kls" required>
               <option value="" disabled selected>--Pilih--</option>
               <?php
               $sql  = "SELECT * FROM t_index_mapel JOIN t_kelas ON t_index_mapel.id_kelas = t_kelas.id_kelas JOIN t_mapel ON t_index_mapel.id_mapel = t_mapel.id_mapel WHERE t_index_mapel.id_guru = '$_SESSION[id]'";

               $data = mysqli_query($mysqli, $sql);

               while ($key = mysqli_fetch_array($data)) { //start while
                  echo '<option value="'.$key['id_index'].'">'.$key['nama_mapel'].' ('.$key['nama_kelas'].')</option>';
               } //end while
               ?>
            </select>
         </div> <!-- end row kelas -->

         <div class="row"> <!-- start row button -->
            <div class="input-field col s6 right">
               <button class="btn waves-effect waves-light green lighten-1" type="submit" name="add">
                  Tambah <i class="fa fa-send right"></i>
               </button>
               <a href="?page=test" class="btn waves-effect waves-light red">
                  Batal <i class="fa fa-times right"></i>
               </a>
            </div>
         </div> <!-- end row button -->

      </form>

   </div><!-- end row -->
