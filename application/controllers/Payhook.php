<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/YooKassa/autoload.php';

use YooKassa\Client;


defined('BASEPATH') or exit('No direct script access allowed');

class Payhook extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
        $this->load->database();
        $this->load->library('session');
        
		/*cache control*/
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');

        //$this->user_model->check_session_data();       
    }

    function Sber(){
        echo "123";
    }

	public function Yookassa()
	{
		$client = new Client();
		
		$gateway_data = $this->db->where('identifier', 'YooKassa')->get('payment_gateways')->result_array();
		$keys = json_decode($gateway_data[0]['keys'], true);
		
		if (empty($gateway_data[0]['enabled_test_mode']))
			$client->setAuth(intval($keys['shop_id']), $keys['secret_key']);
		else
			$client->setAuth(intval($keys['test_shop_id']), $keys['test_secret_key']);
		
        $seconds_past = intval(time()) - intval(strtotime("1 October 2023")) + rand(1, 10000);
		
		$courses_arr = explode("8", $_POST['course_id']);
		foreach ($courses_arr as $course_id) {
			// convert octet number of course id to decimal
			$course_id = intval($course_id, 8);
		}
		
		// merchant_order_id holds information about user_id and course_id. First two nine-digit system numbers separated by '9' are user_id and course_id.
		$invoice = base_convert($_POST['user_id'], 10, 9).'9'.base_convert($_POST['course_id'], 10, 9).'9'.base_convert(strval($seconds_past), 10, 9); // time();
		
		try {
			$idempotenceKey = uniqid('', true);
			$response = $client->createPayment(
				[
					'amount' => [
						'value' => $_POST['amount'],
						'currency' => strtoupper($gateway_data[0]['currency']),
					],
					'confirmation' => [
						'type' => 'redirect',
						'locale' => 'ru_RU',
						'return_url' => base_url().'payhook/yookassa_callback?invoice='.$invoice,
					],
					'capture' => true,
					'description' => $_POST['description'],
					'metadata' => [
						'invoice' => $invoice,
					]
				],
				$idempotenceKey
			);
			
			//получаем confirmationUrl для дальнейшего редиректа
			$confirmationUrl = $response->getConfirmation()->getConfirmationUrl();

			// save pay attempt
			$this->db->insert('payment', ['user_id' => $this->session->userdata('user_id'), 'payment_type' => 'YooKassa', 'course_id' => $course_id, 'amount' => 0, 'date_added' => strtotime(date('D, d M Y')), 'last_modified' => strtotime(date('D, d M Y')), 'transaction_id' => $invoice, 'session_id' => $response->getId()]);

			redirect($confirmationUrl);

		} catch (\Exception $e) {
			$response = $e;
			echo "Error: $e<br>";
		}
    }

	public function Yookassa_callback()
	{
		$gateway_data = $this->db->where('identifier', 'YooKassa')->get('payment_gateways')->result_array();
		$keys = json_decode($gateway_data[0]['keys'], true);

		$invoice_arr = $this->db->where('transaction_id', html_escape($_GET['invoice']))->get('payment')->result_array();
		
		// Check out if this order has been processed already
		if (empty($invoice_arr[0]['amount'])) {
			$paymentId = $invoice_arr[0]['session_id'];
			
			$client = new Client();
			if (empty($gateway_data[0]['enabled_test_mode']))
				$client->setAuth(intval($keys['shop_id']), $keys['secret_key']);
			else
				$client->setAuth(intval($keys['test_shop_id']), $keys['test_secret_key']);
			
			$payment = $client->getPaymentInfo($paymentId);
			$payment_status = $payment->getStatus();
			if ($payment_status == 'succeeded') {
				// process payment if it is succeeded
				$amount_obj = $payment->getAmount();
				$amount = $amount_obj->value;
				
				// merchant_order_id holds information about user_id and IDs of purchased curses. First two nine-digit system numbers separated by '9' are user_id and IDs of purchased curses.
				$code_arr = explode("9", $_GET['invoice']);
				$user_id = intval($code_arr[0], 9);

				// The curses, which are purchased, are packed in one octet number where each course_id separated from each other by '8'
				$courses_str = strval(intval($code_arr[1], 9));
				$courses_arr = explode("8", $courses_str);

				$this->db->trans_start();
				
				foreach ($courses_arr as $course_id) {
					
					// convert octet number of course id to decimal
					$course_id = intval($course_id, 8);
					
					// subscribe purchaser to the curse
					$this->db->insert('enrol', ['user_id' => $user_id, 'course_id' => $course_id, 'date_added' => strtotime(date('D, d M Y')), 'last_modified' => strtotime(date('D, d M Y'))]);
				}
				
				// set purchase amount in DB
				$this->db->where('transaction_id', html_escape($_GET['invoice']))->update('payment', ['amount' => floatval($amount)]);

				$this->db->trans_complete();
			}			
		}

		redirect($keys['return_url']);

	}

	public function Set_currency_rate()
	{
		// set USD exchange rate for a currency
		$res = $this->db->where('code', html_escape($_POST['currency_code']))->update('currency', ['usd_exchange_rate' => floatval($_POST['usd_exchange_rate'])]);
		echo ($res ? "ok" : "fail");
	}
}