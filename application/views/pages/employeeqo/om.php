<!DOCTYPE html>
<html>
<head>
	<title>QUOTATION / ORDER ENTRY FORM</title>
</head>
<body>
	<?php 
		$pt = $this->db->get_where('customer', ['id' => $data['customer_id']])->row_array();
	?>
	<p><strong>QUOTATION / ORDER ENTRY FORM (OM 1)</strong></p>
	<div style="float:left; width: 30%;">
		<table style="width:100%;">
			<tr>
				<td>Date</td>
				<td style="text-align: left;"><?=date('d F Y')?></td>
			</tr>
			<tr>
				<td style="border-right: 0;border-top: 1px solid black;border-bottom: 1px solid black;border-left: 1px solid black;">Total Tones</td>
				<td style="border-right: 1px solid black; border-top: 1px solid black;border-bottom: 1px solid black;border-left: 1px solid black;">
				<?php 
					$ton = $this->db->query("SELECT sum(weight) as total, sum(vol) as total_vol FROM quotation_order_products where quotation_order_id={$data['id']}")->row_array();
					if($ton)
					{
						echo round(($ton['total'] * $ton['total_vol']) / 1000, 1);
					}
				?>
				  Ton</td>
			</tr>
			<tr>
				<td style="border-top: 1px solid black;border-bottom: 1px solid black;border-left: 1px solid black;width: 100px;"> Sales Person</td>
				<td style="border: 1px solid;"> <?=$data['sales']?></td>
			</tr>
		</table>
	</div>
	<div style="float: left; width: 65%; margin-left: 50px;">
		<div style="background: #efefef; border: 1px solid black; padding: 5px 10px; margin-right: 10px; width: 100px;float: left"><b>Customer Type</b></div>
		<div style="border: 2px solid red; padding: 4px 10px; width: 100px; float: left; margin-left: 10px; "><b><?=$pt['tipe_customer']?></b></div>
		<div style="border: 2px solid blue; padding: 4px 10px; width: 100px; float: left; margin-left: 10px; height: 20px; "></div>
		<div style="padding: 4px 10px; width: 100px; float: left; margin-left: 10px; height: 20px; ">Biaya Setting</div>
		<div style="padding: 4px 10px; width: 100px; float: left; margin-left: 10px; height: 20px; ">Marketing</div>

		<br style="clear: both;">
		<div style="border: 1px solid black; padding: 5px 10px; width: 100px; float: left; "><b>Project Type</b></div>
		<div style="border: 2px solid green; padding: 4px 10px; width: 100px; float: left; margin-left: 10px; "><b><?=$data['tipe_pekerjaan']?></b></div> 
		<div style="border: 2px solid green; padding: 4px 10px; width: 100px; float: left; margin-left: 10px; "><b>Infrastructure</b></div>
		<div style="border: 2px solid green; padding: 4px 10px; width: 100px; float: left; margin-left: 10px; "><b><?=$data['penurunan_barang']?></b></div>

		<div style="border: 2px solid green; padding: 4px 10px; width: 100px; float: left; margin-left: 10px; "><b><?=$data['marketing']?></b></div>
	</div>
	<br style="clear: both;">
	<table style="width: 100%;" class="border">
		<tr>
			<td rowspan="4" colspan="7" style="border-right:0;border-bottom:0;">
				<p><?=(label_customer_pt($pt['id']))?></p>
				<p>Address</p>
				<p><?=$pt['address']?></p>
			</td>
			<td style="border: 0px;border-top:1px solid;">Contact Person</td>
			<td style="width: 100px;"><?=label_customer_pt($pt['id'])?></td>
			<td>Project : <?=$data['proyek']?></td>
		</tr>
		<tr>
			<td style="border:0">Phone No.</td>
			<td style="width: 100px;"><?=$pt['telphone']?></td>
			<td rowspan="2">Loc :
			<?php 
				$kel = $this->db->query("
						SELECT k.nama as kelurahan, kab.nama as  kabupaten, kec.nama as kecamatan FROM kelurahan k INNER JOIN kecamatan kec ON kec.id_kec=k.id_kec INNER JOIN kabupaten kab on kab.id_kab=kec.id_kab where k.id_kel=". $data['kelurahan_id'])->row_array();

				if($kel['kelurahan'])
				{
					echo $kel['kabupaten'];
				}
			?>
			</td>
		</tr>
		<tr>
			<td style="border:0;">Mobile Phone</td>
			<td style="width: 100px;"><?=$pt['handphone']?></td>
		</tr>
		<tr>
			<td style="border:0px;">Fax No</td>
			<td style="width: 100px;"><?=$pt['fax']?></td>
			<td rowspan="2">
				<p>Stage <input type="checkbox" > Design <input type="checkbox"> Doc <input type="checkbox"> Tend <input type="checkbox"> Const </p>
				<br />
				<p>Estimate, Project Start / Finish </p>
			</td>
		</tr>
	<!--</table>
	<table style="width: 100%;" class="border">
	-->
		<tr>
			<td>Customer Type</td>
			<td colspan="3">Credit App</td>
			<td colspan="2">Warning List</td>
			<td colspan="3">Payment Term : <?=$data['sistem_pembayaran']?></td>
		</tr>
		<tr>
			<th>Check / Approve Paraf</th>
			<td style="width: 50px;text-align: center;">Quote</td>
			<td style="width: 50px;text-align: center;">RI</td>
			<td style="width: 50px;text-align: center;">R2</td>
			<td>Final</td>
			<th colspan="3">Log In Panel</th>
			<td colspan="2">Credit checks Qt - CredApp, Warning List / Rev - CA, WL, Limit / Final - CA, WL, CL, Limit, Overdue</td>
		</tr>
		<tr>
			<td>Product Spec Clear</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td style="width: 40px;text-align: center;">Paraf</td>
			<td style="width: 40px;text-align: center;">Who</td>
			<td style="text-align: center;">Position</td>
			<td rowspan="6" colspan="2" style="vertical-align: top;position: relative;">
				Notes : 
			</td>
		</tr>
		<tr>
			<td>Non Std Costing OK</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>Capacity OK</td>
			<td></td>
			<td></td>	
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>Price Disc Approved</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>Credit Check OK</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>Payment Term Agreed</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
	</table>
	<table class="border" style="width: 100%;">
		<thead>
			<tr class="tr-center">
				<td rowspan="2">Product Code</td>
				<td rowspan="2">Product Description</td>
				<td rowspan="2">Air</td>
				<td colspan="2">Quantity</td>
				<td>Weight</td>
				<td>Product Seling Price</td>
				<td colspan="2">Ongkos Kirim</td>
				<td>Biaya Setting</td>
				<td colspan="2">Harga Material Ex. Factory</td>
				<th colspan="2">Price List <?=date('Y')?></th>
				<td rowspan="2">Diskon tanpa<br /> Potongan Biaya<br /> Setting (Tanpa<br /> Potongan PPn)</td>
				<td rowspan="2">KETERANGAN</td>
			</tr>
			<tr class="tr-center">
				<td>Vol</td>
				<td>Sat</td>
				<td>Kg/Pc</td>
				<td>Rp/Pc</td>
				<td>Rp/Pc</td>
				<td>Rp/Kg</td>
				<td>Rp.</td>
				<td>Rp/Pc</td>
				<td>Rp/Kg</td>
				<td>Rp/Pc</td>
				<th>Disc. REAL</th>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td colspan="2" style="text-align: center;background: yellow;">
					<?php 
						$ar = $this->db->get_where('area', ['id' => $data['area_id']])->row_array();
						echo $ar['area'];
					?>
				</td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
		</thead>
		<tbody>
		<?php 
		
		$spesification = $this->db->query("SELECT ps.* FROM quotation_order qo
								inner join quotation_order_products qop on qop.quotation_order_id=qo.id 
								inner join products p on p.id=qop.product_id
								inner join `product_specification` ps on ps.id=p.`product_specification_id`
								where qo.id={$data['id']}
								group by p.`product_specification_id`;")->result_array();

		foreach($spesification as $key => $spec):
		?>
			<?php 
				$products = $this->db->query("SELECT qop.*, qo.penurunan_barang, a.price as ongkos_kirim FROM quotation_order qo
								inner join quotation_order_products qop on qop.quotation_order_id=qo.id 
								inner join products p on p.id=qop.product_id
								inner join area a on a.id=qo.area_id
								where qo.id={$data['id']} and p.product_specification_id = {$spec['id']};")->result_array();

				foreach ($products as $key => $p):?>
				<?php 
					$_product = $this->db->get_where('products', ['id' => $p['product_id']])->row_array();

					$ongkos_kirim_pc = round($_product['weight'] * $p['ongkos_kirim'], -2);

					if($p['penurunan_barang'] == 'Setting')
						$biaya_setting = $_product['biaya_setting'];
					else
						$biaya_setting = 0;

					$material_rp_pc = ($p['harga_satuan'] - $ongkos_kirim_pc - $biaya_setting);

					$disc_real = (($_product['price'] - $material_rp_pc) / $_product['price']) ;

					$price_non_ppn = ($_product['price'] - $p['harga_satuan']) / $_product['price'];
				?>
				<tr>
					<td><?=$p['kode']?></td>
					<td><?=$p['uraian']?></td>
					<td></td>
					<td><?=$p['vol']?></td>
					<td><?=$p['satuan']?></td>
					<td><?=$_product['weight']?></td>
					<td style="text-align: right;"><?=number_format($p['harga_satuan'])?></td>
					<td style="text-align: right;"><?=number_format($ongkos_kirim_pc)?></td>
					<td style="text-align: right;"><?=number_format($p['ongkos_kirim'])?></td>
					<td style="text-align: right;"><?=number_format($biaya_setting)?></td>
					<td style="text-align: right;"><?=number_format($material_rp_pc)?></td>
					<td style="text-align: right;"><?=number_format(round($material_rp_pc/$_product['weight']))?></td>
					<td style="text-align: right;"><?=number_format($_product['price'])?></td>		
					<td style="text-align: right;"><?=round($disc_real*100)?>%</td>
					<td style="text-align: right;"><?=round($price_non_ppn*100)?>%</td>
					<td></td>
				</tr>
			<?php endforeach; ?>		
		<?php endforeach; ?>
		<tr>
			<td colspan="16">&nbsp;</td>
		</tr>
		<?php 
		$spesification = $this->db->query("SELECT ps.* FROM quotation_order qo
								inner join quotation_order_products qop on qop.quotation_order_id=qo.id 
								inner join products p on p.id=qop.product_id
								inner join `product_specification` ps on ps.id=p.`product_specification_id`
								where qo.id={$data['id']}
								group by p.`product_specification_id`;")->result_array();

		foreach($spesification as $key => $spec):
		?>
			<?php 
				$products = $this->db->query("SELECT qop.*, qo.penurunan_barang, a.price as ongkos_kirim FROM quotation_order qo
								inner join quotation_order_products qop on qop.quotation_order_id=qo.id 
								inner join products p on p.id=qop.product_id
								inner join area a on a.id=qo.area_id
								where qo.id={$data['id']} and p.product_specification_id = {$spec['id']};")->result_array();

				foreach ($products as $key => $p):
					
					$_product = $this->db->get_where('products', ['id' => $p['product_id']])->row_array();

					$ongkos_kirim_pc = round($_product['weight'] * $p['ongkos_kirim'], -2);

					if($p['penurunan_barang'] == 'Setting')
						$biaya_setting = $_product['biaya_setting'];
					else
						$biaya_setting = 0;

					$material_rp_pc = ($_product['price'] - $ongkos_kirim_pc - $biaya_setting);

					$disc_real = (($_product['price'] - $material_rp_pc) / $_product['price']) ;

					$price_non_ppn = 0 / $_product['price'];
				?>
				<tr>
					<td><?=$p['kode']?></td>
					<td><?=$p['uraian']?></td>
					<td></td>
					<td><?=$p['vol']?></td>
					<td><?=$p['satuan']?></td>
					<td><?=$_product['weight']?></td>
					<td style="text-align: right;"><?=number_format($_product['price'])?></td>
					<td style="text-align: right;"><?=number_format($ongkos_kirim_pc)?></td>
					<td style="text-align: right;"><?=number_format($p['ongkos_kirim'])?></td>
					<td style="text-align: right;"><?=number_format($biaya_setting)?></td>
					<td style="text-align: right;"><?=number_format($material_rp_pc)?></td>
					<td style="text-align: right;"><?=number_format(round($material_rp_pc/$_product['weight']))?></td>
					<td style="text-align: right;"><?=number_format($_product['price'])?></td>		
					<td style="text-align: right;"><?=round($disc_real*100)?>%</td>
					<td style="text-align: right;"><?=round($price_non_ppn*100)?>%</td>
					<td></td>
				</tr>
			<?php endforeach; ?>		
		<?php endforeach; ?>

		</tbody>
	</table>
<style type="text/css">
	body {
		font-size: 10px;
	}
	.tr-center td {
		text-align: center;
	}
	table { 
      border-spacing:0; 
    }
	table.border tr td, table.border tr th
	{
		border: 1px solid black;
		padding: 2px;
	}
</style>
</body>
</html>