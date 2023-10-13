<?php
$CI = get_instance();
$CI->load->database();
$CI->load->dbforge();

// CREATING TABLE
$notification_settings = array(
    'id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'unsigned' => TRUE,
        'auto_increment' => TRUE,
        'collation' => 'utf8_unicode_ci'
    ),
    'type' => array(
        'type' => 'VARCHAR',
        'constraint' => '255',
        'default' => null,
        'null' => TRUE,
        'collation' => 'utf8_unicode_ci'
    ),
    'is_editable' => array(
        'type' => 'INT',
        'constraint' => 11,
        'collation' => 'utf8_unicode_ci'
    ),
    'addon_identifier' => array(
        'type' => 'VARCHAR',
        'constraint' => '255',
        'default' => null,
        'null' => TRUE,
        'collation' => 'utf8_unicode_ci'
    ),
    'user_types' => array(
        'type' => 'VARCHAR',
        'constraint' => '400',
        'default' => null,
        'null' => TRUE,
        'collation' => 'utf8_unicode_ci'
    ),
    'system_notification' => array(
        'type' => 'VARCHAR',
        'constraint' => '400',
        'default' => null,
        'null' => TRUE,
        'collation' => 'utf8_unicode_ci'
    ),
    'email_notification' => array(
        'type' => 'VARCHAR',
        'constraint' => '400',
        'default' => null,
        'null' => TRUE,
        'collation' => 'utf8_unicode_ci'
    ),
    'subject' => array(
        'type' => 'VARCHAR',
        'constraint' => '255',
        'default' => null,
        'null' => TRUE,
        'collation' => 'utf8_unicode_ci'
    ),
    'template' => array(
        'type' => 'longtext',
        'default' => null,
        'null' => TRUE,
        'collation' => 'utf8_unicode_ci'
    ),
    'setting_title' => array(
        'type' => 'VARCHAR',
        'constraint' => '255',
        'default' => null,
        'null' => TRUE,
        'collation' => 'utf8_unicode_ci'
    ),
    'setting_sub_title' => array(
        'type' => 'VARCHAR',
        'constraint' => '255',
        'default' => null,
        'null' => TRUE,
        'collation' => 'utf8_unicode_ci'
    ),
    'date_updated' => array(
        'type' => 'VARCHAR',
        'constraint' => '100',
        'default' => null,
        'null' => TRUE,
        'collation' => 'utf8_unicode_ci'
    )
);
$CI->dbforge->add_field($notification_settings);
$CI->dbforge->add_key('id', TRUE);
$attributes = array('collation' => "utf8_unicode_ci");
$CI->dbforge->create_table('notification_settings', TRUE);

$notifications = array(
    'id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'unsigned' => TRUE,
        'auto_increment' => TRUE,
        'collation' => 'utf8_unicode_ci'
    ),
    'from_user' => array(
        'type' => 'INT',
        'constraint' => 11,
        'collation' => 'utf8_unicode_ci'
    ),
    'to_user' => array(
        'type' => 'INT',
        'constraint' => 11,
        'collation' => 'utf8_unicode_ci'
    ),
    'status' => array(
        'type' => 'INT',
        'constraint' => 11,
        'collation' => 'utf8_unicode_ci'
    ),
    'type' => array(
        'type' => 'VARCHAR',
        'constraint' => '255',
        'default' => null,
        'null' => TRUE,
        'collation' => 'utf8_unicode_ci'
    ),
    'title' => array(
        'type' => 'VARCHAR',
        'constraint' => '255',
        'default' => null,
        'null' => TRUE,
        'collation' => 'utf8_unicode_ci'
    ),
    'description' => array(
        'type' => 'longtext',
        'default' => null,
        'null' => TRUE,
        'collation' => 'utf8_unicode_ci'
    ),
    'created_at' => array(
        'type' => 'VARCHAR',
        'constraint' => '255',
        'default' => null,
        'null' => TRUE,
        'collation' => 'utf8_unicode_ci'
    ),
    'updated_at' => array(
        'type' => 'VARCHAR',
        'constraint' => '255',
        'default' => null,
        'null' => TRUE,
        'collation' => 'utf8_unicode_ci'
    )
);
$CI->dbforge->add_field($notifications);
$CI->dbforge->add_key('id', TRUE);
$attributes = array('collation' => "utf8_unicode_ci");
$CI->dbforge->create_table('notifications', TRUE);

