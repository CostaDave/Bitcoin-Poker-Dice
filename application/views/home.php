
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

  <title>Bitcoin Poker Dice</title>

  <!-- build:css app.min.css -->
  <link href="/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="/bower_components/font-awesome/css/font-awesome.css" rel="stylesheet">
  <link href="/bower_components/ng-table/ng-table.css" rel="stylesheet">
  <link href="/bower_components/ngprogress/ngProgress.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="/bower_components/Plugins/integration/bootstrap/3/dataTables.bootstrap.css" media="screen" />
  <link href="/assets/css/style.css" rel="stylesheet">

  <!-- endbuild -->
  <script src="/bower_components/html5-boilerplate/js/vendor/modernizr-2.6.2.min.js"></script>
  <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->


  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
    </head>

    <body ng-cloak ng-contoller="applicationController">

      <div class="navbar navbar-inverse navbar-fixed-top" role="navigation" ng-controller="navController">
        <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a href="#/" class="navbar-brand visible-sm visible-xs">{{config.site_name}}</a>
          </div>
          <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
              <li ui-sref-active="active"><a ui-sref="home">{{lang.menu_home}}</a></li>
              <li ui-sref-active="active" class="visible-xs visible-sm"><a ui-sref="payouts">{{lang.menu_payouts}}</a></li>
              <li ui-sref-active="active"><a ui-sref="deposit">{{lang.menu_deposit}}</a></li>
              <li ui-sref-active="active"><a ui-sref="withdraw">{{lang.menu_withdraw}}</a></li> 
              <li ui-sref-active="active"><a ui-sref="affiliates">{{lang.menu_affiliates}}</a></li>
              <li ui-sref-active="active"><a ui-sref="account">{{lang.menu_account}}</a></li> 
              <li ng-show="user.role == 'admin'" ui-sref-active="active"><a ui-sref="admin.dashboard">{{lang.menu_admin}}</a></li>              
            </ul>
            <ul class="nav navbar-nav navbar-right">
              <li ng-controller="loginController" ng-show="user.has_password" ng-click="logout()"><a href="">Sign Out</a></li>
              <li><a ng-click="toggleMute()"><span ng-class="{'fa fa-volume-up': !sound_muted, 'fa fa-volume-off': sound_muted}"></span></a></li>
            </ul>
          </div><!--/.nav-collapse -->

        </div>
      </div>

      <div class="container">
       <div class="ui-view"></div>
       <!--  <div class="ng-view" autoscroll="true"></div> -->
      </div><!-- /.container -->

</script>
     <!-- build:js app.min.js -->
      <script src="/bower_components/jquery/dist/jquery.min.js"></script>
      <script src="/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
      <script src="/bower_components/angular/angular.min.js"></script>
     <!-- <script src="/bower_components/angular-route/angular-route.js"></script>-->
      <script src="/bower_components/angular-ui-router/release/angular-ui-router.js"></script>
      <script src="/bower_components/angular-bootstrap/ui-bootstrap-tpls.min.js"></script>
      <script src="/bower_components/lodash/dist/lodash.min.js"></script>
      <script src="/bower_components/restangular/dist/restangular.min.js"></script>
      <script src="/bower_components/jquery.qrcode/dist/jquery.qrcode.min.js"></script>
      <script src="/bower_components/soundmanager2/script/soundmanager2-nodebug-jsmin.js"></script>
      <script src="/bower_components/datatables/media/js/jquery.dataTables.js"></script>
      <script src="/bower_components/angular-datatables/dist/angular-datatables.min.js"></script>
      <script src="/bower_components/ng-table/ng-table.js"></script>
      <script src="/bower_components/ngprogress/build/ngProgress.js"></script>
      <script src="/assets/js/libs/jquery.jrumble.1.3.min.js"></script>
      <script src="/assets/js/app/app.js"></script>
      <script src="/assets/js/app/controllers.js"></script>
      <script src="/assets/js/app/directives.js"></script>
      <script src="/assets/js/app/filters.js"></script>
      <script src="/assets/js/app/services.js"></script>
      <!-- endbuild -->
      <script src="<?=site_url('js/index');?>"></script>

 <script type="text/ng-template" id="dieTemplate">
 <div class="equal-box">
  <div class="card after-card {{size}} rank-{{diceValue}} hearts">

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
