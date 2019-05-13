<?php
$imageFile = 'reference_frame_bas_gauche.jpg';
$im = imagecreatefromjpeg($imageFile);
//$details = getimagesize($imageFile);
$width = imagesx($im);//$details[0];
$height = imagesy($im);//$details[1];
//echo $width.$height;
//$indice = 50;
//
//$differenceR = $_GET['r'];
//$differenceG = $_GET['g'];
//$differenceB = $_GET['b'];

//echo $differenceR.'<br>';
//echo $differenceG.'<br>';
//echo $differenceB.'<br>';
//exit;

$reference = '3E4780';
$destination = $_GET['color'];//''0C794F';
//$destination = '0C794F';

//$differenceR = hexdec(substr($reference,0,2)) - hexdec(substr($destination,0,2));
//$differenceG = hexdec(substr($reference,2,2)) - hexdec(substr($destination,2,2));
//$differenceB = hexdec(substr($reference,4,2)) - hexdec(substr($destination,4,2));
$differenceR = hexdec(substr($destination,0,2));
$differenceG = hexdec(substr($destination,2,2));
$differenceB = hexdec(substr($destination,4,2));

for($y=0; $y < $height; $y++)
{
    for($x=0; $x < $width; $x++)
    {
        $color_index = imagecolorat($im, $x, $y); // récupération de la couleur du pixel
        $color_tran = imagecolorsforindex($im, $color_index); // on la rend humainement lisible
        //imagecolorset($im, $color_index, $color_tran['red']+$indice, $color_tran['green']+$indice, $color_tran['blue']+$indice);
        if ($color_tran['red'] <= 210)
        {
            $r = min(255,$differenceR);
            $g = min(255,$differenceG);
            $b = min(255,$differenceB);
            
            
            $c = imagecolorallocate($im, $r, $g, $b);
            
            imagesetpixel ($im, $x, $y, $c);
        }


    }
}
//print_r($details);
header("Content-type: image/jpeg");
imagejpeg($im, '', 100);
imagejpeg($im, 'frame_bas_gauche.jpg', 100);
?>