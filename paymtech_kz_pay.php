<?php
function get_text_between_tags($inputStr, $delimeterLeft = '', $delimeterRight = '', $debug = false) { 
	if ( empty($delimeterLeft) )
		$posLeft = 0;
	else
		$posLeft = strpos($inputStr, $delimeterLeft); 
    if ( $posLeft === false ) { 
		if ( $debug )
            echo "Warning: left delimiter '".$delimeterLeft."' not found"; 
        return false; 
    } 
    $posLeft = $posLeft + strlen($delimeterLeft); 
	if ( empty($delimeterRight) )
		$posRight = strlen($inputStr);
	else {
		$posRight = strpos($inputStr, $delimeterRight, $posLeft); 
		if ( $posRight === false ) { 
			$posRight = strlen($inputStr);
			if ( $debug )
				echo "Warning: right delimiter '{$delimeterRight}' not found"; 
		} 
	}
    return substr($inputStr, $posLeft, $posRight - $posLeft); 
}

$certs_folder = 'application/views/payment-global/paymtech/';
$api_url = 'https://api.paymtech.kz/';
$password_for_certificate = "7CyP1XfPWEbE";
$username = 'alakrisgroup';
$password = 'rR7M2z/EJeQM8T/0';

/*
$api_url = 'https://sandboxapi.paymtech.kz/';
$password_for_certificate = "fPp/pr3KEQLn";
$username = 'alakrisgroup';
$password = 'MsTyha61Ch8h5WaL';
*/

$certs = array();
$pkcs12 = file_get_contents($certs_folder.'alakrisgroup.p12');

$base_currency = 'USD';
//$currency = 'KZT';
$currency = 'USD';
$exchange_rate_file = $certs_folder."exchange_rate_".$base_currency."_to_".$currency.".txt";
$exchange_rate = 1;

$seconds_past = intval(time()) - intval(strtotime("31 December 2022")) + rand(1, 10000);

// merchant_order_id holds information about user_id and course_id. First two nine-digit system numbers separated by '9' are user_id and course_id.
$invoice = base_convert($_POST['user_id'], 10, 9).'9'.base_convert($_POST['course_id'], 10, 9).'9'.base_convert(strval($seconds_past), 10, 9); // time();

$description = 'test';
if (!empty($_POST['description'])) {
	$description = $_POST['description'];
}

// extract certeficate and publick key from file
openssl_pkcs12_read( $pkcs12, $certs, $password_for_certificate );

// save cerificates
file_put_contents($certs_folder.'cert.pem', $certs['cert']);
file_put_contents($certs_folder.'priv.key', $certs['pkey']);

$curl = curl_init();
curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
//curl_setopt($curl, CURLOPT_CAINFO, $certs_folder.'cert.pem');//'корневой сертификат');
curl_setopt($curl, CURLOPT_SSLCERT, $certs_folder.'cert.pem');
curl_setopt($curl, CURLOPT_SSLKEY, $certs_folder.'priv.key');
curl_setopt($curl, CURLOPT_SSLCERTPASSWD, $password_for_certificate);
curl_setopt($curl, CURLOPT_SSLKEYPASSWD, $password_for_certificate);
curl_setopt($curl, CURLOPT_USERPWD, "$username:$password"); // если нужно авторизироваться логином и паролем
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

$array = [];

switch ($_GET['method']) {
	case 'create' :
		
		if ($currency != 'USD') {
			$date = date_create();
			curl_setopt($curl, CURLOPT_URL, $api_url.'exchange_rates/?date='.date_format($date, 'Y-m-d'));
			curl_setopt($curl, CURLOPT_POST, false);
			curl_setopt($curl, CURLOPT_HEADER, false);

			$result = curl_exec($curl);
			try {
				if ( $result !== false ) {
					$res_arr = json_decode($result, true);
					if ( @$res_arr['exchange_rates'] ) {
						foreach ($res_arr['exchange_rates'] as $rate_arr) {
							if ($rate_arr['from'] == $base_currency && $rate_arr['to'] == $currency) {
								file_put_contents($exchange_rate_file, $rate_arr['rate']);
							}
						}
					}
				}
			}
			catch (Exception $e) {
			}
		}
		curl_setopt($curl, CURLOPT_URL, $api_url.'orders/create');
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_HEADER, true);
		
		if ($currency != 'USD') {
			$exchange_rate = 472;
			$s = file_get_contents($exchange_rate_file);
			if (!empty($s))
				$exchange_rate = floatval($s);
			$description = $description." (1 $base_currency = ".number_format($exchange_rate, 2, '.', ' ')." $currency)";
		}

		$amount = $_POST['amount'] * $exchange_rate;
		$array = array(
			'amount' => $amount,
			'currency' => $currency,
			'merchant_order_id' => $invoice,
			'description' => $description,
			'options' => [
				'force3d' => '1',
				'auto_charge' => '1',
				'return_url' => 'https://galactik.org/paymtech_kz_pay.php', //URL для возврата
				'terminal' => ($currency == 'USD' ? 'terminal_alakrisgroup_usd' : 'terminal_alakrisgroup'),
			],
		);
		//var_dump($array); exit;
	break;
	case 'orders' :
		curl_setopt($curl, CURLOPT_URL, $api_url.'orders');
		curl_setopt($curl, CURLOPT_POST, false);
	break;
}

