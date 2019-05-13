<?

if ($PROD == 1)
{
    $page->afficheHeader();
    echo 'Accès Interdit depuis les serveurs de productions';
    $page->afficheFooter();
    deconnexionDesBases();
    exit;
}

$page->afficheHeader();

if (isset($_POST['action']))
    $action = $_POST['action'];
else
    $action = '';

if (isset($_POST['libelle_table']))
    $libelle_table = $_POST['libelle_table'];
else
    $libelle_table = '';

if (isset($_POST['genre']))
    $genre = $_POST['genre'];
else
    $genre = '';

if (isset($_GET['only_table']))
    $only_table = $_GET['only_table'];
else
    $only_table = '';
    
if (isset($_POST['table']))
{
    $table = $_POST['table'];
    $only_table = $table;
}
else
    $table = '';


// Initialisation des variables
$gm = new GenerateModule($db);
$gm->setAllTables();
$gm->setAllTablesComment();
$tabTypes = $gm->getTypeDisponibles(); // récupération des différents objets que l'on peut créer

// Génération des modules si on le demande
if ($table != '' && $action != '')
{
    list($champs, $primaryKey) = $gm->getAllChampsForTableName($table);
    $colonnes = array();
    
    foreach($champs as $colonne => $v)
    {
        if (($action == 'generate_ajout' || $action == 'generate_ajout_save')&& isset($_POST[$table.'___'.$colonne.'__aff']) && $_POST[$table.'___'.$colonne.'__aff'] == 'on')
        {
            $pk = 'NO';
            if (in_array($colonne, $primaryKey))
                $pk = 'YES';
            $colonnes[$colonne] = array(
                                        'TYPE' => $v['TYPE'],
                                        'NULL' => $v['NULL'],
                                        'DEFAULT' => $v['DEFAULT'],
                                        'PRIMARY_KEY' => $pk,
                                        'INPUT' => $_POST[$table .'___'. $colonne],
                                        'INPUT_TXT' => $_POST[$table .'___'. $colonne.'___txt'],
                                        );
        }
        if ($action == 'generate_list' && isset($_POST[$table.'___'.$colonne.'__list']) && $_POST[$table.'___'.$colonne.'__list'] == 'on')
        {
            $pk = 'NO';
            if (in_array($colonne, $primaryKey))
                $pk = 'YES';
            $colonnes[$colonne] = array(
                                        'TYPE' => $v['TYPE'],
                                        'NULL' => $v['NULL'],
                                        'DEFAULT' => $v['DEFAULT'],
                                        'PRIMARY_KEY' => $pk,
                                        'INPUT' => $_POST[$table .'___'. $colonne],
                                        'INPUT_TXT' => $_POST[$table .'___'. $colonne.'___txt'],
                                        'LINK_MODIF' => isset($_POST[$table .'___'. $colonne.'__list__linkmodif']) ? $_POST[$table .'___'. $colonne.'__list__linkmodif']:'off',
                                        );
        }
    }
    
    if ($action == 'generate_list')
    {
        $ecraser = (isset($_POST['P_list_ecraser']) && $_POST['P_list_ecraser'] == '1') ? true:false;
        echo $gm->generateModuleList($table, $colonnes, $_POST['P_list'], $_POST['libelle_table'], $_POST['genre'], $ecraser);
    }
    if ($action == 'generate_ajout')
    {
        $ecraser = (isset($_POST['P_ajout_ecraser']) && $_POST['P_ajout_ecraser'] == '1') ? true:false;
        echo $gm->generateModuleAjout($table, $colonnes, $_POST['P_ajout'], $_POST['libelle_table'], $_POST['genre'], $ecraser);
    }
    if ($action == 'generate_ajout_save')
    {
        $ecraser = (isset($_POST['P_ajout_save_ecraser']) && $_POST['P_ajout_save_ecraser'] == '1') ? true:false;
        echo $gm->generateModuleAjoutSave($table, $colonnes, $_POST['P_ajout_save'], $_POST['libelle_table'], $_POST['genre'], $ecraser);
    }
    
}

