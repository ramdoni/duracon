<!DOCTYPE html>
<html>
<head>
	<title>Surat Perintah Muat</title>
	<style type="text/css">
		body {
			font-size: 12px;
		}
		.kotak {
			border:2px solid black;
			padding:10px;
		}
	</style>
</head>
<body>
	<div class="kotak">
		<table style="width: 100%;">
			<tr>
				<th style="text-align: left;">Proyek  / Lokasi</th>
				<th style="text-align: left;">: <?=$qo['proyek']?></th>
				<th style="text-align: left;">No SPM</th>
				<th style="text-align: left;">: <?=$spm['no_spm']?></th>
			</tr>
			<tr>
				<th style="text-align: left;">No. Izin Kirim</th>
				<th style="text-align: left;">: <?=$sik['no_sik']?></th>
				<th style="text-align: left;">Tanggal</th>
				<th style="text-align: left;">: <?=date('d F Y')?></th>
			</tr>
			<tr>
				<th style="text-align: left;">No Mobil</th>
				<th style="text-align: left;">: <?=$mobil['no_mobil']?></th>
				<th style="text-align: left;">Supir</th>
				<th style="text-align: left;">: <?=$mobil['nama_supir']?></th>
			</tr>
		</table>
		<br />
		<table border="1" style="width: 100%;">
			<thead>
				<tr>
					<th colspan="4" style="text-align: center;"><h1>Surat Perintah Muat</h1></th>
				</tr>
				<tr>
					<th style="width: 5%;">No</th>
					<th>Type</th>
					<th>Jumlah</th>
					<th>Keterangan</th>
				</tr>
			</thead>
			<tbody>
				<?php 
					$data_product = $this->db->query("SELECT s.*, p.kode FROM surat_perintah_muat_product s inner join products  p on p.id=s.product_id WHERE surat_perintah_muat_id={$spm['id']}")->result_array();
				?>
				<?php foreach($data_product as $key => $item): ?>
				<tr>
					<td><?=$key+1?></td>
					<td><?=$item['kode']?></td>
					<td style="text-align: right;"><?=$item['volume']?></td>
					<td><?=$item['catatan']?></td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
		<p><strong>Note : Setelah Loading Muatan, Surat Perintah Muat Harus Dikembalikan Ke Loket</strong></p>

		<div style="float: left; width: 33%;text-align: center;">
			<p><strong>Kepala Delivery</strong></p>
			<br />
			<br />
			<p>......................</p>
		</div>
		<div style="float: left; width: 33%;text-align: center;">
			<p><strong>Driver</strong></p>
			<br />
			<br />
			<p>......................</p>
		</div>
		<div style="float: left; width: 33%;text-align: center;">
			<p><strong>Stokyard</strong></p>
			<br />
			<br />
			<p>......................</p>
		</div>
	</div>
</body>
</html>