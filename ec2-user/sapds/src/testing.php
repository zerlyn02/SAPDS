<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
echo "Including vendor/autoload.php\n"; 

require_once __DIR__ . '/../vendor/autoload.php';

use Google\Auth\OAuth2;

if (!class_exists('Google\Auth\OAuth2')) {
    echo 'OAuth2 class not found!';
}

$oauth = new OAuth2();
echo "OAuth2 class is loaded!";
