<div class="row">
	<div class="col-sm-6 col-sm-push-3">
		<div class="dice-box">
				<div class="clearfix"></div>
				<h4 class="text-center">Click to Hold</h4>
				<div class="dice-container">
					<dice-directive></dice-directive>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="row">
				<div class="col-md-12 text-center">
					<p><small>Game Hash:<br/> {{game.hash}}</small></p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6" style="padding-top:10px;">
					<div class="btn-group btn-group-justified">
						<a ng-repeat="wager in percent_wagers" ng-click="addPercentToWager(wager.amt)" class="btn btn-wager wager-buttons">{{wager.text}}</a>
						<a ng-click="addPercentToWager('max')" class="btn btn-wager wager-buttons">Max</a>
					</div>
					<div class="spacer10"></div>
					<div class="btn-group btn-group-justified">
						<a ng-repeat="wager in wager_amounts" ng-click="addAmtToWager(wager)" class="btn btn-wager wager-buttons">{{wager}}</a>
						<a ng-click="stake = 0" class="btn btn-wager wager-buttons">Reset</a>
					</div>
				</div>
				<div class="col-md-6" >
					<a type="button" ng-click="roll_dice()" class="btn btn-collect disabled btn-lg btn-block">Collect</a>
					<a type="button" ng-click="roll_dice()" class="btn btn-roll btn-lg btn-block">Roll Dice!</a>
				</div>
			</div>
	</div>
	<div class="col-sm-3 col-sm-pull-6">
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
	<div class="col-sm-3">
		
			<div class="spacer10"></div>
			<div class="white-box">
				<div class="panel-body">

					<div class="row">
						<div class="col-md-4"><h4>Wager</h4></div>
						<div class="col-md-8"><h4 class="pull-right"><i class="fa fa-btc"></i> <span ng-model="wager">{{stake / 100000000 | number:8}}</span></h4></div>
					</div>
					<hr />
					<div class="row">
						<div class="col-md-4"><h4>Balance</h4></div>
						<div class="col-md-8"><h4 class="pull-right"><i class="fa fa-btc"></i> {{user.available_balance / 100000000 | number:8}}</h4></div>
					</div>
				</div>
			</div>
			
			<table class='table white-box odds-table'>
				<thead>
					<tr class="text-center">
						<td>Game ID</td>
						<td>Rolls Remaining</td>
					</tr>
				</thead>
				<tbody>
					<tr class="text-center">
						<td>{{game.id}}</td><td>{{rolls_remaining}}</td>
					</tr>
					<!-- <tr><td class="text-center" colspan="3"><small>Game Hash: {{game.hash}}</small></td></tr> -->
				</tbody>
			</table>
			
	</div>
</div>