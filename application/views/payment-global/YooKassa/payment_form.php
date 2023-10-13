<?php
$description = '';
$course_id = '';

$system_currency = $this->db->where('key', 'system_currency')->get('settings')->row()->value;

$gateway_data = $this->db->where('identifier', 'YooKassa')->get('payment_gateways')->result_array();
$keys = json_decode($gateway_data[0]['keys'], true);
		
foreach ($payment_details['items'] as $key => $item) {
	$description = $description.(empty($description) ? '' : ', ').$item['title'];
	$course_id = $course_id.(empty($course_id) ? '' : '8').base_convert($item['id'], 10, 8);
}

$payment_system_currency = $gateway_data[0]['currency'];
$exchange_rate = $this->db->where('code', $payment_system_currency)->get('currency')->row()->usd_exchange_rate;

$amount = round($payment_details['total_payable_amount'] * $exchange_rate, 2);

$form_url = base_url().'payhook/yookassa';
?>

<form action="<?php echo $form_url; ?>" method="post" class="paymtech-form form">
	<input type="hidden" name="amount" value="<?php echo $amount; ?>">
	<input type="hidden" name="description" value="<?php echo $description; ?>">
	<input type="hidden" name="course_id" value="<?php echo $course_id; ?>">
	<input type="hidden" name="user_id" value="<?php echo $this->session->userdata('user_id'); ?>">
	<button type="submit" class="payment-button float-end gateway YooKassa-gateway"><?php echo get_phrase('continue'); ?> YooKassa ...</button>
</form>

<script type="text/javascript">

function get_local_exhange_rate(currency, base_currency, callback, callback_on_error, source)
{
	source = 0;
	/*if ( typeof source == "undefined" ) {
		var r = Math.random();
		source = Math.floor(r * 2) + 0;
		
	}*/
	if ( typeof base_currency == "undefined" )
		base_currency = "USD";
	try {
		switch ( source ) {
			case 0:
			$.get("https://blockchain.info/ticker", function() {
			}).done(function(response) {
			}).fail(function(response) {
			}).always(function(response) {
				if ( typeof response != "undefined" && typeof response[currency] != "undefined" && typeof response[currency]["last"] != "undefined" && typeof response[base_currency]["last"] != "undefined" ) {
					var currency_rate = response[currency]["last"] / response[base_currency]["last"];
					callback(currency_rate);
				}
			});
			break;
		}
	} catch(error) {
		if ( typeof callback_on_error != "undefined" )
			callback_on_error(error);
	}
}

$( document ).ready(function() {
	get_local_exhange_rate("<?php echo $payment_system_currency; ?>", "USD", 
		function( rate ) {
			if (rate > 0.5) {
				$.ajax({
					method: "POST",
					url: "<?php echo base_url().'payhook/set_currency_rate'; ?>",
					data: {currency_code: "<?php echo $payment_system_currency; ?>", usd_exchange_rate: rate}
				})
				.done(function( ajax__result ) {
					//ajax__result = ajax__result;
					//var arr_ajax__result = JSON.parse(ajax__result);
				});
			}
		}
	);
});

</script>


