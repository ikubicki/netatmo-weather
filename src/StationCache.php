<?php

namespace Irekk\Netatmo;

class StationCache
{
    
    /**
     * @var string
     */
    protected $filename;
    
    /**
     * @var array
     */
    protected $data;
    
    /**
     * @var array
     */
    protected $expires;
    
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
        if (empty($this->data)) {
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
        if (count($this->data)) {
            $content = '<?php' . PHP_EOL;
            $content .= '// cache generated at ' . date('Y-m-d H:i:s') . PHP_EOL;
            $content .= '$this->data = ' . var_export($this->data, true);
            $content .= ';' . PHP_EOL;
            $content .= '$this->expires = ' . $this->expires;
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
        $this->data = null;
        $this->expires = time() + 870;
    }
    
    /**
     *
     * @author ikubicki
     * @return boolean
     */
    public function isLoaded()
    {
        return $this->data && $this->expires > time();
    }
    
    /**
     *
     * @author ikubicki
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }
    
    /**
     *
     * @author ikubicki
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }
}