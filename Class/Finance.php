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
		$famt = $N * $emir;
		$intr = (!$arr) ? ($famt - $P - $intrest) : ($famt - $P);
		$ret = array(
			"emi" => $emir,
			"intrest" => $intr,
			"final_amount" => $famt,
			"fm_int" => $intrest
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
		$r = ($r / (12 * 100));
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
		$r = ($r / (12 * 100));
		//$r = ($r/100);
		$SI = $P * $r * $t;
		$S = $P * (1 + ($r * $t));
		
		return json_encode(array('si' => round($SI, 3), 'final_amount' => round($S, 3)));
	}
	
	/*
	* CI - Compound Interest
	*
	* CI = P x r x n
	* P = Principal, r = Interest Rate per period, n = number of periods
	*/
	public static function CI($P, $r, $n){
		//$r = ($r/100);
		$r = ($r / (12 * 100));
		$CI = $P * (pow(((1/$r)), $n) - 1);
		$C = $P * pow((1 + $r), $n);
		
		return json_encode(array('ci' => round($CI, 3), 'final_amount' => round($C, 3)));
	}
	
	/*
	* Amortization
	*
	* A = P x (r + (r/((1+r)^n - 1)))
	* P = Principal, r = Interest Rate per period, n = number of periods
	*/
	public static function Amortization($P, $r, $n){
		$r = ($r / (12 * 100));
		$A = $P * ($r + ($r / (pow((1+$r), $n) - 1)));
		
		$f_amt = ($A * $n);
		$intr_amt = ($f_amt - $P);
		$intr_perc = (($intr_amt / $P) * 100);
		
		$a_sch = array();
		$cp = $P;
		$cpr = round($cp);
		
		$m_cpr = $m_cir = $m_rbr = $m_balr = 0;
		
		for($i = 1; $i <= $n; $i++){
			$ci = ($cp * $r);
			$rb = $A - $ci;
			$bal = $cp - $rb;
			
			$cir = round($ci);
			$rbr = round($rb);
			$balr = round($bal);
			
			$m_cir = $m_cir + ($ci - $cir);
			$m_rbr = $m_rbr + ($rb - $rbr);
			$m_balr = $m_balr + ($bal - $balr);
			
			$a_sch[$i] = array(
				"month" => $i,
				"principle" => $cpr,
				"interest" => $cir,
				"reduc_princ" => $rbr,
				"balance" => $balr
			);
			$cp = $bal;
		}
		
		return json_encode(array('A' => round($A, 3), 'final_amount' => round($f_amt, 3), 'interest_amount' => round($intr_amt, 3), 'interest_percentage' => round($intr_perc, 2), 'schedule' => $a_sch));
	}
}
?>