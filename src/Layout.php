<?php
namespace Matrix;

define('RESET_POSITION', "\e[H\e[J");
class Layout
{
    public $row = [];
    public $heigh = 0;
    public $width = 0;
    public static $color_style = 0;
    public static $marquee_offset = 0;
    private $new_row_ratio = 50;
    private $empty_row_ratio = 80;
    private $min_rain_length = 15;
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

    public function decreaseMinRainLength()
    {
        if ($this->min_rain_length > 0) {
            $this->min_rain_length--;
        }
    }

    public function increaseMinRainLength()
    {
        if ($this->min_rain_length < $this->heigh) {
            $this->min_rain_length++;
        }
    }

    public function display($debug_mode = false)
    {
        echo RESET_POSITION;
        for ($heigh = 0; $heigh < $this->heigh - 1; $heigh++) {
            if (!isset($this->row[$heigh])) {
                $this->row[$heigh] = new Row();
            }
            $this->row[$heigh]->setWidth($this->width);
            $this->row[$heigh]->display();
        }

        $ignore_last = '';
        if ($debug_mode) {
            $ignore_last = substr(
                sprintf(
                    "fps: %s, W: %s, H: %s, NRR: %s, ERR: %s, MRL: %s",
                    number_format(1000000 / self::$sleep, 2),
                    $this->width,
                    $this->heigh,
                    $this->new_row_ratio,
                    $this->empty_row_ratio,
                    $this->min_rain_length
                ),
                0,
                $this->width
            );
        }
        if (!isset($this->row[$heigh])) {
            $this->row[$heigh] = new Row();
        }
        $this->row[$heigh]->setWidth($this->width);
        $this->row[$heigh]->display($ignore_last);
        $this->growUp();
        usleep(self::$sleep);
    }

    private function getColors()
    {
        return Pixel::$color_256[self::$color_style];
    }

    private function growUp(array $options = [])
    {
        $marquee = null;
        if (isset($options['wording']) and strlen($options['wording']) > 0) {
            $marquee = Alphabet::getString($options['wording']);
        }

        if (isset($options['shift']) and $options['shift']) {
            self::$marquee_offset = (self::$marquee_offset - 1) % $this->width;
        }
        for ($i = $this->heigh - 1; $i > 0; $i--) {

            foreach ($this->row[$i]->cells as $key => &$cell) {

                if (!isset($this->row[$i - 1]->cells[$key]) or $this->row[$i - 1]->cells[$key]->dot == ' ') {
                    $cell->dot = ' ';
                } elseif ($cell->dot == ' ') {                      // 上一列有值但這一列是空白
                    if (rand() % 10 > 7) {                          // 八成機率產生新值
                        // 已經不知道為什麼需要這一行了
                        $this->row[$i - 1]->cells[$key]->color_code = 92;
                    } else {
                        // 產生新值
                        $this->row[$i - 1]->cells[$key]->color_code = 1;
                        $cell->newRandomAlphabet();
                    }
                    for ($j = $i - 1, $k = count($this->getColors()) - 1; isset($this->row[$j]); $j--) {

                        if (isset($options['shift']) and $options['shift']) {
                            $offset = ($key - self::$marquee_offset) % (count($marquee[0]) + 5);
                        } else {
                            $offset = ($key - self::$marquee_offset);
                        }
                        if ($marquee and isset($marquee[$j - ($this->heigh) / 2 + 2][$offset]) and $marquee[$j - ($this->heigh) / 2 + 2][$offset]) {
                            $this->row[$j]->cells[$key]->is_wording = true;
                        } else {
                            $this->row[$j]->cells[$key]->is_wording = false;
                        }
                        $c = max($k--, 0);
                        $this->row[$j]->cells[$key]->color_code = $this->getColors()[$c];
                    }
                } elseif ($i < $this->heigh - 1) {
                    if ($this->row[$i + 1]->cells[$key]->dot == ' ') {
                        $cell->color_code = 15;
                    }
                } else {                                            // 最後一行
                    if ($this->row) {
                        $cell->color_code = $this->row[$i - 1]->cells[$key]->color_code;
                    }
                }
            }
        }

        // 處理第一行
        foreach ($this->row[0]->cells as $key => &$cell) {
            if ($this->row[1]->cells[$key]->dot == ' ') {

                // 當第二列為空值時 第一列產生新值的機率
                if (rand() % 100 < $this->new_row_ratio) {
                    $cell->setRandomAlphabet();
                }
            } elseif ($cell->dot != ' ') {

                // End rain by the probability of empty_row_ratio
                // after growing longer than min_rain_length
                $long_enough = true;
                for ($i = 1; $i <= $this->min_rain_length; $i++) {
                    if (!isset($this->row[$i]) or ' ' == $this->row[$i]->cells[$key]->dot) {
                        $long_enough = false;
                    }
                }
                if ((rand() % 100 < $this->empty_row_ratio) and $long_enough) {
                    $cell->dot = ' ';
                }
            }
        }
    }

    private function captureKeyStroke()
    {
        $c = fread(STDIN, 1);
        if (in_array($c, ['='])) {
            $this->increaseSleep();
        } elseif (in_array($c, ['-'])) {
            $this->decreaseSleep();
        } elseif (in_array($c, ['q'])) {
            exit;
        } elseif (in_array($c, ['1'])) {
            $this->increaseNewRowProperty();
        } elseif (in_array($c, ['2'])) {
            $this->decreaseNewRowProperty();
        } elseif (in_array($c, ['z'])) {
            $this->increaseEmptyRowProperty();
        } elseif (in_array($c, ['x'])) {
            $this->decreaseEmptyRowProperty();
        } elseif (in_array($c, ['a'])) {
            $this->increaseMinRainLength();
        } elseif (in_array($c, ['s'])) {
            $this->decreaseMinRainLength();
        } elseif (in_array($c, ['c'])) {
            self::$color_style = (self::$color_style + 1) % count(Pixel::$color_256);
        }
    }

    public function run($debug_mode = false)
    {
        while(1) {

            $this->captureKeyStroke();
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
            $this->display($debug_mode);
        }
    }
}
