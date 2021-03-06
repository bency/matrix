<?php
use Matrix\Alphabet;
Class AlphabetTest extends PHPUnit_Framework_TestCase
{
    public function testHeight()
    {
        $target = new Alphabet('A');
        $height = $target->getHeight();
        $expected = 7;
        $this->assertEquals($expected, $height);
    }

    public function testHeightOfEmptyString()
    {
        $target = new Alphabet('');
        $height = $target->getHeight();
        $expected = 0;
        $this->assertEquals($expected, $height);
    }
}
