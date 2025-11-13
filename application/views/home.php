
<!DOCTYPE html>
<!--[if lt IE 7]>      <html lang="en" ng-app="bitcoinDice" class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html lang="en" ng-app="bitcoinDice" class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html lang="en" ng-app="bitcoinDice" class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en" ng-app="bitcoinDice" class="no-js"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="../../favicon.ico">

  <title update-title>ibetbtc</title>

  <!-- build:css app.min.css -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://unpkg.com/ng-table@0.8.3/dist/ng-table.min.css">
  <link rel="stylesheet" href="https://unpkg.com/ngprogress@1.1.3/ngProgress.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap.min.css">
  <link href="/assets/css/cards.css" rel="stylesheet">
  <link href="/assets/css/style.css" rel="stylesheet">
  <link href="/assets/css/home-page.css" rel="stylesheet">
  <link href="/assets/css/blackjack.css" rel="stylesheet">
  <link href="/assets/css/videopoker.css" rel="stylesheet">
  <link href="/assets/css/coming_soon.css" rel="stylesheet">
  <link href="/assets/css/pokerdice.css" rel="stylesheet">

  <!-- endbuild -->
  
  
  <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->


  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
    </head>

    <body ng-cloak ng-contoller="applicationController" update-body-class>

      <div class="navbar navbar-inverse navbar-fixed-top" role="navigation" ng-controller="navController">
        <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a href="#/" class="navbar-brand">{{config.site_name}}</a>
          </div>
          <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
              <li class="dropdown" on-toggle="toggled(open)">
                <a href class="dropdown-toggle">
                  {{lang.menu_games}} <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                  <li ng-repeat="choice in items">
                    <a ui-sref="{{choice.state}}">{{choice.text}}</a>
                  </li>
                </ul>
              </li>
              
              <li ui-sref-active="active"><a ui-sref="exchange">{{lang.menu_exchange}}</a></li>
              <li ui-sref-active="active"><a ui-sref="deposit">{{lang.menu_deposit}}</a></li>
              <li ui-sref-active="active"><a ui-sref="withdraw">{{lang.menu_withdraw}}</a></li> 
              <li ui-sref-active="active"><a ui-sref="affiliates">{{lang.menu_affiliates}}</a></li>
              
              <li ng-show="user.role == 'admin'" ui-sref-active="active"><a ui-sref="admin.dashboard">{{lang.menu_admin}}</a></li>              

            </ul>


            <ul class="nav navbar-nav navbar-right">
              <li><div class="nav-info-box pull-right text-center">Balance: <i class="fa fa-btc"></i> {{user.available_balance / 100000000 |number:8}}</div>
              </li>
              <li ng-controller="loginController" ng-show="user.has_password" ng-click="logout()"><a href="">{{lang.sign_out}}</a></li>
              <!-- <li><a ng-click="toggleMute()"><span ng-class="{'fa fa-volume-up': !sound_muted, 'fa fa-volume-off': sound_muted}"></span></a></li>
            --> <li class="dropdown" on-toggle="toggled(open)">
            <a href class="dropdown-toggle">
              <span class="glyphicon glyphicon-user"></span> 
              <strong>{{user.username}}</strong>
              <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
              <li>
                <div class="navbar-login">
                  <div class="row">
                    <div class="col-lg-4">
                      <p class="text-center">
                        <span class="glyphicon glyphicon-user icon-size"></span>
                      </p>
                    </div>
                    <div class="col-lg-8">
                      <p class="text-left"><strong>Nombre Apellido</strong></p>
                      <p class="text-left small">{{user.email}}</p>
                      <p class="text-left">
                        <a ui-sref="account.settings" class="btn btn-primary btn-block btn-sm">{{lang.menu_account}}</a>
                      </p>
                    </div>
                  </div>
                </div>
              </li>
              <li class="divider"></li>
              <li>
                <div class="navbar-login navbar-login-session">
                  <div class="row">
                    <div class="col-lg-12">
                      <p>
                        <a href="#" class="btn btn-danger btn-block">{{lang.sign_out}}</a>
                      </p>
                    </div>
                  </div>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>

    </div>
  </div>

  <div class="ui-view"></div>
  <div class="container">
    <hr>

    <!-- Footer -->
    <footer>
      <div class="row">
        <div class="col-lg-12">
          <p>Copyright &copy; Your Website 2014</p>
        </div>
      </div>
    </footer>

  </div>


  <!-- build:js app.min.js -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.6.2/modernizr.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.2.32/angular.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-router/0.2.18/angular-ui-router.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/0.11.0/ui-bootstrap-tpls.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/2.4.2/lodash.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/restangular/1.4.0/restangular.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.qrcode/1.0/jquery.qrcode.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/soundmanager2/2.97a.20170601/script/soundmanager2-nodebug-jsmin.js"></script>
  <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/plug-ins/1.10.25/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/gh/l-lin/angular-datatables@0.4.3/dist/angular-datatables.min.js"></script>
  <script src="https://unpkg.com/ng-table@0.8.3/dist/ng-table.min.js"></script>
  <script src="https://unpkg.com/ngprogress@1.1.3/build/ngprogress.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/async/0.9.2/async.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-backstretch/2.1.18/jquery.backstretch.min.js"></script>
  <script src="/assets/js/libs/jquery.jrumble.1.3.min.js"></script>

  <!-- App scripts -->
  <script src="/assets/js/app/services/blockUIMock.js?v=2"></script>
  <script src="/assets/js/app/app.js?v=2"></script>
  <script src="/assets/js/app/controllers.js"></script>
  <script src="/assets/js/app/controllers/applicationController.js"></script>
  <script src="/assets/js/app/controllers/navController.js"></script>
  <script src="/assets/js/app/controllers/payoutController.js"></script>
  <script src="/assets/js/app/controllers/withdrawController.js"></script>
  <script src="/assets/js/app/controllers/depositController.js"></script>
  <script src="/assets/js/app/controllers/affiliateController.js"></script>
  <script src="/assets/js/app/controllers/accountController.js"></script>
  <script src="/assets/js/app/controllers/tabController.js"></script>
  <script src="/assets/js/app/controllers/proofController.js"></script>
  <script src="/assets/js/app/controllers/ctrReadController.js"></script>
  <script src="/assets/js/app/controllers/allGamesController.js"></script>
  <script src="/assets/js/app/controllers/tranTableController.js"></script>
  <script src="/assets/js/app/controllers/loginController.js"></script>
  <script src="/assets/js/app/controllers/accountSettingsController.js"></script>
  <script src="/assets/js/app/controllers/modalInstanceController.js"></script>
  <script src="/assets/js/app/controllers/pokerController.js"></script>
  <script src="/assets/js/app/controllers/vpDataController.js"></script>
  <script src="/assets/js/app/controllers/pokerDiceController.js"></script>
  <script src="/assets/js/app/controllers/blackjackController.js"></script>
  <script src="/assets/js/app/controllers/rouletteController.js"></script>

  <script src="/assets/js/app/directives.js"></script>
  <script src="/assets/js/app/directives/qrCodeDirective.js"></script>
  <script src="/assets/js/app/directives/diceDirective.js"></script>
  <script src="/assets/js/app/directives/cardDirective.js"></script>
  <script src="/assets/js/app/directives/cardsDirective.js"></script>
  <script src="/assets/js/app/directives/customSortDirective.js"></script>
  <script src="/assets/js/app/directives/blackjackDirective.js"></script>
  <script src="/assets/js/app/directives/comingSoonDirective.js"></script>
  <script src="/assets/js/app/directives/updateTitleDirective.js"></script>
  <script src="/assets/js/app/directives/updateBodyClassDirective.js"></script>
  <script src="/assets/js/app/directives/gamesTableDirective.js"></script>
  <script src="/assets/js/app/directives/rouletteDirective.js"></script>
  <script src="/assets/js/app/directives/updateEmailDirective.js"></script>
  <script src="/assets/js/app/directives/updatePasswordDirective.js"></script>

  <script src="/assets/js/app/services.js"></script>
  <script src="/assets/js/app/services/authService.js"></script>
  <script src="/assets/js/app/services/apiService.js"></script>
  <script src="/assets/js/app/services/vpApiService.js"></script>
  <script src="/assets/js/app/services/pdApiService.js"></script>
  <script src="/assets/js/app/services/adminApiService.js"></script>


  <script src="/assets/js/app/controllers/adminController.js"></script>
  <script src="/assets/js/app/controllers/adminDashboardController.js"></script>
  <script src="/assets/js/app/controllers/adminWithdrawController.js"></script>
  <script src="/assets/js/app/controllers/adminGamesController.js"></script>
  <script src="/assets/js/app/controllers/adminGameController.js"></script>
  <script src="/assets/js/app/controllers/adminUsersController.js"></script>
  <script src="/assets/js/app/controllers/adminUserController.js"></script>

  <script src="/assets/js/app/filters.js"></script>

  <!-- endbuild -->
  <script src="<?=site_url('js/index');?>"></script>


  <?php foreach($templates as $template):?>
    <script type="text/ng-template" id="<?=$template;?>Template">
      <?php $this->load->view('templates/'.$template);?>
    </script>
  <?php endforeach;?>

  <script type="text/ng-template" id="dieTemplate">
   <div class="equal-box">
    <div class="card after-card {{size}} rank-{{diceValue}} hearts">

    </div>
  </div>
