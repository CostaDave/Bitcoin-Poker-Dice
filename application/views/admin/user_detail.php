<div class="admin-page">
  <h3 class="black_text no-top-or-bottom-marg">User Details</h3>
  <hr>
        <p><a ui-sref="admin.dashboard">Back to Dashboard</a></p>
  <div class="row">

    <div class="col-md-12">
      <div class="panel panel-info">
        <div class="panel-heading">User Details</div>
        <table class="table">
         <tr>
            <td><h5 class="black-text no-top-or-bottom-marg">User ID</h5></td>
            <td>{{user.user_id}}</td>
          </tr>
           <tr>
            <td><h5 class="black-text no-top-or-bottom-marg">User GUID</h5></td>
            <td>{{user.guid}}</td>
          </tr>
           <tr>
            <td><h5 class="black-text no-top-or-bottom-marg">Deposit Address</h5></td>
            <td>{{user.address}}</td>
          </tr>
           <tr>
            <td><h5 class="black-text no-top-or-bottom-marg">Password Protected</h5></td>
            <td ng-show="user.has_password == '1'">Yes <a ng-click="resetPasswordModal()" class="btn btn-xs btn-info">Reset Password</a></td>
            <td ng-show="user.has_password == '0'">No</td>
          </tr>
           <tr>
            <td><h5 class="black-text no-top-or-bottom-marg">Games Played</h5></td>
            <td>{{user.total_games}}</td>
          </tr>
          <tr>
            <td><h5 class="black-text no-top-or-bottom-marg">Deposits</h5></td>
            <td><i class="fa fa-btc"></i> {{user.total_deposited / 100000000 | number:8}}</td>
          </tr>
          <tr>
            <td><h5 class="black-text no-top-or-bottom-marg">Withdrawals</h5></td>
            <td><i class="fa fa-btc"></i> {{user.total_withdrawn / 100000000 | number:8}}</td>
          </tr>
          <tr>
            <td><h5 class="black-text no-top-or-bottom-marg">Wagered</h5></td>
            <td><i class="fa fa-btc"></i> {{user.total_wagered / 100000000 | number:8}}</td>
          </tr>
          <tr>
            <td><h5 class="black-text no-top-or-bottom-marg">Won</h5></td>
            <td><i class="fa fa-btc"></i> {{user.total_profit / 100000000 | number:8}}</td>
          </tr>
          <tr>
            <td><h5 class="black-text no-top-or-bottom-marg">Profit</h5></td>
            <td><i class="fa fa-btc"></i> {{(user.total_profit - user.total_wagered) / 100000000 | number:8}}</td>
          </tr>
          <tr>
            <td><h5 class="black-text no-top-or-bottom-marg">Available Balance</h5></td>
            <td><i class="fa fa-btc"></i> {{user.available_balance / 100000000 | number:8}}</td>
          </tr>
        </table>
        <!-- <div class="panel-body">
          <h5>Available Balance</h5>
          <p class="black-text"><i class="fa fa-btc"></i> {{user.available_balance / 100000000 | number:8}}</p>
          <h5>Total Wagered</h5>
          <p class="black-text"><i class="fa fa-btc"></i> {{user.total_wagered / 100000000 | number:8}}</p>
          <h5>Total Profit</h5>
          <p class="black-text"><i class="fa fa-btc"></i> {{user.total_profit / 100000000 | number:8}}</p>
        </div> -->
      </div>
      <h4 class="black-text">User Games</h4>
      <table ng-table="tableParams" class="table table-bordered table-striped">
        <tr ng-repeat="game in $data">
          <td data-title="'ID'" sortable="'id * 1'"><a ui-sref="admin.game({id:game.id})">{{game.id}}</a></td>
          <td data-title="'User ID'" sortable="'user_id'"><a ui-sref="admin.user({user_id:game.user_id})">{{game.user_id}}</a></td>
          <td data-title="'Date'" sortable="'updated_on'">{{game.updated_on}}</td>
          <td data-title="'Stake'" sortable="'stake'">{{game.stake|number:8}}</td>
          <td data-title="'Profit'" sortable="'profit'">{{game.profit|number:8}}</td>
          <td data-title="'Winning Hand'" sortable="'winning_hand'">{{game.winning_hand}}</td>
          <td data-title="'Rolls'" sortable="'rolls'">{{3 - game.rolls_remaining}}</td>
          <td data-title="'Proof'"><a ui-sref="proof({game_id:game.id})">Show Proof</a></td>
        </tr>
      </table>
    </div>
  </div>
</div>