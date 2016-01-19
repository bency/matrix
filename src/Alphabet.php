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
            $charts[] = $alpha = new Alphabet(strtoupper($string[$i]));
            $max_height = max($max_height, $alpha->getHeight());
        }

        for ($row = $max_height - 1; $row >= 0; $row--) {
            foreach ($charts as $i => $alpha) {
                if (!isset($combo[$row])) {
                    $combo[$row] = [];
                }
                $combo[$row] = array_merge(
                    $combo[$row],
                    [' ', ' '],
                    $alpha->getRow($row)
                );
            }
        }
        return $combo;
    }
}
