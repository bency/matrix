<?php
stream_set_blocking(STDIN, 0);
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
    public $dot = ' ';

    public function __construct($empty = false)
    {
        if (!$empty) {
            $this->setRandomAlphabet();
        }
    }

    public function getAscii()
    {
        return "\e[{$this->bright};{$this->color_code}m{$this->dot}\e[0m";
    }

    public function newRandomAlphabet()
    {
        $this->bright = 1;
        $this->color_code = 37;
        $rand = rand() % count(self::$alphabet);
        $this->dot = self::$alphabet[$rand];
    }

    public function setRandomAlphabet()
    {
        $this->bright = rand() % 2;
        $this->color_code = 32;
        $rand = rand() % count(self::$alphabet);
        $this->dot = self::$alphabet[$rand];
    }
}

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

    public function display()
    {
        for ($i = 0; $i < $this->width; $i++) {
            if (!isset($this->cells[$i])) {
                $this->cells[$i] = new Pixel(true);
            }
            echo $this->cells[$i]->getAscii();
        }
    }
}

// 取得寬度
exec('tput cols', $arr);
$width = $arr[0];

// 取得高度
exec('tput lines', $arr);
$heigh = $arr[1];

// 讓 STDIN 只讀取一個字元就輸出
system("stty -icanon time 1");

$layout = new Layout($heigh, $width);
$layout->setWidth($width);
$layout->setHeight($heigh);

while(1) {
    $c = fread(STDIN, 1);
    if (in_array($c, ['='])) {
        $layout->increaseSleep();
    } elseif (in_array($c, ['-'])) {
        $layout->decreaseSleep();
    }

    // 重設環境變數
    unset($envi_param);
    exec('tput cols', $envi_param);
    exec('tput lines', $envi_param);

    if ($envi_param[0] != $width) {
        $width = $envi_param[0];
        $layout->setWidth($width);
    }

    if (($envi_param[1]) != $heigh) {
        $heigh = $envi_param[1];
        $layout->setHeight($heigh);
    }
    $layout->display();
}
