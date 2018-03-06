<?php 

$hari = [1 => "Senin", 2 => "Selasa", 3 => "Rabu", 4=> "Kamis",5 => "Jumat", 6 => "Sabtu", 7 => "Minggu"];
?>
<!DOCTYPE html>
<html>
<head>
	<title>Jadwal Produksi Mingguan Pengecoran</title>
	<style type="text/css">
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
		<td rowspan="4">
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
		<td rowspan="2" style="text-align: center;"><h4>Jadwal Produksi Mingguan Pengecoran</h4></td>
		<td>Tanggal Terbit</td>
		<td><?=date('d F Y')?></td>
	</tr>
	<tr>
		<td>Revisi</td>
		<td> - </td>
	</tr>
	<tr>
		<td colspan="4"><strong>Periode : <?=$data['start_date']?> - <?=$data['end_date']?></strong></td>
	</tr>
</table>
<table>
	<tr class="header" style="background: #309C9F;">
		<td rowspan="2" colspan="3" style="text-align: left;">PLANT DURACON<br /> Factory : Legok, Tangeran </td>
		<td rowspan="2">Jumlah Cetakan</td>
		<?php foreach($hari as $key => $item):?>
			<td colspan="2" style="text-align: center;"><?=$item?></td>
		<?php endforeach;?>
		<td rowspan="2" colspan="2" class="bg-green">Total Week<br /> (Total 1 Minggu)</td>
	</tr>
	<tr style="background: #309C9F;">
		<?php foreach($hari as $item):?>
			<td colspan="2" style="text-align: center;"> - </td>
		<?php endforeach;?>
	</tr>
	<tr>
		<td rowspan="2">No</td>
		<td colspan="2">PRODUCT CODE</td>
		<td rowspan="2">Jumlah Cetakan</td>
		<?php foreach($hari as $key => $i):?>
			<?php foreach([1,2] as $s) { echo "<td>Shift {$s}</td>" ;}?>
		<?php endforeach; ?>
		<td class="bg-green">Shft 1</td>
		<td class="bg-green">Shft 2</td>
	</tr>
	<tr>
		<td colspan="2">Kode Produksi</td>
		<?php 
		$total_colspan = 0;
		foreach($hari as $key => $i):?>
			<?php foreach([1,2] as $s) { echo "<td>Plan</td>" ; $total_colspan++; }?>
		<?php endforeach; ?>
		<td class="bg-green">Plan</td>
		<td class="bg-green">Plan</td>
	</tr>
	<tr>
		<td colspan="<?=8+$total_colspan?>" style="background: rgb(165, 204, 137)"><h4>Area Produksi Plan <?=$data['plan']?></h4></td>
	</tr>
	<?php 

		$total_cetakan = 0;

		$senin_shift1 = 0;
		$senin_shift2 = 0;

		$selasa_shift1 = 0;
		$selasa_shift2 = 0;

		$rabu_shift1 = 0;
		$rabu_shift2 = 0;

		$kamis_shift1 = 0;
		$kamis_shift2 = 0;

		$jumat_shift1 = 0;
		$jumat_shift2 = 0;

		$sabtu_shift1 = 0;
		$sabtu_shift2 = 0;

		$minggu_shift1 = 0;
		$minggu_shift2 = 0;

		$total_shift1 = 0;
		$total_shift2  = 0;
	
	foreach($list_plan as $key => $item):?>
	
	<?php 
		$total_cetakan_shift1 = $this->db->query("select (sum(day1_shift1) + sum(day2_shift1) + sum(day3_shift1) + sum(day4_shift1) + sum(day5_shift1) + sum(day6_shift1) + sum(day7_shift1)) as total from product_schedule_plan where product_schedule_id={$data['id']}")->row();
        $total_cetakan_shift2 = $this->db->query("select (sum(day1_shift2) + sum(day2_shift2) + sum(day3_shift2) + sum(day4_shift2) + sum(day5_shift2) + sum(day6_shift2) + sum(day7_shift2)) as total from product_schedule_plan where product_schedule_id={$data['id']}")->row();

        $bg = "";

        if($item['pengecoran'] == 4)
        {
        	$bg = ' style="background: #fba09c" ';
        }else if($item['pengecoran'] == 3){
        	$bg = ' style="background: #337ab7" ';
        }	


        $total_cetakan += ($total_cetakan_shift1->total + $total_cetakan_shift2->total);
	?>
		<tr <?=$bg?>>
			<td style="width:20px;"><?=($key+1)?></td>
			<td colspan="2"><?=$item['product']?></td>
			<td><?=($total_cetakan_shift1->total + $total_cetakan_shift2->total)?></td>
			<?php 
				foreach($hari as $key => $i):
					foreach([1,2] as $shift){

						if($key ==1){
							if($shift == 1)
							{
								$senin_shift1 +=$item['day'.($key).'_shift'. $shift];
							}else{
								$senin_shift2 +=$item['day'.($key).'_shift'. $shift];
							}
						}

						if($key ==2){
							if($shift == 1)
							{
								$selasa_shift1 +=$item['day'.($key).'_shift'. $shift];
							}else{
								$selasa_shift2 +=$item['day'.($key).'_shift'. $shift];
							}
						}

						if($key ==3){
							if($shift == 1)
							{
								$rabu_shift1 +=$item['day'.($key).'_shift'. $shift];
							}else{
								$rabu_shift2 +=$item['day'.($key).'_shift'. $shift];
							}
						}

						if($key ==4){
							if($shift == 1)
							{
								$kamis_shift1 +=$item['day'.($key).'_shift'. $shift];
							}else{
								$kamis_shift2 +=$item['day'.($key).'_shift'. $shift];
							}
						}

						if($key ==5){
							if($shift == 1)
							{
								$jumat_shift1 +=$item['day'.($key).'_shift'. $shift];
							}else{
								$jumat_shift2 +=$item['day'.($key).'_shift'. $shift];
							}
						}

						if($key ==6){
							if($shift == 1)
							{
								$sabtu_shift1 +=$item['day'.($key).'_shift'. $shift];
							}else{
								$sabtu_shift2 +=$item['day'.($key).'_shift'. $shift];
							}
						}

						if($key ==7){
							if($shift == 1)
							{
								$minggu_shift1 +=$item['day'.($key).'_shift'. $shift];
							}else{
								$minggu_shift2 +=$item['day'.($key).'_shift'. $shift];
							}
						}

						echo "<td>". $item['day'.($key).'_shift'. $shift] ."</td>";						
					}
				endforeach; 

				$total_shift1 += $total_cetakan_shift1->total;
				$total_shift2 += $total_cetakan_shift2->total;
			?>
			<td class="bg-green"><?=number_format($total_cetakan_shift1->total)?></td>
			<td class="bg-green"><?=number_format($total_cetakan_shift2->total)?></td>
		</tr>
	<?php endforeach; ?>
	<?php foreach($list_plan_revisi as $key => $item):?>
	<?php 
		$total_cetakan_shift1 = $this->db->query("SELECT (sum(day1_shift1) + sum(day2_shift1) + sum(day3_shift1) + sum(day4_shift1) + sum(day5_shift1) + sum(day6_shift1) + sum(day7_shift1)) as total from product_schedule_plan where product_schedule_id={$data['id']}")->row();

        $total_cetakan_shift2 = $this->db->query("select (sum(day1_shift2) + sum(day2_shift2) + sum(day3_shift2) + sum(day4_shift2) + sum(day5_shift2) + sum(day6_shift2) + sum(day7_shift2)) as total from product_schedule_plan where product_schedule_id={$data['id']}")->row();

	?>
		<tr style="background: #59d659;">
			<td style="width:20px;"><?=($key+1)?></td>
			<td colspan="2"><?=$item['product']?></td>
			<td><?=($total_cetakan_shift1->total + $total_cetakan_shift2->total)?></td>
			<?php 
				foreach($hari as $key => $i):
					foreach([1,2] as $shift){

						if($key ==1){
							if($shift == 1)
							{
								$senin_shift1 +=$item['day'.($key).'_shift'. $shift];
							}else{
								$senin_shift2 +=$item['day'.($key).'_shift'. $shift];
							}
						}

						if($key ==2){
							if($shift == 1)
							{
								$selasa_shift1 +=$item['day'.($key).'_shift'. $shift];
							}else{
								$selasa_shift2 +=$item['day'.($key).'_shift'. $shift];
							}
						}

						if($key ==3){
							if($shift == 1)
							{
								$rabu_shift1 +=$item['day'.($key).'_shift'. $shift];
							}else{
								$rabu_shift2 +=$item['day'.($key).'_shift'. $shift];
							}
						}

						if($key ==4){
							if($shift == 1)
							{
								$kamis_shift1 +=$item['day'.($key).'_shift'. $shift];
							}else{
								$kamis_shift2 +=$item['day'.($key).'_shift'. $shift];
							}
						}

						if($key ==5){
							if($shift == 1)
							{
								$jumat_shift1 +=$item['day'.($key).'_shift'. $shift];
							}else{
								$jumat_shift2 +=$item['day'.($key).'_shift'. $shift];
							}
						}

						if($key ==6){
							if($shift == 1)
							{
								$sabtu_shift1 +=$item['day'.($key).'_shift'. $shift];
							}else{
								$sabtu_shift2 +=$item['day'.($key).'_shift'. $shift];
							}
						}

						if($key ==7){
							if($shift == 1)
							{
								$minggu_shift1 +=$item['day'.($key).'_shift'. $shift];
							}else{
								$minggu_shift2 +=$item['day'.($key).'_shift'. $shift];
							}
						}

						echo "<td>". $item['day'.($key).'_shift'. $shift] ."</td>";						
					}
				endforeach; 
			
				$total_shift1 += $total_cetakan_shift1->total;
				$total_shift2 += $total_cetakan_shift2->total;
			?>	
			<td class="bg-green"><?=number_format($total_cetakan_shift1->total)?></td>
			<td class="bg-green"><?=number_format($total_cetakan_shift2->total)?></td>
		</tr>
	<?php endforeach; ?>
	<tr class="strong">
		<td colspan="3" style="text-align: right;">Total</td>
		<td><?=$total_cetakan?></td>

		<td><?=$senin_shift1?></td>
		<td><?=$senin_shift2?></td>

		<td><?=$selasa_shift1?></td>
		<td><?=$selasa_shift2?></td>

		<td><?=$rabu_shift1?></td>
		<td><?=$rabu_shift2?></td>

		<td><?=$kamis_shift1?></td>
		<td><?=$kamis_shift2?></td>

		<td><?=$jumat_shift1?></td>
		<td><?=$jumat_shift2?></td>

		<td><?=$sabtu_shift1?></td>
		<td><?=$sabtu_shift2?></td>

		<td><?=$minggu_shift1?></td>
		<td><?=$minggu_shift2?></td>

		<td><?=$total_shift1?></td>
		<td><?=$total_shift2?></td>
	</tr>
</table>
<div style="width: 100%; border: 1px solid black; padding: 10px;">
	<div style="width: 20%;float: left;">
		<p><strong>Dibuat Oleh,</strong></p>
		<br>
		<br>
		<br>
		<strong><u>(Maman Sulaeman)</u></strong>
		<p>PPIC Plant</p>
	</div>
	<div style="width: 30%; text-align: center;float: left;">
		<p><strong>Menyetujui</strong></p>
		<br>
		<br>
		<br>
		<div style="width: 50%;float: left;">
			<strong><u><?=$data['spv_pengecoran']?></u></strong>
			<p>Spv. Pengecoran</p>
		</div>
		<div style="width: 50%;float: left;">
			<strong><u>(M. Luftie)</u></strong>
			<p>KA. Produksi</p>
		</div>
	</div>
	<div style="width: 20%;float: left;">
		<p><strong>Mengetahui,</strong></p>
		<br>
		<br>
		<br>
		<strong><u>(M Muchlish M)</u></strong>
		<p>Plant Manager</p>
	</div>
</div>
</body>
</html>