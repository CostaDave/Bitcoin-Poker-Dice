<div class="admin-page">
    <h3 class="black_text  no-top-or-bottom-marg">Withdrawals</h3>
    <div class="row">
        <div class="col-md-12">
            <tabset>
                <tab heading="Pending Withdrawals">
                    <div class="spacer20"></div>
                    <table ng-table="pendingTableParams" class="table table-bordered">
                        <tr ng-repeat="wd in $data">
                            <td data-title="''" class="text-center" header="'check_box'"><input type="checkbox" ng-model="checkboxes.items[wd.id]" /></td>
                            <td data-title="'ID'">{{wd.id}}</td>
                            <td data-title="'User ID'"><a ui-sref="admin.user({user_id:wd.user_id})">{{wd.user_id}}</a></td>
                            <td data-title="'Date'">{{wd.updated_on}}</td>
                            <td data-title="'Address'">{{wd.destination_address}}</td>
                            <td data-title="'Amount'">{{wd.value / 100000000 | number:8}}</td>
                            <td data-title="'Status'">{{wd.status}}</td>
                        </tr>
                    </table>
                    <a ng-class="{'disabled': pending_total < 1}" ng-click="processWithdrawals(checkboxes)" class="btn btn-success">Process Selected</a>
                    <a ng-class="{'disabled': pending_total < 1}" ng-click="cancelWithdrawals(checkboxes)" class="btn btn-danger">Cancel Selected</a>
                </tab>
                <tab heading="All Withdrawals">
                    <div class="spacer20"></div>
                    <table ng-table="allTableParams" class="table table-bordered">
                        <tr ng-repeat="wd in $data">
                            <td data-title="'ID'">{{wd.id}}</td>
                            <td data-title="'User ID'"><a ui-sref="admin.user({user_id:wd.user_id})">{{wd.user_id}}</a></td>
                            <td data-title="'Date'">{{wd.updated_on}}</td>
                            <td data-title="'Address'">{{wd.destination_address}}</td>
                            <td data-title="'Amount'">{{wd.value / 100000000 | number:8}}</td>
                            <td data-title="'Status'">{{wd.status}}</td>
                        </tr>
                    </table>
                </tab>
            </tabset>

        </div>
    </div>
</div>
<script type="text/ng-template" id="check_box">
    <input type="checkbox" ng-model="checkboxes.checked" id="select_all" name="filter-checkbox" value="" />
</script>