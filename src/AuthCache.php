<?php

namespace Irekk\Netatmo;

class AuthCache
{
    
    const ACCESS_TOKEN = 't';
    const REFRESH_TOKEN = 'r';
    const EXPIRES = 'e';
    
    /**
     * @var string
     */
    protected $filename;
    
    /**
     * @var array
     */
    protected $params;
    
    /**
     *
     * @author ikubicki
     * @param string $filename
     */
    public function __construct($filename)
    {
        $this->filename = $filename;
        if (file_exists($this->filename)) {
            include $this->filename;
        }
        if (empty($this->params)) {
            $this->clear();
        }
    }
    
    /**
     *
     * @author ikubicki
     */
    public function __destruct()
    {
        $this->store();
    }
    
    /**
     *
     * @author ikubicki
     */
    public function store()
    {
        if (count($this->params)) {
            $content = '<?php' . PHP_EOL;
            $content .= '// cache generated at ' . date('Y-m-d H:i:s') . PHP_EOL;
            $content .= '$this->params = ' . var_export($this->params, true);
            $content .= ';' . PHP_EOL;
            file_put_contents($this->filename, $content);
        }
    }
    
    /**
     *
     * @author ikubicki
     */
    public function clear()
    {
        $this->params = [];
    }
    
    /**
     *
     * @author ikubicki
     * @return boolean
     */
    public function isLoaded()
    {
        return is_array($this->params) && count($this->params) > 0;
    }
    
    /**
     *
     * @author ikubicki
     * @return mixed
     */
    public function get($param)
    {
        return $this->params[$param] ?? false;
    }
    
    /**
     *
     * @author ikubicki
     * @param string $param
     * @param mixed $value
     */
    public function set($param, $value)
    {
        $this->params[$param] = $value;
    }
    
    /**
     * 
     * @author ikubicki
     * @return boolean
     */
    public function isExpired()
    {
        return $this->get(self::EXPIRES) < time() || empty($this->get(self::ACCESS_TOKEN));
    }
}