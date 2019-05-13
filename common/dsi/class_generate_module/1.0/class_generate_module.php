<?php

/*
    Class qui va générer des modules PHP en fonction de la base de données
    
    Table de test :
    DROP TABLE IF EXISTS `test`;
CREATE TABLE IF NOT EXISTS `test` (
  `test_id` int(11) NOT NULL auto_increment,
  `service_id` int(11) NOT NULL,
  `test_nom` varchar(100) NOT NULL COMMENT 'Nom',
  `test_prenom` varchar(100) default NULL COMMENT 'Prénom',
  `test_grade` varchar(100) default NULL COMMENT 'Grade',
  `marche_id` int(12) default NULL,
  `lot_id` int(12) default NULL,
  `test_last_action` int(12) default NULL COMMENT 'Dernière action',
  `test_date_naissance` date default NULL COMMENT 'Date de naissance',
  `test_sexe` varchar(1) NOT NULL default 'F' COMMENT 'Sexe',
  `test_email` varchar(100) NOT NULL COMMENT 'Email',
  `test_commentaire` TEXT default NULL COMMENT 'Commentaires',
  PRIMARY KEY  (`test_id`))
   COMMENT 'tests';


*/
 
class GenerateModule
{
    var $db;
    var $tables = array(); // liste des tables
    var $tablesComment =  array(); // liste des commentaires sur les tables
    var $version = '1.0';
    var $base = ''; // mysql ou oracle
    var $typeDisponibles = array(
                                    'input_text' => 'INPUT de type <b>TEXT</b>',
                                    'input_email' => 'INPUT de type <b>TEXT</b> avec check EMAIL',
                                    'input_hidden' => 'INPUT de type HIDDEN',
                                    'input_date' => 'INPUT de type TEXT avec Calendrier',
                                    'input_password' => 'INPUT de type PASSWORD',
                                    'select_y_n' => 'SELECT Oui / Non (Oui=1, Non=0)',
                                    'select_sexe' => 'SELECT Homme / Femme (Homme=H, Femme=F)',
                                    'textarea' => 'TEXTAREA',
                                );
    
    function __construct($db)
    {
        $this->GenerateModule($db);
    }

    function GenerateModule($db)
    {
        set_time_limit(600);
        $this->setBase($db);
    }
    
    function getTypeDisponibles()
    {
        return $this->typeDisponibles;
    }
    
    function setBase($db)
    {
        if ($db->dbsyntax == 'mysql')
            $this->base = 'mysql';
        else if ($db->dbsyntax == 'oci8')
            $this->base = 'oracle';
        else
            die('base de données ['.$db->dbsyntax.'] non reconnu');
        $this->db = $db;
    }
    
    function setAllTables()
    {
        if ($this->base == 'mysql')
            $req = 'show tables';
        else
            $req =  'select object_name, object_type '.
                    'from user_objects '.
                    'where object_type in (\'TABLE\',\'VIEW\',\'MATERIALIZED VIEW\')';
        $res = executeReq($this->db, $req);
        $this->tables = array();
        while(list($t) = $res->fetchRow())
        {
            $this->tables[] = $t;
        }
    }
    
    function setAllTablesComment()
    {
        $this->tablesComment = array();
        if ($this->base == 'mysql')
        {
            $req = 'show table status';
            $res = executeReq($this->db, $req);
            
            while($t = $res->fetchRow())
            {
                //print_jc($t);
                if (substr($t[17], 0, 11) == 'InnoDB free')
                {
                    $t[17] = '';
                }
                else
                {
                    $t2 = explode('; InnoDB free', $t[17]);
                    $t[17] = $t2[0];
                }
                
                $this->tablesComment[$t[0]] = $t[17];
            }
        }
        else
        {
            // en attente de la requete pour oracle
            foreach($this->tables as $v)
                $this->tablesComment[$v] = '';
        }
        
    }
    
    function setTables($tabTable)
    {
        $this->tables = array();
        foreach($tabTable as $v)
            $this->tables[] = $v;
    }
    
    function setAllObjetsForTables($isFileAllReadyExists = false)
    {
        global $DATA_PATH;
        $rep = $DATA_PATH . '/objet_bdd';
        
        if (!is_dir($rep))
            mkdir($rep);
        
        $repFichier = $rep .'/'. $this->base;
        
        if (!is_dir($repFichier))
            mkdir($repFichier);
    
        if ($isFileAllReadyExists)
        {
            $chClass = "\n".'// Inclusion des classes '. $this->base ."\n";
        }
        else
        {
            $chClass =  '<?php'."\n".
                        '// Inclusion des classes '. $this->base ."\n";
        }
        
        foreach($this->tables as $tableName)
        {
            // Génération de la class équivalent à 1 ligne de la table
            $file = $repFichier .'/'. $this->getNameForFile($tableName) .'.php';
            $f = fopen($file, 'w+');
            if ($f)
            {
                $ch = $this->getClassForTable($tableName);
                fwrite($f, $ch);
                fclose($f);
                $chClass .= 'require_once($DATA_PATH . \'/objet_bdd/'. $this->base .'/'. $this->getNameForFile($tableName) .'.php\');'."\n";
            }
            else
            {
                echo '<font color=red>Impossible de créer le fichier '. $file .'</font>';
            }
            
            // Génération de la class équivalent à plusieurs objet de la classe précédente
            $file = $repFichier .'/liste_'. $this->getNameForFile($tableName) .'.php';
            $f = fopen($file, 'w+');
            if ($f)
            {
                $ch = $this->getClassForListeObjet($tableName);
                fwrite($f, $ch);
                fclose($f);
                $chClass .= 'require_once($DATA_PATH . \'/objet_bdd/'. $this->base .'/liste_'. $this->getNameForFile($tableName) .'.php\');'."\n";
            }
            else
            {
                echo '<font color=red>Impossible de créer le fichier '. $file .'</font>';
            }
            //break;
            
        }
        
        if ($isFileAllReadyExists)
        {
            $f = fopen($rep .'/all_classes.php', 'r');
            $chFichierExistant = fread ($f, filesize($rep .'/all_classes.php'));
            fclose($f);
            
            $chFichierExistant = str_replace(   '$ALL_CLASSE_LOADED = 1;',
                                                $chClass.'$ALL_CLASSE_LOADED = 1;',
                                                $chFichierExistant);
            
            $f = fopen($rep .'/all_classes.php', 'w+');
            fwrite($f, $chFichierExistant);
            fclose($f);
        }
        else
        {
            $chClass .=  '$ALL_CLASSE_LOADED = 1;'."\n";
            $chClass .=  '?>';
            
            $f = fopen($rep .'/all_classes.php', 'w+');
            fwrite($f, $chClass);
            fclose($f);
        }
            
        
        
//        $res = executeReq($this->db, 'show tables');
//        $this->tables = array();
//        while(list($t) = $res->fetchRow())
//        {
//            $this->tables[] = $t;
//        }
    }
    
