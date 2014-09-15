<div class="playingCards faceImages">
	<ul class="hand">
	<li ng-repeat="card in cards" class="card rank-{{card.rank | lowercase}} {{card.suit}}">
			<span class="rank">{{card.rank}}</span>
			<span class="suit">♠</span>
		</li>
	</ul>
</div>