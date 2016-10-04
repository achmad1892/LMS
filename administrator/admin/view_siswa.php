<?php

	if (empty($_SESSION['type']) || $_SESSION['type'] == 3) {
		header('location:./');
	}

	//cek $_REQUEST['aksi'] apakah diset
	if (isset($_REQUEST['aksi'])) {
		switch ($_REQUEST['aksi']) {
			case 'add':
				include_once('add_siswa.php');
				break;
			case 'inport':
				include_once('inport_siswa.php');
				break;
			case 'edit':
				include_once('edit_siswa.php');
				break;
			case 'delete':
				if($_REQUEST['ft'] != "default.png"){
					mysqli_query($mysqli, "DELETE FROM t_siswa WHERE nis = '$_REQUEST[id]'");

					if ($foto != "default.png" || $foto != '') {
						unlink("../assets/img/".$_REQUEST['ft']);
					}
				} else {
					mysqli_query($mysqli, "DELETE FROM t_siswa WHERE nis = '$_REQUEST[id]'");
				}
				header('location:?page=daftar_siswa');
				break;
			case 'detail':
				include_once('detail_siswa.php');
				break;
			case 'password':
				include_once('password.php');
				break;
			case 'status':
				if ($_REQUEST['status'] == "Y") {
					mysqli_query($mysqli, "UPDATE t_siswa SET status = 'N' WHERE nis = '$_REQUEST[id]'");
				} else {
					mysqli_query($mysqli, "UPDATE t_siswa SET status = 'Y' WHERE nis = '$_REQUEST[id]'");
				}
				header('location:?page=daftar_siswa');
				break;
		}

	} else {
		//cek $_REQUEST['hlm']
		if (isset($_REQUEST['hlm'])) {
			$hlm = $_REQUEST['hlm'];
			$no  = (6*$hlm) - 5;
		} else {
			$hlm = 1;
			$no  = 1;
		}

		if ($_SESSION['type'] == 1) {
			echo '<div class="right row">';
			echo '<div class="col m8">';
			echo '<form method="post" action="" class="row" id="form">';
			echo '<div class="input-field col m8">';
			echo '<input type="text" name="cari" placeholder="cari tahun angkatan..." data-validation="length number" data-validation-length="4" data-validation-allowing="float">';
			echo '</div>';
			echo '<div class="input-field col m2">';
			echo '<button type="submit" name="submi" style="background-color:transparent; border:none; padding-top:16px;"><i class="fa fa-search"></i></button>';
			echo '</div>';
			echo '</form>';
			echo '</div>';
			echo '<div class="col m2" style="padding-top:16px; align:left">';
			echo '<a class="btn-floating waves-effect waves-light green lighten-1" href="?page=daftar_siswa&aksi=inport"><i class="fa fa-upload"></i></a>';
			echo '</div>';
			echo '<div class="col m2" style="padding-top:16px; align:left">';
			echo '<a class="btn-floating waves-effect waves-light blue lighten-1" href="?page=daftar_siswa&aksi=add"><i class="fa fa-user-plus"></i></a>';
			echo '</div>';
			echo '</div>';
		}
?>
	<h4>Daftar Siswa</h4>
	<br />
	<table class="striped">
		<thead>
			<tr>
				<th class="center">No</th>
				<th class="center">NIS</th>
				<th class="center">Nama Lengkap</th>
				<?php
				if($_SESSION['type'] == 1) {
					echo '<th class="center">Status</th>';
				}
				?>
				<th class="center">Opsi</th>
			</tr>
		</thead>

		<tbody>
			<?php
			$start  = ($hlm - 1) * 6;

			if (isset($_REQUEST['idkelas'])) {
				$row = mysqli_query($mysqli, "SELECT * FROM t_siswa WHERE id_kelas = '$_REQUEST[idkelas]' LIMIT $start,6");
			} elseif (isset($_REQUEST['cari'])) {
				$row = mysqli_query($mysqli, "SELECT * FROM t_siswa WHERE angkatan = '$_REQUEST[cari]'");
			} else {
				$row = mysqli_query($mysqli, "SELECT * FROM t_siswa LIMIT $start,6");
			}

			if (mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM t_siswa")) <= 0){
				echo '<tr><td colspan="5" class="center"><i>BELUM ADA DATA</i></td></tr>';
			} else {
				while ($data = mysqli_fetch_array($row)) {
					echo '<tr>';
					echo '<td class="center">'.$no++.'</td>';
					echo '<td class="center">'.$data['nis'].'</td>';
					echo '<td>'.$data['fullname'].'</td>';

					if($_SESSION['type'] == 1) {
						echo '<td class="center">';

						if ($data['status'] == "Y") {
							echo '<a href="?page=daftar_siswa&aksi=status&id='.$data['nis'].'&status='.$data['status'].'" class="btn green lighten-1">Aktif</a>';
						} else {
							echo '<a href="?page=daftar_siswa&aksi=status&id='.$data['nis'].'&status='.$data['status'].'" class="btn red lighten-1">Nonaktif</a>';
						}

						echo '</td>';
					}

					echo '<td class="center">';
					echo '<a href="?page=daftar_siswa&aksi=detail&id='.$data['nis'].'" class="btn-floating green lighten-1"><i class="fa fa-eye"></i></a>';
					echo '&nbsp;';

					if($_SESSION['type'] == 1) {
						echo '<a href="?page=daftar_siswa&aksi=edit&id='.$data['nis'].'" class="btn-floating blue lighten-1"><i class="fa fa-pencil"></i></a>';
						echo '&nbsp;';
			?>
						<a href="?page=daftar_siswa&aksi=delete&id=<?php  echo $data['nis']; ?>&ft=<?php  echo $data['foto']; ?>" class="btn-floating red" onclick="return confirm('Yakin Ingin Mengahapus data ini?')"><i class="fa fa-trash"></i></a>
						<a href="?page=daftar_siswa&aksi=password&id=<?php  echo $data['nis']; ?>" class="btn-floating yellow darken-4"><i class="fa fa-key"></i></a>
					<?php
					}

					echo '</td>';
					echo '</tr>';
				} //end while

			} //end if hitung siswa
			?>
		</tbody>
	</table>

	<?php if (!isset($_REQUEST['cari'])) { ?>
			<ul class="pagination">	<!-- start pagination -->
			<?php
				if($hlm > 1){ //start if
					$hlmn = $hlm - 1;
			?>
					<li class="waves-effect">
						<a href="?page=daftar_siswa&hlm=<?php  echo $hlmn; ?><?php if(isset($_REQUEST['idkelas'])) { echo '&idkelas='.$_REQUEST['idkelas']; } ?>">
							<i class='fa fa-caret-left'></i> Prev
						</a>
					</li>
			<?php
				}		//end if $hlm > 1

				if (isset($_REQUEST['idkelas'])) {
					$hitung = mysqli_num_rows(mysqli_query($mysqli, "SELECT * FROM t_siswa WHERE id_kelas = '$_REQUEST[idkelas]'"));
				} else {
					$hitung = mysqli_num_rows(mysqli_query($mysqli, "SELECT * FROM t_siswa"));
				}

				$total  = ceil($hitung / 6);
				for ($i = 1; $i <= $total ; $i++) { //start for
			?>
					<li <?php if ($hlm != $i) { echo 'class="waves-effect"'; } else { echo 'class="active"'; } ?>>
						<a href="?page=daftar_siswa&hlm=<?php  echo $i; ?><?php if(isset($_REQUEST['idkelas'])) { echo '&idkelas='.$_REQUEST['idkelas']; } ?>">
							<?php  echo $i; ?>
						</a>
					</li>
				<?php
				} // end for

				if ($hlm < $total) { //start if $hlm < $total
					$next = $hlm + 1;
				?>
					<li class="waves-effect">
						<a href="?page=daftar_siswa&hlm=<?php  echo $next; ?><?php if(isset($_REQUEST['idkelas'])) { echo '&idkelas='.$_REQUEST['idkelas']; } ?>">
							Next <i class='fa fa-caret-right'></i>
						</a>
					</li>
				<?php
				}	//end if $hlm < $total

			echo '</ul>';	//end pagination
		} //end if isset $_REQUEST['search'];

	}
?>
