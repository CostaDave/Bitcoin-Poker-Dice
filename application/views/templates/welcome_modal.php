
<div class="modal-header">
<h3 class="modal-title">{{lang.pages.home.welcome_title}}</h3>
</div>
<div class="modal-body">
	<p>{{lang.pages.home.welcome_desc}}</p>
	<p>{{lang.pages.home.welcome_url}}</p>
	<div class="text-center"><code>{{config.site_url}}/u/{{user.guid}}</code></div>
	<div class="spacer10"></div>
	<update-password-directive current="user.has_password"></update-password-directive>
</div>
<div class="modal-footer">
	<button class="btn btn-primary" ng-click="ok()">OK</button>
</div>