$newsletter_subscriber = array(
    'id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'unsigned' => TRUE,
        'auto_increment' => TRUE,
        'collation' => 'utf8_unicode_ci'
    ),
    'email' => array(
        'type' => 'VARCHAR',
        'constraint' => '255',
        'default' => null,
        'null' => TRUE,
        'collation' => 'utf8_unicode_ci'
    ),
    'created_at' => array(
        'type' => 'VARCHAR',
        'constraint' => '255',
        'default' => null,
        'null' => TRUE,
        'collation' => 'utf8_unicode_ci'
    ),
    'updated_at' => array(
        'type' => 'VARCHAR',
        'constraint' => '255',
        'default' => null,
        'null' => TRUE,
        'collation' => 'utf8_unicode_ci'
    )
);
$CI->dbforge->add_field($newsletter_subscriber);
$CI->dbforge->add_key('id', TRUE);
$attributes = array('collation' => "utf8_unicode_ci");
$CI->dbforge->create_table('newsletter_subscriber', TRUE);


$newsletters = array(
    'id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'unsigned' => TRUE,
        'auto_increment' => TRUE,
        'collation' => 'utf8_unicode_ci'
    ),
    'subject' => array(
        'type' => 'VARCHAR',
        'constraint' => '255',
        'default' => null,
        'null' => TRUE,
        'collation' => 'utf8_unicode_ci'
    ),
    'description' => array(
        'type' => 'mediumtext',
        'default' => null,
        'null' => TRUE,
        'collation' => 'utf8_unicode_ci'
    ),
    'created_at' => array(
        'type' => 'VARCHAR',
        'constraint' => '255',
        'default' => null,
        'null' => TRUE,
        'collation' => 'utf8_unicode_ci'
    ),
    'updated_at' => array(
        'type' => 'VARCHAR',
        'constraint' => '255',
        'default' => null,
        'null' => TRUE,
        'collation' => 'utf8_unicode_ci'
    )
);
$CI->dbforge->add_field($newsletters);
$CI->dbforge->add_key('id', TRUE);
$attributes = array('collation' => "utf8_unicode_ci");
$CI->dbforge->create_table('newsletters', TRUE);


//column add
$fields = array(
        'completed_date' => array(
                'type' => 'varchar',
                'constraint' => 255,
                'default' => null,
        ),
);
$CI->dbforge->add_column('watch_histories', $fields);

$fields2 = array(
        'expiry_period' => array(
                'type' => 'varchar',
                'constraint' => 255,
                'default' => null,
        ),
);
$CI->dbforge->add_column('course', $fields2);

$fields3 = array(
        'expiry_date' => array(
                'type' => 'varchar',
                'constraint' => 255,
                'default' => null,
        ),
);
$CI->dbforge->add_column('enrol', $fields3);


if (!$CI->db->field_exists('quiz_attempt', 'lesson')) {
    $fields4 = array(
            'quiz_attempt' => array(
                    'type' => 'INT',
                    'constraint' => 11,
                    'default' => 0,
            ),
    );
    $CI->dbforge->add_column('lesson', $fields4);
}

$fields5 = array(
        'phone' => array(
                'type' => 'varchar',
                'constraint' => 255,
                'default' => null,
        ),
);
$CI->dbforge->add_column('users', $fields5);

