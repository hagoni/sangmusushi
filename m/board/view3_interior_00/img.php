<?
header('Content-Type: image/png');

$x = $_REQUEST['x'];
$y = $_REQUEST['y'];
$png = imagecreatetruecolor($x, $y);
imagepng($png);
imagedestroy($png);
?>