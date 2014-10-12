<?php

	$budget = $_REQUEST['budget'];
	$duration = $_REQUEST['duration'];
	$json_in = $_REQUEST['json'];


	function twoPackages($bud, $dur) {
  		$twopac = false;
  		if($bud > 50 && $dur > 2){
  			$twopac = true;
  		}
  		return $twopac;
	}

	function pickOne($trunc_sorted_price_arr, $budg){
		$retrunc_sorted_price_arr = array();
		foreach ($trunc_sorted_price_arr as $key => $value){
			if($budg>=$value && $value >= (.7 * $budg)){
				$retrunc_sorted_price_arr[$key] = $value;
			}
		}
		$second_package = array_rand($retrunc_sorted_price_arr);
		if($second_package == null){

			foreach ($trunc_sorted_price_arr as $key => $value){
				if($budg>=$value){
					$retrunc_sorted_price_arr[$key] = $value;
				}
			}
			$second_package = array_rand($retrunc_sorted_price_arr);	
		}
		print("test: " . $second_package);
		return $second_package;
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

			//truncate  sorted price array
			foreach ($price_arr as $key => $value){
				if($budget>=$value){
					$truncated_arr[$key] = $value;
				}
			}

			print_r($truncated_arr);
			echo "<br />";

			//random value from truncated and sorted price array
			$first_package = array_rand($truncated_arr);
			echo $first_package;
			echo "<br />";

			//remove $first_package from truncated and sorted price array
			unset($truncated_arr[$first_package]);
			print_r($truncated_arr);
			echo "<br />";

			//get new budget
			$new_budget = $budget - $output['package'][$first_package]['price'];
			echo $new_budget;
			echo "<br />";
//PICK ONE FUNCTION
		
			$last_package = pickOne($truncated_arr, $new_budget);
			echo $last_package;
			echo "<br />";
//END PICK ONE FUNCTION
			echo "the two final packages are:";
			echo ($first_package . " " . $last_package);





			?> </h1>
			
		</div>
		<div id="footer"></div>
	</body>
</html>

