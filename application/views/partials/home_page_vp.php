<div class="container vp-body">
<div class="spacer20"></div>
<div class="row">
	<div class="col-md-8 col-lg-8">
		<div class="visible-md visible-lg">
			<div class="row">
				<div class="col-md-10 col-md-offset-1">
					<!-- <div class="panel panel-default">
					<div class="panel-heading">Pay Tables</div> -->
					
						<tabset vertical="false" type="tabs">
							<tab ng-repeat="game in games | toArray" heading="{{pageLang.games[game.name]}}" disabled="bets_disabled" ng-click="changePaytable(game.name)">
								<table class="table table-condensed table-bordered vp-payouts-table">
								<thead>
									<tr>
										<td ng-class="{'danger':winning_hand == hand.name}" ng-repeat="hand in game.hands | toArray | orderBy:payout.sort">{{pageLang.hands[hand.name]}}</td>
									</tr>
								</thead>
									<tbody>
										<tr>
										<td ng-class="{'danger':winning_hand == hand.name}" ng-repeat="hand in game.hands | toArray | orderBy:payout.bet_5">{{hand.payout.bet_1}}</td>
											<!-- <td width="25%">{{pageLang.hands[hand.name]}}</td>
											<td class="text-right" ng-class="{'danger': stake == 1}" width="15%">{{hand.payout.bet_1}}</td>
											<td class="text-right" ng-class="{'danger': stake == 2}" width="15%">{{hand.payout.bet_1 * 2}}</td>
											<td class="text-right" ng-class="{'danger': stake == 3}" width="15%">{{hand.payout.bet_1 * 3}}</td>
											<td class="text-right" ng-class="{'danger': stake == 4}" width="15%">{{hand.payout.bet_1 * 4}}</td>
											<td class="text-right" ng-class="{'danger': stake == 5}" width="15%">{{hand.payout.bet_1 * 5}}</td> -->
										</tr>
									</tbody>
								</table>
							</tab>
						</tabset>
					<!-- </div> -->
				</div>
			</div>

		</div>
		
		<cards-directive></cards-directive>

		<div class="row">
			<div class="col-md-12 text-center visible-lg visible-md visible-sm">
				<p><small>Game ID: {{game.id}} {{lang.game_hash}}: {{game.hash}}</small></p>
				<form class="form-inline" role="form">
				  <div class="form-group">
				    <label for="client_seed">Client Seed</label>
				    <input class="form-control input-sm" name="client_seed" ng-model="client_seed" ng-disabled="bets_disabled" size="20" />
				  </div>
  			</form>
				</div>
		</div>
		<div class="spacer20"></div>
	</div>

	<div class=" col-md-4 col-lg-4">
		<h1 class="title_text_vp text-center">{{pageLang.title}}</h1>
		
		<div class="visible-lg visible-md">
			<div class="panel-body">
				<div class="row">
					<div class="col-md-4"><h4 class="wager-text">{{lang.wager}}:</h4></div>
					<div class="col-md-8">
						<h4 class="pull-right wager-text" ng-show="stake < 0.00000001"><span>{{lang.free_play}}</span></h4>
						<h4 class="pull-right wager-text black-text" ng-show="stake > 0"><i class="fa fa-btc"></i> <span>{{stake / 100000000 | number:8}}</span></h4>
					</div>
				</div>
				<hr class="no-top-or-bottom-marg"/>
				<div class="row">
					<div class="col-md-4 wager-text"><h4 class="wager-text">{{lang.balance}}:</h4></div>
					<div class="col-md-8 wager-text"><h4 class="pull-right wager-text"><i class="fa fa-btc"></i> {{user.available_balance / 100000000 | number:8}}</h4></div>
				</div>
			</div>
		</div>
		<!-- <div class=""> -->
		<div class="row">
			<div class="col-md-6 text-center">
			<div class="btn-group btn-group-justified">
						<a ng-repeat="wager in percent_wagers" ng-class="{'disabled': user.available_balance < 1,'disabled':all_disabled,'disabled':bets_disabled}" ng-click="addPercentToWager(wager)" class="btn btn-wager wager-buttons">{{wager * 100}}%</a>
						<a ng-click="addPercentToWager('max')" ng-class="{'disabled': user.available_balance < 1,'disabled':all_disabled,'disabled':bets_disabled}" class="btn btn-wager wager-buttons">{{lang.max}}</a>
					</div>
					<div class="spacer10"></div>
					<div class="btn-group btn-group-justified">
						<a ng-repeat="wager in wager_amounts" ng-click="addAmtToWager(wager)" ng-class="{'disabled': user.available_balance < 1,'disabled':all_disabled,'disabled':bets_disabled}" class="btn btn-wager wager-buttons">{{wager}}</a>
						<a ng-click="stake = 0" ng-class="{'disabled': user.available_balance < 1,'disabled':all_disabled,'disabled':bets_disabled}" class="btn btn-wager wager-buttons">{{lang.reset}}</a>
					</div>
				</div>
			<!-- <div class="btn-group btn-group-justified">
				<a ng-repeat="wager in percent_wagers" ng-class="{'disabled': user.available_balance < 1}" ng-click="addPercentToWager(wager.amt)" class="btn btn-lg btn-wager wager-buttons-vp">{{wager}}</a>
						</div>	
				<button type="button" class="btn btn-danger" ng-class="{'disabled':all_disabled}" ng-click="betOne()">Bet<br />One</button>
				<button type="button" class="btn btn-danger" ng-class="{'disabled':all_disabled}" ng-click="betMax()">Bet<br />Max</button>
			</div> -->
			<div class="col-md-6">
				<div class="spacer5"></div>
				<button type="button" class="btn btn-lg btn-success  btn-block" ng-class="{'disabled':all_disabled}" ng-click="drawCards()">DRAW</button>
			</div>
		</div>

	</div>
</div>
<div class="panel panel-default hidden-sm hidden-xs">
	<div class="panel-body">
		<tabset>				
			<tab heading="{{lang.my_games}}">
				<div class="spacer10"></div>
				<div>
					<games-table-directive global="0" gametype="videopoker"></games-table-directive>
				</div>
			</tab>
			<tab heading="{{lang.global_games}}">
				<div class="spacer10"></div>
				<div ng-controller="allGamesController">
					<games-table-directive global="1" gametype="videopoker"></games-table-directive>
				</div>
			</tab>
		</tabset>
	</div>
</div>