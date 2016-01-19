<?php
use Matrix\Alphabet;
Class AlphabetTest extends PHPUnit_Framework_TestCase
{
    public function testHeight()
    {
        Alphabet::setFont('modular');
        $target = new Alphabet('A');
        $height = $target->getHeight();
        $expected = 7;
        $this->assertEquals($expected, $height);
    }

    public function testHeightOfEmptyString()
    {
        Alphabet::setFont('modular');
        $target = new Alphabet('');
        $height = $target->getHeight();
        $expected = 0;
        $this->assertEquals($expected, $height);
    }

    public function testWidth()
    {
        $alpha = new Alphabet('A');
        $target = $alpha->getWidth();
        $expected = 9;
        $this->assertEquals($expected, $target);
    }

    public function testGetRowByModularFont()
    {
        $alpha = new Alphabet('A');
        $target = $alpha->getRow(0);
        $expected = [' ', '_', '_', '_', '_', '_', '_', '_', ' '];
        $this->assertEquals($expected, $target);
    }
}