$fields6 = array(
        'address' => array(
                'type' => 'varchar',
                'constraint' => 255,
                'default' => null,
        ),
);
$CI->dbforge->add_column('users', $fields6);


//Row insert
$settings_data = array('key' => 'smtp_from_email', 'value' => get_settings('smtp_user'));
$CI->db->insert('settings', $settings_data);


$settings_data3 = array('key' => 'website_faqs', 'value' => '[]');
$CI->db->insert('frontend_settings', $settings_data3);

$settings_data4 = array('key' => 'motivational_speech', 'value' => '[]');
$CI->db->insert('frontend_settings', $settings_data4);

$settings_data5 = array('key' => 'home_page', 'value' => 'home_1');
$CI->db->insert('frontend_settings', $settings_data5);

$notification_setting_rows = array(
  array('type' => 'signup','is_editable' => '1','addon_identifier' => NULL,'user_types' => '["admin","user"]','system_notification' => '{"admin":"1","user":"1"}','email_notification' => '{"admin":"0","user":"0"}','subject' => '{"admin":"New user registered","user":"Registered successfully"}','template' => '{"admin":"New user registered [user_name] \\r\\n<br>User email: <b>[user_email]<\\/b>","user":"You have successfully registered with us at [system_name]."}','setting_title' => 'New user registration','setting_sub_title' => 'Get notified when a new user signs up','date_updated' => '1684786525'),
  array('type' => 'email_verification','is_editable' => '0','addon_identifier' => NULL,'user_types' => '["user"]','system_notification' => '{"user":"0"}','email_notification' => '{"user":"1"}','subject' => '{"user":"Email verification code"}','template' => '{"user":"You have received a email verification code. Your verification code is [email_verification_code]"}','setting_title' => 'Email verification','setting_sub_title' => 'It is permanently enabled for student email verification.','date_updated' => '1684135777'),
  array('type' => 'forget_password_mail','is_editable' => '0','addon_identifier' => NULL,'user_types' => '["user"]','system_notification' => '{"user":"0"}','email_notification' => '{"user":"1"}','subject' => '{"user":"Forgot password verification code"}','template' => '{"user":"You have received a email verification code. Your verification code is [system_name][verification_link][minutes]"}','setting_title' => 'Forgot password mail','setting_sub_title' => 'It is permanently enabled for student email verification.','date_updated' => '1684145383'),
  array('type' => 'new_device_login_confirmation','is_editable' => '0','addon_identifier' => NULL,'user_types' => '["user"]','system_notification' => '{"user":"0"}','email_notification' => '{"user":"1"}','subject' => '{"user":"Please confirm your login"}','template' => '{"user":"Have you tried logging in with a different device? Confirm using the verification code. Your verification code is [verification_code]. Remember that you will lose access to your previous device after logging in to the new device [user_agent]. Use the verification code within [minutes] minutes"}','setting_title' => 'Account security alert','setting_sub_title' => 'Send verification code for login from a new device','date_updated' => '1684145383'),
  array('type' => 'course_purchase','is_editable' => '1','addon_identifier' => NULL,'user_types' => '["admin","student","instructor"]','system_notification' => '{"admin":"1","student":"1","instructor":"1"}','email_notification' => '{"admin":"0","student":"0","instructor":"0"}','subject' => '{"admin":"A new course has been sold","instructor":"A new course has been sold","student":"You have purchased a new course"}','template' => '{"admin":"[course_title][student_name][instructor_name][paid_amount]","instructor":"[course_title][student_name][paid_amount]","student":"[course_title][instructor_name][paid_amount]"}','setting_title' => 'Course purchase notification','setting_sub_title' => 'Stay up-to-date on student course purchases.','date_updated' => '1684303456'),
  array('type' => 'course_completion_mail','is_editable' => '1','addon_identifier' => NULL,'user_types' => '["student","instructor"]','system_notification' => '{"student":"1","instructor":"1"}','email_notification' => '{"student":"0","instructor":"0"}','subject' => '{"instructor":"Course completion","student":"You have completed a new course"}','template' => '{"instructor":"[course_title][student_name]","student":"[course_title][instructor_name]"}','setting_title' => 'Course completion mail','setting_sub_title' => 'Stay up to date on student course completion.','date_updated' => '1684303457'),
  array('type' => 'certificate_eligibility','is_editable' => '1','addon_identifier' => 'certificate','user_types' => '["student","instructor"]','system_notification' => '{"student":"1","instructor":"1"}','email_notification' => '{"student":"0","instructor":"0"}','subject' => '{"instructor":"Certificate eligibility","student":"certificate eligibility"}','template' => '{"instructor":"[course_title][student_name][certificate_link]","student":"[course_title][instructor_name][certificate_link]"}','setting_title' => 'Course eligibility notification','setting_sub_title' => 'Stay up to date on course certificate eligibility.','date_updated' => '1684303460'),
  array('type' => 'offline_payment_suspended_mail','is_editable' => '1','addon_identifier' => 'offline_payment','user_types' => '["student"]','system_notification' => '{"student":"1"}','email_notification' => '{"student":"0"}','subject' => '{"student":"Your payment has been suspended"}','template' => '{"student":"<p>Your offline payment has been <b style=\'color: red;\'>suspended</b> !</p><p>Please provide a valid document of your payment.</p>"}','setting_title' => 'Offline payment suspended mail','setting_sub_title' => 'If students provides fake information, notify them of the suspension','date_updated' => '1684303463'),
  array('type' => 'bundle_purchase','is_editable' => '1','addon_identifier' => 'course_bundle','user_types' => '["admin","student","instructor"]','system_notification' => '{"admin":"1","student":"1","instructor":"1"}','email_notification' => '{"admin":"0","student":"0","instructor":"0"}','subject' => '{"admin":"A new course bundle has been sold ","instructor":"A new course bundle has been sold ","student":"You have purchased a new course bundle test"}','template' => '{"admin":"[bundle_title][student_name][instructor_name] ","instructor":"[bundle_title][student_name] ","student":"[bundle_title][instructor_name] "}','setting_title' => 'Course bundle purchase notification','setting_sub_title' => 'Stay up-to-date on student course bundle purchases.','date_updated' => '1684303467'),
  array('type' => 'add_new_user_as_affiliator','is_editable' => '0','addon_identifier' => 'affiliate_course','user_types' => '["affiliator"]','system_notification' => '{"affiliator":"0"}','email_notification' => '{"affiliator":"1"}','subject' => '{"affiliator":"Congratulation ! You are assigned as an affiliator test"}','template' => '{"affiliator":"[website_link][password] test"}','setting_title' => 'New user added as affiliator','setting_sub_title' => 'Send account information to the new user','date_updated' => '1684135777'),
  array('type' => 'affiliator_approval_notification','is_editable' => '1','addon_identifier' => 'affiliate_course','user_types' => '["affiliator"]','system_notification' => '{"affiliator":"1"}','email_notification' => '{"affiliator":"0"}','subject' => '{"affiliator":"Congratulations! Your affiliate request has been approved"}','template' => '{"affiliator":"Congratulations! Your affiliate request has been approved"}','setting_title' => 'Affiliate approval notification','setting_sub_title' => 'Send affiliate approval mail to the user account','date_updated' => '1684303472'),
  array('type' => 'affiliator_request_cancellation','is_editable' => '1','addon_identifier' => 'affiliate_course','user_types' => '["affiliator"]','system_notification' => '{"affiliator":"1"}','email_notification' => '{"affiliator":"0"}','subject' => '{"affiliator":"Sorry ! Your request has been currently refused"}','template' => '{"affiliator":"Sorry ! Your request has been currently refused."}','setting_title' => 'Affiliator request cancellation','setting_sub_title' => 'Send mail, when you cancel the affiliation request','date_updated' => '1684303473'),
  array('type' => 'affiliation_amount_withdrawal_request','is_editable' => '1','addon_identifier' => 'affiliate_course','user_types' => '["admin","affiliator"]','system_notification' => '{"admin":"1","affiliator":"1"}','email_notification' => '{"admin":"0","affiliator":"0"}','subject' => '{"admin":"New money withdrawal request","affiliator":"New money withdrawal request"}','template' => '{"admin":"New money withdrawal request by [\'user_name] [amount]","affiliator":"Your Withdrawal request of [amount] has been sent to authority"}','setting_title' => 'Affiliation money withdrawal request','setting_sub_title' => 'Send mail, when the users request the withdrawal of money','date_updated' => '1684303476'),
  array('type' => 'approval_affiliation_amount_withdrawal_request','is_editable' => '1','addon_identifier' => 'affiliate_course','user_types' => '["affiliator"]','system_notification' => '{"affiliator":"1"}','email_notification' => '{"affiliator":"0"}','subject' => '{"affiliator":"Congartulation ! Your withdrawal request has been approved"}','template' => '{"affiliator":"Congartulation ! Your payment request has been approved."}','setting_title' => 'Approval of withdrawal request of affiliation','setting_sub_title' => 'Send mail, when you approved the affiliation withdrawal request','date_updated' => '1684303480'),
  array('type' => 'course_gift','is_editable' => '1','addon_identifier' => NULL,'user_types' => '["payer","receiver"]','system_notification' => '{"payer":"1","receiver":"1"}','email_notification' => '{"payer":"0","receiver":"0"}','subject' => '{"payer":"You have gift a course","receiver":"You have received a course gift"}','template' => '{"payer":"You have gift a course to [user_name] [course_title][instructor]","receiver":"You have received a course gift by [course_title][instructor]"}','setting_title' => 'Course gift notification','setting_sub_title' => 'Notify users after course gift','date_updated' => '1684303482')
);

