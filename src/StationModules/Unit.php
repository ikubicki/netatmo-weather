<?php

namespace Irekk\Netatmo\StationModules;

class Unit extends AbstractModule
{
    
    const TEMPERATURE = 't';
    const HUMIDITY = 'h';
    const TEMPERATURE_MIN = 'tmin';
    const TEMPERATURE_MAX = 'tmax';
    const BATTERY = 'b';
    const PRESSURE = 'p';
    
    public function __construct($data)
    {
        $this->setType($data['type']);
        $this->set(self::TEMPERATURE, $data['dashboard_data']['Temperature']);
        $this->set(self::HUMIDITY, $data['dashboard_data']['Humidity']);
        $this->set(self::TEMPERATURE_MIN, $data['dashboard_data']['min_temp']);
        $this->set(self::TEMPERATURE_MAX, $data['dashboard_data']['max_temp']);
        $this->set(self::UPDATE, $data['dashboard_data']['time_utc']);
        if (!empty($data['battery_percent'])) {
            $this->set(self::BATTERY, $data['battery_percent']);
        }
        if (!empty($data['dashboard_data']['Pressure'])) {
            $this->set(self::PRESSURE, $data['dashboard_data']['Pressure']);
        }
    }
}