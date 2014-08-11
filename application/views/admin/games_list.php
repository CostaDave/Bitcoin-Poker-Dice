<div class="admin-page">
<h3 class="black_text  no-top-or-bottom-marg">All Games</h3>
<hr />
  <div class="row">
    <div class="col-md-12">
      <table ng-table="tableParams" template-pagination="custom/pager" class="table table-bordered table-striped">
        <tr ng-repeat="game in $data">
          <td data-title="'ID'" sortable="'id * 1'"><a ui-sref="admin.game({id:game.id})">{{game.id}}</a></td>
          <td data-title="'User ID'" sortable="'user_id'"><a ui-sref="admin.user({user_id:game.user_id})">{{game.user_id}}</a></td>
          <td data-title="'Date'" sortable="'updated_on'">{{game.updated_on}}</td>
          <td data-title="'Stake'" sortable="'stake'">{{game.stake|number:8}}</td>
          <td data-title="'Profit'" sortable="'profit'">{{game.profit|number:8}}</td>
          <td data-title="'Winning Hand'" sortable="'winning_hand'">{{game.winning_hand}}</td>
          <td data-title="'Rolls'" sortable="'rolls'">{{3 - game.rolls_remaining}}</td>
          <td data-title="'Proof'"><a class="btn btn-success" ui-sref="proof({game_id:game.id})">Show Proof</a></td>
        </tr>
      </table>
    </div>
  </div>
</div>