    function getNameForClass($tableName)
    {
        $t = explode('_', strtolower($tableName));
        foreach ($t as $k => $v)
        {
            $t[$k] = ucfirst($v);
        }
        $ch = implode('',$t);
        return $ch;
    }
    
    /**
     * @param unknown_type $mots
     * @return string
     */
    function convertMotsAuSingulier($mots)
    {
        $tab = explode(' ', $mots);
        foreach($tab as $k => $v)
        {
            if (substr($v, -1) == 's')
                $tab[$k] = substr($v, 0, -1);
        }
        $mots = implode(' ', $tab);
        return $mots;
    }
    
    function getNameForFile($tableName)
    {
        return strtolower($tableName);
    }
    
    function getNameForColonne($colonne)
    {
        $t = explode('_', strtolower($colonne));
        
        foreach ($t as $k => $v)
        {
            $t[$k] = ucfirst($v);
        }
        $t[0] = strtolower($t[0]);
        $ch = implode('',$t);
        return $ch;
    }
    
    function generateModuleAjout($tableName, $colonnes, $P, $libelleTable, $genre, $ecraser = false)
    {
        global $MODULE_PATH, $DATA_PATH, $PAGES;
        
        if (!is_dir($MODULE_PATH))
            mkdir($MODULE_PATH);
        
        
        $ch =   '<?php'."\n"."\n".
                '/** '."\n".
                ' * Module généré automatiquement '."\n".
                ' * Il représente le formulaire d\'ajout/modification de la table `'. $tableName .'` de la base `'. $this->db->_db .'`'."\n".
                ' * @version '. $this->version ."\n".
                ' */'."\n\n";
        
        
        // on récupère le action
        $ch .=  'if (!isset($action))'."\n".
                '{'."\n".
                "\t".'if (isset($_GET[\'action\']))'."\n".
                "\t\t".'$action = $_GET[\'action\'];'."\n".
                "\t".'else'."\n".
                "\t\t".'$action = \'ajouter\';'."\n".
                '}'."\n\n";
        
        // Initialisation des variables du formulaire
        $ch .= '// Initialisation des variables du formulaire'."\n";
        $primaryKeyColonne = '';
        foreach($colonnes as $colonneName => $colonneInfo)
        {
            $defaultValue = '';
            if ($colonneInfo['DEFAULT'] != '')
                $defaultValue = $colonneInfo['DEFAULT'];

            $ch .= '$'. $colonneName .' = \''. $defaultValue .'\';'."\n";
            if ($colonneInfo['PRIMARY_KEY'] == 'YES')
                $primaryKeyColonne = $colonneName;
        }
        
        
        // modification d'un élément => récupération des valeurs
        $ch .=  "\n".
                "// Si l'on souhaite modifier un élément => récupération des valeurs\n".
                'if ($action == \'modifier\' && isset($_GET[\''.$primaryKeyColonne.'\']))'."\n".
                '{'."\n".
                "\t".'$'.$primaryKeyColonne.' = $_GET[\''.$primaryKeyColonne.'\'];'."\n".
                "\t".'$o = new '.$this->getNameForClass($tableName).'($db);'."\n".
                "\t".'$o->select(array(\''.$primaryKeyColonne.'\' => $'.$primaryKeyColonne.'));'."\n";
                
        
        foreach($colonnes as $colonneName => $colonneInfo)
        {
            if ($colonneInfo['PRIMARY_KEY'] != 'YES')
            {
                if ($colonneInfo['INPUT'] == 'input_date') // date US dans la base => conversion en FR
                    $ch .= "\t".'$'.$colonneName.' = getDateFr($o->get'. $this->getNameForClass($colonneName) .'());'."\n";
                else
                    $ch .= "\t".'$'.$colonneName.' = $o->get'. $this->getNameForClass($colonneName) .'();'."\n";
                // si type == date getDateFr ??
            }
        }
        $ch .= '}'."\n\n";
        
        // Définition des boutons
        $ch .= "// Définitions des boutons\n".
                '$BOUTTONS = array();'."\n";
        
        $ch .= '$BOUTTONS[] = array('."\n".
                "\t'ACTION' => 'return false;',\n".
                "\t'ID' => 'boutton_submit_form1',\n".
                "\t'TXT' => 'Sauver',\n".
                "\t'IMG' => \$page->getDesignUrl().'/images/toolbar/icon-32-save.png',\n".
                "\t'TITLE' => 'Cliquez ici pour <strong>enregistrer</strong> les modifications',\n".
                ');'."\n\n";
        
        $ch .=  '$JAVASCRIPTS[] = JS_FORMCHECK_URL.\'/lang/fr.js\';'."\n";
        $ch .=  '$JAVASCRIPTS[] = JS_FORMCHECK_URL.\'/formcheck.js\';'."\n\n";
        
        $ch .=  '$CSS_TO_LOAD = array();'."\n";
        $ch .=  '$CSS_TO_LOAD[] = JS_FORMCHECK_URL.\'/theme/red/formcheck.css\';'."\n\n";

        $ch .=  '$page->afficheHeader();'."\n"."\n";
        
        // Affichage du formulaire
        $ch .=  "?>\n\n".
                "<!-- Affichage du formulaire -->\n".
                '<form id="form1" name="form1" action="index.php" method="post" class="form1">'."\n".
                '<input type="hidden" name="P" value="'.$_POST['P_ajout_save'].'">'."\n".
                '<input type="hidden" name="'.$primaryKeyColonne.'" value="<?=$'.$primaryKeyColonne.'?>">'."\n".
                '<input type="hidden" name="action" value="<?=$action?>">'."\n";
        
        $ch .= '<fieldset>'."\n".
    	       "\t".'<legend>&nbsp;Informations sur l'.($genre == 'M' ? 'e':'a').' '.$this->convertMotsAuSingulier($libelleTable).'</legend>'."\n".
    	       "\t".'<table class="admintable">'."\n";
        
        foreach($colonnes as $colonneName => $colonneInfo)
        {
            if ($colonneInfo['PRIMARY_KEY'] != 'YES')
            {
                $libelle = $colonneInfo['INPUT_TXT'] != '' ? $colonneInfo['INPUT_TXT']:$colonneName;
                $ch .=  "\t\t".'<tr>'."\n".
                        "\t\t\t".'<td class="key">'. $libelle .' : ';
                if ($colonneInfo['NULL'] == 'NO')
                    $ch .= '<font color="red" size=2>*</font>';
                
                $ch .= '</td>'."\n";
                
                $codeSource = $this->getInputCode($colonneInfo['INPUT'], $colonneName, $colonneInfo['TYPE'], $colonneInfo['NULL']);
                $ch .=  "\t\t\t".'<td>';
                $ch .=  $codeSource;
                $ch .=  '</td>'."\n";
                $ch .= "\t\t</tr>\n";
            }
        }
        $ch .= "\t".'</table>'."\n";
        $ch .= '</fieldset>'."\n";
        $ch .= '</form>'."\n".
               "<!-- Fin du formulaire -->\n\n";
        // Fin du formulaire
        
        // Application du javascript sur le bouton
$ch .=  "<!-- Application du javascript sur le bouton -->
<script type=\"text/javascript\" language=\"JavaScript\">
window.addEvent('domready', function()
{
    var frm = new FormCheck('form1');
    var submitButton = $('boutton_submit_form1');
    submitButton.addEvent('click', function(e)
    {
	    frm.onSubmit(e);
	    if (frm.form.isValid == true)
        {
            document.form1.submit();
        }
    });
});
</script>\n\n";


        $ch .=  '<?php'."\n";
        $ch .=  '$page->afficheFooter();'."\n"."\n";
        $ch .=  '?>';
        
        $fichier = $MODULE_PATH.'/mod_'.$_POST['P_ajout_name'].'.php';
        if ($ecraser == false && file_exists($fichier))
        {
            return '<b><font color=red>Impossible de créer le fichier</font> '. $fichier .'</b> : le fichier existe déjà !';
        }
        else
        {
            $f = fopen($fichier, 'w+');
            if ($f)
            {
                fwrite($f, $ch);
                fclose($f);
            }
            
            // mise à jour du fichier config.php
           
            if (!isset($PAGES[$P]))
            {
                $this->str_replace_fichier($DATA_PATH.'/config.php', '$PAGES  =   array(',
                
"\$PAGES  =   array(
                        '".$P."' => array(
                                        'MODULE' => '".$_POST['P_ajout_name']."', // Module Généré automatiquement
                                        'TITRE' => 'Ajout/Modification d\'un".($genre == 'M' ? '':'e')." ".$this->convertMotsAuSingulier($libelleTable)."',
                                        'SECURE_ACCESS' => 1,
                                        ),"
);
            }
            
            return 'Fichier <a target="_blank" href="index.php?P='.$P.'"><b>'. $fichier .'</b></a> créé avec succès !';
        }
    }
    
