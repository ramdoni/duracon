<html>
<head>
	<title>Sales Order - <?=$data['no_po']?></title>
	<style type="text/css">
		body {
			font-size: 12px;
		}
	</style>
</head>
<body>
<?php 
	$pt = $this->db->get_where('customer', ['id' => $data['customer_id']])->row_array();
?>
<div style=" width: 200px;text-align: right; float: right;"><h3 style="color:#2f692f; "><u><i>SALES ORDER (SO)</i></u></h3></div>
<p>No Formulir : </p>
<p><strong>No. IPR : - </strong></p>
<p style="background: #2f692f; color: white; padding: 5px; width: 100px;text-align: center;"><strong>Pembeli</strong></p>
<div style="width: 50%;float: left;">
	<table style="width: 100%;">
		<tr>
			<td>Pelanggan</td>
			<td> : </td>
			<td><?=$data['customer']?></td>
		</tr>
		<tr>
			<td>No. PO / SPK</td>
			<td> : </td>
			<td><?=$data['no_po']?></td>
		</tr>
		<tr>
			<td>Proyek</td>
			<td> : </td>
			<td><?=$data['proyek']?></td>
		</tr>
		<tr>
			<td>Segment</td>
			<td> : </td>
			<td><div style="width: 100%; height: 50px; border: 3px solid black;"></td>
		</tr>
		<tr>
			<td>Setting</td>
			<td> : </td>
			<td> <?=$data['penurunan_barang']?></td>
		</tr>
		<tr>
			<td>Penerima</td>
			<td>: </td>
			<td><?=$data['penerima_lapangan']?> - <?=$data['no_telepon']?></td>
		</tr>
		<tr>
			<td>Area Kirim</td>
			<td> : </td>
			<td><?=$data['area']?></td>
		</tr>
	</table>
</div>
<div style="width: 50%; float: left;">
	<table style="width: 100%;">
		<tr>
			<td>Tanggal Terbit</td>
			<td width="2">:</td>
			<td><?=date('d M Y')?></td>
		</tr>
		<tr>
			<td>No. SO</td>
			<td width="2">:</td>
			<td><?=$data['no_so']?></td>
		</tr>
		<tr>
			<td colspan="2" style="background: #2f692f; color: white; padding: 5px;">
				<p><strong>Jadwal</strong></p>
			</td>
		</tr>
		<tr>
			<td>&nbsp;&nbsp;&nbsp;Mulai</td>
			<td width="2">:</td>
			<td><?=$data['jadwal_mulai']?></td>
		</tr>
		<tr>
			<td>&nbsp;&nbsp;&nbsp;Selesai</td>
			<td width="2">:</td>
			<td><?=$data['jadwal_selesai']?></td>
		</tr>
		<tr>
			<td colspan="2" style="background: #2f692f; color: white; padding: 5px;"><strong>Sales</strong></td>
		</tr>
		<tr>
			<td>&nbsp;&nbsp;&nbsp;</td>
		</tr>
		<tr>
			<td></td>
			<td colspan="2" style="border: 3px solid #2f692f;text-align: center;">
				<p><strong><?=$data['sales']?></strong></p>
			</td>
		</tr>
	</table>
</div>
<table border="1" style="width: 100%;">
	<tr style="background: #2f692f; color: white;">
		<th>No</th>
		<th>Kode Produk</th>
		<th>Deskripsi Produk</th>
		<th>Jumlah</th>
		<th>Ton</th>
		<th>Keterangan</th>
	</tr>
	<?php 
    if(isset($data['quotation_order_id']))
    {
    	$total_tonase = 0;
      $data_products = $this->db->get_where('quotation_order_products', ['quotation_order_id' => $data['quotation_order_id']])->result_array();
      foreach($data_products as $key => $value)
      {
        echo "<tr>";
        echo "<td>".($key+1)."</td>";
        echo "<td>{$value['kode']}</td>";
        echo "<td>{$value['uraian']}</td>";
        echo "<td>{$value['vol']}</td>";
        echo "<td>{$value['satuan']}</td>";
        echo "<td></td>";
        echo "</tr>";
      }
    }
  ?>
</table>
<div style="width: 80%;text-align: right;">Total Tonase : </div>
<p style="background: #2f692f; color: white; padding: 5px; width: 300px;"><strong><i><u>Ketentuan Pengiriman & Produksi</u></i></strong></p>
<ol>
	<li style="border-bottom:1px solid #000;padding-left: 25px;">&nbsp;</li>
	<li style="border-bottom:1px solid #000;padding-left: 25px;">&nbsp;</li>
	<li style="border-bottom:1px solid #000;padding-left: 25px;">&nbsp;</li>
</ol>
<br />
<div style="float:left; width: 40%; ">
	<p>Dibuat oleh</p>
	<br />
	<br />
	<p><strong><u><?=get_user_name($qo['employee_id'])?></u></strong><br />Admin</p>
</div>
<div style="float: left; width: 200px;">
	<p>Diajukan Oleh</p>
	<br />
	<br />
	<p style="margin-bottom:0;padding-bottom:0;"><strong><u><?=$data['sales']?></u></strong></p>
	<p style="margin-top:0;padding-top:0;">Sales</p>
</div>
<div style="float: right;width: 200px;text-align: center;">
	<p>Menyetujui</p>
	<br />
	<br />
	<p  style="margin-bottom:0;padding-bottom:0;"><strong><u><?=name_manager()?></u></strong></p>
	<p style="margin-top:0;padding-top:0;">Sales & Marketing Manager</p>
</div>
<br style="clear: both" />
<p style="background: #2f692f; color: white; padding: 5px; width: 200px;"><strong><i><u>Ketentuan Pembayaran</u></i></strong></p>
<div style="float: left;border: 3px solid #000; width: 20%; text-align: center;"><strong><?=$data['sistem_pembayaran']?></strong></div>
<div style="float: left; width: 45%; margin-left: 20px; border-bottom: 3px solid #000"><strong>Note : </strong></div>
<div style="float: right; width: 25%; text-align: center;">
	
	<p><strong><?=name_ar_manager()?></strong><br /> Accounts Receivable Manager</p>
	<p>Mengetahui</p>
</div>
<br style="clear: both;" />
<br />

<p style="background: #2f692f; color: white; padding: 5px; width: 300px;"><strong><i><u>Tanggapan</u></i></strong></p>
<ol>
	<li style="border-bottom:1px solid #000;padding-left: 25px;">&nbsp;</li>
	<li style="border-bottom:1px solid #000;padding-left: 25px;">&nbsp;</li>
	<li style="border-bottom:1px solid #000;padding-left: 25px;">&nbsp;</li>
</ol>
<p><i>Note : Apabila 3 hari tidak ada jawaban dari pihak Pabrik, Sales Order (SO) ini dianggap OK.</i></p>
</body>
</html>
