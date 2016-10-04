<?php

	if (empty($_SESSION['type']) || $_SESSION['type'] != 1) {
		header('location:./');
	}

	//cek apakah $_REQUEST['aksi'] telah diset
	if (isset($_REQUEST['aksi'])) {
		switch ($_REQUEST['aksi']) {
			case 'add':
				include_once('add_guru.php');
				break;
			case 'edit':
				include_once('edit_guru.php');
				break;
			case 'delete':
				mysqli_query($mysqli, "DELETE FROM t_guru WHERE id_guru = '$_REQUEST[id]'");

				if ($_REQUEST['ft'] != '' && $_REQUEST['ft'] != 'default.png') {
					unlink("../assets/img/".$_REQUEST['ft']);
				}
				header('location:?page=daftar_guru');
				break;
			case 'detail':
				include_once('detail_guru.php');
				break;
			case 'status':
				if ($_REQUEST['status'] == "Y") {
					mysqli_query($mysqli, "UPDATE t_guru SET status = 'N' WHERE id_guru = '$_REQUEST[id]'");
				} else {
					mysqli_query($mysqli, "UPDATE t_guru SET status = 'Y' WHERE id_guru = '$_REQUEST[id]'");
				}
				echo '<script type="text/javascript">window.history.go(-1);</script>';
				break;
			case 'password':
				include_once('password.php');
				break;
		}

	} else {
	//cek apakah $_REQUEST['hlm'] telah diset
	if (isset($_REQUEST['hlm'])) {
		$hlm = $_REQUEST['hlm'];
		$no  = (6*$hlm) - 5;
	} else {
		$hlm = 1;
		$no  = 1;
	}
?>

	<div style="padding-right:30px; padding-top:20px;">
		<a class="btn-floating waves-effect waves-light right blue lighten-1" href="?page=daftar_guru&aksi=add">
			<i class="fa fa-user-plus left"></i>
		</a>
	</div>
	<h4>Daftar Guru</h4>
	<br />
	<table class="striped">
		<thead>
			<tr>
				<th width="40" class="center">No</th>
				<th width="150" class="center">NIP</th>
				<th width="200" class="center">Nama Lengkap</th>
				<th width="200" class="center">Status</th>
				<th width="200" class="center">Opsi</th>
			</tr>
		</thead>
		<tbody>
			<?php

			if ( mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM t_guru")) <= 0 ){
				echo '<tr><td class="center" colspan="5"><i>BELUM ADA DATA</i></td></tr>';
			} else {
				$start  = ($hlm - 1) * 6;
				$row = mysqli_query($mysqli, "SELECT * FROM t_guru LIMIT $start, 6");
				while ($data = mysqli_fetch_array($row)) {
			?>
					<tr>
						<td class="center">
							<?php  echo $no++; ?>
						</td>
						<td class="center">
						<?php
							if($data['nip'] == ''){
								echo "-";
							} else {
								echo $data['nip'];
							}
						?>
						</td>
						<td>
							<?php  echo $data['fullname']; ?>
						</td>
						<td class="center">
						<?php
							if ($data['status'] == "Y") {
								echo '<a href="?page=daftar_guru&aksi=status&id='.$data['id_guru'].'&status='.$data['status'].'" class="btn green lighten-1">Aktif</a>';
							} else {
								echo '<a href="?page=daftar_guru&aksi=status&id='.$data['id_guru'].'&status='.$data['status'].'" class="btn red lighten-1">Nonaktif</a>';
							}
						?>
						</td>
						<td class="center">
							<a href="?page=daftar_guru&aksi=detail&id=<?php  echo $data['id_guru']; ?>" class="btn-floating green lighten-1">
								<i class="fa fa-eye"></i>
							</a>
							&nbsp; <!-- hanya spasi -->
							<a href="?page=daftar_guru&aksi=edit&id=<?php  echo $data['id_guru']; ?>" class="btn-floating blue lighten-1">
								<i class="fa fa-pencil"></i>
							</a>
							&nbsp; <!-- hanya spasi -->
							<a href="?page=daftar_guru&aksi=delete&id=<?php  echo $data['id_guru']; ?>&ft=<?php  echo $data['foto']; ?>" class="btn-floating red" onclick="return confirm('Yakin Ingin Mengahapus data ini?')">
								<i class="fa fa-trash"></i>
							</a>
							&nbsp; <!-- hanya spasi -->
							<a href="?page=daftar_guru&aksi=password&id=<?php  echo $data['id_guru']; ?>" class="btn-floating yellow darken-4">
								<i class="fa fa-key"></i>
							</a>
						</td>
					</tr>
			<?php
				} //end while
			}	//end else hitung guru
			?>
		</tbody>
	</table>

	<ul class="pagination">
	<?php
		if($hlm > 1){
			$hlmn = $hlm - 1;
			echo "<li class='waves-effect'><a href='?page=daftar_guru&hlm=$hlmn'><i class='fa fa-caret-left'></i> Prev</a></li>";
		}

		$hitung = mysqli_num_rows(mysqli_query($mysqli, "SELECT * FROM t_guru"));
		$total  = ceil($hitung / 6);
		for ($i=1; $i <= $total ; $i++) {
	?>
			<li <?php if ($hlm != $i) { echo 'class="waves-effect"'; } else { echo 'class="active"'; } ?>>
				<a href="?page=daftar_guru&hlm=<?php  echo $i; ?>">
					<?php  echo $i; ?>
				</a>
			</li>
	<?php
		} // end for

		if ($hlm < $total) {
			$next = $hlm + 1;
			echo "<li class='waves-effect'><a href='?page=daftar_guru&hlm=$next'>Next <i class='fa fa-caret-right'></i></a></li>";
		}
	echo '</ul>';
	} //end else isset $_REQUEST['aksi']
	?>
