<!DOCTYPE html>
<html lang="en">
<head>
	<title><?php echo $page_title.' | '.get_settings('system_name'); ?></title>
    <!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-MQWF2TG');</script>
<!-- End Google Tag Manager -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="author" content="<?php echo get_settings('author') ?>" />

	<meta name="keywords" content="<?php echo get_settings('website_keywords'); ?>"/>
	<meta name="description" content="<?php echo get_settings('website_description'); ?>" />

	<link name="favicon" type="image/x-icon" href="<?php echo base_url('uploads/system/'.get_frontend_settings('favicon')); ?>" rel="shortcut icon" />
	<?php include 'includes_top.php';?>
</head>
<body>
    <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MQWF2TG"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
	<?php
		if($this->session->userdata('app_url')):
			include "go_back_to_mobile_app.php";
		endif;
		echo '<div class="container-fluid">';
			include 'payment_gateway.php';
		echo '</div>';

		include 'includes_bottom.php';
		if(get_frontend_settings('cookie_status') == 'active'):
	    	include 'eu-cookie.php';
	  	endif;
	?>
</body>
</html>
