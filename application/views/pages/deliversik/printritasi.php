<!DOCTYPE html>
<html>
<head>
	<title>LAPORAN RITASI SUPIR</title>
	<style type="text/css">
		body {
			font-size: 12px;
		}
		table tr th {
			padding: 5px;
		}
	</style>
</head>
<body>
	<h2 style="text-align: center;">LAPORAN RITASI SOPIR</h2>
	<table style="width: 100%;">
			<tr>
				<th  style="text-align: left;">Tanggal Kirim</th>
				<th style="text-align: left;">: <?=date('d F Y', strtotime($data['date']))?></th>
			</tr>
			<tr>
				<th  style="text-align: left;">No Mobil</th>
				<th style="text-align: left;">: <?=$spm['no_mobil']?></th>
			</tr>
			<tr>
				<th  style="text-align: left;">Nama Sopir</th>
				<th style="text-align: left;">: <?=$supir['nama']?></th>
			</tr>
			<tr>
				<th  style="text-align: left;">Nama Kenek</th>
				<th style="text-align: left;">: <?=$supir['nama_kenek']?></th>
			</tr>
			<tr>
				<th  style="text-align: left;">Proyek / Lokasi Pengiriman</th>
				<th style="text-align: left;">: <?=$qo['proyek']?></th>
			</tr>
			<tr>
				<th  style="text-align: left;">Rit Ke</th>
				<th style="text-align: left;">: <?=$rit_ke?></th>
			</tr>
			<tr>
				<th  style="text-align: left;">Area / Daerah</th>
				<th style="text-align: left;">: <?=$qo['area']?></th>
			</tr>
			<tr>
				<th  style="text-align: left;">Nilai Rp. </th>
				<th style="text-align: left;">: </th>
			</tr>
			<tr>
				<th  style="text-align: left;">Komponen</th>
				<th style="text-align: left;">: 
				<?php 
					$produk = $this->db->query("SELECT p.kode, p.weight, q.volume FROM surat_perintah_muat_product q inner join products p on p.id=q.product_id where q.surat_perintah_muat_id={$spm['id']}")->result_array();
					$berat = 0;
					foreach($produk as $i){
						echo $i['kode'] . ',';
						$berat += $i['volume']* $i['weight'];
					}
				?>

				</th>
			</tr>
			<tr>
				<th  style="text-align: left;">Berat Komponen</th>
				<th style="text-align: left;">: <?=round($berat/ 1000, 1)?> Ton</th>
			</tr>
			<tr>
				<th  style="text-align: left;">Pengembalian Barang</th>
				<th style="text-align: left;">: </th>
			</tr>
			<tr>
				<th  style="text-align: left;">Keterangan</th>
				<th style="text-align: left;">:</th>
			</tr>
		</table>

		<div style="float: left; width: 50%;text-align: center;">
			<p><strong>TTD Supir</strong></p>
			<br />
			<br />
			<p>(............................................)</p>
		</div>
		<div style="float: left; width: 50%;text-align: center;">
			<p><strong>Dibuat Oleh</strong></p>
			<br />
			<br />
			<p>(............................................)</p>
		</div>
	</div>
</body>
</html>