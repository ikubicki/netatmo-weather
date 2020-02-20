<?php

$config = null;

include 'vendor/autoload.php';
include 'config.php';

date_default_timezone_set("Europe/Warsaw");
header('Content-Encoding: UTF-8');

$auth = new Irekk\Netatmo\Auth($config);
$station = new Irekk\Netatmo\Station($config, $auth);
$modules = $station->getModulesData();

if (!empty($_GET['plain'])) {
    
    header('Content-Type: application/json');
    print json_encode([
        'outside' => $modules['NAModule1']->export(),
        'wind' => $modules['NAModule2']->export(),
        'rain' => $modules['NAModule3']->export(),
    ], JSON_PRETTY_PRINT);
}
else {
    $inside = $modules['NAMain'];
    $outside = $modules['NAModule1'];
    $wind = $modules['NAModule2'];
    $rain = $modules['NAModule3'];
    
    header('Content-Type: text/html');
    
    include 'tpl.php';
}