<div class="row">
  <h1 class="title_text">Admin</h1>
  <div class="panel panel-default">
    <div class="panel-heading">
    <div class="panel-body">
      <div class="col-sm-3">
      <div class="panel panel-success">
      <div class="panel-heading">Admin Menu</div>
      <div class="panel-body">
      <ul class="nav nav-pills nav-stacked">
        <li ui-sref-active="active"><a ui-sref="admin.dashboard">Dashboard</a></li>
        <li ui-sref-active="active"><a ui-sref="admin.users">Users</a></li>
        <li ui-sref-active="active"><a ui-sref="admin.games">Games</a></li>
        <li ui-sref-active="active"><a ui-sref="admin.withdrawals">Withdrawals  <span ng-show="adminData.pending_withdrawal_amount > 0" class="badge pull-right">{{adminData.pending_withdrawal_amount / 100000000 |number:8}}</span></a></li>
      </ul>
      </div>
      </div>
    </div>
    <div class="col-sm-9">
      <div ui-view></div>
    </div>
    </div>
  </div>
</div>
</div>