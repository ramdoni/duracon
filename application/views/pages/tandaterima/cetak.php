<!DOCTYPE html>
<html>
<head>
	<title>TANDA TERIMA TAGIHAN</title>
	<style type="text/css">
		body {
			font-size: 12px;
		}
		table {
			width: 100%;
			border-collapse: collapse;
			border:1px solid;
		}
		table tr td {
			padding: 5px 30px;
		}
		td.border-right {
			border-right: 1px solid;

		}
		.border-bottom {
			border-bottom:1px dotted;
			text-align: left;
			margin-left: 0 !important;
			padding-left: 0 !important;
		}
		.border-bottom b {
			text-align: left;
			margin-left: 0!important;
			padding-left: 0 !important;
		}
	</style>

</head>
<?php 

$proyek = $this->db->query("
							SELECT qo.proyek, so.no_po FROM sales_order so inner join quotation_order qo on qo.id=so.quotation_order_id
							where so.id={$data['sales_order_id']}
						")->row_array();

$sj = $this->db->get_where('surat_jalan', ['invoice_id' => $data['invoice_id']])->result_array();

?>
<body>

	<h2 style="text-align: center;"><u>TANDA TERIMA TAGIHAN</u></h2>
	<p>Bukti - bukti tagihan yang sudah diterima sbb:</p>

	<div>

		<table>
			<tr>
				<td class="border-right">1. Kwitansi No :</td>
				<td class="border-bottom"><b> <?=$data['no_invoice']?></b></td>
			</tr>
			<tr>
				<td class="border-right">&nbsp;&nbsp;&nbsp;&nbsp;Nilai Rp.</td>
				<td class="border-bottom"><b > <?=number_format($data['nominal'])?></b></b></td>
			</tr>
			
			<tr>
				<td class="border-right">&nbsp;&nbsp;&nbsp;&nbsp;Tanggal Kwitansi</td>
				<td class="border-bottom"><b> <?=date('d F Y', strtotime($data['date']))?></b></td>
			</tr>
			<tr>
				<td class="border-right">&nbsp;&nbsp;&nbsp;&nbsp;Tanggal Jatuh Tempo</td>
				<td class="border-bottom"><b> </b></td>
			</tr>
			<tr>
				<td class="border-right" style="border-top:1px solid;border-bottom:1px solid;">2. Faktur Pajak No</td>
				<td class="border-bottom" style="border-top:1px solid;border-bottom:1px solid;"><b><?=$data['faktur_pajak']?></b></td>
			</tr>
			<tr>
				<td class="border-right">3. Surat Jalan</td>
				<td class="border-bottom">
					<b>
						<?php foreach($sj as $i):?>
							<?=$i['no_surat_jalan']?>, 
						<?php endforeach; ?>		
					</b>
				</td>
			</tr>
			<tr>
				<td class="border-right">&nbsp;&nbsp;&nbsp;&nbsp;Proyek</td>
				<td class="border-bottom"><b><?=$proyek['proyek']?></b></td>
			</tr>
			<tr>
				<td class="border-right" style="border-top:1px solid;border-bottom:1px solid;">4. Kontrak / PO</td>
				<td class="border-bottom" style="border-top:1px solid;border-bottom:1px solid;"><b><?=$proyek['no_po']?></b></td>
			</tr>
			<tr>
				<td class="border-right">5. Lain-lain</td>
				<td class="border-bottom"><strong>
					- BERITA ACARA TAGIHAN<br />
					- REKAPITULASI PENGIRIMAN
				</strong></td>
			</tr>
		</table>
		<br style="clear: both;" />
	</div>
	<div style="width: 50%; float: left;">
		<p>Diserahkan Oleh<br /><br /><br />
			<br />


			<strong>( <?=$this->session->userdata('name')?> ) </strong><br />
			............................<br />
			<strong><?=$this->session->userdata('phone')?></strong>
		</p>
		<p>FOR C 0809 - 18 Agustus 09. Rev. 01</p>
	</div>
	<div style="width: 40%; float: right;">
		<p>Tanggal  Oleh: ............................<br />
			Diterima Oleh,
			<br /><br />
			<br />


			<strong>( ................................................... ) </strong><br />
			<smal>Nama Jelas dan Stempel Perusahaan</smal>
		</p>
	</div>
</html>