    function generateModuleAjoutSave($tableName, $colonnes, $P, $libelleTable, $genre, $ecraser = false)
    {
        global $MODULE_PATH, $DATA_PATH, $PAGES;
        
        if (!is_dir($MODULE_PATH))
            mkdir($MODULE_PATH);
        
        
        $ch =   '<?php'."\n"."\n".
                '/** '."\n".
                ' * Module généré automatiquement '."\n".
                ' * Il représente la page d\'enregistrement de la table `'. $tableName .'` de la base `'. $this->db->_db .'`'."\n".
                ' * @version '. $this->version ."\n".
                ' */'."\n\n";
        
        
        // on récupère le action
        $ch .=  'if (isset($_POST[\'action\']))'."\n".
                '{'."\n".
                "\t".'$action = $_POST[\'action\'];'."\n".
                '}'."\n".
                'else'."\n".
                '{'."\n".
                "\t".'$action = \'\';'."\n".
                '}'."\n\n";
        
        $primaryKeyColonne = '';
        foreach($colonnes as $colonneName => $colonneInfo)
        {
            if ($colonneInfo['PRIMARY_KEY'] == 'YES')
                $primaryKeyColonne = $colonneName;
        }
        
        // Instantiation de l'objet
        $ch .=  "\n".
                "// Instantiation de l'objet\n".
                '$'.$this->getNameForColonne($tableName).' = new '.$this->getNameForClass($tableName).'($db);'."\n".
                '$error = \'\';'."\n\n".
                'if ($action == \'ajouter\' || $action == \'modifier\')'."\n".
                '{'."\n".
                "\t".'if ($action == \'modifier\')'."\n".
                "\t".'{'."\n".
                "\t\t".'$'.$this->getNameForColonne($tableName).'->select(array(\''.$primaryKeyColonne.'\' => $_POST[\''.$primaryKeyColonne.'\']));'."\n".
                "\t".'}'."\n\n";
        
        // on set toutes les variables        
        foreach($colonnes as $colonneName => $colonneInfo)
        {
            if ($colonneInfo['PRIMARY_KEY'] != 'YES')
            {
                $ch .= "\t".'$'.$this->getNameForColonne($tableName).'->set'.$this->getNameForClass($colonneName).'(';
                
                if ($colonneInfo['INPUT'] == 'input_date')
                    $ch .= 'getDateUs(';
                $ch .= '$_POST[\''.$colonneName.'\']';
                if ($colonneInfo['INPUT'] == 'input_date')
                    $ch .= ')';
                $ch .= ');'."\n";
            }
        }
        
        $ch .= "\n\t".'if ($action == \'ajouter\')'."\n".
                "\t".'{'."\n".
                "\t\t".'$res = $'.$this->getNameForColonne($tableName).'->insert();'."\n".
                "\t".'}'."\n".
                "\t".'else'."\n".
                "\t".'{'."\n".
                "\t\t".'$res = $'.$this->getNameForColonne($tableName).'->update();'."\n".
                "\t".'}'."\n\n";
        
        $ch .= "\t".'if (DB::isError($res))'."\n".
                "\t".'{'."\n".
                "\t\t".'$error = $res->getMessage();'."\n".
                "\t".'}'."\n".
                "\t".'else'."\n".
                "\t".'{'."\n".
                "\t\t".'if ($action == \'ajouter\')'."\n".
                "\t\t".'{'."\n".
                "\t\t\t".'$'.$primaryKeyColonne.' = mysql_insert_id($db->connection);'."\n".
                "\t\t".'}'."\n".
                "\t\t".'else'."\n".
                "\t\t".'{'."\n".
                "\t\t\t".'$'.$primaryKeyColonne.' = $_POST[\''.$primaryKeyColonne.'\'];'."\n".
                "\t\t".'}'."\n".
                "\t".'}'."\n";
        
        $ch .= '}'."\n"; // fin du ajouter || modifier
        
        $ch .=  'if ($action == \'supprimer\')'."\n".
                '{'."\n".
                "\t".'if (isset($_POST[\''.$primaryKeyColonne.'\']))'."\n".
                "\t".'{'."\n".
                "\t\t".'$tab = $_POST[\''.$primaryKeyColonne.'\'];'."\n".
                "\t".'}'."\n".
                "\t".'else'."\n".
                "\t".'{'."\n".
                "\t\t".'$tab = array();'."\n".
                "\t".'}'."\n".
                "\t".'foreach($tab as $'.$primaryKeyColonne.')'."\n".
                "\t".'{'."\n".
                "\t\t".'$res = executeReq($db, \'delete from '.$tableName.' where '.$primaryKeyColonne.'=\\\'\'. protegeChaine($'.$primaryKeyColonne.') .\'\\\'\');'."\n".
                "\t\t".'if (DB::isError($res))'."\n".
                "\t\t".'{'."\n".
                "\t\t\t".'$error = $res->getMessage();'."\n".
                "\t\t\t".'break;'."\n".
                "\t\t".'}'."\n".
                "\t".'}'."\n".
                '}'."\n\n";
        
        $ch .=  'if ($error != \'\')'."\n".
                '{'."\n".
                "\t".'$page->afficheHeader();'."\n".
                "\t".'echo \'<font color="red"><b>ERREUR DETECTEE : </b>\'.$error.\'</font>\';'."\n".
                "\t".'$page->afficheFooter();'."\n".
                '}'."\n".
                'else'."\n".
                '{'."\n".
                "\t".'deconnexionDesBases();'."\n".
                "\t".'header(\'Location: index.php?P='.$_POST['P_list'].'\');'."\n".
                "\t".'exit;'."\n".
                '}'."\n\n";
                
        $ch .=  '?>';
        
        $fichier = $MODULE_PATH.'/mod_'.$_POST['P_ajout_save_name'].'.php';
        if ($ecraser == false && file_exists($fichier))
        {
            return '<b><font color=red>Impossible de créer le fichier</font> '. $fichier .'</b> : le fichier existe déjà !';
        }
        else
        {
            $f = fopen($fichier, 'w+');
            if ($f)
            {
                fwrite($f, $ch);
                fclose($f);
            }
            
            // mise à jour du fichier config.php
           
            if (!isset($PAGES[$P]))
            {
                $this->str_replace_fichier($DATA_PATH.'/config.php', '$PAGES  =   array(',
                
"\$PAGES  =   array(
                        '".$P."' => array(
                                        'MODULE' => '".$_POST['P_ajout_save_name']."', // Module Généré automatiquement
                                        'TITRE' => 'Enregistrement d\'un".($genre == 'M' ? '':'e')." ".$this->convertMotsAuSingulier($libelleTable)."',
                                        'SECURE_ACCESS' => 1,
                                        ),"
);
            }
            
            return 'Fichier <a target="_blank" href="index.php?P='.$P.'"><b>'. $fichier .'</b></a> créé avec succès !';
        }
    }
    
