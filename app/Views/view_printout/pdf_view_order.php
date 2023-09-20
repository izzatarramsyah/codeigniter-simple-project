<?php 
    $dt = new DateTime("now", new DateTimeZone('Asia/Jakarta'));
	$totalPrice = 0;
?>
<!DOCTYPE html>
<html>
<style type="text/css">
	th.tabel{
		border-bottom: 1px solid black;
		border-top: 1px solid black;
		padding-top:10px;
		padding-bottom:10px;
		padding-left: 5px;
		padding-right: 5px;
	}
	td.tabel{
		/*border-bottom: 1px solid black;*/
		padding-top:5px;
		padding-bottom:5px;
		padding-left: 5px;
		padding-right: 5px;
	}
</style>

<body>
	<div style="padding-top: 0.5cm;">
		<div>
		 <table style="width:100%">
			<tr>
			  <td width="30%" style="font-size: 12px;"><b>PT. MANDIRI UTAMA FINANCE</b></td>
			  <td width="40%"></td>
			  <td width="30%" align="right" style="font-size: 11px;"><b><?php echo $dt->format("d F Y"); ?></b></td> 
			</tr>
			<tr>
			  <td width="30%" style="font-size: 12px"><b><?php echo $report_name ?></b></td>
			  <td width="40%"></td>
			  <td width="30%" align="right" style="font-size: 11px;"><b><?php echo $dt->format("h:i:s A"); ?></b></td> 
			</tr>
			<tr>
			<td width="30%" style="font-size: 12px"><?php echo 'Periode : '. date('d F Y', strtotime($start_date)) .' - '. date('d F Y', strtotime($end_date)) ?></td>
			</tr>
		 </table>
		</div>
	</div>
	<br>
	<div>
		<table style="width:100%;">
			<tr>
			  	<th class="tabel left" width="20%" style="font-size: 12px">Order ID</th>
			  	<th class="tabel center" width="20%" style="font-size: 12px">Transaction Date</th>
			  	<th class="tabel left" width="20%" style="font-size: 12px">Product Name</th>
			  	<th class="tabel center" width="20%" style="font-size: 12px">Quantity</th>
			  	<th class="tabel center" width="20%" style="font-size: 12px">Price</th>
			</tr>
			<?php for ($i = 0; $i < count($data); $i++) { ?>
				<tr>
					<td class="tabel left" width="20%" style="font-size: 11px"><?php echo $data[$i]->order_id; ?></td>
					<td class="tabel center" width="20%" style="font-size: 11px"><?php echo date('d F Y h:i:s', strtotime($data[$i]->created_dtm)); ?></td>
					<td class="tabel left" width="20%" style="font-size: 11px"><?php echo $data[$i]->product_name; ?></td>
					<td class="tabel center" width="20%" style="font-size: 11px"><?php echo $data[$i]->quantity; ?></td>
					<td class="tabel right" width="20%" style="font-size: 11px">Rp. <?php echo $data[$i]->total_price; ?></td>
				</tr> 
			<?php $totalPrice = $totalPrice + $data[$i]->total_price; } ?>
		</table>
	</div>
	<br>
	<div>
		<table style="width:100%;">
			<tr>
			  	<td class="left" width="62%"></td>
			  	<td class="right" width="12%" style="font-size: 12px"><b>Total :</b></td>
			  	<td class="right" width="13%" style="font-size: 12px; padding-right: 5px;">Rp. <?php echo $totalPrice ?></td>
			</tr>
		</table>
	</div>
</body>
</html>