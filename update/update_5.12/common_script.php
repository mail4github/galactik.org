<?php
$CI = get_instance();
$CI->load->database();
$CI->load->dbforge();

if ($CI->db->field_exists('faqs', 'course')){
	// update VERSION NUMBER INSIDE SETTINGS TABLE
	$settings_data = array( 'value' => '5.11');
	$CI->db->where('key', 'version');
	$CI->db->update('settings', $settings_data);
}
?>
