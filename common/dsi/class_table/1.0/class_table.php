<?php
 /**
 * @package common
 */
 
 /**
  * Classe générant des tableaux au format HTML<br>
  * avec des entètes, des tris et de la pagination
  * 
  * Exemple:
  * <code>
  * <?php
  * $table = new Table();
  * 
  * // Définition des entètes du tableau
  * $table->ajouteColonne('#', '', 5);
  * $table->ajouteColonne('Image', '', 10);
  * $table->ajouteColonne('Libellé', 'categorie_libelle');
  * 
  * $table->setCheckboxPosition(2); // on affiche les checkbox dans la seconde colonne
  * $table->setCheckboxName('categorie_id'); // le nom des checkbox
  * $table->setCheckboxValue(1); // les différents checkbox du tableau doivent prendre la valeur de la 1ère colonne
  * 
  * // Ajout des valeurs dans le tableau
  * foreach($tabValeur as $v)
  * {
  *     $table->ajouteValeur(array($v['categorie_id'], $v['categorie_image'], $v['categorie_libelle']));
  * }
  * 
  * $table->draw(); // on affiche le tableau
  * ?>
  * </code>
  */
class Table
{
    /**
     * Colonnes de mon tableau
     */
    var $headers            = array();
    /**
     * Valeurs de mon tableau
     */
    var $valeurs            = array();
    /**
     * numéro de la colonne qui contiendra le checkbox permettant de cocher/décocher tous les checkbox du tableau
     */
    var $checkboxPosition   = -1;
    /**
     * nom des checkbox présent dans le tableau
     */
    var $checkboxName       = '';
    /**
     * indice du tableau $valeurs contenant la valeur du checkbox
     */
    var $checkboxValue      = -1;
    /**
     * nom du formulaire qui contiendra le tableau
     */
    var $formName           = '';
    
    // Variables pour la Pagination
    /**
     * Nombre d'élément à afficher au total
     */
    var $nbResultatMax      = '';
    /**
     * Nombre d'élément à afficher par page
     */
    var $nbResultatParPage  = '';
    /**
     * lien à faire passer dans les liens de navigations
     */
    var $lienPaginationParametre = '';
    /**
     * Nombre de lien de navigation à afficher au maximum
     */
    var $nbLienPageMax      = 6;
    /**
     * Indique si oui ou non on affiche le filtre de recherche
     */
    var $afficheFiltre = false;
    
    /**
     * Chaine à afficher en haut à droite du tableau
     */
    var $chaineFiltre = '';
    
    /**
     * Liste des valeurs à checker pour les checkbox de sélection
     */
    var $tabValueChecked = array();
    
    /**
     * Chaine qui contient les input Hidden
     */
    var $chInputHidden = '';
    
    function __construct($formName = 'F1')
    {
        $this->Table($formName);
    }

    /**
     * Constructeur
     * 
     * @param string Nom du formulaire
     */
    function Table($formName = 'F1')
    {
        $this->formName = $formName;
        $this->headers = array();
    }
    
    /**
     * Défini le lien à faire passer dans les liens de navigations
     * 
     * @param string $link lien à faire passer dans les liens de navigations
     */
    function setLienPaginationParametre($link)
    {
        $this->lienPaginationParametre = $link;
    }
    
    /**
     * Défini le nombre d'élément à afficher au total
     * 
     * @param int $nb Nombre d'élément à afficher au total
     */
    function setNbResultatMax($nb)
    {
        $this->nbResultatMax = $nb;
    }
    
    /**
     * Défini si on veut ou non afficher le filtre de recherche au dessus du tableau
     * 
     * @param boolean $afficher
     */
    function setAfficheFiltre($afficher)
    {
        $this->afficheFiltre = $afficher;
    }
    
    /**
     * Défini le nombre d'élément à afficher par page
     * 
     * @param int $nbResultatParPage Nombre d'élément à afficher par page
     */
    function setNbResultatParPage($nbResultatParPage)
    {
        $this->nbResultatParPage = $nbResultatParPage;
    }
    
