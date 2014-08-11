<div class="admin-page">
<h3 class="black_text  no-top-or-bottom-marg">All Users</h3>
<hr />
  <div class="row">
    <div class="col-md-12">
      <table ng-table="tableParams" class="table table-bordered table-striped">
        <tr ng-repeat="user in $data">
          <td data-title="'ID'" sortable="'user_id * 1'"><a ui-sref="admin.user({user_id:user.user_id})">{{user.user_id}}</a></td>
          <td data-title="'GUID'" sortable="'guid'" filter="{ 'guid.toString()': 'text' }">{{user.guid}}</td>
          <td data-title="'Balance'" sortable="'available_balance / 1000000000'">{{user.available_balance / 100000000 |number:8}}</td>
          <td data-title="'Games'" sortable="'total_games * 1'">{{user.total_games}}</td>
          <td data-title="'Wagered'" sortable="'total_wagered / 100000000'">{{user.total_wagered / 100000000 |number:8}}</td>
          <td data-title="'Won'" sortable="'total_won / 100000000'">{{user.total_won / 100000000 |number:8}}</td>
          <td data-title="'Profit'" sortable="'(user.total_won - user.total_wagered) / 100000000'">{{(user.total_won - user.total_wagered) / 100000000 |number:8}}</td>
        </tr>
      </table>
    </div>
  </div>
</div>