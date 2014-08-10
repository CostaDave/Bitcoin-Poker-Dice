<h1 class="title_text">Account History</h1>
<div class="panel panel-default" ng-controller="tabController">
		<div class="panel-body">
			<tabset>
				
				<tab heading="My Games">
					<div class="spacer10"></div>
					<div ng-controller="ctrlRead">


						<table class="table table-striped table-condensed table-hover table-responsive">
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
			<tab heading="Global Games">
				<div class="spacer10"></div>
				<!-- <table datatable="" dt-options="mygames_dtOptions" dt-columns="mygames_dtColumns" class="table table-bordered"></table> -->
			</tab>
			<tab heading="Transactions">Transactions</tab>
		</tabset>
	</div>