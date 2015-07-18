<?php
namespace Matrix;

define('RESET_POSITION', "\e[H\e[J");
class Layout
{
    public $row = [];
    public $heigh = 0;
    public $width = 0;
    private $new_row_ratio = 50;
    private $empty_row_ratio = 80;
    private static $sleep_standard = 100000;
    private static $sleep;
    public function __construct()
    {

        // 讓 STDIN 只讀取一個字元就輸出
        system("stty -icanon time 1");

        // STDIN 沒東西就略過
        stream_set_blocking(STDIN, 0);
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

    public function decreaseEmptyRowProperty()
    {
        if ($this->empty_row_ratio > 1) {
            $this->empty_row_ratio --;
        }
    }

    public function increaseEmptyRowProperty()
    {
        if ($this->empty_row_ratio < 100) {
            $this->empty_row_ratio ++;
        }
    }

    public function decreaseNewRowProperty()
    {
        if ($this->new_row_ratio > 1) {
            $this->new_row_ratio --;
        }
    }

    public function increaseNewRowProperty()
    {
        if ($this->new_row_ratio < 100) {
            $this->new_row_ratio ++;
        }
    }

    public function display($debug_mode = false)
    {
        echo RESET_POSITION;
        for ($heigh = 0; $heigh < $this->heigh; $heigh++) {
            if (!isset($this->row[$heigh])) {
                $this->row[$heigh] = new Row();
            }
            $this->row[$heigh]->setWidth($this->width);
            $ignore_last = '';
            if ($heigh == $this->heigh - 1 and $debug_mode) {
                $ignore_last = substr(
                    sprintf(
                        "width: %s, heigh: %s, new_row_ratio: %s, empty_row_ratio: %s",
                        $this->width,
                        $this->heigh,
                        $this->new_row_ratio,
                        $this->empty_row_ratio
                    ),
                    0,
                    $this->width
                );
            }
            $this->row[$heigh]->display($ignore_last);
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
                if (rand() % 100 > $this->new_row_ratio) {
                    $cell->setRandomAlphabet();
                }
            } elseif ($cell->dot != ' ') {

                // 當第二列有值 而第一列變成空值的機率
                if (rand() % 100 > $this->empty_row_ratio and $this->row[5]->cells[$key]->dot != ' ') {
                    $cell->dot = ' ';
                }
            }
        }
    }

    private function captureKeyStroke()
    {
        return fread(STDIN, 1);
    }

    public function run()
    {
        while(1) {

            $c = $this->captureKeyStroke();
            if (in_array($c, ['='])) {
                $this->increaseSleep();
            } elseif (in_array($c, ['-'])) {
                $this->decreaseSleep();
            } elseif (in_array($c, ['q'])) {
                break;
            } elseif (in_array($c, ['1'])) {
                $this->increaseNewRowProperty();
            } elseif (in_array($c, ['2'])) {
                $this->decreaseNewRowProperty();
            } elseif (in_array($c, ['z'])) {
                $this->increaseEmptyRowProperty();
            } elseif (in_array($c, ['x'])) {
                $this->decreaseEmptyRowProperty();
            }

            // 重設環境變數
            unset($envi_param);
            exec('tput cols', $envi_param);
            exec('tput lines', $envi_param);

            if ($envi_param[0] != $width) {
                $width = $envi_param[0];
                $this->setWidth($width);
            }

            if (($envi_param[1]) != $heigh) {
                $heigh = $envi_param[1];
                $this->setHeight($heigh);
            }
            $this->display();
        }
    }
}
