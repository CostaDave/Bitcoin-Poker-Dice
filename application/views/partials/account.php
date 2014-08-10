<h1 class="title_text">Account History</h1>
<div class="panel panel-default" ng-controller="tabController">
		<div class="panel-body">
			<tabset>
				<tab heading="Settings">
				<?php $this->load->view("partials/account_settings");?>
			</tab>
				<tab heading="My Games">
					<div class="spacer10"></div>
					<div class="table-responsive" ng-controller="ctrlRead">


						<table class="table table-striped table-condensed table-hover table-responsive">
							<thead>

								<tr>
									<th class="id" custom-sort order="'id'" sort="sort">ID&nbsp;</th>
									<th class="updated_on" custom-sort order="'updated_on'" sort="sort">Date&nbsp;</th>
									<th class="result" custom-sort order="'result'" sort="sort">Result&nbsp;</th>
									<th class="stake" custom-sort order="'stake'" sort="sort">Stake&nbsp;</th>
									<th class="winning_hand" custom-sort order="'winning_hand'" sort="sort">Winning Hand&nbsp;</th>
									<th class="rolls" custom-sort order="'rolls'" sort="sort">Rolls&nbsp;</th>
									<th class="profit" custom-sort order="'profit'" sort="sort">Profit&nbsp;</th>
									<th class="proof" custom-sort order="'proof'" sort="sort">Provably Fair&nbsp;</th>
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
								<td><a href="#/proof/{{item.id}}" class="btn btn-success">See Proof</a></td>
							</tr>
						</tbody>
					</table>
				</div>
			</tab>
			<tab heading="Transactions">
				<div class="spacer10"></div>
					<div class="table-responsive" ng-controller="tranTableController">
						<table class="table table-striped table-condensed table-hover table-responsive">
							<thead>

								<tr>
									<th class="id" custom-sort order="'id'" sort="sort">ID&nbsp;</th>
									<th class="updated_on" custom-sort order="'updated_on'" sort="sort">Date&nbsp;</th>
									<th class="type" custom-sort order="'type'" sort="sort">Type&nbsp;</th>
									<th class="amount" custom-sort order="'amount'" sort="sort">Amount&nbsp;</th>
									<th class="reference" custom-sort order="'reference'" sort="sort">Reference&nbsp;</th>
									<th class="balance" custom-sort order="'balance'" sort="sort">Balance&nbsp;</th>
								</tr>
							</thead>
						<tbody>
							<tr ng-show="items.length < 1"><td colspan="8">No Records to Display</td></tr>
							<tr ng-repeat="item in pagedItems[currentPage] | orderBy:sort.sortingOrder:sort.reverse">
								<td>{{item.id}}</td>
								<td>{{item.updated_on}}</td>
								<td>{{item.type}}</td>
								<td ng-class="{'red-text': item.type =='debit', 'green-text': item.type == 'credit'}">{{item.amount / 100000000 | number:8}}</td>
								<td>{{item.reference}}</td>
								<td>{{item.balance / 100000000 | number:8}}</td>
							</tr>
						</tbody>
					</table>
				</div>
			</tab>
			
		</tabset>
	</div>