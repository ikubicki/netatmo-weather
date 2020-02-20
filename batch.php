<?php

$config = null;

include 'vendor/autoload.php';
include 'config.php';

$auth = new Irekk\Netatmo\Auth($config);
$station = new Irekk\Netatmo\Station($config, $auth);
$storage = new Irekk\Netatmo\Storage($config);
$modules = $station->getModulesData();

$storage->storeInside($modules['NAMain']);
$storage->storeOutside($modules['NAModule1']);
$storage->storeWind($modules['NAModule2']);
$storage->storeRain($modules['NAModule3']);