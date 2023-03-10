<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Retirement Calculator</title>

	<div id="content">
			<div style="position: relative">
  				<div style=" top: 10; left: 20; width: 100px; text-align:right;">
				<form>
				<input type="button" value="BACK" onclick="history.back()" >
				</form>
				</div>
			</div>
		</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>
	<script src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.1/jquery.dataTables.min.js"></script>
	<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.11.1/jquery.validate.min.js"></script>
	<script src="http://cdnjs.cloudflare.com/ajax/libs/flot/0.8.1/jquery.flot.min.js"></script>

	<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/themes/base/jquery-ui.css" type="text/css"></link>
	<link rel="stylesheet" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.1/css/jquery.dataTables.css" type="text/css"></link>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<script language="javascript">
		function displayData(data, startYear, endYear) {
			"use strict";
			var year,
			    dataTable = [],
			    dataGraph = [];
			for (year = startYear; year <= endYear; year += 1) {
				dataTable[year - startYear] = [
					year,
					data[year].start.toFixed(2),
					data[year].change.toFixed(2),
					data[year].end.toFixed(2)
				];
				dataGraph[year] = [
					year,
					data[year].start
				];
			}
			$("#tab-table").empty().append("<table id='outputTable'/>");
			$("#outputTable").dataTable({
				"aaData": dataTable,
				"aoColumns": [
					{ "sTitle": "Year" },
					{ "sTitle": "Current savings at starting of the year" },
					{ "sTitle": "Annual Growth Rate" },
					{ "sTitle": "Gross savings at the end of the year" }
				]
			});
			$("#tab-graph").empty().append("<div id='outputGraph' style='width:100%;height:500px'></div>");
			// we have to select the graph tab because canvas has to be shown to draw on it
			// TODO: get the tab based on name
			//$("#tabs").tabs("select", 2);
			$.plot("#outputGraph", [ dataGraph ]);
		}

		function computeRetirement(data, yearCurrent, yearRetirement, yearDeath, rate_inflation, rate_capital, cost_retirement, cost_death) {
			"use strict";
			var year;
			for (year = yearDeath; year >= yearRetirement; year -= 1) {
				var total_inflation_growth = Math.pow(1.0 + rate_inflation, year - yearCurrent),
				    yearSpending = cost_retirement * total_inflation_growth,
				    endOfYear = year === yearDeath ? cost_death * total_inflation_growth : data[year + 1].start / (1.0 + rate_capital),
				    startOfYear = endOfYear + yearSpending;

				data[year] = {
					change: -yearSpending,
					end: endOfYear,
					start: startOfYear
				};
			}
			return data;
		}

		function computeWork(data, yearCurrent, yearRetirement, rate_salary, rate_capital, salary, salary_contribution) {
			"use strict";
			var year;
			for (year = yearRetirement - 1; year >= yearCurrent; year -= 1) {
				var total_salary_growth = Math.pow(1.0 + rate_salary, year - yearCurrent),
				    contribution = salary * total_salary_growth * salary_contribution,
				    endOfYear = data[year + 1].start / (1.0 + rate_capital),
				    startOfYear = endOfYear - contribution;

				data[year] = {
					change: contribution,
					end: endOfYear,
					start: startOfYear
				};
			}
			return data;
		}

		$(document).ready(function () {
			"use strict";
			
			// TODO: not available in this version of jquery ui
			//$("#tabs").tabs( { heightStyle: "auto" });

			jQuery.validator.addMethod("integer", function (value, element) {
				return this.optional(element) || /^[0-9]+$/.test(value);
			}, "Please specify an integer value.");

			$("#processForm").validate({
				submitHandler: function (form) {
					var ageCurrent = parseInt($("#age_current").val(), 10),
					    ageRetirement = parseInt($("#age_retirement").val(), 10),
					    ageDeath = parseInt($("#age_death").val(), 10),

					    cost_retirement = parseFloat($("#cost_retirement_month").val(), 10) * 12.0,
					    cost_death = parseFloat($("#cost_death").val(), 10),

					    rate_inflation = parseFloat($("#rate_inflation").val(), 10) / 100.0,
					    rate_capital = parseFloat($("#rate_capital").val(), 10) / 100.0,

					    salary = parseFloat($("#salary").val(), 10),
					    rate_salary = parseFloat($("#rate_salary").val(), 10) / 100.0,
					    salary_contribution = parseFloat($("#rate_contribution").val(), 10) / 100.0,

					    // compute years
					    yearCurrent = new Date().getFullYear(),
					    yearRetirement = yearCurrent + (ageRetirement - ageCurrent),
					    yearDeath = yearCurrent + (ageDeath - ageCurrent),

					    data = [];

					data = computeRetirement(
						data,
						yearCurrent,
						yearRetirement,
						yearDeath,
						rate_inflation,
						rate_capital,
						cost_retirement,
						cost_death
					);
					data = computeWork(
						data,
						yearCurrent,
						yearRetirement,
						rate_salary,
						rate_capital,
						salary,
						salary_contribution
					);

					displayData(data, yearCurrent, yearDeath);
				}
			});
		});
	</script>
	<div id="tabs" height="100%" width="100%">
		<ul>
			<li><a href="#tab-inputs">Inputs</a></li>
			<li><a href="#tab-table">Outputs - Table</a></li>
			<li><a href="#tab-graph">Outputs - Graph</a></li>
		</ul>	
		<div id="tab-inputs">
			<form id="processForm"><fieldset>
			<p>
				<label for="age_current">Current Age:</label>
				<input type="text" name="age_current" id="age_current" placeholder="00" class="required number integer"/>
			</p>
			<p>
				<label for="age_retirement">Retirement Age:</label>
				<input type="text" name="age_retirement" id="age_retirement" placeholder="00" class="required number integer"/>
			</p>
			<p>
				<label for="rate_inflation">Inflation rate, %:</label>
				<input type="text" name="rate_inflation" id="rate_inflation" placeholder="0.0" class="requird number"/>
			</p>
			<p>
				<label for="rate_capital">Capital growth rate, %:</label>
				<input type="text" name="rate_capital" id="rate_capital" placeholder="0.0" class="required number"/>
			</p>
			<p>
				<label>Monthly Salary (today's money):</label>
				<input type="text" name="salary" id="salary" placeholder="00000.00" class="required number"/>
			</p>
			<p>
				<label>Salary growth rate, %:</label>
				<input type="text" name="rate_salary" id="rate_salary" placeholder="0.0" class="required number"/>
			</p>
			<p>
				<label>Tax Contribution, %:</label>
				<input type="text" name="rate_contribution" id="rate_contribution" placeholder="0.0" class="required number"/>
			</p>
			<p>
			<p>
				<label for="age_death">Life Expectancy (estimated):</label>
				<input type="text" name="age_death" id="age_death" placeholder="00" class="required number integer"/>
			</p>
			<p>
				<label for="cost_retirement_month">Spending per month during retirement (today's money):</label>
				<input type="text" name="cost_retirement_month" id="cost_retirement_month" placeholder="00000.00" class="required number"/>
			</p>
			<p>
				<label for="cost_death">Target Savings at Life Expectancy (today's money):</label>
				<input type="text" name="cost_death" id="cost_death" placeholder="00000.00" class="required number"/>
			</p>
				<button type="submit">Process</button>
				<!--<input type="submit" id="process" value="Process"/>-->
			</p>
			</fieldset></form>
		</div>
		<div id="tab-table">
		</div>
		<div id="space">
		</div>
		<div id="tab-graph">
		</div>
	</div>
</body>
</html>
