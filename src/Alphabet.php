<?php
namespace Matrix;

class Alphabet
{

    private $map = null;

    public function __construct($char)
    {
        $ascii = ord($char);
        if (isset(self::$V5ProphitCell[$ascii])) {
            $this->map = self::$V5ProphitCell[$ascii];
        }
    }

    public function getHeight()
    {
        return count($this->map);
    }

    public function getWidth()
    {
        return count($this->map[0]);
    }

    public static $V5ProphitCell = [];

    public static function setFont($font_name)
    {
        if (!file_exists(__DIR__ . '/../fonts/' . $font_name . '.json')) {
            throw new \Exception('Can not find font ' . $font_name . ' in ' . __DIR__ . '/../fonts');
        }
        self::$V5ProphitCell = json_decode(file_get_contents(__DIR__ . '/../fonts/' . $font_name . '.json'), true);
    }

    public function getRow($row = 0)
    {
        return $this->map[$row];
    }

    public static function getString($string)
    {
        $str_len = strlen($string);
        if ($str_len < 1) {
            return null;
        }
        $max_height = 0;

        // get max height
        for ($i = 0; $i < $str_len; $i++) {

            // only provide upper case
            $alpha = ord(strtoupper($string[$i]));
            if (!isset(self::$V5ProphitCell[$alpha])) {
                throw new \Exception("this character {$string[$i]} is not support");
            }
            $max_height = max($max_height, count(self::$V5ProphitCell[$alpha]));
        }

        for ($row = $max_height - 1; $row >= 0; $row--) {
            for ($i = 0; $i < $str_len; $i++) {
                if (!isset($combo[$row])) {
                    $combo[$row] = [];
                }
                $alpha = ord(strtoupper($string[$i]));
                $combo[$row] = array_merge(
                    $combo[$row],
                    [' ', ' '],
                    self::$V5ProphitCell[$alpha][$row]
                );
            }
        }
        return $combo;
    }
}
