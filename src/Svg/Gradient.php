<?php

namespace Irekk\Netatmo\Svg;

class Gradient extends AbstractObject
{
    
    public $start = 25;
    public $end = 100;
    
    public function render()
    {
        return '<defs>' .
            sprintf('<linearGradient id="%s" x1="0%%" y1="0%%" x2="100%%" y2="0%%">', $this->id) .
            sprintf('<stop offset="%d%%" stop-color="%s"/>', $this->start, $this->fill) .
            sprintf('<stop offset="%d%%" stop-color="%s"/>', $this->end, $this->stroke) .
            '</linearGradient>' .
            '</defs>' . "\r\n";
    }
    
    public function __toString()
    {
        return "url(#$this->id)";
    }
}