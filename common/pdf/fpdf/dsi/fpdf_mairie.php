<?php
/**
 * @package common
 */
 
/**
 * Classe qui permet de générer des PDF avec les entètes mairie
 * 
 * Exemple d'utilisation de la classe:
 * <code>
 * <?php
 * class PDF extends PDF_Mairie
 * {
 *     function header()
 *     {
 *         if ($this->PageNo() == 1)
 *         {
 *             $this->AjouteTitreDocument();
 *             $this->afficheLogo('NB'); // Affichage du logo
 *             $this->Ln(10);
 *         }
 *         
 *         $this->SetFont('Arial','B',15);
 *         $this->Cell(15, 8, 'N°' , 1, 0, 'C', 1);
 *         $this->Cell(175, 8, 'ASSOCIATION' , 1, 1, 'C', 1);
 *     }
 *     
 *     function footer()
 *     {
 *         $this->AjouteTitreDocumentEnBas();
 *         $this->AjouteDateAujourdhuiEnBas();
 *         $this->AjoutePagination();
 *     }
 * }
 * 
 * $pdf = new PDF();
 * 
 * $pdf->AliasNbPages('{nb}');
 * 
 * $pdf->setEnteteTexte('Direction Générale Adjointe des Services Finance Informatique et de la Programmation'."\n".'Direction des Relations avec les Associations');
 * $pdf->setEnteteTexteTaille(7);
 * $pdf->setEnteteLongueur(50);
 * 
 * $pdf->setTitreDocument('Liste des associations (dossiers actifs)');
 * 
 * $pdf->SetFont('Arial','',6);
 * $pdf->SetFillColor(200);
 * $pdf->AddPage();
 * 
 * $pdf->Output();
 * ?>
 * </code>
 */
class PDF_Mairie extends FPDF
{
    // Variables publiques
    var $enteteLongueur     = 30; // Longueur de la cellule qui contient l'entete (en dessous du blason)
    var $enteteTexte        = 'A Définir via la méthode setEnteteTexte()';
    var $enteteTexteTaille  = 5; // Taille de la police de caractère de l'entete
    var $titreDocument      = '';
    
    // Constantes de couleurs
    var $colors = array(
                        'BLANC' => array(255),
                        'NOIR' => array(0),
                        'GRIS' => array(200),
                       );
    
    // Variables privées
    var $tmpFiles           = array(); // pour l'alpha channel
    var $retraitX           = 15; // Retrait du logo à gauche
    var $retraitY           = 20; // Retrait du logo en haut
    var $version            = 1;
    /*------------------------------------------------------------------------------------------*/
    /*------------------------------------------------------------------------------------------*/
    /*------------------------------------------------------------------------------------------*/
    var $angle = 0;
    var $gradients;

    function LinearGradient($x, $y, $w, $h, $col1=array(), $col2=array(), $coords=array(0,0,1,0)){
        $this->Clip($x,$y,$w,$h);
        $this->Gradient(2,$col1,$col2,$coords);
    }

    function RadialGradient($x, $y, $w, $h, $col1=array(), $col2=array(), $coords=array(0.5,0.5,0.5,0.5,1)){
        $this->Clip($x,$y,$w,$h);
        $this->Gradient(3,$col1,$col2,$coords);
    }

    function CoonsPatchMesh($x, $y, $w, $h, $col1=array(), $col2=array(), $col3=array(), $col4=array(), $coords=array(0.00,0.0,0.33,0.00,0.67,0.00,1.00,0.00,1.00,0.33,1.00,0.67,1.00,1.00,0.67,1.00,0.33,1.00,0.00,1.00,0.00,0.67,0.00,0.33), $coords_min=0, $coords_max=1){
        $this->Clip($x,$y,$w,$h);        
        $n = count($this->gradients)+1;
        $this->gradients[$n]['type']=6; //coons patch mesh
        //check the coords array if it is the simple array or the multi patch array
        if(!isset($coords[0]['f'])){
            //simple array -> convert to multi patch array
            if(!isset($col1[1]))
                $col1[1]=$col1[2]=$col1[0];
            if(!isset($col2[1]))
                $col2[1]=$col2[2]=$col2[0];
            if(!isset($col3[1]))
                $col3[1]=$col3[2]=$col3[0];
            if(!isset($col4[1]))
                $col4[1]=$col4[2]=$col4[0];
            $patch_array[0]['f']=0;
            $patch_array[0]['points']=$coords;
            $patch_array[0]['colors'][0]['r']=$col1[0];
            $patch_array[0]['colors'][0]['g']=$col1[1];
            $patch_array[0]['colors'][0]['b']=$col1[2];
            $patch_array[0]['colors'][1]['r']=$col2[0];
            $patch_array[0]['colors'][1]['g']=$col2[1];
            $patch_array[0]['colors'][1]['b']=$col2[2];
            $patch_array[0]['colors'][2]['r']=$col3[0];
            $patch_array[0]['colors'][2]['g']=$col3[1];
            $patch_array[0]['colors'][2]['b']=$col3[2];
            $patch_array[0]['colors'][3]['r']=$col4[0];
            $patch_array[0]['colors'][3]['g']=$col4[1];
            $patch_array[0]['colors'][3]['b']=$col4[2];
        }
        else{
            //multi patch array
            $patch_array=$coords;
        }
        $bpcd=65535; //16 BitsPerCoordinate
        //build the data stream
        for($i=0;$i<count($patch_array);$i++){
            $this->gradients[$n]['stream'].=chr($patch_array[$i]['f']); //start with the edge flag as 8 bit
            for($j=0;$j<count($patch_array[$i]['points']);$j++){
                //each point as 16 bit
                $patch_array[$i]['points'][$j]=(($patch_array[$i]['points'][$j]-$coords_min)/($coords_max-$coords_min))*$bpcd;
                if($patch_array[$i]['points'][$j]<0) $patch_array[$i]['points'][$j]=0;
                if($patch_array[$i]['points'][$j]>$bpcd) $patch_array[$i]['points'][$j]=$bpcd;
                $this->gradients[$n]['stream'].=chr(floor($patch_array[$i]['points'][$j]/256));
                $this->gradients[$n]['stream'].=chr(floor($patch_array[$i]['points'][$j]%256));
            }
            for($j=0;$j<count($patch_array[$i]['colors']);$j++){
                //each color component as 8 bit
                $this->gradients[$n]['stream'].=chr($patch_array[$i]['colors'][$j]['r']);
                $this->gradients[$n]['stream'].=chr($patch_array[$i]['colors'][$j]['g']);
                $this->gradients[$n]['stream'].=chr($patch_array[$i]['colors'][$j]['b']);
            }
        }
        //paint the gradient
        $this->_out('/Sh'.$n.' sh');
        //restore previous Graphic State
        $this->_out('Q');
    }

