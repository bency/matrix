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

    public static $V5ProphitCell = [
        '48' => [
            [' ', '_', '_', '_', '_', '_', '_', '_', ' '],
            ['|', ' ', ' ', '_', ' ', ' ', ' ', ' ', '|'],
            ['|', ' ', '|', ' ', '|', ' ', ' ', ' ', '|'],
            ['|', ' ', '|', ' ', '|', ' ', ' ', ' ', '|'],
            ['|', ' ', '|', '_', '|', ' ', ' ', ' ', '|'],
            ['|', ' ', ' ', ' ', ' ', ' ', ' ', ' ', '|'],
            ['|', '_', '_', '_', '_', '_', '_', '_', '|'],
        ],
        '49' => [
            [' ', '_', '_', '_', '_', ' ', ' '],
            ['|', ' ', ' ', ' ', ' ', '|', ' '],
            [' ', '|', ' ', ' ', ' ', '|', ' '],
            [' ', '|', ' ', ' ', ' ', '|', ' '],
            [' ', '|', ' ', ' ', ' ', '|', ' '],
            [' ', '|', ' ', ' ', ' ', '|', ' '],
            [' ', '|', '_', '_', '_', '|', ' '],
        ],
        '50' => [
            [' ', '_', '_', '_', '_', '_', '_', '_', ' '],
            ['|', ' ', ' ', ' ', ' ', ' ', ' ', ' ', '|'],
            ['|', '_', '_', '_', '_', ' ', ' ', ' ', '|'],
            [' ', '_', '_', '_', '_', '|', ' ', ' ', '|'],
            ['|', ' ', '_', '_', '_', '_', '_', '_', '|'],
            ['|', ' ', '|', '_', '_', '_', '_', '_', ' '],
            ['|', '_', '_', '_', '_', '_', '_', '_', '|'],
        ],
        '51' => [
            [' ', '_', '_', '_', '_', '_', '_', '_', ' '],
            ['|', ' ', ' ', ' ', ' ', ' ', ' ', ' ', '|'],
            ['|', '_', '_', '_', ' ', ' ', ' ', ' ', '|'],
            [' ', '_', '_', '_', '|', ' ', ' ', ' ', '|'],
            ['|', '_', '_', '_', ' ', ' ', ' ', ' ', '|'],
            [' ', '_', '_', '_', '|', ' ', ' ', ' ', '|'],
            ['|', '_', '_', '_', '_', '_', '_', '_', '|'],
        ],
        '52' => [
            [' ', '_', ' ', ' ', ' ', '_', '_', '_', ' '],
            ['|', ' ', '|', ' ', '|', ' ', ' ', ' ', '|'],
            ['|', ' ', '|', '_', '|', ' ', ' ', ' ', '|'],
            ['|', ' ', ' ', ' ', ' ', ' ', ' ', ' ', '|'],
            ['|', '_', '_', '_', ' ', ' ', ' ', ' ', '|'],
            [' ', ' ', ' ', ' ', '|', ' ', ' ', ' ', '|'],
            [' ', ' ', ' ', ' ', '|', '_', '_', '_', '|'],
        ],
        '53' => [
            [' ', '_', '_', '_', '_', '_', '_', '_', ' '],
            ['|', ' ', ' ', ' ', ' ', ' ', ' ', ' ', '|'],
            ['|', ' ', ' ', ' ', '_', '_', '_', '_', '|'],
            ['|', ' ', ' ', '|', '_', '_', '_', '_', ' '],
            ['|', '_', '_', '_', '_', '_', ' ', ' ', '|'],
            [' ', '_', '_', '_', '_', '_', '|', ' ', '|'],
            ['|', '_', '_', '_', '_', '_', '_', '_', '|'],
        ],
        '54' => [
            [' ', '_', '_', '_', ' ', ' ', ' ', ' ', ' '],
            ['|', ' ', ' ', ' ', '|', ' ', ' ', ' ', ' '],
            ['|', ' ', ' ', ' ', '|', '_', '_', '_', ' '],
            ['|', ' ', ' ', ' ', ' ', '_', ' ', ' ', '|'],
            ['|', ' ', ' ', ' ', '|', ' ', '|', ' ', '|'],
            ['|', ' ', ' ', ' ', '|', '_', '|', ' ', '|'],
            ['|', '_', '_', '_', '_', '_', '_', '_', '|'],
        ],
        '55' => [
            [' ', '_', '_', '_', '_', '_', '_', '_', ' '],
            ['|', ' ', ' ', ' ', ' ', ' ', ' ', ' ', '|'],
            ['|', '_', '_', '_', ' ', ' ', ' ', ' ', '|'],
            [' ', ' ', ' ', ' ', '|', ' ', ' ', ' ', '|'],
            [' ', ' ', ' ', ' ', '|', ' ', ' ', ' ', '|'],
            [' ', ' ', ' ', ' ', '|', ' ', ' ', ' ', '|'],
            [' ', ' ', ' ', ' ', '|', '_', '_', '_', '|'],
        ],
        '56' => [
            [' ', ' ', '_', '_', '_', '_', '_', ' ', ' '],
            [' ', '|', ' ', ' ', '_', ' ', ' ', '|', ' '],
            [' ', '|', ' ', '|', '_', '|', ' ', '|', ' '],
            ['|', ' ', ' ', ' ', '_', ' ', ' ', ' ', '|'],
            ['|', ' ', ' ', '|', ' ', '|', ' ', ' ', '|'],
            ['|', ' ', ' ', '|', '_', '|', ' ', ' ', '|'],
            ['|', '_', '_', '_', '_', '_', '_', '_', '|'],
        ],
        '57' => [
            [' ', '_', '_', '_', '_', '_', '_', '_', ' '],
            ['|', ' ', ' ', '_', ' ', ' ', ' ', ' ', '|'],
            ['|', ' ', '|', ' ', '|', ' ', ' ', ' ', '|'],
            ['|', ' ', '|', '_', '|', ' ', ' ', ' ', '|'],
            ['|', '_', '_', '_', ' ', ' ', ' ', ' ', '|'],
            [' ', ' ', ' ', ' ', '|', ' ', ' ', ' ', '|'],
            [' ', ' ', ' ', ' ', '|', '_', '_', '_', '|'],
        ],
        '65' => [
            [' ', '_', '_', '_', '_', '_', '_', '_', ' '],
            ['|', ' ', ' ', ' ', '_', ' ', ' ', ' ', '|'],
            ['|', ' ', ' ', '|', '_', '|', ' ', ' ', '|'],
            ['|', ' ', ' ', ' ', ' ', ' ', ' ', ' ', '|'],
            ['|', ' ', ' ', ' ', ' ', ' ', ' ', ' ', '|'],
            ['|', ' ', ' ', ' ', '_', ' ', ' ', ' ', '|'],
            ['|', '_', '_', '|', ' ', '|', '_', '_', '|'],
        ],
        '66' => [
            [' ', '_', '_', '_', '_', '_', '_', '_', ' '],
            ['|', ' ', ' ', '_', ' ', ' ', ' ', ' ', '|'],
            ['|', ' ', '|', '_', '|', ' ', ' ', ' ', '|'],
            ['|', ' ', ' ', ' ', ' ', ' ', ' ', ' ', '|'],
            ['|', ' ', ' ', '_', ' ', ' ', ' ', '|', ' '],
            ['|', ' ', '|', '_', '|', ' ', ' ', ' ', '|'],
            ['|', '_', '_', '_', '_', '_', '_', '_', '|'],
        ],
        '67' => [
            [' ', '_', '_', '_', '_', '_', '_', '_', ' '],
            ['|', ' ', ' ', ' ', ' ', ' ', ' ', ' ', '|'],
            ['|', ' ', ' ', ' ', ' ', ' ', ' ', ' ', '|'],
            ['|', ' ', ' ', ' ', ' ', ' ', ' ', ' ', '|'],
            ['|', ' ', ' ', ' ', ' ', ' ', ' ', '_', '|'],
            ['|', ' ', ' ', ' ', ' ', ' ', '|', '_', ' '],
            ['|', '_', '_', '_', '_', '_', '_', '_', '|'],
        ],
        '68' => [
            [' ', '_', '_', '_', '_', '_', '_', ' ', ' '],
            ['|', ' ', ' ', ' ', ' ', ' ', ' ', '|', ' '],
            ['|', ' ', ' ', '_', ' ', ' ', ' ', ' ', '|'],
            ['|', ' ', '|', ' ', '|', ' ', ' ', ' ', '|'],
            ['|', ' ', '|', '_', '|', ' ', ' ', ' ', '|'],
            ['|', ' ', ' ', ' ', ' ', ' ', ' ', ' ', '|'],
            ['|', '_', '_', '_', '_', '_', '_', '|', ' '],
        ],
        '69' => [
            [' ', '_', '_', '_', '_', '_', '_', '_', ' '],
            ['|', ' ', ' ', ' ', ' ', ' ', ' ', ' ', '|'],
            ['|', ' ', ' ', ' ', ' ', '_', '_', '_', '|'],
            ['|', ' ', ' ', ' ', '|', '_', '_', '_', ' '],
            ['|', ' ', ' ', ' ', ' ', '_', '_', '_', '|'],
            ['|', ' ', ' ', ' ', '|', '_', '_', '_', ' '],
            ['|', '_', '_', '_', '_', '_', '_', '_', '|'],
        ],
        '70' => [
            [' ', '_', '_', '_', '_', '_', '_', '_', ' '],
            ['|', ' ', ' ', ' ', ' ', ' ', ' ', ' ', '|'],
            ['|', ' ', ' ', ' ', ' ', '_', '_', '_', '|'],
            ['|', ' ', ' ', ' ', '|', '_', '_', '_', ' '],
            ['|', ' ', ' ', ' ', ' ', '_', '_', '_', '|'],
            ['|', ' ', ' ', ' ', '|', ' ', ' ', ' ', ' '],
            ['|', '_', '_', '_', '|', ' ', ' ', ' ', ' '],
        ],
        '71' => [
            [' ', '_', '_', '_', '_', '_', '_', '_', ' '],
            ['|', ' ', ' ', ' ', ' ', ' ', ' ', ' ', '|'],
            ['|', ' ', ' ', ' ', ' ', '_', '_', '_', '|'],
            ['|', ' ', ' ', ' ', '|', ' ', '_', '_', ' '],
            ['|', ' ', ' ', ' ', '|', '|', ' ', ' ', '|'],
            ['|', ' ', ' ', ' ', '|', '_', '|', ' ', '|'],
            ['|', '_', '_', '_', '_', '_', '_', '_', '|'],
        ],
        '72' => [
            [' ', '_', '_', ' ', ' ', ' ', '_', '_', ' '],
            ['|', ' ', ' ', '|', ' ', '|', ' ', ' ', '|'],
            ['|', ' ', ' ', '|', '_', '|', ' ', ' ', '|'],
            ['|', ' ', ' ', ' ', ' ', ' ', ' ', ' ', '|'],
            ['|', ' ', ' ', ' ', ' ', ' ', ' ', ' ', '|'],
            ['|', ' ', ' ', ' ', '_', ' ', ' ', ' ', '|'],
            ['|', '_', '_', '|', ' ', '|', '_', '_', '|'],
        ],
        '73' => [
            [' ', '_', '_', '_', ' ', ' '],
            ['|', ' ', ' ', ' ', '|', ' '],
            ['|', ' ', ' ', ' ', '|', ' '],
            ['|', ' ', ' ', ' ', '|', ' '],
            ['|', ' ', ' ', ' ', '|', ' '],
            ['|', ' ', ' ', ' ', '|', ' '],
            ['|', '_', '_', '_', '|', ' '],
        ],
        '74' => [
            [' ', ' ', ' ', ' ', ' ', '_', '_', '_', ' '],
            [' ', ' ', ' ', ' ', '|', ' ', ' ', ' ', '|'],
            [' ', ' ', ' ', ' ', '|', ' ', ' ', ' ', '|'],
            [' ', ' ', ' ', ' ', '|', ' ', ' ', ' ', '|'],
            [' ', '_', '_', '_', '|', ' ', ' ', ' ', '|'],
            ['|', ' ', ' ', ' ', ' ', ' ', ' ', ' ', '|'],
            ['|', '_', '_', '_', '_', '_', '_', '_', '|'],
        ],
        '75' => [
            [' ', '_', '_', '_', ' ', ' ', ' ', '_', ' '],
            ['|', ' ', ' ', ' ', '|', ' ', '|', ' ', '|'],
            ['|', ' ', ' ', ' ', '|', '_', '|', ' ', '|'],
            ['|', ' ', ' ', ' ', ' ', ' ', ' ', '_', '|'],
            ['|', ' ', ' ', ' ', ' ', ' ', '|', '_', ' '],
            ['|', ' ', ' ', ' ', ' ', '_', ' ', ' ', '|'],
            ['|', '_', '_', '_', '|', ' ', '|', '_', '|'],
        ],
        '76' => [
            [' ', '_', '_', '_', ' ', ' ', ' ', ' ', ' '],
            ['|', ' ', ' ', ' ', '|', ' ', ' ', ' ', ' '],
            ['|', ' ', ' ', ' ', '|', ' ', ' ', ' ', ' '],
            ['|', ' ', ' ', ' ', '|', ' ', ' ', ' ', ' '],
            ['|', ' ', ' ', ' ', '|', '_', '_', '_', ' '],
            ['|', ' ', ' ', ' ', ' ', ' ', ' ', ' ', '|'],
            ['|', '_', '_', '_', '_', '_', '_', '_', '|'],
        ],
        '77' => [
            [' ', '_', '_', ' ', ' ', ' ', '_', '_', ' '],
            ['|', ' ', ' ', '|', '_', '|', ' ', ' ', '|'],
            ['|', ' ', ' ', ' ', ' ', ' ', ' ', ' ', '|'],
            ['|', ' ', ' ', ' ', ' ', ' ', ' ', ' ', '|'],
            ['|', ' ', ' ', ' ', ' ', ' ', ' ', ' ', '|'],
            ['|', ' ', '|', '|', '_', '|', '|', ' ', '|'],
            ['|', '_', '|', ' ', ' ', ' ', '|', '_', '|'],
        ],
        '78' => [
            [' ', '_', '_', ' ', ' ', ' ', ' ', '_', ' '],
            ['|', ' ', ' ', '|', ' ', ' ', '|', ' ', '|'],
            ['|', ' ', ' ', ' ', '|', '_', '|', ' ', '|'],
            ['|', ' ', ' ', ' ', ' ', ' ', ' ', ' ', '|'],
            ['|', ' ', ' ', '_', ' ', ' ', ' ', ' ', '|'],
            ['|', ' ', '|', ' ', '|', ' ', ' ', ' ', '|'],
            ['|', '_', '|', ' ', ' ', '|', '_', '_', '|'],
        ],
        '79' => [
            [' ', '_', '_', '_', '_', '_', '_', '_', ' '],
            ['|', ' ', ' ', ' ', ' ', ' ', ' ', ' ', '|'],
            ['|', ' ', ' ', ' ', '_', ' ', ' ', ' ', '|'],
            ['|', ' ', ' ', '|', ' ', '|', ' ', ' ', '|'],
            ['|', ' ', ' ', '|', '_', '|', ' ', ' ', '|'],
            ['|', ' ', ' ', ' ', ' ', ' ', ' ', ' ', '|'],
            ['|', '_', '_', '_', '_', '_', '_', '_', '|'],
        ],
        '80' => [
            [' ', '_', '_', '_', '_', '_', '_', '_', ' '],
            ['|', ' ', ' ', ' ', ' ', ' ', ' ', ' ', '|'],
            ['|', ' ', ' ', ' ', ' ', '_', ' ', ' ', '|'],
            ['|', ' ', ' ', ' ', '|', '_', '|', ' ', '|'],
            ['|', ' ', ' ', ' ', ' ', '_', '_', '_', '|'],
            ['|', ' ', ' ', ' ', '|', ' ', ' ', ' ', ' '],
            ['|', '_', '_', '_', '|', ' ', ' ', ' ', ' '],
        ],
        '81' => [
            [' ', '_', '_', '_', '_', '_', '_', '_', ' '],
            ['|', ' ', ' ', ' ', ' ', ' ', ' ', ' ', '|'],
            ['|', ' ', ' ', ' ', '_', ' ', ' ', ' ', '|'],
            ['|', ' ', ' ', '|', ' ', '|', ' ', ' ', '|'],
            ['|', ' ', ' ', '|', '_', '|', ' ', ' ', '|'],
            ['|', ' ', ' ', ' ', ' ', ' ', ' ', '|', ' '],
            ['|', '_', '_', '_', '_', '|', '|', '_', '|'],
        ],
        '82' => [
            [' ', '_', '_', '_', '_', '_', '_', ' ', ' ', ' '],
            ['|', ' ', ' ', ' ', ' ', '_', ' ', '|', ' ', ' '],
            ['|', ' ', ' ', ' ', '|', ' ', '|', '|', ' ', ' '],
            ['|', ' ', ' ', ' ', '|', '_', '|', '|', '_', ' '],
            ['|', ' ', ' ', ' ', ' ', '_', '_', ' ', ' ', '|'],
            ['|', ' ', ' ', ' ', '|', ' ', ' ', '|', ' ', '|'],
            ['|', '_', '_', '_', '|', ' ', ' ', '|', '_', '|'],
        ],
        '83' => [
            [' ', '_', '_', '_', '_', '_', '_', '_', ' '],
            ['|', ' ', ' ', ' ', ' ', ' ', ' ', ' ', '|'],
            ['|', ' ', ' ', '_', '_', '_', '_', '_', '|'],
            ['|', ' ', '|', '_', '_', '_', '_', '_', ' '],
            ['|', '_', '_', '_', '_', '_', ' ', ' ', '|'],
            [' ', '_', '_', '_', '_', '_', '|', ' ', '|'],
            ['|', '_', '_', '_', '_', '_', '_', '_', '|'],
        ],
        '84' => [
            [' ', '_', '_', '_', '_', '_', '_', '_', ' '],
            ['|', ' ', ' ', ' ', ' ', ' ', ' ', ' ', '|'],
            ['|', '_', ' ', ' ', ' ', ' ', ' ', '_', '|'],
            [' ', ' ', '|', ' ', ' ', ' ', '|', ' ', ' '],
            [' ', ' ', '|', ' ', ' ', ' ', '|', ' ', ' '],
            [' ', ' ', '|', ' ', ' ', ' ', '|', ' ', ' '],
            [' ', ' ', '|', '_', '_', '_', '|', ' ', ' '],
        ],
        '85' => [
            [' ', '_', '_', ' ', ' ', ' ', '_', '_', ' '],
            ['|', ' ', ' ', '|', ' ', '|', ' ', ' ', '|'],
            ['|', ' ', ' ', '|', ' ', '|', ' ', ' ', '|'],
            ['|', ' ', ' ', '|', '_', '|', ' ', ' ', '|'],
            ['|', ' ', ' ', ' ', ' ', ' ', ' ', ' ', '|'],
            ['|', ' ', ' ', ' ', ' ', ' ', ' ', ' ', '|'],
            ['|', '_', '_', '_', '_', '_', '_', '_', '|'],
        ],
        '86' => [
            [' ', '_', '_', ' ', ' ', ' ', '_', '_', ' '],
            ['|', ' ', ' ', '|', ' ', '|', ' ', ' ', '|'],
            ['|', ' ', ' ', '|', '_', '|', ' ', ' ', '|'],
            ['|', ' ', ' ', ' ', ' ', ' ', ' ', ' ', '|'],
            ['|', ' ', ' ', ' ', ' ', ' ', ' ', ' ', '|'],
            [' ', '|', ' ', ' ', ' ', ' ', ' ', '|', ' '],
            [' ', ' ', '|', '_', '_', '_', '|', ' ', ' '],
        ],
        '87' => [
            [' ', '_', ' ', ' ', ' ', ' ', ' ', '_', ' '],
            ['|', ' ', '|', ' ', '_', ' ', '|', ' ', '|'],
            ['|', ' ', '|', '|', ' ', '|', '|', ' ', '|'],
            ['|', ' ', ' ', ' ', ' ', ' ', ' ', ' ', '|'],
            ['|', ' ', ' ', ' ', ' ', ' ', ' ', ' ', '|'],
            ['|', ' ', ' ', ' ', '_', ' ', ' ', ' ', '|'],
            ['|', '_', '_', '|', ' ', '|', '_', '_', '|'],
        ],
        '88' => [
            [' ', '_', '_', ' ', ' ', ' ', '_', '_', ' '],
            ['|', ' ', ' ', '|', '_', '|', ' ', ' ', '|'],
            ['|', ' ', ' ', ' ', ' ', ' ', ' ', ' ', '|'],
            ['|', ' ', ' ', ' ', ' ', ' ', ' ', ' ', '|'],
            [' ', '|', ' ', ' ', ' ', ' ', ' ', '|', ' '],
            ['|', ' ', ' ', ' ', '_', ' ', ' ', ' ', '|'],
            ['|', '_', '_', '|', ' ', '|', '_', '_', '|'],
        ],
        '89' => [
            [' ', '_', '_', ' ', ' ', ' ', '_', '_', ' '],
            ['|', ' ', ' ', '|', ' ', '|', ' ', ' ', '|'],
            ['|', ' ', ' ', '|', '_', '|', ' ', ' ', '|'],
            ['|', ' ', ' ', ' ', ' ', ' ', ' ', ' ', '|'],
            ['|', '_', ' ', ' ', ' ', ' ', ' ', '_', '|'],
            [' ', ' ', '|', ' ', ' ', ' ', '|', ' ', ' '],
            [' ', ' ', '|', '_', '_', '_', '|', ' ', ' '],
        ],
        '90' => [
            [' ', '_', '_', '_', '_', '_', '_', '_', ' '],
            ['|', ' ', ' ', ' ', ' ', ' ', ' ', ' ', '|'],
            ['|', '_', '_', '_', '_', ' ', ' ', ' ', '|'],
            [' ', '_', '_', '_', '_', '|', ' ', ' ', '|'],
            ['|', ' ', '_', '_', '_', '_', '_', '_', '|'],
            ['|', ' ', '|', '_', '_', '_', '_', '_', ' '],
            ['|', '_', '_', '_', '_', '_', '_', '_', '|'],
        ],
        '32' => [
            [' ', ' ', ' ', ' '],
            [' ', ' ', ' ', ' '],
            [' ', ' ', ' ', ' '],
            [' ', ' ', ' ', ' '],
            [' ', ' ', ' ', ' '],
            [' ', ' ', ' ', ' '],
            [' ', ' ', ' ', ' '],
        ],
        "39" => [
            [' ', '_', '_', ' ', ' '],
            ['|', ' ', ' ', '|', ' '],
            ['|', '_', '_', '|', ' '],
            [' ', ' ', ' ', ' ', ' '],
            [' ', ' ', ' ', ' ', ' '],
            [' ', ' ', ' ', ' ', ' '],
            [' ', ' ', ' ', ' ', ' '],
        ]
    ];

    public static function getString($string)
    {
        $str_len = strlen($string);
        if ($str_len < 1) {
            return null;
        }
        $max_height = 0;

        // get max height
        for ($i = 0; $i < $str_len; $i++) {
            $alpha = ord($string[$i]);
            $max_height = max($max_height, count(self::$V5ProphitCell[$alpha]));
        }

        for ($row = $max_height - 1; $row >= 0; $row--) {
            for ($i = 0; $i < $str_len; $i++) {
                if (!isset($combo[$row])) {
                    $combo[$row] = [];
                }
                $alpha = ord($string[$i]);
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