foreach($notification_setting_rows as $row){
        $CI->db->insert('notification_settings', $row);
}


$frontend_settings = array( 'value' => 'default-new');
$CI->db->where('key', 'theme');
$CI->db->update('frontend_settings', $frontend_settings);

$current_banner = get_frontend_settings('banner_image');
$frontend_settings2['value'] = json_encode(['home_1' => $current_banner,'home_2' => $current_banner,'home_3' => $current_banner,'home_4' => $current_banner,'home_5' => $current_banner,'home_6' => $current_banner]);
$CI->db->where('key', 'banner_image');
$CI->db->update('frontend_settings', $frontend_settings2);


// update VERSION NUMBER INSIDE SETTINGS TABLE
$settings_data = array( 'value' => '6.0');
$CI->db->where('key', 'version');
$CI->db->update('settings', $settings_data);

//Course thumbnail change by default-new
foreach($CI->db->get('course')->result_array() as $course):
    if (file_exists('uploads/thumbnails/course_thumbnails/optimized/course_thumbnail_default_' . $course['id'].$course['last_modified'] . '.jpg')) {
        copy('uploads/thumbnails/course_thumbnails/optimized/course_thumbnail_default_' . $course['id'].$course['last_modified'] . '.jpg', 'uploads/thumbnails/course_thumbnails/optimized/course_thumbnail_default-new_' . $course['id'].$course['last_modified'] . '.jpg');
    }

    if (file_exists('uploads/thumbnails/course_thumbnails/course_thumbnail_default_' . $course['id'].$course['last_modified'] . '.jpg')) {
        copy('uploads/thumbnails/course_thumbnails/course_thumbnail_default_' . $course['id'].$course['last_modified'] . '.jpg', 'uploads/thumbnails/course_thumbnails/course_thumbnail_default-new_' . $course['id'].$course['last_modified'] . '.jpg');
    }
endforeach;