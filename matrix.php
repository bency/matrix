<?php
include __DIR__ . "/src/Layout.php";
include __DIR__ . "/src/Row.php";
include __DIR__ . "/src/Pixel.php";

$width = $heigh = 0;


$layout = new Matrix\Layout();

while(1) {

    $c = fread(STDIN, 1);
    if (in_array($c, ['='])) {
        $layout->increaseSleep();
    } elseif (in_array($c, ['-'])) {
        $layout->decreaseSleep();
    }

    // 重設環境變數
    unset($envi_param);
    exec('tput cols', $envi_param);
    exec('tput lines', $envi_param);

    if ($envi_param[0] != $width) {
        $width = $envi_param[0];
        $layout->setWidth($width);
    }

    if (($envi_param[1]) != $heigh) {
        $heigh = $envi_param[1];
        $layout->setHeight($heigh);
    }
    $layout->display();
}