    function Clip($x,$y,$w,$h){
        //save current Graphic State
        $s='q';
        //set clipping area
        $s.=sprintf(' %.2f %.2f %.2f %.2f re W n', $x*$this->k, ($this->h-$y)*$this->k, $w*$this->k, -$h*$this->k);
        //set up transformation matrix for gradient
        $s.=sprintf(' %.3f 0 0 %.3f %.3f %.3f cm', $w*$this->k, $h*$this->k, $x*$this->k, ($this->h-($y+$h))*$this->k);
        $this->_out($s);
    }

    function Gradient($type, $col1, $col2, $coords){
        $n = count($this->gradients)+1;
        $this->gradients[$n]['type']=$type;
        if(!isset($col1[1]))
            $col1[1]=$col1[2]=$col1[0];
        $this->gradients[$n]['col1']=sprintf('%.3f %.3f %.3f',($col1[0]/255),($col1[1]/255),($col1[2]/255));
        if(!isset($col2[1]))
            $col2[1]=$col2[2]=$col2[0];
        $this->gradients[$n]['col2']=sprintf('%.3f %.3f %.3f',($col2[0]/255),($col2[1]/255),($col2[2]/255));
        $this->gradients[$n]['coords']=$coords;
        //paint the gradient
        $this->_out('/Sh'.$n.' sh');
        //restore previous Graphic State
        $this->_out('Q');
    }

    function _putshaders(){
        foreach($this->gradients as $id=>$grad){  
            if($grad['type']==2 || $grad['type']==3){
                $this->_newobj();
                $this->_out('<<');
                $this->_out('/FunctionType 2');
                $this->_out('/Domain [0.0 1.0]');
                $this->_out('/C0 ['.$grad['col1'].']');
                $this->_out('/C1 ['.$grad['col2'].']');
                $this->_out('/N 1');
                $this->_out('>>');
                $this->_out('endobj');
                $f1=$this->n;
            }
            
            $this->_newobj();
            $this->_out('<<');
            $this->_out('/ShadingType '.$grad['type']);
            $this->_out('/ColorSpace /DeviceRGB');
            if($grad['type']=='2'){
                $this->_out(sprintf('/Coords [%.3f %.3f %.3f %.3f]',$grad['coords'][0],$grad['coords'][1],$grad['coords'][2],$grad['coords'][3]));
                $this->_out('/Function '.$f1.' 0 R');
                $this->_out('/Extend [true true] ');
                $this->_out('>>');
            }
            elseif($grad['type']==3){
                //x0, y0, r0, x1, y1, r1
                //at this this time radius of inner circle is 0
                $this->_out(sprintf('/Coords [%.3f %.3f 0 %.3f %.3f %.3f]',$grad['coords'][0],$grad['coords'][1],$grad['coords'][2],$grad['coords'][3],$grad['coords'][4]));
                $this->_out('/Function '.$f1.' 0 R');
                $this->_out('/Extend [true true] ');
                $this->_out('>>');
            }
            elseif($grad['type']==6){
                $this->_out('/BitsPerCoordinate 16');
                $this->_out('/BitsPerComponent 8');
                $this->_out('/Decode[0 1 0 1 0 1 0 1 0 1]');
                $this->_out('/BitsPerFlag 8');
                $this->_out('/Length '.strlen($grad['stream']));
                $this->_out('>>');
                $this->_putstream($grad['stream']);
            }
            $this->_out('endobj');
            $this->gradients[$id]['id']=$this->n;
        }
    }

    function _putresourcedict(){
        parent::_putresourcedict();
        $this->_out('/Shading <<');
        foreach($this->gradients as $id=>$grad)
            $this->_out('/Sh'.$id.' '.$grad['id'].' 0 R');
        $this->_out('>>');
    }

    function _putresources(){
        $this->_putshaders();
        parent::_putresources();
    }
    
