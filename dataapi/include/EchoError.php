<?php 

class EchoError
{
	const SUCCESS				= "ok";
	const ERROR_MAC_IS_NULL			= "mac is null";
	const ERROR_DATA_IS_NULL		= "data is null";
	const ERROR_PARAMS_COMPLETE		= "params is not complete";
	const ERROR_SAME_NAME			= "same name or email or phone";
	const ERROR_SAME_EMAIL			= "same email";
	const ERROR_SAME_PHONE			= "same phone";
	const ERROR_REGISTER_FAILED		= "register failed";
	const ERROR_INVALID_NAME_OR_PWD		= "invalid name or password";
	const ERROR_REQUEST_TIMEOUT		= "request timeout";
	const ERROR_MAC_REPEAT			= "mac is repeated";
	const ERROR_NEED_POST			= "need post";
	const ERROR_NO_SCHOOL_ID		= "can not find school id";

	static function dieError($code, $info=null)
	{
		$res = array();
		$res["error"] = $code;
		switch ($code) {
		case 0 :
			$res["info"] = self::SUCCESS;
			break;
		case 1 :
			$res["info"] = self::ERROR_MAC_IS_NULL;
			break;
		case 2 :
			$res["info"] = self::ERROR_DATA_IS_NULL;
			break;
		case 3 :
			$res["info"] = self::ERROR_PARAMS_COMPLETE;
			break;
		case 4 :
			$res["info"] = self::ERROR_SAME_NAME;
			break;
		case 5 :
			$res["info"] = self::ERROR_SAME_EMAIL;
			break;
		case 6 :
			$res["info"] = self::ERROR_SAME_PHONE;
			break;
		case 7 :
			$res["info"] = self::ERROR_REGISTER_FAILED;
			break;
		case 8 :
			$res["info"] = self::ERROR_INVALID_NAME_OR_PWD;
			break;
		case 9 :
			$res["info"] = self::ERROR_MAC_REPEAT;
			break;
		case 10 :
			$res["info"] = self::ERROR_NEED_POST;
			break;
		case 11 :
			$res["info"] = self::ERROR_NO_SCHOOL_ID;
			break;

		default :
			$res["info"] = $info;
			break;
		}

		echo json_encode($res);
		die("");
	}

}

?>
