<?php

/* This is the error page that will be displayed for TRICKY USERS.
 * This page is set in the .htaccess file.
 * For the rest of the users, you can set your own custom 404 page.
 */
define('IMVC_BASE_PATH', realpath(dirname(__FILE__).'/../../../').'/');

require(IMVC_BASE_PATH.'sys-core/Util.php');
require(IMVC_BASE_PATH.'sys-config/sys.constants.php');
require(IMVC_BASE_PATH . 'sys-core/IrisException.php');
require(IMVC_BASE_PATH.'sys-core/Logger.php');
require(IMVC_BASE_PATH.'sys-core/FileLogger.php');
require(IMVC_BASE_PATH.'sys-core/IrisLogger.php');

IrisLogger::registerLogger('file', new FileLogger(IMVC_BAD_LOG_FILE_PATH, IMVC_LOGGER_LEVEL_WARN));

$ip = Util::getIp();
$url = $_SERVER['REQUEST_URI'];
IrisLogger::warn("$ip requested: $url");

echo 'Well, hello there! Looking for something? ;-)';

sleep(15); //#! may the request timeout...
exit;