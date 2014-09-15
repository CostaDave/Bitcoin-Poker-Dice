<div class="container">
		<h1>Affiliates</h1>
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-body">
					<div class="alert alert-info">
						Your personal affiliate link: <br />
						<?=site_url();?>?aff={{user.affiliate_id}}
					</div>
					<p class="black-text"><strong>Affiliate Earnings: <i class="fa fa-btc"></i> {{user.affiliate_earnings / 100000000 | number:8}}</strong></p>
					<p class="black-text">Use the link above to promote Bitcoin Poker Dice and earn {{config.affiliate_percent * 100}}% of our profits for any user that plays after following your link. At the end of every game, we will deposit your commissions into your account.</p>
					</div>
				</div>
			</div>

		</div>
</div>