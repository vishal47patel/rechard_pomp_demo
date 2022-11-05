<?php
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

    if($_SERVER['SERVER_NAME'] == 'localhost' || $_SERVER['SERVER_NAME'] == '192.168.100.128' || $_SERVER['SERVER_NAME'] == 'nct128'){
        define("ENVIRONMENT", "d");//d- development, p- production
        define("DB_HOST", "localhost");
        define("DB_USER", "root");
        define("DB_PASS", "");
        define("DB_NAME", "autoservice_global");
        define("PROJECT_DIRECTORY_NAME", "");
        define('SITE_URL',  'https://'. $_SERVER["SERVER_NAME"] . '/autoservice_global/');
        define('ADMIN_URL', SITE_URL . 'admin-nct/');
        define('DIR_URL', $_SERVER["DOCUMENT_ROOT"] . '/autoservice_global/');

    }else{
        define("ENVIRONMENT", "p");//d- development, p- production
        define("DB_HOST", "localhost");
        define("DB_USER", "root");
        define("DB_PASS", "");
        define("DB_NAME", "autoserv_dbnm");
        define("PROJECT_DIRECTORY_NAME", "");
        define('SITE_URL',  $protocol. $_SERVER["SERVER_NAME"] . '/demo/');
        define('ADMIN_URL', SITE_URL . 'admin-nct/');
        define('DIR_URL', $_SERVER["DOCUMENT_ROOT"] . '/demo/');

    }
if(ENVIRONMENT == 'd' ){
    ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
error_reporting(0);
}else{
    ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
error_reporting(0);
}