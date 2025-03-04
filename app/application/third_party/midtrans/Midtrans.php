<?php

require_once __DIR__ . '/Config.php';
require_once __DIR__ . '/Snap.php';
require_once __DIR__ . '/CoreApi.php';
require_once __DIR__ . '/Transaction.php';

class Midtrans {
    public function __construct() {
        \Midtrans\Config::$serverKey = config_item('midtrans_server_key');
        \Midtrans\Config::$isProduction = config_item('midtrans_production');
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;
    }
}

/** 
 * Check PHP version.
 */
if (version_compare(PHP_VERSION, '5.4', '<')) {
    throw new Exception('PHP version >= 5.4 required');
}

// Check PHP Curl & json decode capabilities.
if (!function_exists('curl_init') || !function_exists('curl_exec')) {
    throw new Exception('Midtrans needs the CURL PHP extension.');
}
if (!function_exists('json_decode')) {
    throw new Exception('Midtrans needs the JSON PHP extension.');
}

// Configurations
require_once 'Midtrans/Config.php';

// Midtrans API Resources
require_once 'Midtrans/Transaction.php';

// Plumbing
require_once 'Midtrans/ApiRequestor.php';
require_once 'Midtrans/Notification.php';
require_once 'Midtrans/CoreApi.php';
require_once 'Midtrans/Snap.php';

// Sanitization
require_once 'Midtrans/Sanitizer.php';
