<?php

namespace Irekk\Netatmo\Svg;

class Path extends AbstractObject
{
    
    protected $document;
    
    public function __construct(Document $document)
    {
        $this->document = $document;
    }
        
    public function render()
    {
        $attributes = [];
        
        foreach ($this->points as $i => $point) {
            
            $x = $point[0] * $this->document->getXMultiplier();
            $y = ($this->getMaxY() - $point[1]) * $this->document->getYMultiplier() + $this->document->getYOffset();
            $prefix = 'L ';
            $attributes[] = "$prefix$x $y";
        }
        return sprintf(
            '<path id="%s" d="M%s 0" style="stroke:%s;stroke-width:%d;fill:%s;opacity:%d%%" />' . "\r\n",
            $this->id,
            ltrim(implode(' ', $attributes), 'L'),
            $this->stroke,
            $this->stroke_width,
            $this->fill,
            $this->opacity
        );
    }
}
