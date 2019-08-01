<?php

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/application'));
set_time_limit(0); 
	ini_set('session.gc_maxlifetime', '288000000');
	ini_set('max_execution_time', '20000000');
	ini_set('max_input_time', '1000000');
// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path(),
)));

/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);
//$mySessionFront = new Zend_Session_Namespace('default');
$mySessionFront = new Zend_Session_Namespace('true');
$mySession = new Zend_Session_Namespace('false'); 

$application->bootstrap()
            ->run();