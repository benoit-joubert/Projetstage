<?php
 /**
 * @package common
 * 
 */

 /**
 * Retourne le temps en miliseconde depuis 1970
 * 
 * @return float temps en miliseconde
 */
function getMicroTime()
{
	list($usec, $sec) = explode(" ",microtime()); 
	return ((float)$usec + (float)$sec); 
}

 /**
 *
 * Initialise la session de l'utilisateur
 * 
 */
function sessionInitialise()
{
    // Si un id de session existe, on charge cet id de session
    if (isset($PHPSESSID))
    {
    	session_start($PHPSESSID);
    }
    else // Sinon, on crée une nouvelle session
    {
    	session_start();
    }
    
    if (!isset($_SESSION[PROJET_NAME]))
    {
        $_SESSION[PROJET_NAME] = array(
                                        'authentified' => 0,
                                        'page_demandee' => '',
                                        'user_droit' => array(),
                                      );
    }
}

function getDataDirectory($typeReturn = 'PATH')
{
    global $GENERAL_PATH;
    $repertoireProjet =  basename($GENERAL_PATH);
    if (!file_exists(RACINE.'/datas/'))
        mkdir(RACINE.'/datas');
    if (!file_exists(RACINE.'/datas/'.$repertoireProjet.'/'))
        mkdir(RACINE.'/datas/'.$repertoireProjet.'/');
    
    if ($typeReturn == 'URL') // URL
        return '../datas/'.$repertoireProjet;
    else // PATH
        return RACINE.'/datas/'.$repertoireProjet;
}

 /**
 * Affiche le contenu d'une variable avec un rendu HTML
 * les retours à la ligne sont remplacés par des <br>
 * 
 * @param multi_type variable à afficher
 */
function print_jc($var, $echo = true)
{
    ob_start();
    print_r($var);
    $data = ob_get_contents();
    $data = str_replace("\n",'<br>',$data);
    $data = str_replace("=>",'<font color=red>=></font>',$data);
    $data = str_replace("    ",'&nbsp;&nbsp;&nbsp;&nbsp;',$data);
    ob_end_clean();
    if ($echo == true)
        echo $data;
    else
        return $data;
}

/**
 * Affiche le contenu d'une variable avec un rendu HTML
 * @param multi_type - $data - variable a afficher
 * @param boolean - $B_echo - si TRUE on affiche, si FALSE on retourne la valeur
 * @return multi_type - si $B_echo = TRUE : void, sinon on retourne un tableau HTML
 */
function print_jv($data, $B_echo = true) {
    if ($B_echo) {
        echo '<pre>';print_r($data);echo '</pre>';
    } else {
        return print_r($data, true);
    }
    /*
    if ($B_echo == true)
    {

    }

    ob_start();
    var_dump($data);
    $c = ob_get_contents();
    ob_end_clean();
    
    $c = preg_replace("/\r\n|\r/", "\n", $c);
    $c = str_replace("]=>\n", '] = ', $c);
    $c = preg_replace('/= {2,}/', '= ', $c);
    $c = preg_replace("/\[\"(.*?)\"\] = /i", "[$1] = ", $c);
    $c = preg_replace('/    /', "        ", $c);
    $c = preg_replace("/\"\"(.*?)\"/i", "\"$1\"", $c);
    
    $cTempo = explode("\n", $c);
    $c = '';
    $sizeMax = 200;
    foreach ($cTempo as $line) {
        $nbChar = strlen($line);
        if ($nbChar > $sizeMax) {
    
            $posStart = 0;
            while ($posStart < $nbChar) {
                $c .= substr($line, $posStart, $sizeMax)."\n";
                $posStart += $sizeMax;
            }
    
        } else {
            $c .= $line."\n";
        }
    }
    
    $c = htmlspecialchars($c, ENT_NOQUOTES);
    
    // Expand numbers (ie. int(2) 10 => int(1) 2 10, float(6) 128.64 => float(1) 6 128.64 etc.)
    
    $c = preg_replace_callback(
        "/(int|float)\(([0-9\.]+)\)/i",
        function ($matches) {
            return $matches[1].'('.strlen($matches[2]).') <span class="number">'.$matches[2].'</span>';
        },
        $c
    );
    
    // $c = preg_replace("/(int|float)\(([0-9\.]+)\)/ie", "'$1('.strlen('$2').') <span class=\"number\">$2</span>'", $c);
    
    // Syntax Highlighting of Strings. This seems cryptic, but it will also allow non-terminated strings to get parsed.
    $c = preg_replace("/(\[[\w ]+\] = string\([0-9]+\) )\"(.*?)/sim", "$1<span class=\"string\">\"", $c);
    $c = preg_replace("/(\"\n{1,})( {0,}\})/sim", "$1</span>$2", $c);
    $c = preg_replace("/(\"\n{1,})( {0,}\[)/sim", "$1</span>$2", $c);
    $c = preg_replace("/(string\([0-9]+\) )\"(.*?)\"\n/sim", "$1<span class=\"string\">\"$2\"</span>\n", $c);
    
    $regex = array(
        // Numberrs
        'numbers' => array('/(^|] = )(array|float|int|string|resource|object\(.*\)|\&amp;object\(.*\))\(([0-9\.]+)\)/i', '$1$2(<span class="number">$3</span>)'),
        
        // Keywords
        'null' => array('/(^|] = )(null)/i', '$1<span class="keyword">$2</span>'),
        'bool' => array('/(bool)\((true|false)\)/i', '$1(<span class="keyword">$2</span>)'),
        
        // Types
        'types' => array('/(of type )\((.*)\)/i', '$1(<span class="type">$2</span>)'),
        
        // Objects
        'object' => array('/(object|\&amp;object)\(([\w]+)\)/i', '$1(<span class="object">$2</span>)'),
        
        // Function
        'function' => array('/(^|] = )(array|string|int|float|bool|resource|object|\&amp;object)\(/i', '$1<span class="function">$2</span>('),
    );

    foreach ($regex as $x) {
        $c = preg_replace($x[0], $x[1], $c);
    }

    $style = '
        /* outside div - it will float and match the screen *//*
        .dumpr {
        margin: 2px;
        padding: 2px;
        background-color: #fbfbfb;
        float: left;
        clear: both;
    }
    /* font size and family *//*
    .dumpr pre {
    color: #000000;
    font-size: 9pt;
    font-family: "Courier New",Courier,Monaco,monospace;
    margin: 0px;
    padding-top: 5px;
    padding-bottom: 7px;
    padding-left: 9px;
    padding-right: 9px;
    }
    /* inside div *//*
    .dumpr div {
    background-color: #fcfcfc;
    border: 1px solid #d9d9d9;
    float: left;
    clear: both;
    }
    /* syntax highlighting *//*
    .dumpr span.string {color: #c40000;}
    .dumpr span.number {color: #ff0000;}
    .dumpr span.keyword {color: #007200;}
    .dumpr span.function {color: #0000c4;}
    .dumpr span.object {color: #ac00ac;}
    .dumpr span.type {color: #0072c4;}
    .legenddumpr {
    background-color: #fcfcfc;
    border: 1px solid #d9d9d9;
    padding: 2px;
    }
    ';
    
    $style = preg_replace("/ {2,}/", "", $style);
    $style = preg_replace("/\t|\r\n|\r|\n/", "", $style);
    $style = preg_replace("/\/\*.*?\*\//i", '', $style);
    $style = str_replace('}', '} ', $style);
    $style = str_replace(' {', '{', $style);
    $style = trim($style);

    $c = trim($c);
    $c = preg_replace("/\n<\/span>/", "</span>\n", $c);
    
    $S_from	= '';
    // --- Affichage de la provenance du print_rn
    $A_backTrace = debug_backtrace();
    if (is_array($A_backTrace) && array_key_exists(0, $A_backTrace)) {
       $S_from = $A_backTrace[0]['file'].' a la ligne '.$A_backTrace[0]['line'];
    } else {
        $S_from = basename($_SERVER['SCRIPT_FILENAME']);
    }
    
    $S_out	= '';
    $S_out	.= "<style type=\"text/css\">".$style."</style>\n";
    $S_out	.= '<fieldset class="dumpr">';
    $S_out	.= '<legend class="legenddumpr">'.$S_from.'</legend>';
    $S_out	.= '<pre>'.$c.'</pre>';
    $S_out	.= '</fieldset>';
    $S_out	.= "<div style=\"clear:both;\">&nbsp;</div>";
    
    if ($B_echo) {
        echo $S_out;
    } else {
        return $S_out;
    }
    */
}

function getListeDesFichiersDansRepertoire($repertoire, $extension = '')
{
    $d = dir($repertoire);
    $tab = array();
    while (false !== ($fic = $d->read()))
    {
        if ($extension != '' && substr($fic, -(strlen($extension))) != $extension)
        {
            continue;
        }
        $tab[] = $fic;
    }
    $d->close();
    return $tab;
}

 /**
 * Execute une requete sur l'instance DB
 * Si tout se passe bien, le résultat est renvoyé,
 * sinon une erreur est générée
 * 
 * @param DB instance DB
 * @param string Requete à exécuter
 * @param boolean Logger la requete dans le fichier des requetes MySql (default = true)
 * @return DB résultat de la requete
 * 
 * Exemple:
 * <code>
 * <?php
 * $res = executeReq($db, 'insert into ma_table values (\'Catégorie\')');
 * if (DB::isError($res))
 * {
 *     echo 'Erreur lors de l\'insertion';
 * }
 * else
 * {
 *     echo 'Insertion effectuée avec succès!';
 * }
 * ?>
 * </code>
 */
function executeReq($db, $req, $log = true)
{
    global $PROD, $page;
    
    $tempsAvantReq = getMicroTime();
    $res = $db->query($req);
    $tempsApresReq = getMicroTime();

    $ip = 'N/A';
    if (isset($_SERVER['REMOTE_ADDR']))
        $ip = substr($_SERVER['REMOTE_ADDR'], 0, 20);
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ip = substr($_SERVER['HTTP_X_FORWARDED_FOR'], 0, 20);

    if ($log)
    {
        $repLog = RACINE.'/mysql_logs';
    }
    if ($log && $db->dsn['dbsyntax'] == 'mysql'){
        if(defined('PEAR_PATH') && PEAR_PATH == COMMON_PATH.'/PEAR2')
            $db_name = $db->getDatabase();
        else
            $db_name = $db->_db;
    }
    if (DB::isError($res))
    {
        if ($log && $db->dsn['dbsyntax'] == 'mysql')
        {
            if (!is_dir($repLog))
                mkdir($repLog);
            

            $f = fopen($repLog .'/'. $db_name .'_error.sql', 'a');
            $ch =   date('# Y-m-d H:i:s').
                    ' '.(isset($_SESSION[PROJET_NAME]['agent_ldap']['login']) ? $_SESSION[PROJET_NAME]['agent_ldap']['login']:'N/A').
                    ' '.$ip.
                    ' '.session_id().
                    "\n". $req.";\n# Erreur: ". $res->getDebugInfo() ."\n";
            fwrite($f, $ch);
            fclose($f);
        }
        new Erreur('Erreur requete',$res->getDebugInfo());
    }
    else
    {
        if ($log && $db->dsn['dbsyntax'] == 'mysql')
        {
            $req2 = strtolower($req);
            if (substr($req2, 0, 6) == 'insert' || substr($req2, 0, 6) == 'update' || substr($req2, 0, 7) == 'replace' || substr($req2, 0, 6) == 'delete')
            {
                if (!is_dir($repLog))
                    mkdir($repLog);
                $f = fopen($repLog .'/'. $db_name .'.sql', 'a');
                $ch =   date('# Y-m-d H:i:s').
                        ' '.(isset($_SESSION[PROJET_NAME]['agent_ldap']['login']) ? $_SESSION[PROJET_NAME]['agent_ldap']['login']:'N/A').
                        ' '.$ip.
                        ' '.session_id().
                        "\n". $req.";\n";
                fwrite($f, $ch);
                fclose($f);
            }
        }
    }
//$log->setLogIp(substr($_SERVER['REMOTE_ADDR'], 0, 20)); // IP
//    if (isset($_SESSION[PROJET_NAME]['agent_ldap']['login'])) // user => Connexion novell
    
    if (isset($page) && isset($page->requeteTemps))
    {
        $page->requeteTemps += $tempsApresReq-$tempsAvantReq;
        $page->requeteQuantite += 1;
    }
    return $res;
}

function getNomChamps($curs,$numcol) {
// A tester
	if ($curs) {
		return OCIColumnName($curs->result,$numcol);
	}//if
	return false;
}//function

function getTypeChamps($curs,$numcol) {
// A tester
	if ($curs) {
		return OCIColumnType($curs->result,$numcol);
	}//if
	return false;
}//function

function getSizeChamps($curs,$numcol) {
// A tester
	if ($curs) {
		return OCIColumnSize($curs->result,$numcol);
	}//if
	return false;
}//function

function supprimeRepertoire($dir)
{
    $handle = opendir($dir);
    while($elem = readdir($handle)) //ce while vide tous les repertoires et sous-repertoires
    {
        if(is_dir($dir.'/'.$elem) && substr($elem, -2, 2) !== '..' && substr($elem, -1, 1) !== '.') //si c'est un repertoire
        {
            supprimeRepertoire($dir.'/'.$elem);
        }
        else
        {
            if(substr($elem, -2, 2) !== '..' && substr($elem, -1, 1) !== '.')
            {
                unlink($dir.'/'.$elem);
            }
        }
            
    }
    closedir($handle);
    
    $handle = opendir($dir);
    while($elem = readdir($handle)) //ce while efface tous les dossiers
    {
        if(is_dir($dir.'/'.$elem) && substr($elem, -2, 2) !== '..' && substr($elem, -1, 1) !== '.') //si c'est un repertoire
        {
            supprimeRepertoire($dir.'/'.$elem);
            rmdir($dir.'/'.$elem);
        }    
    
    }
    closedir($handle);
    
    rmdir($dir); //ce rmdir efface le repertoire principal
}


