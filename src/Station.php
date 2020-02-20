<?php

namespace Irekk\Netatmo;

class Station
{
    
    const NETATMO_STATIONDATA_URL = 'https://api.netatmo.com/api/getstationsdata';
    
    protected $auth;
    
    public function __construct(Config $config, Auth $auth)
    {
        $this->auth = $auth;
        $this->config = $config;
    }
    
    public function getData()
    {
        
        $cache = $this->createStationCache();
        
        if (!$this->config->get('refresh') && $cache->isLoaded()) {
            return $cache->getData();
        }
        
        $cache->clear();
        
        $url = self::NETATMO_STATIONDATA_URL;
        if ($this->config->get('device_id')) {
            $url = self::NETATMO_STATIONDATA_URL . '?device_id=' . $this->config->get('device_id');
        }
        $http = new NotGuzzle;
        $response = $http->getJson($url, [
            'Authorization: Bearer ' . $this->auth->getToken()
        ]);
        
        $cache->setData($response);
        $cache->store();
        
        return $response;
    }
    
    public function getModulesData()
    {
        $data = $this->getData();
        $device = $data['body']['devices'][0];
        $result = [
            'NAMain' => new StationModules\Unit($device),
        ];
        
        foreach($device['modules'] as $moduleData) {
            $moduleInstance = $this->createModuleInstance($moduleData);
            $result[$moduleInstance->getType()] = $moduleInstance;
            if ($moduleInstance->getType() == 'NAModule1') {
                $moduleInstance->set(StationModules\Unit::PRESSURE, $result['NAMain']->get(StationModules\Unit::PRESSURE));
            }
        }
        return $result;
    }
    
    protected function createModuleInstance(array $moduleData)
    {
        switch($moduleData['type']) {
            case 'NAModule1':
                return new StationModules\Unit($moduleData);
            case 'NAModule2':
                return new StationModules\Wind($moduleData);
            case 'NAModule3':
                return new StationModules\Rain($moduleData);
        }
    }
    
    protected function createStationCache()
    {
        if (!file_exists($this->config->get('cache'))) {
            mkdir($this->config->get('cache'), 0777, true);
        }
        return new StationCache($this->config->get('cache') . '/station.' . md5_file(__FILE__) . '.php');
    }
}