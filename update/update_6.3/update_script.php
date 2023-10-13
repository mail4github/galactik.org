<?php
$CI = get_instance();
$CI->load->database();
$CI->load->dbforge();

$fields = array(
    'start_date' => array(
        'type' => 'VARCHAR',
        'constraint' => '255',
        'default' => null,
        'null' => TRUE,
        'collation' => 'utf8_unicode_ci'
    ),
    'end_date' => array(
        'type' => 'VARCHAR',
        'constraint' => '255',
        'default' => null,
        'null' => TRUE,
        'collation' => 'utf8_unicode_ci'
    ),
    'restricted_by' => array(
        'type' => 'VARCHAR',
        'constraint' => '255',
        'default' => null,
        'null' => TRUE,
        'collation' => 'utf8_unicode_ci'
    )
);
$this->dbforge->add_column('section', $fields);

$settings_data = array('key' => 'timezone', 'value' => 'America/New_York');
$CI->db->insert('settings', $settings_data);

$settings_data2 = array('key' => 'account_disable', 'value' => '0');
$CI->db->insert('settings', $settings_data2);

// update VERSION NUMBER INSIDE SETTINGS TABLE
$settings_data = array('value' => '6.3');
$CI->db->where('key', 'version');
$CI->db->update('settings', $settings_data);