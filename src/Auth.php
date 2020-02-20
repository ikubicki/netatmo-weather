<?php

namespace Irekk\Netatmo;

class Auth
{
    
    const NETATMO_AUTH_URL = 'https://api.netatmo.net/oauth2/token';
    
    /**
     * @var Config
     */
    protected $config;
    
    /**
     * @var string
     */
    protected $token;
    
    /**
     * 
     * @author ikubicki
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }
    
    /**
     * 
     * @author ikubicki
     * @return string
     */
    public function getToken()
    {
        if ($this->token) {
            return $this->token;
        }
        $cache = $this->createAuthCache();
        if (!$cache->isLoaded() || $cache->isExpired()) {
            $http = new NotGuzzle;
            $response = $http->postJson(
                self::NETATMO_AUTH_URL,
                [
                    'grant_type' => 'password',
                    'scope' => 'read_station',
                    'client_id' => $this->config->get('client_id'),
                    'client_secret' => $this->config->get('client_secret'),
                    'username' => $this->config->get('username'),
                    'password' => $this->config->get('password'),
                ]
            );
            $cache->clear();
            $cache->set($cache::ACCESS_TOKEN, $response['access_token']);
            $cache->set($cache::REFRESH_TOKEN, $response['refresh_token']);
            $cache->set($cache::EXPIRES, time() + $response['expires_in'] - 1000);
            $cache->store();
        }
        return $this->token = $cache->get($cache::ACCESS_TOKEN);
    }
    
    /**
     * 
     * @author ikubicki
     * @return AuthCache
     */
    protected function createAuthCache()
    {
        if (!file_exists($this->config->get('cache'))) {
            mkdir($this->config->get('cache'), 0777, true);
        }
        return new AuthCache($this->config->get('cache') . '/auth.' . md5_file(__FILE__) . '.php');
    }
}