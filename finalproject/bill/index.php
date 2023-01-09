<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Electricity Bill Calculator</title>

		<div id="content">
			<div style="position: relative">
  				<div style="top: 10; right: 20; width: 100px; text-align:right;">
				<form>
				<input type="button" value="BACK" href="\home.php">
				</form>
				</div>
			</div>
		</div>

		<!-- Bootstrap CSS -->
		<link href="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="style.css">

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->

		<!-- jQuery -->
		<script src="http://code.jquery.com/jquery.js"></script>
		<!-- Bootstrap JavaScript -->
		<script src="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
	</head>
	<body>

	<div class="container">
		<h1>Electricity Bill Calculator</h1>
		<form action="" method="POST" role="form">
		<div class="row">
			<div class="col-lg-6">
				<div class="form-group">
					<label for="">Total Unit per Kwh</label>
					<input type="text" class="form-control" name="unit" placeholder="Input total Unit per kWh">
				</div>
			</div>

			<div class="col-lg-6">
				<div class="form-group">
					<label for="">Meter Charge</label>
					<select class="form-control" name="meter">
						<option value="0"> Select </option>
						<option value="10.0630">As of March 10.0630</option>
						<option value="10.4612">As of June 10.4612</option>
					</select>
				</div>
			</div>

			<div class="col-lg-6">
				<button type="submit" class="btn btn-primary">Calculate</button>
			</div>
		</div>
		</form>

		<hr>
		<?php
		if(isset($_POST['unit']))
		{
			$total = 0;
			$unit = (int) $_POST['unit'];

			function calculate($unit,$range,$price)
			{
				$xunit = $range[1]-$range[0]+1;
				if($unit<=$xunit && $unit>0)
				{
					$bill = $unit  * $price;
					echo "
						<tr>
							<td>".implode("-", $range)."</td>
							<td>$price</td>
							<td>$unit</td>
							<td>₱ $bill</td>
						</tr>
						";
					return array($unit-$xunit, $bill);
				}
				elseif($unit>$xunit)
				{
					$bill = $xunit * $price;
					$newUnit = $unit - $xunit;
					echo "
						<tr>
							<td>".implode("-", $range)."</td>
							<td>$price</td>
							<td>".$xunit."</td>
							<td>₱ $bill</td>
						</tr>
						";
					return array($newUnit, $bill);
				}
			}

			echo "<h3>Bill for $unit per kWh</h3>";

			echo "<table class=\"table table-hover\">
			<thead>
				<tr>
					<th>Range</th>
					<th>Meter Charge</th>
					<th>Unit</th>
					<th>Bill</th>
				</tr>
			</thead>
			<tbody>
				
			";

			$newUnit = 0;
			$meter = $_POST['meter'];
			if($unit>0)
			{
				$rep = calculate($unit,array(1,1000000),$meter );
				$newUnit = $rep[0];
				$total += $rep[1];
			}
			
			$vat = ($total * 0.01107);
			$vat1 = sprintf('%0.2f', round($vat, 2));
			$gTotal = $total + $vat;
			$Balance= sprintf('%0.2f', round($gTotal, 2));
			$genchar= ($total * 0.55);
			$genchar1= sprintf('%0.2f', round($genchar, 2));
			$trans= ($total * 0.01001);
			$trans1= sprintf('%0.2f', round($trans, 2));
			$dischar= ($total * 0.01705);
			$dischar1= sprintf('%0.2f', round($dischar, 2));
			$other= ($total * 0.0507);
			$otherchar= sprintf('%0.2f', round($other, 2));
			echo "
				
			</tbody>

			<tfoot>
				<tr>
					<th></th>
					<th></th>
					<th>Bill</th>
					<th>₱ $total</th>
				</tr>
				<tr>
					<th></th>
					<th></th>
					<th>Generation Charge</th>
					<th>₱ $genchar1</th>
				</tr>
				<tr>
					<th></th>
					<th></th>
					<th>Transmission Charge</th>
					<th>₱ $trans1</th>
				</tr>
				<tr>
					<th></th>
					<th></th>
					<th>Distribution Charge</th>
					<th>₱ $dischar1</th>
				</tr>
				<tr>
					<th></th>
					<th></th>
					<th>Vat 12%</th>
					<th>₱ $vat1</th>
				</tr>
				<tr>
					<th></th>
					<th></th>
					<th>Other Charges</th>
					<th>₱ $otherchar</th>
				</tr>
				<tr>
					<th></th>
					<th></th>
					<th>Total Amount</th>
					<th>₱ $Balance</th>
				</tr>

			</tfoot>
		</table>";
		}
		?>
	</div>	
	</body>
</html>
