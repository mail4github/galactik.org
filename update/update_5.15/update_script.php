<?php
$CI = get_instance();
$CI->load->database();
$CI->load->dbforge();


$fields = array(
        'gifted_by' => array(
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
        ),
);

$CI->dbforge->add_column('enrol', $fields);

// update VERSION NUMBER INSIDE SETTINGS TABLE
$settings_data = array( 'value' => '5.15');
$CI->db->where('key', 'version');
$CI->db->update('settings', $settings_data);
