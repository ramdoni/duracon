<!DOCTYPE html>
<html>
<head>
	<title>Surat Jalan <?=$no_surat_jalan?></title>
	<style type="text/css">
		body {
			font-size: 11px;
			/*font-family: "Courier New", Courier, "Lucida Sans Typewriter", "Lucida Typewriter", monospace;*/
		}
		.kotak {
			padding:0 5px;
		}

		table.table-header tr th {
			padding: 3px 0;
		}

		table.table_content tr td , table.table_content tr th {
			border: 1px solid black;
			padding: 5px;
		}
		table.table_content{
		    border-collapse: collapse;
		    border-spacing: 0;
		}

		ol {
			padding-top:0;
			margin-top:5px;
		}
		ol li {
			font-size: 8px;
			margin-top:0;
			padding-top:0;
		}

	</style>
</head>
<body>
	<div class="kotak">
		<table style="width: 100%;" class="table-header">
			<tr>
				<th colspan="4" style="text-align: center;padding-bottom:20px;"><h1 style="padding-top: 5px; margin-top: 0"><u>SURAT JALAN</u></h1><br /></th>
			</tr>
			<tr>
				<th style="text-align: left; width: 60px;">Customer</th>
				<th style="text-align: left;">: <?=$qo['customer']?></th>
				<th style="text-align: left; width: 90px;">No Surat Jalan</th>
				<th style="text-align: left;">: <?=$no_surat_jalan?></th>
			</tr>
			<tr>
				<th style="text-align: left; vertical-align: top;" rowspan="2">Lokasi</th>
				<th style="text-align: left; vertical-align: top;" rowspan="2">: <?=$qo['proyek']?></th>
				<th style="text-align: left;">Tanggal </th>
				<th style="text-align: left;">: <?=date('d F Y')?></th>
			</tr>
			<tr>
				<th style="text-align: left;">No PO</th>
				<th style="text-align: left;">: <?=$so['no_po']?></th>
			</tr>
			<tr>
				<th style="text-align: left;">Penerima</th>
				<th style="text-align: left;">: <?=$so['penerima_lapangan']?></th>
				<th style="text-align: left;">No SO</th>
				<th style="text-align: left;">: <?=$so['no_so']?></th>
			</tr>
			<tr>
				<th colspan="4" style="padding-top: 20px; font-size: 10px;">HARAP DITERIMA BARANG-BARANG SBB, DENGAN MOBIL NO : <?=$mobil['no_mobil']?></th>
			</tr>
		</table>
		<table class="table_content" style="width: 100%;">

			<tr>
				<th style="width: 5%;">NO</th>
				<th>TYPE</th>
				<th>JUMLAH</th>
				<th>KETERANGAN</th>
			</tr>
			<?php 
				$spm_product = $this->db->query("SELECT s.*, p.kode,p.uraian FROM surat_perintah_muat_product s INNER JOIN products p on p.id=s.product_id WHERE surat_perintah_muat_id={$spm['id']}")->result_array();
				foreach($spm_product as $k => $i):
			?>
				<tr>
					<td style="text-align: center;"><?=$k+1?></td>
					<td><?=$i['uraian']?></td>
					<td style="text-align: center;"><?=$i['volume']?></td>
					<td><?=$i['catatan']?></td>
				</tr>
			<?php endforeach; ?>
			<tr>
				<td>&nbsp;</td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
		</table>
		
		<div style="float: left; width: 18%;text-align: center;">
			<p><strong>Delivery Duracon</strong></p>
			<br />
			<br />
			<p>..................</p>
		</div>
		<div style="float: left; width: 20%;text-align: center;">
			<p><strong>Supir / Trucking</strong></p>
			<br />
			<br />
			<p>..................</p>
		</div>
		<div style="float: left; width: 20%;text-align: center;">
			<p><strong>Quality Control <br />Duracon</strong></p>
			<br />
			<p>..................</p>
		</div>
		<div style="float: left; width: 20%;text-align: center;">
			<p><strong>Security <br />Duracon</strong></p>
			<br />
			<p>..................</p>
		</div>
		
		
		<div style="float: left; width: 20%;text-align: center;">
			<p><strong>Yang Menerima / <br /> Pihak Proyek</strong></p>
			<br />
			<p>..................</p>
		</div>
		<br style="clear: both;" />

		<p style="font-size: 9px; padding-bottom: 0;margin-bottom:0;"><strong>Perhatian :</strong></p>
		<ol>
			<li>Surat Jalan ini tidak dapat dipindahtangankan tanpa persetujuan dari PT. Duraconindo Pratama</li>
			<li>Harap barang diteliti dan dipastikan sesuai dengan pesanan yang tertera pada No PO</li>
		</ol>
		<strong style="float: right; font-size: 8px;">FOR B 0901</strong>
	</div>	
	<br />

	<!-- <div style="page-break-before: always; "></div> -->
	<!--<div class="kotak">
		<p style="margin-top: 0;padding-top: 0;font-size: 10px;">Jl. Ciputat Raya No. 20 H Pondok Pinang Jakarta 12310</p>
		<br style="clear: both" />
		<table border="1" style="width: 100%;">
			<tr>
				<td rowspan="3" style="padding: 10px; width: 50%;"><h3>BUKTI PENGEMBALIAN PRODUK</h3></td>
				<td>NO. SURAT JALAN</td>
				<td><?=$sj['no_surat_jalan']?></td>
			</tr>
			<tr>
				<td>TANGGAL</td>
				<td><?=date('d F Y', strtotime($sj['date']))?></td>
			</tr>
			<tr>
				<td>PROYEK</td>
				<td><?=$qo['proyek']?></td>
			</tr>
		</table>

		<table border="1" style="width: 100%;">

			<tr>
				<th style="width: 5%;" rowspan="2">No</th>
				<th rowspan="2">Type Produk</th>
				<th rowspan="2">Jumlah</th>
				<th colspan="3">Quality</th>
				<th rowspan="2">Keterangan</th>
			</tr>
			<tr>
				<th>BAIK</th>
				<th>REPAIR</th>
				<th>REJECT</th>
			</tr>
			<?php 
				$spm_product = $this->db->query("SELECT s.*, p.kode,p.uraian FROM surat_perintah_muat_product s INNER JOIN products p on p.id=s.product_id WHERE surat_perintah_muat_id={$spm['id']}")->result_array();
				foreach($spm_product as $k => $i):
			?>
				<tr>
					<td><?=$k+1?></td>
					<td><?=$i['uraian']?></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
			<?php endforeach; ?>
		</table>
		<p>Note: Barang/produk yang dikembalikan harap disimpan di tempat terpisah untuk mempermudah inspeksi produk</p>
		<hr />
		<div style="float:left; width: 20%;text-align: center;">
			Proyek
			<br /><br /><br />
			(...............)
		</div>
		<div style="float:left; width: 20%;text-align: center;">
			Supir
			<br /><br /><br />
			(...............)
		</div>
		<div style="float:left; width: 20%;text-align: center;">
			Pengiriman
			<br /><br /><br />
			(...............)
		</div>
		<div style="float:left; width: 20%;text-align: center;">
			Stockyard
			<br /><br /><br />
			(...............)
		</div>
		<div style="float:left; width: 18%;text-align: center;">
			Quality Control
			<br /><br /><br />
			(...............)
		</div>
	</div>
	<div style="float: left;text-align: left; width: 30%;"><small>Form Bukti Pengembalian Produk - 2015</small></div>
	<div style="float: right;text-align: right; width: 50%;"><small>Issued : 19.12.2015 Ki</small></div>
	-->

</body>
</html>