    function VCell($w,$h=0,$txt='',$border=0,$ln=0,$align='',$fill=0)
    {
        //Output a cell
        $k=$this->k;
        if($this->y+$h>$this->PageBreakTrigger and !$this->InFooter and $this->AcceptPageBreak())
        {
            $x=$this->x;
            $ws=$this->ws;
            if($ws>0)
            {
                $this->ws=0;
                $this->_out('0 Tw');
            }
            $this->AddPage($this->CurOrientation);
            $this->x=$x;
            if($ws>0)
            {
                $this->ws=$ws;
                $this->_out(sprintf('%.3f Tw',$ws*$k));
            }
        }
        if($w==0)
            $w=$this->w-$this->rMargin-$this->x;
        $s='';
    // begin change Cell function
        if($fill==1 or $border>0)
        {
            if($fill==1)
                $op=($border>0) ? 'B' : 'f';
            else
                $op='S';
            if ($border>1) {
                $s=sprintf(' q %.2f w %.2f %.2f %.2f %.2f re %s Q ',$border,
                            $this->x*$k,($this->h-$this->y)*$k,$w*$k,-$h*$k,$op);
            }
            else
                $s=sprintf('%.2f %.2f %.2f %.2f re %s ',$this->x*$k,($this->h-$this->y)*$k,$w*$k,-$h*$k,$op);
        }
        if(is_string($border))
        {
            $x=$this->x;
            $y=$this->y;
            if(is_int(strpos($border,'L')))
                $s.=sprintf('%.2f %.2f m %.2f %.2f l S ',$x*$k,($this->h-$y)*$k,$x*$k,($this->h-($y+$h))*$k);
            else if(is_int(strpos($border,'l')))
                $s.=sprintf('q 2 w %.2f %.2f m %.2f %.2f l S Q ',$x*$k,($this->h-$y)*$k,$x*$k,($this->h-($y+$h))*$k);
                
            if(is_int(strpos($border,'T')))
                $s.=sprintf('%.2f %.2f m %.2f %.2f l S ',$x*$k,($this->h-$y)*$k,($x+$w)*$k,($this->h-$y)*$k);
            else if(is_int(strpos($border,'t')))
                $s.=sprintf('q 2 w %.2f %.2f m %.2f %.2f l S Q ',$x*$k,($this->h-$y)*$k,($x+$w)*$k,($this->h-$y)*$k);
            
            if(is_int(strpos($border,'R')))
                $s.=sprintf('%.2f %.2f m %.2f %.2f l S ',($x+$w)*$k,($this->h-$y)*$k,($x+$w)*$k,($this->h-($y+$h))*$k);
            else if(is_int(strpos($border,'r')))
                $s.=sprintf('q 2 w %.2f %.2f m %.2f %.2f l S Q ',($x+$w)*$k,($this->h-$y)*$k,($x+$w)*$k,($this->h-($y+$h))*$k);
            
            if(is_int(strpos($border,'B')))
                $s.=sprintf('%.2f %.2f m %.2f %.2f l S ',$x*$k,($this->h-($y+$h))*$k,($x+$w)*$k,($this->h-($y+$h))*$k);
            else if(is_int(strpos($border,'b')))
                $s.=sprintf('q 2 w %.2f %.2f m %.2f %.2f l S Q ',$x*$k,($this->h-($y+$h))*$k,($x+$w)*$k,($this->h-($y+$h))*$k);
        }
        if(trim($txt)!='')
        {
            $cr=substr_count($txt,"\n");
            if ($cr>0) { // Multi line
                $txts = explode("\n", $txt);
                $lines = count($txts);
                for($l=0;$l<$lines;$l++) {
                    $txt=$txts[$l];
                    $w_txt=$this->GetStringWidth($txt);
                    if ($align=='U')
                        $dy=$this->cMargin+$w_txt;
                    elseif($align=='D')
                        $dy=$h-$this->cMargin;
                    else
                        $dy=($h+$w_txt)/2;
                    $txt=str_replace(')','\\)',str_replace('(','\\(',str_replace('\\','\\\\',$txt)));
                    if($this->ColorFlag)
                        $s.='q '.$this->TextColor.' ';
                    $s.=sprintf('BT 0 1 -1 0 %.2f %.2f Tm (%s) Tj ET ',
                        ($this->x+.5*$w+(.7+$l-$lines/2)*$this->FontSize)*$k,
                        ($this->h-($this->y+$dy))*$k,$txt);
                    if($this->ColorFlag)
                        $s.=' Q ';
                }
            }
            else { // Single line
                $w_txt=$this->GetStringWidth($txt);
                $Tz=100;
                if ($w_txt>$h-2*$this->cMargin) {
                    $Tz=($h-2*$this->cMargin)/$w_txt*100;
                    $w_txt=$h-2*$this->cMargin;
                }
                if ($align=='U')
                    $dy=$this->cMargin+$w_txt;
                elseif($align=='D')
                    $dy=$h-$this->cMargin;
                else
                    $dy=($h+$w_txt)/2;
                $txt=str_replace(')','\\)',str_replace('(','\\(',str_replace('\\','\\\\',$txt)));
                if($this->ColorFlag)
                    $s.='q '.$this->TextColor.' ';
                $s.=sprintf('q BT 0 1 -1 0 %.2f %.2f Tm %.2f Tz (%s) Tj ET Q ',
                            ($this->x+.5*$w+.3*$this->FontSize)*$k,
                            ($this->h-($this->y+$dy))*$k,$Tz,$txt);
                if($this->ColorFlag)
                    $s.=' Q ';
            }
        }
    // end change Cell function
        if($s)
            $this->_out($s);
        $this->lasth=$h;
        if($ln>0)
        {
            //Go to next line
            $this->y+=$h;
            if($ln==1)
                $this->x=$this->lMargin;
        }
        else
            $this->x+=$w;
    }

    /*------------------------------------------------------------------------------------------*/
    /*------------------------------------------------------------------------------------------*/
    /*------------------------------------------------------------------------------------------*/
	
    function __construct($orientation='P',$unit='mm',$format='A4')
    {
        $this->PDF_Mairie($orientation,$unit,$format);
    }

	function PDF_Mairie($orientation='P',$unit='mm',$format='A4')
	{
        parent::FPDF($orientation,$unit,$format);
        $this->gradients=array();
        $this->AddFont('futura','B','futura_heavy.php');
        $this->AddFont('futura','','futura_light.php');
        $this->AddFont('wingding','','wingding.php');
	}
	
	
	/**
	 * Définition de la version du PDF que l'on souhaite générer
	 * 
	 * @param int $version Version souhaité du PDF (1 ou 2)
	 */
	function setVersion($version)
	{
	    $this->version = $version;
	}
	
