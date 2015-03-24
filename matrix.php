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
    public function __construct($width, $empty = false)
    {
        $this->width = $width;
        for ($i = 0; $i < $width; $i++) {
            $this->cells[$i] = new Pixel($empty);
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
        $row = new Row($width);
        foreach ($row->cells as $key => &$cell) {
            if ($cell->dot != ' ') {
                $cell->color_code = 37;
                $cell->bright = 1;
            }
        }
        $this->row[] = $row;
        for ($i = 1; $i < $heigh; $i++) {
            $this->row[] = new Row($width, true);
        }
    }

    public function display()
    {
        echo RESET_POSITION;
        $max = min($this->heigh, count($this->row));
        for ($heigh = 0; $heigh < $max; $heigh++) {
            $this->row[$heigh]->display();
        }
        $this->growUp();
        usleep(100000);
    }

    private function growUp()
    {
        for ($i = $this->heigh - 1; $i > 0; $i--) {
            foreach ($this->row[$i]->cells as $key => &$cell) {
                if ($this->row[$i - 1]->cells[$key]->dot == ' ') {  // 若上一列同一個位置是空白
                    $cell->dot = ' ';
                } elseif ($cell->dot == ' ') {                      // 上一列有值但這一列是空白
                    if (rand() % 10 > 5) {                          // 五成機率產生新值
                        // 將上一列上色
                        $this->row[$i - 1]->cells[$key]->color_code = 37;
                        $this->row[$i - 1]->cells[$key]->bright = 1;
                    } else {
                        // 產生新值
                        $this->row[$i - 1]->cells[$key]->color_code = 32;
                        $this->row[$i - 1]->cells[$key]->bright = rand() % 2;
                        $cell->newRandomAlphabet();
                    }
                } elseif ($i < $this->heigh - 1) {
                    if ($this->row[$i + 1]->cells[$key]->dot == ' ') {
                        $cell->bright = 1;
                        $cell->color_code = 37;
                    }
                }
            }
        }
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