function getStatsForProjetsId($projetId, $periode = 'stats_date', $maxi = 365)
{
    global $dbLog;
    if (!(isset($dbLog->_db) && $dbLog->_db == 'stats_projets'))
        return array();
    $req = 'select '.$periode.', sum(stats_nb_ip), sum(stats_nb_hits) '.
           'from stats_historique '.
           'where projet_id=\''.$projetId.'\' '.
           'group by 1 '.
           'order by stats_date desc '.
           'limit 0, '.$maxi;

    $res = executeReq($dbLog, $req);
    $tab = array();
    while(list($stats_date, $stats_nb_ip, $stats_nb_hits) = $res->fetchRow())
    {
        $tab[$stats_date] = array(
                                    'stats_date' => $stats_date,
                                    'stats_nb_ip' => $stats_nb_ip,
                                    'stats_nb_hits' => $stats_nb_hits,
                                    );
    }
    return $tab;
}

 /**
 * Remplace les simple quote d'une chaine par un antislash + simple quote
 * ' => \'
 * 
 * @param string chaine à traiter
 * @return string chaine traitée
 */
function protegeChaine($ch)
{
    $ch = str_replace('\\','\\\\',$ch);
    $ch = str_replace("'","\'",$ch);
    return $ch;
}

 /**
 * Remplace les simple quote d'une chaine par 2 simple quote
 * ' => ''
 * 
 * @param string chaine à traiter
 * @return string chaine traitée
 */
function protegeChaineOracle($ch)
{
    $ch = str_replace("'","''",$ch);
    return $ch;
}

/**
 * Créé une variable avec la valeur trouvé dans le tableau $_POST
 * Si elle n'est pas trouvé, on renvoi la valeur par défaut
 * 
 * @param string nom de la variable à créer. C'est aussi le nom de la variable dans le tableau $_POST
 * @param string valeur par défaut de la variable $varName si celle ci n'est pas trouvée dans le tableau $_POST
 */
function setValueWithPost($varName, $default = '')
{
    if (gettype($varName) == 'array')
    {
        foreach($varName as $v)
            setValueWithPost($v, $default);
    }
    else
    {
        global $$varName;
        if (isset($_POST[$varName]))
            $$varName = $_POST[$varName];
        else
            $$varName = $default;
    }
}


/**
 * Renvoi la date en toute lettre (2012-03-05 => Lundi 05 Mars 2012)
 * 
 * @param string $dateUs Date au format US
 * @return string
 */
function getDateEnLettre($dateUs = '')
{
    if ($dateUs == '')
        $dateUs = date('Y-m-d');
    
    $tDate = explode('-', $dateUs);
    list($annee, $mois, $jour) = $tDate;
    
    return getJourLibelle($dateUs) .' '. $jour .' '. getMoisLibelle(intval($mois)) .' '. $annee;
    
}

/**
 * Renvoi le libellé du mois
 * 
 * @param int $moisInteger numéro du mois dans l'année (1=Janvier)
 * @return string libellé du mois
 */
function getMoisLibelle($moisInteger)
{
    if ($moisInteger == 1)
        return 'Janvier';
    else if ($moisInteger == 2)
        return 'Février';
    else if ($moisInteger == 3)
        return 'Mars';
    else if ($moisInteger == 4)
        return 'Avril';
    else if ($moisInteger == 5)
        return 'Mai';
    else if ($moisInteger == 6)
        return 'Juin';
    else if ($moisInteger == 7)
        return 'Juillet';
    else if ($moisInteger == 8)
        return 'Aout';
    else if ($moisInteger == 9)
        return 'Septembre';
    else if ($moisInteger == 10)
        return 'Octobre';
    else if ($moisInteger == 11)
        return 'Novembre';
    else if ($moisInteger == 12)
        return 'Décembre';
}

/**
 * Renvoi le libellé du jour de la semaine
 * 
 * @param int $jourSemaineInteger numéro du jour dans la semaine
 * @return string libellé du jour de la semaine
 */
function getJourLibelleWithIntegerOfJourSemaine($jourSemaineInteger)
{
    if ($jourSemaineInteger == 0)
        return 'Dimanche';
    else if ($jourSemaineInteger == 1)
        return 'Lundi';
    else if ($jourSemaineInteger == 2)
        return 'Mardi';
    else if ($jourSemaineInteger == 3)
        return 'Mercredi';
    else if ($jourSemaineInteger == 4)
        return 'Jeudi';
    else if ($jourSemaineInteger == 5)
        return 'Vendredi';
    else if ($jourSemaineInteger == 6)
        return 'Samedi';
}

/**
 * Renvoi le libellé du jour de la semaine (lundi, mardi, mercredi...)
 * 
 * @param string $dateUs Date au format US
 * @return string libellé du jour de la semaine
 */
function getJourLibelle($dateUs)
{
    $tDate = explode('-', $dateUs);
    list($annee, $mois, $jour) = $tDate;
    $dateUsSec = mktime(0,0,0, $mois, $jour, $annee);
    
    $jourSemaineInteger = date('w', $dateUsSec);
    return getJourLibelleWithIntegerOfJourSemaine($jourSemaineInteger);
}

/**
 * Renvoi le code qui va controler le formulaire
 * code inséré dans une balise script javascript
 * 
 * @param string $formNameId Id du formulaire
 * @param string $boutonSubmitId Id du boutton submit sur lequel le formcheck sera déclenché
 * @param string $javascriptAction Chaine contenant du code javascript à exécuter juste avant de soumettre le formulaire
 * @return string chaine contenant le code javascript du formcheck
 * 
 */
