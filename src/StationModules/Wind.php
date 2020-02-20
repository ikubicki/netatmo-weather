<?php

namespace Irekk\Netatmo\StationModules;

class Wind extends AbstractModule
{
    
    const WIND = 'w';
    const WIND_GUST = 'g';
    const WIND_MAX = 'wmax';
    const ANGLE = 'a';
    const BATTERY = 'b';
    
    public function __construct($data)
    {
        $this->setType($data['type']);
        $this->set(self::WIND, $data['dashboard_data']['WindStrength']);
        $this->set(self::WIND_GUST, $data['dashboard_data']['GustStrength']);
        $this->set(self::WIND_MAX, $data['dashboard_data']['max_wind_str']);
        $this->set(self::ANGLE, $data['dashboard_data']['WindAngle']);
        $this->set(self::UPDATE, $data['dashboard_data']['time_utc']);
        if (!empty($data['battery_percent'])) {
            $this->set(self::BATTERY, $data['battery_percent']);
        }
    }
}