<html>
	<head>
		<title>Smolecka pogodynka</title>
		<link rel="stylesheet" type="text/css" href="assets/style.css" />
	</head>
	<body>
		<h1>Smolec, Gruszkowa</h1>
		<h2>Aktualizacja <?php echo $inside->getUpdate() ?></h2>
        <div class="module outside" style="background-image: url(svg/index.php?outside)">
        	<h1>Temp. zewnętrzna <b><?php echo $outside->get($outside::TEMPERATURE) ?> &deg;C</b><sup class="min"><?php echo $outside->get($outside::TEMPERATURE_MIN) ?> &deg;C</sup><sup class="max"><?php echo $outside->get($outside::TEMPERATURE_MAX) ?> &deg;C</sup></h1>
        	<h2>Ciśnienie <b><?php echo $outside->get($outside::PRESSURE) ?> hPa</b></h2>
        	<h3>Wilgotność <b><?php echo $outside->get($outside::HUMIDITY) ?>%</b></h3>
        	<br />
        </div>
        <div class="module wind" style="background-image: url(svg/index.php?wind)">
        	<h1>Wiatr <b><?php echo $wind->get($wind::WIND) ?> km/h</b> w porywach do <?php echo $wind->get($wind::WIND_GUST) ?> km/h<sup class="max"><?php echo $wind->get($wind::WIND_MAX) ?> km/h</sup></h1>
        	<h2>Kierunek <b><?php echo $wind->get($wind::ANGLE) ?>&deg;</b></h2>
        	<br />
        </div>
        <div class="module rain" style="background-image: url(svg/index.php?rain&ym=2)">

        	<h1>
        		<?php echo $rain->get($rain::RAIN) ? sprintf('Opady %.1f mm', $rain->get($rain::RAIN)) : 'Brak aktualnie opadów' ?>
    			<h2><?php echo $rain->get($rain::RAIN_HOUR) ? sprintf('%.1f mm w przeciągu godziny', round($rain->get($rain::RAIN_HOUR), 1)) : 'Brak opadów w przeciągu godziny' ?></h2>
        		<h3><?php echo $rain->get($rain::RAIN_DAY) ? sprintf('%.1f mm w przeciągu doby', round($rain->get($rain::RAIN_DAY), 1)) : 'Brak opadów w przeciągu doby' ?></h3>
        	</h1>
        	<br />
        </div>
        <div class="module inside" style="background-image: url(svg/index.php?inside&ym=7)">
        	<h1>Temp. wewnętrzna <b><?php echo $inside->get($inside::TEMPERATURE) ?> &deg;C</b><sup class="min"><?php echo $inside->get($inside::TEMPERATURE_MIN) ?> &deg;C</sup><sup class="max"><?php echo $inside->get($inside::TEMPERATURE_MAX) ?> &deg;C</sup></h1>
        	<h2>Wilgotność <b><?php echo $inside->get($inside::HUMIDITY) ?>%</b></h2>
        	<br />
        </div>
        <p class="footer">Powered by <a href="https://www.netatmo.com/pl-pl"><img src="assets/netatmo.png" alt="Netatmo" /></a></p>
	</body>
</html>