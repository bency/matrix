<?php
namespace Matrix;

class Row
{
    public $cells = [];
    public $width;
    public function __construct()
    {
    }

    public function setWidth($width)
    {
        if (intval($width) <= 0) {
            return;
        }
        $this->width = $width;
        for ($i = 0; $i < $this->width; $i++) {
            if (!isset($this->cells[$i])) {
                $this->cells[$i] = new Pixel(true);
            }
        }
    }

    public function display()
    {
        for ($i = 0; $i < $this->width; $i++) {
            echo $this->cells[$i]->getAscii();
        }
    }
}
