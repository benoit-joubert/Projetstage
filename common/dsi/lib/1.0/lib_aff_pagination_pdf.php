<?php
 /**
 * @package common_private
 */
function centreFeuilleFinale()
{
    global $tabPoints, $newTab;
    
    $newTab2 = $newTab;
    //print_r($newTab);
    $i=0;
    //print_r($newTab);
    $Xmax = rechercheXmax();
    //$Xmax = 6;
    
    while($Xmax >= 0)
    {
        //die('ee'.$Xmax);
        $recommenceBranchePrecedente = false;
        foreach($newTab2 as $P => $v)
        {
            if (isset($v['xy']) && $v['xy'][0] == $Xmax) // on est sur la bonne colonne
            {
                if ($v['parent'] != -1)
                {
                    $tabFils = getPagesWhoHaveParent($v['parent']); // on récupère tous les éléments qui possède le meme parent que l'élément
                    $nbFils = count($tabFils);
                    if ($nbFils != 0)
                    {
                        $yMilieu = getMilieuForTabElement($tabFils); // on calcule le milieu des élements
                        $x = $newTab[$v['parent']]['xy'][0];
                        
                        $yAncien = $newTab[$v['parent']]['xy'][1];
                        
//                         if ($yMilieu >= $yAncien) // on bouge le parent
//                         {
                            
//                             bougeElement($v['parent'], $x, $yMilieu); // on déplace le parent au milieu de ses fils
//                             bougeElementDessous($x, $yAncien, ($yMilieu - $yAncien), $v['parent']);
//                         }
//                         else // on bouge le(s) fil(s)
//                         {
//                             bougeElement($P, $v['xy'][0], $yAncien); // on aligne le fils sur la meme ligne que le parent
//                             $y = $v['xy'][1];
//                             bougeElementDessous($v['xy'][0], $yAncien, ($yAncien - $y), $P); // on bouge les éléments d'en dessous
//                             $recommenceBranchePrecedente = true;
//                         }
                        
                        if ($yMilieu >= $yAncien) // on bouge le parent
                        {
                        
                            bougeElement($v['parent'], $x, $yMilieu); // on déplace le parent au milieu de ses fils
                            bougeElementDessous($x, $yAncien, ($yMilieu - $yAncien), $v['parent']);
                        }
                        else // on bouge le(s) fil(s)
                        {
                            // on doit bouger les fil(s) plus bas pour etre aligné avec le parent (déjà plus bas)
                            if ($nbFils == 1)
                            {
                                // un seul fils à bouger => on l'aligne sur le parent
                                bougeElement($P, $v['xy'][0], $yAncien);
                                $y = $v['xy'][1];
                                bougeElementDessous($v['xy'][0], $yAncien, ($yAncien - $y), $P); // on bouge les éléments d'en dessous
                                $recommenceBranchePrecedente = true;
                            }
                            else
                            {
                                // on a a plusieurs fils à bouger...
                                $pMin = $tabFils[0];
                                foreach($tabFils as $pFils)
                                {
                                    if ($newTab[$pFils]['xy'][1] < $newTab[$pMin]['xy'][1])
                                        $pMin = $pFils;
                                }
                                $y = $newTab[$pMin]['xy'][1];
                                //bougeElement($pMin, $v['xy'][0], $yAncien); // on déplace le fils le plus haut
                                //bougeElementDessous($v['xy'][0], $yAncien, ($yAncien - $y), $pMin);
                                //$recommenceBranchePrecedente = true;
                            }
//                                 bougeElement($P, $v['xy'][0], $yAncien); // on aligne le fils sur la meme ligne que le parent
//                             $y = $v['xy'][1];
//                             bougeElementDessous($v['xy'][0], $yAncien, ($yAncien - $y), $P); // on bouge les éléments d'en dessous
//                             $recommenceBranchePrecedente = true;
                        }
                        
                    }
                }
                
            }
            //if ($i == 6 && $P == '41')
            //    break 2;
            //echo '['.$P.']';
        }
        //break;
        //echo '['.$Xmax.']';
        if ($recommenceBranchePrecedente == true)
            $Xmax = $Xmax + 2;
        else
            $Xmax = rechercheXmax($Xmax);
        
        $i++;
//        if ($i == 7)
//            break;
    }
    //return $newTab;
}

function bougeElementDessous($x, $yAncien, $distance, $PaPasBouger)
{
    global $newTab;
    
    foreach($newTab as $P => $v)
    {
        if ($P != $PaPasBouger && isset($v['xy']) && $v['xy'][0] == $x && $v['xy'][1] > $yAncien)
        {
            bougeElement($P, $x, $v['xy'][1] + $distance);
        }
    }
}

function bougeElement($P, $x, $y)
{
    global $newTab, $tabPoints;
    
    unset($tabPoints['x'. $newTab[$P]['xy'][0] .'y'. $newTab[$P]['xy'][1]]);
    
    //$newTab[$P]['MODULE'] .= '('. $newTab[$P]['xy'][1] .'=>'.$y.')';
    
    $newTab[$P]['xy'][0] = $x;
    $newTab[$P]['xy'][1] = $y;
    
    $tabPoints['x'. $x .'y'. $y] = $P;
}

