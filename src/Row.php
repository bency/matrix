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
    }

    public function display($debug_message = '')
    {
        for ($i = 0; $i < $this->width; $i++) {
            if (!isset($this->cells[$i])) {
                $this->cells[$i] = new Pixel(true);
            }
            if ('' == $debug_message) {
                echo $this->cells[$i]->getAscii();
            }
        }
        if ('' != $debug_message) {
            echo $debug_message;
        }
    }
}
