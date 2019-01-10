<!DOCTYPE html>
<html>
<head>
	<title>Invoice - <?=$invoice['no_invoice']?></title>

	<style type="text/css">
		body {
			font-size: 15px;
		}
		.green {
			color: #3f687e;
		}
		table {
			width: 100%;
		}
		table.table tr th {
			background: #3f687e;
			color: white;
		}
		table.table tr td, table.table tr th {
			padding: 5px 10px;
		}	
		table.right {
			float: right;
			width: 100%;
		}

		table.border tr td, table.border tr th {
			border: 1px solid;
		}
		tfoot.no_border tr td,tfoot.no_border tr th {
			border: 0;
		}
	</style>
</head>
<body>
	<p style="position: absolute;right: 10px; top: 10px;">
		<b>No.</b> <?=$invoice['no_invoice']?>
	</p>
	<div class="">
		<img src="<?=site_url()?>assets/images/small-logo.jpg" style="height: 100px; width: 120px;float: left;" />
		<div style="float: left;margin-left: 10px;">
			<p>
				<b style="font-size: 18px;">PT DURACONINDO PRATAMA</b><br />
				Kp. Jaha, RT/RW : 03/04, Malang Nengah, Legok - Tangerang <br />
				No. NPWP : 01.495.350.9-415.000 <br />
				Kantor : Jl Ciputat Raya No. 20 H, Pondok Pinang, Jakarta Selatan 12310<br />
				Phone : 75907375 (Hunting) Fax : 7509486
			</p>
		</div>
	</div>
	<br style="clear: both;" />
	<table class="table">
		<tr>
			<td>Sudah diterima dari </td>
			<td style="width: 5px;"> : </td>
			<td><strong style="font-size: 18px;"><?=$qo['customer']?></strong></td>
		</tr>
		<tr>
			<td>Sejumlah Uang</td>
			<td> : </td>
			<td><strong><?=terbilang($invoice['nominal'], 1)?> RUPIAH</strong></td>
		</tr>
		<tr>
			<td>Untuk pembayaran</td>
			<td> : </td>
			<td><strong><?=empty($invoice['untuk_pembayaran']) ? 'Komponen Beton Pracetak' : $invoice['untuk_pembayaran']?></strong></td>
		</tr>
		<tr>
			<td>No PO</td>
			<td> : </td>
			<td><strong><?=$qo['no_po']?></strong></td>
		</tr>
		<tr>
			<td>Proyek / Lokasi</td>
			<td> : </td>
			<td><?=$qo['proyek']?></td>
		</tr>
		<tr>
			<td>Komponen franko ditempat Rp. </td>
			<td> : </td>
			<td><?=number_format($invoice['nominal'])?></td>
		</tr>
		<tr>
			<td>P.P.N 10% Rp. </td>
			<td></td>
			<td>
				<?php 
					$ppn = ($invoice['nominal'] * 10 ) / 100;

				?>
				<?=number_format($ppn)?></td>
		</tr>
		<tr>
			<td>Jumlah Rp. </td>
			<td></td>
			<td>
				<strong style="font-size: 18px;"><?=number_format($invoice['nominal']+$ppn)?></strong><br /><br />
			</td>
		</tr>
		<tr>
	</table>
	<div style="float: right;width: 30%;margin-top: -50px;">
		<p>Jakarta, <?=date('d F Y')?></p>
		<br />
		<br />
		<p><i>materai 6000</i></p>
		<br />
		<br />
		<p>Bachri Tanu</p>
	</div>

	<p style="margin-top: 150px;">
		Pembayaran dengan giro/cheque harap atas nama<br />
		PT. Duraconindo Pratama dan dianggap sah, setelah <br />
		giro/cheque tersebut dapat diuangkan (clearing)
	</p>
	<p>
		Rek BCA :  237-3020-311 <br />
		Cabang Pondok Indah - Jakarta Selatan<br />
		<strong>PT. Duraconindo Pratama</strong>
	</p>
	<div style="position: absolute;bottom:10px; left:10px;">
		<small>FOR: C 0806 / 01 Juni 2007 - Rev. 00</small>
	</div>
