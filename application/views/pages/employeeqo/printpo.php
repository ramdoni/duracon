<!DOCTYPE html>
<html>
<head>
	<title>QUOTATION / ORDER ENTRY FORM</title>
	<style type="text/css">
		body {
			font-size: 12px;
		}
	</style>
</head>
<body>
	<p style="position: absolute; top: 0; right: 10px;"><?=date('d F Y')?></p>
	<?php 
		$pt = $this->db->get_where('customer', ['id' => $data['customer_id']])->row_array();
	?>
	<p>Nomor : <?=$data['no_po']?><br />
	Perihal : <?=$data['perihal']?><br />
	Kepada Yth,<br />
	<?=label_customer($data['customer_id'])?>
	</p>
	<table>
		<tr>
			<th style="width: 100px;text-align: left;">No. Telp</th>
			<td>: <?=$pt['telphone']?></td>
		</tr>
		<tr>
			<th style="width: 100px;text-align: left;">No. HP</th>
			<td>: <?=$pt['handphone']?></td>
		</tr>
		<tr>
			<th style="width: 100px;text-align: left;">No. Fax</th>
			<td>: <?=$pt['fax']?></td>
		</tr>
		<tr>
			<th style="width: 100px;text-align: left;">E-Mail</th>
			<td>: <?=$pt['email']?></td>
		</tr>
	</table>
	<p>
		Dengan Hormat<br />
		Dengan ini kami bermaksud untuk memberikan Harga Beton Pracetak, berikut perinciannya;<br />
		Proyek : <strong><?=$data['proyek']?></strong>
	</p>
	<table border="1" width="100%">
		<tr>
			<td>No</td>
			<td>Uraian</td>
			<td>Volume</td>
			<td>Satuan</td>
			<td>Harga Satuan</td>
			<td>Total Harga</td>
		</tr>
		<?php 
			$product = $this->db->get_where('quotation_order_products', ['quotation_order_id' => $data['id']])->result_array();
			$total_price = 0;
		?>
		<?php foreach($product as $key => $item):

			$temp_price = 0;
			$temp_price = ($item['harga_satuan'] - ($item['harga_satuan']*($item['disc_ppn'] / 100)));

			$total_price +=$temp_price * $item['vol'];

			$p = $this->db->get_where('products', ['id' => $item['product_id']])->row_array();
		?>
			<tr>
				<td><?=($key+1)?></td>
				<td><?=$p['uraian']?></td>
				<td><?=$item['vol']?></td>
				<td><?=$item['satuan']?></td>
				<td>Rp. <?=(number_format($temp_price))?></td>
				<td>Rp. <?=(number_format($temp_price*$item['vol']))?></td>
			</tr>
		<?php endforeach; ?>
		<?php 

		$ppn = (($total_price * 10) / 100);

		?>
			<tr>
				<td colspan="5" style="text-align: right;"><strong>Sub Total</strong>&nbsp;&nbsp;&nbsp;</td>
				<td><strong>Rp. <?=number_format($total_price)?></strong></td>
			</tr>
			<tr>
				<td colspan="5" style="text-align: right;"><strong>PPn 10 %</strong>&nbsp;&nbsp;&nbsp;</td>
				<td><strong>Rp. <?=number_format($ppn)?></strong></td>
			</tr>

			<tr>
				<td colspan="5" style="text-align: right;"><strong>TOTAL</strong>&nbsp;&nbsp;&nbsp;</td>
				<td><strong>Rp. <?=number_format($ppn+$total_price)?></strong></td>
			</tr>
			
		</table>
	<p>
		<u><strong>Catatan : </strong></u>
		<ul>
			<li>Harga diatas adalah pengiriman sampai proyek <?=($data['penurunan_barang'] == 'Setting' ? 'diatas Tanah' : 'diatas Truck')?>.</li>
			<li>Harga diatas tidak termasuk biaya kuli / preman dilapangan. </li>
			<li>Harga berlaku 14 (Empat Belas) hari setelah tanggal penawaran ini dikeluarkan.</li>
			<li>Sistem pembayaran : <strong><?=$data['sistem_pembayaran']?> <?=!empty($pt['kredit_overdue_day']) ? $pt['kredit_overdue_day'] .' Hari': ''?></strong></li>
		</ul>	
	<br />
	<strong>SPESIFIKASI TEKNIS</strong></p>
	<?php 
	$spesifikasi = $this->db->query("select ps.* from quotation_order_products ep
	inner join products p on p.id=ep.`product_id`
	inner join `product_specification` ps on ps.id=p.`product_specification_id`
	where quotation_order_id={$data['id']}
	group by p.`product_specification_id`
	;")->result_array();
	?>
	<?php 
		foreach($spesifikasi as $item):
	?>
	<h4><?=$item['spesifikasi']?></h4>
	<table>
		<tr>
			<td>Sistem Produksi</td>
			<td><?=$item['sistem_produksi']?></td>
		</tr>
		<tr>
			<td>Mutu Beton</td>
			<td><?=$item['mutu_beton']?></td>
		</tr>
		<tr>
			<td>Tipe Semen</td>
			<td><?=$item['tipe_semen']?></td>
		</tr>
		<tr>
			<td>System Joint</td>
			<td><?=$item['system_joint']?></td>
		</tr>
	</table>
	<?php endforeach; ?>

	Demikianlah spesifikasi Harga ini kami sampaikan, bila ada yang kurang jelas harap segera menghubungi kami.<br />
	Terima kasih atas perhatian Bapak/Ibu pada produk kami. Kami tunggu kabar baik dan kerjasama selanjutnya.
	<br />
	<div style="width: 40%; float: left;">
		<p>Mengetahui,<br />
			<strong>PT. DURACONINDO PRATAMA</strong>
		</p>
		<br />
		<p>
			<strong><i>Ir. M. MUCHLIS. M</i></strong>
			<br />Marketing Manager
			<br />Hp : +62 811 1636 969 
		</p>
	</div>
	<div style="width: 40%; float: right;">
		<p>Hormat Kami,<br />
		</p>
		<br />
		<p>
			<strong><i><?=$data['sales']?></i></strong>
			<br />Sales Engineer
			<br />Hp : +62 811 9920 066
		</p>
	</div>
</body>
</html>