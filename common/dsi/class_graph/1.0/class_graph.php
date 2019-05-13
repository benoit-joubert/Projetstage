<?php

require('police.php');

class GraphJC
{
    var $colorVisiteur = '#D6DFF0';
    var $colorVisiteurOmbre = '#A4ADBE';
    
    var $colorPageVue = '#95AED9';
    var $colorPageVueOmbre = '#637CA7';
    
    var $colorCouple = array(
                                'orange' => array('#D9B693', '#A78D63'),
                                'vert' => array('#A0D993', '#70A763'),
                                'blancFonce' => array('#D6DFF0', '#A4ADBE'),
                                'blanc' => array('#EEECEC', '#C8C8C8'),
                                'bleu' => array('#95AED9', '#637CA7'),
                            );
    var $colorFond = '#B3C8E7';//array(179,200,231); //#B3C8E7
    
    var $data = array();
    
    function __construct()
    {
        $this->GraphJC();
    }

    function taille($chaine)
    {
    	$t=0;
    	for ($i=0;$i<strlen($chaine);$i++)
    	{
    		if (substr($chaine,$i,1) == "1")
    			$t=$t+1;
    		else
    			$t=$t+5;
    	}
    	$t=$t+strlen($chaine)-1;
    	return $t;
    }
    
    function getRGB($hex)
    {
        $hex = str_replace('#','',$hex);
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));
        return array($r, $g, $b);
    }
    
    function setData($tab)
    {
        $this->data = $tab;
    }

    function GraphJC()
    {
    }

    function draw()
    {
        $data = $this->data;
    	
    	
    	// Calcul du maximum
    	$v_max = $p_max = $v_sum = $p_sum = 0;
    	foreach($data as $abscisse => $donnees)
    	{
    	    $v_max = max($donnees[1], $v_max);
    	    $p_max = max($donnees[2], $p_max);
    	    $v_sum += $donnees[1];
    	    $p_sum += $donnees[2];
    	}
    	
        $sec = time(); // Seconde depuis 1970
        $jour = date("Y/m/d",$sec); // Récupération du jour actuel
        $jourh = date("Y/m/d",$sec-60*60*24); // Récupération du jour d'hier
        $mois = date("m",$sec); //Récupération du mois en cours
        $premier_jour_sec = mktime(0,0,0,$mois,1,date("Y",$sec));
        $nb_jour = date("t",$sec);
        $dernier_jour_sec = $premier_jour_sec+(60*60*24)*$nb_jour-1;
        $premier_jour = date("Y-m-d",$premier_jour_sec);
        $dernier_jour = date("Y-m-d",$dernier_jour_sec);
        
        $nb_colonne = count($data);//$nb_jour+2;
        $taille_colonne = intval((440-$nb_colonne*4)/$nb_colonne);
    
    
    	// Création de l'image
    	header("Content-type: image/png");
    	$image = imagecreate(550,350);
    	$c = $this->getRGB($this->colorFond);
    	$fondColor = imagecolorallocate($image,$c[0], $c[1], $c[2]); 
    	
    	$bleufonce = imagecolorallocate($image,0,74,101); // #000040
    	
    	$c = $this->getRGB($this->colorCouple['orange'][0]);
    	$bleu      = imagecolorallocate($image,$c[0],$c[1],$c[2]);
    	$c = $this->getRGB($this->colorCouple['orange'][1]);
    	$bleuombre = imagecolorallocate($image,$c[0],$c[1],$c[2]);
    	
    	$orange = imagecolorallocate($image,239,140,50);
    	$orangefonce = imagecolorallocate($image,189,90,0);
        
        //$c = $this->getRGB($this->colorVisiteur);
        $c = $this->getRGB($this->colorCouple['blanc'][0]);
    	$blanc      = imagecolorallocate($image,$c[0],$c[1],$c[2]);
    	//$c = $this->getRGB($this->colorVisiteurOmbre);

    	$c = $this->getRGB($this->colorCouple['blanc'][1]);
    	$blancombre = imagecolorallocate($image,$c[0],$c[1],$c[2]);
    	
    	$gris = imagecolorallocate($image,164,173,190);
    	
    	$rouge = imagecolorallocate($image,255,0,0);
    	$noir = imagecolorallocate($image,0,0,0);
    	
    	// couleur de fond
    	imagefill($image,0,0,$fondColor);
    	
//    	if ($num_site=="all")
//    		$req="	SELECT max(hnb_visiteur), max(hnb_pagevu), sum(hnb_visiteur), sum(hnb_pagevu)
//    		FROM staty_stath
//    		WHERE hdate='$jourh'";
//    	else
//    		$req="	SELECT max(vnb_visiteur), max(vnb_pagevu), sum(vnb_visiteur), sum(vnb_pagevu)
//    		FROM staty_statv
//    		WHERE num_site=$num_site
//    		AND vdate>='$premier_jour'
//    		AND vdate<='$dernier_jour'";
//    	$res_req=mysql_query("$req");
//    	list($v_max,$p_max,$v_sum,$p_sum)=mysql_fetch_array($res_req);
    	//list($v_max,$p_max,$v_sum,$p_sum)= array(50, 30, 580, 887);
    	//echo $req."<BR>";
//    	if ($num_site=="all")
//    		$req="	SELECT hheure, sum(hnb_visiteur), sum(hnb_pagevu)
//    		FROM staty_stath
//    		WHERE hdate='$jourh'
//    		GROUP BY hheure
//    		ORDER BY hheure";
//    	else
//    		$req="SELECT vdate, vnb_visiteur, vnb_pagevu
//    		FROM staty_statv
//    		WHERE num_site=$num_site
//    		AND vdate BETWEEN '$premier_jour' AND '$dernier_jour'
//    		ORDER BY vdate";
    	//echo $req."<BR>";
    	//echo "pouet";
    	if ($p_max != 0)
    	{
    		$hauteur_colonne = 220 / $p_max;
    	}
    	
    	// Base du graphique
    	$tab_points = array(20+26, 280-26, 460+26, 280-26, 460, 280, 20, 280);
    	imagefilledpolygon($image, $tab_points, 4, $bleufonce);
    	imagepolygon($image, $tab_points, 4, $noir);
    
    	// Partie gauche du graphique
    	$tab_points=array(20, 60, 20+26, 60-26, 20+26, 280-26, 20, 280);
    	imagefilledpolygon($image, $tab_points, 4, $gris);

        // Trais de la partie gauche
    	$tab_points=array(20, 60, 20+26, 60-26, 20+26, 60+55-26, 20, 60+55);
    	imagepolygon($image, $tab_points, 4, $noir);
    
    	$tab_points=array(20, 60, 20+26, 60-26, 20+26, 60+55*2-26, 20, 60+55*2);
    	imagepolygon($image, $tab_points, 4, $noir);
    
    	$tab_points=array(20, 60, 20+26, 60-26, 20+26, 60+55*3-26, 20, 60+55*3);
    	imagepolygon($image, $tab_points, 4, $noir);
    
    	$tab_points=array(20, 60, 20+26, 60-26, 20+26, 280-26, 20, 280);
    	imagepolygon($image, $tab_points, 4, $noir);
    	
    	// Trais horizontaux au fond du graphique
    	imagerectangle($image, 20+26, 60-26, 460+26, 280-26, $noir);
    	imagerectangle($image, 20+26, 60+55-26, 460+26, 280-26, $noir);
    	imagerectangle($image, 20+26, 60+55*2-26, 460+26, 280-26, $noir);
    	imagerectangle($image, 20+26, 60+55*3-26, 460+26, 280-26, $noir);
    	
        $h = 0;
    	foreach($data as $abscisse => $donnees)
    	{
    		// PAGES VUES
    		$p = 0;
    			
    		$tab_points_haut=array(
    			0 => 25+$h*$taille_colonne+22+$h*4,
    			1 => 278-intval($p*$hauteur_colonne)-22,
    			2 => 25+($h+1)*$taille_colonne+22+$h*4,
    			3 => 278-intval($p*$hauteur_colonne)-22,
    			4 => 25+($h+1)*$taille_colonne+12+$h*4,
    			5 => 278-intval($p*$hauteur_colonne)-12,
    			6 => 25+$h*$taille_colonne+12+$h*4,
    			7 => 278-intval($p*$hauteur_colonne)-12);
    
    		imagefilledpolygon($image, $tab_points_haut, 4, $bleu);
    		imagepolygon($image, $tab_points_haut, 4, $noir);
    		
    		// VISITEURS
    			
    		$tab_points_haut=array(
    			0 => 25+$h*$taille_colonne+10+$h*4,
    			1 => 278-intval($p*$hauteur_colonne)-10,
    			2 => 25+($h+1)*$taille_colonne+10+$h*4,
    			3 => 278-intval($p*$hauteur_colonne)-10,
    			4 => 25+($h+1)*$taille_colonne+$h*4,
    			5 => 278-intval($p*$hauteur_colonne),
    			6 => 25+$h*$taille_colonne+$h*4,
    			7 => 278-intval($p*$hauteur_colonne));
    
    		imagefilledpolygon($image, $tab_points_haut, 4, $blanc);
    		imagepolygon($image, $tab_points_haut, 4, $noir);
    
            $h++;
    	}
    	
        $h = 0;
    	foreach($data as $abscisse => $donnees)
    	{
    		list($jh,$v,$p) = $donnees;
    		
    		// Page vu
    		$tab_points_face=array(
    			0 => 25+$h*$taille_colonne+$h*4+12,
    			1 => 278-intval($p*$hauteur_colonne)-12,
    			2 => 25+($h+1)*$taille_colonne+$h*4+12,
    			3 => 278-intval($p*$hauteur_colonne)-12,
    			4 => 25+($h+1)*$taille_colonne+$h*4+12,
    			5 => 278-12,
    			6 => 25+$h*$taille_colonne+$h*4+12,
    			7 => 278-12);

    		$tab_points_haut=array(
    			0 => 25+$h*$taille_colonne+10+$h*4+12,
    			1 => 278-intval($p*$hauteur_colonne)-10-12,
    			2 => 25+($h+1)*$taille_colonne+10+$h*4+12,
    			3 => 278-intval($p*$hauteur_colonne)-10-12,
    			4 => 25+($h+1)*$taille_colonne+$h*4+12,
    			5 => 278-intval($p*$hauteur_colonne)-12,
    			6 => 25+$h*$taille_colonne+$h*4+12,
    			7 => 278-intval($p*$hauteur_colonne)-12);
    		
    		$tab_points_cote=array(
    			0 => 25+($h+1)*$taille_colonne+$h*4+12,
    			1 => 278-intval($p*$hauteur_colonne)-12,
    			2 => 25+($h+1)*$taille_colonne+10+$h*4+12,
    			3 => 278-intval($p*$hauteur_colonne)-10-12,
    			4 => 25+($h+1)*$taille_colonne+10+$h*4+12,
    			5 => 278-10-12,
    			6 => 25+($h+1)*$taille_colonne+$h*4+12,
    			7 => 278-12);
    
    		imagefilledpolygon($image, $tab_points_haut, 4, $bleu);
    		imagepolygon($image, $tab_points_haut, 4, $noir);
    
    		imagefilledpolygon($image, $tab_points_face, 4, $bleu);
    		imagepolygon($image, $tab_points_face, 4, $noir);
    		
    		imagefilledpolygon($image, $tab_points_cote, 4, $bleuombre);
    		imagepolygon($image, $tab_points_cote, 4, $noir);
    		
    		// Visiteurs uniques
    		$tab_points_face=array(
    			0 => 25+$h*$taille_colonne+$h*4,
    			1 => 278-intval($v*$hauteur_colonne),
    			2 => 25+($h+1)*$taille_colonne+$h*4,
    			3 => 278-intval($v*$hauteur_colonne),
    			4 => 25+($h+1)*$taille_colonne+$h*4,
    			5 => 278,
    			6 => 25+$h*$taille_colonne+$h*4,
    			7 => 278);
    			
    		$tab_points_haut=array(
    			0 => 25+$h*$taille_colonne+10+$h*4,
    			1 => 278-intval($v*$hauteur_colonne)-10,
    			2 => 25+($h+1)*$taille_colonne+10+$h*4,
    			3 => 278-intval($v*$hauteur_colonne)-10,
    			4 => 25+($h+1)*$taille_colonne+$h*4,
    			5 => 278-intval($v*$hauteur_colonne),
    			6 => 25+$h*$taille_colonne+$h*4,
    			7 => 278-intval($v*$hauteur_colonne));
    
    		$tab_points_cote=array(
    			0 => 25+($h+1)*$taille_colonne+$h*4,
    			1 => 278-intval($v*$hauteur_colonne),
    			2 => 25+($h+1)*$taille_colonne+10+$h*4,
    			3 => 278-intval($v*$hauteur_colonne)-10,
    			4 => 25+($h+1)*$taille_colonne+10+$h*4,
    			5 => 278-10,
    			6 => 25+($h+1)*$taille_colonne+$h*4,
    			7 => 278);
    
    		imagefilledpolygon($image, $tab_points_haut, 4, $blanc);
    		imagepolygon($image, $tab_points_haut, 4, $noir);
    
    		imagefilledpolygon($image, $tab_points_face, 4, $blanc);
    		imagepolygon($image, $tab_points_face, 4, $noir);
    		
    		imagefilledpolygon($image, $tab_points_cote, 4, $blancombre);
    		imagepolygon($image, $tab_points_cote, 4, $noir);
    		
    		$h++;
    	}
    	$police = 1;

    	$i = 0;
    	foreach($data as $abscisse => $donnees)
    	{
//    		if ($abscisse<10)
//    			$abscisse="0$abscisse";
            $txt = $donnees[0];
    		$xcoord = 25+$i*$taille_colonne+intval(($taille_colonne - $this->taille($txt))/2)+1+$i*4;
    		$image = $this->setTexte($image,$xcoord,280+6,$txt,0,74,101);
    		$i++;
    	}
    	
    	$premier_jour = substr($premier_jour,8,2)."/".substr($premier_jour,5,2)."/".substr($premier_jour,0,4);
    	$dernier_jour = substr($dernier_jour,8,2)."/".substr($dernier_jour,5,2)."/".substr($dernier_jour,0,4);
    	
    	//$nom_site = strtoupper($nom_site);
    	$image = $this->setTexte($image,20,310,"NOM DU SITE :",0,0,0);
    	$image = $this->setTexte($image,20,320,"ADRESSE :",0,0,0);
    	$image = $this->setTexte($image,20,330,"PERIODE :",0,0,0);
    	$image = $this->setTexte($image,90,310,"Nom du site",0,74,101);
    	$image = $this->setTexte($image,90,320,"URL SITE",0,74,101);
    	$image = $this->setTexte($image,90,330,"Du $premier_jour au $dernier_jour",0,74,101);
    	
    	$image = $this->setTexte($image,460+26+2,280-26-55*4-3,intval($p_max),0,74,101);
    	$image = $this->setTexte($image,460+26+2,280-26-55*3-3,intval($p_max*3/4),0,74,101);
    	$image = $this->setTexte($image,460+26+2,280-26-55*2-3,intval($p_max*2/4),0,74,101);
    	$image = $this->setTexte($image,460+26+2,280-26-55-3,intval($p_max/4),0,74,101);
    	imagefilledrectangle($image, 56, 15, 56+8, 15+8, $blanc);
    	imagerectangle($image, 56, 15, 56+8, 15+8, $noir);
    	$image = $this->setTexte($image,56+8+3,16,"VISITEURS",0,74,101);
    	$image = $this->setTexte($image,56+8+3+60,16,"TOTAL : $v_sum",0,0,0);
    	imagefilledrectangle($image, 46+280, 15, 46+8+280, 15+8, $bleu);
    	imagerectangle($image, 46+280, 15, 46+8+280, 15+8, $noir);
    	$image = $this->setTexte($image,46+8+3+280,16,"PAGES VUES",0,74,101);
    	$image = $this->setTexte($image,46+8+3+280+70,16,"TOTAL : $p_sum",0,0,0);
    	$image = $this->setTexte($image,280,330,"COPYRIGHT DIRECTION DES SYSTEMES INFORMATIQUES",0,0,0);
    	imagerectangle($image, 0, 0, 549, 349, $noir);
    	imagepng($image);
    }
    
    //Fonction affiche le texte $texte aux coordonnées $x,$y sur l'image $image
    function setTexte($img,$x,$y,$texte,$red,$green,$blue,$espace_yes=0,$border_yes=0,$bred=0,$bgreen=0,$bblue=0)
    {
        global $tableau_caractere;
    	$fill_texte_color=imagecolorallocate($img,$red,$green,$blue);
    	if ($border_yes)
    		$border_texte_color=imagecolorallocate($img,$bred,$bgreen,$bblue);
    	for ($k=0;$k<strlen($texte);$k++)
    	{
    		$caractere = substr($texte,$k,1);
    		$caractere = strtoupper($caractere);
    		$tab_caractere = $tableau_caractere[$caractere]; // on récupère les infos sur le caractère
    		if (count($tab_caractere)==0)
    		{
    			$tab_caractere=$tableau_caractere[" "];
    		}
    		for ($i=0;$i<count($tab_caractere);$i++)
    		{
    			for ($j=0;$j<count($tab_caractere[0]);$j++)
    			{
    				if ($tab_caractere[$i][$j]==1)
    				{
    					imagesetpixel($img,$x+$j,$y+$i,$fill_texte_color);
    				}
    				else
    				{
    					if ($tab_caractere[$i][$j]==0 and $border_yes==1)
    						imagesetpixel($img,$x+$j,$y+$i,$border_texte_color);
    				}
    			}
    		}
    		if ($espace_yes)
    			$x=$x+count($tab_caractere[0]);
    		else
    			$x=$x+count($tab_caractere[0])-1;
    	}
    	return($img);
    }
}
?>