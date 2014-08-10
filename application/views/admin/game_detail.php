<div class="admin-page">
  <h3 class="black_text no-top-or-bottom-marg">Game Details</h3>
  <hr>
        <p><a ui-sref="admin.games">Back to Games</a></p>
  <div class="row">

    <div class="col-md-12">
      <div class="panel panel-info">
        <div class="panel-heading">Game Details</div>
        <table class="table">
         <tr>
            <td><h5 class="black-text no-top-or-bottom-marg">Game ID</h5></td>
            <td>{{game.id}}</td>
          </tr>
          <tr>
            <td><h5 class="black-text no-top-or-bottom-marg">Date</h5></td>
            <td>{{game.updated_on}}</td>
          </tr>
           <tr>
            <td><h5 class="black-text no-top-or-bottom-marg">User ID</h5></td>
            <td><a ui-sref="admin.user({user_id:game.user_id})">{{game.user_id}}</a></td>
          </tr>
           <tr>
            <td><h5 class="black-text no-top-or-bottom-marg">Stake</h5></td>
            <td><i class="fa fa-btc"></i> {{game.stake / 100000000 | number:8}}</td>
          </tr>
           <tr>
            <td><h5 class="black-text no-top-or-bottom-marg">Winning Hand</h5></td>
            <td>{{game.winning_hand}}</td>
          </tr>
          <tr>
            <td><h5 class="black-text no-top-or-bottom-marg">Rolls</h5></td>
            <td>{{3 - game.rolls_remaining}}</td>
          </tr>
           <tr>
            <td><h5 class="black-text no-top-or-bottom-marg">Profit</h5></td>
            <td><i class="fa fa-btc"></i> {{game.profit / 100000000 | number:8}}</td>
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
    </div>
  </div>
</div>