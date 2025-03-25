<?php

if (!defined('ENVIRONMENT'))
    define('ENVIRONMENT', 'pre_installation');

$domain = $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'];
$domain = preg_replace('/index.php.*/', '', $domain);
if (!empty($_SERVER['HTTPS'])) {
    $domain = 'https://' . $domain;
} else {
    $domain = 'http://' . $domain;
}


$hostname = "***";
$username = "***";
$password = "***";
$database = "***";


$admin_email = "****";
$company_email = "****";
