<div class="row visible-md visible-lg">	
	<div class="col-md-8">
		<h1 class="title_text">Bitcoin Poker Dice</h1>
	</div>
	<div class="col-md-4 text-right">
		<p class="deposit-address h4">Your Deposit Address <button type="button" ng-click="openModal('qrModalTemplate')" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-qrcode"></span></button></p>
		<p class="">{{user.address}}</p>
	</div>
</div>
<div class="row">
	<div class="col-sm-6 col-sm-push-3">
		<div class="visible-xs visible-sm">
			<p class="h4 text-center">
				<span>Wager: <i ng-show="stake > 1000000000000000" class="fa fa-btc"></i> <span ng-model="wager">{{stake / 100000000 | number:5}}</span>
				| <span>Balance: <i class="fa fa-btc"></i> <span ng-model="wager">{{user.available_balance / 100000000 | number:5}}</span>
			</p>
		</div>
		<div class="dice-box">
			<div class="clearfix"></div>

			<div ng-show="screenState == 'inplay'" class="dice-container white-outline">
				<h6 class="text-center">Click to Hold</h6>
				<dice-directive></dice-directive>
			</div>
			<div ng-show="screenState == 'new' " class="text-center white-outline">
				<h1 class="winner-text">Place Your Bets</h1>
				<p class="winner-instructions">Use the buttons below to place your wager.  Click <strong>Roll Dice!</strong> when you are ready.</p>
			</div>
			<div ng-show="screenState == 'result-loser'" class="text-center white-outline">
				<div class="row">
					<div class="col-md-6 text-center"><h1 class="text-center winner-text">Try Again</h1></div>
					<div class="col-md-6 playingCards inText rotateHand text-center">
						<div class="row winner-dice">
							<div class="spacer20 hidden-sm hidden-xs"></div>
							<div class="col-md-2 col-md-offset2 col-sm-2 col-sm-offset2 col-xs-2 col-xs-offset5">
								<single-die dice="last_roll.dice_1"></single-die>
							</div>
							<div class="col-md-2 col-md-offset1 col-sm-2 col-sm-offset1 col-xs-2 col-xs-offset1">
								<single-die dice="last_roll.dice_2"></single-die>
							</div>
							<div class="col-md-2 col-md-offset1 col-sm-2 col-sm-offset1 col-xs-2 col-xs-offset1">
								<single-die dice="last_roll.dice_3"></single-die>
							</div>
							<div class="col-md-2 col-md-offset1 col-sm-2 col-sm-offset1 col-xs-2 col-xs-offset1">
								<single-die dice="last_roll.dice_4"></single-die>
							</div>
							<div class="col-md-2 col-md-offset1 col-sm-2 col-sm-offset1 col-xs-2 col-xs-offset1">
								<single-die dice="last_roll.dice_5"></single-die>
							</div>
						</div>
					</div>
				</div>	
				<p class="winner-instructions">Use the buttons below to place your wager.  Click "Roll Dice" when you are ready.</p>
			</div>
			<div ng-show="screenState == 'result-winner'" class="text-center white-outline">
				<div class="row">
					<div class="col-md-6"><h1 class="winner-text">Winner!</h1></div>
					<div class="col-md-6 playingCards inText rotateHand text-center">
						<div class="row winner-dice">
							<div class="spacer20 hidden-sm hidden-xs"></div>
							<div class="col-md-2 col-md-offset2 col-sm-2 col-sm-offset2 col-xs-2 col-xs-offset5">
								<single-die dice="last_roll.dice_1"></single-die>
							</div>
							<div class="col-md-2 col-md-offset1 col-sm-2 col-sm-offset1 col-xs-2 col-xs-offset1">
								<single-die dice="last_roll.dice_2"></single-die>
							</div>
							<div class="col-md-2 col-md-offset1 col-sm-2 col-sm-offset1 col-xs-2 col-xs-offset1">
								<single-die dice="last_roll.dice_3"></single-die>
							</div>
							<div class="col-md-2 col-md-offset1 col-sm-2 col-sm-offset1 col-xs-2 col-xs-offset1">
								<single-die dice="last_roll.dice_4"></single-die>
							</div>
							<div class="col-md-2 col-md-offset1 col-sm-2 col-sm-offset1 col-xs-2 col-xs-offset1">
								<single-die dice="last_roll.dice_5"></single-die>
							</div>
						</div>
						<div class="row text-center">
							<p class="winner-instructions">{{winning_hand}} on {{winning_rolls_needed}} roll<span ng-show="winning_rolls_needed > 1">s</span> pays x{{winning_payout}}.</p>  
						</div>
						
					</div>
				</div>	
				<p class="winner-instructions">Use the buttons below to place your wager.  Click "Roll Dice" when you are ready.</p>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="row">
				<div class="col-md-12 text-center visible-lg visible-md">
					<p><small>Game Hash: {{game.hash}}</small></p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 col-sm-6 col-xs-7" style="padding-top:10px;">
					<div class="btn-group btn-group-justified">
						<a ng-repeat="wager in percent_wagers" ng-class="{'disabled': user.available_balance < 1}" ng-click="addPercentToWager(wager.amt)" class="btn btn-wager wager-buttons">{{wager.text}}</a>
						<a ng-click="addPercentToWager('max')" ng-class="{'disabled': user.available_balance < 1}" class="btn btn-wager wager-buttons">Max</a>
					</div>
					<div class="spacer10"></div>
					<div class="btn-group btn-group-justified">
						<a ng-repeat="wager in wager_amounts" ng-click="addAmtToWager(wager)" ng-class="{'disabled': user.available_balance < 1}" class="btn btn-wager wager-buttons">{{wager}}</a>
						<a ng-click="stake = 0" ng-class="{'disabled': user.available_balance < 1}" class="btn btn-wager wager-buttons">Reset</a>
					</div>
				</div>
				<div class="col-md-6  col-sm-6 col-xs-5" >
					<a type="button" ng-click="collect_win()" class="btn btn-collect disabled btn-lg btn-block">Collect</a>
					<a type="button" ng-click="roll_dice()" class="btn btn-roll btn-lg btn-block">Roll Dice!</a>
				</div>
			</div>
			<div class="spacer20"></div>
		</div>
		<div class="col-sm-3 col-sm-pull-6">
			<table class="table white-box odds-table visible-lg visible-md">
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
			<div class="white-box visible-lg visible-md">
				<div class="panel-body">

					<div class="row">
						<div class="col-md-4"><h4>Wager:</h4></div>
						<div class="col-md-8">
							<h4 class="pull-right no-top-or-bottom-marg" ng-show="stake < 0.00000001"><span>Free Play</span></h4>
							<h4 class="pull-right no-top-or-bottom-marg" ng-show="stake > 0"><i class="fa fa-btc"></i><span>{{stake / 100000000 | number:8}}</span></h4>
						</div>
					</div>
					<hr class="no-top-or-bottom-marg"/>
					<div class="row">
						<div class="col-md-4"><h4>Balance:</h4></div>
						<div class="col-md-8"><h4 class="pull-right"><i class="fa fa-btc"></i> {{user.available_balance / 100000000 | number:8}}</h4></div>
					</div>
				</div>
			</div>
			
			<table class='table white-box odds-table game-info-box'>
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
			<p class="text-center seed-link"><a ng-click="openSeedModal()">Set client seeds for this roll.</a></p>
		</div>

	</div>
	<div class="panel panel-default hidden-sm hidden-xs" ng-controller="tabController">
		<div class="panel-body">
			<tabset>
				
				<tab heading="My Games">
					<div class="spacer10"></div>
					<div ng-controller="ctrlRead">


						<table class="table table-striped table-condensed table-hover">
							<thead>

								<tr>
									<th class="id" custom-sort order="'id'" sort="sort">Id&nbsp;</th>
									<th class="updated_on" custom-sort order="'updated_on'" sort="sort">Date&nbsp;</th>
									<th class="result" custom-sort order="'result'" sort="sort">Result&nbsp;</th>
									<th class="stake" custom-sort order="'stake'" sort="sort">Stake&nbsp;</th>
									<th class="winning_hand" custom-sort order="'winning_hand'" sort="sort">Winning Hand&nbsp;</th>
									<th class="rolls" custom-sort order="'rolls'" sort="sort">Rolls&nbsp;</th>
									<th class="profit" custom-sort order="'profit'" sort="sort">Profit&nbsp;</th>
									<th class="proof" custom-sort order="'proof'" sort="sort">Provably Fair&nbsp;</th>
								</tr>
							</thead>
							<!-- <tfoot>
								<td colspan="6">
									<div class="pagination pull-right">
										<ul>
											<li ng-class="{disabled: currentPage == 0}">
												<a href ng-click="prevPage()">« Prev</a>
											</li>

											<li ng-repeat="n in range(pagedItems.length, currentPage, currentPage + gap) "
											ng-class="{active: n == currentPage}"
											ng-click="setPage()">
											<a href ng-bind="n + 1">1</a>
										</li>

										<li ng-class="{disabled: (currentPage) == pagedItems.length - 1}">
											<a href ng-click="nextPage()">Next »</a>
										</li>
									</ul>
								</div>
							</td>
						</tfoot> -->
						<tbody>
							<tr ng-repeat="item in pagedItems[currentPage] | orderBy:sort.sortingOrder:sort.reverse">
								<td>{{item.id}}</td>
								<td>{{item.updated_on}}</td>
								<td>{{item.result}}</td>
								<td>{{item.stake}}</td>
								<td>{{item.winning_hand}}</td>
								<td>{{item.rolls}}</td>
								<td>{{item.profit}}</td>
								<td><a href="#/proof/{{item.id}}" class="btn btn-success">See Proof</a></td>
							</tr>
						</tbody>
					</table>
				</div>
			</tab>
			<tab heading="Global Games">
				<div class="spacer10"></div>
				<!-- <table datatable="" dt-options="mygames_dtOptions" dt-columns="mygames_dtColumns" class="table table-bordered"></table> -->
			</tab>
		</tabset>
	</div>