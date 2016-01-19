<?php
use Matrix\Row;
class RowTest extends PHPUnit_Framework_TestCase
{
    public function testWidth()
    {
        $row = new Row;
        $expected = 20;
        $row->setWidth($expected);
        $target = count($row->cells);
        $this->assertEquals($expected, $target);
    }
}
