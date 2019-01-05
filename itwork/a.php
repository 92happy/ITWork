<?php

/*
	function squares($start,$stop){
		if($start < $stop){
			for ($i = $start ; $i <= $stop ; $i++){
				//echo $i.'<br>';
				yield $i => $i * $i ;
			}
		} else {
			for ($i = $start ; $i >= $stop ; $i--){
				//echo $i.'<br>';
				yield $i => $i * $i ;
			}
		}
	}


	foreach (squares (1,10) as $n => $squares){
		printf("%d squares is %d/n",$n,$squres);
	}
*/
echo PHP_VERSION;
echo '<br>=======================<br>';

	$lower = 1;
	$upper = 1000;
	echo $random_number = mt_rand( $lower,$upper);
echo '<br>=======================<br>';

	function pick_color(){
		$colors = array('red','orange','yellow','blue','green','indigo','violet');
		$i = mt_rand(0,count($colors) - 1);
		return $colors[$i];
	}
	mt_srand(1234);
	$first = pick_color();
	$second = pick_color();
	print "$first is red and $second is yellow.";




	echo '<br>';
	print date('r');
	echo '<br>';
	$when = new DateTime();
	print $when->format('d/m/y');

	echo '<br>';
	print "Today is day ".date('d'). ' of the month and '.date('z').' of the year.' ;



	echo '<br>';

	$start = microtime(true);
	for ($i = 1; $i < 1000 ; $i++) {
		preg_match('/age=\d{1,5}/',$_SERVER['QUERY_STRING']);
	}
	$end = microtime(true);
	echo $elapsed = $end - $start;

	echo '<br>';


	$fruits = ['Apple','Bananas','Cantaloupes','Dates'];
	echo $fruits[0].'<br>';
	echo $fruits[1].'<br>';
	echo '<br>';
	echo '<br>';
?>