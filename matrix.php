<?php
define('RESET_POSITION', "\e[H\e[J");
class Pixel
{
    static public $alphabet = [
        ' ','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z',
        'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z',' ',
        ' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',
        ' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' '
    ];
    public $color_code = 32;  // 31 ~ 37
    public $bright = 1;
    public $dot = '';

    public function __construct()
    {
        $this->setRandomAlphabet();
    }

    public function getAscii()
    {
        return "\e[{$this->bright};{$this->color_code}m{$this->dot}\e[0m";
    }

    public function setRandomAlphabet()
    {
        $this->bright = rand() % 2;
        $rand = rand() % count(self::$alphabet);
        $this->dot = self::$alphabet[$rand];
    }
}

class Row
{
    public $cells = [];
    public $width;
    public function __construct($width)
    {
        $this->width = $width;
        for ($i = 0; $i < $width; $i++) {
            $this->cells[$i] = new Pixel;
        }
    }

    public function display()
    {
        for ($i = 0; $i < $this->width; $i++) {
            echo $this->cells[$i]->getAscii();
        }
        echo PHP_EOL;
    }
}

class Layout
{
    public $row = [];
    public $heigh = 0;
    public $width = 0;
    public function __construct($heigh, $width)
    {
        $this->heigh = $heigh;
        $this->width = $width;
    }

    public function display()
    {
        echo RESET_POSITION;
        $this->addRow();
        $max = count($this->row);
        for ($heigh = $max - 1; $heigh >= 0; $heigh--) {
            $this->row[$heigh]->display();
        }
        sleep(1);
    }

    private function addRow()
    {
        $new = new Row($this->width);
        if ($last_key = count($this->row)) {
            $last = $this->row[$last_key - 1];
            foreach ($new->cells as $key => &$cell) {
                if ($last->cells[$key]->dot == '') {
                    $cell->color_code = 37;
                    $cell->bright = 1;
                }
            }
        } else {
            foreach ($new->cells as $key => &$cell) {
                $cell->color_code = 37;
                $cell->bright = 1;
            }
        }
        $this->row[] = $new;
    }
}
// 取得當前長寬
exec('tput cols', $arr);
exec('tput lines', $arr);
$width = $arr[0];
$heigh = $arr[1] - 1;
$layout = new Layout($heigh, $width);

while(1) {
    $layout->display();
}
