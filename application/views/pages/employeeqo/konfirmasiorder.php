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
	<h2 style="text-align: center;"><i><u>KONFIRMASI ORDER</u></i></h2>
	<?php 
		$pt = $this->db->get_where('customer', ['id' => $data['customer_id']])->row_array();
		$sales = $this->db->get_where('user', ['id' => $data['sales_id']])->row_array();
	?>

	<div style="width: 50%;float: left;">
		<table style="width: 100%;">
			<tr>
				<td>Pembeli</td>
			</tr>
			<tr>
				<td>Customer</td>
				<td>: <?=$pt['company']?></td>
			</tr>
			<tr>
				<td>No. Telp</td>
				<td>: <?=$pt['handphone']?></td>
			</tr>
			<tr>
				<td>No. Fax</td>
				<td>: <?=$pt['fax']?></td>
			</tr>
			<tr>
				<td>Proyek</td>
				<td>: <?=$data['proyek']?></td>
			</tr>
		</table>
	</div>
	<div style="width: 50%;float: right;">
		<table style="width: 100%;">
			<tr>
				<td>Tanggal Terbit</td>
				<td>: <?=date('d F Y')?></td>
			</tr>
			<tr>
				<td>No. QUOTATION</td>
				<td>: <?=$data['no_po']?></td>
			</tr>
			<tr>
				<td>No PO</td>
				<td>: </td>
			</tr>
			<tr>
				<td>Ketentuan Pembayaran</td>
				<td>: <?=$data['sistem_pembayaran']?></td>
			</tr>
		</table>
	</div>
	<div style="clear:both"></div>
	<br />
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
			$sub_total = 0;
		?>
		<?php foreach($product as $key => $item):

			$sub_total += $item['harga_akhir']*$item['vol'];

			$p = $this->db->get_where('products', ['id' => $item['product_id']])->row_array();
		?>
			<tr>
				<td><?=($key+1)?></td>
				<td><?=$p['uraian']?></td>
				<td><?=$item['vol']?></td>
				<td><?=$item['satuan']?></td>
				<td>Rp. <?=(number_format($item['harga_akhir']))?></td>
				<td>Rp. <?=(number_format($item['harga_akhir']*$item['vol']))?></td>
			</tr>
		<?php endforeach; ?>
		<?php 

		$ppn = (($sub_total * 10) / 100);

		?>
			<tr>
				<td colspan="5" style="text-align: right;"><strong>Sub Total</strong>&nbsp;&nbsp;&nbsp;</td>
				<td><strong>Rp. <?=number_format($sub_total)?></strong></td>
			</tr>
			<tr>
				<td colspan="5" style="text-align: right;"><strong>PPn 10 %</strong>&nbsp;&nbsp;&nbsp;</td>
				<td><strong>Rp. <?=number_format($ppn)?></strong></td>
			</tr>

			<tr>
				<td colspan="5" style="text-align: right;"><strong>TOTAL</strong>&nbsp;&nbsp;&nbsp;</td>
				<td><strong>Rp. <?=number_format($ppn+$sub_total)?></strong></td>
			</tr>
			
		</table>
		<br />
	<div style="width: 50%;">
		<u><strong>Intruksi & Catatan : </strong></u>
		<ul>
			<li style="border-bottom: 1px solid;"> &nbsp;</li>
			<li style="border-bottom: 1px solid;"> &nbsp;</li>
			<li style="border-bottom: 1px solid;"> &nbsp;</li>
		</ul>	
	</div>

	<br />
	<div style="width: 50%; float: left;">
		<p>Mengetahui,</p>
		<br />
		<p>
			<strong><i><?=$sales['name']?></i></strong>
			<br />Sales
			<br />Hp : <?=$sales['phone']?> 
		</p>
	</div>
	<div style="width: 40%; float: right;">
		<p>&nbsp;</p>
		<br />
		<br />
		<p><?=label_customer_pt($pt['id'])?><br /></p>
	</div>
	<br style="clear: both;" />
	<p style="position: absolute; bottom:10px; left: 10px;"><small>
		FOR-B0105 <br /> No. Form. <b>01 September 2014</b>
	</small></p>
</body>
</html>