    /**
     * Affiche le logo de la mairie ainsi que l'organisation
     * 
     * @param string $couleur Défini la couleur du logo
     * ('COULEUR' => logo couleur, 'NB' => logo noir et blanc)
     */
    function afficheLogo($couleur='COULEUR', $tailleLogoWidth = 35)
    {
        if ($this->version == 2)
        {
            $this->SetXY($this->retraitX, $this->retraitY);
            $border = 0;
            if ($couleur == 'COULEUR')
    	        $this->Image(FPDF_FONTPATH . 'blasonaix_officiel_2015.jpg',$this->retraitX,$this->retraitY, $tailleLogoWidth);
     	    else
     	        $this->Image(FPDF_FONTPATH . 'blasonaix_officiel_2015_nb.jpg',$this->retraitX,$this->retraitY, $tailleLogoWidth);
            //$this->Ln(1);
            
            
//             $this->SetXY($this->retraitX, $this->retraitY);
//             //$pdf->Image('D:\Sites\ciq\images\logo_aix_couleur.jpg',10,10, 24);
//             $this->Cell($tailleLogoWidth + 0.5, 30,'', $border, 1, 'C', 0);
            
            
            
//             // Aix en provence
//             $this->SetXY(($this->retraitX+10)-(40/2), $this->retraitY+29);
//             $this->SetFont('times','B',12.5);
//             $this->MultiCell(40, 3, 'Aix en Provence', $border, 'C');
            
//             // Ville thermale et climatique
            
//             $this->SetXY(($this->retraitX+10)-(30/2), $this->retraitY+32);
//             $this->SetFont('Arial','',4);
//             $this->Cell(30, 3, ' ILLE     HERMALE ET     LIMATIQUE', $border, 0, 'C');
            
            
//             $this->SetFont('Arial','',6);
            
//             // V
//             $this->SetXY(($this->retraitX+10)-(30/2)+2.4, $this->retraitY+31.8);
//             $this->Cell(1, 3, 'V', 0, 0, 'C');
            
//             // T
//             $this->SetXY(($this->retraitX+10)-(30/2)+7.3, $this->retraitY+31.8);
//             $this->Cell(1, 3, 'T', 0, 0, 'C');
            
//             // C
//             $this->SetXY(($this->retraitX+10)-(30/2)+18, $this->retraitY+31.8);
//             $this->Cell(1, 3, 'C', 0, 0, 'C');
            
            // Entete
            //$this->enteteLongueur = 44;
            //$this->Ln(20);
            
            //$this->SetXY(($this->retraitX+20)-($this->enteteLongueur/2), $this->retraitY+20);
            $this->SetXY(($this->retraitX+17.5)-($this->enteteLongueur/2), $this->retraitY+21);
            $this->SetFont('futura','',$this->enteteTexteTaille);
            $this->MultiCell($this->enteteLongueur, 3, $this->enteteTexte, $border, 'C');
            $this->SetY($this->retraitY+41);
        }
        else
        {
            $border = 0;
            $this->SetXY($this->retraitX, $this->retraitY);
            if ($couleur == 'COULEUR')
     	        $this->Image(FPDF_FONTPATH . 'blasonaix_officiel_2015.jpg',$this->retraitX,$this->retraitY, $tailleLogoWidth);
     	    else
     	        $this->Image(FPDF_FONTPATH . 'blasonaix_officiel_2015_nb.jpg',$this->retraitX,$this->retraitY, $tailleLogoWidth);
            
            
            //             if ($couleur == 'COULEUR')
           // $this->Image(FPDF_FONTPATH . 'blasonaix_officiel_2015.jpg',$this->retraitX,$this->retraitY, $tailleLogoWidth);
            
//             $this->Ln(1);
//             $this->SetXY($this->retraitX, $this->retraitY);
//             //$pdf->Image('D:\Sites\ciq\images\logo_aix_couleur.jpg',10,10, 24);
//             $this->Cell(20 + 0.5, 30,'', $border, 1, 'C', 0);
            
            
            
//             // Aix en provence
//             $this->SetXY(($this->retraitX+10)-(40/2), $this->retraitY+29);
//             $this->SetFont('times','B',12.5);
//             $this->MultiCell(40, 3, 'Aix en Provence', $border, 'C');
            
//             // Ville thermale et climatique
            
//             $this->SetXY(($this->retraitX+10)-(30/2), $this->retraitY+32);
//             $this->SetFont('Arial','',4);
//             $this->Cell(30, 3, ' ILLE     HERMALE ET     LIMATIQUE', $border, 0, 'C');
            
            
//             $this->SetFont('Arial','',6);
            
//             // V
//             $this->SetXY(($this->retraitX+10)-(30/2)+2.4, $this->retraitY+31.8);
//             $this->Cell(1, 3, 'V', 0, 0, 'C');
            
//             // T
//             $this->SetXY(($this->retraitX+10)-(30/2)+7.3, $this->retraitY+31.8);
//             $this->Cell(1, 3, 'T', 0, 0, 'C');
            
//             // C
//             $this->SetXY(($this->retraitX+10)-(30/2)+18, $this->retraitY+31.8);
//             $this->Cell(1, 3, 'C', 0, 0, 'C');
            
//             $this->enteteLongueur = 44;
            //$this->Ln(20);
            
            // Entete
            $this->SetXY(($this->retraitX+17.5)-($this->enteteLongueur/2), $this->retraitY+21);
            $this->SetFont('Arial','',$this->enteteTexteTaille);
            $this->MultiCell($this->enteteLongueur, 3, $this->enteteTexte, $border, 'C');
            $this->SetY($this->retraitY+41);
        }
    }
    
    /**
     * Affiche le numéro de page ainsi que le nombre total de pages en bas à droite de la page
     */
    function AjoutePagination()
    {
        if ($this->version == 2)
        {
            //$this->SetXY(230,285);
            $this->SetY($this->h-10); // on se place en bas
            $this->SetFont('futura','',6);
            $this->Cell(0, 8, $this->PageNo().' / {nb}' , 0, 0, 'R', 0);
        }
        else
        {
            //$this->SetXY(230,285);
            $this->SetY($this->h-10); // on se place en bas
            $this->SetFont('Arial','',6);
            $this->Cell(0, 8, $this->PageNo().' / {nb}' , 0, 0, 'R', 0);
        }
        
    }
    
    /**
     * Affiche le titre du document en bas au milieu de la page
     */
    function AjouteTitreDocumentEnBas()
    {
        if ($this->version == 2)
        {
            //$this->SetY(285);
            $this->SetY($this->h-10); // on se place en bas
            $this->SetFont('futura','',6);
            $this->Cell(0, 8, $this->titreDocument , 0, 0, 'C', 0);
        }
        else
        {
            //$this->SetY(285);
            $this->SetY($this->h-10); // on se place en bas
            $this->SetFont('Arial','',6);
            $this->Cell(0, 8, $this->titreDocument , 0, 0, 'C', 0);
        }
    }
    
    /**
     * Affiche le titre du document en haut à droite à coté du logo
     */
    function AjouteTitreDocument()
    {
        if ($this->version == 2)
        {
            $this->SetXY($this->retraitX+40, $this->retraitY);
            $this->SetFont('futura','B',14);
            $this->MultiCell(0, 8, $this->titreDocument, 0, 'R', 0);
            return $this->GetStringWidth($this->titreDocument);
        }
        else
        {
            $this->SetXY($this->retraitX+40, $this->retraitY);
            $this->SetFont('Arial','B',14);
            $this->MultiCell(0, 8, $this->titreDocument , 0, 'R', 0);
            return $this->GetStringWidth($this->titreDocument);
        }
    }
    
