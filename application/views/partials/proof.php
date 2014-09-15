<div class="container">
<h1>Provably Fair</h1>
			<div class="panel panel-default" ng-controller="proofController">
				<div class="panel-heading">
					<h3 class="panel-title">Proof of Fairness - Game ID: <?=$game->id;?></h3>
				</div>
				<div class="panel-body">

					<tabset>
						
						<tab heading="Proof Script">
							<h3>This Game is Provably Fair</h3>
							<p class="black-text">This game can be proven to have been fair.  Below you will find the results of a script that verifies that the result is correct and that the initial array and seeds have not been tampered with since the game began.  Click on the "Details" link above to view the individual game details.</p>
							<?=$proof;?>
							<p class="black-text">If you would like to verify this for yourself (and you should), simply copy the code below into a PHP file and run it on your own computer.</p>
							<pre>
&lt;?php
$initial_array  = '<?=$game->initial_array;?>';

$final_array = '<?=$game->final_array;?>';

$server_seeds = '<?=$game->server_seeds;?>';

$client_seeds = '<?=$game->client_seeds;?>';

$hash = '<?=$game->hash;?>';

// create the secret array
$secret_array = array(
	'server_seeds' => $server_seeds,
	'initial_array' => $initial_array
);

// compute the hash again to see if it matches with the hash provided
$computed_hash = hash("sha256", json_encode($secret_array));

// turn the JSON into a PHP array
$initial_array = json_decode($initial_array, true);
$client_seeds = json_decode($client_seeds, true);
$final_array = json_decode($final_array, true);

// find the result_array by shuffling the initial array with the client provided seeds
for($i=1;$i<=3;$i++) {
	if(!empty($final_array['roll_'.$i])) {
		for($n=1;$n<=5;$n++) {
			if($client_seeds['roll_'.$i][$n] == 'held') {
				$field = $i-1;
				$result_array['roll_'.$i][$n] = $final_array['roll_'.$field][$n];
			} else {
				$result_array['roll_'.$i][$n] = seed_shuffle($initial_array['roll_'.$i][$n], $client_seeds['roll_'.$i][$n]);
			}
		}
	}
}

// find the last roll.  The game may have ended on 1, 2, or 3 rolls
if(!empty($final_array['roll_3'])) {
	$final_roll = 3;
} elseif(!empty($final_array['roll_2'])) {
	$final_roll = 2;
} else {
	$final_roll = 1;
} 


// find the result - It's the "0" element of each die
$result = array(
	$result_array['roll_'.$final_roll][1][0],
	$result_array['roll_'.$final_roll][2][0],
	$result_array['roll_'.$final_roll][3][0],
	$result_array['roll_'.$final_roll][4][0],
	$result_array['roll_'.$final_roll][5][0]
);

echo 'Result: '.implode(',',$result).'&lt;br /&gt;';
echo 'Hashes match: ';
echo $computed_hash == $hash ? 'true':'false';

function seed_shuffle( $items, $seed ) {
	if (is_numeric($seed)) {
		$seedval = $seed;
	} else {
		$seedval = crc32($seed);
	}

	srand($seedval);

	for ($i = count($items) - 1; $i > 0; $i--) {
		$j = @rand(0, $i);
		$tmp = $items[$i];
		$items[$i] = $items[$j];
		$items[$j] = $tmp;
	}

	return $items;
}
?&gt;
</pre>
						</tab>
						<tab heading="Details">
							<h3>Initial Array</h3>
							<pre><?php print_r($game->initial_array);?></pre>
							<h3>Server Seeds</h3>
							<pre><?=$game->server_seeds;?></pre>
							<h3>Hash</h3>
							<pre><?=$game->hash;?></pre>
							<h3>Client Seeds</h3>
							<pre><?=$game->client_seeds;?></pre>
							<h3>Final Array</h3>
							<pre><?=$game->final_array;?></pre>
						</tab>
					</tabset>
				</div>
				</div>
	