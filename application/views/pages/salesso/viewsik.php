<!DOCTYPE html>
<html>
<head>
	<title>Surat Izin Kirim - <?=$data['no_sik']?></title>

	<style type="text/css">
		body {
			font-size: 10px;
		}
		.green {
			color: #3f687e;
		}
		table.table {
			width: 100%;
		}
		table.table tr th {
			background: #3f687e;
			color: white;
		}
		table.table tr td, table.table tr th {
			padding: 5px 10px;
			border: 1px solid;
		}	
		table.right {
			float: right;
			width: 100%;
		}
	</style>
</head>
<body>
	<img src="<?=site_url()?>assets/images/logo.png" style="width: 250px;float: left;" />
	<h2 style="text-align: center;" class="green"><i><u>Surat Izin Kirim (SIK)</u></i></h2>
	<table class="right">
		<tr>
			<td>
				Jl. Ciputat Raya No. 20 H Pondok Pinang Jakarta 12310<br />
				No. Formulir : FOR-B0107<br />
				18 Desember 2014
			</td>
		</tr>
		<tr>
			<td>
				<table>
					<tr>
						<td><h3><u><i>No Index</i></u></h3></td>
						<td></td>
					</tr>
					<tr>
						<td>Tanggal Terbit</td>
						<td><?=date('d F Y')?></td>
					</tr>
					<tr>
						<td>Untuk Pengiriman Tanggal</td>
						<td><?=date('d F Y', strtotime(date('Y-m-d') . ' +1 day'))?></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<br style="clear;" />
	<table class="table">
		<thead>
			<tr>
				<tH>No</th>
				<tH>No. SIK</th>
				<tH>Sales</th>
				<tH>Customer</th>
				<tH>Alamat Pengiriman</th>
				<tH>Deskripsi Produk</th>
				<th>Jumlah</th>
				<th>Ton</th>
				<th>Keterangan</th>
				<th>Feedback SIK</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$product = $this->db->get_where('quotation_order_products', ['quotation_order_id']); 
				$num_row = $product->num_rows(); 
			?>
			<tr>
				<td rowspan="<?=($num_row+1)?>">1</td>
				<td rowspan="<?=($num_row+1)?>"><?=$so['no_po']?></td>
				<td rowspan="<?=($num_row+1)?>"><?=$so['sales']?></td>
				<td rowspan="<?=($num_row+1)?>"><?=$so['customer']?></td>
				<td rowspan="<?=($num_row+1)?>"><?=$data['alamat_pengiriman']?></td>
			</tr>
			<?php 

				foreach($product->result_array() as $key => $item){
			?>
				<tr>
					<td><?=$item['uraian']?></td>
					<td style="text-align: right;"><?=$item['vol']?></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
</body>
</html>