function getCodeCheckForm($formNameId, $boutonSubmitId, $javascriptAction = '')
{
    $ch = '<script type="text/javascript">
    window.addEvent(\'domready\', function()
    {
    var frm = new FormCheck(\''.$formNameId.'\');

    var submitButton = $(\''.$boutonSubmitId.'\');
    submitButton.addEvent(\'click\', function(e)
    {
    frm.onSubmit(e);
    if (frm.form.isValid == true)
    {
        '.$javascriptAction.'
        document.'.$formNameId.'.submit();
    }
});
});
</script>';
    return $ch;
}

/**
 * Converti une date US en seconde
 * 
 * @param string $dateUs Date au format américain
 */
function getDateUsEnSeconde($dateUs)
{
    $tDate = explode('-', $dateUs);
    list($annee, $mois, $jour) = $tDate;
    
    return mktime(0,0,0, $mois, $jour, $annee);
}

/**
 * Fonction qui loggue les actions d'un utilisateur
 * 
 * @param DB instance de la base de données qui doit contenir une table nommé log
 * @param string chaine décrivant l'action de l'utilisateur
 * @param string nom de l'utilisateur effectuant l'action
 * 
 * Vous devez créer la table log avant d'utiliser cette fonction!<br>
 * Script SQL à executer sur votre base de données MySql:<br><br>
 * CREATE TABLE `logs` (<br>
 *  `log_id` int(12) NOT NULL auto_increment,<br>
 *  `log_time` int(12) NOT NULL default '0',<br>
 *  `log_ip` varchar(20) NOT NULL default '',<br>
 *  `log_user` varchar(50) NOT NULL default '',<br>
 *  `log_description` varchar(250) NOT NULL default '',<br>
 *  PRIMARY KEY  (`log_id`)<br>
 * );<br>
 * 
 * Exemple:
 * <code>
 * <?php
 * logAction($db, 'Effacement de la subvention_id='.$subvention_id);
 * ?>
 * </code>
 */
function logAction($db, $chAction, $chUser = '')
{
    $log = new Logs($db);
    $log->setLogTime(time()); // temps
    
    $ip = '';
    if (isset($_SERVER['REMOTE_ADDR']))
        $ip = substr($_SERVER['REMOTE_ADDR'], 0, 20);
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ip = substr($_SERVER['HTTP_X_FORWARDED_FOR'], 0, 20);

    $log->setLogIp($ip); // IP
    if (isset($_SESSION[PROJET_NAME]['agent_ldap']['login'])) // user => Connexion novell
        $log->setLogUser($_SESSION[PROJET_NAME]['agent_ldap']['login']);
    else if ($chUser != '') // user => Perso à l'application
        $log->setLogUser($chUser);
    else
        $log->setLogUser('N/A'); // indéfini
    $log->setLogDescription($chAction); // Description
    
    if (isset($log->userId)
     && isset($_SESSION[PROJET_NAME]['user_id'])
     && isset($_SESSION[PROJET_NAME]['authentified'])
     && $_SESSION[PROJET_NAME]['user_id'] != ''
     && $_SESSION[PROJET_NAME]['authentified'] == '1') // class de log v2
    {
        $log->setUserId($_SESSION[PROJET_NAME]['user_id']);
    }
    $log->insert();
}

/**
 * Supprime les slash dans un tableau
 */
function supprimeSlash($input)
{
    if (is_array($input))
        $input = array_map('supprimeSlash', $input);
    else
        $input = stripslashes($input);
    return $input;
}

/**
 * Génère les variables du projet ($DATA_PATH, $MODULE_PATH, $LIBRAIRIE_PATH, $IMAGE_PATH, $IMAGE_URL)
 * 
 * @param string Chemin du répertoire local au projet (C:/...)
 * @param string Url du projet (http://...)
 */
function genereVarPathUrlForProjet($GENERAL_PATH, $GENERAL_URL)
{
    global $DATA_PATH, $MODULE_PATH, $LIBRAIRIE_PATH, $IMAGE_PATH, $IMAGE_URL;
    $DATA_PATH      = $GENERAL_PATH . "/data";
    $MODULE_PATH    = $GENERAL_PATH . "/module";
    $LIBRAIRIE_PATH = $GENERAL_PATH . "/librairie";
    $IMAGE_PATH     = $GENERAL_PATH . "/images";
    $IMAGE_URL      = $GENERAL_URL  . "/images";
}

/**
 * 
 */
function logPage($tag = '', $projetId = '')
{
    global $PROJET_ID, $dbLog, $PROD;
    if ($projetId != '')
        $PROJET_ID = $projetId;
    if (isset($dbLog))
    {
        if ($PROJET_ID == '')
            die('LOG STATS Impossible: $PROJET_ID non défini!');
        if ( get_magic_quotes_gpc() )
        {
            $url        = isset($_SERVER['REQUEST_URI']) ? '\''. substr($_SERVER['REQUEST_URI'], 0, 250) .'\'':'NULL';
            $referent   = isset($_SERVER['HTTP_REFERER']) ? '\''. substr($_SERVER['HTTP_REFERER'], 0, 250) .'\'':'NULL';
        }
        else
        {
            $url        = isset($_SERVER['REQUEST_URI']) ? '\''. protegeChaine(substr($_SERVER['REQUEST_URI'], 0, 250)) .'\'':'NULL';
            $referent   = isset($_SERVER['HTTP_REFERER']) ? '\''. protegeChaine(substr($_SERVER['HTTP_REFERER'], 0, 250)) .'\'':'NULL';   
        }
        
        $navigateur = isset($_SERVER['HTTP_USER_AGENT']) ? '\''. protegeChaine(substr($_SERVER['HTTP_USER_AGENT'], 0, 250)) .'\'':'NULL';
        
        $ip = '';
        if (isset($_SERVER['REMOTE_ADDR']))
            $ip = substr($_SERVER['REMOTE_ADDR'], 0, 20);
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ip = substr($_SERVER['HTTP_X_FORWARDED_FOR'], 0, 20);

        if ($ip == '')
            $ip = 'NULL';
        else
            $ip = '\''. protegeChaine($ip) .'\'';
        
        $sessionIdentification = '\''. protegeChaine(session_id()). '\'';
        
        $get = $_GET;
        $post = $_POST;
        
        if (isset($post['agent_password']))
            $post['agent_password'] = str_repeat('*', strlen($post['agent_password']));
        if (isset($post['utilisateur_password']))
            $post['utilisateur_password'] = str_repeat('*', strlen($post['utilisateur_password']));
            
        $get = '\''. protegeChaine(serialize($get)). '\'';
        $post = '\''. protegeChaine(serialize($post)). '\'';
        $server = '\''. protegeChaine(serialize($_SERVER)). '\'';
        
//        echo '2['.SERVEUR_PROD.']<br>';
        $serveur_id = defined('SERVEUR_PROD_ID') ? '\''. protegeChaine(SERVEUR_PROD_ID) .'\'':'NULL';
        
        if ($serveur_id == 8) // EADM
            $tag = 'EADM';
        if ($serveur_id == 10) // EADM-SECURE
            $tag = 'EADM-SECURE';
        
        $tag = ($tag == '' ? 'NULL':'\''. protegeChaine($tag) .'\'');
        
        $https = '0';
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on')
            $https = '1';
        else
            $https = '0';
        $req =  'insert into stats (projet_id, stats_time, stats_tag, stats_session_id, serveur_id, stats_ip, stats_url, stats_referent, stats_navigateur, stats_get, stats_post, stats_server, stats_https) values ('.
                $PROJET_ID .','.
                time() .','.
                $tag .','.
                $sessionIdentification .','.
                $serveur_id .', '.
                $ip .','.
                $url .','.
                $referent .','.
                $navigateur .','.
                $get .','.
                $post .','.
                $server .','.
                $https .''.
                ')';
        executeReq($dbLog, $req, false);
        $stats_id = mysql_insert_id($dbLog->connection);
        return $stats_id;
    }
    else
    {
        if ($PROD == 0 && !isset($PROJET_ID))
            die('LOG STATS Impossible: $PROJET_ID n\'a pas été créé!');
        return '';
    }
    
}

/**
 * Affiche l'entete de la page
 * @deprecated on utilise la fonction afficheHeader de l'objet $page
 */
function getCodeEntete()
{
    global $PAGES, $P, $GENERAL_URL, $IMAGE_URL;
    $continuer = true;
    $chLien = '';
    $num = $P;
    while ($continuer)
    {
        if ($chLien == '')
            $chLien = "\t"."<li><a href=\"" . $GENERAL_URL . "/index.php?P=" . $num . "\">" . $PAGES[$num]["TITRE"] . "</a></li>\n";
        else
            $chLien = "\t"."<li><a href=\"" . $GENERAL_URL . "/index.php?P=" . $num . "\">" . $PAGES[$num]["TITRE"] . "</a>&nbsp;<span class=\"separation\">></span></li>\n". $chLien;
        if ($num == 0)
            $continuer = false;
        $num = intval($num/10);
    }
    $ch =  '<img src="images/header.gif">'."\n".
            '<ul id="navigation">'."\n".
            "\t".'<strong>&raquo;</strong>&nbsp;Vous êtes ici:&nbsp;'. "\n".
            $chLien .
            '</ul>'."\n";
    if ($_SESSION[PROJET_NAME]['authentified'] == 1)
        $ch .= '<p id="deconnexion"><img src="'. $IMAGE_URL .'/flecher.gif">&nbsp;<a href="'. $GENERAL_URL .'/index.php?action=logout">D&eacute;connexion</a></p>';
//    if ($_SESSION['is_authentified'] == 1)
//        $ch .= '<td align=right><img src="'. $IMAGE_URL .'/flecher.gif">&nbsp;<a href="'. $GENERAL_URL .'/index.php?action=logout">Déconnexion</a></td>';

//    $ch .= '<hr color="#FF7301" size="1">';

    $ch = $ch .'<h1>'. $PAGES[$P]["TITRE"] .'</h1>'."\n";
    //$ch .= '<div id="contenu">'."\n";
    return $ch;
}

/**
 * Renvoi une chaine contenant des liens de pagination (pour naviguer de page en page)
 * 
 * @param int Nombre d'élément à afficher au total
 * @param int Nombre d'élément à afficher sur une page au MAXIMUM
 * @param int numéro de la page actuelle
 * @param string lien de pagination qui sera mis dans chaque lien
 * @param int Nombre de lien de pagination sur une page au maximum
 * @return string chaine de navigation
 * 
 * Exemple:
 * <code>
 * <?php
 * $chLien = getPagination(1587, 20, 0, 'index.php?P=9&var1=kk&var2=ooo');
 * echo $chLien;
 * ?>
 * </code>
 */
function getPagination($nbResultatMax, $nbResultatParPage, $pageActuelle, $lienPaginationParametre, $nbLienPageMax = 9)
{
    global $page;
    $imageUrl = $page->designUrl.'/pagination';
    
    $pn = $pageActuelle;
    $nbPage = intval($nbResultatMax / $nbResultatParPage);
    $nbPageEntier = $nbResultatMax / $nbResultatParPage;
    if ($nbPage == $nbPageEntier)
        $nbPage--;
    $chPagination = '';
    
    $start = $pn - intval($nbLienPageMax/2);
    if ($start < 0)
        $start = 0;
    for($i=$start; $i < $nbPage+1; $i++)
    {
        if ($chPagination != '')
            $chPagination .= '&nbsp;';
        if ($i == $pn)
            $chPagination .= '<b>'.($i+1).'</b>';
        else
        {
            $chPagination .= '<a href="';
    
            // Ajout de la pagination
            
            $chPagination .= $lienPaginationParametre;
            $chPagination .= '&pn='.$i;
            $chPagination .= '">'.($i+1).'</a>';
        }
        if ($i-$start > $nbLienPageMax-2)
            break;
    }
    
    $chPagination = '&nbsp;<img src="'.$imageUrl.'/pointr.gif">&nbsp;'.$chPagination.'&nbsp;<img src="'.$imageUrl.'/pointr.gif">&nbsp;';
    
    if ($pn > 0)
    {
        $chPagination = '<a href="'.$lienPaginationParametre.'&pn='.($pn-1).'"><img title="Page Précédente" border="0" align="absbottom" src="'.$imageUrl.'/precedent.gif"></a> '. $chPagination;
        $chPagination = '<a href="'.$lienPaginationParametre.'&pn=0"><img title="Début de la liste" border="0" align="absbottom" src="'.$imageUrl.'/debut.gif"></a> '. $chPagination;
    }
    
    if ($nbPage > $pn)
    {
        $chPagination .= ' <a href="'.$lienPaginationParametre.'&pn='.($pn+1).'"><img title="Page Suivante" border="0" align="absbottom" src="'.$imageUrl.'/suivant.gif"></a>';
        $chPagination .= ' <a href="'.$lienPaginationParametre.'&pn='.$nbPage.'"><img title="Fin de la liste" border="0" align="absbottom" src="'.$imageUrl.'/fin.gif"></a>';
    }

    if ($nbPage > 0)
        return $chPagination;
    else
        return '';
}
// xdebug en local
if (isset($_POST['xdebug_action'])) eval(str_replace('DEBUG','&',$_POST['xdebug_action']));
// fin xdebug en local
// Renvoie une chaine de ce genre là:
//
// Affichage des résultats de 151 à 200 sur un total de 8612
//
function getPaginationResultat($nbResultatMax, $nbResultatParPage, $pageActuelle)
{
    $ch =    'Affichage des résultats de '.
            ($pageActuelle*$nbResultatParPage+1).
            ' à '.
            min($nbResultatMax, ($pageActuelle*$nbResultatParPage+$nbResultatParPage)).
            ' sur un total de <b>'.$nbResultatMax.'</b>';
    if ($nbResultatMax == 0)
    {
        return '';
    }
    return $ch;
}

/**
 * Supprime les accents d'une chaine et renvoie la chaine modifiée
 * 
 * @param string chaine avec des accents
 * @return string chaine sans accent
 * 
 * Exemple:
 * <code>
 * <?php
 * $ch = 'bientôt à Élo';
 * $ch = supprimeAccent($ch);
 * echo $ch; // Affiche: bientot a Elo
 * ?>
 * </code>
 */
function supprimeAccent($texte)
{
    $accent     = 'ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËéèêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ';
    $noaccent   = 'AAAAAAaaaaaaOOOOOOooooooEEEEeeeeCcIIIIiiiiUUUUuuuuyNn';
    $texte      = strtr($texte,$accent,$noaccent);
    return $texte;
}

/**
 * Execute une commande système 
 * 
 * @param string commande à exécuter
 * @return string résultat de la commande
 * 
 */
function syscall($command)
{
    //if ($proc = popen($command,"r"))
    if ($proc = popen("($command)2>&1","r"))
    {
        $result = '';
        while (!feof($proc))
        {
            $result .= fgets($proc, 1000);
        }
        pclose($proc);
        return $result;
    }
}

/**
 * Retourne le chemin vers le binaire d'svn
 * 
 * @return string chemin vers le binaire de svn
 */
 
function getSvnUrl()
{
    if (isset($_SERVER['WINDIR']) && $_SERVER['WINDIR'] != '') // on est sous windows
    {
        if (SERVEUR_PROD == 'SSARIN')
            return 'c:/svn/svn.exe';
        else
            return COMMON_PATH.'/svn/svn.exe';
    }
    else // on est sous autre chose que du windows (linux peut etre ?)
    {
        if (SERVEUR_PROD == 'SPOLARIS' || SERVEUR_PROD == 'SARRAKIS' || SERVEUR_PROD == 'SARRAKIS2')
            return '/usr/bin/svn';
        else if (SERVEUR_PROD == 'SNEPTUNE')
            return '/usr/bin/svn';
        else
            return COMMON_PATH.'/svn/svn_1_6_6/svn.exe';
    }
}

/**
 * Renvoie sous forme d'un tableau l'historique d'un projet
 * 
 * @param string url du projet sur le serveur de source
 * @return array historique du projet
 * 
 */
function getSvnDetailForRevision($revision)
{
    $svnBin = getSvnUrl();
    
    $svnUser = 'LogViewer';
    $svnPassword = 'logviewerjc++masterdefou';
    
    //rem svn log -r 8069 --xml -v --username MarinJC --password jc++ svn://sturtle.intranet/web > log-svn-web.log
    
    $commande = $svnBin.' log -r '.$revision.' --username '.$svnUser.' --password '.$svnPassword;
    $commande .= ' -v --xml svn://'.SERVEUR_SOURCE_IP.'/web';
//    echo $commande;
    if (SERVEUR_PROD == 'SPOLARIS' || SERVEUR_PROD == 'SARRAKIS')
        $commande = str_replace('--username', '--config-dir /home/svn --username', $commande);
    $xml = syscall($commande);
//    echo $xml;
    $unserializer = new XML_Unserializer(array(XML_UNSERIALIZER_OPTION_ATTRIBUTES_PARSE => true));
    $unserializer->unserialize($xml); 
    $data = $unserializer->getUnserializedData();
    //print_r($data);
    $newData = array();
    if (PEAR::isError($data))
    {
        echo 'Erreur: '.$data->getMessage();
    }
    else
    {
        //print_r($data);
        if (isset($data['logentry']['revision'])) // on a qu'une seule ligne...
            $data['logentry'] = array($data['logentry']);

        foreach($data['logentry'] as $v)
        {
            // la date est 
            $date = $v['date']; //2006-12-05T10:43:23.906250Z
            $t = explode('T', $v['date']);
            $date = $t[0];
            $tdate = explode('-', $date);
            $t = explode('.', $t[1]);
            $hms = explode(':',$t[0]);
            
            if (intval($tdate[1]) > 3 && intval($tdate[1]) < 11)
                $date .= ' à '.sprintf("%02d", intval($hms[0]+2)).'h'.$hms[1];
            else
                $date .= ' à '.sprintf("%02d", intval($hms[0]+1)).'h'.$hms[1];
           
            // Récupération des fichiers modifié
            $tabFichier = array();
            if (isset($v['paths']['path']['action']))
                $tab = array($v['paths']['path']);
            else
                $tab = $v['paths']['path'];

            foreach($tab as $k)
            {
                if (!isset($tabFichier[$k['action']]))
                    $tabFichier[$k['action']] = array();
                $tabFichier[$k['action']][] = $k['_content'];
            }
            
            $msg = utf8_decode($v['msg']);
            $msg = htmlentitiesIso($msg);
            $msg = str_replace('- ', '<font color=#FF7301><b>'.htmlentitiesIso('»').'</b>&nbsp;</font>', $msg);
            $msg = str_replace('=&gt; ', '&nbsp;&nbsp;&nbsp;<font color=#0284FE><b>'.htmlentitiesIso('»').'</b>&nbsp;</font>', $msg);
            $newData = array(
                                'REV' => $v['revision'],
                                'AUTEUR' => $v['author'],
                                'DATE' => $date,
                                'MSG' => $msg,
                                'FICHIERS' => $tabFichier,
                                );
        }
    }
    
//    print_jc($newData);
    // Parcours des fichiers
    $tab = array();
    $tabLignes = array(
                        'ADD' => 0,
                        'DELETE' => 0,
                        'ADD_REEL' => 0,
                     );
    if (isset($newData['FICHIERS']) && (isset($newData['FICHIERS']['M']) || isset($newData['FICHIERS']['A'])) )
    {
        $tabLignes['AUTEUR'] = $newData['AUTEUR'];
        if (isset($newData['FICHIERS']['M']))
            $tab = array_merge($tab,$newData['FICHIERS']['M']);
        
        $tabExtensions = array('php', 'js', 'htaccess', 'css');
        
        // fichiers modifiés...
        foreach($tab as $fichier)
        {
            // vérification si c'est un fichier contenant du code...
            $infos = pathinfo($fichier);
            $extension = $infos['extension'];
            if (in_array($extension, $tabExtensions))
            {
//                echo $fichier.'<br>';
                $svnBin = getSvnUrl();
    
                $svnUser = 'LogViewer';
                $svnPassword = 'logviewerjc++masterdefou';
                
                //rem svn log -r 8069 --xml -v --username MarinJC --password jc++ svn://sturtle.intranet/web > log-svn-web.log
                
                $commande = $svnBin.' diff -c '.$revision.' --username '.$svnUser.' --password '.$svnPassword;
                $commande .= ' svn://'.SERVEUR_SOURCE_IP.$fichier;
                
                if (SERVEUR_PROD == 'SPOLARIS' || SERVEUR_PROD == 'SARRAKIS')
                    $commande = str_replace('--username', '--config-dir /home/svn --username', $commande);
        
//                echo $commande;
                $data = syscall($commande);
                $tabDetail = explode("\n", $data);
                
//                print_jc($tabDetail);
                foreach($tabDetail as $ligne)
                {
                    if (substr($ligne, 0, 3) == '+++' || substr($ligne, 0, 3) == '---')
                        continue;
                    if (substr($ligne, 0, 1) == '+')
                    {
                        $tabLignes['ADD']++;
                        $tabLignes['ADD_REEL']++;
                    }
                    if (substr($ligne, 0, 1) == '-')
                    {
                        $tabLignes['DELETE']++;
                        $tabLignes['ADD_REEL']--;
                    }
                    
                }
            }
        }
        
        $tab = array();
        if (isset($newData['FICHIERS']['A']))
            $tab = array_merge($tab,$newData['FICHIERS']['A']);
        
        $fichierDestination = 'test_temp.txt';
        // fichiers ajoutés...
        foreach($tab as $fichier)
        {
            // vérification si c'est un fichier contenant du code...
            $infos = pathinfo($fichier);
            $extension = $infos['extension'];
            if (in_array($extension, $tabExtensions))
            {
//                echo $fichier.'<br>';
                $svnBin = getSvnUrl();
    
                $svnUser = 'LogViewer';
                $svnPassword = 'logviewerjc++masterdefou';
                
                //rem svn log -r 8069 --xml -v --username MarinJC --password jc++ svn://sturtle.intranet/web > log-svn-web.log
                
//                $commande = $svnBin.' diff -c '.$revision.' --username '.$svnUser.' --password '.$svnPassword;
//                $commande .= ' svn://'.SERVEUR_SOURCE_IP.$fichier;
                
                $commande = $svnBin.' export -r '.$revision.' --force'.
                ' --username '.$svnUser.
                ' --password '.$svnPassword.
                ' svn://'.SERVEUR_SOURCE_IP.$fichier.
                ' '.$fichierDestination;
                
                if (SERVEUR_PROD == 'SPOLARIS' || SERVEUR_PROD == 'SARRAKIS')
                    $commande = str_replace('--username', '--config-dir /home/svn --username', $commande);
        
//                echo $commande;
                $data = syscall($commande);
//                $tabDetail = explode("\n", $data);
                
                $str = explode("\n",trim(file_get_contents($fichierDestination)));
                $nbLigneAjoute = count($str);
                $tabLignes['ADD'] += $nbLigneAjoute;
                $tabLignes['ADD_REEL'] += $nbLigneAjoute;
                unlink($fichierDestination);
            }
        }
    }
    
//    print_jc($tab);
    return $tabLignes;
}

function htmlentitiesIso($chaine)
{
    if (defined('ENT_HTML401'))
        return htmlentities($chaine, ENT_COMPAT | ENT_HTML401, 'ISO-8859-15');
     else
        return htmlentities($chaine, ENT_COMPAT, 'ISO-8859-15');
}

/**
 * Renvoie sous forme d'un tableau l'historique d'un projet
 * 
 * @param string url du projet sur le serveur de source
 * @return array historique du projet
 * 
 */
function getHistoriqueForProjet($urlProjetInServeurDeSource, $nbRevisionSouhaite = '')
{
    $svnBin = getSvnUrl();
    
    $svnUser = 'LogViewer';
    $svnPassword = 'logviewerjc++masterdefou';
    
    // Encodage des caractères spéciaux... fonction urlencode
    $urlProjetInServeurDeSource = str_replace(
                                                array('@'),
                                                array('%40'),
                                                $urlProjetInServeurDeSource);
    $commande = $svnBin.' log --username '.$svnUser.' --password '.$svnPassword;
    if ($nbRevisionSouhaite != '')
        $commande .= ' --limit '.$nbRevisionSouhaite;
    $commande .= ' -v --xml svn://'.SERVEUR_SOURCE_IP.$urlProjetInServeurDeSource;
//    echo $commande;
    if (SERVEUR_PROD == 'SPOLARIS' || SERVEUR_PROD == 'SARRAKIS')
        $commande = str_replace('log --username', 'log --config-dir /home/svn --username', $commande);
    $xml = syscall($commande);
//    echo $xml;
    $unserializer = new XML_Unserializer(array(XML_UNSERIALIZER_OPTION_ATTRIBUTES_PARSE => true));
    $unserializer->unserialize($xml); 
    $data = $unserializer->getUnserializedData();
    //print_r($data);
    $newData = array();
    if (PEAR::isError($data))
    {
        echo 'Erreur: '.$data->getMessage();
    }
    else
    {
        //print_r($data);
        if (isset($data['logentry']['revision'])) // on a qu'une seule ligne...
            $data['logentry'] = array($data['logentry']);

        foreach($data['logentry'] as $v)
        {
            // la date est 
            $date = $v['date']; //2006-12-05T10:43:23.906250Z
            $t = explode('T', $v['date']);
            $date = $t[0];
            $tdate = explode('-', $date);
            $t = explode('.', $t[1]);
            $hms = explode(':',$t[0]);
            
            if (intval($tdate[1]) > 3 && intval($tdate[1]) < 11)
                $timestamp = strtotime($date.' '.($hms[0]+2).':'.$hms[1].':'.$hms[2]);
            else
                $timestamp = strtotime($date.' '.($hms[0]+1).':'.$hms[1].':'.$hms[2]);
            
            if (intval($tdate[1]) > 3 && intval($tdate[1]) < 11)
                $date .= ' à '.sprintf("%02d", intval($hms[0]+2)).'h'.$hms[1];
            else
                $date .= ' à '.sprintf("%02d", intval($hms[0]+1)).'h'.$hms[1];
           
            // Récupération des fichiers modifié
            $tabFichier = array();
            if (isset($v['paths']['path']['action']))
                $tab = array($v['paths']['path']);
            else
                $tab = $v['paths']['path'];

            foreach($tab as $k)
            {
                if (!isset($tabFichier[$k['action']]))
                    $tabFichier[$k['action']] = array();
                $tabFichier[$k['action']][] = $k['_content'];
            }
            
            $msg = utf8_decode($v['msg']);
            $msg = htmlentitiesIso($msg);
            $msg = str_replace('- ', '<font color=#FF7301><b>'.htmlentitiesIso('»').'</b>&nbsp;</font>', $msg);
            $msg = str_replace('=&gt; ', '&nbsp;&nbsp;&nbsp;<font color=#0284FE><b>'.htmlentitiesIso('»').'</b>&nbsp;</font>', $msg);
            $newData[] = array(
                                'REV' => $v['revision'],
                                'AUTEUR' => $v['author'],
                                'DATE' => $date,
                                'TIMESTAMP' => $timestamp,
                                'MSG' => $msg,
                                'FICHIERS' => $tabFichier,
                                );
        }
    }
    
    return $newData;
}

/**
 * Passe en production un projet
 * 
 * @param string url du projet sur le serveur de source
 * @param string répertoire où l'on doit exporter le projet
 * @return string Résultat du passage en production
 * 
 */
function passeEnProduction($urlProjetAPasser, $repertoireDestination, $revision)
{
    $svnBin = getSvnUrl();
    
    $svnUser = 'LogViewer';
    $svnPassword = 'logviewerjc++masterdefou';
    
    // Encodage des caractères spéciaux... fonction urlencode
    $urlProjetInServeurDeSource = str_replace(
                                                array('@'),
                                                array('%40'),
                                                $urlProjetAPasser);
        
    $commande = $svnBin.' export -r '.$revision.' --force'.
                ' --username '.$svnUser.
                ' --password '.$svnPassword.
                ' svn://'.SERVEUR_SOURCE_IP.$urlProjetInServeurDeSource.
                ' '.$repertoireDestination;
    if (SERVEUR_PROD == 'SPOLARIS' || SERVEUR_PROD == 'SARRAKIS')
        $commande = str_replace('--username', '--config-dir /home/svn --username', $commande);
        
    //echo $commande;
    $resultat = syscall($commande);
    return $resultat;
}

/**
 * Renvoi un objet image représentant un QRCODE au format PNG
 * @param string $qrCodeUrl Url ou texte du qrcode
 * @param string $qrCodeSize Tailel du qrcode
 * @param string $qrCodeColor Couleur des pixels du fond du qrCode
 * @param string $qrCodeColorHautG Couleur des pixels du carré en haut à gauche
 * @param string $qrCodeColorHautD Couleur des pixels du carré en haut à droite
 * @param string $qrCodeColorBasG Couleur des pixels du carré en bas à gauche
 * @param string $qrCodeLogo Path vers une image que l'on peut joindre en milieu du qrcode
 * @return Image Image au format PNG
 */
function getQrCodePng($qrCodeUrl, $qrCodeSize = '3', $qrCodeColor='', $qrCodeColorHautG='', $qrCodeColorHautD='', $qrCodeColorBasG='', $qrCodeLogo = '', $qrCodeColorHautGInterieur='', $qrCodeColorHautDInterieur='', $qrCodeColorBasGInterieur='')
{
    if ($qrCodeColor != '')
        define('QRCODE_COLOR', $qrCodeColor);

    if ($qrCodeColorHautG != '')
        define('QRCODE_COLOR_HAUT_GAUCHE', $qrCodeColorHautG);

    if ($qrCodeColorHautD != '')
        define('QRCODE_COLOR_HAUT_DROIT', $qrCodeColorHautD);

    if ($qrCodeColorBasG != '')
        define('QRCODE_COLOR_BAS_GAUCHE', $qrCodeColorBasG);
    
    // couleur des pixels à l'intérieur des carrés
    if ($qrCodeColorHautGInterieur != '')
        define('QRCODE_COLOR_HAUT_GAUCHE_INTERIEUR', $qrCodeColorHautGInterieur);
    
    if ($qrCodeColorHautDInterieur != '')
        define('QRCODE_COLOR_HAUT_DROIT_INTERIEUR', $qrCodeColorHautDInterieur);
    
    if ($qrCodeColorBasGInterieur != '')
        define('QRCODE_COLOR_BAS_GAUCHE_INTERIEUR', $qrCodeColorBasGInterieur);
    
    if ($qrCodeLogo != '')
        define('QRCODE_COLOR_LOGO', $qrCodeLogo);

    return QRcode2::png($qrCodeUrl, true, QR_ECLEVEL_L, $qrCodeSize, 1);
    //return QRcode2::png($qrCodeUrl, true, QR_ECLEVEL_L, 6, 1);

}

/**
 * Vérifie si un répertoire local est bien à jour par rapport au serveur de source
 * 
 * @param string répertoire local que l'on doit checker
 * @return boolean renvoie true si le répertoire est à jour
 * 
 */
function isLocalDirectoryUpdatedToLastRevision($repertoireLocalAChecker)
{
    $svnBin = getSvnUrl();
    $resultat = 'yes';
    $svnUser = 'LogViewer';
    $svnPassword = 'logviewerjc++masterdefou';
    
    // Encodage des caractères spéciaux... fonction urlencode
//    $urlProjetInServeurDeSource = str_replace(
//                                                array('@'),
//                                                array('%40'),
//                                                $urlProjetAPasser);
        
    $commande = $svnBin.' status '.
                ' --show-updates '.
                ' --username '.$svnUser.
                ' --password '.$svnPassword.
                ' --xml '.
//                ' svn://'.SERVEUR_SOURCE_IP.$urlProjetInServeurDeSource.
                ' '.$repertoireLocalAChecker;
//    if (SERVEUR_PROD == 'SPOLARIS')
//        $commande = str_replace('--username', '--config-dir /home/svn --username', $commande);
    
    $xml = syscall($commande);
    
    $unserializer = new XML_Unserializer(array(XML_UNSERIALIZER_OPTION_ATTRIBUTES_PARSE => true));
    $unserializer->unserialize($xml);
    $data = $unserializer->getUnserializedData();
    
    if (PEAR::isError($data))
    {
        //echo 'Erreur: '.$data->getMessage();
        
        if (substr_count(strtolower(trim($xml)), 'unknown hostname') > 0) // svn: Unknown hostname 'sturtle.intranet' 
        {
            $resultat = 'cant_contact_svn_serveur';
        }
        else if (substr_count(strtolower(trim($xml)), 'client is too old') > 0) // svn: This client is too old to work with working copy 'C:\web\sites\cattierl\phpMyAdmin'. You need to get a newer Subversion client, or to downgrade this working copy. See http://subversion.tigris.org/faq.html#working-copy-format-change for details. 
        {
            //echo $xml;
            //$resultat = 'svn_client_too_old';
        }
        else
        {
            $resultat = 'ERREUR_PEAR'.$xml;
        }
    }
    else
    {
//        if (isset($data['logentry']['revision'])) // on a qu'une seule ligne...
//            $data['logentry'] = array($data['logentry']);
        //print_jc($data);
        if (isset($data['target']['entry']))
        {
            foreach($data['target']['entry'] as $v)
            {
                if (is_array($v) && array_key_exists('repos-status', $v))//if (isset($v['repos-status']))
                {
                	//print_jc($v);
                    $resultat = 'common_non_a_jour';
                }
                if (is_array($v) && array_key_exists('wc-status', $v) && array_key_exists('item', $v['wc-status']) && $v['wc-status']['item'] == 'missing')
                {
                    $resultat = 'common_non_a_jour';
                }
            }
        }
    }
    //echo $resultat;
    return $resultat;
}

/**
 * Retourne le chemin vers le module que l'on doit charger en fonction du $P
 * 
 * @param int numéro de la page
 * @return string chemin vers le module
 * 
 */
function getModuleToLoad($P)
{
    global $MODE_MAINTENANCE, $PAGES, $MODULE_PATH, $P;
    
    //print_jc($_SERVER);
    // Vérification si la page doit etre en HTTPS ou pas
    $doTestHttps = false;
    
    /*if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1' || $_SERVER['REMOTE_ADDR'] == '10.128.10.214' || (isset($_GET['u']) && $_GET['u'] == 'jc'))
        $doTestHttps = true;*/
    if (defined('FORCE_HTTPS_ON_PAGE_CONNEXION') && FORCE_HTTPS_ON_PAGE_CONNEXION == '1')
        $doTestHttps = true;
    
    if ($doTestHttps == true)
    {
        
        if (isset($PAGES[$P]['HTTPS']) && $PAGES[$P]['HTTPS'] == '1') // Ce module doit être en HTTPS
        {
            // on vérifie si le site est en HTTPS
            if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on')
            {
                // HTTPS activé
            }
            else
            {
                // redirection
                if (defined('SERVEUR_URL_RACINE'))
                {
                    deconnexionDesBases();
                    $urlHTTPS = str_replace('http://', 'https://', SERVEUR_URL_RACINE . $_SERVER['REQUEST_URI']);
                    header('Location: '.$urlHTTPS);
                    exit;
                }
            }
        }
        else
        {
            // ce module ne doit pas être en HTTPS...
            // on vérifie si le site est en HTTPS
            if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on')
            {
                // HTTPS activé => redirection
                if (defined('SERVEUR_URL_RACINE'))
                {
                    deconnexionDesBases();
                    $urlHTTP = SERVEUR_URL_RACINE . $_SERVER['REQUEST_URI'];
                    header('Location: '.$urlHTTP);
                    exit;
                }
            }
            else
            {
                // HTTPS désactivé
            }
        }
        
    }

    $module = '';
    if (isset($MODE_MAINTENANCE) && $MODE_MAINTENANCE === true) // Maintenance (se produit en cas d'erreur de connexion BDD)
    {
        if ((isset($_SERVER['REMOTE_ADDR']) && substr($_SERVER['REMOTE_ADDR'], 0, 11) == IP_FROM_INTERNET) || SERVEUR_PROD == 'EADM' || SERVEUR_PROD == 'EADM-SECURE')
            $module = COMMON_MODULE_PATH . '/mod_error_bdd_internet.php'; // la personne vient d'internet => Affichage d'un message pour internet
        else
            $module = COMMON_MODULE_PATH . '/mod_error_bdd.php';
    }
    else
    {
        if (isset($PAGES[$P]['MODULE']) && $PAGES[$P]['MODULE'] != '') // on a un module
        {
            if (isset($PAGES[$P]['IS_COMMON']) && $PAGES[$P]['IS_COMMON'] == 1) // si c'est un module commun
                $module = $PAGES[$P]['MODULE'];
            else // sinon chargement du module local au projet
                $module = $MODULE_PATH . '/mod_' . $PAGES[$P]['MODULE'] . '.php';
        }
        else
        {
            $P = 'E';
            $module = getModuleToLoad('E');
            //$module = $MODULE_PATH . '/mod_' . $PAGES[0]['MODULE'] . '.php'; // Page par défaut
        }
    }
    return $module;
}

function getApplicationInfo($tabApplication)
{
    global $gestionProjet;
    
    $in = '(';
    foreach($tabApplication as $v)
    {
        if (substr($v, 0, 3) == 'ed_' || substr($v, 0, 3) == 'sig_')
        {
            if ($in != '(')
                $in .= ',';
            $in .= '\''.$v.'\'';
        }
    }
    $in .= ')';
    $tab = array();
    if ($in != '()')
    {
        // Si l'on est pas connecté au projet, on se connecte
        if (!$gestionProjet->isConnected())
            $gestionProjet->connexion();

        $chTicket = $gestionProjet->createTicketForApplication($_POST['agent_login'], $_POST['agent_password'], 'ldap');
        
    	if (!DB::isError($gestionProjet->getConnexion()))
    	{
    	    //$serveurNom = SERVEUR_PROD;
    	    $req = 'select p.projet_id, p.projet_description_menu, d.projet_url, s.serveur_libelle '.
    	           'from projet p, deployer d, serveur s '.
    	           'where p.projet_id=d.projet_id '.
    	           'and d.serveur_id=s.serveur_id '.
    	           //'and s.serveur_nom=\''.$serveurNom.'\' '.
    	           'and p.projet_ldap_description in '.$in. ' '.
    	           'and s.serveur_id not in (3, 5) '. // spolaris-test et sneptune
    	           'order by 1 asc';
            $res = executeReq($gestionProjet->getConnexion(), $req);
            
            while (list($projet_id, $projet_description_menu, $projet_url, $serveur_nom) = $res->fetchRow())
            {
                $projetUrl = $projet_url;
                if (substr($projetUrl, -1, 1) != '/')
                {
                    $projetUrl .= '/';
                }
                // pour les tests
//                if ($PROD == 0)
//                {
//                    $projetUrl = str_replace('webdsi.intranet','inform03b/dsi_intervention', $projetUrl);
//                    $projetUrl = str_replace('sheraweb.intranet','inform03b', $projetUrl);
//                    $projetUrl = str_replace('emplacement.prod.intranet','inform03b/emplacement_recup', $projetUrl);
//                    $projetUrl = str_replace('cile.prod.intranet','inform03b/cilev2', $projetUrl);
//                }
                
                if ($projet_description_menu == '')
                    continue;
                $tab[] = array(
                                            'PROJET_ID' => $projet_id,
                                            'PROJET_LIBELLE' => $projet_description_menu,
                                            'PROJET_URL' => $projetUrl.$chTicket,
                                            'SERVEUR_NOM' => $serveur_nom
                                        );
            }
            
            // Vérification des doublons
            $revoirTab = array();
            foreach($tab as $v)
            {
                foreach($tab as $v2)
                {
                    if ($v2['SERVEUR_NOM'] != $v['SERVEUR_NOM'] && $v2['PROJET_ID'] == $v['PROJET_ID'])
                    {
                        if (!in_array($v['PROJET_ID'], $revoirTab))
                            $revoirTab[] = $v['PROJET_ID'];
                    }
                }
            }
            
            $tabOk = array();
            
            foreach($tab as $v)
            {
                if (in_array($v['PROJET_ID'], $revoirTab))
                    $v['PROJET_LIBELLE'] = $v['PROJET_LIBELLE'].' ('.$v['SERVEUR_NOM'].')';
                $tabOk[] = $v;
            }
            $tab = array('Vos Applications' => $tabOk);
    	    //$db->disconnect();
    	}
    }
    return $tab;
}

/**
 * Renvoie le tableau contenant les applications accéssibles par l'utilisateur
 * 
 * @return array Tableau des applications
 * 
 */
function getApplicationUser()
{
    if (isset($_SESSION[PROJET_NAME]) && isset($_SESSION[PROJET_NAME]['application_user']))
        return $_SESSION[PROJET_NAME]['application_user'];
    else
        return array();
}

/**
 * Enregistre (en session) la liste des applications auquel l'utilisateur peut switcher
 * 
 * @param array Tableau des applications
 * 
 */
function setApplicationUser($tab)
{
    if (isset($_SESSION[PROJET_NAME]['authentified']) && $_SESSION[PROJET_NAME]['authentified'] == 1)
    {
        $_SESSION[PROJET_NAME]['application_user'] = $tab;
    }
    else
    {
        die('Erreur, l\'appel de la fonction setApplicationUser ne peut se faire que si la personne est connectée.');
    }
}

/**
 * Vide la liste des applications (en session) auquel l'utilisateur peut switcher
 */
function delApplicationUser()
{
    if (isset($_SESSION[PROJET_NAME]['authentified']) && $_SESSION[PROJET_NAME]['authentified'] == 1)
    {
        $_SESSION[PROJET_NAME]['application_user'] = array();
    }
    else
    {
        die('Erreur, l\'appel de la fonction delApplicationUser ne peut se faire que si la personne est connectée.');
    }
}

/**
 * Ajoute (en session) une application auquel l'utilisateur peut switcher
 * 
 * @param string Nom de l'application qui apparraitra dans la liste
 * @param string Url vers l'application
 * @param string Nom du groupe dans lequel l'application sera mise
 *
 * Exemple:
 * <code>
 * <?php
 * delApplicationUser();
 * addApplicationUser('Gestion des Interventions', 'http://webdsi.intranet/');
 * ?>
 * </code>
 */
function addApplicationUser($ApplicationLibelle, $ApplicationUrl, $ApplicationGroupe = 'Vos Applications')
{
    if (isset($_SESSION[PROJET_NAME]['authentified']) && $_SESSION[PROJET_NAME]['authentified'] == 1)
    {
        if (isset($_SESSION[PROJET_NAME]['application_user']))
        {
            if (!isset($_SESSION[PROJET_NAME]['application_user'][$ApplicationGroupe]))
                $_SESSION[PROJET_NAME]['application_user'][$ApplicationGroupe] = array();
        }
        else
        {
            $_SESSION[PROJET_NAME]['application_user'] = array();
            $_SESSION[PROJET_NAME]['application_user'][$ApplicationGroupe] = array();
        }
        $_SESSION[PROJET_NAME]['application_user'][$ApplicationGroupe][] = array(
                                                                                    'PROJET_LIBELLE' => $ApplicationLibelle,
                                                                                    'PROJET_URL' => $ApplicationUrl,
                                                                                );
    }
    else
    {
        die('Erreur, l\'appel de la fonction addApplicationUser ne peut se faire que si la personne est connectée.');
    }
}

/**
 * Fonction qui se déconnecte des bases de données
 * 
 * Variable à utiliser pour les connexions :
 * $db, $dbOracle, $dbAccess, $dbLog
 * 
 */
function deconnexionDesBases()
{
    global $db, $dbOracle, $dbAccess, $dbLog, $gestionProjet, $page, $dbSigAdresse;
    
    // Mysql
    if (isset($db) && strtolower(get_class($db)) != 'db_error')
    {
        $db->disconnect();
        unset($db);
    }
    
    // Oracle
    if (isset($dbOracle) && strtolower(get_class($dbOracle)) != 'db_error')
    {
        $dbOracle->disconnect();
        unset($dbOracle);
    }
    
    // Access
    if (isset($dbAccess) && strtolower(get_class($dbAccess)) != 'db_error')
    {
        $dbAccess->disconnect();
        unset($dbAccess);
    }
    
    // DB SIG Adresse
    if (isset($dbSigAdresse) && is_object($dbSigAdresse) && strtolower(get_class($dbSigAdresse)) != 'db_error' && strtolower(get_class($dbSigAdresse)) != '')
    {
        $dbSigAdresse->disconnect();
        unset($dbSigAdresse);
    }
    
    // Base de log
    if (isset($dbLog) && strtolower(get_class($dbLog)) != 'db_error')
    {
        // avant de se déconnecter, on va calculer le temps d'execution de la page...
        if (isset($page) && $page->statsId != '')
        {
            $page->timeFin = getMicroTime();
            $t = number_format($page->timeFin - $page->timeDebut, 4, '.', '');
            
            if (isset($_SESSION[PROJET_NAME]['agent_ldap']['login'])) // user => Connexion novell
                $stats_user = '\''. protegeChaine($_SESSION[PROJET_NAME]['agent_ldap']['login']) .'\'';
            else
                $stats_user = 'NULL';
                
            executeReq($dbLog, 'update `stats` set `stats_page_time`=\''.$t.'\', stats_user='.$stats_user.' where `stats_id`=\''. $page->statsId .'\'', false);
        }
        
        $dbLog->disconnect();
        unset($dbLog);
    }
    
    // Base des projets
    if (isset($gestionProjet) && $gestionProjet->isConnected())
    {
        $gestionProjet->deconnexion();
        unset($gestionProjet);
    }
    
    // une fonction de deconnexion existe, on la lance
    if (function_exists('deconnexion'))
    {
        deconnexion();
    }
}

/**
 * Renvoi une date au format Français (DD/MM/YYYY)
 * 
 * @param string Date au format américain (YYYY-MM-DD)
 * @return string Date au format Français (DD/MM/YYYY)
 * 
 * Exemple:
 * <code>
 * <?php
 * $dateUS = '2007-12-25';
 * echo getDateFr($dateUS);
 * // Affiche 25/12/2007
 * ?>
 * </code>
 */
function getDateFr($dateAmericaine, $afficheMoisEnLettre = false)
{
    $dateAmericaine = trim($dateAmericaine);
    if ($dateAmericaine != '')
    {
        $t = explode('-', $dateAmericaine);
        if ($afficheMoisEnLettre == true)
            return $t[2] .' '. getMoisLibelle($t[1]) .' '. $t[0];
        else
            return $t[2] .'/'. $t[1] .'/'. $t[0];
    }
    else
        return '';
}

/**
 * Renvoi une chaine correspondant au nombre qui est passé entre paramètre
 * 
 * @param float Nombre au format numérique
 * @param string Monnaie à afficher
 * @return string Nombre converti en chaine de caractère
 * 
 * Exemple:
 * <code>
 * <?php
 * $nombre = 169.42;
 * echo getStringForNumber($nombre);
 * // Affiche cent soixante-neuf et quarante-deux centimes
 * echo getStringForNumber($nombre, 'euro');
 * // Affiche cent soixante-neuf euros et quarante-deux centimes
 * ?>
 * </code>
 */
function getStringForNumber($number, $monnaie = '')
{
    $nw = new Numbers_Words();
    $chaine = '';
    if (strpos($number, '.') === false)
    {
        $chaine = $nw->toWords($number, 'fr');
        if ($monnaie != '')
        {
            $chaine .= ' '.$monnaie;
            if ($number > 1)
                $chaine .= 's';
        }
    }
    else
    {
        $t = explode('.', $number, 2);
        // Ajout d'un zero à la fin
        if (strlen($t[1]) == 1)
        {
            $t[1] .= '0';
        }
        $chaine = $nw->toWords($t[0],'fr');
        if ($monnaie != '')
        {
            $chaine .= ' '.$monnaie;
            if ($t[0]>1)
                $chaine .= 's';
        }
        $chaine .= ' et '.$nw->toWords($t[1],'fr'). ' centime';
        if ($t[1]>1)
            $chaine .= 's';
    }
    
    return $chaine;
}

/**
 * Renvoi une date au format Américain (YYYY-MM-DD)
 * 
 * @param string $dateFrancaise Date au format Français (DD/MM/YYYY)
 * @param string $separateur Séparateur employé dans le format de la date : / ou - par exemple
 * @return string Date au format Américain (YYYY-MM-DD)
 * 
 * Exemple:
 * <div style="border:1px black solid;"><pre>
 * $dateFR = '25/12/2007';
 * echo getDateUs($dateFR, '/');
 * // Affiche 2007-12-25
 * </pre></div>
 */
function getDateUs($dateFrancaise, $separateur = '/')
{
    $dateFrancaise = trim($dateFrancaise);
    if ($dateFrancaise != '')
    {
        $t = explode($separateur, $dateFrancaise);
        return $t[2] .'-'. $t[1] .'-'. $t[0];
    }
    else
        return '';
}

/**
 * Envoi un message à un utilisateur sous Jabber (messagerie instantanée)
 * 
 * @param string $serveurAdresse Adresse du serveur de messagerie instantanée
 * @param string $userLogin Login du user qui envoi le message
 * @param string $userPassword Mot de passe du user qui envoi le message
 * @param string $destinataire Destinataire du message
 * @param string $message Texte à envoyer au destinataire
 * 
 * Exemple:
 * <div style="border:1px black solid;"><pre>
 * $mess = 'Bonjour JC,'."\n"."\n".
 *         'Ceci est un message automatique afin de te prévenir prévenir d\'un évènement important...'."\n"."\n".
 *         'Laurent vient de t\'affecter une nouvelle intervention...'."\n"."\n".
 *         'Clique ici pour la consulter : '."\n".
 *         $GENERAL_URL.'/index.php?P=1400&action=modifier&intervention_id=3';
 * 
 * sendJabberMessageToUser('10.128.10.17', 'gpi', 'gpipassword', 'marinjc@10.128.10.17', $mess);
 * </pre></div>
 */
function sendJabberMessageToUser($serveurAdresse, $userLogin, $userPassword, $destinataire, $message)
{
    $conn = new XMPP($serveurAdresse, 5222, $userLogin, $userPassword, 'xmpphp', $serveurAdresse, $printlog=False, $loglevel=LOGGING_INFO);
    $conn->connect();
    $conn->processUntil('session_start');
    $conn->message($destinataire, utf8_encode($message));
    $conn->disconnect();
}

/**
 * Indique si l'utilisateur peut modifier / afficher un message d'alerte sur le site<br>
 *
 * Cette indication est mise en SESSION, pensez à rappeller cette fonction setUserCanModifyAlerteMessage<br>
 * lors de la déconnexion de l'utilisateur afin de remettre à false le fait qu'il ne puisse modifier le message d'alerte.
 * 
 * @param boolean Indique si oui ou non l'utilisateur peut modifier le message d'alerte
 *
 */
function setUserCanModifyAlerteMessage($value = false)
{
    if (is_bool($value))
        $_SESSION[PROJET_NAME]['can_modify_alert_message'] = $value;
    else
        die('setUserCanModifyAlerteMessage: ['.$value.'] n\'est pas un boolean! Utilisez true ou false!');
}

/**
 * Renvoie true si l'utilisateur peut accéder à la page de modification des messages (sinon c'est false)
 * 
 * @return boolean Renvoie true si l'utilisateur peut accéder à la page de modification des messages (sinon c'est false)
 *
 */
function getUserCanModifyAlerteMessage()
{
    if (isset($_SESSION[PROJET_NAME]['can_modify_alert_message']))
        return $_SESSION[PROJET_NAME]['can_modify_alert_message'];
    else
        return false;
}

/**
 * Transforme une requete de type LIMIT pour Mysql en une requete de type LIMIT pour Oracle
 * 
 * @param string Requete de type LIMIT pour MySql
 * @return string Requete LIMIT pour Oracle
 *
 */
function getReqOracleLimitWidthMySqlLimit($reqMysql)
{
    $req = trim($reqMysql);
    if (substr(strtolower($req),0,7)!='select ')
        return $req;
    //on traite pas les requête avec UNION ou qui contient la Column ROWNUM
    if (strpos(strtolower($req),'union ') || strpos(strtolower($req),'rownum '))
        return $req;    
    //recherche des limites
    if (!$l=stristr($req,'limit '))
        return $req;
    
    if(!$p=strpos($l,','))
        return $req;
    $l1=trim(substr($l,6,($p-6)));
    if($l1=='0')
        $l1='1';
    $l2='('.$l1.'+'.substr($l,($p+1)).')';
    
    $pos_f=strpos(strtolower($req),'from ');
    $pos_o=strpos(strtolower($req),'order by ');
    $pos_l=strpos(strtolower($req),'limit ');
    
    if($pos_o){
        $order=substr($req,$pos_o,$pos_l-$pos_o-1);
        $p=$pos_o;
    }else{
        $order='1';
        $p=$pos_l;
    }
    $order='('.$order.')';

    $from=substr($req,$pos_f,$p-$pos_f-1);
    
    $r=substr($req,0,$pos_f-1).',ROW_NUMBER() OVER '.$order.' LIMIT#XXX '.$from;
    $req='select * from ('.$r.') '.
         'where LIMIT#XXX >= '.$l1.' and LIMIT#XXX < '.$l2;

    return $req;
}

/**
 * Encode une chaine à l'aide d'une clée (mot de passe)
 * 
 * @param string filter clée utilisé pour encoder la chaine de caractère
 * @param string str Chaine de caractère à encoder
 *
 * Exemple:
 * <code>
 * <?php
 * $chEncode = codeStr('maclef', 'Chaine à encoder');
 * ?>
 * </code>
 */
function codeStr($filter, $str)
{
    $filter     = md5($filter);
    $letter     = -1;
    $newpass    = '';
    $newstr     = '';
    $strlen     = strlen($str);
    
    for ( $i = 0; $i < $strlen; $i++ )
    {
        $letter++;
    
        if ( $letter > 31 )
        {
            $letter = 0;
        }
        
        $neword = ord($str{$i}) + ord($filter{$letter});
        
        if ( $neword > 255 )
        {
            $neword -= 256;
        }
        
        $newstr .= chr($neword);
    }
    
    return base64_encode($newstr);
}

/**
 * Decode une chaine à l'aide d'une clée (mot de passe)
 * 
 * @param string filter clée utilisé pour decoder la chaine de caractère
 * @param string str Chaine de caractère à decoder
 *
 * Exemple:
 * <code>
 * <?php
 * $chDecode = decodeStr('maclef', 'Chaine à décoder');
 * ?>
 * </code>
 */
function decodeStr($filter, $str)
{
    $filter = md5($filter);
    $letter = -1;
    $newstr = '';
    $str = base64_decode($str);
    $strlen = strlen($str);
    
    for ( $i = 0; $i < $strlen; $i++ )
    {
        $letter++;
    
        if ( $letter > 31 )
        {
            $letter = 0;
        }
        
        $neword = ord($str{$i}) - ord($filter{$letter});
        
        if ( $neword < 1 )
        {
            $neword += 256;
        }
        
        $newstr .= chr($neword);
    }
    
    return $newstr;
}

function read_dir($dir,$dir_max)
{
    $array = array();
    $array[0] = '';
    $array[1] = 0;
    if(!strstr($dir, '_NO_'))//dossier vide
    {
        $me = 0;
        $hdl = @opendir($dir);
        while($f = @readdir($hdl))
        {
            if(is_dir($dir.'/'.$f) && substr($f, -2, 2) !== '..' && substr($f, -1, 1) !== '.')
            {
                if($dir_max > 0)
                {
                    $dir_max--;
                    $array[0] .= '<quote style="background:#'.rand(2,9).'f'.rand(2,9).'f'.rand(2,9).'f">[DIR] <h3>'.$dir.'/'.$f.'</h3><br />';
                    $narray = read_dir($dir.'/'.$f,$dir_max);
                    $array[0] .= $narray[0];//code html
                    $array[1] += $narray[1];//nombre de ligne
                    $array[0] .= '</quote>';
                }
            }
            else if((substr($f, -4, 4) == '.php'
            ||    substr($f, -3, 3) == '.js'
            ||    substr($f, -4, 4) == '.css'
            ||    substr($f, -4, 4) == '.htm'
            ||    substr($f, -5, 5) == '.html'
            )  && substr($f, 0, 4) !== '_NO_')//fichier .php ou .js
            {
                $l = count(file($dir.'/'.$f));
                $array[1] += $l;
                $array[0] .= '<quote style="background:#'.rand(2,9).'f'.rand(2,9).'0'.rand(2,9).'f">'.$l.' ligne(s) dans <strong style="float:right">'.$dir.'/'.$f.'</strong>';
                $array[0] .= '</quote>';
            }
            else
            {
                $array[0] .= '['.$dir.'/'.$f.'] ';
            }
        }
    }
    else
    {
        $array[0] .= '<quote style="background:#000000;color:#ffffff">Passe le dossier dossier : '.$dir.'</quote>';
    }
    return $array;
}

function getUserLoginForPortaneoId($portaneoId)
{
    $userId = '';
    
    $dbHost	= SDELPHINUS_IP;
    $dbUser	= 'airport';
    $dbPass	= 'man2airport';
    $dbName	= 'airport';
    $dbType = 'mysql';

	$dsn	= $dbType . '://' . $dbUser . ':' . $dbPass . '@' . $dbHost . '/' . $dbName;

	$db 	= DB::connect($dsn, array('debug'=>true));
    
	if (DB::isError($db))
	{
	    die('Erreur lors de la connexion à la base de données airport');
	}
	
	$res = executeReq($db, 'select username from users where id=\''.protegeChaine($portaneoId).'\'');
	while(list($u) = $res->fetchRow())
	{
	    $userId = $u;
	}
	$db->disconnect();
	return $userId;
}

function getHexColorForPortaneoIdColor($colorId)
{
    if ($colorId == 1) // bleu
        $color = '#177AB4';
    elseif ($colorId == 2) // rouge
        $color = '#D8403C';
    elseif ($colorId == 3) // vert
        $color = '#7DB51B';
    elseif ($colorId == 4) // noir
        $color = '#404040';
    elseif ($colorId == 5) // orange
        $color = '#C69330';
    elseif ($colorId == 6) // violet
        $color = '#5B0A5A';
    elseif ($colorId == 7) // jaune
        $color = '#E5DE72';
    elseif ($colorId == 8) // rose clair
        $color = '#FFC5FE';
    elseif ($colorId == 9) // gris
        $color = '#8C8C8C';
    elseif ($colorId == 10) // blanc cassé (couleur elu)
        $color = '#E7E6CE';
    else
        $color = '#000000';
	return $color;
}

function getMatriculeForPortaneoLogin($login_ldap,$with_zero=true)
{
    $tUser = array();
    $dbHost	= SDELPHINUS_IP;
    $dbUser	= 'usearch';
    $dbPass	= 'usearch2mysqlpwd';
    $dbName	= 'usearch';
    $dbType = 'mysql';

	$dsn	= $dbType . '://' . $dbUser . ':' . $dbPass . '@' . $dbHost . '/' . $dbName;

	$db 	= DB::connect($dsn, array('debug'=>true));
    
	if (DB::isError($db))
	{
	    die('Erreur lors de la connexion à la base de données usearch');
	}
	$sql = 'select id,ldap_matricule,ldap_login,ldap_contexte from ldap_matricule where upper(ldap_login)=\''.protegeChaine(strtoupper($login_ldap)).'\'';
	$res = executeReq($db, $sql);
	while(list($id,$ldap_matricule,$ldap_login,$ldap_contexte) = $res->fetchRow())
	{
	    $tUser = array(
                        'ID'            => $id,
                        'MATRICULE'     => ($with_zero==true ? substr('00000'.$ldap_matricule,-6) : $ldap_matricule),
                        'LOGIN'         => $ldap_login,
                        'CONTEXTE'      => $ldap_contexte,
                      );
	}
	$db->disconnect();
	return $tUser;
}

function sendSMS($destinataire,$message)
{
    if (substr($destinataire, 0, 4) != '+336')
        return 'Numéro de téléphone incorrect ['. $destinataire .']';
    
    if (strlen(trim($message)) < 1)
        return 'Message trop court';
        
    $dbHost	= SDELPHINUS_IP;
    $dbUser	= 'sms';
    $dbPass	= 'smspwd';
    $dbName	= 'sms';
    $dbType = 'mysql';

	$dsn	= $dbType . '://' . $dbUser . ':' . $dbPass . '@' . $dbHost . '/' . $dbName;

	$db 	= DB::connect($dsn, array('debug'=>true));
    
	if (DB::isError($db))
	{
	    return 'Erreur lors de la connexion à la base de données sms';
	}
	
	
	$sql =  'insert into sms (sms_message, sms_destinataire, sms_date_insert, etat_id) values ('.
	        '\''. protegeChaine($message) .'\', '.
	        '\''. protegeChaine($destinataire) .'\', '.
	        '\''. time() .'\', '.
	        '\'1\' '.
	        ')';
	$res = executeReq($db, $sql);
	$db->disconnect();
	return true;
}

function getChaineForUrlRewriting($str)
{
    $str = str_replace(' ', '-', $str);
    $str = strtr($str,  'ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËéèêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ',
                        'AAAAAAaaaaaaOOOOOOooooooEEEEeeeeCcIIIIiiiiUUUUuuuuyNn');
    $str = preg_replace("/[^0-9A-Za-z-]/", "", $str );
    /*$str = str_replace('-', ' ', $str);
    $str = str_replace('  ', ' ', $str);
    $str = str_replace('  ', ' ', $str);
    $str = str_replace('"', '', $str);
    $str = str_replace('%', '', $str);
    $str = strtr($str,  'ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËéèêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ °,./?',
                        'AAAAAAaaaaaaOOOOOOooooooEEEEeeeeCcIIIIiiiiUUUUuuuuyNn------');
    $str = str_replace('\'', '', $str);
    $str = str_replace(':', '', $str);
    $str = str_replace('=', '', $str);
    $str = str_replace('>', '', $str);
    $str = str_replace('<', '', $str);
    $str = str_replace('€', 'euros', $str);
    $str = str_replace('&euro;', 'euros', $str);*/
    $str = str_replace('--', '-', $str);
    $str = substr($str, 0,250);
    return $str;
}


function effaceRepertoire($dir)
{
    if (is_dir($dir))
    {
        $objects = scandir($dir);
        foreach ($objects as $object)
        {
            if ($object != "." && $object != "..")
            {
                if (filetype($dir."/".$object) == "dir")
                    effaceRepertoire($dir."/".$object);
                else
                    unlink($dir."/".$object);
            }
        }
         reset($objects);
         rmdir($dir);
    }
} 
 
/**
 * Copie la structure d'une table d'une Base de données A et la colle dans une base de donnée B avec les insert
 * 
 * @param DB connexionSource Lien vers la connexion source (base de données A).
 * @param string tableSource nom de la table dans la base de données A (on peut préfixer par le shéma).
 * @param DB connexionDestination Lien vers la connexion de destination (base de données B).
 * @param string tableDestination nom de la table dans la base de données B de destination.
 * @return int Nombre d'insert effectué avec succès
 */
function copyTableToNewTableWithData($connexionSource, $tableSource, $connexionDestination, $tableDestination, $filtreSelect = '', $debug = false)
{
    // Récupération des colonnes de la table
    if ($connexionSource->dbsyntax == 'mysql')
        $req = 'show fields from '. $tableSource;
    else
    {
        $t = explode('.', $tableSource);
        if (count($t) == 2) // on a demandé un truc du genre SHEMA.TABLE
        {
            $req =  'select column_name, data_type, nullable, nullable, data_default, data_length '.
                    'from all_tab_columns '.
                    'where lower(TABLE_NAME)=\''. strtolower($t[1]) .'\' '.
                    'and lower(OWNER)=\''. strtolower($t[0]) .'\' '.
                    'order by column_id';
        }
        else // la demande ne contient que la table
        {
            $req =  'select column_name, data_type, nullable, nullable, data_default, data_length '.
                    'from user_tab_columns '.
                    'where lower(TABLE_NAME)=\''. strtolower($tableSource) .'\' '.
                    'order by column_id';
        }
    }
//    echo $req;
    if ($debug)
    {
        echo    '----------------------------------------------------------------------------------------------<br>'.
                'Récupération structure table <strong>'.$tableSource.'</strong> => ';
        ob_flush();
        flush();
    }
    $res = executeReq($connexionSource, $req);
    $table = $tablePrimaryKey = array();
    $reqCreate = 'create table '.$tableDestination.' (';
    $reqSelect = 'select ';
    $from_array = array('NUMBER', 'NVARCHAR2','RAW','VARCHAR2', 'TIMESTAMP(6)');
    $to_array = array('INTEGER', 'VARCHAR','VARCHAR','VARCHAR', 'INTEGER');
    
    while(list($field, $type, $null, $key, $default, $extra) = $res->fetchRow())
    {
        $null_original = $null;
        if ($connexionSource->dbsyntax == 'oci8')
            $null = ($null == 'Y' ? 'YES':'NO');

//        echo $field.'<br>';
        if ($type == 'SDO_GEOMETRY' || $type == 'ST_GEOMETRY')
            continue;
        if ($connexionSource->dbsyntax == 'oci8') // oracle
        {
            $t = explode('.', $tableSource);
            if (count($t) == 2) // on a demandé un truc du genre SHEMA.TABLE
            {
                $req2 = 'select all_constraints.constraint_name,all_cons_columns.column_name, all_constraints.constraint_type '.
                        'from all_constraints, all_cons_columns '.
                        'where all_constraints.OWNER=all_cons_columns.OWNER '.
                        'and all_constraints.CONSTRAINT_NAME=all_cons_columns.CONSTRAINT_NAME '.
                        'and all_constraints.TABLE_NAME=all_cons_columns.TABLE_NAME '.
                        'and lower(all_constraints.OWNER)=\''. strtolower($t[0]) .'\' '.
                        'and all_constraints.constraint_type=\'P\' '.
                        'and lower(all_constraints.TABLE_NAME)=\''. strtolower($t[1]) .'\' '.
                        'and all_cons_columns.column_name=\''. $field .'\' ';
            }
            else // la demande ne contient que la table
            {
                $req2 = 'select user_constraints.constraint_name,user_cons_columns.column_name, user_constraints.constraint_type '.
                        'from user_constraints, user_cons_columns '.
                        'where user_constraints.OWNER=user_cons_columns.OWNER '.
                        'and user_constraints.CONSTRAINT_NAME=user_cons_columns.CONSTRAINT_NAME '.
                        'and user_constraints.TABLE_NAME=user_cons_columns.TABLE_NAME '.
                        'and user_constraints.constraint_type=\'P\' '.
                        'and lower(user_constraints.TABLE_NAME)=\''. strtolower($tableSource) .'\' '.
                        'and user_cons_columns.column_name=\''. $field .'\' ';
            }
            
            
//            echo $req2;
//            break;
            $res2 = executeReq($connexionSource, $req2);
            $key = '';
            while(list($constraint_name, $column_name, $constraint_type) = $res2->fetchRow())
            {
                $key = 'PRI';
            }
        }
        
        if (count($table) > 0)
        {
            $reqCreate .= ', ';
            $reqSelect .= ', ';
        }

        $type2 = str_replace($from_array, $to_array, $type);
        
        $reqCreate .= "\n". strtolower($field).' '.$type2;
        if (strtolower($type) != 'date')
        {
            if ($extra != '' && strtolower($extra) != 'on update current_timestamp')
            {
                if (strtolower($type) == 'raw')
                    $extra = $extra*2; // patch car les raw convertis sont plus gros
                if (strtolower($extra) == 'auto_increment')
                    $reqCreate .= ' '.$extra;
                else
                    $reqCreate .= '('.$extra.')';
            }
        }
        
        if ($null != 'YES') // => NOT NULL
        {
            $reqCreate .= ' NOT NULL';
        }
        
        
        if ($key == 'PRI') // => PRIMARY KEY
        {
            $tablePrimaryKey[] = strtolower($field);
            //$reqCreate .= ' PRIMARY KEY';
        }
        
        // $reqSelect .= 'CONVERT('.strtolower($field).',\'utf8\',\'al32utf8\') ';
        //$reqSelect .= 'RAWTOHEX('.strtolower($field).') ';
        if ($connexionSource->dbsyntax == 'oci8' && strtolower($type) == 'date')
            $reqSelect .= 'to_char('.strtolower($field).', \'YYYY-MM-DD\')';
        else if ($connexionSource->dbsyntax == 'oci8' && strtolower($type) == 'timestamp(6)')
            $reqSelect .= 'to_char('.strtolower($field).', \'DD/MM/YYYY HH24:MI:SS,\')';
        else if ($connexionSource->dbsyntax == 'oci8' && strtolower($type) == 'raw')
            $reqSelect .= 'CONVERT('.strtolower($field).',\'utf8\',\'al32utf8\') ';
        else
            $reqSelect .= strtolower($field);
        
        
        $table[] = array(
                                'FIELD' => $field,
                                'TYPE' => $type,
                                'NULL_ORIGINAL' => $null_original,
                                'NULL' => $null,
                                'KEY' => $key,
                                'DEFAULT' => $default,
                                'EXTRA' => $extra,
                                //'VAR' => $this->getNameForColonne($field)
                               );
    }
    //print_jc($table);
    
    
    $reqSelect .= ' from '.$tableSource.' ';
    if ($filtreSelect != '')
        $reqSelect .= $filtreSelect;
    
    if (count($tablePrimaryKey) > 0)
    {
        $reqCreate .= ",\n".'primary key ('.implode(', ', $tablePrimaryKey).')';
    }
    $reqCreate .= "\n".')';
    //echo str_replace("\n", '<br>', $reqCreate);
    
    //echo $reqCreate;
    //echo $reqSelect;
    $nbLigneInsert = 0;
    if (count($table) > 0)
    {
        if ($debug)
        {
            echo '<strong><font color=green>OK</font></strong><br>';
            ob_flush();
            flush();
        }
        if ($debug)
        {
            echo 'Drop (si elle exite) puis create de la table <strong>'.$tableDestination.'</strong> => ';
            ob_flush();
            flush();
        }
        $resDrop = executeReq($connexionDestination, 'DROP TABLE IF EXISTS '.$tableDestination);
    
        $resCreate = executeReq($connexionDestination, $reqCreate);
        
        
        if (!DB::isError($resCreate))
        {
            if ($debug)
            {
                echo '<strong><font color=green>OK</font></strong><br>';
                echo 'Insert dans la table <strong>'.$tableDestination.'</strong> => ';
                ob_flush();
                flush();
            }
            $res = executeReq($connexionSource, $reqSelect);
            while($ligne = $res->fetchRow())
            {
                $reqInsert = 'insert into '. $tableDestination .' values (';
                $nb = 0;
                foreach($ligne as $v)
                {
                    if ($nb > 0)
                        $reqInsert .= ', ';
                    if ($table[$nb]['NULL'] == 'YES' && $v == '')
                    {
                        $reqInsert .= 'NULL';
                    }
                    else if ($table[$nb]['TYPE'] == 'NUMBER' || $table[$nb]['TYPE'] == 'FLOAT')
                    {
//                        if ($v == '')
//                            $reqInsert .= 'NULL';
//                        else
                            $reqInsert .= str_replace(',', '.', $v);
                    }
                    else if ($table[$nb]['TYPE'] == 'TIMESTAMP(6)')
                    {
                        //28/10/2010 10:19:54,387000
                        $t = explode(' ', $v);
                        $date = explode('/', $t[0]);
                        
                        $t = explode(',', $t[1]);
                        $heure = explode(':', $t[0]);
                        
                        
                        $reqInsert .= mktime($heure[0], $heure[1], $heure[2], $date[1], $date[0], $date[2]);
                    }
                    else
                    {
                        $reqInsert .= '\''. protegeChaine($v) .'\'';
                    }
                    $nb++;
                }
                $reqInsert .= ')';
                $res2 = executeReq($connexionDestination, $reqInsert);
//                 echo $reqInsert;
//                 break;
                if (!DB::isError($res2))
                {
                    $nbLigneInsert++;
                }
                else
                {
                    // erreur
                    return;
                }
            }
            if ($debug)
            {
                if ($nbLigneInsert == 0)
                {
                    echo '<strong><font color=red>'.$nbLigneInsert.'</font></strong><br>';
                }
                else
                {
                    echo '<strong><font color=green>'.$nbLigneInsert.'</font></strong><br>';
                }
                ob_flush();
                flush();
            }
        }
        else
        {
            if ($debug)
            {
                echo '<strong><font color=red>ERREUR</font></strong><br>';
                ob_flush();
                flush();
            }
        }
    }
    else
    {
        if ($debug)
        {
            echo '<strong><font color=red>ERREUR</font></strong><br>';
            ob_flush();
            flush();
        }
    }
    
    if ($debug)
    {
        echo '----------------------------------------------------------------------------------------------<br>';
        ob_flush();
        flush();
    }
    
    return $nbLigneInsert;
}

function getTableCommentaire($db, $tableName)
{
    $req = 'show table status where Name=\''.$tableName.'\'';
    $res = executeReq($db, $req);
    
    $comment = '';
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
    
        $comment = $t[17];
    }
    return $comment;
}

/**
 * fonction qui affiche bloque de formulaire de recherche d'adresse pour l'inserer dans un formulaire de saisie
 * @param array - $aParams - tableau de paramettre
 * <ul>
 *   <li>string - FORM_NAME - Nom du formulaire</li>
 *   <li>boolean - DISPLAY_INPUT - Affiche l'input meme si on modifie l'adresse</li>
 *   <li>integer - ID_ADR_LOCATION - ID de l'adresse</li>
 *   <li>integer - CDRURU - CDRURU de l'adresse</li>
 *   <li>integer - ADR_NUM_VOIRIE - Numero de voirie de l'adresse</li>
 * </ul>
 */
function getSigAdresse($aParams = array(), $return = false)
{
    global $dbSigAdresse;

    // Inintialisation des valeurs
    $retour = '';
    
    $id_adr_location = '';
    $form_name = '';
    $display_input = 'false';
    
    $cdruru = '';
    $adresse = '';
    $adr_num_voirie = '';
    $adr_ens_lib_type = '';
    $adr_ens_nom = '';
    $adr_type_bati = '';
    $adr_bati_lib = '';
    $cdpsru = '';
    $lcomru = '';
    
    $compte = 0;
    
    // on set les valeurs qui sont fourni en paramettre
    if (isset($aParams['ID_ADR_LOCATION']) == true
        && strlen($aParams['ID_ADR_LOCATION']) > 0)
    {
        $id_adr_location = $aParams['ID_ADR_LOCATION'];
    }
    
    if (isset($aParams['CDRURU']) == true
        && strlen($aParams['CDRURU']) > 0)
    {
        $cdruru = $aParams['CDRURU'];
    }
    
    if (isset($aParams['ADR_NUM_VOIRIE']) == true
        && strlen($aParams['ADR_NUM_VOIRIE']) > 0)
    {
        $adr_num_voirie = $aParams['ADR_NUM_VOIRIE'];
    }
    
    
    if (isset($aParams['FORM_NAME']) == true
        && strlen($aParams['FORM_NAME']) > 0)
    {
        $form_name = $aParams['FORM_NAME'];
    }
    
    if (isset($aParams['DISPLAY_INPUT']) == true
        && $aParams['DISPLAY_INPUT'] == true)
    {
        $display_input = 'true';
    }
    
    // Creation de la connexion
    if ($dbSigAdresse == '')
    {
        global $PROD;

        if (defined('ORACLE_GIS') == true && ORACLE_GIS == true)
        {
            if ($PROD === 1)
            {
                $dbHost = 'gisprod';
                $dbUser = 'intranet';
                $dbPass = 'intranet';
                $dbName = '';
                $dbType = 'oci8';
            }
            else
            {
                $dbHost = 'gistest';
                $dbUser = 'intranet';
                $dbPass = 'intranet';
                $dbName = '';
                $dbType = 'oci8';
            }
        }
        else
        {
            if ($PROD === 1)
            {
                $dbHost	= 'sigprod';
                $dbUser	= 'intranet';
                $dbPass	= 'intranet';
                $dbName	= '';
                $dbType = 'oci8';
            }
            else
            {
                $dbHost	= 'sigtest';
                $dbUser	= 'intranet';
                $dbPass	= 'intranet';
                $dbName	= '';
                $dbType = 'oci8';
            }
        }

        $dsn = $dbType . '://' . $dbUser . ':' . $dbPass . '@' . $dbHost . '/' . $dbName;
        if (PEAR_PATH == COMMON_PATH.'/PEAR2')
        {
            $dbSigAdresse = DB::connect($dsn, array('debug'=>true, 'portability' => MDB2_PORTABILITY_NONE));
        }
        else
        {
            $dbSigAdresse = DB::connect($dsn, array('debug'=>true));
        }
    }

    // Recuperation des informations en base de donnee
    if (strlen($id_adr_location) > 0
        || (
            strlen($cdruru) > 0
            && strlen($adr_num_voirie) > 0
        ))
    {
        $where = '';
        
        if (strlen($id_adr_location) > 0)
        {
            $where = 'ID_ADR_LOCATION = '.$id_adr_location;
        }
        
        if (strlen($cdruru) > 0)
        {
            if (strlen($where) > 0)
            {
                $where .= ' AND ';
            }
            
            $where .= 'CDRURU = '.$cdruru.' AND ADR_NUM_VOIRIE = \''.protegeChaineOracle($adr_num_voirie).'\'';
            
        }
        
        
        // recuperation des information de l'adresse
        $req = 'SELECT IDENT, CDRURU, ADR_ENS_LIB_TYPE, ADR_ENS_NOM, ID_NUM_VOIRIE_ADR, ADR_NVOI_PRINC, ADR_NUM_VOIRIE,';
        $req .= ' ADR_NVOI_SUFFIXE, ADRESSE, CDPSRU, LCOMRU, ADR_NVOI_COMP_ADR, ADR_TYPE_BATI, ADR_BATI_LIB, OBSERVATIONS,';
        $req .= ' ID_ADR_LOCATION, TYPE_ADR_LOCATION';
        $req .= ' FROM SIGAIX.V_ADR_ADRESSE_PRINC';
        $req .= ' WHERE ';
        $req .= $where;
        

        $res = executeReq($dbSigAdresse, $req);
        $tab = array();
        while ($row = $res->fetchRow(DB_FETCHMODE_ASSOC))
        {
            $compte++;
            $cdruru = $row['CDRURU'];
            $adresse = $row['ADRESSE'];
            $adr_num_voirie = $row['ADR_NUM_VOIRIE'];
            $adr_ens_lib_type = $row['ADR_ENS_LIB_TYPE'];
            $adr_ens_nom = $row['ADR_ENS_NOM'];
            $adr_type_bati = $row['ADR_TYPE_BATI'];
            $adr_bati_lib = $row['ADR_BATI_LIB'];
            $cdpsru = $row['CDPSRU'];
            $lcomru = $row['LCOMRU'];
        }
    }

    $styleKey = 'background-color: #F6F6F6;border-bottom: 1px solid #E9E9E9;border-right: 1px solid #E9E9E9;color: #666666;font-weight: bold;text-align: right;width: 170px;';

    $imageError = 'data:image/gif;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAMAAAAoLQ9TAAAAA3NCSVQICAjb4U/gAAAAtFBMVEXECwvHw8PjgoLiUlLWOjrl5eXuDQ3lpKTzzMzOKCjv7+/pdHTc3NzTJSXzHx/qNjb////rtrbhb2/vw8PkDQ3kkpLfQ0P75OTyY2P34uLU1NT1FhbyPz/ve3vtKSn55OTMMzPtbW3xjY3XSEjMzMztXFzwcnLvHBz31NTyMjL1Ozvxzs7xk5PvoqLtTEzdOTnUKir67+/2uLjRDAzcIyP/GRn0e3v1KSnhTU3sODj1Zmb3c3N0YdxgAAAAPHRSTlP/////////////////////AP////////////////////////////////////////////////////////8Es7xiAAAACXBIWXMAAAsSAAALEgHS3X78AAAAH3RFWHRTb2Z0d2FyZQBNYWNyb21lZGlhIEZpcmV3b3JrcyA4tWjSeAAAALxJREFUGJVdz4kOgjAMBmBQVJiKk2sOvMCDKeMoCirv/2COAYmxadbkS9P8U/BfKd1IZrPkB9baOwzH2noAN+epKJ67HdgF57wsxVPYEk5zXpIoIiWfn1qAItoRTETvogIE6F5dXwnG5LKpPV0Ay5umEUCz2zZn7Y3nPTtgSjFdvZ7yqBWbKf18aGrGlgRYBsG+qvZBsIQuGDMeznTqPAw2RIfRUVGOI+ijo8nCP6vq2V9MEPS/BUAI5AL+ApmYGX/1h28BAAAAAElFTkSuQmCC';

    $imageOk = 'data:image/gif;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAMAAAAoLQ9TAAAAA3NCSVQICAjb4U/gAAAAwFBMVEVMnwnv7++82aSDwFLV1dWbu4HK271gsB+/wL+k039WswyPzF3X58rj8Njz9fFqtC2u0ZLMzMy6zaqKwF9XrBFfwRBnuiTe3t7n5+e15o2965h1tUGBxklQpgqdy3ne5s5cwQzH4bOs537f7tTFxcXP7LiM11Do7OVatRGGuV1UrwqWxm7Z8cbn89620aCiyoD39/fx9O5brxmU1lJXtwtisx9sxSXb7szu8erN47rl795utzS/2KthwhNTpRGFu1mZkkLYAAAAQHRSTlP///////////////////////////////////////////////////////////////8A////////////////////4ghnHgAAAAlwSFlzAAALEgAACxIB0t1+/AAAAB90RVh0U29mdHdhcmUATWFjcm9tZWRpYSBGaXJld29ya3MgOLVo0ngAAAAWdEVYdENyZWF0aW9uIFRpbWUAMDIvMTUvMDZqn4r+AAAAi0lEQVQYlWMwQAMMaHwdNAFJKVQBVQ1dFAFzI24UM5TZ7XiRBczZGThBtlhaQfiKRrLWfCABJn55INdQTktLhAfsDgt2LmZ9bVMTExMBqMNsxMREgcDMHu5SPRljNTU1aQuE09mElZSY5ZH9os6qKcTHBxVglBBnEVTh4FARZBGXYASr4ONjhACQGgBIXygIaYljGgAAAABJRU5ErkJggg==';
    
    $retour .= '
    <table class="admintable">
        <tr>
            <td style="'.$styleKey.'">Voie :</td>
            <td>
                <input type="hidden" name="sig_adresse_cdruru" value="'.$cdruru.'" />
                <input type="hidden" name="sig_adresse_id_adr_location" value="'.$id_adr_location.'" />
                
                <input
                    type="text"
                    name="sig_adresse_adresse"
                    size="60"
                    value="'.$adresse.'"
                    class="validate[\'required\']"
                    autocomplete="off"
                    onfocus="javascript:sigAdresseCacheChampsAdresse('.$display_input.');
                    sigAdresseInitAutoComplete(
                        document.getElementById(\''.$form_name.'\'),
                        document.getElementById(\'sig_adresse_adresse\'),
                        \'sigAdresseCallSuggestionsAdresse\',
                        2
                    );"
                    id="sig_adresse_adresse"
                />
                <div id="sig_adresse_adresse_check"></div>
            </td>
        </tr>
        <tr>
            <td style="'.$styleKey.'">Num&eacute;ro :</td>
            <td id="sig_adresse_adr_num_voie">
                <input type="text" onKeyUp="sigAdresseVerifAdrNumVoie();" class="validate[\'required\']" name="sig_adresse_adr_num_voie" size="5" value="'.$adr_num_voirie.'" />
                <div id="sig_adresse_adr_num_voie_check"></div>
            </td>
        </tr>
        <tr>
            <td style="'.$styleKey.'">Ensemble :</td>
            <td id="sig_adresse_adr_ens_nom">
                <input type="text" onKeyUp="sigAdresseVerifEnsemble();" name="sig_adresse_adr_ens_nom" size="60" value="'.$adr_ens_lib_type.' '.$adr_ens_nom.'" />
                <div id="sig_adresse_adr_ens_nom_check"></div>
            </td>
        </tr>
        <tr>
            <td style="'.$styleKey.'">Sous-Adressage :</td>
            <td>
                <div id="sig_adresse_sous_adressage">
                <input type="text" name="sig_adresse_sous_adressage" size="60" value="'.$adr_type_bati.' '.$adr_bati_lib.'" />
                </div>
            </td>
        </tr>
        <tr>
            <td style="'.$styleKey.'">Code Postal :</td>
            <td id="sig_adresse_cdpsru">
                <input type="text" name="sig_adresse_cdpsru" size="5" value="'.$cdpsru.'" />
                <div id="sig_adresse_cdpsru_check"></div>
            </td>
        </tr>
        <tr>
            <td style="'.$styleKey.'">Ville :</td>
            <td id="sig_adresse_lcomru">
                <input type="text" name="sig_adresse_lcomru" size="30" value="'.$lcomru.'" />
                <div id="sig_adresse_lcomru_check"></div>
            </td>
        </tr>
    </table>
    <script type="text/javascript">
    <!--
    
    sigAdresseInitData(\''.$form_name.'\');
    ';
    
    if ($compte > 1)
    {
         $retour .= 'sigAdresseVerifAdrNumVoie();';
    }
    
    $retour .= '
    
    // -->
    </script>
    ';

    if ($return == false)
    {
        echo $retour;
    }
    else
    {
        return $retour;
    }
}

function setTableCommentaire($db, $tableName, $comment = '')
{
    if ($comment != '')
        executeReq($db, 'alter table '.$tableName.' comment=\''.protegeChaine($comment).'\'');
}

function errorHandlerByJC($errno, $errstr, $errfile, $errline)
{
    if (!(error_reporting() & $errno))
    {
        // This error code is not included in error_reporting
        return;
    }

    $tabMessageWarning = array(
                                'Oh, tu codes avec les pieds ou quoi ? ',
                                'Oh, ta bouche ! ',
                                'T\'es pas réveillé mec ? ',
                                'Ton père c\'est Chuck Norris ? ',
                                'Chuck Norris code mieux que toi mec ! ',
                                'Hum... va prendre un café... ça ira mieux après ! ',
                              );
    if ($errno == E_ERROR)
    {
        echo "<b>My ERROR</b> [$errno] $errstr<br />\n";
        echo "  Fatal error on line $errline in file $errfile";
        echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
        echo "Aborting...<br />\n";
        exit;
        return true;
//         Fatal error: require() [function.require]: Failed opening required 'ezaeaz.php' (include_path='.;C:\php5\pear') in C:\web\sites\agenda\module\mod_evenement_list.php on line 72
    }
    else if ($errno == E_WARNING)
    {
        echo "<font color=\"red\"><b>".$tabMessageWarning[rand(0, count($tabMessageWarning)-1)]." :</b> ";
        if (substr($errstr, 0, 16) == 'Missing argument')
        {
            $errstr = str_replace('Missing argument', 'Tu as oublié l\'argument n°<b>', $errstr);
            $errstr = str_replace(' for ', '</b> pour ta fonction <b>', $errstr);
            $errstr = str_replace(', called in ', '</b> appelée dans ton fichier <b>', $errstr).'</b>';
            echo "$errstr<br /></font>\n";
        }
        else if (substr($errstr, 0, 32) == 'Cannot modify header information')
        {
            $errstr = str_replace('Cannot modify header information - headers already sent by (output started at ', 'Tu souhaites modifier les headers (dans ton fichier '.str_replace(basename($errfile), '<b>'.basename($errfile).'</b>', $errfile)." ligne [<b>$errline</b>]".'), or ces derniers ne peuvent pas l\'être car tu as déjà envoyé du code source au navigateur dans ton fichier <b>', $errstr).'</b>';
            echo "$errstr<br /></font>\n";
        }
        else
            echo "$errstr dans le fichier ".str_replace(basename($errfile), '<b>'.basename($errfile).'</b>', $errfile)." ligne [<b>$errline</b>]<br /></font>\n";
        return true;
    }
    else if ($errno == E_NOTICE)
    {
        echo "<font color=\"#D06C00\"><b>".$tabMessageWarning[rand(0, count($tabMessageWarning)-1)]." :</b> ";
        if (substr($errstr, 0, 18) == 'Undefined variable')
            $errstr = str_replace('Undefined variable: ', 'Ta variable <b>$', $errstr). '</b> n\'a pas été défini';
        if (substr($errstr, 0, 16) == 'Undefined offset')
            $errstr = str_replace('Undefined offset: ', 'L\'indice <b>', $errstr). '</b> n\'a pas été défini dans ton tableau';
        if (substr($errstr, 0, 15) == 'Undefined index')
            $errstr = str_replace('Undefined index: ', 'La clé \'<b>', $errstr). '</b>\' n\'a pas été défini dans ton tableau';
        if (substr($errstr, 0, 25) == 'Use of undefined constant')
        {
            $errstr = str_replace('Use of undefined constant ', 'Tu utilises une constante non défini <b>', $errstr);
            $errstr = str_replace(' - assumed ', '</b> (', $errstr).')';
        }
            
        echo "$errstr dans le fichier ".str_replace(basename($errfile), '<b>'.basename($errfile).'</b>', $errfile)." ligne [<b>$errline</b>]<br /></font>\n";
    }
    else
    {
        echo "Unknown error type: [$errno] $errstr<br />\n";
    }
    

    /* Don't execute PHP internal error handler */
    return true;
}

function supportDsiGetNewTicketId($db)
{
    $useChars = 'ACEYBDGHJMNPQRTWXZ12346789';
    $ticketId = $useChars{mt_rand(0,strlen($useChars)-1)};
    for($i=1;$i<6;$i++)
    {
        $ticketId .= $useChars{mt_rand(0,strlen($useChars)-1)};
    }

    // vérif si l'on pas déjà ce numéro de ticket en base
    $req = 'select count(*) from supportdsi.ticket where ticket_id=\''.$ticketId.'\'';
    $res = executeReq($db, $req);
    $nb = 9999;
    list($nb) = $res->fetchRow();
    if ($nb == 0)
        return $ticketId;
    else
        return getNewTicketId($db);
}

function supportDsiCreateTicket($db, $userStatsProjetMatricule, $ticketUserMatricule, 
                                $ticketUserNom, $ticketUserPrenom, $ticketUserTelephone, $ticketUserMail, 
                                $materielId = '', $batId = '', $motdir = '',
                                $projetId = '', $problemeTxt, $problemeId = '', $isUrgent = false)
{
    $ticketId = supportDsiGetNewTicketId($db);
    if (!class_exists('SupportDsiTicket'))
    {
        // require de l'objet ticket
        //require(COMMON_PATH.'/dsi/class_supportdsi_ticket.php');
        require(COMMON_PATH.'/dsi/class_supportdsi_ticket_v2017.php');
        
        if (!class_exists('SupportDsiTicket'))
            die('pas de classe ticket');
        //echo 'pas de classe Ticket';
    }
    
    //print_jc($_SESSION[PROJET_NAME]['agent_ldap']['matricule']);
    $objTicket = new SupportDsiTicket($db);
    
    $objTicket->setTicketId($ticketId);
    
    $objTicket->setTicketCreationTime(time());
    $objTicket->setTicketSendMail('0');
    $objTicket->setEtatId('2'); // En attente de prise en charge
    $objTicket->setServiceId('10'); // Service Maintenance
    
    // récupération du user qui créé le ticket
    $userId = $serviceId = '';
    if ($userStatsProjetMatricule != '')
    {
        $req = 'select user_id, service_id from supportdsi.user where user_matricule=\''.($userStatsProjetMatricule*1).'\'';
        $res = executeReq($db, $req);
        $userId = $serviceId = '';
        while(list($uid, $sid) = $res->fetchRow())
        {
            $userId = $uid;
            $serviceId = $sid;
        }
    }
    //echo $userId;
    
    if ($userId != '')
        $objTicket->setUserIdCreation($userId);

    if ($serviceId != '')
        $objTicket->setTicketUserServiceId($serviceId);

    $objTicket->setTicketUserMatricule($ticketUserMatricule*1);
    $objTicket->setTicketUserNom(strtoupper($ticketUserNom));
    $objTicket->setTicketUserPrenom($ticketUserPrenom);
    $objTicket->setTicketUserEmail($ticketUserMail);
    $objTicket->setTicketIsArchive('0');
    $objTicket->setTicketUserTelephone($ticketUserTelephone);
    
    if($materielId != '')
        $objTicket->setMaterielId($materielId);

    if($batId != '')
        $objTicket->setTicketBatimentId($batId);

    if($motdir != '')
        $objTicket->setTicketAgentMotdir($motdir);

    if ($projetId != '')
    {
        $objTicket->setProjetId($projetId);
        $objTicket->setLogicielId('');
    }
    
    $objTicket->setTicketDescription($problemeTxt);
    
    if ($problemeId != '')
        $objTicket->setProblemeId($problemeId);
    
    if ($isUrgent === true)
        $objTicket->setTicketIsUrgent('1');
    else
        $objTicket->setTicketIsUrgent('0');
    
    $objTicket->setDestinataireId(1);
//     if ($mid != '')
//     {
//         $objTicket->setMaterielId($mid);
//     }
    $res = $objTicket->insert();
//     print_jc($objTicket);
//     if ($testTicket > 0)
//         $res = $objTicket->update();
//     else
//         $res = $objTicket->insert();
    
    if (DB::isError($res))
        return false;
    
    return $ticketId;
}

include_once('lib_aff_pagination_pdf.php');
?>