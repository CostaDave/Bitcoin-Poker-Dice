<div class="container">
<div class="row">
<h1>Payouts</h1>
<table class="table white-box odds-table">
	<thead>
		<tr>
			<td>Type</td>
			<td>1 Roll</td>
			<td>2 Roll</td>
			<td>3 Roll</td>
		</tr>
	</thead>
	<tbody>
		<tr ng-repeat="roll in odds | orderBy:'odds'">
			<td>{{roll.name}}</td>
			<td class="text-center">x{{roll.payout.roll_1}}</td>
			<td class="text-center">x{{roll.payout.roll_2}}</td>
			<td class="text-center" ng-if="roll.payout.roll_3 == null">--</td>
			<td class="text-center" ng-if="roll.payout.roll_3 != null">x{{roll.payout.roll_3}}</td>
		</tr>
	</tbody>
</table>
</div>
</div>