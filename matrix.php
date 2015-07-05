<?php
define('RESET_POSITION', "\e[H\e[J");
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

class Layout
{
    public $row = [];
    public $heigh = 0;
    public $width = 0;
    private static $sleep_standard = 100000;
    private static $sleep;
    public function __construct()
    {
        self::$sleep = self::$sleep_standard;
    }

    public function setWidth($width)
    {
        if (intval($width) <= 0) {
            return;
        }
        $this->width = $width;
    }

    public function setHeight($heigh)
    {
        if (intval($heigh) <= 0) {
            return;
        }
        $this->heigh = $heigh;
    }

    private function adjustSleep() {
        if (self::$sleep == self::$sleep_standard / 10) {
            self::$sleep_standard /= 10;
        } elseif (self::$sleep == self::$sleep_standard * 10) {
            self::$sleep_standard *= 10;
        }
    }

    public function decreaseSleep()
    {
        $this->adjustSleep();
        self::$sleep += self::$sleep_standard / 10;
    }

    public function increaseSleep()
    {
        $this->adjustSleep();
        self::$sleep -= self::$sleep_standard / 10;
    }

    public function display()
    {
        echo RESET_POSITION;
        for ($heigh = 0; $heigh < $this->heigh; $heigh++) {
            if (!isset($this->row[$heigh])) {
                $this->row[$heigh] = new Row();
            }
            $this->row[$heigh]->setWidth($this->width);
            $this->row[$heigh]->display();
        }
        $this->growUp();
        usleep(self::$sleep);
    }

    private function growUp()
    {
        for ($i = $this->heigh - 1; $i > 0; $i--) {
            foreach ($this->row[$i]->cells as $key => &$cell) {
                if (!isset($this->row[$i - 1]->cells[$key]) or $this->row[$i - 1]->cells[$key]->dot == ' ') {  // 若上一列同一個位置是空白
                    $cell->dot = ' ';
                } elseif ($cell->dot == ' ') {                      // 上一列有值但這一列是空白
                    if (rand() % 10 > 7) {                          // 八成機率產生新值
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
                } else {                                            // 最後一行
                    if ($this->row and $cell->bright) {
                        $cell->color_code = $this->row[$i - 1]->cells[$key]->color_code;
                    }
                }
            }
        }

        // 處理第一行
        foreach ($this->row[0]->cells as $key => &$cell) {
            if ($this->row[1]->cells[$key]->dot == ' ') {

                // 當第二列為空值時 第一列產生新值的機率
                if (rand() % 10 > 5) {
                    $cell->setRandomAlphabet();
                }
            } elseif ($cell->dot != ' ') {

                // 當第二列有值 而第一列變成空值的機率
                if (rand() % 10 > 8 and $this->row[5]->cells[$key]->dot != ' ') {
                    $cell->dot = ' ';
                }
            }
        }
    }
}
// 取得當前長寬
exec('tput cols', $arr);
$width = $arr[0];

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