    /**
     * Affiche la date du jour en bas au milieu de la page
     * (au dessus du titre du document)
     */
    function AjouteDateAujourdhuiEnBas()
    {
        
        if ($this->version == 2)
        {
            //$this->SetY(280);
            $this->SetY($this->h-15); // on se place en bas
            $this->SetFont('futura','',6);
            $this->Cell(0, 8, date('d/m/Y') , 0, 0, 'C', 0);
        }
        else
        {
            //$this->SetY(280);
            $this->SetY($this->h-15); // on se place en bas
            $this->SetFont('Arial','',6);
            $this->Cell(0, 8, date('d/m/Y') , 0, 0, 'C', 0);
        }
    }
    
    /**
     * Affiche des cases blanche pour la saisie via stylot
     */
    function afficheCaseBlance($nbCase, $contenu = '', $alignement='L', $ajoutPixel = 0, $hauteur = 3)
    {
        $y = $this->getY();
        $x = $this->getX();
        $this->setXY($x, $y+0.5+$ajoutPixel);
        
        if ($alignement == 'R') // le texte est aligné à gauche
            $contenu = sprintf("%".$nbCase."s", $contenu);
        $this->SetFillColor(255);
        for($i=0; $i < $nbCase; $i++)
        {
            $lettre = ' ';
            if ($contenu != '')
            {
                $lettre = substr($contenu, $i, 1);
            }
            
            $this->Cell($hauteur, $hauteur, $lettre, 0, 0, 'C',1); // $this->Cell(3, 3, $lettre, 0, 0, 'C',1);
            $this->Cell(1, $hauteur, ' ', 0, 0, 'L',0);
        }
        $x = $this->getX();
        $this->setXY($x, $y);
    }
    
    /**
     * Affiche un cadre vert gris avec un numéro de puce et un titre
     */
    function cadreVertGris($numeroPuce, $titre, $hauteur, $largeur = 0, $alignement = 'L', $background = 1, $taillePolice = 8, $hauteurLigneTitre = 4)
    {
        $largeurTitre = $largeur;

        $x = $this->getX();
        
        $this->SetFont('futura','B', $taillePolice);
        $this->SetTextColor(255,255,255);
        $this->SetFillColor(155,212,65);
        
        $taillePuce = $this->getStringWidth($numeroPuce)+1;
        
        if ($largeur != 0)
            $largeurTitre = $largeur-$taillePuce;
        $yDebut = $this->getY();
        
        $this->Cell($taillePuce, $hauteurLigneTitre, '', 0, 0, 'L',1);
        $this->SetTextColor(0,0,0);
        $this->MultiCell($largeurTitre, $hauteurLigneTitre, $titre, 0, 1, $alignement,1);
        $y = $this->getY();
        
        $this->setXY($x, $yDebut);
        $this->SetFont('futura','B', $taillePolice);
        $this->SetTextColor(255,255,255);
        $this->SetFillColor(155,212,65);
        $this->Cell($taillePuce, ($y-$yDebut), $numeroPuce, 0, 1, 'L',1);
        $this->SetTextColor(0,0,0);
        
        $this->setXY($x, $y);
        
        $this->SetFillColor(230);
        $this->SetDrawColor(150,150,150);
        $this->Cell($largeur, $hauteur, '', 'TLRB', 1, 'L',$background);
        $this->SetDrawColor(0,0,0);
        $this->SetFillColor(200);
        
        $this->setY($y);
        $this->setX($x);
    }
    
    /**
     * Affiche un orange vert gris avec un numéro de puce et un titre
     */
    function cadreOrangeGris($numeroPuce, $titre, $hauteur, $largeur = 0, $alignement = 'L', $background = 1, $taillePolice = 8, $hauteurLigneTitre = 4)
    {
        
        $largeurTitre = $largeur;

        $x = $this->getX();
        
        $this->SetFont('futura','B',$taillePolice);
        $this->SetTextColor(255,255,255);
        $this->SetFillColor(212,116,64);
        
        $taillePuce = $this->getStringWidth($numeroPuce)+1;
        
        if ($largeur != 0)
            $largeurTitre = $largeur-$taillePuce;

        $this->Cell($taillePuce, $hauteurLigneTitre, $numeroPuce, 0, 0, 'L',1);
        $this->SetTextColor(0,0,0);
        $this->Cell($largeurTitre, $hauteurLigneTitre, $titre, 0, 1, $alignement,1);
        $y = $this->getY();
        
        $this->setX($x);
        
        $this->SetFillColor(230);
        $this->SetDrawColor(150,150,150);
        $this->Cell($largeur, $hauteur, '', 'TLRB', 1, 'L',$background);
        $this->SetDrawColor(0,0,0);
        $this->SetFillColor(200);
        
        $this->setY($y);
        $this->setX($x);
    }
    
