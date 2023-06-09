<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<!-- SweetAlert JS -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.3/dist/sweetalert2.min.css">
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.3/dist/sweetalert2.min.js"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

	<title>UNK Twibbon</title>
	<meta name="description" content="Universitas Negeri Konoha twibbon Maker">
	<meta name="keyword" content="UNK, UNK Twibbon Maker, twibbon Maker">
	<!-- Google Fonts -->
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Courgette&family=Playfair+Display:wght@500&display=swap" rel="stylesheet">
	<!-- Google reCAPTCHA -->
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
	<!-- jQuery -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
	<style>
		body, head {
			background-image: url('https://gcdnb.pbrd.co/images/qMyTjzHQiQmB.jpg');
			background-size: cover;
			font-family: 'Playfair Display';
		}
	</style>
</head>
<body>
	<!-- Hidden images untuk template twibbon -->
	<img src="twibbon1.png" id="twibbon1" width="1000px" height="1000px" hidden="true" class="img-fluid">
	<img src="twibbon2.png" id="twibbon2" width="1000px" height="1000px" hidden="true" class="img-fluid">
	<img src="twibbon3.png" id="twibbon3" width="1000px" height="1000px" hidden="true" class="img-fluid">
	<img src="twibbon4.png" id="twibbon4" width="1000px" height="1000px" hidden="true" class="img-fluid">
	<!-- Navbar -->
	<nav class="navbar navbar-light bg-white shadow-sm">
		<div class="container">
			<a class="navbar-brand">
				<span class="navbar-brand mb-0 h1">UNK Twibbon Maker</span>
			</a>
		</div>
	</nav>
	<!-- Card untuk memunculkan -->
	<div class="container my-5">
		<div class="row">
			<div class="col-lg-6 offset-lg-3 col-md-12 mb-4">
				<div class="card card-body shadow-sm mb-4">
					<?php
						// Validasi file yang di upload
						if (isset($_POST['submit']))
						{
							$namafile       = $_FILES["file"]["name"];
							$filegambar     = substr($namafile, 0, strripos($namafile, '.'));
							$ekstensifile   = substr($namafile, strripos($namafile, '.'));
							$ukuranfile     = $_FILES["file"]["size"];
							$jenisfile      = array('.jpg','.jpeg','.png', '.JPG','.JPEG','.PNG');

							if (!empty($filegambar))
							{
								if ($ukuranfile <= 5000000)
								{
									if (in_array($ekstensifile, $jenisfile) && ($ukuranfile <= 5000000))
									{
										$namabaru = time().'_'.uniqid().'_n'.$ekstensifile;
										if (file_exists("images/" . $namabaru))
										{
											echo '<script>';
											echo 'swal("Error!", "Terjadi kesalahan silahkan coba lagi", "error").then(() => {
												window.location.href = "index.html";
											});';
										echo '</script>';
										exit;
									}
									else
									{       
										move_uploaded_file($_FILES["file"]["tmp_name"], "images/" . $namabaru);
										$gambar = "images/" . $namabaru;

										// Menampilkan image dan canvas
										echo '<img src="'.$gambar.'" id="img1" width="1000px" height="1000px" hidden="true" class="img-fluid">';
										echo '<img src="" id="img2" width="1000px" height="1000px" hidden="true" class="img-fluid">';
										echo '<h2><canvas id="canvas" class="img-fluid"></canvas></h2>';
									}
								}
								else
								{
									echo '<script>';
									echo 'swal("Error!", "File harus gambar", "error").then(() => {
										window.location.href = "index.html";
									});';
								echo '</script>';
								exit;
							} 
						}
						else
						{
							echo '<script>';
							echo 'swal("Error!", "Ukuran file tidak boleh lebih dari 5MB", "error").then(() => {
								window.location.href = "index.html";
							});';
						echo '</script>';
						exit;
					}
				}
				else
				{
					echo '<script>';
					echo 'swal("Error!", "Gambar tidak boleh kosong", "error").then(() => {
						window.location.href = "index.html";
					});';
				echo '</script>';
				exit;
			}
		}
	?>

	<!-- Konten html -->
	<h6 class="font-weight-normal mt-1">Harap Pilih Template Twibbon</h6>
	<select class="form-control" id="twibbonSelect">
		<option selected>--- Pilih Twibbon ---</option>
		<option value="twibbon1">Rekayasa Perangkat Lunak</option>
		<option value="twibbon2">Akuntansi</option>
		<option value="twibbon3">Teknik Industri</option>
		<option value="twibbon4">Manajemen</option>
	</select>
	<a id="download" class="btn btn-outline-primary btn-sm mt-3">Download gambar</a>
	<button class="btn btn-outline-danger btn-sm mt-3" id="reset">Reset Gambar</button>
</form>
</div>

<script>
	$(document).ready(function() {
		var img1 = $('#img1')[0];
		var img2 = $('#img2')[0];
		var canvas = $('#canvas')[0];
		var context = canvas.getContext("2d");
		var width = img2.width;
		var height = img2.height;
		canvas.width = width;
		canvas.height = height;
		var twibbonSelect = $('#twibbonSelect');
		var selectedTwibbonImg;

				// Event saat dropdown template twibbon berubah
		twibbonSelect.on('change', function() {
			var selectedTwibbon = twibbonSelect.val();
			selectedTwibbonImg = $('#' + selectedTwibbon)[0];
			drawImages();
		});

				// gambar awal tanpa twibbon
		img1.src = img1.getAttribute('src');
		img1.onload = function() {
			selectedTwibbonImg = img1;
			drawImages();
		};

				// Function draw images ke canvas
		function drawImages() {
			context.clearRect(0, 0, canvas.width, canvas.height);
			context.drawImage(img1, 0, 0, width, height);
			if (selectedTwibbonImg) {
				context.drawImage(selectedTwibbonImg, 0, 0, width, height);
			}
		}
	});

			// Function download hasil canvas
	function downloadCanvas(link, canvasId, filename) {
		link.href = document.getElementById(canvasId).toDataURL();
		link.download = filename;
	}

			// Event saat "Download gambar" button di klik
	$('#download').click(function() {
		downloadCanvas(this, 'canvas', 'bsitwibbon.png');
	});

	document.getElementById('reset').addEventListener('click', function() {
  		Swal.fire({
   			title: 'Apakah Anda yakin?',
    		text: 'Pilihan yang Anda buat tidak dapat dibatalkan.',
   			icon: 'warning',
    		showCancelButton: true,
    		confirmButtonText: 'Ya',
    		cancelButtonText: 'Tidak'
  		}).then((result) => {
    		if (result.isConfirmed) {
				window.location.href = "index.html"
    	} 
  });
});


</script>	
</body>
</html>
