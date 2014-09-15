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