    /**
     * Affiche un cadre violet gris avec un numéro de puce et un titre
     */
    function cadreVioletGris($numeroPuce, $titre, $hauteur, $largeur = 0, $alignement = 'L', $background = 1, $taillePolice = 8, $hauteurLigneTitre = 4)
    {
        $largeurTitre = $largeur;

        $x = $this->getX();
        
        $this->SetFont('futura','B', $taillePolice);
        $this->SetTextColor(0, 0, 0);
//        $this->SetFillColor(237, 0, 140);//155,212,65);

        //$this->SetFillColor(212, 64, 172);
        //$this->SetFillColor(123, 20, 107);
        $this->SetFillColor(0, 168, 143);
        
            
        $taillePuce = $this->getStringWidth($numeroPuce)+1;
        
        if ($largeur != 0)
            $largeurTitre = $largeur-$taillePuce;
        $this->SetTextColor(255, 255, 255);
        
        $this->Cell($taillePuce, $hauteurLigneTitre, $numeroPuce, 0, 0, 'L',1);
        //$this->SetTextColor(255, 255, 255);
        $this->SetTextColor(255, 240, 42);
        $this->Cell($largeurTitre, $hauteurLigneTitre, $titre, 0, 1, $alignement,1);
        $this->SetTextColor(0,0,0);
        $y = $this->getY();
        
        $this->setX($x);
        
        $this->SetFillColor(200);
        $this->SetDrawColor(150,150,150);
        $this->Cell($largeur, $hauteur, '', 'TLRB', 1, 'L',$background);
        $this->SetDrawColor(0,0,0);
        $this->SetFillColor(200);
        
        $this->setY($y);
        $this->setX($x);
    }


    
    /**
     * Affiche un cadre marron gris avec un numéro de puce et un titre
     */
    function cadreMarronGris($numeroPuce, $titre, $hauteur, $largeur = 0, $alignement = 'L', $background = 1, $taillePolice = 8, $hauteurLigneTitre = 4)
    {
        $largeurTitre = $largeur;

        $x = $this->getX();
        
        $this->SetFont('futura','B', $taillePolice);
        $this->SetTextColor(0, 0, 0);
//        $this->SetFillColor(237, 0, 140);//155,212,65);
        //$this->SetFillColor(212, 64, 172);
        $this->SetFillColor(156, 89, 58);
        $taillePuce = $this->getStringWidth($numeroPuce)+1;
        
        if ($largeur != 0)
            $largeurTitre = $largeur-$taillePuce;

        $this->Cell($taillePuce, $hauteurLigneTitre, $numeroPuce, 0, 0, 'L',1);
        $this->SetTextColor(255, 255, 255);
        $this->Cell($largeurTitre, $hauteurLigneTitre, $titre, 0, 1, $alignement,1);
        $this->SetTextColor(0,0,0);
        $y = $this->getY();
        
        $this->setX($x);
        
        $this->SetFillColor(200);
        $this->SetDrawColor(150,150,150);
        $this->Cell($largeur, $hauteur, '', 'TLRB', 1, 'L',$background);
        $this->SetDrawColor(0,0,0);
        $this->SetFillColor(200);
        
        $this->setY($y);
        $this->setX($x);
    }
    /**
     * Affiche des ciseaux ainsi qu'un trait
     */
    function afficheCiseaux($longueur = 100, $espacement = 1)
    {
        $this->SetFont('wingding','',16);
        $this->Cell(6, 5, chr(34), 0, 0, 'L',0);
        $this->SetFont('futura', '', 10);
        $this->setXY($this->getX(), $this->getY()-0.70);
        for($i = 0; $i < $longueur; $i++)
        {
            $this->Cell(1, 5, '-', 0, 0, 'C',0);
            for($j=0; $j < $espacement; $j++)
                $this->Cell(1, 5, ' ', 0, 0, 'C',0);
        }
    }
    
	/**
	 * Défini le texte à afficher sous le logo de la mairie
	 * @param string $enteteTxt Texte qui sera affiché en dessous du logo
	 * (vous pouvez mettre des \n pour les retours à la ligne
	 */
	function setEnteteTexte($enteteTxt)
	{
	    $this->enteteTexte = $enteteTxt;
	}
	
	/**
	 * Défini la marge de retrait à gauche
	 */
	function setRetraitX($val)
	{
	    $this->retraitX = $val;
	}
	
	/**
	 * Défini la marge de retrait en haut
	 */
	function setRetraitY($val)
	{
	    $this->retraitY = $val;
	}
	
	/**
	 * Défini le titre du document
	 * @param string $txt Modifie le titre du document
	 */
	function setTitreDocument($txt)
	{
	    $this->titreDocument = $txt;
	}
	
	/**
	 * Défini la taille de la police qui affiche l'entete
	 * @param int $taille Modifie la taille de la police du texte en 
	 */
	function setEnteteTexteTaille($taille)
	{
	    $this->enteteTexteTaille = $taille;
	}
	
	/**
	 * Défini la longueur de la cellule qui contient l'entete (en dessous du logo mairie)
	 */
	function setEnteteLongueur($val)
	{
	    $this->enteteLongueur = $val;
	}

    /*******************************************************************************
    *                                                                              *
    *                               Public methods                                 *
    *                                                                              *
    *******************************************************************************/
    function Image($file,$x=null,$y=null,$w=0,$h=0,$type='',$link='', $isMask=false, $maskImg=0)
    {
        //Put an image on the page
        if(!isset($this->images[$file]))
        {
            //First use of image, get info
            if($type=='')
            {
                $pos=strrpos($file,'.');
                if(!$pos)
                    $this->Error('Image file has no extension and no type was specified: '.$file);
                $type=substr($file,$pos+1);
            }
            $type=strtolower($type);
            //$mqr=get_magic_quotes_runtime();
            //set_magic_quotes_runtime(0);
            if($type=='jpg' || $type=='jpeg')
                $info=$this->_parsejpg($file);
            elseif($type=='png'){
                $info=$this->_parsepng($file);
                if($info=='alpha')
                    return $this->ImagePngWithAlpha($file,$x,$y,$w,$h,$link);
            }
            else
            {
                //Allow for additional formats
                $mtd='_parse'.$type;
                if(!method_exists($this,$mtd))
                    $this->Error('Unsupported image type: '.$type);
                $info=$this->$mtd($file);
            }
            //set_magic_quotes_runtime($mqr);
            
            if($isMask){
                if(in_array($file,$this->tmpFiles))
                    $info['cs']='DeviceGray'; //hack necessary as GD can't produce gray scale images
                if($info['cs']!='DeviceGray')
                    $this->Error('Mask must be a gray scale image');
                if($this->PDFVersion<'1.4')
                    $this->PDFVersion='1.4';
            }
            $info['i']=count($this->images)+1;
            if($maskImg>0)
                $info['masked'] = $maskImg;
            $this->images[$file]=$info;
        }
        else
            $info=$this->images[$file];
        //Automatic width and height calculation if needed
        if($w==0 && $h==0)
        {
            //Put image at 72 dpi
            $w=$info['w']/$this->k;
            $h=$info['h']/$this->k;
        }
        if($w==0)
            $w=$h*$info['w']/$info['h'];
        if($h==0)
            $h=$w*$info['h']/$info['w'];
            
        if(!$isMask)
            $this->_out(sprintf('q %.2f 0 0 %.2f %.2f %.2f cm /I%d Do Q',$w*$this->k,$h*$this->k,$x*$this->k,($this->h-($y+$h))*$this->k,$info['i']));
        if($link)
            $this->Link($x,$y,$w,$h,$link);
            
        return $info['i'];
    }
    
