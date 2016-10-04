<?php

	if (empty($_SESSION['type']) || $_SESSION['type'] != 1) {
		header('location:./');
	}

	//cek $_REQUEST['update'] apakah telah diset
	if (isset($_REQUEST['update'])) {
		$npass   = MD5(MD5($_REQUEST['user']));
		$pass    = MD5(MD5($_REQUEST['admin']));
		$id      = mysqli_real_escape_string($mysqli, $_REQUEST['id']);
		switch ($_REQUEST['page']) {
			case 'daftar_guru':
				$sql = "UPDATE t_guru SET password = '$npass' WHERE id_guru = '$id'";
				break;
			case 'daftar_siswa':
				$sql = "UPDATE t_siswa SET password = '$npass' WHERE nis = '$id'";
				break;
		}

	$cek_admin = mysqli_query($mysqli, "SELECT * FROM t_admin WHERE password = '$pass'");

	if (mysqli_num_rows($cek_admin) <= 0) {
		echo '<script type="text/javascript">alert("Password Admin ditolak!!! Akses Illegal !!!");window.location = "?page=logout";</script>';
	} else {
		mysqli_query($mysqli, $sql);
		echo '<script type="text/javascript">window.location = "?page='.$_REQUEST['page'].'";</script>';
	}

}

	$iduser = mysqli_real_escape_string($mysqli, $_REQUEST['id']);
?>
	<h4>Ganti Password</h4>
	<br />
	<br />
	<div class="row"> <!-- start row -->

		<form class="col l8 m6 s12 offset-l1 offset-m3" action="" method="post" id="form"> <!-- start form -->

			<input type="hidden" name="id" value="<?php  echo $iduser; ?>" />

			<div class="row jarak"> <!-- start row pass lama -->
				<div class="input-field col s12">
					<i class="fa fa-key prefix"></i>
					<input id="pass_prefix1" type="password" class="validate" name="admin" required="password" data-validation="length" data-validation-length="min5" />
					<label for="pass_prefix1">Password Admin</label>
				</div>
			</div> <!-- end pass lama -->

			<div class="row jarak"> <!-- start pass baru -->
				<div class="input-field col s12">
					<i class="fa fa-key prefix"></i>
					<input id="pass_prefix" type="password" class="validate" name="user" required="password" data-validation="length" data-validation-length="min5" />
					<label for="pass_prefix">Password</label>
				</div>
			</div> <!-- end pass baru -->
			<br />
			<div class="row"> <!-- start row button -->
				<div class="input-field right">
					<button class="btn waves-effect waves-light green lighten-1" type="submit" name="update" onclick="return confirm('Yakin ingin merubah password akun ini ?')">
						Update <i class="fa fa-check right"></i>
					</button>
					<a href="./" class="btn waves-effect waves-light red">
     				Batal <i class="fa fa-arrow-left right"></i>
    			</a>
				</div>
			</div> <!-- end row button -->

		</form>	<!-- end form -->

	</div><!-- end row -->