function rechercheXmax($borneSup = 99999999999)
{
    global $newTab;
    $xMax = -1;
    foreach($newTab as $P => $v)
    {
        //if ($v['xy'][0] > $xMax && $v['xy'][0] < $borneSup)
        if (isset($v['xy']) && $v['xy'][0] > $xMax && $v['xy'][0] < $borneSup)
            $xMax = $v['xy'][0];
    }
    return $xMax;
}

function getMilieuForTabElement($tabElement = array())
{
    global $newTab;
    
    $yMin = 1000000000;
    $yMax = -1;
    
    foreach($tabElement as $P)
    {
        $y = $newTab[$P]['xy'][1];
        if ($y < $yMin)
            $yMin = $y;
        if ($y > $yMax)
            $yMax = $y;
    }
    $milieu = ($yMax + $yMin) / 2;
    
    return $milieu;
}

function getPagesWhoHaveParent($Parent)
{
    global $newTab;
    $tab = array();
    foreach($newTab as $P => $v)
    {
        if (isset($v['parent']) && $v['parent'] == $Parent && $v['parent'] != -1)
            $tab[] = $P;
    }
    return $tab;
}

function canElementDrawHere($x, $y)
{
    global $newTab, $tabPoints;
    
    if (isset($tabPoints['x'. $x .'y'. $y]))
        return false;
    
    foreach($newTab as $k => $v)
    {
        if ($v['xy'][0] == $x)
        {
            if ($y - 1 <= $v['xy'][1] && $y >= $v['xy'][1])
                return false;
            if ($y + 1 >= $v['xy'][1] && $y <= $v['xy'][1])
                return false;
        }
    }
    return true;
}

function getMax($xy)
{
    global $newTab;
    $max = 0;
    foreach($newTab as $k => $v)
    {
        if (isset($v['xy']))
            $max = max($v['xy'][$xy], $max);
    }
    return $max;
}

