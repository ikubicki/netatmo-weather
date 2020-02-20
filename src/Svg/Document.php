<?php

namespace Irekk\Netatmo\Svg;

class Document extends AbstractObject
{
    public $objects = [];
    public $gradients = [];
    
    public function getMinX()
    {
        if ($this->min_x === null) {
            $this->min_x = 9999999;
            foreach($this->objects as $object) {
                $min = $object->getMinX();
                if ($this->min_x > $min) {
                    $this->min_x = $min;
                }
            }
        }
        return $this->min_x;
    }
    
    public function getMaxX()
    {
        if ($this->max_x === null) {
            $this->max_x = 0;
            foreach($this->objects as $object) {
                $max = $object->getMaxX();
                if ($this->max_x < $max) {
                    $this->max_x = $max;
                }
            }
        }
        return $this->max_x;
    }
    
    public function getMinY()
    {
        if ($this->min_y === null) {
            $this->min_y = 9999999;
            foreach($this->objects as $object) {
                $min = $object->getMinY();
                if ($this->min_y > $min) {
                    $this->min_y = $min;
                }
            }
        }
        return $this->min_y;
    }
    
    public function getMaxY()
    {
        if ($this->max_y === null) {
            $this->max_y = 0;
            foreach($this->objects as $object) {
                $max = $object->getMaxY();
                if ($this->max_y < $max) {
                    $this->max_y = $max;
                }
            }
        }
        return $this->max_y;
    }
    
    public function createPolygon(): Polygon
    {
        $polygon = new Polygon($this);
        $this->objects[] = $polygon;
        return $polygon;
    }
    
    public function createPath(): Path
    {
        $path = new Path($this);
        $this->objects[] = $path;
        return $path;
    }
    
    public function createGradient($gradientId): Gradient
    {
        $gradient = new Gradient;
        $gradient->id = $gradientId;
        return $this->gradients[$gradientId] = $gradient;
    }
    
    public function render()
    {
        $width = $this->getMaxX() * $this->getXMultiplier();
        $height = ($this->getMaxY() - $this->getMinY()) * $this->getYMultiplier();
        $content = '<?xml version="1.0" encoding="UTF-8"?>' . "\r\n";
        $content .= '<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">' . "\r\n";
        $content .= sprintf(
            '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="%d" height="%d">' . "\r\n",
            $width,
            $height +  + $this->getYOffset() * 2
        );
        
        foreach ($this->gradients as $gradient) {
            $content .= $gradient->render();
        }
        
        foreach ($this->objects as $object) {
            $content .= $object->render();
        }
        
        $content .= '</svg>';
        return $content;
    }
}
