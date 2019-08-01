<?php
$_CONFIG['environment'] = 'development';
define('APPLICATION_URL', "http://appsshoppy.com/career_souq/admin/");	
		
define('APPLICATION_URL_ADMIN', "http://appsshoppy.com/career_souq/admin/");

define('BASE_PATH', APPLICATION_URL);

define('IMAGES_URL', APPLICATION_URL.'images/');
define('CSS_URL', APPLICATION_URL.'css/');
define('JS_URL', APPLICATION_URL.'js/');

define('CK_Edit', APPLICATION_URL.'ckeditor/'); 
define('BANNER_IMG', APPLICATION_URL.'upload/banners/');
define('CAT_IMG', APPLICATION_URL.'upload/category_banners/');
//====================== ADMIN Config URL ===================================================


//==================== Image Paths ============================//

define("ADMIN_EMAIL", "say2me84@gmail.com.com");
define("MAIL_SITE_NAME", "say2me84@gmail.com.com");
define("EMAIL_VERIFICATION_LINK", APPLICATION_URL."verify/activate?key=");
define("CLASS_VERIFICATION_LINK", APPLICATION_URL."verify/permission?key=");

$_CONFIG['homeDir'] = realpath(dirname(dirname(dirname(__FILE__)))).'/'; 
define('SITE_ROOT', $_CONFIG['homeDir']);

$_CONFIG['homeDir'] = realpath(dirname(dirname(dirname(__FILE__)))).'/';


define("DEF_CHK_ALLOT_RECEIPT",0);
define("DEF_CHK_RECEIPT_ALREADY",0);
define("DEF_NEED_APPROVE",0);
//print_r($_CONFIG['homeDir']);
?>