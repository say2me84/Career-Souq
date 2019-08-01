<?php
$_CONFIG['environment'] = 'development';
define('APPLICATION_URL', "http://appsshoppy.com/career_souq/");	
define('BASE_PATH', APPLICATION_URL);

define('APPLICATION_URL_ADMIN', "http://appsshoppy.com/career_souq/admin/");
//echo APPLICATION_URL_ADMIN; 

define('ADMIN_IMG', APPLICATION_URL_ADMIN.'upload/');

define('IMAGES_URL', APPLICATION_URL.'images/');
define('CSS_URL', APPLICATION_URL.'css/');
define('JS_URL', APPLICATION_URL.'js/');
define('JPICKER', APPLICATION_URL.'jPicker/');

define('ASSET_CSS', APPLICATION_URL.'asset/css/');
define('ASSET_JS', APPLICATION_URL.'asset/js/');
define('ASSET_IMG', APPLICATION_URL.'asset/Images/');

define('Upload_Resume', APPLICATION_URL.'upload/Upload_Resume/');

define('FCK', APPLICATION_URL.'fck_editer/');
define('FCK_IMG', APPLICATION_URL.'fck_editer/images/');
define('USER_PIC', APPLICATION_URL.'upload/User_pic/');

define('PDF', APPLICATION_URL.'Pdf/');
//====================== ADMIN Config URL ===================================================
//define('APPLICATION_URL_ADMIN', "http://localhost/sybite/jobportal/admin/");

define('APPLICATION_URL_ADMIN', APPLICATION_URL."admin/");
define('BASE_PATH_ADMIN', "/sybite/zend/admin/");

define('IMAGES_URL_ADMIN', APPLICATION_URL_ADMIN.'images/');
define('CSS_URL_ADMIN', APPLICATION_URL_ADMIN.'css/');
define('JS_URL_ADMIN', APPLICATION_URL_ADMIN.'js/');

//==================== Image Paths ==========================================================//

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

//print_r(ADMIN_IMG);

?>