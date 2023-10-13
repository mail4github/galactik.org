<!DOCTYPE html>
<html lang="en">
<?php $instructor_details = $this->user_model->get_all_user($instructor_id)->row_array();
$categories = $this->crud_model->get_blog_categories()->result_array();
 ?>
<head>
	<?php include 'metas.php'; ?>
	<title>
	<?php if (substr_count($_SERVER['REQUEST_URI'], 'course')):
	echo $course_details['title'];
	elseif (substr_count($_SERVER['REQUEST_URI'], 'blog/details')):
	echo $blog_details['title'];
	elseif (substr_count($_SERVER['REQUEST_URI'], 'blogs?category')):
	echo 'Блог';
	elseif (substr_count($_SERVER['REQUEST_URI'], 'page/zapis')):
	echo 'Как записаться на курс?';
	elseif (substr_count($_SERVER['REQUEST_URI'], 'page/getcertificate')):
	echo 'Как получить сертификат после прохождения курса?';
	elseif (substr_count($_SERVER['REQUEST_URI'], 'page/getcourse')):
	echo 'Добавить курс';
	elseif (substr_count($_SERVER['REQUEST_URI'], 'sign_up')):
	echo 'Регистрация';
	elseif (substr_count($_SERVER['REQUEST_URI'], 'home/login')):
	echo 'Логин';
	elseif (substr_count($_SERVER['REQUEST_URI'], 'home/courses')):
	echo 'Онлайн-курсы';
	elseif (substr_count($_SERVER['REQUEST_URI'], 'home/courses?category=')):
	echo 'Онлайн-курсы';
	elseif (substr_count($_SERVER['REQUEST_URI'], 'Программирование')):
	echo 'Онлайн-курсы: Прогаммирование';
	
	elseif (substr_count($_SERVER['REQUEST_URI'], 'instructor')):
	echo $instructor_details['first_name'].' '.$instructor_details['last_name'];
	else:
	echo get_settings('system_title');
	endif; ?>
	</title>
	
	<?php include 'includes_top.php'; ?>


	<!-- Google Tag Manager -->
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start': new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-MQWF2TG');</script>
	<!-- End Google Tag Manager -->

</head>

<body <?php if ($page_name == 'login' || $page_name == 'sign_up' || $page_name == 'forgot_password' || $page_name == "change_password_from_forgot_password"): ?> id="login_bg" <?php endif; ?>>

	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MQWF2TG" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->

	<?php if ($page_name != 'login' && $page_name != 'sign_up' && $page_name != 'forgot_password' && $page_name != "change_password_from_forgot_password"): ?>
		<div id="page">
			<!-- Header -->
			<?php include 'header.php'; ?>
			<!-- Main content starts from here -->
			<main>
				<?php include $page_name.'.php'; ?>
			</main>
			<!-- footer -->
			<?php include 'footer.php'; ?>
		</div>
		<!-- end of page -->
	<?php elseif ($page_name == 'login' || $page_name == 'sign_up' || $page_name == 'forgot_password' || $page_name == "change_password_from_forgot_password"):?>
		<nav id="menu" class="fake_menu"></nav>
		<div id="preloader">
			<div data-loader="circle-side"></div>
		</div>
		<div id="login">
			<?php include $page_name.'.php'; ?>
		</div>
	<?php endif; ?>
	<!-- COMMON SCRIPTS -->
	<?php include 'includes_bottom.php'; ?>
	<?php include 'common_scripts.php'; ?>
	<?php include 'modal.php'; ?>
</body>
</html>