if (!empty($_GET['method'])) {
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($array));
	
	$result = curl_exec($curl);
	if ( $result===false ) {
		header("Location: https://galactik.org/home/payment?status=fail&message=".$_GET['method']." curl error: ".urlencode(curl_error($curl)), true, 301);
	}
	else {
		//var_dump($result); exit;
		if (is_integer(strpos($result, 'Location:'))) {
			$redirect_url = trim(get_text_between_tags($result, 'Location:', "\r"));
			//echo "redirect url: '$redirect_url'<br>"; exit;
			header("Location: $redirect_url", true, 301);
		}
		else {
			if (is_integer(strpos($result, '{'))) {
				$jsn = '{'.get_text_between_tags($result, '{');
				try {
					$res_arr = json_decode($jsn, true);
					//var_dump($res_arr); exit;
					if ( isset($res_arr['errors']) && isset($res_arr['errors'][0]) && !empty(@$res_arr['errors'][0]['message']) ) {
						//echo "msg: ".$res_arr['errors'][0]['message']; exit;
						header("Location: https://galactik.org/home/payment?status=error&message=".$res_arr['errors'][0]['message'], true, 301);
					}
				}
				catch (Exception $e) {
					header("Location: https://galactik.org/home/payment?status=fail&message=".urlencode("bank returned: $result"), true, 301);
				}
			}
			else {
				header("Location: https://galactik.org/home/payment?status=fail&message=".urlencode('Payment system did not return redirect URL'), true, 301);			
			}
			/*echo "result:<br>";
			var_dump($result); 
			echo "<br>header:<br>";
			$header = curl_getinfo($curl);
			var_dump($header);*/

		}
	}
	//echo "result:<br>";
	//var_dump($result); 
	//echo "<br>header:<br>";
	//$header = curl_getinfo($curl);
	//var_dump($header);

	exit;
}
else 
if (!empty($_GET['order_id'])) {
	curl_setopt($curl, CURLOPT_URL, $api_url."orders/".$_GET['order_id']);
	curl_setopt($curl, CURLOPT_POST, false);
	$result = curl_exec($curl);
	try {
		if ( $result === false ) {
			header("Location: https://galactik.org/home/payment?status=fail&message=".$_GET['method']." curl error: ".urlencode(curl_error($curl)), true, 301);
		}
		else {
			$res_arr = json_decode($result, true);
			if ( @$res_arr['orders'] && count($res_arr['orders']) > 0 ) {
				
				//$res_arr['orders'][0]['status'] = 'charged';

				if ($res_arr['orders'][0]['status'] == 'charged') {
					file_put_contents($certs_folder.'order_'.$res_arr['orders'][0]['id'].'.txt', json_encode($res_arr));
					header("Location: https://galactik.org/home/purchase_history?status=".$res_arr['orders'][0]['status'].'&order_id='.@$res_arr['orders'][0]['id'], true, 301);
				}
				else {
					header("Location: https://galactik.org/home/payment?status=".$res_arr['orders'][0]['status'].'&message='.@$res_arr['orders'][0]['failure_message'], true, 301);
				}
			}
			else {
				header("Location: https://galactik.org/home/payment?status=fail&message=".urlencode('Payment system does not respond'), true, 301);
			}
		}
	}
	catch (Exception $e) {
		header("Location: https://galactik.org/home/payment?status=fail&message=".urlencode('A request to payment system raised an exception'), true, 301);
	}
	exit;
}
else {
	echo "<br>no data<br>";
	//echo "<br>GET:<br>";
	//var_dump($_GET);
	//echo "<br>POST:<br>";
	//var_dump($_POST);
}
?>
</body>
</html>