    /**
     * Défini le nombre de lien de navigation à afficher au maximum (pour la pagination)
     * 
     * @param int Nombre de lien de navigation à afficher au maximum
     */
    function setNbLienPageMax($v)
    {
        $this->nbLienPageMax = $v;
    }
    
    /**
     * Chaine à afficher en haut à droite du tableau
     * 
     * @param string Chaine à afficher en haut à droite du tableau
     */
    function setChaineFiltre($v)
    {
        $this->chaineFiltre = $v;
    }
    
     /**
      * Ajoute une colonne au tableau
      *
      * @param string $colonneLibelle Libellé de la colonne
      * @param string $colonneNameDeLaTable Tri avec ce nom (en général, c'est le nom du colonne d'une table)
      * @param int $width Taille de la colonne
      * @param string $align Alignement qui sera appliqué aux valeurs de la colonne
      **/
    function ajouteColonne($colonneLibelle, $colonneNameDeLaTable = '', $width = '', $align = '', $display = true, $legendeTitle = '')
    {
        $this->headers[] = array(
                                    'txt' => $colonneLibelle,
                                    'name' => $colonneNameDeLaTable,
                                    'width' => $width,
                                    'align' => $align,
                                    'display' => $display,
                                    'legende_title' => $legendeTitle,
                                   );
    }
    
    
    /**
     * Ajoute une valeur qui sera checked par défaut
     * 
     * @param unknown_type $valueChecked
     */
    function ajouteValueChecked($value)
    {
        $this->tabValueChecked[] = $value;
    }
    
    
    /**
     * Ajoute une ligne de valeurs dans le tableau
     * 
     * @param Array $tab valeurs à ajouter au tableau
     **/
    function ajouteValeur($tab)
    {
        $this->valeurs[] = $tab;
    }
    
    private function setColonnes($tab)
    {
        foreach($tab as $c)
        {
            $this->ajouteColonne($c['txt'], $c['name']);
        }
    }
    
    /**
     * Défini le numéro de la colonne qui contiendra le checkbox
     * 
     * @param int $numColonne
     */
    function setCheckboxPosition($numColonne)
    {
        $this->checkboxPosition = $numColonne;
    }
    
    /**
     * Défini le nom du checkbox (name de l'input)
     * 
     * @param String $name
     */
    function setCheckboxName($name)
    {
        $this->checkboxName = $name;
    }
    
    
    /**
     * Défini le numéro de la colonne dont les différents checkbox prendront la valeur
     * 
     * @param int $numColonne
     */
    function setCheckboxValue($numColonne)
    {
        $this->checkboxValue = $numColonne;
    }
    
    /**
     * Affiche le Filtre au dessus du tableau<br>
     * 
     * Attention: Faire appel à la fonction setAfficheFiltre avant!
     **/
    private function afficheFiltre()
    {
        global $type, $orderby;
        $searchColonne = '';
        if ($this->afficheFiltre == true)
        {
            if (isset($_GET['search']))
                $searchValue = $_GET['search'];
            else
                $searchValue = '';
            if (isset($_GET['colonne']))
                $searchColonne = $_GET['colonne'];
            else
            {
                if ($type != '' && $orderby != '')
                    $searchColonne = $orderby;
            }
                
            echo '<form name="formsearch" method="GET" action="'.$this->lienPaginationParametre.'">';
            // Affichage en hidden des variables du lienPaginationParametre
            $t = explode('?', $this->lienPaginationParametre);
            if (count($t) == 2)
            {
                $t = explode('&', $t[1]);
                foreach($t as $v)
                {
                    list($name, $value) = explode('=', $v);
                    echo '<input type="hidden" name="'.$name.'" value="'.$value.'">'."\n";
                }
            }
            
            echo '<table>'."\n";
            //echo '<form name="formsearch" method="GET" action="index.php?P=3"><table>'."\n";
            
            echo    '<tr>'.
                        '<td width="100%">'.
                            'Rechercher : '.
                            '<input type="text" name="search" id="search" value="'.$searchValue.'" class="text_area" title="Tapez ici un terme à rechercher !"/>';
            $selectFiltre = '<select name="colonne">';
            foreach($this->headers as $v)
            {
                if (isset($v['name']) && $v['name'] != '')
                {
                    if (isset($v['txt']) && $v['txt'] != '')
                        $txt = $v['txt'];
                    
                    $selectFiltre .= '<option value="'. $v['name'] .'"';
                    if ($searchColonne == $v['name'])
                        $selectFiltre .= ' selected';
                    $selectFiltre .= '>'. $txt .'</option>';
                }
            }
            $selectFiltre .= '</select>';
            echo '&nbsp;sur&nbsp;'. $selectFiltre;
            echo            '&nbsp;<input class="soumettre" type="button" onclick="document.formsearch.submit();" value="Appliquer">'.
                            '&nbsp;<input class="soumettre" type="button" onclick="document.location.href=\''.$this->lienPaginationParametre.'\';" value="Réinitialiser">'.
                        '</td>'.
                        '<td nowrap="nowrap">';
            
            if ($this->chaineFiltre != '')
                echo $this->chaineFiltre;

            echo        '</td>'.
                    '</tr>'."\n";
            echo '</table></form>'."\n";
        }
    }
    
