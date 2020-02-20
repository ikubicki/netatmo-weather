<?php

$config = null;

include '../vendor/autoload.php';
include '../config.php';

date_default_timezone_set("Europe/Warsaw");

$auth = new Irekk\Netatmo\Auth($config);
$storage = new Irekk\Netatmo\Storage($config);
$svg = new Irekk\Netatmo\Svg;

$type = null;
$content = null;
if (array_key_exists('wind', $_GET)) $type = 'wind';
if (array_key_exists('inside', $_GET)) $type = 'inside';
if (array_key_exists('outside', $_GET)) $type = 'outside';
if (array_key_exists('rain', $_GET)) $type = 'rain';
$multiplier_y = isset($_GET['ym']) && $_GET['ym'] > 0 ? intval($_GET['ym']) : 3;

switch ($type) {
    case 'wind':
        $content = $svg->renderWind($storage->getWind(), $multiplier_y);
        break;
    case 'inside':
        $content = $svg->renderUnit($storage->getInside(), $multiplier_y);
        break;
    case 'outside':
        $content = $svg->renderUnit($storage->getOutside(), $multiplier_y);
        break;
    case 'rain':
        $content = $svg->renderRain($storage->getRain(), $multiplier_y);
        break;
}

if ($content) {
    header('Content-Type: image/svg+xml');
    print $content;
}
else {
    header("HTTP/1.0 404 Not Found");
    exit;
}
