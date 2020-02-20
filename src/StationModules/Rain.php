<?php

namespace Irekk\Netatmo\StationModules;

class Rain extends AbstractModule
{
    
    const RAIN = 'r';
    const RAIN_HOUR = 'rhour';
    const RAIN_DAY = 'rday';
    const BATTERY = 'b';
    
    public function __construct($data)
    {
        $this->setType($data['type']);
        $this->set(self::RAIN, $data['dashboard_data']['Rain']);
        $this->set(self::RAIN_HOUR, $data['dashboard_data']['sum_rain_1']);
        $this->set(self::RAIN_DAY, $data['dashboard_data']['sum_rain_24']);
        $this->set(self::UPDATE, $data['dashboard_data']['time_utc']);
        if (!empty($data['battery_percent'])) {
            $this->set(self::BATTERY, $data['battery_percent']);
        }
    }
}