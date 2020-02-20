<?php

namespace Irekk\Netatmo;

class Config
{
    
    private $options;
    
    public function __construct(array $options)
    {
        $this->options = $options;
    }
    
    public function get($option)
    {
        return $this->options[$option] ?? null;
    }
}