<?php 
	$surat_jalan = $this->db->query("
                        SELECT sj.*, p.kode, sum(spmp.volume) as total_volume, p.satuan, p.price FROM surat_jalan sj 
                        inner join surat_perintah_muat spm on spm.id=sj.surat_perintah_muat_id
                        inner join surat_perintah_muat_product spmp on spmp.surat_perintah_muat_id=spm.id 
                        inner join surat_izin_kirim sik on sik.id=spm.surat_izin_kirim_id
                        inner join products p on p.id=spmp.product_id
                        where sj.invoice_id = {$invoice['id']}
                        group by p.id
                        ")->result_array();

	if(count($surat_jalan) > 0){
?>
	<div style="page-break-before: always; "></div>
	<h3 style="text-align: center;">BERITA ACARA TAGIHAN</h3>
	<table>
		<tr>
			<td>No PO</td>
			<td>: <?=$qo['no_po']?></td>
		</tr>
		<tr>
			<td>No SO</td>
			<td>: <?=$so['no_so']?></td>
		</tr>
		<tr>
			<td>Customer</td>
			<td>: <?=$qo['customer']?></td>
		</tr>
		<tr>
			<td>Lokasi</td>
			<td>: <?=$qo['proyek']?></td>
		</tr>
		<tr>
			<td>Lingkup</td>
			<td>: Komponen Beton Pracetak</td>
		</tr>
		<tr>
			<td>No. Ref</td>
			<td>: </td>
		</tr>
	</table>
	<table class="border">
		<thead>
			<tr>
				<th>No</th>
				<th>Produk</th>
				<th>Satuan</th>
				<th>Volume</th>
				<th>Harga Satuan Rp. </th>
				<th>Total Rp. </th>
			</tr>
		</thead>
		<tbody>
			<?php 

				$total = 0;

				foreach($surat_jalan as $key => $item):
					$total += ($item['price'] * $item['total_volume']);
			?>
					<tr>
						<td style="text-align: center"><?=($key+1)?></td>
						<td><?=($item['kode'])?></td>
						<td style="text-align: center"><?=($item['satuan'])?></td>
						<td style="text-align: right"><?=($item['total_volume'])?></td>
						<td style="text-align: right"><?=number_format($item['price'])?></td>
						<td style="text-align: right"><?=number_format($item['price'] * $item['total_volume'])?></td>
					</tr>
			<?php endforeach; ?>
			<?php 

			$ppn = ($total *10 / 100 );

			?>
		</tbody>
		<tfoot class="no_border">
			<tr>
				<th colspan="5" style="text-align: right;">Subtotal</th>
				<th><?=number_format($total)?></th>
			</tr>
			<tr>
				<th colspan="5" style="text-align: right;">PPN 10% </th>
				<th><?=number_format($ppn)?></th>
			</tr>
			<tr>
				<th colspan="5" style="text-align: right;">Total Terkirim </th>
				<th><?=number_format($ppn + $total)?></th>
			</tr>
			<tr>
				<th colspan="5" style="text-align: right;">Total Tagihan </th>
				<th><?=number_format($ppn + $total)?></th>
			</tr>
		</tfoot>
	</table>
	<p>
		Terbilang : <br />
		# <?=terbilang($ppn + $total, 1)?> RUPIAH #
	</p>
	<div style="float: right;text-align: center; width: 30%;">
		Jakarta, <?=date('d F Y')?><br />
		PT. Duraconindo Pratama
		<br /><br /><br /><br /><br />
		Leri Setiawan
	</div>
	
	<div style="position: absolute;bottom:10px; left:10px;">
		<small>FOR-C 0804 / 01 Juni 2007-Rev.00</small>
	</div>
<?php } ?>
<?php 

$surat_jalan = $this->db->query("
                        SELECT sj.*, p.kode, spmp.volume, p.satuan, p.price FROM surat_jalan sj 
                        inner join surat_perintah_muat spm on spm.id=sj.surat_perintah_muat_id
                        inner join surat_perintah_muat_product spmp on spmp.surat_perintah_muat_id=spm.id 
                        inner join surat_izin_kirim sik on sik.id=spm.surat_izin_kirim_id
                        inner join products p on p.id=spmp.product_id
                        inner join invoice i on i.id=sj.invoice_id
                        where sik.sales_order_id = {$so['id']}
                        group by sj.id
                        ")->result_array();

if(count($surat_jalan)){
?>
	<div style="page-break-before: always; "></div>
	<h3 style="text-align:center;">REKAPITULASI PENGIRIMAN MATERIAL BETON PRACETAK</h3>
	<table>
		<tr>
			<td>No PO</td>
			<td>: <?=$qo['no_po']?></td>
		</tr>
		<tr>
			<td>Pembeli</td>
			<td>: <?=$qo['customer']?></td>
		</tr>
		<tr>
			<td>Lokasi</td>
			<td>: <?=$qo['proyek']?></td>
		</tr>
	</table>

	<table class="border">
		<thead>
			<tr>
				<th>No</th>
				<th>Tanggal</th>
				<th>Surat Jalan</th>
				<th>Jenis Barang</th>
				<th>Jumlah Pcs</th>
			</tr>
		</thead>
		<tbody>
			<?php 

				$total = 0;
				

				foreach($surat_jalan as $key => $item):
					$total += ($item['price'] * $item['volume']);
			?>
					<tr>
						<td style="text-align: center"><?=($key+1)?></td>
						<td><?=$item['date']?></td>
						<td><?=$item['no_surat_jalan']?></td>
						<td><?=($item['kode'])?></td>
						<td style="text-align: right"><?=($item['volume'])?></td>
					</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<p>OR-C 0804 / 01 Juni 2007 - Rev.00</p>
<?php } ?>
</body>
</html>