<?php

namespace Irekk\Netatmo\StationModules;

abstract class AbstractModule
{
    
    const UPDATE = 'u';
        
    protected $type;
    protected $data = [];
    
    public function getType()
    {
        return $this->type;
    }
    
    public function setType($type)
    {
        $this->type = $type;
    }
    
    public function export()
    {
        return $this->data;
    }
    
    public function get($param)
    {
        return $this->data[$param] ?? null;
    }
    
    public function set($param, $value)
    {
        $this->data[$param] = $value;
    }
    
    public function getUpdate()
    {
        $ago = time() - $this->get(self::UPDATE);
        if ($ago < 60) return "{$ago} sekund(y) temu";
        if ($ago < 3600) return floor($ago / 60) . " minut(y) temu";
        if ($ago < 86400) return floor($ago / 3600) . " godzin(y) temu";
        return floor($ago / 86400) . " dni temu";
    }
}