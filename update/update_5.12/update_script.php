<?php
$CI = get_instance();
$CI->load->database();
$CI->load->dbforge();

// CREATING payment_gateways TABLE
$payment_gateways = array(
    'id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'unsigned' => TRUE,
        'auto_increment' => TRUE,
        'collation' => 'utf8_unicode_ci'
    ),
    'identifier' => array(
        'type' => 'varchar',
        'null' => TRUE,
        'constraint' => 255,
        'collation' => 'utf8_unicode_ci'
    ),
    'currency' => array(
        'type' => 'varchar',
        'null' => TRUE,
        'constraint' => 100,
        'collation' => 'utf8_unicode_ci'
    ),
    'title' => array(
        'type' => 'varchar',
        'null' => TRUE,
        'constraint' => 255,
        'collation' => 'utf8_unicode_ci'
    ),
    'description' => array(
        'type' => 'longtext',
        'null' => TRUE,
        'collation' => 'utf8_unicode_ci'
    ),
    'keys' => array(
        'type' => 'longtext',
        'null' => TRUE,
        'collation' => 'utf8_unicode_ci'
    ),
    'model_name' => array(
        'type' => 'varchar',
        'null' => TRUE,
        'constraint' => 255,
        'collation' => 'utf8_unicode_ci'
    ),
    'enabled_test_mode' => array(
        'type' => 'INT',
        'constraint' => 11,
        'null' => TRUE,
        'collation' => 'utf8_unicode_ci'
    ),
    'status' => array(
        'type' => 'INT',
        'constraint' => 11,
        'null' => TRUE,
        'collation' => 'utf8_unicode_ci'
    ),
    'is_addon' => array(
        'type' => 'INT',
        'constraint' => 11,
        'collation' => 'utf8_unicode_ci'
    ),
    'created_at' => array(
        'type' => 'varchar',
        'constraint' => 100,
        'collation' => 'utf8_unicode_ci'
    ),
    'updated_at' => array(
        'type' => 'varchar',
        'constraint' => 100,
        'collation' => 'utf8_unicode_ci'
    )
);
$CI->dbforge->add_field($payment_gateways);
$CI->dbforge->add_key('id', TRUE);
$attributes = array('collation' => "utf8_unicode_ci");
$CI->dbforge->create_table('payment_gateways', TRUE);

//Razorpay payment gateway
$r_keys = json_decode(get_settings('razorpay_keys'), true);
$r_currency = get_settings('razorpay_currency');
if(array_key_exists('secret_key', $r_keys[0])){
    $r_keys = $r_keys[0];
}
$r_sub_data['key_id']     = $r_keys['key'];
$r_sub_data['secret_key']     = $r_keys['secret_key'];
$r_sub_data['theme_color'] = $r_keys['theme_color'];
$r_data['keys'] = json_encode($r_sub_data);
$r_data['currency'] = $r_currency;
$r_data['enabled_test_mode'] = 0;
if($r_keys['active'] == 1){
    $r_data['status'] = 1;
}else{
    $r_data['status'] = 0;
}
$r_data['identifier'] = 'razorpay';
$r_data['title'] = 'Razorpay';
$r_data['description'] = '';
$r_data['model_name'] = 'Payment_model';
$r_data['is_addon'] = 0;
$r_data['created_at'] = time();
$CI->db->insert('payment_gateways', $r_data);

//Stripe payment gateway
$s_keys = json_decode(get_settings('stripe_keys'), true);
$s_currency = get_settings('stripe_currency');
if(array_key_exists('public_live_key', $s_keys[0])){
    $s_keys = $s_keys[0];
}
$s_sub_data['public_key']     = $s_keys['public_key'];
$s_sub_data['secret_key']     = $s_keys['secret_key'];
$s_sub_data['public_live_key'] = $s_keys['public_live_key'];
$s_sub_data['secret_live_key'] = $s_keys['secret_live_key'];
$s_data['keys'] = json_encode($s_sub_data);
$s_data['currency'] = $s_currency;

if($s_keys['testmode'] == 'on'){
    $s_data['enabled_test_mode'] = 1;
}else{
    $s_data['enabled_test_mode'] = 0;
}
if($s_keys['active'] == 1){
    $s_data['status'] = 1;
}else{
    $s_data['status'] = 0;
}
$s_data['identifier'] = 'stripe';
$s_data['title'] = 'Stripe';
$s_data['description'] = '';
$s_data['model_name'] = 'Payment_model';
$s_data['is_addon'] = 0;
$s_data['created_at'] = time();
$CI->db->insert('payment_gateways', $s_data);

//Paypal payment gateway
$p_keys = json_decode(get_settings('paypal'), true);
$p_currency = get_settings('paypal_currency');
if(array_key_exists('sandbox_client_id', $p_keys[0])){
    $p_keys = $p_keys[0];
}
$p_sub_data['sandbox_client_id']     = $p_keys['sandbox_client_id'];
$p_sub_data['sandbox_secret_key']     = $p_keys['sandbox_secret_key'];
$p_sub_data['production_client_id'] = $p_keys['production_client_id'];
$p_sub_data['production_secret_key'] = $p_keys['production_secret_key'];
$p_data['keys'] = json_encode($p_sub_data);
$p_data['currency'] = $p_currency;

if($p_keys['mode'] == 'sandbox'){
    $p_data['enabled_test_mode'] = 1;
}else{
    $p_data['enabled_test_mode'] = 0;
}
if($p_keys['active'] == 1){
    $p_data['status'] = 1;
}else{
    $p_data['status'] = 0;
}
$p_data['identifier'] = 'paypal';
$p_data['title'] = 'Paypal';
$p_data['description'] = '';
$p_data['model_name'] = 'Payment_model';
$p_data['is_addon'] = 0;
$p_data['created_at'] = time();
$CI->db->insert('payment_gateways', $p_data);

//insert google analytics id
$google_analytics['key'] = 'google_analytics_id';
$google_analytics['value'] = '';
$CI->db->insert('settings', $google_analytics);

//insert facebook pixel id
$meta_pixel_id['key'] = 'meta_pixel_id';
$meta_pixel_id['value'] = '';
$CI->db->insert('settings', $meta_pixel_id);

// update VERSION NUMBER INSIDE SETTINGS TABLE
$settings_data = array( 'value' => '5.12');
$CI->db->where('key', 'version');
$CI->db->update('settings', $settings_data);

