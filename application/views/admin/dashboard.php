<div class="admin-page">
<h3 class="black_text">Dashboard</h3>
<div class="row">
  <div class="col-md-3">
    <div class="panel panel-info">
      <div class="panel-heading"><h4 class="text-center black-text">Wallet Balance</h4></div>
      <div class="panel-body">

        <p class="black-text text-center"><i class="fa fa-btc"></i>  {{adminData.balance / 100000000 | number:8}}</p>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="panel panel-info">
      <div class="panel-heading"><h4 class="text-center black-text">Total Wagered</h4></div>
      <div class="panel-body">

        <p class="black-text text-center"><i class="fa fa-btc"></i>  {{adminData.total_wagered / 100000000 | number:8}}</p>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="panel panel-info">
      <div class="panel-heading"><h4 class="text-center black-text">Total Won</h4></div>
      <div class="panel-body">

        <p class="black-text text-center"><i class="fa fa-btc"></i>  {{adminData.total_won / 100000000 | number:8}}</p>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="panel panel-info">
      <div class="panel-heading"><h4 class="text-center black-text">Profit</h4></div>
      <div class="panel-body">

        <p class="black-text text-center"><i class="fa fa-btc"></i>  {{(adminData.total_wagered - adminData.total_won) / 100000000 | number:8}}</p>
      </div>
    </div>
  </div>
</div>

<div class="row">
<div class="col-md-6">
<h4 class="black-text">Top Users</h4>
  <table ng-table="userTableParams" template-pagination="custom/pager" class="table table-bordered table-striped">
        <tr ng-repeat="user in $data">
            <td data-title="'ID'" sortable="'user.user_id * 1'"><a ui-sref="admin.user({user_id:user.user_id})">{{user.user_id}}</a></td>
          <td data-title="'Balance'" sortable="'available_balance / 1000000000'">{{user.available_balance / 100000000 |number:5}}</td>
          <td data-title="'Games'" sortable="'total_games * 1'">{{user.total_games}}</td>
          <td data-title="'Wagered'" sortable="'total_wagered / 100000000'">{{user.total_wagered / 100000000 |number:5}}</td>
          <td data-title="'Profit'" sortable="'(user.total_won - user.total_wagered) / 100000000'">{{(user.total_won - user.total_wagered) / 100000000 |number:5}}</td>
        </tr>
        </table>
</div>
<div class="col-md-6">
<h4 class="black-text">Recent Games</h4>
  <table ng-table="gameTableParams" template-pagination="custom/pager" class="table table-bordered table-striped">
        <tr ng-repeat="item in $data">
            <td data-title="'ID'"><a ui-sref="admin.game({id:item.id})">{{item.id}}</a></td>
            <td data-title="'Stake'">{{item.stake | number:8}}</td>
            <td data-title="'Profit'">{{item.profit | number:8}}</td>
        </tr>
        </table>
</div>
</div>
</div>