// Select contant les types d'éléments à générer
$selectType = '<select name="#NAME#">';
$selectType .= '<option value="">Sélectionnez...</option>';
foreach($tabTypes as $k => $v)
{
    $selectType .= '<option value="'.$k.'">'.$v.'</option>';
}
$selectType .= '</select>';

$selectTable = '<select onChange="javascript:document.location=\'index.php?P=G&only_table=\'+this.value;" name="only_table">';
$selectTable .= '<option value="">Sélectionnez une table...</option>';
foreach($gm->tables as $tableName)
{
    if (isset($gm->tablesComment[$tableName]) && $gm->tablesComment[$tableName] != '')
        $tableNameAff = $tableName.' ("'.$gm->tablesComment[$tableName].'")';
    else
        $tableNameAff = $tableName;
    $selectTable .= '<option value="'.$tableName.'">'.$tableNameAff.'</option>';
}
$selectTable .= '</select>';

$selectTable = str_replace('value="'.$only_table.'"', 'value="'.$only_table.'" selected', $selectTable);

echo '<center>Sélectionnez une table : '. $selectTable .'</center><br><br>';

//print_jc($gm->tablesComment);
//print_jc($gm->getAllChampsForTableName('vacances'));

foreach($gm->tables as $tableName)
{
    if ($tableName != $only_table)
        continue;
    
    // vérificaiton si on a des commentaires sur la table et les champs
    
    // sur la table
    if ($gm->base == 'mysql' && isset($_POST['libelle_table']) && $_POST['libelle_table'] != '')
    {
        executeReq($db, 'alter table '.$tableName.' comment=\''.protegeChaine($_POST['libelle_table']).'\'');
    }
    
    // sur les champs
    list($champs, $primaryKey) = $gm->getAllChampsForTableName($tableName);
    foreach($champs as $colonne => $v)
    {
        
        if ($gm->base == 'mysql' && $v['KEY'] == '' && isset($_POST[$tableName.'___'.$colonne.'___txt']) && $_POST[$tableName.'___'.$colonne.'___txt'] != '')
        {
            $req =    'ALTER TABLE '.$tableName.' '.
                      'change '.$colonne.' '.$colonne.' '.
                      $v['TYPE'].' '.
                      ($v['NULL'] == 'NO' ? 'not null ':'null ').
//                       ($v['KEY'] == 'PRI' ? 'primary key ':'').
                      ($v['EXTRA'] != '' ? $v['EXTRA'].' ':'').
                      ($v['DEFAULT'] != '' ? 'default \''.$v['DEFAULT'].'\' ':'').
                      'comment \''.protegeChaine($_POST[$tableName.'___'.$colonne.'___txt']).'\'';
            
            executeReq($db, $req);
        }
    }
    // Fin de vérif
    
    if (!isset($_POST['libelle_table']) && $libelle_table == '')
    {
        $libelle_table = $gm->tablesComment[$tableName];
    }
    
    echo '<form name="F_'. $tableName .'" action="index.php" method="POST">';
    echo '<input type="hidden" name="table" value="'. $tableName .'">';
    echo '<input type="hidden" name="action" value="">';
    echo '<input type="hidden" name="P" value="'.$P.'">';
    echo '<fieldset>';
    echo '  <legend>'.
            $tableName.
            '&nbsp;<input type="text" size="80" name="libelle_table" value="'.$libelle_table.'" title="indiquez le contenu de la table (au pluriel).<br><br><b>Exemple : </b>utilisateurs">'.
            '&nbsp;Genre : '.
            str_replace('<option value="'.$genre.'">', '<option value="'.$genre.'" selected>', '<select name="genre"><option value="M">Masculin</option><option value="F">Féminin</option></select>').
            '</legend>';
    echo '<table class="adminlist">';
    echo    '<tr>'.
                '<th>Colonne</th>'.
                '<th>Type</th>'.
                '<th>Libellé</th>'.
                
//                '<th>Visualisation temporaire</th>'.
                '<th>Ajouter ce champs<br>dans le module <font color=blue><i>_list</i></font></th>'.
                '<th>Ajouter un lien de<br>modification sur ce champs<br>dans le module <font color=blue><i>_list</i></font></th>'.
                '<th>Formulaire généré dans le module <font color=blue>_ajout</font></th>'.
                '<th>Générer ce champs<br>dans le formulaire d\'<font color=blue>_ajout</font></th>'.
            '</tr>';
    list($champs, $primaryKey) = $gm->getAllChampsForTableName($tableName);
    $nbLinkModif = 0;
    foreach($champs as $colonne => $v)
    {
//            list($inputTxt, $inputCode) = $gm->getChaineInputForColonne($colonne, $v['TYPE']);
        
        $inputType = $gm->getInputTypeForColonne($colonne, $v['TYPE']);
        
        if ($inputType == '')
        {
            if (in_array($colonne, $primaryKey))
            {
                $inputType = 'input_hidden';
            }
        }
        $inputCode = $gm->getInputCode($inputType, $colonne, $v['TYPE']);
        
//            $t = '$input = \''.str_replace("'", "\'", $input).'\';';
//            echo $t;
//            eval($t);
        $selectDuType = str_replace('#NAME#', $tableName.'___'.$colonne, $selectType);
        $selectDuType = str_replace('"'. $inputType .'"', '"'. $inputType .'" selected', $selectDuType);
        
        $value = '';
        if (isset($_POST[$tableName.'___'.$colonne.'___txt']))
            $value = $_POST[$tableName.'___'.$colonne.'___txt'];
        else
        {
            if ($v['COMMENT'] != '')
                $value = $v['COMMENT'];
        }
        
        if (isset($_POST[$tableName.'___'.$colonne.'__list']))
        {
            $affOnPageList = $_POST[$tableName.'___'.$colonne.'__list'] == 'on' ? true:false;
        }
        else
        {
            $affOnPageList = true;
            if (in_array($colonne, $primaryKey))
            {
                $affOnPageList = false;
            }
        }
        
        $affLinkModif = false;
        if ($nbLinkModif == 0)
        {
            if (!in_array($colonne, $primaryKey))
            {
                $affLinkModif = true;
                $nbLinkModif++;
            }
        }
        echo    '<tr>'.
                    '<td>'.
                    $colonne.
                    ($v['NULL'] == 'NO' ? ' (<font color="red"><b>OBLIGATOIRE</b></font>)':'').
                    '</td>'.
                    '<td>'.$v['TYPE'].'</td>'.
                    '<td><input type="text" size="20" name="'.$tableName.'___'.$colonne.'___txt" value="'.$value.'"></td>'.
                    
//                    '<td>'.$inputCode.'</td>'.
                    
                    '<td align=center><input type="checkbox" name="'.$tableName.'___'.$colonne.'__list" '.($affOnPageList == true ? 'checked="checked"':'').'></td>'.
                    '<td align=center><input type="checkbox" name="'.$tableName.'___'.$colonne.'__list__linkmodif" '.($affLinkModif == true ? 'checked="checked"':'').'></td>'.
                    '<td>'.$selectDuType.'</td>'.
                    '<td align=center><input type="checkbox" name="'.$tableName.'___'.$colonne.'__aff" '.($inputCode != '' ? 'checked="checked"':'').'></td>'.
                '</tr>';
    }
    echo '</table>';

    // Définition des numéros de $P
    if (isset($_POST['P_list']))
        $P_list = $_POST['P_list'];
    else
        $P_list = '';
    
    if (isset($_POST['P_ajout']))
        $P_ajout = $_POST['P_ajout'];
    else
        $P_ajout = '';

    if (isset($_POST['P_ajout_save']))
        $P_ajout_save = $_POST['P_ajout_save'];
    else
        $P_ajout_save = '';
    
    foreach($PAGES as $indice => $infos)
    {
        if ($P_list == '' && $infos['MODULE'] == $tableName.'_list')
        {
            $P_list = $indice;
        }
        if ($P_ajout == '' && $infos['MODULE'] == $tableName.'_ajout')
        {
            $P_ajout = $indice;
        }
        if ($P_ajout_save == '' && $infos['MODULE'] == $tableName.'_ajout_save')
        {
            $P_ajout_save = $indice;
        }
    }
    
    // Définition des noms des modules
    if (isset($_POST['P_list_name']))
        $P_list_name = $_POST['P_list_name'];
    else
        $P_list_name = $tableName.'_list';
    
    if (isset($_POST['P_ajout_name']))
        $P_ajout_name = $_POST['P_ajout_name'];
    else
        $P_ajout_name = $tableName.'_ajout';
    
    if (isset($_POST['P_ajout_save_name']))
        $P_ajout_save_name = $_POST['P_ajout_save_name'];
    else
        $P_ajout_save_name = $tableName.'_ajout_save';
    
    
//    $forceP_list = false;
    
    if ($P_list == '')
    {
//        $forceP_list = true;
        // Pas de $P trouvé dans le config, on prends le prochain
        for($i = 1; $i < 100; $i++)
        {
            if (!isset($PAGES[$i]))
            {
                $P_list = $i;
                break;
            }
        }
    }
    
    if ($P_ajout == '' && !isset($PAGES[$P_list*100]))
    {
        $P_ajout = $P_list*100;
    }
    
    if ($P_ajout_save == '' && !isset($PAGES[$P_list*10000]))
    {
        $P_ajout_save = $P_ajout*100;
    }
    echo    '<table class="admintable">';
    
    echo    '<tr>'.
                '<td class="key">Numéro des $P :</td>'.
                '<td align="center"><input '.(isset($PAGES[$P_list]) ? 'style="font-weight:bold;color:#FF0000;"':'').' type="text" size="15" name="P_list" value="'.$P_list.'"></td>'.
                '<td align="center"><input '.(isset($PAGES[$P_ajout]) ? 'style="font-weight:bold;color:#FF0000;"':'').' type="text" size="15" name="P_ajout" value="'.$P_ajout.'"></td>'.
                '<td align="center"><input '.(isset($PAGES[$P_ajout_save]) ? 'style="font-weight:bold;color:#FF0000;"':'').' type="text" size="15" name="P_ajout_save" value="'.$P_ajout_save.'"></td>'.
            '</tr>';
    
    echo    '<tr>'.
                '<td class="key">Nom des modules :</td>'.
                '<td align="center"><input '.(isset($PAGES[$P_list]) ? 'style="font-weight:bold;color:#FF0000;"':'').' type="text" size="30" name="P_list_name" value="'.$P_list_name.'"></td>'.
                '<td align="center"><input '.(isset($PAGES[$P_ajout]) ? 'style="font-weight:bold;color:#FF0000;"':'').' type="text" size="30" name="P_ajout_name" value="'.$P_ajout_name.'"></td>'.
                '<td align="center"><input '.(isset($PAGES[$P_ajout_save]) ? 'style="font-weight:bold;color:#FF0000;"':'').' type="text" size="30" name="P_ajout_save_name" value="'.$P_ajout_save_name.'"></td>'.
            '</tr>';
    echo    '<tr>'.
                '<td class="key">Ecraser les fichiers cochés :</td>'.
                '<td align="center"><input type="checkbox" name="P_list_ecraser" value="1"></td>'.
                '<td align="center"><input type="checkbox" name="P_ajout_ecraser" value="1"></td>'.
                '<td align="center"><input type="checkbox" name="P_ajout_save_ecraser" value="1"></td>'.
            '</tr>';
    
    echo '<tr>'.
            '<td class="key">Générer les fichiers :</td>'.
            '<td align="center"><input type="button" onclick="document.F_'. $tableName .'.action.value=\'generate_list\';document.F_'. $tableName .'.submit();" class="soumettre" value="Générer le module List">&nbsp;</td>'.
            '<td align="center"><input type="button" onclick="document.F_'. $tableName .'.action.value=\'generate_ajout\';document.F_'. $tableName .'.submit();" class="soumettre" value="Générer le module Ajout">&nbsp;</td>'.
            '<td align="center"><input type="button" onclick="document.F_'. $tableName .'.action.value=\'generate_ajout_save\';document.F_'. $tableName .'.submit();" class="soumettre" value="Générer le module Ajout_Save"></td>'.
         '</tr>';
        
    

    
    echo '</table>';
    
    echo '</fieldset>';
    echo '</form>';
}
$page->afficheFooter();

?>