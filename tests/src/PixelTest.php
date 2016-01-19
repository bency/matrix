<?php
use Matrix\Pixel;
class PixelTest extends PHPUnit_Framework_TestCase
{
    public function testColorSet()
    {
        $target = new Pixel;
        $target->setColorSet();
        $color = $target->getColor();
        $expect = Pixel::$color_256[0][8];
        $this->assertEquals($expect, $color);
    }

    public function testSecondColor()
    {
        $target = new Pixel;
        $target->setColorSet();
        $target->nextColor();
        $color = $target->getColor();
        $expect = Pixel::$color_256[0][7];
        $this->assertEquals($expect, $color);
    }

    public function testNextColorSet()
    {
        $target = new Pixel;
        $target->setColorSet();
        $target->nextColorSet();
        $target->nextColor();
        $target->nextColor();
        $target->nextColor();
        $target->nextColor();
        $target->nextColor();
        $target->nextColor();
        $target->nextColor();
        $target->nextColor();
        $color = $target->getColor();
        $expect = Pixel::$color_256[1][0];
        $this->assertEquals($expect, $color);
    }

    public function testDelayNextColorSet()
    {
        $target = new Pixel;
        $target->setColorSet();
        $target->nextColorSet();
        $color = $target->getColor();
        $expect = Pixel::$color_256[0][0];
        $this->assertEquals($expect, $color);
    }
}
