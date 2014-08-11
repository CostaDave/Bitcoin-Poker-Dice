<div class="account-settings" ng-controller="accountSettingsController">
	<h4 class="black-text" ng-show="!user.has_password">Password Protection</h4>
	<h4 class="black-text" ng-show="user.has_password">Change Password</h4>
	<p class="black-text" ng-show="!user.has_password">A password is not required for your account, but it will protect your account in the event that you someone learns your unique site URL.</p>
	<div class="row">
		<div class="col-md-4">
			<form role="form" ng-submit="setPassword(pass)">
				<div ng-show="user.has_password" class="form-group">
				<label for="password">Current Password</label>
					<input type="password" class="form-control" id="password" ng-model="pass.current_password" placeholder="Current Password" required>
				</div>
				<div class="form-group">
				<label for="password">Password</label>
					<input type="password" class="form-control" id="password" ng-model="pass.password" placeholder="New Password" required>
				</div>
				<div class="form-group">
					<label for="password_confirm">Confirm Password</label>
					<input type="password" class="form-control" id="password_confirm" ng-model="pass.password_confirm" placeholder="Confirm Password" required>
				</div>
				<button type="submit" class="btn btn-info pull-right" >Submit</button>
			</form>
		</div>
		<div class="col-md-8">
			<div ng-show="password_errors != null" class="alert alert-danger">
				{{password_errors}}
			</div>
		</div>
	</div>
	
</div>