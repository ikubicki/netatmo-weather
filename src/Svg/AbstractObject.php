<?php

namespace Irekk\Netatmo\Svg;

abstract class AbstractObject
{
    public $stroke;
    public $stroke_width = 1;
    public $fill = 'none';
    public $opacity = 100;
    public $points = [];
    public $multiplier_x = 20;
    public $multiplier_y = 3;
    public $min_x;
    public $max_x;
    public $min_y;
    public $max_y;
    public $id = '';
    public $offset_y;
    
    abstract function render();
    
    public function getYOffset()
    {
        return $this->offset_y;
    }
    
    public function addPoint($x, $y)
    {
        $this->points[] = [$x, $y];
    }
    
    public function getMinY()
    {
        if ($this->min_y === null) {
            $this->min_y = 99999999;
            foreach($this->points as $point) {
                if ($this->min_y > $point[1]) {
                    $this->min_y = $point[1];
                }
            }
        }
        return $this->min_y;
    }
    
    public function getMaxY()
    {
        if ($this->max_y === null) {
            $this->max_y = 0;
            foreach($this->points as $point) {
                if ($this->max_y < $point[1]) {
                    $this->max_y = $point[1];
                }
            }
        }
        return $this->max_y;
    }
    
    public function getMinX()
    {
        if ($this->min_x === null) {
            $this->min_x = 99999999;
            foreach($this->points as $point) {
                if ($this->min_x > $point[0]) {
                    $this->min_x = $point[0];
                }
            }
        }
        return $this->min_x;
    }
    
    public function getMaxX()
    {
        if ($this->max_x === null) {
            $this->max_x = 0;
            foreach($this->points as $point) {
                if ($this->max_x < $point[0]) {
                    $this->max_x = $point[0];
                }
            }
        }
        return $this->max_x;
    }
    
    public function getXMultiplier()
    {
        return $this->multiplier_x;
    }
    
    public function getYMultiplier()
    {
        return $this->multiplier_y;
    }
}
