<?php
$txt = $_GET['text'];
$im = @imagecreate(400, 300);
$background_color = imagecolorallocate($im, 0, 0, 0);
$text_color = imagecolorallocate($im, 233, 14, 91);
imagestring($im, 55, 55, 55,  $txt, $text_color);
header("Content-Type: image/png");
imagepng($im);
imagedestroy($im);