    /**
     * Défini une chaine contenant des inputs hidden à rajouter au formulaire des checkbox
     * 
     * @param String $codeSourceInputs
     */
    function setChaineHidden($codeSourceInputs)
    {
        $this->chInputHidden = $codeSourceInputs;
    }
    
    /**
     * Affiche le Header du tableau<br>
     * Soit le début du formulaire + les entètes des colonnes
     **/
    private function afficheHeader()
    {
        global $P, $orderby, $type, $page;
        
        // récupération du nombre d'élément par page
        if (isset($_GET['epn']) && trim($_GET['epn']) != '')
            $this->nbResultatParPage = $_GET['epn'];

        echo '<form name="'.$this->formName.'" action="index.php" method="POST">'."\n";
        echo '<input type="hidden" name="action" value="">'."\n";
        echo '<input type="hidden" name="P" value="'. $P .'">'."\n";
        echo $this->chInputHidden;
        
        //echo $orderby.$type;
        echo '<table class="adminlist" cellspacing="1" cellpadding="1">'."\n";
        echo    "\t".'<thead>'."\n".
                "\t".'<tr>'."\n";
        $i = 1;
        foreach($this->headers as $v)
        {
            // si le champ ne doit pas etre affiche, on passe a la suite
            if (isset($this->headers[($i-1)]['display']) == true
                    && $this->headers[($i-1)]['display'] == false)
            {
                $i++;
                continue;
            }
            
            if ($i == $this->checkboxPosition)
            {
                echo "\t"."\t".'<th width="5"><input type="checkbox" name="toggle" value="" onclick="checkOrUncheckAll(document.'. $this->formName .', \''. $this->checkboxName .'\');" /></th>'."\n";
            }
            $width = $txt = '';
            // taille
            if (isset($v['width']) && $v['width'] != '')
                $width = ' width="'. $v['width'] .'"';
            // texte
            if (isset($v['txt']) && $v['txt'] != '')
                $txt = $v['txt'];
            
            
            // on a un nom de colonne, on va donc afficher un lien pour trier la colonne
            if (isset($v['name']) && $v['name'] != '')
            {
                if (isset($v['legende_title']) && $v['legende_title'] != '')
                {
                    $txt = '<a href="'. $this->lienPaginationParametre .'&orderby='.$v['name'].'&type='. (strtolower($type) == 'asc' ? 'DESC':'ASC').'&epn='. $this->nbResultatParPage .'" title="<b>'.$v['legende_title'].' : </b>Cliquer pour trier cette colonne">'.$txt;
                }
                else
                {
                    $txt = '<a href="'. $this->lienPaginationParametre .'&orderby='.$v['name'].'&type='. (strtolower($type) == 'asc' ? 'DESC':'ASC').'&epn='. $this->nbResultatParPage .'" title="Cliquer pour trier cette colonne">'.$txt;
                }

                
                //$txt = '<a href="index.php?P='.$P.'&orderby='.$v['name'].'&type='. (strtolower($type) == 'asc' ? 'DESC':'ASC').'" title="Cliquer pour trier cette colonne">'.$txt;
                
                
                // on vérifie si cette colonne n'est pas la colonne qui est actuellement triée
                if ($type != '' && $orderby == $v['name'])
                {
                    $nbVersion3 = substr_count($page->designColor, '/3.0');
                    if ($nbVersion3 == 1)
                        $txt .= '<img src="'.$page->getDesignUrl().'/images/sort_'. strtolower($type) .'.png" alt="" align="middle" border="0">';
                    else
                        $txt .= '<img src="'.$page->designUrl.'/pagination/sort_'. strtolower($type) .'.png" alt="" align="middle" border="0">';
                }
                $txt .= '</a>';
            }
            else
            {
                if (isset($v['legende_title']) && $v['legende_title'] != '')
                {
                    $txt = '<div title="'.$v['legende_title'].'">'.$txt.'</div>';
                }
            }
            
            echo "\t"."\t".'<th'.$width.'>'.$txt.'</th>'."\n";
            $i++;
        }
        echo    "\t".'</tr>'."\n".
                "\t".'</thead>'."\n";
    }
    
