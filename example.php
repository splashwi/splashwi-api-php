<?php
/**
 * Splash-Wi API Example
 *
 * @author MenkMedia
 * @version v1.0
 * @compatibility Splash-Wi v3.0+
 * @homepage https://webinterface.us/
 * @license GNU GPL v3 (See https://www.gnu.org/licenses/gpl-3.0.de.html)
 */
require "SplashAPI.php";

$url = "http://localhost/splashwi-webinterface-master/api/externalauth";
$data = array(
    'auth' => array(
        'API_KEY' => 'BMfVSkiM2eJsn65a',
        'API_USERNAME' => 'apiuser',
        'API_PASSWORD' => 'BMQVSkiM2eJsx65a'
    ),
    'data' => array(
        'USERNAME' => 'admin',
        'PASSWORD' => 'admin'
    )
);
$api = new SplashAPI($url, true);
$response = $api->execute($data);