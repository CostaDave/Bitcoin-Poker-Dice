<div class="admin-page">
<h3 class="black_text  no-top-or-bottom-marg">Withdrawals</h3>
<div class="row">
<div class="col-md-12">
{{checkboxes.items}}
  <table ng-table="tableParams" class="table table-bordered">
        <tr ng-repeat="wd in $data">
            <td data-title="''" class="text-center" header="'check_box'"><input type="checkbox" ng-model="checkboxes.items[wd.id]" /></td>
            <td data-title="'ID'">{{wd.id}}</td>
            <td data-title="'User ID'"><a ui-sref="admin.user({user_id:wd.user_id})">{{wd.user_id}}</a></td>
            <td data-title="'Date'">{{wd.updated_on}}</td>
            <td data-title="'Amount'">{{wd.value / 100000000 | number:8}}</td>
            <td data-title="'Status'">{{wd.status}}</td>
        </tr>
        </table>
</div>
</div>
</div>
<script type="text/ng-template" id="check_box">
    <input type="checkbox" ng-model="checkboxes.checked" id="select_all" name="filter-checkbox" value="" />
</script>