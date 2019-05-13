<?php
$imageFile = 'reference_frame_bas.jpg';
$im = imagecreatefromjpeg($imageFile);

//$details = getimagesize($imageFile);
$width = imagesx($im);//$details[0];
$height = imagesy($im);//$details[1];


//echo $width.$height;
//$indice = 50;

//echo $differenceR.'<br>';
//echo $differenceG.'<br>';
//echo $differenceB.'<br>';
//exit;

$c1 = array(
            'r' => hexdec(substr($_GET['color'],0,2)),
            'g' => hexdec(substr($_GET['color'],2,2)),
            'b' => hexdec(substr($_GET['color'],4,2)),
            );
//print_r($_GET);
//$c1 = array(
//            'r' => 206,
//            'g' => 226,
//            'b' => 209,
//            );
$c2 = array(
            'r' => 255,
            'g' => 255,
            'b' => 255,
            );

for ($x=0;$x < $width;$x++)
{
    $r = $c1['r'] + $x*($c2['r']-$c1['r'])/$width;
    $v = $c1['g'] + $x*($c2['g']-$c1['g'])/$width;
    $b = $c1['b'] + $x*($c2['b']-$c1['b'])/$width;
    $c=imagecolorallocate($im,$r,$v,$b);
    imageline($im,$x,0,$x,7,$c);
}

//for($y=0; $y < $height; $y++)
//{
//    for($x=0; $x < $width; $x++)
//    {
//        $color_index = imagecolorat($im, $x, $y); // récupération de la couleur du pixel
//        $color_tran = imagecolorsforindex($im, $color_index); // on la rend humainement lisible
//        //imagecolorset($im, $color_index, $color_tran['red']+$indice, $color_tran['green']+$indice, $color_tran['blue']+$indice);
//        if ($y < 7)
//        {
//            $r = min(255,$color_tran['red']+$differenceR);
//            $g = min(255,$color_tran['green']+$differenceG);
//            $b = min(255,$color_tran['blue']+$differenceB);
//            
//            
//            $c = imagecolorallocate($im, $r, $g, $b);
//            
//            imagesetpixel ($im, $x, $y, $c);
//        }
//
//
//    }
//}
//print_r($details);
header("Content-type: image/jpeg");
imagejpeg($im, '', 100);
imagejpeg($im, 'frame_bas.jpg', 100);
?>