    function generateModuleList($tableName, $colonnes, $P, $libelleTable, $genre, $ecraser = false)
    {
        global $MODULE_PATH, $DATA_PATH, $PAGES;
        
        if (!is_dir($MODULE_PATH))
            mkdir($MODULE_PATH);
        
        
        $ch =   '<?php'."\n"."\n".
                '/** '."\n".
                ' * Module généré automatiquement '."\n".
                ' * Il représente la page qui liste les lignes de la table `'. $tableName .'` de la base `'. $this->db->_db .'`'."\n".
                ' * @version '. $this->version ."\n".
                ' */'."\n\n";
        
        
        // on récupère le action
        $ch .=  'if (!isset($action))'."\n".
                '{'."\n".
                "\t".'if (isset($_POST[\'action\']))'."\n".
                "\t\t".'$action = $_POST[\'action\'];'."\n".
                "\t".'else'."\n".
                "\t\t".'$action = \'\';'."\n".
                '}'."\n\n";
        
        // Récupération du numéro de la page
        $ch .=  'if (isset($_GET[\'pn\'])) // Récupération du numéro de la page'."\n".
                "\t".'$pageNumber = $_GET[\'pn\'];'."\n".
                'else'."\n".
                "\t".'$pageNumber = 0;'."\n\n";
        
        // Récupération du nombre d'éléments par page
        $ch .=  'if (isset($_GET[\'epn\'])) // Récupération du nombre d\'éléments par page'."\n".
                "\t".'$elementParPage = $_GET[\'epn\'];'."\n".
                'else'."\n".
                "\t".'$elementParPage = 30;'."\n\n";
    
        // Récupération de l'order by
        $ch .=  'if (isset($_GET[\'orderby\'])) // Récupération de l\'order by'."\n".
                "\t".'$orderby = $_GET[\'orderby\'];'."\n".
                'else'."\n".
                "\t".'$orderby = \'\';'."\n\n";
                
        // Récupération de l'ordre de l'order by
        $ch .=  'if (isset($_GET[\'type\']) && $_GET[\'type\'] == \'DESC\') // Récupération de l\'ordre de l\'order by'."\n".
                '{'."\n".
                "\t".'$type = \'DESC\';'."\n".
                "\t".'$typeLien = \'ASC\';'."\n".
                '}'."\n".
                'else'."\n".
                '{'."\n".
                "\t".'$type = \'ASC\';'."\n".
                "\t".'$typeLien = \'DESC\';'."\n".
                '}'."\n\n";
        
        $ch .=  '$rech = \'\'; // Chaine contenant le where de la recherche'."\n";

        $ch .=  '$lienPaginationParametre =  \'index.php?P='.$P.'&orderby=\'.$orderby.'."\n".
                '                            \'&type=\'.$type;'."\n";
                            
        $ch .=  'if (isset($_GET[\'search\']) && trim($_GET[\'search\']) != \'\' && isset($_GET[\'colonne\']) && $_GET[\'colonne\'] != \'\')'."\n";
        $ch .=  '{'."\n";
        $ch .=  "\t".'$rech = $_GET[\'colonne\'] .\' like \\\'%\'. protegeChaine($_GET[\'search\']) .\'%\\\' \';'."\n";
        $ch .=  "\t".'$lienPaginationParametre .= \'&search=\'.$_GET[\'search\'].\'&colonne=\'.$_GET[\'colonne\'];'."\n";
        $ch .=  '}'."\n\n";

        // Définition des boutons
        $ch .= "// Définitions des boutons\n".
                '$BOUTTONS = array();'."\n";
        
        $P_ajout = $_POST['P_ajout'];
        
        // Bouton de suppression
        //<a onclick="window.document.form1.cidas.value=\''.$v['CONVENTION_ID'].'\';Ext.MessageBox.show({title:\'ATTENTION\',msg: \'Toutes les informations sur cette convention seront supprim&eacute;es !<br/><br/>Etes vous certain de vouloir <b>supprimer cette convention</b> ?\',buttons: Ext.MessageBox.YESNO,fn: supprimeConvention,icon: Ext.MessageBox.WARNING});" href="#">
        $ch .= '$BOUTTONS[] = array('."\n".
                "\t'HREF' => '#',\n".
                "\t'ACTION' => 'Ext.MessageBox.show({title:\'ATTENTION\',msg: \'Tous les &eacute;l&eacute;ments s&eacute;lectionn&eacute;s seront supprim&eacute;s !<br/><br/>Etes vous certain de vouloir <b>supprimer ces &eacute;l&eacute;ments</b> ?\',buttons: Ext.MessageBox.YESNO,fn: supprimeElement,icon: Ext.MessageBox.WARNING});',\n".
                "\t'TXT' => 'Supprimer',\n".
                "\t'IMG' => \$page->getDesignUrl().'/images/toolbar/icon-32-trash.png',\n".
                "\t'TITLE' => 'Cliquez ici pour <strong>supprimer</strong> les <strong>".$libelleTable."</strong> sélectionné".($genre == 'M' ? '':'e')."s',\n".
                ');'."\n";
        
        // Bouton d'ajout
        $ch .= '$BOUTTONS[] = array('."\n".
                "\t'HREF' => 'index.php?P=".$P_ajout."&action=ajouter',\n".
                "\t'TXT' => 'Nouve".($genre == 'M' ? 'au':'lle')." ".$this->convertMotsAuSingulier($libelleTable)."',\n".
                "\t'IMG' => \$page->getDesignUrl().'/images/toolbar/icon-32-new.png',\n".
                "\t'TITLE' => 'Cliquez ici pour <strong>créer</strong> un".($genre == 'M' ? '':'e')." nouve".($genre == 'M' ? 'au':'lle')." <strong>".$this->convertMotsAuSingulier($libelleTable)."</strong>',\n".
                ');'."\n\n";
        
        
        $ch .=  '$JAVASCRIPTS[] = \'http://extjs.prod.intranet/adapter/ext/ext-base.js\';'."\n";
        $ch .=  '$JAVASCRIPTS[] = \'http://extjs.prod.intranet/ext-all.js\';'."\n";
        $ch .=  '$JAVASCRIPTS[] = \'http://extjs.prod.intranet/source/locale/ext-lang-fr.js\';'."\n";
        $ch .=  '$CSS_TO_LOAD[] = \'http://extjs.prod.intranet/resources/css/ext-all.css\';'."\n\n";
//        $ch .=  '$CSS_TO_LOAD[] = \'http://extjs.prod.intranet/resources/css/dialog.css\';'."\n";
//        $ch .=  '$CSS_TO_LOAD[] = \'http://extjs.prod.intranet/resources/css/window.css\';'."\n";
//        $ch .=  '$CSS_TO_LOAD[] = \'http://extjs.prod.intranet/resources/css/box.css\';'."\n";
//        $ch .=  '$CSS_TO_LOAD[] = \'http://extjs.prod.intranet/resources/css/core.css\';'."\n";
//        $ch .=  '$CSS_TO_LOAD[] = \'http://extjs.prod.intranet/resources/css/borders.css\';'."\n";
        
        
        $ch .= '$PAGES[$P][\'HEAD_JAVASCRIPT\'] = \'function supprimeElement(btn){if (btn == \\\'yes\\\'){document.F1.action.value=\\\'supprime_elements\\\';document.F1.submit();}}\';'."\n\n";
        
        list($champs, $primaryKey) = $this->getAllChampsForTableName($tableName);
        
        
        $ch .= '// Suppression des éléments sélectionnés'."\n";
        $ch .= 'if ($action == \'supprime_elements\')'."\n";
        $ch .= '{'."\n";
        $ch .= "\t".'foreach($_POST[\''.$primaryKey[0].'\'] as $'.$primaryKey[0].')'."\n";
        $ch .= "\t".'{'."\n";
        $ch .= "\t\t".'$o = new '.$this->getNameForClass($tableName).'($db);'."\n";
        $ch .= "\t\t".'$o->select(array(\''.$primaryKey[0].'\' => $'.$primaryKey[0].'));'."\n";
        $ch .= "\t\t".'$o->delete();'."\n";
        $ch .= "\t".'}'."\n";
        $ch .= '}'."\n\n";
        $ch .=  '$page->afficheHeader();'."\n"."\n";
        
        
        // Requete qui compte le nombre d'éléments maximum
        $ch .=  "// on compte le nombre de lignes au maximum\n";
        $ch .=  '$req =  \'SELECT count(*) \'.'."\n";
        $ch .=  '        \'FROM '.$tableName.' \'.'."\n";
        $ch .=  '        ($rech != \'\' ? \'WHERE \'. $rech:\'\');'."\n";
        $ch .=  '$res = executeReq($db, $req);'."\n";
        $ch .=  'list($nbResultatMax) = $res->fetchRow();'."\n\n";
        
        // Récupération des lignes
        $ch .=  "// Récupération des lignes\n";
        $ch .=  '$req =  \'SELECT ';
        
        
        $chSelect = '';
        foreach($champs as $colonne => $v)
        {
            if (!in_array($colonne, $primaryKey) && !array_key_exists($colonne, $colonnes))
                continue;
            if ($chSelect != '')
                $chSelect .= ', ';
            $chSelect .= $colonne;
        }
        $ch .= $chSelect .' \'.'."\n";
        $ch .=  '        \'FROM '. $tableName .' \'.'."\n";
        $ch .=  '        ($rech != \'\' ? \'WHERE \'. $rech:\'\').'."\n";
        $ch .=  '        ($orderby != \'\' ? \' ORDER BY \'. $orderby.\' \'.$type:\'\').'."\n";
        $ch .=  '        \' LIMIT \'. ($pageNumber*$elementParPage) .\', \'. $elementParPage;'."\n\n";
        
        $ch .=  '$res = executeReq($db,$req);'."\n";
        
        // Affichage des éléments avec l\'objet Table
        $ch .=  '// Affichage des éléments avec l\'objet Table'."\n";
        $ch .=  '$table = new Table();'."\n";
        $ch .=  '$table->setNbResultatParPage($elementParPage);'."\n";
        $ch .=  '$table->setNbResultatMax($nbResultatMax);'."\n";
        $ch .=  '$table->setLienPaginationParametre($lienPaginationParametre);'."\n\n";
        
        // Définition des colonnes
        $ch .=  '// Définition des colonnes'."\n";
        $i = 1;
        $indiceColonneClePrimaire = '';
        foreach($champs as $colonne => $v)
        {
            // si c'est pas une clé primaire et que la clé n'existe pas dans le tableau
            if (!in_array($colonne, $primaryKey) && !array_key_exists($colonne, $colonnes))
                continue;
            if ($indiceColonneClePrimaire == '' && in_array($colonne, $primaryKey))
                $indiceColonneClePrimaire = $i;
            if (in_array($colonne, $primaryKey))
                $libelle = '#';
            else
                $libelle = $colonnes[$colonne]['INPUT_TXT'] != '' ? $colonnes[$colonne]['INPUT_TXT']:$colonne;
            $ch .=  '$table->ajouteColonne(\''.$libelle.'\', \''.$colonne.'\'';
            
            // si c'est une clé primaire
            if (in_array($colonne, $primaryKey))
                $ch .= ', 10, \'center\'';
            $ch .= ');'."\n";
            $i++;
        }
        
        $ch .=  "\n";
        
        if (count($primaryKey) == 1)
        {
            
            $ch .=  '$table->setCheckboxPosition(2); // on affiche les checkbox dans la seconde colonne'."\n";
            $ch .=  '$table->setCheckboxName(\''.$primaryKey[0].'\'); // le nom du checkbox'."\n";
            $ch .=  '$table->setCheckboxValue('.$indiceColonneClePrimaire.'); // les différents checkbox du tableau doivent prendre la valeur de la '.$indiceColonneClePrimaire.''.($indiceColonneClePrimaire == 1 ? 'ère':'ème').' colonne'."\n\n";
        }
        
        $ch .=  '// Activation de la recherche'."\n";
        $ch .=  '$table->setAfficheFiltre(true);'."\n";
        
        // while
        $ch .=  'while(list(';
        
        $chSelect = '';
        foreach($champs as $colonne => $v)
        {
            if (!in_array($colonne, $primaryKey) && !array_key_exists($colonne, $colonnes))
                continue;
            if ($chSelect != '')
                $chSelect .= ', ';
            $chSelect .= '$'. $colonne;
        }
        $ch .= $chSelect .') = $res->fetchRow())'."\n";
        $ch .=  '{'."\n";
        $ch .=  "\t".'$table->ajouteValeur(array('."\n";
        
        foreach($champs as $colonne => $v)
        {
            if (!in_array($colonne, $primaryKey) && !array_key_exists($colonne, $colonnes))
                continue;
            
            $ch .=  '	                           ';
            if (count($primaryKey) == 1 && isset($colonnes[$colonne]) && $colonnes[$colonne]['LINK_MODIF'] == 'on')
            {
                $ch .= '\'<a href="index.php?P='.$P_ajout.'&action=modifier&'.$primaryKey[0].'=\'.$'.$primaryKey[0].'.\'"'.
                       ' title="Cliquez ici pour <b>modifier cet enregistrement</b>"'.
                       '>\'.';
            }
            if ($v['TYPE'] == 'date')
            {
                $ch .= 'getDateFr(';
            }
            $ch .= '$'. $colonne;
            if ($v['TYPE'] == 'date')
            {
                $ch .= ')';
            }
            if (isset($colonnes[$colonne]) && $colonnes[$colonne]['LINK_MODIF'] == 'on')
            {
                $ch .= '.\'</a>\'';
            }
            $ch .= ','."\n";
        }
        
        $ch .=  '	                    ));'."\n";
        $ch .=  '}'."\n";
        
        // Affichage de la table
        $ch .=  '// Affichage de la table'."\n";
        $ch .=  '$table->draw();'."\n";
        
        $ch .=  "\n".'$page->afficheFooter();'."\n"."\n";
        $ch .=  '?>';
        
        $fichier = $MODULE_PATH.'/mod_'.$_POST['P_list_name'].'.php';
        if ($ecraser == false && file_exists($fichier))
        {
            return '<b><font color=red>Impossible de créer le fichier</font> '. $fichier .'</b> : le fichier existe déjà !';
        }
        else
        {
            $f = fopen($fichier, 'w+');
            if ($f)
            {
                fwrite($f, $ch);
                fclose($f);
            }
            
            // mise à jour du fichier config.php
           
            if (!isset($PAGES[$P]))
            {
                $this->str_replace_fichier($DATA_PATH.'/config.php', '$PAGES  =   array(',
                
"\$PAGES  =   array(
                        '".$P."' => array(
                                        'MODULE' => '".$_POST['P_list_name']."', // Module Généré automatiquement
                                        'TITRE' => 'Liste des ".$libelleTable."',
                                        'SECURE_ACCESS' => 1,
                                        ),"
);
            }
            
            return 'Fichier <a target="_blank" href="index.php?P='.$P.'"><b>'. $fichier .'</b></a> créé avec succès !';
        }
    }
    
