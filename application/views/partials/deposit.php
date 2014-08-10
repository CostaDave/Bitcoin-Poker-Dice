
		<h1 class="title_text">{{lang.title_deposit}}</h1>
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="row">

							<div class="col-md-4 text-center">
							<h4 class="black-text text-left">{{lang.deposit_address}}</h4>
								<address-qr-code></address-qr-code>
								<h6 class="black-text">{{user.address}}</h6>
							</div>
							<div class="col-md-8">
							<h5 class="black-text">{{lang.page_deposit_deposit_history}}</h5>


						<table class="table table-striped table-condensed table-hover">
							<thead>

								<tr>
									<th class="id" custom-sort order="'id'" sort="sort">{{lang.result_id}}&nbsp;</th>
									<th class="updated_on" custom-sort order="'updated_on'" sort="sort">{{lang.date}}&nbsp;</th>
									<th class="amount" custom-sort order="'result'" sort="sort">{{lang.amount}}&nbsp;</th>
									<th class="transaction_hash" custom-sort order="'stake'" sort="sort">{{lang.tran_hash}}&nbsp;</th>
									<th class="destination_address" custom-sort order="'winning_hand'" sort="sort">{{lang.address}}&nbsp;</th>
									<th class="status" custom-sort order="'rolls'" sort="sort">{{lang.status}}&nbsp;</th>
								</tr>
							</thead>
						<tbody>
						<tr ng-show="items === false"><td colspan="6">{{lang.no_records}}</td></tr>
						<tr ng-show="items" ng-repeat="item in pagedItems[currentPage] | orderBy:sort.sortingOrder:sort.reverse">
							<td>{{item.id}}</td>
							<td>{{item.updated_on}}</td>
							<td>{{item.result}}</td>
							<td>{{item.stake}}</td>
							<td>{{item.winning_hand}}</td>
							<td><a href="#/proof/{{item.id}}" class="btn btn-success">{{lang.see_proof}}</a></td>
						</tr>
						</tbody>
					</table>
							</div>
						</div>
					</div>
				</div>
			</div>
