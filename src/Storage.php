<?php

namespace Irekk\Netatmo;

use SQLite3;

class Storage
{
    
    protected $config;
    
    public function __construct(Config $config)
    {
        $this->config = $config;
        $this->sqlite = new SQLite3($this->getDBFilename(), SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE);
        $this->sqlite->enableExceptions(true);
    }
    
    protected function getDBFilename()
    {
        $directory = dirname($this->config->get('storage'));
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }
        return $this->config->get('storage');
    }
    
    protected function createOutsideTable()
    {
        try {
            $this->sqlite->exec('CREATE TABLE IF NOT EXISTS t_outside(actual REAL, min REAL, max REAL, date INTEGER, updated INTEGER UNIQUE);');
            return true;
        }
        catch(\Throwable $t) {
            return false;
        }
    }
    
    protected function createInsideTable()
    {
        try {
            $this->sqlite->exec('CREATE TABLE IF NOT EXISTS t_inside(actual REAL, min REAL, max REAL, date INTEGER, updated INTEGER UNIQUE);');
            return true;
        }
        catch(\Throwable $t) {
            return false;
        }
    }
    
    protected function createRainTable()
    {
        try {
            $this->sqlite->exec('CREATE TABLE IF NOT EXISTS t_rain(actual REAL, hour REAL, day REAL, date INTEGER, updated INTEGER UNIQUE);');
            return true;
        }
        catch(\Throwable $t) {
            return false;
        }
    }

    protected function createWindTable()
    {
        try {
            $this->sqlite->exec('CREATE TABLE IF NOT EXISTS wind(actual INTEGER, gust INTEGER, max INTEGER, date INTEGER, updated INTEGER UNIQUE);');
            return true;
        }
        catch(\Throwable $t) {
            return false;
        }
    }
    
    public function storeRain(StationModules\Rain $rain)
    {
        $this->createRainTable();
        $values = sprintf(
            '(%f, %f, %f, %d, %d)',
            $rain->get($rain::RAIN),
            $rain->get($rain::RAIN_HOUR),
            $rain->get($rain::RAIN_DAY),
            $rain->get($rain::UPDATE),
            time()
        );
        try {
            return $this->sqlite->exec('INSERT INTO t_rain (actual, hour, day, updated, date) VALUES ' . $values);
        }
        catch(\Throwable $t) {
            return false;
        }
    }
    
    public function storeInside(StationModules\Unit $unit)
    {
        $this->createInsideTable();
        $values = sprintf(
            '(%f, %f, %f, %d, %d)',
            $unit->get($unit::TEMPERATURE),
            $unit->get($unit::TEMPERATURE_MIN),
            $unit->get($unit::TEMPERATURE_MAX),
            $unit->get($unit::UPDATE),
            time()
        );
        try {
            return $this->sqlite->exec('INSERT INTO t_inside (actual, min, max, updated, date) VALUES ' . $values);
        }
        catch(\Throwable $t) {
            return false;
        }
    }
    
    public function storeOutside(StationModules\Unit $unit)
    {
        $this->createOutsideTable();
        $values = sprintf(
            '(%f, %f, %f, %d, %d)',
            $unit->get($unit::TEMPERATURE),
            $unit->get($unit::TEMPERATURE_MIN),
            $unit->get($unit::TEMPERATURE_MAX),
            $unit->get($unit::UPDATE),
            time()
        );
        try {
            return $this->sqlite->exec('INSERT INTO t_outside (actual, min, max, updated, date) VALUES ' . $values);
        }
        catch(\Throwable $t) {
            return false;
        }
    }
    
    public function storeWind(StationModules\Wind $wind)
    {
        $this->createWindTable();
        $values = sprintf(
            '(%d, %d, %d, %d, %d)',
            $wind->get($wind::WIND),
            $wind->get($wind::WIND_GUST),
            $wind->get($wind::WIND_MAX),
            $wind->get($wind::UPDATE),
            time()
        );
        try {
            return $this->sqlite->exec('INSERT INTO wind (actual, gust, max, updated, date) VALUES ' . $values);
        }
        catch(\Throwable $t) {
            return false;
        }
    }
    
    public function getInside($iLimit = 100)
    {
        $results = [];
        $resultset = $this->sqlite->query('SELECT date , * FROM t_inside ORDER BY date DESC LIMIT ' . $iLimit);
        while(($row = $resultset->fetchArray(SQLITE3_ASSOC))) {
            $results[] = (object) $row;
        }
        $resultset->finalize();
    	krsort($results);
        return array_values($results);

    }
    
    public function getOutside($iLimit = 100)
    {
        $results = [];
        $resultset = $this->sqlite->query('SELECT date, * FROM t_outside ORDER BY date DESC LIMIT ' . $iLimit);
        while(($row = $resultset->fetchArray(SQLITE3_ASSOC))) {
            $results[] = (object) $row;
        }
        $resultset->finalize();
	    krsort($results);
        return array_values($results);
    }
    
    public function getWind($iLimit = 100)
    {
        $results = [];
        $resultset = $this->sqlite->query('SELECT date , * FROM wind ORDER BY date DESC LIMIT ' . $iLimit);
        while(($row = $resultset->fetchArray(SQLITE3_ASSOC))) {
            $results[] = (object) $row;
        }
        $resultset->finalize();
        krsort($results);
        return array_values($results);
    }
    
    public function getRain($iLimit = 100)
    {
        $results = [];
        $resultset = $this->sqlite->query('SELECT date , * FROM t_rain ORDER BY date DESC LIMIT ' . $iLimit);
        while(($row = $resultset->fetchArray(SQLITE3_ASSOC))) {
            $results[] = (object) $row;
        }
        $resultset->finalize();
        krsort($results);
        return array_values($results);
    }

}