    function str_replace_fichier($filename, $chaine, $chaineRemplacement, $verbose = true, $verifChaine = true)
    {
        // Assurons nous que le fichier est accessible en écriture
        if (is_writable($filename))
        {
            // Lit un fichier, et le place dans une chaîne
            $handle = fopen ($filename, "r");
            $contents = fread ($handle, filesize ($filename));
            fclose($handle);
            
            // Vérification si la chaine n'est pas déjà dans le fichier
            if ($verifChaine && substr_count($contents, $chaineRemplacement) > 0)
            {
                echo 'ERREUR ['.str_replace(array("\n","\r"), '', $chaineRemplacement).'] deja present'."\n";
                return;
            }
            
            // Remplacement dans la chaine
            $contents = str_replace($chaine, $chaineRemplacement, $contents);
            
            // Réécriture dans le fichier
            if (!$handle = fopen($filename, 'w'))
            {
                 echo "Impossible d'ouvrir le fichier ($filename)\n";
                 return;
            }
            
            if (fwrite($handle, $contents) === FALSE)
            {
               echo "Impossible d'ecrire dans le fichier ($filename)\n";
               return;
            }
            fclose($handle);
            if ($verbose)
                echo "Modif : $chaineRemplacement\n";
        }
        else
        {
            echo "ERREUR: Le fichier $filename n'est pas accessible en ecriture.\n";
            return;
        }
    }

