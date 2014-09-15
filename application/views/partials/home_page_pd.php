<div class="container pokerdice">
<div class="row visible-md visible-lg">	
	<div class="col-md-8">
		<h1 class="title_text">{{pageLang.title}}</h1>
	</div>
	<div class="col-md-4 text-right">
		<p class="deposit-address h4">{{lang.deposit_address}} <button type="button" ng-click="openModal('qrModalTemplate')" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-qrcode"></span></button></p>
		<p class="">{{user.address}}</p>
	</div>
</div>
<div class="row">
	<div class="col-md-6 col-lg-6 col-md-push-3 col-lg-push-3">
		<div class="visible-xs visible-sm ">
		<div class="spacer10"></div>
			<div class="white-box text-center">
				<h5 ng-show="stake < 0.00000001">{{lang.wager}}: <span>Free Play</span>  |  {{lang.balance}}: <i class="fa fa-btc"></i> {{user.available_balance / 100000000 | number:8}} </h5>
				<h5 ng-show="stake > 0">{{lang.wager}}: <i class="fa fa-btc"></i><span>{{stake / 100000000 | number:8}}</span>  |  {{lang.balance}}: <i class="fa fa-btc"></i> {{user.available_balance / 100000000 | number:8}}</h5 >
			</div>
		</div>
		<div class="dice-box">
			<div class="clearfix"></div>
			<div class="dice-container white-outline main-box">
				<div ng-show="screenState == 'inplay'">
					<h6 class="text-center">{{lang.click_to_hold}}</h6>
					<dice-directive></dice-directive>
				</div>
				<div ng-show="screenState == 'new'">
					<h1 class="new-text text-center">{{lang.place_bets}}</h1>
					<p class="winner-instructions text-center">{{lang.new_instruction}}</p>
				</div>
				<div ng-show="screenState == 'result-winner'">
					<div class="row">
						<div class="col-md-5 col-sm-5 col-xs-5 text-center" style="padding-left:0px; padding-right:0px;">
							<h1 class="text-right loser-text">Winner!</h1>
						</div>
						<div class="col-md-7 col-sm-7 col-xs-7 text-center">
							<div class="text-center">
						    <div id="dice_1_result" ng-class="{'dice-a': last_roll.dice_1 == 'A','dice-k': last_roll.dice_1 == 'K','dice-q': last_roll.dice_1 == 'Q','dice-j': last_roll.dice_1 == 'J','dice-10': last_roll.dice_1 == '10','dice-9': last_roll.dice_1 == '9'}" class="dice result"></div>
						    <div id="dice_2_result" ng-class="{'dice-a': last_roll.dice_2 == 'A','dice-k': last_roll.dice_2 == 'K','dice-q': last_roll.dice_2 == 'Q','dice-j': last_roll.dice_2 == 'J','dice-10': last_roll.dice_2 == '10','dice-9': last_roll.dice_2 == '9'}" class="dice result"></div>
						    <div id="dice_3_result" ng-class="{'dice-a': last_roll.dice_3 == 'A','dice-k': last_roll.dice_3 == 'K','dice-q': last_roll.dice_3 == 'Q','dice-j': last_roll.dice_3 == 'J','dice-10': last_roll.dice_3 == '10','dice-9': last_roll.dice_3 == '9'}" class="dice result"></div>
						    <div id="dice_4_result" ng-class="{'dice-a': last_roll.dice_4 == 'A','dice-k': last_roll.dice_4 == 'K','dice-q': last_roll.dice_4 == 'Q','dice-j': last_roll.dice_4 == 'J','dice-10': last_roll.dice_4 == '10','dice-9': last_roll.dice_4 == '9'}" class="dice result"></div>
						    <div id="dice_5_result" ng-class="{'dice-a': last_roll.dice_5 == 'A','dice-k': last_roll.dice_5 == 'K','dice-q': last_roll.dice_5 == 'Q','dice-j': last_roll.dice_5 == 'J','dice-10': last_roll.dice_5 == '10','dice-9': last_roll.dice_5 == '9'}" class="dice result"></div> 
						  </div>
						  <div class="clearfix"></div>
							<div class="row text-center">
								<p class="winner-instructions">{{winning_hand}} on {{winning_rolls_needed}} roll<span ng-show="winning_rolls_needed > 1">s</span> pays x{{winning_payout}}.</p>  
							</div>
						</div>			
					</div>
					<p class="winner-instructions text-center">{{lang.result_win_instruction}}</p>
				</div>
				<div ng-show="screenState == 'result-loser'">
					<div class="row">
						<div class="col-md-5 col-sm-5 col-xs-5 text-center" style="padding-left:0px; padding-right:0px;">
							<h1 class="text-right loser-text">Try Again</h1>
						</div>
						<div class="col-md-7 col-sm-7 col-xs-7 text-center">
							<div class="text-center">
						    <div id="dice_1_result" ng-class="{'dice-a': last_roll.dice_1 == 'A','dice-k': last_roll.dice_1 == 'K','dice-q': last_roll.dice_1 == 'Q','dice-j': last_roll.dice_1 == 'J','dice-10': last_roll.dice_1 == '10','dice-9': last_roll.dice_1 == '9'}" class="dice result"></div>
						    <div id="dice_2_result" ng-class="{'dice-a': last_roll.dice_2 == 'A','dice-k': last_roll.dice_2 == 'K','dice-q': last_roll.dice_2 == 'Q','dice-j': last_roll.dice_2 == 'J','dice-10': last_roll.dice_2 == '10','dice-9': last_roll.dice_2 == '9'}" class="dice result"></div>
						    <div id="dice_3_result" ng-class="{'dice-a': last_roll.dice_3 == 'A','dice-k': last_roll.dice_3 == 'K','dice-q': last_roll.dice_3 == 'Q','dice-j': last_roll.dice_3 == 'J','dice-10': last_roll.dice_3 == '10','dice-9': last_roll.dice_3 == '9'}" class="dice result"></div>
						    <div id="dice_4_result" ng-class="{'dice-a': last_roll.dice_4 == 'A','dice-k': last_roll.dice_4 == 'K','dice-q': last_roll.dice_4 == 'Q','dice-j': last_roll.dice_4 == 'J','dice-10': last_roll.dice_4 == '10','dice-9': last_roll.dice_4 == '9'}" class="dice result"></div>
						    <div id="dice_5_result" ng-class="{'dice-a': last_roll.dice_5 == 'A','dice-k': last_roll.dice_5 == 'K','dice-q': last_roll.dice_5 == 'Q','dice-j': last_roll.dice_5 == 'J','dice-10': last_roll.dice_5 == '10','dice-9': last_roll.dice_5 == '9'}" class="dice result"></div> 
						  </div>
						</div>
					</div>
					<p class="winner-instructions text-center">{{lang.result_lose_instruction}}</p>
				</div>			
			</div>			
			<div class="clearfix"></div>
		</div>
		<div class="row">
				<div class="col-md-12 text-center visible-lg visible-md visible-sm">
					<p><small>{{lang.game_hash}}: {{game.hash}}</small></p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 col-sm-6 col-xs-7 " style="padding-top:10px;">
					<div class="btn-group btn-group-justified">
						<a ng-repeat="wager in percent_wagers" ng-class="{'disabled': user.available_balance < 1}" ng-click="addPercentToWager(wager.amt)" class="btn btn-wager wager-buttons">{{wager.text}}</a>
						<a ng-click="addPercentToWager('max')" ng-class="{'disabled': user.available_balance < 1}" class="btn btn-wager wager-buttons">{{lang.max}}</a>
					</div>
					<div class="spacer10"></div>
					<div class="btn-group btn-group-justified">
						<a ng-repeat="wager in wager_amounts" ng-click="addAmtToWager(wager)" ng-class="{'disabled': user.available_balance < 1}" class="btn btn-wager wager-buttons">{{wager}}</a>
						<a ng-click="stake = 0" ng-class="{'disabled': user.available_balance < 1}" class="btn btn-wager wager-buttons">{{lang.reset}}</a>
					</div>
				</div>
				<div class="col-md-6  col-sm-6 col-xs-5" >
					<a type="button" ng-click="collect_win()" class="btn btn-collect disabled btn-lg btn-block">{{lang.collect}}</a>
					<a type="button" ng-click="roll()" class="btn btn-roll btn-lg btn-block">{{lang.roll_dice}}</a>
				</div>
			</div>
			<div class="spacer20"></div>
		</div>
		<div class="col-md-3 col-md-pull-6 col-lg-pull-6 visible-md visible-lg">
			<table width="100%" class="table white-box">
				<thead>
					<tr>
						<td>{{lang.payoffs_type}}</td>
						<td class="text-center">{{lang.payoffs_one_roll}}</td>
						<td class="text-center">{{lang.payoffs_two_roll}}</td>
						<td class="text-center">{{lang.payoffs_three_roll}}</td>
					</tr>
				</thead>
				<tbody>
					<tr ng-repeat="hand in hands | orderBy:''">
						<td>{{pageLang.hands[hand.name]}}</td>
						<td class="text-center">x{{hand.payout.roll_1}}</td>
						<td class="text-center">x{{hand.payout.roll_2}}</td>
						<td class="text-center" ng-show="hand.payout.roll_3 ==0">--</td>
						<td class="text-center" ng-show="hand.payout.roll_3 > 0">x{{hand.payout.roll_3}}</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class=" col-md-3 col-lg-3">
			<div class="white-box visible-lg visible-md">
				<div class="panel-body">
					<div class="row">
						<div class="col-md-4"><h4 class="wager-text">{{lang.wager}}:</h4></div>
						<div class="col-md-8">
							<h4 class="pull-right wager-text" ng-show="stake < 0.00000001"><span>{{lang.free_play}}</span></h4>
							<h4 class="pull-right wager-text" ng-show="stake > 0"><i class="fa fa-btc"></i> <span>{{stake / 100000000 | number:8}}</span></h4>
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
			<table class='table white-box odds-table game-info-box'>
				<thead>
					<tr class="text-center">
						<td>{{lang.game_id}}</td>
						<td>{{lang.rolls_remaining}}</td>
					</tr>
				</thead>
				<tbody>
					<tr class="text-center">
						<td>{{game.id}}</td><td>{{rolls_remaining}}</td>
					</tr>
					<!-- <tr class="visible-sm visible-xs"><td class="text-center" colspan="3"><small>Game Hash: {{game.hash}}</small></td></tr> -->
				</tbody>
			</table>
			<p class="text-center seed-link"><a ng-click="openSeedModal()">{{lang.set_client_seeds}}</a></p>
		</div>
	</div>
	<div class="panel panel-default hidden-sm hidden-xs" ng-controller="tabController">
		<div class="panel-body">
			<tabset>				
				<tab heading="{{lang.my_games}}">
					<div class="spacer10"></div>
					<div>
						<table class="table table-striped table-condensed table-hover">
							<thead>
								<tr>
									<th class="id">{{lang.result_id}}&nbsp;</th>
									<th class="updated_on">{{lang.date}}&nbsp;</th>
									<th class="result">{{lang.result}}&nbsp;</th>
									<th class="stake">{{lang.stake}}&nbsp;</th>
									<th class="winning_hand">{{lang.winnging_hand}}&nbsp;</th>
									<th class="rolls">{{lang.rolls}}&nbsp;</th>
									<th class="profit">{{lang.profit}}&nbsp;</th>
									<th class="proof">{{lang.provably_fair}}&nbsp;</th>
								</tr>
							</thead>
						<tbody>
							<tr ng-show="items === false"><td colspan="8">No Records to Display</td></tr>
							<tr ng-repeat="item in pagedItems[currentPage] | orderBy:sort.sortingOrder:sort.reverse">
								<td>{{item.id}}</td>
								<td>{{item.updated_on}}</td>
								<td>{{item.result}}</td>
								<td>{{item.stake}}</td>
								<td>{{item.winning_hand}}</td>
								<td>{{item.rolls}}</td>
								<td>{{item.profit}}</td>
								<td><a ui-sref="proof({game_id:item.id})" class="btn btn-success">See Proof</a></td>
							</tr>
						</tbody>
					</table>
				</div>
			</tab>
			<tab heading="{{lang.global_games}}">
				<div class="spacer10"></div>
				<div ng-controller="allGamesController">
						<table class="table table-striped table-condensed table-hover">
							<thead>
								<tr>
									<th class="id">{{lang.result_id}}&nbsp;</th>
									<th class="updated_on">{{lang.date}}&nbsp;</th>
									<th class="result">{{lang.result}}&nbsp;</th>
									<th class="stake">{{lang.stake}}&nbsp;</th>
									<th class="winning_hand">{{lang.winnging_hand}}&nbsp;</th>
									<th class="rolls">{{lang.rolls}}&nbsp;</th>
									<th class="profit">{{lang.profit}}&nbsp;</th>
									<th class="proof">{{lang.provably_fair}}&nbsp;</th>
								</tr>
							</thead>
						<tbody>
							<tr ng-show="items === false"><td colspan="8">No Records to Display</td></tr>
							<tr ng-repeat="item in items">
								<td>{{item.id}}</td>
								<td>{{item.updated_on}}</td>
								<td>{{item.result}}</td>
								<td>{{item.stake}}</td>
								<td>{{item.winning_hand}}</td>
								<td>{{item.rolls}}</td>
								<td>{{item.profit}}</td>
								<td><a ui-sref="proof({game_id:item.id})" class="btn btn-success">See Proof</a></td>
							</tr>
						</tbody>
					</table>
				</div>
			</tab>
		</tabset>
	</div>
	</div>