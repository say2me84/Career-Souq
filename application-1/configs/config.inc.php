<?php
$_CONFIG['environment'] = 'development';
define('APPLICATION_URL', "//localhost/sybite/career_souq/");

//define('APPLICATION_URL', "http://appsshoppy.com/career_souq/");
	
define('BASE_PATH', APPLICATION_URL);

define('APPLICATION_URL_ADMIN', "//localhost/sybite/career_souq/admin/");
define('ADMIN_PIC', APPLICATION_URL.'admin/upload/');

								  
define('IMAGES_URL', APPLICATION_URL.'images/');
define('CSS_URL', APPLICATION_URL.'css/');
define('JS_URL', APPLICATION_URL.'js/');
define('JPICKER', APPLICATION_URL.'jPicker/');

define('COLOR', APPLICATION_URL.'Color_master/');
// ================== Our Top Featured Employeers ===================//
define('ASSET_CSS', APPLICATION_URL.'asset/css/');
define('ASSET_JS', APPLICATION_URL.'asset/js/');
define('ASSET_IMG', APPLICATION_URL.'asset/Images/');
// ================== Our Top Featured Employeers ===================//

define('Upload_Resume', APPLICATION_URL.'upload/Upload_Resume/');

define('CK_Edit', APPLICATION_URL.'ckeditor/'); 

define('PDF', APPLICATION_URL.'Pdf/');
define('PDF_CRT', APPLICATION_URL.'Pdf/examples/user_pdf.php');
//====================== ADMIN Config URL ===================================================
define('ADMIN_USR_IMG', APPLICATION_URL_ADMIN.'upload/user_pic/');

//print_r(ADMIN_USR_IMG);

define('ADMIN_IMG', APPLICATION_URL_ADMIN.'upload/');

define('ADMIN_IMAGES', APPLICATION_URL_ADMIN.'images/');
define('ADMIN_CSS', APPLICATION_URL_ADMIN.'css/');
define('ADMIN_JS', APPLICATION_URL_ADMIN.'js/');

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