    function getAllChampsForTableName($tableName)
    {
        // Récupération des colonnes de la table
        if ($this->base == 'mysql')
            $req = 'show fields from '. $tableName;
        else
            $req =  'select column_name, data_type, nullable, nullable, data_default, data_length '.
                    'from user_tab_columns '.
                    'where TABLE_NAME=\''. $tableName .'\' order by column_id';
        $res = executeReq($this->db, $req);
        $table = array();
        $primaryKey = array();
        while(list($field, $type, $null, $key, $default, $extra) = $res->fetchRow())
        {
            $comment = '';
            if ($this->base == 'oracle')
            {
                $req2 = 'select user_constraints.constraint_name,user_cons_columns.column_name, user_constraints.constraint_type '.
                        'from user_constraints, user_cons_columns '.
                        'where user_constraints.OWNER=user_cons_columns.OWNER '.
                        'and user_constraints.CONSTRAINT_NAME=user_cons_columns.CONSTRAINT_NAME '.
                        'and user_constraints.TABLE_NAME=user_cons_columns.TABLE_NAME '.
                        'and user_constraints.constraint_type=\'P\' '.
                        'and user_constraints.TABLE_NAME=\''. $tableName .'\' '.
                        'and user_cons_columns.column_name=\''. $field .'\' ';
                
                $res2 = executeReq($this->db, $req2);
                $key = '';
                while(list($constraint_name, $column_name, $constraint_type) = $res2->fetchRow())
                {
                    $key = 'PRI';
                }
            }
            
            // Oracle => == 'Y' ? 'YES':'NO')
            $table[$field] = array(
                                    'FIELD' => $field,
                                    'TYPE' => $type,
                                    'NULL' => $null,
                                    'KEY' => $key,
                                    'DEFAULT' => $default,
                                    'EXTRA' => $extra,
                                    'VAR' => $this->getNameForColonne($field),
                                    'COMMENT' => $comment,
                                   );
            if ($key == 'PRI')
                $primaryKey[] = $field;
        }
        // récupération des commentaires des colonnes
        if ($this->base == 'mysql')
        {
            $req = 'show full columns from '.$tableName;
            $res = executeReq($this->db, $req);
            while($t = $res->fetchRow())
            {
                $table[$t[0]]['COMMENT'] = $t[8];
            }
        }
        return array($table, $primaryKey);
    }
    
