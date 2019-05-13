<?php

/**
 * Class permettant de générer des PDF pour la mairie
 * Cette classe inclus le multicellTag et le PDF_Mairie
 * Elle permet d'écrire sur une seule ligne d'un coups.
 * 
 * @author MarinJC
 *
 */
class PDF_Mairie2 extends FPDF_MULTICELLTAG
{
    var $tabColonneWidth = array(); //Tableau des largeurs de colonnes
    var $tabColonneAlign; //Tableau des alignements de colonnes
    var $tabColonneBackground; //Tableau des couleurs de fond des cellules de colonnes
    var $hauteurCellule = 5; //Hauteur des cellules de la ligne (default 5)
    var $version = 2;
    var $AliasNbPages = '{nb}';
    
    /**
     * Défini la hauteur d'une ligne de cellule multicell
     * Par défaut 5
     * 
     * @param int $hauteur Hauteur d'une ligne de cellule
     */
    function setHauteurCellule($hauteur)
    {
        $this->hauteurCellule = $hauteur;
    }
    
    /**
     * Défini la taille de chacune des cellules
     * 
     * @param array $tab Tableau contenant les tailles de chacune des cellules
     */
    function setColonneWidth($tab)
    {
        $this->tabColonneWidth=$tab;
    }
    
    /**
     * Défini l'alignement du texte dans chacune des cellules
     *
     * @param array $tab Tableau contenant l'alignement de chacune des cellules
     */
    function setColonneAlign($tab)
    {
        $this->tabColonneAlign=$tab;
    }
    
    /**
     * Défini la couleur de fond de chacune des cellules
     *
     * @param array $tab Tableau contenant la couleur de fond de chacune des cellules
     */
    function setColonneBackground($tab)
    {
        $this->tabColonneBackground = $tab;
    }
    
    /**
     * Affiche une ligne complète de données
     *
     * @param array $tab Tableau contenant les données à afficher
     */
    function Row($data)
    {
        //Calcule la hauteur de la ligne
        $nb=0;
        for($i=0;$i<count($data);$i++)
            $nb=max($nb,$this->NbLines($this->tabColonneWidth[$i],$data[$i]));
            $h=$this->hauteurCellule*$nb;
        //Effectue un saut de page si nécessaire
        $this->CheckPageBreak($h);
        //Dessine les cellules
        for($i=0;$i<count($data);$i++)
        {
            $w=$this->tabColonneWidth[$i];
            $a=isset($this->tabColonneAlign[$i]) ? $this->tabColonneAlign[$i] : 'L';
            //Sauve la position courante
            $x=$this->GetX();
            $y=$this->GetY();
            //Dessine le cadre
            $color = isset($this->tabColonneBackground[$i]) ? $this->tabColonneBackground[$i] : '';
            $rectStyle = 'D';
            if ($color != '')
            {
            $this->SetFillColor(
                    hexdec(substr($color, 1, 2)),
                    hexdec(substr($color, 3, 2)),
                    hexdec(substr($color, 5, 2))
                    );
                    $rectStyle = 'DF';
            }
            $this->Rect($x,$y,$w,$h, $rectStyle);
                //Imprime le texte
            //$this->MultiCellTag($w,$this->hauteurCellule,$this->hauteurCellule.':'.$nb.':'.$h,0,$a);
            $this->MultiCellTag($w,$this->hauteurCellule,$data[$i],0,$a);
            //.
            //Repositionne à droite
            $this->SetXY($x+$w,$y);
        }
        //Va à la ligne
        $this->Ln($h);
        return $h;
    }

    function CheckPageBreak($h)
    {
        //Si la hauteur h provoque un débordement, saut de page manuel
        if($this->GetY()+$h>$this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }
    
    private function NbLines($w,$txt)
    {
        //Calcule le nombre de lignes qu'occupe un MultiCell de largeur w
        $cw=&$this->CurrentFont['cw'];
        if($w==0)
            $w=$this->w-$this->rMargin-$this->x;
        $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
        $s=str_replace("\r",'',$txt);
        $nb=strlen($s);
        if($nb>0 and $s[$nb-1]=="\n")
            $nb--;
        $sep=-1;
        $i=0;
        $j=0;
        $l=0;
        $nl=1;
        while($i<$nb)
        {
            $c=$s[$i];
            if($c=="\n")
            {
                $i++;
                $sep=-1;
                $j=$i;
                $l=0;
                $nl++;
                continue;
            }
            if($c==' ')
                $sep=$i;
            $l+=$cw[$c];
            if($l>$wmax)
            {
                if($sep==-1)
                {
                    if($i==$j)
                        $i++;
                }
                else
                    $i=$sep+1;
                $sep=-1;
                $j=$i;
                $l=0;
                $nl++;
            }
            else
                $i++;
        }
        return $nl;
    }
    
    
}
?>