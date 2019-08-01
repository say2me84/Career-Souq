<?php
$_CONFIG['environment'] = 'development';

//define('APPLICATION_URL', "appsshoppy.com/career_souq/admin/");

define('APPLICATION_URL', "http://localhost/sybite/career_souq/admin/");
define('BASE_PATH',APPLICATION_URL);

/*define('APPLICATION_URL_ADMIN', APPLICATION_URL);*/
define('APPLICATION_URL_ADMIN', APPLICATION_URL);

define('CK_Edit', APPLICATION_URL.'ckeditor/'); 

define('IMAGES_URL', APPLICATION_URL.'images/');
define('CSS_URL', APPLICATION_URL.'css/');
define('JS_URL', APPLICATION_URL.'js/');


define('BANNER_IMG', APPLICATION_URL.'upload/banners/');
//print_r(BANNER_IMG);

define('CAT_IMG', APPLICATION_URL.'upload/category_banners/'); 

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

//print_r(APPLICATION_URL_ADMIN);
?>