<?php
$server = "localhost"; 
$user = "root";
$pass = "";
$database = "amrydbase";

$koneksi = mysqli_connect($server, $user, $pass, $database) or die(mysqli_error($koneksi));

if (isset($_POST['bsimpan'])) {
	if ($_GET['hal'] == "edit") {
		$edit = mysqli_query($koneksi, "UPDATE tabelmahasiswa set
											 	nim = '$_POST[tnim]',
											 	nama = '$_POST[tnama]',
												email = '$_POST[temail]',
											 	lahir = '$_POST[tlahir]'
											 WHERE id_mhs = '$_GET[id]'
										   ");
		if ($edit) {
			echo "<script>
						alert('Data Telah Terupdate');
						document.location='index.php';
				     </script>";
		} else {
			echo "<script>
						alert('Data Gagal Terupdate');
						document.location='index.php';
				     </script>";
		}
	} else {
		$simpan = mysqli_query($koneksi, "INSERT INTO tabelmahasiswa (nim, nama, email, lahir)
										  VALUES ('$_POST[tnim]', 
										  		 '$_POST[tnama]', 
										  		 '$_POST[temail]', 
										  		 '$_POST[tlahir]')
										 ");
		if ($simpan) {
			echo "<script>
						alert('Data Telah Tersimpan');
						document.location='index.php';
				     </script>";
		} else {
			echo "<script>
						alert('Data Gagal Tersimpan');
						document.location='index.php';
				     </script>";
		}
	}
}


if (isset($_GET['hal'])) {
	if ($_GET['hal'] == "edit") {
		$tampil = mysqli_query($koneksi, "SELECT * FROM tabelmahasiswa WHERE id_mhs = '$_GET[id]' ");
		$data = mysqli_fetch_array($tampil);
		if ($data) {
			$vnim = $data['nim'];
			$vnama = $data['nama'];
			$vemail = $data['email'];
			$vlahir = $data['lahir'];
		}
	} else if ($_GET['hal'] == "hapus") {
		$hapus = mysqli_query($koneksi, "DELETE FROM tabelmahasiswa WHERE id_mhs = '$_GET[id]' ");
		if ($hapus) {
			echo "<script>
						alert('Data Telah Terhapus');
						document.location='index.php';
				     </script>";
		}
	}
}

?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
	<link rel="stylesheet" href="style.css">
	<title>Daftar Mahasiswa</title>
</head>

<body class="bg-light">
	<br>
	<div class="container-fluid card btn">
		<h1 class="text-center card bg-success text-white atas">Data Mahasiswa</h1>
		<div class="row">
			<div class="col">
				<div class="card bg-light">
					<div class="card-header bg-primary text-white">
						Input Data Mahasiswa
					</div>
					<div class="card-body">
						<form method="post" action="">
							<div class="form-group">
								<label for="nim">NIM</label>
								<input id="nim" type="text" name="tnim" value="<?= @$vnim ?>" class="form-control" placeholder="NIM" required>
							</div>
							<div class="form-group">
								<label for="nama">Nama</label>
								<input id="nama" type="text" name="tnama" value="<?= @$vnama ?>" class="form-control" placeholder="Nama" required>
							</div>
							<div class="form-group">
								<label for="email">E-mail</label>
								<input id="email" type="email" name="temail" value="<?= @$vemail ?>" class="form-control" placeholder="E-mail" required>
							</div>
							<div class="form-group">
								<label for="lahir">Tanggal Lahir</label>
								<input id="lahir" type="date" name="tlahir" value="<?= @$vlahir  ?>" class="form-control" placeholder="2001-01-01" required>
							</div>
							<br>
							<div>
								<button type="submit" class="btn btn-success tombol kiri" name="bsimpan">Simpan</button>
								<button type="reset" class="btn btn-danger tombol" name="breset">Reset</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="col">
				<div class="card">
					<div class="card-header bg-primary text-white">
						Daftar Mahasiswa
					</div>
					<div class="card-body bg-light">

						<table class="table table-bordered table-striped table-hover">
							<tr>
								<th>No.</th>
								<th>Nim</th>
								<th>Nama</th>
								<th>E-mail</th>
								<th>Tanggal Lahir</th>
								<th>Aksi</th>

							</tr>
							<?php
							$no = 1;
							$tampil = mysqli_query($koneksi, "SELECT * from tabelmahasiswa order by id_mhs desc");
							while ($data = mysqli_fetch_array($tampil)) :

							?>
								<tr>
									<td><?= $no++; ?></td>
									<td><?= $data['nim'] ?></td>
									<td><?= $data['nama'] ?></td>
									<td><?= $data['email'] ?></td>
									<td><?= $data['lahir'] ?></td>
									<td>
										<a href="index.php?hal=edit&id=<?= $data['id_mhs'] ?>" class="btn btn-warning tombol atas"> Edit </a>
										<a href="index.php?hal=hapus&id=<?= $data['id_mhs'] ?>" onclick="return confirm('Apakah yakin ingin menghapus data ini?')" class="btn btn-danger tombol"> Hapus </a>
									</td>
								</tr>
							<?php endwhile; ?>
						</table>

					</div>
				</div>
			</div>
		</div>
	</div>
</body>

</html>