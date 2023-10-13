<?php
$CI = get_instance();
$CI->load->database();
$CI->load->dbforge();


$settings_data['key'] = 'contact_info';
$settings_data['value'] = '{"email":"","phone":"","address":"","office_hours":""}';
$CI->db->insert('frontend_settings', $settings_data);



// CREATING TABLE
$contact = array(
    'id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'unsigned' => TRUE,
        'auto_increment' => TRUE,
        'collation' => 'utf8_unicode_ci'
    ),
    'first_name' => array(
        'type' => 'VARCHAR',
        'constraint' => '255',
        'default' => null,
        'null' => TRUE,
        'collation' => 'utf8_unicode_ci'
    ),
    'last_name' => array(
        'type' => 'VARCHAR',
        'constraint' => '255',
        'default' => null,
        'null' => TRUE,
        'collation' => 'utf8_unicode_ci'
    ),
    'email' => array(
        'type' => 'VARCHAR',
        'constraint' => '255',
        'default' => null,
        'null' => TRUE,
        'collation' => 'utf8_unicode_ci'
    ),
    'phone' => array(
        'type' => 'VARCHAR',
        'constraint' => '255',
        'default' => null,
        'null' => TRUE,
        'collation' => 'utf8_unicode_ci'
    ),
    'address' => array(
        'type' => 'VARCHAR',
        'constraint' => '400',
        'default' => null,
        'null' => TRUE,
        'collation' => 'utf8_unicode_ci'
    ),
    'message' => array(
        'type' => 'text',
        'default' => null,
        'null' => TRUE,
        'collation' => 'utf8_unicode_ci'
    ),
    'has_read' => array(
        'type' => 'INT',
        'constraint' => 11,
        'default' => null,
        'null' => TRUE,
        'collation' => 'utf8_unicode_ci'
    ),
    'replied' => array(
        'type' => 'INT',
        'constraint' => 11,
        'default' => null,
        'null' => TRUE,
        'collation' => 'utf8_unicode_ci'
    ),
    'created_at' => array(
        'type' => 'VARCHAR',
        'constraint' => '100',
        'default' => null,
        'null' => TRUE,
        'collation' => 'utf8_unicode_ci'
    ),
    'updated_at' => array(
        'type' => 'VARCHAR',
        'constraint' => '100',
        'default' => null,
        'null' => TRUE,
        'collation' => 'utf8_unicode_ci'
    )
);
$CI->dbforge->add_field($contact);
$CI->dbforge->add_key('id', TRUE);
$attributes = array('collation' => "utf8_unicode_ci");
$CI->dbforge->create_table('contact', TRUE);


// update VERSION NUMBER INSIDE SETTINGS TABLE
$settings_data = array('value' => '6.2');
$CI->db->where('key', 'version');
$CI->db->update('settings', $settings_data);