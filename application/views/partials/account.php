<div class="container">
	<h1>{{pageLang.title}}</h1>
	<div class="panel with-nav-tabs panel-default">
		<div class="panel-heading">
			<ul class="nav nav-tabs">
				<li ui-sref-active="active"><a ui-sref="account.settings">{{pageLang.settings}}</a></li>
				<li ui-sref-active="active"><a ui-sref="account.security">{{pageLang.security}}</a></li>
				<!-- <li class="dropdown">
					<a href="#" data-toggle="dropdown">Dropdown <span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
						<li><a href="#tab4default" data-toggle="tab">Default 4</a></li>
						<li><a href="#tab5default" data-toggle="tab">Default 5</a></li>
					</ul>
				</li> -->
			</ul>
		</span>
	</div>
	<div class="panel-body">
		<div class="tab-content">
			<div class="tab-pane fade in active">	
				<div ui-view></div>
			</div>
		</div>
	</div>
</div>
</div>