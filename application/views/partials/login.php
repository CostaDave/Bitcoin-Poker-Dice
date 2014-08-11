<h1 class="title_text">Sign In</h1>
<div class="row" ng-controller="loginController">
<div class="col-md-4 col-md-offset-4">
<div ng-show="login_errors != null" class="alert alert-danger">
  {{login_errors}}
</div>
    <div class="panel panel-default">
    <div class="panel-body">
    <div class="row">
      <div class="col-md-10 col-md-offset-1" >
        <form class="form-signin" role="form" ng-submit="login(credentials)">
        <h4 class="form-signin-heading black-text">Please Sign In</h4>
        <input type="password" class="form-control" placeholder="Password" ng-model="credentials.password" required>
        <!-- <div class="spacer10"></div>
        <input type="text" class="form-control" placeholder="One Time Password (Optional)" ng-model="credentials.one_time_pass"> -->
        <hr>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      </form>
      </div>
    </div>
      </div>
    </div>
  </div>
</div>