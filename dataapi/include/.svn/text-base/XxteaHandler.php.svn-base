<?php include 'Xxtea.php' ?>

<?php

class XxteaHandler
{
	const ART_KEY = "WKL_ART";
	const TIME_OUT = 300;		// 300s

	public function __construct() {}

	public function getToken($mac)
	{
		if ($mac == null) return '';
		$src = $mac.'&'.time(0);
		$encstr = Xxtea::encrypt($src, self::ART_KEY);
		//return base64_encode($encstr);
		return $encstr;
	}

	public function compareTime($token, $mac)
	{
		//$b64str = base64_decode($token);
		$decstr = Xxtea::decrypt($token, self::ART_KEY);
		//echo $decstr;
		$dstArr = explode('&', $decstr);
		if ((time(0) - $dstArr[1]) > self::TIME_OUT) return false;
		return true;
	}
}

?>
