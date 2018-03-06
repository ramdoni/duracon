<!DOCTYPE html>
<html>
<head>
	<title>Lembar Kerja Harian <?=date('d D Y')?>   </title>
	<style type="text/css">
	body {
		font-size: 12px;
	}
	table {
		width: 100%;
		border-spacing: 0;
	}
	table tr td {
		border: 1px solid #494d45;
		margin: 0;
	}
	tr.header td {
		font-weight: bold;
		text-align: center;
	}
	.bg-green {
		background: #7eb651;
		border: 1px solid #7eb651;
	}
</style>
</head>
<body>
	<table>
		<tr>
			<td rowspan="4" colspan="2">
				<img src="<?=base_url()?>assets/images/logo.jpg" style="width: 200px;">
			</td>
			<td rowspan="2" style="text-align: center;">
				<h3>MANAGEMENT SYSTEM PROCEDURE</h3>			
			</td>
			<td>Halaman </td>
			<td>01</td>
		</tr>
		<tr>
			<td>Nomor Dokument</td>
			<td>B 0<?=$data['id']?></td>
		</tr>
		<tr>
			<td rowspan="2" style="text-align: center;"><h4>LEMBAR HARIAN KELOMPOK KERJA</h4></td>
			<td>Tanggal Terbit</td>
			<td><?=date('d F Y')?></td>
		</tr>
		<tr>
			<td>Revisi</td>
			<td> - </td>
		</tr>
		<tr>
			<td>Devisi</td>
			<td>Pengecoran</td>
			<td rowspan="6" colspan="3" style="text-align: right;">
				Tanggal
				<table style="width: auto;">
					<tr>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
						<td>&nbsp;<?=date('Y')?>&nbsp;</td>
					</tr>
				</table>

			</td>
		</tr>
		<tr>
			<td>Pusat Produksi</td>
			<td>Plan I</td>
		</tr>
		<tr>
			<td>Shift</td>
			<td><?=$_GET['shift']?></td>
		</tr>
		<tr>
			<td>Plan Jumlah Pekerja</td>
			<td><?=$data['plan_pekerja']?></td>
		</tr>
		<tr>
			<td>Aktual Jumlah Pekerja</td>
			<td></td>
		</tr>
		<tr>
			<td>Jam Lembur</td>
			<td></td>
		</tr>
		<tr>
			<td>Jumlah Pekerja</td>
			<td></td>
		</tr>
	</table>
	<table>
		<tr style="background: #efefef">
			<td colspan="2">Hasil Kerja</td>
			<td rowspan="2">Jumlah Cetakan</td>
			<td rowspan="2">Plan</td>
			<td rowspan="2">Jumlah Hasil Produksi</td>
			<td colspan="2">Quality Produk</td>
		</tr>
		<tr style="background: #efefef">
			<td>No</td>
			<td>Type Produk</td>
			<td>Finishing</td>
			<td>Reject</td>
		</tr>
		<?php foreach($list_plan as $key => $item):?>
			<tr>
				<td><?=($key+1)?></td>
				<td><?=$item['product']?> </td>
				<td style="text-align: right;"><?=$item['cetakan']?></td>
				<td style="text-align: right;"><?=$item['day'.$_GET['day'].'_shift'. $_GET['shift']]?></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
		<?php endforeach; ?>
		<tr>
			<td colspan="7"><strong>Keterangan ( Di isi Oleh Supervisor / Asisten )</strong></td>
		</tr>
		<tr>
			<td colspan="7" style="height: 100px;"></td>
		</tr>
	</table>
	<div style="width: 50%; margin: auto;">
		<div style="float: left; width: 50%;text-align: center;">
			<p>Disetujui</p>
			<br />
			<br />	
			(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)<br />
			Supervisor / Asisten
		</div>
		<div style="float: left; width: 50%;text-align: center;">
			<p>Mengetahui</p>
			<br />
			<br />	
			(M.Luftie)<br />
			Ka. Produksi
		</div>
	</div>
</body>
</html>