    // needs GD 2.x extension
    // pixel-wise operation, not very fast
    function ImagePngWithAlpha($file,$x,$y,$w=0,$h=0,$link='')
    {
        $tmp_alpha = tempnam('.', 'mska');
        $this->tmpFiles[] = $tmp_alpha;
        $tmp_plain = tempnam('.', 'mskp');
        $this->tmpFiles[] = $tmp_plain;
    
        list($wpx, $hpx) = getimagesize($file);
        $img = imagecreatefrompng($file);
        $alpha_img = imagecreate( $wpx, $hpx );
    
        // generate gray scale pallete
        for($c=0;$c<256;$c++)
            ImageColorAllocate($alpha_img, $c, $c, $c);
    
        // extract alpha channel
        $xpx=0;
        while ($xpx<$wpx){
            $ypx = 0;
            while ($ypx<$hpx){
                $color_index = imagecolorat($img, $xpx, $ypx);
                $col = imagecolorsforindex($img, $color_index);
                imagesetpixel($alpha_img, $xpx, $ypx, $this->_gamma( (127-$col['alpha'])*255/127) );
                ++$ypx;
            }
            ++$xpx;
        }
    
        imagepng($alpha_img, $tmp_alpha);
        imagedestroy($alpha_img);
    
        // extract image without alpha channel
        $plain_img = imagecreatetruecolor ( $wpx, $hpx );
        imagecopy($plain_img, $img, 0, 0, 0, 0, $wpx, $hpx );
        imagepng($plain_img, $tmp_plain);
        imagedestroy($plain_img);
        
        //first embed mask image (w, h, x, will be ignored)
        $maskImg = $this->Image($tmp_alpha, 0,0,0,0, 'PNG', '', true);
        
        //embed image, masked with previously embedded mask
        $this->Image($tmp_plain,$x,$y,$w,$h,'PNG',$link, false, $maskImg);
    }
    
    function Close()
    {
        parent::Close();
        // clean up tmp files
        foreach($this->tmpFiles as $tmp)
            @unlink($tmp);
    }
    
    /*******************************************************************************
    *                                                                              *
    *                               Private methods                                *
    *                                                                              *
    *******************************************************************************/
    function _putimages()
    {
        $filter=($this->compress) ? '/Filter /FlateDecode ' : '';
        reset($this->images);
        while(list($file,$info)=each($this->images))
        {
            $this->_newobj();
            $this->images[$file]['n']=$this->n;
            $this->_out('<</Type /XObject');
            $this->_out('/Subtype /Image');
            $this->_out('/Width '.$info['w']);
            $this->_out('/Height '.$info['h']);
    
            if(isset($info['masked']))
                $this->_out('/SMask '.($this->n-1).' 0 R');
    
            if($info['cs']=='Indexed')
                $this->_out('/ColorSpace [/Indexed /DeviceRGB '.(strlen($info['pal'])/3-1).' '.($this->n+1).' 0 R]');
            else
            {
                $this->_out('/ColorSpace /'.$info['cs']);
                if($info['cs']=='DeviceCMYK')
                    $this->_out('/Decode [1 0 1 0 1 0 1 0]');
            }
            $this->_out('/BitsPerComponent '.$info['bpc']);
            if(isset($info['f']))
                $this->_out('/Filter /'.$info['f']);
            if(isset($info['parms']))
                $this->_out($info['parms']);
            if(isset($info['trns']) && is_array($info['trns']))
            {
                $trns='';
                for($i=0;$i<count($info['trns']);$i++)
                    $trns.=$info['trns'][$i].' '.$info['trns'][$i].' ';
                $this->_out('/Mask ['.$trns.']');
            }
            $this->_out('/Length '.strlen($info['data']).'>>');
            $this->_putstream($info['data']);
            unset($this->images[$file]['data']);
            $this->_out('endobj');
            //Palette
            if($info['cs']=='Indexed')
            {
                $this->_newobj();
                $pal=($this->compress) ? gzcompress($info['pal']) : $info['pal'];
                $this->_out('<<'.$filter.'/Length '.strlen($pal).'>>');
                $this->_putstream($pal);
                $this->_out('endobj');
            }
        }
    }

    // GD seems to use a different gamma, this method is used to correct it again
    function _gamma($v){
        return pow ($v/255, 2.2) * 255;
    }

    // this method overwriing the original version is only needed to make the Image method support PNGs with alpha channels.
    // if you only use the ImagePngWithAlpha method for such PNGs, you can remove it from this script.
    function _parsepng($file)
    {
        //Extract info from a PNG file
        $f=fopen($file,'rb');
        if(!$f)
            $this->Error('Can\'t open image file: '.$file);
        //Check signature
        if(fread($f,8)!=chr(137).'PNG'.chr(13).chr(10).chr(26).chr(10))
            $this->Error('Not a PNG file: '.$file);
        //Read header chunk
        fread($f,4);
        if(fread($f,4)!='IHDR')
            $this->Error('Incorrect PNG file: '.$file);
        $w=$this->_freadint($f);
        $h=$this->_freadint($f);
        $bpc=ord(fread($f,1));
        if($bpc>8)
            $this->Error('16-bit depth not supported: '.$file);
        $ct=ord(fread($f,1));
        if($ct==0)
            $colspace='DeviceGray';
        elseif($ct==2)
            $colspace='DeviceRGB';
        elseif($ct==3)
            $colspace='Indexed';
        else {
            fclose($f);      // the only changes are
            return 'alpha';  // made in those 2 lines
        }
        if(ord(fread($f,1))!=0)
            $this->Error('Unknown compression method: '.$file);
        if(ord(fread($f,1))!=0)
            $this->Error('Unknown filter method: '.$file);
        if(ord(fread($f,1))!=0)
            $this->Error('Interlacing not supported: '.$file);
        fread($f,4);
        $parms='/DecodeParms <</Predictor 15 /Colors '.($ct==2 ? 3 : 1).' /BitsPerComponent '.$bpc.' /Columns '.$w.'>>';
        //Scan chunks looking for palette, transparency and image data
        $pal='';
        $trns='';
        $data='';
        do
        {
            $n=$this->_freadint($f);
            $type=fread($f,4);
            if($type=='PLTE')
            {
                //Read palette
                $pal=fread($f,$n);
                fread($f,4);
            }
            elseif($type=='tRNS')
            {
                //Read transparency info
                $t=fread($f,$n);
                if($ct==0)
                    $trns=array(ord(substr($t,1,1)));
                elseif($ct==2)
                    $trns=array(ord(substr($t,1,1)),ord(substr($t,3,1)),ord(substr($t,5,1)));
                else
                {
                    $pos=strpos($t,chr(0));
                    if($pos!==false)
                        $trns=array($pos);
                }
                fread($f,4);
            }
            elseif($type=='IDAT')
            {
                //Read image data block
                $data.=fread($f,$n);
                fread($f,4);
            }
            elseif($type=='IEND')
                break;
            else
                fread($f,$n+4);
        }
        while($n);
        if($colspace=='Indexed' && empty($pal))
            $this->Error('Missing palette in '.$file);
        fclose($f);
        return array('w'=>$w,'h'=>$h,'cs'=>$colspace,'bpc'=>$bpc,'f'=>'FlateDecode','parms'=>$parms,'pal'=>$pal,'trns'=>$trns,'data'=>$data);
    }
    
