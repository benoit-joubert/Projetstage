<?php
/*
 * PHP QR Code encoder
 *
 * Image output of code using GD2
 *
 * PHP QR Code is distributed under LGPL 3
 * Copyright (C) 2010 Dominik Dzienia <deltalab at poczta dot fm>
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 3 of the License, or any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 */
 
    define('QR_IMAGE', true);

    class QRimage {
    
        //----------------------------------------------------------------------
        public static function png($frame, $filename = false, $pixelPerPoint = 4, $outerFrame = 4,$saveandprint=FALSE) 
        {
            global $qrcodeLogo;
            
            $image = self::image($frame, $pixelPerPoint, $outerFrame);
            
            if (defined('QRCODE_COLOR_LOGO'))
            {
                $h = count($frame);
                $w = strlen($frame[0]);
                
                $imgW = ($w + 2*$outerFrame)*$pixelPerPoint;
                $imgH = ($h + 2*$outerFrame)*$pixelPerPoint;
                
                $width2 = $imgW/4;
                $height2 = $imgH/4;
                
                $posX = (($imgW+$width2)/2)-$width2;
                $posY = (($imgH+$height2)/2)-$height2;
//                die($imgW.':'.$imgH);
                $imgLogo = imagecreatefrompng(QRCODE_COLOR_LOGO);
                list($width, $height) = getimagesize(QRCODE_COLOR_LOGO);
                imagecopyresampled($image,$imgLogo,$posX,$posY,0,0, $width2,$height2,$width,$height);
                ImageDestroy($imgLogo);
//                exit;
            }
            
//            exit;
            return $image;
            if ($filename === false) {
                Header("Content-type: image/png");
                ImagePng($image);
            } else {
                if($saveandprint===TRUE){
                    ImagePng($image, $filename);
                    header("Content-type: image/png");
                    ImagePng($image);
                }else{
                    ImagePng($image, $filename);
                }
            }
            
            ImageDestroy($image);
        }
    
        //----------------------------------------------------------------------
        public static function jpg($frame, $filename = false, $pixelPerPoint = 8, $outerFrame = 4, $q = 85) 
        {
            $image = self::image($frame, $pixelPerPoint, $outerFrame);
            
            if ($filename === false) {
                Header("Content-type: image/jpeg");
                ImageJpeg($image, null, $q);
            } else {
                ImageJpeg($image, $filename, $q);            
            }
            
            ImageDestroy($image);
        }
    
        //----------------------------------------------------------------------
        private static function image($frame, $pixelPerPoint = 4, $outerFrame = 4) 
        {
            $h = count($frame);
            $w = strlen($frame[0]);
            
            $imgW = $w + 2*$outerFrame;
            $imgH = $h + 2*$outerFrame;
            
            $base_image =ImageCreate($imgW, $imgH);
            
            $col[0] = ImageColorAllocate($base_image,255,255,255);
            if (defined('QRCODE_COLOR'))
            {
                //echo 'vu';
                $col[1] = ImageColorAllocate($base_image,
                                            hexdec(substr(QRCODE_COLOR, 1, 2)),
                                            hexdec(substr(QRCODE_COLOR, 3, 2)),
                                            hexdec(substr(QRCODE_COLOR, 5, 2)));
            }
            else
                $col[1] = ImageColorAllocate($base_image,0,0,0);
            
            if (defined('QRCODE_COLOR_HAUT_GAUCHE'))
            {
                $col[2] = ImageColorAllocate($base_image,
                                            hexdec(substr(QRCODE_COLOR_HAUT_GAUCHE, 1, 2)),
                                            hexdec(substr(QRCODE_COLOR_HAUT_GAUCHE, 3, 2)),
                                            hexdec(substr(QRCODE_COLOR_HAUT_GAUCHE, 5, 2)));
            }
            else
            {
                if (defined('QRCODE_COLOR'))
                {
                    $col[2] = ImageColorAllocate($base_image,
                                                hexdec(substr(QRCODE_COLOR, 1, 2)),
                                                hexdec(substr(QRCODE_COLOR, 3, 2)),
                                                hexdec(substr(QRCODE_COLOR, 5, 2)));
                }
                else
                    $col[2] = ImageColorAllocate($base_image,0,0,0);
            }
            
            // intérieur du carré en haut à gauche
            if (defined('QRCODE_COLOR_HAUT_GAUCHE_INTERIEUR'))
            {
                $col[5] = ImageColorAllocate($base_image,
                        hexdec(substr(QRCODE_COLOR_HAUT_GAUCHE_INTERIEUR, 1, 2)),
                        hexdec(substr(QRCODE_COLOR_HAUT_GAUCHE_INTERIEUR, 3, 2)),
                        hexdec(substr(QRCODE_COLOR_HAUT_GAUCHE_INTERIEUR, 5, 2)));
            }
            else
            {
                if (defined('QRCODE_COLOR_HAUT_GAUCHE'))
                {
                    $col[5] = ImageColorAllocate($base_image,
                                                hexdec(substr(QRCODE_COLOR_HAUT_GAUCHE, 1, 2)),
                                                hexdec(substr(QRCODE_COLOR_HAUT_GAUCHE, 3, 2)),
                                                hexdec(substr(QRCODE_COLOR_HAUT_GAUCHE, 5, 2)));
                }
                else
                {
                    if (defined('QRCODE_COLOR'))
                    {
                        $col[5] = ImageColorAllocate($base_image,
                                                    hexdec(substr(QRCODE_COLOR, 1, 2)),
                                                    hexdec(substr(QRCODE_COLOR, 3, 2)),
                                                    hexdec(substr(QRCODE_COLOR, 5, 2)));
                    }
                    else
                        $col[5] = ImageColorAllocate($base_image,0,0,0);
                }
            }
            
            if (defined('QRCODE_COLOR_HAUT_DROIT'))
            {
                $col[3] = ImageColorAllocate($base_image,
                                            hexdec(substr(QRCODE_COLOR_HAUT_DROIT, 1, 2)),
                                            hexdec(substr(QRCODE_COLOR_HAUT_DROIT, 3, 2)),
                                            hexdec(substr(QRCODE_COLOR_HAUT_DROIT, 5, 2)));
            }
            else
            {
                if (defined('QRCODE_COLOR'))
                {
                    $col[3] = ImageColorAllocate($base_image,
                                                hexdec(substr(QRCODE_COLOR, 1, 2)),
                                                hexdec(substr(QRCODE_COLOR, 3, 2)),
                                                hexdec(substr(QRCODE_COLOR, 5, 2)));
                }
                else
                    $col[3] = ImageColorAllocate($base_image,0,0,0);
            }
            
            // intérieur du carré en haut à droite
            if (defined('QRCODE_COLOR_HAUT_DROIT_INTERIEUR'))
            {
                $col[6] = ImageColorAllocate($base_image,
                        hexdec(substr(QRCODE_COLOR_HAUT_DROIT_INTERIEUR, 1, 2)),
                        hexdec(substr(QRCODE_COLOR_HAUT_DROIT_INTERIEUR, 3, 2)),
                        hexdec(substr(QRCODE_COLOR_HAUT_DROIT_INTERIEUR, 5, 2)));
            }
            else
            {
                if (defined('QRCODE_COLOR_HAUT_GAUCHE'))
                {
                    $col[6] = ImageColorAllocate($base_image,
                            hexdec(substr(QRCODE_COLOR_HAUT_DROIT, 1, 2)),
                            hexdec(substr(QRCODE_COLOR_HAUT_DROIT, 3, 2)),
                            hexdec(substr(QRCODE_COLOR_HAUT_DROIT, 5, 2)));
                }
                else
                {
                    if (defined('QRCODE_COLOR'))
                    {
                        $col[6] = ImageColorAllocate($base_image,
                                hexdec(substr(QRCODE_COLOR, 1, 2)),
                                hexdec(substr(QRCODE_COLOR, 3, 2)),
                                hexdec(substr(QRCODE_COLOR, 5, 2)));
                    }
                    else
                        $col[6] = ImageColorAllocate($base_image,0,0,0);
                }
            }
            
            if (defined('QRCODE_COLOR_BAS_GAUCHE'))
            {
                $col[4] = ImageColorAllocate($base_image,
                                            hexdec(substr(QRCODE_COLOR_BAS_GAUCHE, 1, 2)),
                                            hexdec(substr(QRCODE_COLOR_BAS_GAUCHE, 3, 2)),
                                            hexdec(substr(QRCODE_COLOR_BAS_GAUCHE, 5, 2)));
            }
            else
            {
                if (defined('QRCODE_COLOR'))
                {
                    $col[4] = ImageColorAllocate($base_image,
                                                hexdec(substr(QRCODE_COLOR, 1, 2)),
                                                hexdec(substr(QRCODE_COLOR, 3, 2)),
                                                hexdec(substr(QRCODE_COLOR, 5, 2)));
                }
                else
                    $col[4] = ImageColorAllocate($base_image,0,0,0);
            }
            
            // intérieur du carré en bas à gauche
            if (defined('QRCODE_COLOR_BAS_GAUCHE_INTERIEUR'))
            {
                $col[7] = ImageColorAllocate($base_image,
                        hexdec(substr(QRCODE_COLOR_BAS_GAUCHE_INTERIEUR, 1, 2)),
                        hexdec(substr(QRCODE_COLOR_BAS_GAUCHE_INTERIEUR, 3, 2)),
                        hexdec(substr(QRCODE_COLOR_BAS_GAUCHE_INTERIEUR, 5, 2)));
            }
            else
            {
                if (defined('QRCODE_COLOR_BAS_GAUCHE'))
                {
                    $col[7] = ImageColorAllocate($base_image,
                            hexdec(substr(QRCODE_COLOR_BAS_GAUCHE, 1, 2)),
                            hexdec(substr(QRCODE_COLOR_BAS_GAUCHE, 3, 2)),
                            hexdec(substr(QRCODE_COLOR_BAS_GAUCHE, 5, 2)));
                }
                else
                {
                    if (defined('QRCODE_COLOR'))
                    {
                        $col[7] = ImageColorAllocate($base_image,
                                hexdec(substr(QRCODE_COLOR, 1, 2)),
                                hexdec(substr(QRCODE_COLOR, 3, 2)),
                                hexdec(substr(QRCODE_COLOR, 5, 2)));
                    }
                    else
                        $col[7] = ImageColorAllocate($base_image,0,0,0);
                }
            }
            

            $frame[0] = '2222222'.substr($frame[0], 7, strlen($frame[0])-14).'3333333';
            $frame[1] = '2000002'.substr($frame[1], 7, strlen($frame[1])-14).'3000003';
            $frame[2] = '2055502'.substr($frame[2], 7, strlen($frame[2])-14).'3066603';
            $frame[3] = '2055502'.substr($frame[3], 7, strlen($frame[3])-14).'3066603';
            $frame[4] = '2055502'.substr($frame[4], 7, strlen($frame[4])-14).'3066603';
            $frame[5] = '2000002'.substr($frame[5], 7, strlen($frame[5])-14).'3000003';
            $frame[6] = '2222222'.substr($frame[6], 7, strlen($frame[6])-14).'3333333';
            
            $frame[count($frame)-7] = '4444444'.substr($frame[count($frame)-7], 7, strlen($frame[count($frame)-7])-7);
            $frame[count($frame)-6] = '4000004'.substr($frame[count($frame)-6], 7, strlen($frame[count($frame)-6])-7);
            $frame[count($frame)-5] = '4077704'.substr($frame[count($frame)-5], 7, strlen($frame[count($frame)-5])-7);
            $frame[count($frame)-4] = '4077704'.substr($frame[count($frame)-4], 7, strlen($frame[count($frame)-4])-7);
            $frame[count($frame)-3] = '4077704'.substr($frame[count($frame)-3], 7, strlen($frame[count($frame)-3])-7);
            $frame[count($frame)-2] = '4000004'.substr($frame[count($frame)-2], 7, strlen($frame[count($frame)-2])-7);
            $frame[count($frame)-1] = '4444444'.substr($frame[count($frame)-1], 7, strlen($frame[count($frame)-1])-7);
            
            imagefill($base_image, 0, 0, $col[0]);

//            print_jc($frame);
//            exit;
            for($y=0; $y<$h; $y++)
            {
                for($x=0; $x<$w; $x++)
                {
                    if ($frame[$y][$x] == '1')
                    {
                        ImageSetPixel($base_image,$x+$outerFrame,$y+$outerFrame,$col[1]); 
                    }
                    else if ($frame[$y][$x] == '0')
                    {
                        ImageSetPixel($base_image,$x+$outerFrame,$y+$outerFrame,$col[0]); 
                    }
                    else if ($frame[$y][$x] == '2')
                    {
                        ImageSetPixel($base_image,$x+$outerFrame,$y+$outerFrame,$col[2]); 
                    }
                    else if ($frame[$y][$x] == '3')
                    {
                        ImageSetPixel($base_image,$x+$outerFrame,$y+$outerFrame,$col[3]); 
                    }
                    else if ($frame[$y][$x] == '4')
                    {
                        ImageSetPixel($base_image,$x+$outerFrame,$y+$outerFrame,$col[4]); 
                    }
                    else if ($frame[$y][$x] == '5')
                    {
                        ImageSetPixel($base_image,$x+$outerFrame,$y+$outerFrame,$col[5]);
                    }
                    else if ($frame[$y][$x] == '6')
                    {
                        ImageSetPixel($base_image,$x+$outerFrame,$y+$outerFrame,$col[6]);
                    }
                    else if ($frame[$y][$x] == '7')
                    {
                        ImageSetPixel($base_image,$x+$outerFrame,$y+$outerFrame,$col[7]);
                    }
                }
            }
            
            $target_image =ImageCreate($imgW * $pixelPerPoint, $imgH * $pixelPerPoint);
            ImageCopyResized($target_image, $base_image, 0, 0, 0, 0, $imgW * $pixelPerPoint, $imgH * $pixelPerPoint, $imgW, $imgH);
            ImageDestroy($base_image);
            
            return $target_image;
        }
    }