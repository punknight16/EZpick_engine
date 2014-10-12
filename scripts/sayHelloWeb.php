<?php

	$budget = $_REQUEST['budget'];
	$duration = $_REQUEST['duration'];
	$json_in = $_REQUEST['json'];


	function checkNumPackages($bud, $dur) {
		//true means 2 packages, false means 1 package
		$twopac = false;
  			if($bud > 50 && $dur > 2){
  				$twopac = true;
  			}
  		return $twopac;
	}

	function twoPackages($p_arr, $b){
  		$package_arr = array();
  		$first_random_package = pickFirst($p_arr, $b);
  		
  		$package_arr[0] = $first_random_package;
  		//print("awesome");
  		//print($p_arr[$first_random_package]);
  		//print("<br />");
  		$new_budget = $b-$p_arr[$first_random_package];
  		print("b:". $b . "v new budget" . $new_budget);
  		unset($p_arr[$first_random_package]);
  		//$new_budget = $budget - $output['package'][$first_random_package]['price'];
  		$last_random_package = pickLast($p_arr, $new_budget);
  		$package_arr[1] = $last_random_package;
  		return $package_arr;
	}

	function pickLast($trunc_sorted_price_arr, $budg){
		$retrunc_sorted_price_arr = array();
		//truncate to get only prices near budget
		foreach ($trunc_sorted_price_arr as $key => $value){
			if($budg>=$value && $value >= (.7 * $budg)){
				$retrunc_sorted_price_arr[$key] = $value;
			}
		}
		//pick random from trunc 100%-70% price list
		$second_package = array_rand($retrunc_sorted_price_arr);
		//if can't find near budget truncate to find any price below budget
		if($second_package == null){

			foreach ($trunc_sorted_price_arr as $key => $value){
				if($budg>=$value){
					$retrunc_sorted_price_arr[$key] = $value;
				}
			}
			//pick random from trunc price list
			$second_package = array_rand($retrunc_sorted_price_arr);	
		}
		//print("test: " . $second_package);
		return $second_package;
	}

	function pickFirst($sorted_price_arr, $budge){
		$truncate_sorted_price_arr = array();
		//truncate sorted price array
			foreach ($sorted_price_arr as $key => $value){
				if($budge>=$value){
					$truncate_sorted_price_arr[$key] = $value;
				}
			}
			//random value from truncated and sorted price array
			$first_package = array_rand($truncate_sorted_price_arr);
			return $first_package;
	}

	function getPackages($numpacks, $json_file, $budget){
		$json = json_decode($json_file);
	}
?>

<html>
	<head>
	</head>

	<body>
		<div id="header"><h1>Data Out</h1></div>
		<div id="content">
			<h1><?php 

			//inputs

			/*printf($budget);
			printf("<br />");
			printf($duration);
			printf("<br />");
			printf($json_in);*/

			/*
			$numpacks = twoPackages($budget, $duration);
			if($numpacks == false){
				echo "hello";
			}*/

			$output = json_decode($json_in, true);
			print_r($output['package'][1]['price']);
			echo "<br />";
			$pkg_file_length = count($output['package']);
			echo $pkg_file_length;
			echo "<br />";

			//extract prices
			for ($i = 0; $i < $pkg_file_length; $i++) {
    			$price_arr[$i] = $output['package'][$i]['price'];
			}

			//sort price array -- keys are left as associate with original pkg
			print_r($price_arr);
			$sorted = arsort($price_arr);
			echo "<br />";
			print_r($price_arr);
			echo "<br />";

			$pack_arr = array();
			if($budget > 50 && $duration > 2){
				//if true run two packages run
  				$pack_arr = twoPackages($price_arr, $budget);
  			} else {
  				//run one package
  				$pack_arr[0] = pickLast($price_arr, $budget);	
  			}
  			print_r($pack_arr);

//if one package run
			

			

			?> </h1>
			
		</div>
		<div id="footer"></div>
	</body>
</html>