    /**
     * Affiche le contenu du tableau<br>
     * Soit les valeurs
     **/
    private function afficheContenu()
    {
        global $page;
       //initialise la couleur de la première ligne.
       $coul ='#FFFFFF';
        $j = 0;
        echo    "\t".'<tbody>'."\n";
        foreach($this->valeurs as $tab)
        {
            $nbVersion2 = substr_count($page->designColor, '/2.0');
            if ($nbVersion2 == 1)
                echo "\t".'<tr class="row'.($j++%2).'">'."\n";
            else
                echo "\t".'<tr class="v'.($j++%2).'">'."\n";
            
            $i = 1;
            
            foreach($tab as $valeur)
            {

                // si le champ ne doit pas etre affiche, on passe a la suite
                if (isset($this->headers[($i-1)]['display']) == true
                    && $this->headers[($i-1)]['display'] == false)
                {
                    $i++;
                    continue;
                }
                
                $align = $width = '';
                if ($i == $this->checkboxPosition)
                {
                    if (isset($tab[($this->checkboxValue-1)]) == true) {
                        $value = $tab[($this->checkboxValue-1)];
                    } else {
                        $value ='';
                    }
                    echo "\t"."\t".'<td><input type="checkbox" name="'.
                    $this->checkboxName.
                    '[]" value="'.
                    $value.
                    '" '.
                    ($value != '' && in_array($tab[($this->checkboxValue-1)], $this->tabValueChecked) ? 'checked':'').
                    '/></td>'."\n";
                }
                // align


                if (isset($this->headers[($i-1)]['align']) && $this->headers[($i-1)]['align'] != '')
                    $align = ' align="'. $this->headers[($i-1)]['align'] .'"'; 
//                if (isset($this->headers[($i-1)]['width']) && $this->headers[($i-1)]['width'] != '')
//                    $width = ' width="'. $this->headers[($i-1)]['width'] .'"';

                $couleur = ' bgcolor="'.$coul.'"';

                  echo "\t"."\t".'<td'.$align.$width.'>'.$valeur.'</td>'."\n";
                $i++;
            }
            echo "\t".'</tr>'."\n";

// teste la couleur de la ligne précédente et change la couleur du fond.

                  if ($coul=='#FFFFFF'){			
				        $coul='#EBEBEB';
			       }else{
				        $coul='#FFFFFF';
			       }
//***********************************************************************			       
        }
        echo    "\t".'</tbody>'."\n";
    }
    
    /**
     * Affiche le Footer du tableau<br>
     * Soit la fin du tableau et la fin du formulaire
     **/
    private function afficheFooter()
    {
        echo '</table>'."\n";
        echo '</form>'."\n";
    }
    
