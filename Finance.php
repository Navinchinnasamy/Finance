<?php
Class Finance {
	/* 
	* EMI - Euqated Monthly Installment
	* P - Principal, R - Rate per month, r - anual interest rate, N - Number of installments
	* $arr = true -> With arrear, false - 1 installment paid when starting EMI
	*
	* EMI = [P x R x (1+R)^N] / [(1+R)^N - 1]
	*
	*/
	public static function EMI($P, $r, $N, $arr=true) 
	{
		$R = ($r / (12 * 100));
		
		// >>>Paid one instalment when staring EMI
		$intrest = round(($P * $R), 3);
		if(!$arr){
			$P -= $intrest;
		}
		
		$EMI = ($P * $R * pow((1+$R),$N))/(pow((1+$R),$N) - 1);
		
		$emir = round($EMI,3);
		$famt = 12 * $emir;
		$intr = (!$arr) ? (($famt - $P) - $intrest) : ($famt - $P);
		$ret = array(
			"emi" => $emir,
			"intrest" => $intr,
			"final_amount" => $famt
		);
		return json_encode($ret);
	}
	
	/* 
	* APY - Annual Percentage Yield
	* r = Monthly interest rate, n = Number of times 
	* 
	* APY = [(1 + r / n)^n] - 1
	*
	*/
	public static function APY($r, $n=12){
		$APY = pow((1+($r/$n)), $n) - 1;
		return round($APY, 3);
	}
	
	/*
	* SI - Simple Interest
	*
	* SI = P x r x t
	* P = Principal, r = Interest Rate, t = Time period
	*/
	public static function SI($P, $r, $t){
		$r = ($r/100);
		$SI = $P * $r * $t;
		$S = $P * (1 + ($r * $t));
		
		return json_encode(array('si' => round($SI, 3), 'final_amount' => round($S, 3)));
	}
	
	/*
	* CI - Simple Interest
	*
	* CI = P x r x n
	* P = Principal, r = Interest Rate per period, n = number of periods
	*/
	public static function CI($P, $r, $n){
		$r = ($r/100);
		$CI = $P * (pow(((1/$r)), $n) - 1);
		$C = $P * pow((1 + $r), $n);
		
		return json_encode(array('ci' => round($CI, 3), 'final_amount' => round($C, 3)));
	}
}
echo "<h3>Financial Calculations</h3>";
echo "<b>Equated Monthly Installment (EMI):</b>";
echo Finance::EMI(100000, 10, 12, false);
echo "<br/>";
echo "<b>Anual Percentage Yield (APY): </b>";
echo Finance::APY(4, 12);
echo "<br/>";
echo "<b>Simple Interest: </b>";
echo Finance::SI(1000, 4, 12);
echo "<br/>";
echo "<b>Compound Interest: </b>";
echo Finance::CI(1000, 4, 12);
?>