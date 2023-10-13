<?php
/*
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

$certs = array();
$pkcs12 = file_get_contents("alakrisgroup.p12");
$password_for_certificate = "fPp/pr3KEQLn";
$username = 'alakrisgroup';
$password = 'MsTyha61Ch8h5WaL';

//$_GET['amount'] = 1000;
//$_GET['currency'] = 'KZT';
$merchant_order_id = 'paymtech'.time();
$_GET['DESCRIPTION'] = 'test';

openssl_pkcs12_read( $pkcs12, $certs, $password_for_certificate );

//echo '<pre>';
//print_r($certs);
//echo '</pre>';

file_put_contents('cert.pem', $certs['cert']);
file_put_contents('priv.key', $certs['pkey']);

exit;

$curl = curl_init();
curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
//curl_setopt($curl, CURLOPT_CAINFO, 'cert.pem');//'корневой сертификат');
curl_setopt($curl, CURLOPT_SSLCERT, 'cert.pem');
curl_setopt($curl, CURLOPT_SSLKEY, 'priv.key');
curl_setopt($curl, CURLOPT_SSLCERTPASSWD, $password_for_certificate);
curl_setopt($curl, CURLOPT_SSLKEYPASSWD, $password_for_certificate);
curl_setopt($curl, CURLOPT_USERPWD, "$username:$password"); // если нужно авторизироваться логином и паролем
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$array = [];

//curl_setopt($curl, CURLOPT_URL, "https://finecopter.com");
switch ($_GET['method']) {
	case 'create' :
		curl_setopt($curl,CURLOPT_URL,"https://sandboxapi.paymtech.kz/orders/create");
		curl_setopt($curl, CURLOPT_HEADER, true);

		$array = array(
			'amount' => $_GET['amount'],
			'currency' => $_GET['currency'],
			'merchant_order_id' => $merchant_order_id,
			'description' => $_GET['DESCRIPTION'],
			'options' => [
				'force3d' => $_GET['force3d'],
				'auto_charge' => $_GET['auto_charge'],
				'return_url' => 'https://finecopter.com/tmp.php', //URL для возврата
			],
		);
	break;
	case 'authorize' :
		curl_setopt($curl,CURLOPT_URL,"https://sandboxapi.paymtech.kz/orders/authorize");
		$array = [
			'amount' => $_GET['amount'],
			'currency' => $_GET['currency'],
			'pan' => $_GET['card'],
			'card' => [
				"cvv" => $_GET['cvv'],
				"expiration_month" => $_GET['month'],
				"expiration_year" => $_GET['year'],
				"holder" => "John Smith"
			],
			"location" => [
				"ip" => "6.6.6.6"
			],
			'options' => [
				'force3d' => $_GET['force3d'],
				'auto_charge' => $_GET['auto_charge'],
				'return_url' => 'https://finecopter.com/tmp.php', //URL для возврата
			],
		];
	break;
	case 'orders' :
		curl_setopt($curl, CURLOPT_URL,"https://sandboxapi.paymtech.kz/orders");
		curl_setopt($curl, CURLOPT_POST, false);
	break;
}

if (!empty($_GET['method'])) {
	curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($array));
	curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

	$result = curl_exec($curl);
	if (is_integer(strpos($result, 'Location:'))) {
		$redirect_url = trim(get_text_between_tags($result, 'Location:', "\r"));
		//echo "redirect url: '$redirect_url'<br>"; exit;
		header("Location: $redirect_url", true, 301);
		exit;
	}

	echo "result:<br>";
	var_dump($result); 
	echo "<br>header:<br>";
	$header = curl_getinfo($curl);
	var_dump($header); 

	if ($result===false) 
		echo curl_error($curl);
}
else 
if (!empty($_GET['order_id'])) {
	curl_setopt($curl, CURLOPT_URL,"https://sandboxapi.paymtech.kz/orders/".$_GET['order_id']);
	curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	curl_setopt($curl, CURLOPT_POST, false);
	$result = curl_exec($curl);
	echo "result:<br>";
	var_dump($result); 
	echo "<br>header:<br>";
	$header = curl_getinfo($curl);
	var_dump($header); 

	if ($result===false) 
		echo curl_error($curl);
}
else {
	echo "<br>GET:<br>";
	var_dump($_GET);
	echo "<br>POST:<br>";
	var_dump($_POST);
}
//require(DIR_WS_INCLUDES.'footer.php');
*/
$description = '';
$course_id = '';

foreach ($payment_details['items'] as $key => $item) {
	$description = $description.(empty($description) ? '' : ', ').$item['title'];
	$course_id = $course_id.(empty($course_id) ? '' : '8').base_convert($item['id'], 10, 8);
}
?>

<form id="paymtech_kz" action="/paymtech_kz_pay.php?method=create" method="post" class="paymtech-form form">
	<input type="hidden" name="amount" value="<?php echo $payment_details['total_payable_amount']; ?>">
	<input type="hidden" name="description" value="<?php echo $description; ?>">
	<input type="hidden" name="course_id" value="<?php echo $course_id; ?>">
	<input type="hidden" name="user_id" value="<?php echo $this->session->userdata('user_id'); ?>">
	<button type="submit" class="payment-button float-end gateway paymtech-gateway"><?php echo get_phrase('continue'); ?> Paymtech ...</button>
</form>

<!--/body>
</html-->