    function getInputCode($inputType, $colonne_name, $colonne_type, $colonne_can_be_null = 'YES')
    {
        $code = '';
        
        $colonne_name = strtolower($colonne_name);
        
        $c = str_replace('(', '#', strtolower($colonne_type));
        $c = str_replace(')', '', $c);
        
        // varchar#100
        if (substr_count($c, '#') == 1)
        {
            list($type, $taille) = explode('#', $c);
        }
        else
        {
            $type = $c;
            $taille = ''; // taille de la colonne
        }
        
        $size = $taille + 4;
        if ($size > 80)
            $size = 80;

        // Génération des inputs
        
        if ($inputType == 'input_text')
        {
            $code = '<input type="text" name="'. $colonne_name .'" size="'.$size.'" value="<?=$'.$colonne_name.'?>" class="validate['.($colonne_can_be_null == 'NO' ? '\'required\',':'').'\'length[0,'.$taille.']\']" />';
        }
        else if ($inputType == 'input_email')
        {
            $code = '<input type="text" name="'. $colonne_name .'" size="'.$size.'" value="<?=$'.$colonne_name.'?>" class="validate['.($colonne_can_be_null == 'NO' ? '\'required\',':'').'\'length[0,'.$taille.']\', \'email\']" />';
        }
        else if ($inputType == 'input_hidden')
        {
            $code = '<input type="hidden" name="'. $colonne_name .'" value="<?=$'.$colonne_name.'?>" />';
        }
        else if ($inputType == 'input_date')
        {
            $code = '<input type="text" size="12" name="'. $colonne_name .'" id="'. $colonne_name .'" value="<?=$'. $colonne_name .'?>" class="validate['.($colonne_can_be_null == 'NO' ? '\'required\',':'').'\'datefr\']"/>'.
                    '<a title="Afficher le calendrier" href="#" onclick="return showCalendar(\''. $colonne_name .'\', \'%d/%m/%Y\');"><img class="calendar" src="<?=$page->getDesignUrl()?>/images/calendar.png" /></a>';
        }
        else if ($inputType == 'textarea')
        {
            $code = '<textarea rows="10" cols="80" name="'. $colonne_name .'"><?=$'. $colonne_name .'?></textarea>';
        }
        else if ($inputType == 'select_y_n')
        {
            $code = "\n".'<?php'."\n".
                    "\t".'$select = \'<select name="'. $colonne_name .'">'.
                        '<option value="1">Oui</option>'.
                        '<option value="0">Non</option>'.
                    '</select>\';'."\n".
                    "\t".'$select = str_replace(\'value="\'.$'. $colonne_name .'.\'"\', \'value="\'.$'. $colonne_name .'.\'" selected\', $select);'."\n".
                    "\t".'echo $select;'."\n".
                    '?>'."\n";
        }
        else if ($inputType == 'select_sexe')
        {
            $code = '<?php'."\n".
                    '$select = \'<select name="'. $colonne_name .'"';
            if ($colonne_can_be_null == 'NO')
                $code .= ' class="validate[\\\'required\\\']"';
            $code .=    '>'.
                        '<option value="">Sélectionnez le sexe de la personne...</option>'.
                        '<option value="H">Homme</option>'.
                        '<option value="F">Femme</option>'.
                    '</select>\';'."\n";
            $code .= '$select = str_replace(\'value="\'.$'. $colonne_name .'.\'"\', \'value="\'.$'. $colonne_name .'.\'" selected\', $select);'."\n";
            $code .= 'echo $select;'."\n";
            $code .= '?>';
        }
        else
        {
            $code = '';
        }
        
        return $code;
    }
    
    function getInputTypeForColonne($colonne_name, $colonne_type)
    {
        global $page;
        $inputName = '';
        $inputCode = '';
        $colonne_name = strtolower($colonne_name);
        // varchar(100)
        $c = str_replace('(', '#', strtolower($colonne_type));
        $c = str_replace(')', '', $c);
        
        // varchar#100
        if (substr_count($c, '#') == 1)
        {
            list($type, $taille) = explode('#', $c);
        }
        else
        {
            $type = $c;
            $taille = '';
        }
        
        if (substr($type, 0, 7) == 'varchar') // input
        {
            $size = $taille + 4;
            if ($size > 80)
                $size = 80;
            $inputName = 'input_text';
            
            if (substr_count($colonne_name, 'mail') == 1)
                $inputName = 'input_email';
            
            if ($taille == 1 && substr_count($colonne_name, 'sexe') == 1)
                $inputName = 'select_sexe';

        }
        else if ($type == 'text') // textarea
        {
            $inputName = 'textarea';
        }
        else if ($type == 'date') // input date
        {
            
            $inputName = 'input_date';
        }
        else if ($type == 'int' && $taille == 1) // int de 1 => OUI ou NON
        {
            
            $inputName = 'select_y_n';
        }
        else if ($type == 'int' && substr($colonne_name, -3) != '_id') // int
        {
            $size = $taille + 4;
            if ($size > 80)
                $size = 80;
            $inputName = 'input_text';
        }
        else
        {
            $inputName = '';
        }
        
//        return array($inputName, $inputCode);
        return $inputName;
    }
    
