<?php

	if (empty($_SESSION['type']) || $_SESSION['type'] != 1 || empty($_REQUEST['id'])) {
		header('location:../');
	}

	//cek apakah $_REQUEST['update'] telah diset
	if (isset($_REQUEST['update'])) {
		$nis        = addslashes($_REQUEST['nis']);
		$user       = addslashes($_REQUEST['user']);
		$fullname   = addslashes($_REQUEST['nama']);
		$kls        = $_REQUEST['kls'];
		$jk         = $_REQUEST['jk'];
		$tgl        = $_REQUEST['tgl'];
		$alamat     = addslashes(htmlspecialchars($_REQUEST['alamat']));
		$ayah       = addslashes($_REQUEST['ayah']);
		$ibu        = addslashes($_REQUEST['ibu']);
		$id         = $_REQUEST['id_siswa'];

		$sql = "UPDATE t_siswa SET nis = '$nis', username = '$user', fullname = '$fullname', id_kelas = '$kls', jk = '$jk', tgl = '$tgl', alamat = '$alamat', ayah = '$ayah', ibu = '$ibu' WHERE nis = '$id'";

		if ($nis == '' || $user == '' ||$fullname == '' || $jk == '' || $tgl == '' || $ayah == '' || $ibu == '' || $alamat == '') {
			echo '<script type="text/javascript">alert(" NIS / Username / Fullname / Jenis Kelamin / Tgl lahir / Nama Ayah / Nama Ibu tidak boleh kosong !");</script>';
		}
		//validasi umur
		elseif ((date("Y")-date("Y", strtotime($tgl))) < 14 || (date("Y")-date("Y", strtotime($tgl))) > 20 ){
			echo '<script type="text/javascript">alert("Siswa Belum Cukup Umur !");</script>';
		}
		//cek apaka ada perubahan nis
		elseif ($nis == $id) {
			mysqli_query($mysqli, $sql);
			header("location:?page=daftar_siswa");
		}
		//hitung jika ada perubahan nis
		elseif(mysqli_num_rows(mysqli_query($mysqli, "SELECT * FROM t_siswa WHERE nis = '$nis'")) > 0){
			echo '<script type="text/javascript">alert("NIS tidak tersedia silahkan coba lagi!")</script>';
		} else {
			mysqli_query($mysqli, $sql);
			header("location:?page=daftar_siswa");
		}

	}

	$id   = mysqli_real_escape_string($mysqli, $_REQUEST['id']);
	$sql  = "SELECT * FROM t_siswa INNER JOIN t_kelas ON t_kelas.id_kelas = t_siswa.id_kelas WHERE nis = '$id'";
	$data = mysqli_fetch_array(mysqli_query($mysqli, $sql));