function affichePages($interval = 10)
{
    global $PAGES, $newTab, $tabPoints, $PROJET_ID;
    
    $Pcourant = 0;
    $newTab = $PAGES;
    foreach($newTab as $k => $v)
    {
        if (!is_integer($k))
            unset($newTab[$k]);
    }
    $idProjet = $PROJET_ID;
    
    // Calcul des coordonnées avec le lien vers les parents
    ksort($newTab);
    $newTab[0]['xy'] = array(0,0);
    $newTab[0]['parent'] = -1;
    $tabPoints = array();
    $tabPoints['x0y0'] = 0;
    $espacement = 2;
    foreach($newTab as $P => $v)
    {
        if ($P != 0)
        {
            $Pparent = intval($P/$interval);
            //echo '['.$Pparent .']';
            if (isset($newTab[$Pparent]))
                $newTab[$P]['parent'] = $Pparent;
            else
                $newTab[$P]['parent'] = -1;
            
            if (!isset($newTab[$Pparent]['xy']))
            {
                $x = -2;
                $y = 0;
            }
            else
            {
                $x = $newTab[$Pparent]['xy'][0];
                $y = $newTab[$Pparent]['xy'][1];
            }
            
            if (!isset($tabPoints['x'. ($x+2) .'y'. $y]))
            {
                $x = $x + $espacement;
                $newTab[$P]['xy'] = array($x, $y);
                $tabPoints['x'. $x .'y'. $y] = $P;
            }
            else
            {
                $continue = true;
                $y2 = $espacement;
                $x = $x + $espacement;
                while($continue)
                {
                    if (!isset($tabPoints['x'. $x .'y'. ($y+$y2)]))
                        $continue = false;
                    else
                        $y2 = $y2 + $espacement;
                }
                
                $y = $y + $y2;
                
                $newTab[$P]['xy'] = array($x, $y);
                $tabPoints['x'. $x .'y'. $y] = $P;
            }
            
            // Ajout de la page dans la liste des fils du parent
            if (isset($newTab[$Pparent]))
            {
                if (!isset($newTab[$Pparent]['fils']))
                    $newTab[$Pparent]['fils'] = array();
                $newTab[$Pparent]['fils'][] = $P;
            }
        }
    }
    
    if (isset($_GET['centre']) && $_GET['centre'] == '0')
        centreFeuilleFinale();
    //return;
    class PDF extends FPDF
    {
    }
    //print_jc($newTab);
    $xMax = getMax(0)+2;
    $yMax = getMax(1)+2;
    
    
    $border = 1; // Affiche la bordure aux cellules
    $echelle = 8;
    $i = 0;
    
    $width = 8;
    $height = 5;
    
    $decalageX = 1;
    $decalageY = 10;
    
    $pdfWidth = ($xMax*$echelle*3 + $decalageX);
    $pdfHeight = ($yMax*$echelle*1 + $decalageY);
    //echo $pdfWidth;
    $pdf = new PDF_Gradients('L','mm',array($pdfHeight,$pdfWidth));
    $pdf->AddFont('harmony','','harmony.php');
    $pdf->AddFont('lucida','B','lucida.php');
    $pdf->SetFont('harmony','',5);
    $pdf->SetFillColor(200);
    $pdf->SetAutoPageBreak(false);
    $pdf->AddPage();
    
    
    $red    = array(236, 176, 176);
    $blue   = array(0,0,200);
    $yellow = array(255,255,0);
    $green  = array(0,255,0);
    $white  = array(255);
    $black  = array(0);
    $gris   = array(192,192,192);
    
    //set the coordinates x1,y1,x2,y2 of the gradient (see linear_gradient_coords.jpg)
    $coords = array(0,1,0,0);
    
    //paint a linear gradient
    //$pdf->LinearGradient(100,25,80,80,$red,$blue,$coords);

    foreach($newTab as $P => $v)
    {
        if (isset($v['xy']))
            $x = $v['xy'][0]*$echelle*3 + $decalageX;
        if (isset($v['xy']))
            $y = $v['xy'][1]*$echelle + $decalageY;
        //$newTab[$P]['MODULE'] .= ':'.$v['xy'][0].','.$v['xy'][1];
        //$v['MODULE'] .= ':'.$v['xy'][0].','.$v['xy'][1];
        $pdf->SetFont('harmony','',5);
        $tailleTexte = $pdf->GetStringWidth($v['MODULE'])+2;
        
        $pdf->SetXY($x, $y);
        if (isset($v['SECURE_DROIT']) && $v['SECURE_DROIT'] != '')
            $col = array(180, 176, 236);
        else if (isset($v['SECURE_ACCESS']) && $v['SECURE_ACCESS'] == 1)
            $col = array(236, 176, 176);
        else
            $col = array(176, 236, 182);
        //$pdf->Cell($tailleTexte,$height,$P,$border,'','C',1);
        $pdf->SetFont('lucida','B',8);
        $pdf->LinearGradient($x,$y,$tailleTexte,$height,$col,$white,$coords);
        //$pdf->Cell($tailleTexte, $height, $P, $border,'','C',1);
        $pdf->Cell($tailleTexte, $height, $P, $border,'','C');
        //$pdf->Cell($tailleTexte,$height,$P .' ('. $v['xy'][0] .','. $v['xy'][1] .')',$border,'','C',1);
        $pdf->SetFont('harmony','',5);
        $pdf->SetXY($x, $y+$height);
        $pdf->Cell($tailleTexte,$height,$v['MODULE'],$border);
        //$pdf->Cell($tailleTexte,$height,' ('. $v['xy'][0] .','. $v['xy'][1] .')',$border,'','C',1);
        $xx = $pdf->getX();
        $yy = $pdf->getY();
        if (isset($v['SECURE_DROIT']) && $v['SECURE_DROIT'] != '')
        {
            $pdf->SetFont('harmony','',3);
            $pdf->SetXY($x, $y+$height+$height);
            $pdf->Cell($tailleTexte,2,$v['SECURE_DROIT'],$border);
            $pdf->setXY($xx, $yy);
            $pdf->SetFont('harmony','',5);
        }
        
        
        if (isset($v['parent']) && $v['parent'] != -1)
        {
            $xParent = ($newTab[$v['parent']]['xy'][0])*$echelle*3;
            $yParent = ($newTab[$v['parent']]['xy'][1])*$echelle;
            $widthParent = $pdf->GetStringWidth($newTab[$v['parent']]['MODULE'])+2;
            $pdf->SetDrawColor(100,100,129);
            $pdf->Line($x, $y+($height), $xParent+$widthParent+$decalageX, $yParent+($height)+$decalageY);
            $pdf->SetDrawColor('0 G');
            
        }
        
        $i++;
    }
    $pdf->Line(0, 0, $xMax*$echelle*3 + $decalageX, 0);
    $pdf->Line(0, 0, 0, $yMax*$echelle + $decalageY);
    $pdf->Line($xMax*$echelle*3 + $decalageX, $yMax*$echelle + $decalageY, $xMax*$echelle*3 + $decalageX, 0);
    $pdf->Line($xMax*$echelle*3 + $decalageX, $yMax*$echelle + $decalageY, 0, $yMax*$echelle + $decalageY);
    
    
    //$pdf->Line(0, 5, $xMax*$echelle*3 + $decalageX, 5);
    $pdf->LinearGradient(0,0,$xMax*$echelle*3 + $decalageX,$height, $gris,$white,$coords);
    
    $pdf->SetFont('lucida','B',8);
    $pdf->SetXY(0, 0);
    $txt = 'PROJET_NAME = '.PROJET_NAME.' , $PROJET_ID = '.$idProjet.' , Nombre de modules = '.count($newTab).' , Date impression = '.date('d/m/Y à H:i:s');
    $pdf->Cell($xMax*$echelle*3 + $decalageX, $height, $txt, $border,'','C');
    $pdf->Output();
    exit;
}

?>