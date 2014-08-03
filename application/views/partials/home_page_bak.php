
<div class="container">
	<div class="row">	
		<div class="col-md-8">
			<h1>Bitcoin Poker Dice</h1>
		</div>
		<div class="col-md-4 text-right">
			<p class="deposit-address h4">Your Deposit Address <button type="button" ng-click="openModal('qrModalTemplate')" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-qrcode"></span></button></p>
			<p class="">{{user.address}}</p>
		</div>
	</div>
	<div class="row">
		<div class="col-md-3">
			<table class="table white-box odds-table">
				<thead>
					<!-- <tr><td><td colspan="3" class="text-center">Payouts</td></tr> -->
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
		<div class="col-md-6" >

			
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
			<div class="text-center dice-bg">
			</div>
			<div class="spacer30"></div>
			<!-- <div class="text-center">
				<img class="dice-img" src="/assets/img/dice.png" />
			</div> -->
		</div>
		<div class="col-md-3">

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
	<div class="panel panel-default" ng-controller="tabController">
		<div class="panel-body">
			<tabset>
				
				<tab heading="My Games">
				<div class="spacer10"></div>
					<table datatable="" dt-options="allgames_dtOptions" dt-columns="allgames_dtColumns" class="table table-bordered"></table>
				</tab>
				<tab heading="Global Games">
				<div class="spacer10"></div>
					<table datatable="" dt-options="mygames_dtOptions" dt-columns="mygames_dtColumns" class="table table-bordered"></table>
				</tab>
		</tabset>
	</div>
</div>
	<!-- <div class="row white-box">
		<div class="spacer20"></div>
		<div class="col-md-12">
			<ul class="nav nav-tabs" role="tablist">
				<li class="active"><a href="#home" role="tab" data-toggle="tab">All Games</a></li>
				<li><a href="#profile" role="tab" data-toggle="tab">Profile</a></li>
				<li><a href="#messages" role="tab" data-toggle="tab">Messages</a></li>
				<li><a href="#settings" role="tab" data-toggle="tab">Settings</a></li>
			</ul>

			<!-- Tab panes -->
			<!-- <div class="tab-content">
				<div class="tab-pane active" id="home">
					<div class="datatable" id="datatable" ng-controller="gameTableController">

						<table class="table table-striped table-condensed table-hover">
							<thead>
								<tr>
									<th ng-repeat="header in headers | filter:headerFilter | orderBy:headerOrder" width="{{header.width}}">{{header.label}}</th>
								</tr>
							</thead>
							<tbody>
								<tr ng-repeat="user in users" ng-class-odd="'trOdd'" ng-class-even="'trEven'" ng-dblclick="rowDoubleClicked(user)">
									<td ng-repeat="(key,val) in user | orderBy:userOrder(key)">{{val}}</td>
								</tr>
							</tbody>
							<tfoot>

							</tfoot>
						</table>

					</div>
				</div>
				<div class="tab-pane" id="profile">...</div>
				<div class="tab-pane" id="messages">...</div>
				<div class="tab-pane" id="settings">...</div>
			</div>
		</div>
		<div class="spacer20"></div>
	</div> --> -->
</div>

<script type="text/ng-template" id="diceTemplate1">
	<div class="row">
		<div class="col-md-2 col-sm-2 col-xs-2 col-md-offset-1"><i id="dice_1" class="dice dice_1"></i></div>
		<div class="col-md-2 col-sm-2 col-xs-2"><i id="dice_2" class="dice dice_2"></i></div>
		<div class="col-md-2 col-sm-2 col-xs-2"><i id="dice_3" class="dice dice_3"></i></div>
		<div class="col-md-2 col-sm-2 col-xs-2"><i id="dice_4" class="dice dice_4"></i></div>
		<div class="col-md-2 col-sm-2 col-xs-2"><i id="dice_5" class="dice dice_5"></i></div>
	</div>
</script>
<script type="text/ng-template" id="diceTemplate">
	<div class="playingCards fourColours rotateHand text-center">
		<div class="row">
			<div class="col-md-2 col-md-offset-1">
				<a id="dice_1" class="card rank-q hearts" ng-click="toggleHold(1)">
					<span class="rank">Q</span>
					<span class="suit">&hearts;</span>
				</a>
			</div>
			<div class="col-md-2">
				<a id="dice_2" class="card rank-q hearts" ng-click="toggleHold(2)">
					<span class="rank">Q</span>
					<span class="suit">&hearts;</span>
				</a>
			</div>
			<div class="col-md-2">
				<a id="dice_3" class="card rank-q hearts" ng-click="toggleHold(3)">
					<span class="rank">Q</span>
					<span class="suit">&hearts;</span>
				</a>
			</div>
			<div class="col-md-2">
				<a id="dice_4" class="card rank-q hearts" ng-click="toggleHold(4)">
					<span class="rank">Q</span>
					<span class="suit">&hearts;</span>
				</a>
			</div>
			<div class="col-md-2">
				<a id="dice_5" class="card rank-q hearts" ng-click="toggleHold(5)">
					<span class="rank">Q</span>
					<span class="suit">&hearts;</span>
				</a>
			</div>


		</div>
	</div>

</script>
<script type="text/ng-template" id="winnerModalTemplate">
	<div class="modal-header">
		<h3 class="modal-title">WINNER!!</h3>
	</div>
	<div class="modal-body text-center">
		<address-qr-code data-address="user.address"></address-qr-code>
		<h3>{{user.address}}</h3>
	</div>
	<div class="modal-footer">
		<button class="btn btn-primary" ng-click="ok()">OK</button>
	</div>
</script>
<script type="text/ng-template" id="qrModalTemplate">
	<div class="modal-header">
		<h3 class="modal-title">Make a Deposit</h3>
	</div>
	<div class="modal-body text-center">
		<address-qr-code data-address="user.address"></address-qr-code>
		<h3>{{user.address}}</h3>
	</div>
	<div class="modal-footer">
		<button class="btn btn-primary" ng-click="ok()">OK</button>
	</div>
</script>