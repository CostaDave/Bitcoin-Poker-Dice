<form class="form-horizontal" ng-submit="updateUserSettings(settings)">
<fieldset>

<!-- Form Name -->
<legend>{{lang.pages.account.account_settings}}</legend>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">{{lang.username}}</label>  
  <div class="col-md-4">
  <input ng-model="settings.username" class="form-control input-md">
  <span class="help-block">{{lang.username_help}}</span>  
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">{{lang.email_address}}</label>  
  <div class="col-md-4">
  <input ng-model="settings.email" class="form-control input-md">
  <span class="help-block">{{lang.email_address_help}}</span>  
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="selectbasic">{{lane.timezone}}</label>
  <div class="col-md-4">
    <select ng-model="settings.timezone" ng-options="tz.zone for tz in timezones" class="form-control">
    	<option value="">{{lang.choose_timezone}}</option>
    </select>
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="singlebutton">{{lang.save}}</label>
  <div class="col-md-4">
    <button id="singlebutton" name="singlebutton" class="btn btn-primary">{{lang.save}}</button>
  </div>
</div>

</fieldset>
</form>