    function getClassForListeObjet($tableName)
    {
        $table = array();
        $ch =   '<?php'."\n"."\n".
                '/** '."\n".
                ' * Classe représentant une liste d\'objet de type '. $this->getNameForClass($tableName) ."\n".
                ' * @version '. $this->version ."\n".
                ' */'."\n";
//        $ch =   '<?php'."\n"."\n".
//                '/** '."\n".
//                ' * NE PAS MODIFIER, Fichier généré automatiquement par class_objet_bdd. '."\n".
//                ' * Ce fichier représente plusieurs objet de la class `'. $this->getNameForClass($tableName) .'`.'."\n".
//                ' */'."\n"."\n";

        $ch .=  'class '. $this->getNameForClass('liste_'.$tableName) ."\n".
                '{'."\n";
        
        $ch .= "\t".'var $db;'."\n";
        $ch .= "\t".'var $nb = 0;'."\n";
        $ch .= "\t".'var $liste = array();'."\n";
        
        list($table, $primaryKey) = $this->getAllChampsForTableName($tableName);
        
//        // Récupération des colonnes de la table
//        if ($this->base == 'mysql')
//            $req = 'show fields from '. $tableName;
//        else
//            $req =  'select column_name, data_type, data_length, data_precision, nullable, data_default '.
//                    'from user_tab_columns '.
//                    'where TABLE_NAME=\''. $tableName .'\' order by column_id';
//
//        $res = executeReq($this->db, $req);
//        while(list($field, $type, $null, $key, $default, $extra) = $res->fetchRow())
//        {
//            $table[$field] = array(
//                                    'FIELD' => $field,
//                                    'TYPE' => $type,
//                                    'NULL' => $null,
//                                    'KEY' => $key,
//                                    'DEFAULT' => $default,
//                                    'EXTRA' => $extra,
//                                    'VAR' => $this->getNameForColonne($field)
//                                   );
//        }

        // Fonction qui ajoute un objet dans la liste
        $ch .= "\n\t".'// Fonction qui ajoute un objet dans la liste'."\n";
        $ch .=  "\t".'function add($v)'."\n".
                "\t".'{'."\n".
                "\t"."\t".'$this->liste[] = $v;'."\n".
                "\t".'}'."\n";
        
        // Fonction qui renvoie un objet de la liste
        $ch .= "\n\t".'// Fonction qui renvoie un objet de la liste'."\n";
        $ch .=  "\t".'function get($i)'."\n".
                "\t".'{'."\n".
                "\t"."\t".'return $this->liste[$i];'."\n".
                "\t".'}'."\n";
        
        // Fonction qui renvoie le nombre d'objet dans la liste
        $ch .= "\n\t".'// Fonction qui renvoie le nombre d\'objet dans la liste'."\n";
        $ch .=  "\t".'function size()'."\n".
                "\t".'{'."\n".
                "\t"."\t".'return $this->nb;'."\n".
                "\t".'}'."\n";
        
        // Déclaration du constructeur
        $ch .= "\n\t".'// constructeur'."\n";
        $ch .=  "\t".'function '. $this->getNameForClass('liste_'.$tableName) .'($db)'."\n".
                "\t".'{'."\n".
                "\t"."\t".'return $this->db = $db;'."\n".
                //"\t"."\t".'return $this->liste = array();'."\n".
                //"\t"."\t".'if (count($where) > 0)'."\n".
                //"\t"."\t"."\t".'$this->select($where);'."\n".
                "\t".'}'."\n";
        
        // Select
        $ch .= "\n\t".'// Récupération de plusieurs objet'."\n";
        $ch .=  "\t".'function select($where = array(), $orderBy = array())'."\n".
                "\t".'{'."\n";
        
        $ch .=  "\t"."\t".'$req = \'SELECT ';
        
        $chSelect = '';
        foreach($table as $colonne => $v)
        {
            if ($chSelect != '')
                $chSelect .= ', ';
            $chSelect .= $colonne;
        }
        $ch .= $chSelect .' \'.'."\n";
        $ch .= "\t"."\t".'       \'FROM '. $tableName .' \';'."\n";
        
        // WHERE
        $ch .= "\t"."\t".'$chWhere = \'\';'."\n";
        $ch .= "\t"."\t".'foreach($where as $k => $v)'."\n";
        $ch .= "\t"."\t".'{'."\n";
        $ch .= "\t"."\t"."\t".'if ($chWhere != \'\')'."\n";
        $ch .= "\t"."\t"."\t"."\t".'$chWhere .= \'AND \';'."\n";
        $ch .= "\t"."\t"."\t".'else'."\n";
        $ch .= "\t"."\t"."\t"."\t".'$chWhere .= \'WHERE \';'."\n";
        $ch .=  "\t"."\t"."\t".'$chWhere .= $k .\'=\\\'\'. '.
                ($this->base == 'oracle' ? 'protegeChaineOracle':'protegeChaine').
                '($v) .\'\\\' \';'."\n";
        $ch .= "\t"."\t".'}'."\n";
        $ch .= "\t"."\t".'$req .= $chWhere;'."\n";
        
        // ORDER BY
        $ch .= "\t"."\t".'$chOrderBy = \'\';'."\n";
        $ch .= "\t"."\t".'foreach($orderBy as $k => $v)'."\n";
        $ch .= "\t"."\t".'{'."\n";
        $ch .= "\t"."\t"."\t".'if ($chOrderBy != \'\')'."\n";
        $ch .= "\t"."\t"."\t"."\t".'$chOrderBy .= \', \';'."\n";
        $ch .= "\t"."\t"."\t".'else'."\n";
        $ch .= "\t"."\t"."\t"."\t".'$chOrderBy .= \'ORDER BY \';'."\n";
        $ch .= "\t"."\t"."\t".'$chOrderBy .= $k .\' \'. $v .\' \';'."\n";
        $ch .= "\t"."\t".'}'."\n";
        $ch .= "\t"."\t".'$req .= $chOrderBy;'."\n";
        
        $ch .= "\t"."\t".'$res = executeReq($this->db, $req);'."\n";
        
        $ch .= "\t"."\t".'while(list(';
        $chSelect = '';
        foreach($table as $colonne => $v)
        {
            if ($chSelect != '')
                $chSelect .= ', ';
            $chSelect .= '$'. $colonne;
        }
        $ch .= $chSelect .') = $res->fetchRow())'."\n";
        $ch .= "\t"."\t".'{'."\n";
        $ch .= "\t"."\t"."\t".'$obj = new '. $this->getNameForClass($tableName) .'($this->db);'."\n";
        
        foreach($table as $colonne => $v)
        {
            $ch .= "\t"."\t"."\t".'$obj->set'. ucfirst($v['VAR']) .'($'. $colonne .');'."\n";
        }
        $ch .= "\t"."\t"."\t".'$this->add($obj);'."\n";
        
        $ch .= "\t"."\t".'}'."\n";
        $ch .= "\t"."\t".'$this->nb = count($this->liste);'."\n";
        $ch .= "\t".'}'."\n";
        
        // Fin Select
        
        // Fonction Help qui permet d'avoir la liste des méthodes
        $ch .= "\n\t".'/** '."\n".
            "\t".' * Fonction qui affiche la liste des méthodes de la classe '.$this->getNameForClass('liste_'.$tableName)."\n".
            "\t".' */'."\n";
        $ch .=  "\t".'function help()'."\n".
                "\t".'{'."\n".
                "\t"."\t".'$tab = get_class_methods($this);'."\n".
                "\t"."\t".'echo \'<br>Liste des fonctions de la classe <b>'.$this->getNameForClass('liste_'.$tableName).'</b> : <br>\';'."\n".
                "\t"."\t".'foreach($tab as $methodeName)'."\n".
                "\t"."\t".'{'."\n".
                "\t"."\t"."\t".'$methodeName = str_replace(\'set\', \'<font color=red>set</font>\', $methodeName);'."\n".
                "\t"."\t"."\t".'$methodeName = str_replace(\'get\', \'<font color=green>get</font>\', $methodeName);'."\n".
                "\t"."\t"."\t".'$methodeName = str_replace(\'select\', \'<font color=#E45000>select</font>\', $methodeName);'."\n".
                "\t"."\t"."\t".'$methodeName = str_replace(\'update\', \'<font color=#E45000>update</font>\', $methodeName);'."\n".
                "\t"."\t"."\t".'$methodeName = str_replace(\'delete\', \'<font color=#E45000>delete</font>\', $methodeName);'."\n".
                "\t"."\t"."\t".'$methodeName = str_replace(\'insert\', \'<font color=#E45000>insert</font>\', $methodeName);'."\n".
                "\t"."\t"."\t".'echo \'function \'. $methodeName.\'(...)<br>\';'."\n".
                "\t"."\t".'}'."\n".
                "\t".'}'."\n";
        // fin fonction Help
        
        $ch .=  '}'."\n"."\n";
        $ch .=  '?>';
        return $ch;
    }
}

?>