?>
	<h4>Edit Data Siswa</h4>
	<br />
	<div class="row"> <!-- start row -->

		<form class="col s12 m10 l10 offset-l1" action="" method="post" id="form"> <!-- start form -->

			<input type="hidden" value="<?php  echo $data['nis']; ?>" name="id_siswa" />
			<input type="hidden" name="password" value="<?php  echo $data['password']; ?>" />

			<div class="row jarak"> <!-- start row nis -->
				<div class="input-field col s7">
					<i class="fa fa-credit-card prefix"></i>
					<input id="nip" type="text" value="<?php  echo $data['nis']; ?>" length="10" maxlength="10" name="nis" required="NIS" data-validation="custom length" data-validation-regexp="^([0-9]+)$" data-validation-length="10" />
					<label for="nip">NIS</label>
				</div>
			</div> <!-- end row nis -->

			<div class="row jarak"> <!-- start row username -->
				<div class="input-field col s7">
					<i class="fa fa-user prefix"></i>
					<input id="username" type="text" value="<?php  echo $data['username']; ?>" name="user" data-validation="length" data-validation-length="3-35" required="Username" />
					<label for="username">Username</label>
				</div>
			</div> <!-- end row username -->

			<div class="row jarak"> <!-- start row fullname -->
				<div class="input-field col s7">
					<i class="fa fa-user prefix"></i>
					<input id="fullname" type="text" value="<?php  echo $data['fullname']; ?>" length="45" maxlength="45" name="nama" required="fullname" data-validation="custom length" data-validation-regexp="^([a-zA-Z \.\,\']+)$" data-validation-length="3-45" />
					<label for="fullname">Fullname</label>
				</div>
			</div> <!-- end row fullname -->

			<div class="row jarak"> <!-- start row jenis kelamin -->
				<div class="col s7">
					<i class="fa fa-venus-mars prefix"></i>
					<label>Jenis Kelamin</label>
					<select class="browser-default" name="jk" required="Jenis Kelamin">
						<option value="L">Laki - laki</option>
						<option value="P" <?php if ($data['jk'] == 'P') { echo 'selected'; } ?>>Perempuan</option>
					</select>
				</div>
			</div> <!-- end row jenis kelamin -->

			<div class="row jarak"> <!-- start row kelas -->
				<div class="col s8">
					<i class="fa fa-home prefix"></i>
					<label>Kelas</label>
					<select class="browser-default" name="kls" required="Kelas">
						<?php
 						$pilih = mysqli_query($mysqli, "SELECT * FROM t_kelas");
						while ($key = mysqli_fetch_array($pilih)) {
						?>
							<option value="<?php  echo $key['id_kelas']; ?>" <?php if ($data['id_kelas'] == $key['id_kelas']) { echo 'selected'; } ?> >
								<?php  echo $key['nama_kelas']; ?>
							</option>
						<?php
						}
						?>
					</select>
				</div>
			</div> <!-- end row kelas -->

			<div class="row jarak"> <!-- start row tgl lahir -->
				<div class="input-field col s7">
					<i class="fa fa-calendar prefix"></i>
					<input type="text" class="datepicker" value="<?php  echo $data['tgl']; ?>" required="Tanggal Lahir" name="tgl" placeholder="tanggal lahir" />
				</div>
			</div> <!-- end row tgl lahir -->

			<div class="row jarak"> <!--start row alamat -->
				<div class="input-field col s7">
					<i class="fa fa-map prefix"></i>
					<textarea id="textarea1" class="materialize-textarea" length="120" maxlength="120" name="alamat" data-validation="length" data-validation-length="4-120"><?php  echo $data['alamat']; ?></textarea>
					<label for="textarea1">Alamat</label>
				</div>
			</div> <!-- end row alamat -->

			<div class="row jarak">	<!-- start row ayah -->
				<div class="input-field col s8">
					<i class="fa fa-user prefix"></i>
					<input id="ayah" type="text" length="35" maxlength="35" name="ayah" required="Nama Ayah" value="<?php  echo $data['ayah']; ?>" data-validation="custom length" data-validation-regexp="^([a-zA-Z \'\,\.]+)$" data-validation-length="3-45" />
					<label for="ayah">Nama Ayah</label>
				</div>
			</div> <!-- end row ayah -->

			<div class="row jarak"> <!-- start row ibu -->
				<div class="input-field col s8">
					<i class="fa fa-user prefix"></i>
					<input id="ibu" type="text" length="35" maxlength="35" name="ibu" required="Nama Ibu" value="<?php  echo $data['ibu']; ?>" data-validation="custom length" data-validation-regexp="^([a-zA-Z \'\,\.]+)$" data-validation-length="3-45" />
					<label for="ibu">Nama Ibu</label>
				</div>
			</div> <!-- end row ibu -->
			<br />
			<div class="row">	<!-- start row button -->
				<div class="input-field col s6 right">
					<button class="btn waves-effect waves-light green lighten-1" type="submit" name="update">
						Update<i class="fa fa-send"></i>
					</button>
					<a href="?page=daftar_siswa" class="btn waves-effect waves-light red">
						Batal <i class="fa fa-times"></i>
					</a>
				</div>
			</div> <!-- end row button -->

		</form> <!-- end form -->

	</div> <!-- end row -->
