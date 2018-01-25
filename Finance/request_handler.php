<?php
	spl_autoload_register(function($class_name){
		require_once(dirname(__DIR__)."/Class/".$class_name.".php");
	}, true);
	
	$post = $_POST;
	if(isset($post['req_from'])){
		switch($post['req_from']){
			case "getEMI":
				$ret = Finance::Amortization($post['principle'], $post['interest'], (12 * $post['terms']));
				break;
		}
		
		print_r($ret);
	}
	
	
/*
	echo "<h3>Financial Calculations</h3>";
	echo "<b>Equated Monthly Installment (EMI):</b>";
	echo Finance::EMI(300000, 12.7, 36, false);
	echo "<br/>";
	echo "<b>Anual Percentage Yield (APY): </b>";
	echo Finance::APY(12.7, 36);
	echo "<br/>";
	echo "<b>Simple Interest: </b>";
	echo Finance::SI(300000, 12.7, 36);
	echo "<br/>";
	echo "<b>Compound Interest: </b>";
	echo Finance::CI(300000, 12.7, 36);
	echo "<br/>";
	echo "<b>Amortization: </b>";
	echo Finance::Amortization(300000, 12.7, 36);
*/
?>