    /**
     * Affiche le tableau
     **/
    function draw()
    {
        $this->afficheFiltre();
        $this->afficheHeader();
        $this->affichePagination();
        $this->afficheContenu();
        $this->afficheFooter();
    }
    
    /**
     * Affiche la pagination
     **/
    private function affichePagination()
    {
        global $page;
        if ($this->nbResultatMax != '') // on a une pagination à afficher
        {
            if (isset($_GET['pn']))
                $pageActuelle = $_GET['pn'];
            else
                $pageActuelle = 0;
            $imageUrl = $page->designUrl.'/pagination';
            
            $pn = $pageActuelle;
            $nbPage = intval($this->nbResultatMax / $this->nbResultatParPage);

            $nbPageEntier = $this->nbResultatMax / $this->nbResultatParPage;
            if ($nbPage == $nbPageEntier)
                $nbPage--;
            $chPagination = '';
            
            $start = $pn - intval($this->nbLienPageMax/2);
            if ($start < 0)
                $start = 0;
            for($i=$start; $i < $nbPage+1; $i++)
            {
                if ($chPagination != '')
                    $chPagination .= '';
                if ($i == $pn)
                    $chPagination .= '<span><strong>'.($i+1).'</strong></span>';
                else
                {
                    $chPagination .= '<a href="';
            
                    // Ajout de la pagination
                    $chPagination .= $this->lienPaginationParametre;
                    $chPagination .= '&pn='.$i;
                    $chPagination .= '&epn='.$this->nbResultatParPage;
                    $chPagination .= '">'.($i+1).'</a>';
                }
                if ($i-$start > $this->nbLienPageMax-2)
                    break;
            }
            
            $nbColonne = count($this->headers);
            if ($this->checkboxPosition != -1) // si l'on a un checkbox... ça fait une colonne en plus
                $nbColonne++;
            
            //$chPagination = '&nbsp;<img src="'.$imageUrl.'/pointr.gif">&nbsp;'.$chPagination.'&nbsp;<img src="'.$imageUrl.'/pointr.gif">&nbsp;';
            
            $chPagination2 =    '<del class="container">'."\n".
                                    '<div class="pagination">';
            
            $chPagination2 .= '<div class="limit">Page '.($pageActuelle+1).' sur '.(intval($nbPageEntier)+1).'</div>';
            
            if ($pn > 0)
            {
//                $chPagination = '<a href="'.$this->lienPaginationParametre.'&pn='.($pn-1).'"><img title="Page Précédente" border="0" align="absbottom" src="'.$imageUrl.'/precedent.gif"></a> '. $chPagination;
//                $chPagination = '<a href="'.$this->lienPaginationParametre.'&pn=0"><img title="Début de la liste" border="0" align="absbottom" src="'.$imageUrl.'/debut.gif"></a> '. $chPagination;
                
                $chPagination2 .= '<div class="button2-right"><div class="start"><a href="'.$this->lienPaginationParametre.'&pn=0&epn='.$this->nbResultatParPage.'" title="D&eacute;but de la liste">D&eacute;but</a></div></div><div class="button2-right"><div class="prev"><a href="'.$this->lienPaginationParametre.'&pn='.($pn-1).'&epn='.$this->nbResultatParPage.'" title="Pr&eacute;c&eacute;dent">Pr&eacute;c</a></div></div>'."\n";
//</div>';
            }
            else
            {
                $chPagination2 .= '<div class="button2-right off"><div class="start"><span>D&eacute;but</span></div></div><div class="button2-right off"><div class="prev"><span>Pr&eacute;c</span></div></div>'."\n";
            }

            $chPagination2 .= '<div class="button2-left"><div class="page">'. $chPagination .'</div></div>'."\n";
            
            
                                
            if ($nbPage > $pn)
            {
                $chPagination2 .= '<div class="button2-left"><div class="next"><a title="Suivant" href="'.$this->lienPaginationParametre.'&pn='.($pn+1).'&epn='.$this->nbResultatParPage.'">Suivant</a></div></div><div class="button2-left"><div class="end"><a title="Fin" href="'.$this->lienPaginationParametre.'&pn='.$nbPage.'&epn='.$this->nbResultatParPage.'">Fin</a></div></div>'."\n";
//                $chPagination .= ' <a href="'.$this->lienPaginationParametre.'&pn='.($pn+1).'"><img title="Page Suivante" border="0" align="absbottom" src="'.$imageUrl.'/suivant.gif"></a>';
//                $chPagination .= ' <a href="'.$this->lienPaginationParametre.'&pn='.$nbPage.'"><img title="Fin de la liste" border="0" align="absbottom" src="'.$imageUrl.'/fin.gif"></a>';
            }
            else
            {
                $chPagination2 .= '<div class="button2-left off"><div class="next"><span>Suivant</span></div></div><div class="button2-left off"><div class="end"><span>Fin</span></div></div>'."\n";
            }
            
            
//            $chPagination2 =    'Affichage des résultats de '.
//            ($pageActuelle*$nbResultatParPage+1).
//            ' à '.
//            min($nbResultatMax, ($pageActuelle*$nbResultatParPage+$nbResultatParPage)).
//            ' sur un total de <b>'.$nbResultatMax.'</b>';
            
            
            $selectPage =   '<div class="limit">El&eacute;ments par page #'.
                                '<select name="limit" onChange="javascript:window.location.href=\''.$this->lienPaginationParametre.'&pn='.$pn.'&epn=\'+this.value;">'.
                                '<option value="5">5</option>'.
                                '<option value="10">10</option>'.
                                '<option value="15">15</option>'.
                                '<option value="20">20</option>'.
                                '<option value="25">25</option>'.
                                '<option value="30">30</option>'.
                                '<option value="50">50</option>'.
                                '<option value="100">100</option>'.
                                '<option value="'. $this->nbResultatMax .'">Tous</option>'.
                                '</select></div>';
            $selectPage = str_replace('value="'.$this->nbResultatParPage.'"', 'value="'.$this->nbResultatParPage.'" selected', $selectPage);
            
            $chPagination2 .= $selectPage;
            $chPagination2 .=       '</div>'."\n".
                                '</del>'."\n";
            
//<del class="container"><div class="pagination">
//
//<div class="limit">Affichage #<select name="limit" id="limit" class="inputbox" size="1" onchange="submitform();"><option value="5" >5</option><option value="10"  selected="selected">10</option><option value="15" >15</option><option value="20" >20</option><option value="25" >25</option><option value="30" >30</option><option value="50" >50</option><option value="100" >100</option><option value="0" >tous</option></select></div><div class="button2-right off"><div class="start"><span>Début</span></div></div><div class="button2-right off"><div class="prev"><span>Préc</span></div></div>
//<div class="button2-left"><div class="page"><span>1</span><a title="2" onclick="javascript: document.adminForm.limitstart.value=10; submitform();return false;">2</a><a title="3" onclick="javascript: document.adminForm.limitstart.value=20; submitform();return false;">3</a><a title="4" onclick="javascript: document.adminForm.limitstart.value=30; submitform();return false;">4</a><a title="5" onclick="javascript: document.adminForm.limitstart.value=40; submitform();return false;">5</a>
//
//</div></div><div class="button2-left"><div class="next"><a title="Suivant" onclick="javascript: document.adminForm.limitstart.value=10; submitform();return false;">Suivant</a></div></div><div class="button2-left"><div class="end"><a title="Fin" onclick="javascript: document.adminForm.limitstart.value=40; submitform();return false;">Fin</a></div></div>
//<div class="limit">page 1 sur 5</div>
//<input type="hidden" name="limitstart" value="0" />
//</div></del>				</td>
//			</tr>
//			</tfoot>
			if ($nbPage > 0)
			{
			    echo    '<tfoot>'."\n".
			                '<tr>'."\n".
			                    '<td colspan="'.$nbColonne.'">'.
                                    $chPagination2.
                                '</td>'."\n".
			                '</tr>'."\n".
			            '</tfoot>';
            }
            else
            {
                echo '';
            }
        }
    }
}
?>