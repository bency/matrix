<?php
include __DIR__ . "/src/Layout.php";
include __DIR__ . "/src/Row.php";
include __DIR__ . "/src/Pixel.php";

stream_set_blocking(STDIN, 0);

// 取得寬度
exec('tput cols', $arr);
$width = $arr[0];

// 取得高度
exec('tput lines', $arr);
$heigh = $arr[1];

// 讓 STDIN 只讀取一個字元就輸出
system("stty -icanon time 1");

$layout = new Matrix\Layout($heigh, $width);
$layout->setWidth($width);
$layout->setHeight($heigh);

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
