<!DOCTYPE html>
<html>
<head>
	<title>REKAPITULASI PEMBAYARAN</title>
	<style type="text/css">
		body {
			font-size: 12px;
		}
		table {
			border-spacing: 0px;
    		border-collapse: separate;
    		width: 100%;
		}
		table tr td, table tr th {
			border: 1px solid;
			padding: 5px;
		}
	</style>
</head>
<body>
	<?php if(isset($data['sales_order_id']) and !empty($data['sales_order_id'])){ 

		$so = $this->db->get_where('sales_order', ['id' => $data['sales_order_id']])->row_array();
	?>
		<h3>REKAPITULASI PEMBAYARAN <br />SALES ORDER #<?=$so['no_so']?></h3>
		<table>
			<thead>
				<tr>
					<th>No</th>
					<th>No Invoice</th>
					<th>Tanggal</th>
					<th>Nominal</th>
				</tr>
			</thead>
			<tbody>
			<?php 
				$total_nominal = 0 ;
				$invoice = $this->db->query("SELECT p.date, i.no_invoice, p.nominal FROM pembayaran p LEFT JOIN invoice i on i.id=p.invoice_id WHERE p.sales_order_id={$so['id']} order by p.id desc")->result_array();

				foreach($invoice as $no_in =>  $in):
					$total_nominal += $in['nominal'];
			?>
				<tr>
					<td><?=$no_in+1?></td>
					<td><?=$in['no_invoice']?></td>
					<td><?=date('d F Y', strtotime($in['date']))?></td>
					<td>Rp. <?=number_format($in['nominal'])?></td>
				</tr>
			<?php endforeach; ?> 
			</tbody>
			<tfoot>
				<tr>
					<th colspan="3" style="text-align: right;">Total</th>
					<th style="text-align: left;">Rp. <?=number_format($total_nominal)?></th>
				</tr>
			</tfoot>
		</table>

	<?php }else{ ?>
		<h3>REKAPITULASI PEMBAYARAN</h3>
		<table>
			<thead>
				<tr>
					<th>No</th>
					<th>No SO</th>
					<th>No Invoice</th>
					<th>Tanggal</th>
					<th>Nominal Pembayaran</th>
				</tr>
			</thead>
			<tbody>
			<?php 
				$total_nominal = 0 ;
				$group_so = $this->db->query("SELECT so.id, so.no_so FROM pembayaran inner join sales_order so on so.id=pembayaran.sales_order_id group by sales_order_id")->result_array();
				
				$no_in = 1;

				foreach($group_so as $so):
					$invoice = $this->db->query("SELECT  p.date, i.no_invoice, p.nominal FROM pembayaran p LEFT JOIN invoice i on i.id=p.invoice_id where p.sales_order_id={$so['id']}  order by p.id desc")->result_array();
					
					$count_invoice = $this->db->get_where('pembayaran', ['sales_order_id' => $so['id']])->num_rows();

					$nominal_sub_total = 0;
				?>
					<tr>
						<td rowspan="<?=$count_invoice+2?>"><?=$no_in?></td>
						<td rowspan="<?=$count_invoice+2?>"><?=$so['no_so']?></td>
					</tr>
				<?php 
					foreach($invoice as $in):
						$total_nominal += $in['nominal'];
						$nominal_sub_total += $in['nominal'];
					?>
					<tr>
						<td><?=!empty($in['no_invoice']) ? $in['no_invoice'] : '-'?></td>
						<td><?=date('d F Y', strtotime($in['date']))?></td>
						<td>Rp. <?=number_format($in['nominal'])?></td>
					</tr>
					<?php endforeach; ?> 
					<tr>
						<th colspan="2" style="text-align: right;">Sub Total</th>
						<th style="text-align: left;">Rp. <?=number_format($nominal_sub_total)?></th>
					</tr>
				<?php $no_in++;  endforeach; ?>
			</tbody>
			<tfoot>
				<tr>
					<th colspan="4" style="text-align: right;">Total</th>
					<th style="text-align: left;">Rp. <?=number_format($total_nominal)?></th>
				</tr>
			</tfoot>
		</table>
	<?php } ?>
</body>
</html>