    private function Rotate($angle,$x=-1,$y=-1)
    {
        if($x==-1)
            $x=$this->x;
        if($y==-1)
            $y=$this->y;
        if($this->angle!=0)
            $this->_out('Q');
        $this->angle=$angle;
        if($angle!=0)
        {
            $angle*=M_PI/180;
            $c=cos($angle);
            $s=sin($angle);
            $cx=$x*$this->k;
            $cy=($this->h-$y)*$this->k;
            $this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm',$c,$s,-$s,$c,$cx,$cy,-$cx,-$cy));
        }
    }
    
    function RotatedText($x,$y,$txt,$angle)
    {
        //Rotation du texte autour de son origine
        $this->Rotate($angle,$x,$y);
        $this->Text($x,$y,$txt);
        $this->Rotate(0);
    }
    
    function Pointille($x1=0,$y1=0,$x2=210,$y2=297,$epaisseur=1,$nbPointilles=15)
    {
        $this->SetLineWidth($epaisseur);
        $longueur=abs($x1-$x2);
        $hauteur=abs($y1-$y2);
        if($longueur>$hauteur) {
            $Pointilles=($longueur/$nbPointilles)/2; // taille des pointilles
        }
        else {
            $Pointilles=($hauteur/$nbPointilles)/2;
        }
        for($i=$x1;$i<=$x2;$i+=$Pointilles+$Pointilles) {
            for($j=$i;$j<=($i+$Pointilles);$j++) {
                if($j<=($x2-1)) {
                    $this->Line($j,$y1,$j+1,$y1); // on trace le pointillé du haut, point par point
                    $this->Line($j,$y2,$j+1,$y2); // on trace le pointillé du bas, point par point
                }
            }
        }
        for($i=$y1;$i<=$y2;$i+=$Pointilles+$Pointilles) {
            for($j=$i;$j<=($i+$Pointilles);$j++) {
                if($j<=($y2-1)) {
                    $this->Line($x1,$j,$x1,$j+1); // on trace le pointillé du haut, point par point
                    $this->Line($x2,$j,$x2,$j+1); // on trace le pointillé du bas, point par point
                }
            }
        }
    }
    
    /*******************************************************************************
    *                                                                              *
    *                          Cellule à texte ajusté                              *
    *                                                                              *
    *******************************************************************************/
    
    //Cell with horizontal scaling if text is too wide
    function CellFit($w,$h=0,$txt='',$border=0,$ln=0,$align='',$fill=0,$link='',$scale=0,$force=1)
    {
        //Get string width
        $str_width=$this->GetStringWidth($txt);

        //Calculate ratio to fit cell
        if($w==0)
            $w=$this->w-$this->rMargin-$this->x;
        
        if ($str_width != 0)
            $ratio=($w-$this->cMargin*2)/$str_width;
        else
            $ratio = 0;

        $fit=($ratio < 1 || ($ratio > 1 && $force == 1));
        if ($fit)
        {
            switch ($scale)
            {

                //Character spacing
                case 0:
                    //Calculate character spacing in points
                    $char_space=($w-$this->cMargin*2-$str_width)/max($this->MBGetStringLength($txt)-1,1)*$this->k;
                    //Set character spacing
                    $this->_out(sprintf('BT %.2f Tc ET',$char_space));
                    break;

                //Horizontal scaling
                case 1:
                    //Calculate horizontal scaling
                    $horiz_scale=$ratio*100.0;
                    //Set horizontal scaling
                    $this->_out(sprintf('BT %.2f Tz ET',$horiz_scale));
                    break;

            }
            //Override user alignment (since text will fill up cell)
            $align='';
        }

        //Pass on to Cell method
        $this->Cell($w,$h,$txt,$border,$ln,$align,$fill,$link);

        //Reset character spacing/horizontal scaling
        if ($fit)
            $this->_out('BT '.($scale==0 ? '0 Tc' : '100 Tz').' ET');
    }

    //Cell with horizontal scaling only if necessary
    function CellFitScale($w,$h=0,$txt='',$border=0,$ln=0,$align='',$fill=0,$link='')
    {
        $this->CellFit($w,$h,$txt,$border,$ln,$align,$fill,$link,1,0);
    }

    //Cell with horizontal scaling always
    function CellFitScaleForce($w,$h=0,$txt='',$border=0,$ln=0,$align='',$fill=0,$link='')
    {
        $this->CellFit($w,$h,$txt,$border,$ln,$align,$fill,$link,1,1);
    }

    //Cell with character spacing only if necessary
    function CellFitSpace($w,$h=0,$txt='',$border=0,$ln=0,$align='',$fill=0,$link='')
    {
        $this->CellFit($w,$h,$txt,$border,$ln,$align,$fill,$link,0,0);
    }

    //Cell with character spacing always
    function CellFitSpaceForce($w,$h=0,$txt='',$border=0,$ln=0,$align='',$fill=0,$link='')
    {
        //Same as calling CellFit directly
        $this->CellFit($w,$h,$txt,$border,$ln,$align,$fill,$link,0,1);
    }

    //Patch to also work with CJK double-byte text
    function MBGetStringLength($s)
    {
        if($this->CurrentFont['type']=='Type0')
        {
            $len = 0;
            $nbbytes = strlen($s);
            for ($i = 0; $i < $nbbytes; $i++)
            {
                if (ord($s[$i])<128)
                    $len++;
                else
                {
                    $len++;
                    $i++;
                }
            }
            return $len;
        }
        else
            return strlen($s);
    }
}
?>