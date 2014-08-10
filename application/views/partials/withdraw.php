
		<h1 class="title_text">Withdraw</h1>
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="row">
							<div class="col-md-3">
							<h4 class="black-text">Withdraw to a Bitcoin Address</h4>
								<form role="form">
									<div class="form-group">
										<label for="exampleInputEmail1">Bitcoin address</label>
										<input type="text" ng-model="withdraw_address" class="form-control"  placeholder="Bitcoin Address">
									</div>
									<div class="form-group">
										<label for="exampleInputPassword1">Amount</label>
										<input type="amount" class="form-control" ng-model="withdraw_amount" placeholder="Amount">
									</div>
									<button type="submit" ng-class="{disabled: demo_mode}" ng-click="requestWithdrawal()" class="btn btn-success pull-right">Submit</button>
								</form>
							</div>
							<div class="col-md-9">
								<h4 class="black-text">Withdrawal History</h4>


						 <table ng-table="tableParams" class="table table-bordered">
        <tr ng-repeat="wd in $data">
            <td data-title="'ID'">{{wd.id}}</td>
            <td data-title="'Date'">{{wd.updated_on}}</td>
            <td data-title="'Amount'">{{wd.value / 100000000 | number:8}}</td>
            <td data-title="'Tran Hash'">{{wd.transaction_hash}}</td>
            <td data-title="'Status'">{{wd.status}}</td>
        </tr>
        </table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
