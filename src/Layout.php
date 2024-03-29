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
    private $offset = 0;
    private $marquee_width = 0;
    private $wording = null;
    private $shift = false;
    private static $sleep_standard = 100000;
    private static $sleep;
    private static $countdown_target = null;
    public function __construct()
    {

        // 讓 STDIN 只讀取一個字元就輸出
        system("stty -icanon time 1");

        // STDIN 沒東西就略過
        stream_set_blocking(STDIN, 0);
        self::$sleep = self::$sleep_standard;
    }

    public function enableMarquee()
    {
        if (strlen($this->wording) < 1) {
            throw new \Exception('You need to set wording first.');
        }
        $this->shift = true;
    }

    public function disableMarquee()
    {
        $this->shift = false;
    }

    public function setWording($str)
    {
        if (strlen($str) < 1) {
            return false;
        }
        $this->wording = $str;
        return true;
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

    private function adjustSleep()
    {
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
                    "fps: %s, W: %s, H: %s, NRR: %s, ERR: %s, MRL: %s, mr_offset: %s, offset: %s, marquee width: %s",
                    number_format(1000000 / self::$sleep, 2),
                    $this->width,
                    $this->heigh,
                    $this->new_row_ratio,
                    $this->empty_row_ratio,
                    $this->min_rain_length,
                    self::$marquee_offset,
                    $this->offset,
                    $this->marquee_width
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
        if ($this->wording) {
            $marquee = Alphabet::getString($this->wording);
        }

        $this->marquee_width = count($marquee[0]);
        if ($this->shift) {
            self::$marquee_offset = (self::$marquee_offset - 1) % (max($this->width, $this->marquee_width) + 10);
        } else {
            self::$marquee_offset = max(intval(($this->width - $this->marquee_width) / 2), 0);
        }

        // centerd for now
        $padding_top = intval(($this->heigh - count($marquee)) / 2);
        for ($row = $this->heigh - 1; $row > 0; $row--) {
            foreach ($this->row[$row]->cells as $col => &$cell) {
                if ($this->shift) {
                    $this->offset = ($col - self::$marquee_offset) % (max($this->width, $this->marquee_width) + 10);
                } else {
                    $this->offset = ($col - self::$marquee_offset);
                }
                if ($marquee and isset($marquee[$row - $padding_top][$this->offset])) {
                    $this->row[$row]->cells[$col]->is_wording = true;
                    $this->row[$row]->cells[$col]->wording = $marquee[$row - $padding_top][$this->offset];
                } else {
                    $this->row[$row]->cells[$col]->is_wording = false;
                }

                if (!isset($this->row[$row - 1]->cells[$col]) or $this->row[$row - 1]->cells[$col]->dot == ' ') {
                    $cell->dot = ' ';
                } elseif ($cell->dot == ' ') {                      // 上一列有值但這一列是空白
                    if (rand() % 10 > 7) {                          // 八成機率產生新值
                        // 已經不知道為什麼需要這一行了
                        $this->row[$row - 1]->cells[$col]->color_code = 92;
                    } else {
                        // 產生新值
                        $this->row[$row - 1]->cells[$col]->color_code = 1;
                        $cell->newRandomAlphabet();
                    }
                    for ($snake = $row - 1, $k = count($this->getColors()) - 1; isset($this->row[$snake]); $snake--) {
                        $c = max($k--, 0);
                        $this->row[$snake]->cells[$col]->color_code = $this->getColors()[$c];
                    }
                } elseif ($row < $this->heigh - 1) {
                    if ($this->row[$row + 1]->cells[$col]->dot == ' ') {
                        $cell->color_code = 15;
                    }
                } else {                                            // 最後一行
                    if ($this->row) {
                        $cell->color_code = $this->row[$row - 1]->cells[$col]->color_code;
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

    /**
     *  countdown
     *
     *  set countdown timer
     *  eg. 5m 10h4m2s 140s
     */
    private function countdown($countdown)
    {
        if (!self::$countdown_target) {
            self::$countdown_target = time() + $countdown * 60;
        }
        if (time() > self::$countdown_target) {
            return "time's up";
        }
        return $this->formatCountdown(self::$countdown_target - time());
    }

    private function formatCountdown($seconds)
    {
        $rest_seconds = $seconds % 60;
        if ($rest_seconds < 10) {
            $rest_seconds = '0' . $rest_seconds;
        }
        if (!$minutes = floor($seconds / 60)) {
            return $rest_seconds;
        }

        if ($minutes < 60) {
            if ($minutes < 10) {
                $minutes = '0' . $minutes;
            }
            return $minutes . ":" . $rest_seconds;
        }
        $hours = floor($minutes / 60);
        $minutes %= 60;
        if ($minutes < 10) {
            $minutes = '0' . $minutes;
        }
        if ($hours < 10) {
            $hours = '0' . $hours;
        }
        return $hours . ":" . $minutes . ":" . $rest_seconds;
    }

    public function run(array $options = [])
    {
        $width = $heigh = 0;
        $font = 'modular';

        $debug_mode = isset($options['debug']) ? $options['debug'] : false;

        if (isset($options['wording'])) {
            $wording = $options['wording'];
        }

        if (isset($options['font'])) {
            $font = $options['font'];
        }
        Alphabet::setFont($font);

        while (1) {
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
            if (isset($options['timer']) and $options['timer'] and isset($options['timer_format'])) {
                $wording = date($options['timer_format']);
            }

            if (isset($options['countdown']) and $countdown = $options['countdown']) {
                $wording = $this->countdown($countdown);
            }

            if (isset($options['wording-path']) and file_exists($options['wording-path'])) {
                $path = $options['wording-path'];
                $content = file_get_contents($path);
                $words = explode("\n", $content);
                $wording = $words[count($words) - 2];
            }
            $this->setWording($wording);

            if (isset($options['marquee']) and $options['marquee']) {
                $this->enableMarquee();
            }
            $this->display($debug_mode);
        }
    }
}
