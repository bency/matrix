<?php
namespace Matrix;

class Pixel
{
    static public $alphabet = [
        ' ','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z',
        'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z',' ',
        ' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',
        ' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' '
    ];
    public $color_code = 15;  // 31 ~ 37
    public static $color_256 = [
        [22, 28, 34, 40, 46, 83],
        [16, 17, 18, 19, 20, 21],
        [232, 235, 238, 241, 244, 247, 250, 253]
    ];
    public $dot = ' ';

    public function __construct($empty = false)
    {
        if (!$empty) {
            $this->setRandomAlphabet();
        }
    }

    public function getAscii()
    {
        return "\e[38;5;{$this->color_code}m{$this->dot}\e[0m";
    }

    public function newRandomAlphabet()
    {
        $this->color_code = 15;
        $rand = rand() % count(self::$alphabet);
        $this->dot = self::$alphabet[$rand];
    }

    public function setRandomAlphabet()
    {
        $rand = rand() % count(self::$alphabet);
        $this->dot = self::$alphabet[$rand];
    }
}