</script>
<script type="text/ng-template" id="blackjackTemplate">
  <div>
    <div class="playingCards faceImages row">
      <ul class="hand">
        <li><span class="card rank-a clubs">
          <span class="rank">A</span>
          <span class="suit">&clubs;</span>
        </span></li>
        <li><span class="card rank-a clubs">
          <span class="rank">A</span>
          <span class="suit">&clubs;</span>
        </span></li>
      </ul>
    </div>
  </script>
  <script type="text/ng-template" id="cardsTemplate">
    <div>
      <div class="playingCards faceImages row">
        <div block-ui="all_cards"></div>
        <div class="col-md-2 col-sm-2 col-xs-2 col-lg-2 col-md-offset-1 col-sm-offset-1 sol-xm-offset-1 col-lg-offset-1 cardcol">
          <div block-ui="card_1"></div>
          <a id="card_1" class="card back" ng-click="toggleHold(1)">
            <span class="rank">Q</span>
            <span class="suit">&hearts;</span>
          </a>
        </div>
        <div class="col-md-2 col-sm-2 col-xs-2 col-lg-2 cardcol">
          <div  block-ui="card_2"></div>
          <a id="card_2" class="card back" ng-click="toggleHold(2)">
            <span class="rank">Q</span>
            <span class="suit">&hearts;</span>
          </a>
        </div>
        <div class="col-md-2 col-sm-2 col-xs-2 col-lg-2 cardcol">
          <div  block-ui="card_3"></div>
          <a id="card_3" class="card back" ng-click="toggleHold(3)">
            <span class="rank">Q</span>
            <span class="suit">&hearts;</span>
          </a>
        </div>
        <div class="col-md-2 col-sm-2 col-xs-2 col-lg-2 cardcol">
          <div  block-ui="card_4"></div>
          <a id="card_4" class="card back" ng-click="toggleHold(4)">
            <span class="rank">Q</span>
            <span class="suit">&hearts;</span>
          </a>
        </div>
        <div class="col-md-2 col-sm-2 col-xs-2 col-lg-2 cardcol">
          <div  block-ui="card_5"></div>
          <a id="card_5" class="card back" ng-click="toggleHold(5)">
            <span class="rank">Q</span>
            <span class="suit">&hearts;</span>
          </a>
        </div>

      </div>
      <div class="row">
        <div class="col-md-2 col-sm-2 col-xs-2 col-lg-2 col-md-offset-1 col-sm-offset-1 sol-xm-offset-1 col-lg-offset-1">
          <a class="btn btn-info btn-block text-center" ng-class="{'disabled':all_disabled}" ng-click="toggleHold(1)">HOLD</a>
        </div>
        <div class="col-md-2 col-sm-2 col-xs-2 col-lg-2">
          <a class="btn btn-info btn-block text-center" ng-class="{'disabled':all_disabled}" ng-click="toggleHold(2)">HOLD</a>
        </div>
        <div class="col-md-2 col-sm-2 col-xs-2 col-lg-2">
          <a class="btn btn-info btn-block text-center" ng-class="{'disabled':all_disabled}" ng-click="toggleHold(3)">HOLD</a>
        </div>
        <div class="col-md-2 col-sm-2 col-xs-2 col-lg-2">
          <a class="btn btn-info btn-block text-center" ng-class="{'disabled':all_disabled}" ng-click="toggleHold(4)">HOLD</a>
        </div>
        <div class="col-md-2 col-sm-2 col-xs-2 col-lg-2">
          <a class="btn btn-info btn-block text-center" ng-class="{'disabled':all_disabled}" ng-click="toggleHold(5)">HOLD</a>
        </div>
      </div>
    </div>
  </script>
  <script type="text/ng-template" id="diceTemplate">
    <div class="dice-container2 text-center">
      <div id="dice_1" class="dice dice-a" ng-click="toggleHold(1)"></div>
      <div id="dice_2" class="dice dice-a" ng-click="toggleHold(2)"></div>
      <div id="dice_3" class="dice dice-a" ng-click="toggleHold(3)"></div>
      <div id="dice_4" class="dice dice-a" ng-click="toggleHold(4)"></div>
      <div id="dice_5" class="dice dice-a" ng-click="toggleHold(5)"></div> 
    </div>

  </script>
  <script type="text/ng-template" id="seedModalTemplate">
    <div class="modal-header">
      <h3 class="modal-title">Set Client Seeds</h3>
    </div>
    <div class="modal-body">
      <h5>Dice 1</h5>
      <input ng-model="seeds.seed_1" />
      <h5>Dice 2</h5>
      <input ng-model="seeds.seed_2" />
      <h5>Dice 3</h5>
      <input ng-model="seeds.seed_3" />
      <h5>Dice 4</h5>
      <input ng-model="seeds.seed_4" />
      <h5>Dice 5</h5>
      <input ng-model="seeds.seed_5" />
    </div>
    <div class="modal-footer">
      <button class="btn btn-primary" ng-click="ok()">OK</button>
    </div>
  </script>
  <script type="text/ng-template" id="custom/pager">
    <ul class="pager ng-cloak">
      <li ng-repeat="page in pages"
      ng-class="{'disabled': !page.active, 'previous': page.type == 'prev', 'next': page.type == 'next'}"
      ng-show="page.type == 'prev' || page.type == 'next'" ng-switch="page.type">
      <a ng-switch-when="prev" ng-click="params.page(page.number)" href="">&laquo; Previous</a>
      <a ng-switch-when="next" ng-click="params.page(page.number)" href="">Next &raquo;</a>
    </li>
    <li> 
      <div class="btn-group">
        <button type="button" ng-class="{'active':params.count() == 10}" ng-click="params.count(10)" class="btn btn-default">10</button>
        <button type="button" ng-class="{'active':params.count() == 25}" ng-click="params.count(25)" class="btn btn-default">25</button>
        <button type="button" ng-class="{'active':params.count() == 50}" ng-click="params.count(50)" class="btn btn-default">50</button>
        <button type="button" ng-class="{'active':params.count() == 100}" ng-click="params.count(100)" class="btn btn-default">100</button>
      </div>
    </li>
  </ul>
</script>
<script type="text/ng-template" id="qrModalTemplate">
  <div class="modal-header">
    <h3 class="modal-title">Make a Deposit</h3>
  </div>
  <div class="modal-body text-center">
    <div class="panel panel-default">
      <div class="spacer30"></div>
      <address-qr-code data-address="user.address"></address-qr-code>
      <h3 class="black-text">{{user.address}}</h3>
    </div>
  </div>
  <div class="modal-footer">
    <button class="btn btn-primary" ng-click="ok()">OK</button>
  </div>
</script>
<script type="text/ng-template" id="processWithdrawalsTemplate">
  <div class="modal-header">
    <h3 class="modal-title">Process Withdrawals</h3>
  </div>
  <div class="modal-body text-center">
    <h4>Are you sure you want to process {{withdrawal_count}} withdrawals for BTC {{withdrawal_sum / 100000000 |number:8}}?</h4>
  </div>
  <div class="modal-footer">
    <button class="btn btn-primary" ng-click="processPending()">OK</button>
  </div>
</script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-53576991-1', 'auto');
  ga('send', 'pageview');

</script>



</body>
</html>
