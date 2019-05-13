<?php
$im = imagecreate(1,499);

//$details = getimagesize($imageFile);
$width = imagesx($im);//$details[0];
$height = imagesy($im);//$details[1];


//echo $width.$height;
//$indice = 50;

//echo $differenceR.'<br>';
//echo $differenceG.'<br>';
//echo $differenceB.'<br>';
//exit;

$c2 = array(
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
$c1 = array(
            'r' => 255,
            'g' => 255,
            'b' => 255,
            );

for ($i=0;$i < $height;$i++)
{
    $r = $c1['r'] + $i*($c2['r']-$c1['r'])/$height;
    $v = $c1['g'] + $i*($c2['g']-$c1['g'])/$height;
    $b = $c1['b'] + $i*($c2['b']-$c1['b'])/$height;
    $c=imagecolorallocate($im,$r,$v,$b);
    //imageline($im,$x,0,$x,7,$c);
    imageline($im,0,$i,1,$i,$c);
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
header("Content-type: image/png");
imagepng($im);
imagepng($im, 'fonddegrade.png');
?>