<form role="form" ng-submit="setPassword(pass)" class="form-horizontal">
<fieldset>

<!-- Form Name -->
<legend>{{lang.set_password}}</legend>

<!-- Password input-->
<div class="form-group" ng-show="user.has_password">
  <label class="col-md-4 control-label" for="passwordinput">{{lang.current_password}}</label>
  <div class="col-md-4">
    <input ng-model="pass.current_password" type="password" placeholder="{{lang.current_password}}" class="form-control input-md">
  </div>
</div>

<!-- Password input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="passwordinput">{{lang.new_password}}</label>
  <div class="col-md-4">
    <input ng-model="pass.password" type="password" placeholder="{{lang.new_password}}" class="form-control input-md">
  </div>
</div>

<!-- Password input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="passwordinput">{{lang.confirm_password}}</label>
  <div class="col-md-4">
    <input ng-model="pass.password_confirm" type="password" placeholder="placeholder" class="form-control input-md">
  </div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label" for="singlebutton"></label>
  <div class="col-md-4">
    <button id="singlebutton" name="singlebutton" class="btn btn-primary">{{lang.set_password}}</button>
  </div>
</div>
</fieldset>
				<!-- <div ng-show="user.has_password" class="form-group">
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
				<button type="submit" class="btn btn-info pull-right" >Submit</button> -->
			</form>
		</div>