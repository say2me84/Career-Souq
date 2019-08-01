<?php
$_CONFIG['environment'] = 'development';
define('APPLICATION_URL', "http://rbiltd.com/");			
define('APPLICATION_URL_ADMIN', "http://rbiltd.com/");

define('IMAGES_URL', APPLICATION_URL.'images/');
define('CSS_URL', APPLICATION_URL.'css/');
define('JS_URL', APPLICATION_URL.'js/');

define("ADMIN_EMAIL", "info@rbiltd.com");
define("MAIL_SITE_NAME", "info@rbiltd.com");
define("EMAIL_VERIFICATION_LINK", APPLICATION_URL."verify/activate?key=");
define("CLASS_VERIFICATION_LINK", APPLICATION_URL."verify/permission?key=");

//define('SCRIBD_API_KEY','5rq08nrxevxgk2xhpj7tj');
//define('SCRIBD_SECRET','sec-23v0o8s0cj3at3msr6pnqrmd9z');
//define('SCRIBD_PUB_ID','pub-60400982801528332357');

// Relative Paths.....
$_CONFIG['homeDir']				 = realpath(dirname(dirname(dirname(__FILE__)))).'/';

//print_r($_CONFIG['homeDir']);
?>