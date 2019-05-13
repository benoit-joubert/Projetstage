<?php

// Inintialisation des valeurs
$retour = '';

if (isset($_GET['voie']) == true) {
    $voie = $_GET['voie'];
} else {
    $voie = '';
}

$cdruru = '';
$adresse = '';
$adr_num_voirie = '';
$adr_ens_lib_type = '';
$adr_ens_nom = '';
$adr_type_bati = '';
$adr_bati_lib = '';
$cdpsru = '';
$lcomru = '';

$imageOk = 'data:image/gif;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAMAAAAoLQ9TAAAAA3NCSVQICAjb4U/gAAAAwFBMVEVMnwnv7++82aSDwFLV1dWbu4HK271gsB+/wL+k039WswyPzF3X58rj8Njz9fFqtC2u0ZLMzMy6zaqKwF9XrBFfwRBnuiTe3t7n5+e15o2965h1tUGBxklQpgqdy3ne5s5cwQzH4bOs537f7tTFxcXP7LiM11Do7OVatRGGuV1UrwqWxm7Z8cbn89620aCiyoD39/fx9O5brxmU1lJXtwtisx9sxSXb7szu8erN47rl795utzS/2KthwhNTpRGFu1mZkkLYAAAAQHRSTlP///////////////////////////////////////////////////////////////8A////////////////////4ghnHgAAAAlwSFlzAAALEgAACxIB0t1+/AAAAB90RVh0U29mdHdhcmUATWFjcm9tZWRpYSBGaXJld29ya3MgOLVo0ngAAAAWdEVYdENyZWF0aW9uIFRpbWUAMDIvMTUvMDZqn4r+AAAAi0lEQVQYlWMwQAMMaHwdNAFJKVQBVQ1dFAFzI24UM5TZ7XiRBczZGThBtlhaQfiKRrLWfCABJn55INdQTktLhAfsDgt2LmZ9bVMTExMBqMNsxMREgcDMHu5SPRljNTU1aQuE09mElZSY5ZH9os6qKcTHBxVglBBnEVTh4FARZBGXYASr4ONjhACQGgBIXygIaYljGgAAAABJRU5ErkJggg==';

$imageKo = 'data:image/gif;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAMAAAAoLQ9TAAAAA3NCSVQICAjb4U/gAAAAtFBMVEXECwvHw8PjgoLiUlLWOjrl5eXuDQ3lpKTzzMzOKCjv7+/pdHTc3NzTJSXzHx/qNjb////rtrbhb2/vw8PkDQ3kkpLfQ0P75OTyY2P34uLU1NT1FhbyPz/ve3vtKSn55OTMMzPtbW3xjY3XSEjMzMztXFzwcnLvHBz31NTyMjL1Ozvxzs7xk5PvoqLtTEzdOTnUKir67+/2uLjRDAzcIyP/GRn0e3v1KSnhTU3sODj1Zmb3c3N0YdxgAAAAPHRSTlP/////////////////////AP////////////////////////////////////////////////////////8Es7xiAAAACXBIWXMAAAsSAAALEgHS3X78AAAAH3RFWHRTb2Z0d2FyZQBNYWNyb21lZGlhIEZpcmV3b3JrcyA4tWjSeAAAALxJREFUGJVdz4kOgjAMBmBQVJiKk2sOvMCDKeMoCirv/2COAYmxadbkS9P8U/BfKd1IZrPkB9baOwzH2noAN+epKJ67HdgF57wsxVPYEk5zXpIoIiWfn1qAItoRTETvogIE6F5dXwnG5LKpPV0Ay5umEUCz2zZn7Y3nPTtgSjFdvZ7yqBWbKf18aGrGlgRYBsG+qvZBsIQuGDMeznTqPAw2RIfRUVGOI+ijo8nCP6vq2V9MEPS/BUAI5AL+ApmYGX/1h28BAAAAAElFTkSuQmCC';

$imageArrow = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAMAAADXT/YiAAAAB3RJTUUH0wgIDSATtFhRIAAAAAlwSFlzAAALEgAACxIB0t1+/AAAAARnQU1BAACxjwv8YQUAAAAGUExURf////+EALS1utwAAAABdFJOUwBA5thmAAAAGUlEQVR42mNgwA4YESxGBIsRwWLEFEPVCwACjAARsqp7+wAAAABJRU5ErkJggg==';

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
            $dbHost = 'sigprod';
            $dbUser = 'intranet';
            $dbPass = 'intranet';
            $dbName = '';
            $dbType = 'oci8';
        }
        else
        {
            $dbHost = 'sigtest';
            $dbUser = 'intranet';
            $dbPass = 'intranet';
            $dbName = '';
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


/////////////////////////
if (isset($_GET['cdruru']))
    $cdruru = $_GET['cdruru'];
else
    $cdruru = '';

if (isset($_GET['adr_num_voie']))
    $adr_num_voie = $_GET['adr_num_voie'];
else
    $adr_num_voie = '';

if (isset($_GET['adr_ens_nom']))
    $adr_ens_nom_get = strtoupper($_GET['adr_ens_nom']);
else
    $adr_ens_nom_get = '';

if (isset($_GET['force']))
    $force = $_GET['force'];
else
    $force = '';

if ($force == 1)
{
    $req =  'SELECT count(*) '.
            'FROM SIGAIX.V_ADR_ADRESSE_PRINC '.
            'WHERE CDRURU=\''. protegeChaineOracle($cdruru) .'\' '.
            ($adr_ens_nom_get != '' ? 'AND UPPER(ADR_ENS_NOM) like \'%'. protegeChaineOracle($adr_ens_nom_get) .'%\' ':'');
            //'AND ADR_NUM_VOIRIE=\''. protegeChaineOracle($adr_num_voie) .'\'';
}
else
{
    $req =  'SELECT count(*) '.
            'FROM SIGAIX.V_ADR_ADRESSE_PRINC '.
            'WHERE CDRURU=\''. protegeChaineOracle($cdruru) .'\' '.
            ($adr_num_voie != '' ? 'AND ADR_NUM_VOIRIE=\''. protegeChaineOracle($adr_num_voie) .'\' ':'').
            ($adr_ens_nom_get != '' ? 'AND UPPER(ADR_ENS_NOM) like \'%'. protegeChaineOracle($adr_ens_nom_get) .'%\' ':'');
}

$res = executeReq($dbSigAdresse, $req);
list($nb) = $res->fetchRow();

if ($nb > 0)
{
    if ($force == '1')
    {
        $req =  'SELECT IDENT, ADR_ENS_LIB_TYPE, ADR_ENS_NOM, ADR_TYPE_BATI, ADR_BATI_LIB, OBSERVATIONS, CDPSRU, LCOMRU, ADR_NVOI_COMP_ADR, ADR_NUM_VOIRIE, ID_ADR_LOCATION '.
                'FROM SIGAIX.V_ADR_ADRESSE_PRINC '.
                'WHERE CDRURU=\''. protegeChaineOracle($cdruru) .'\' '.
                ($adr_ens_nom_get != '' ? 'AND UPPER(ADR_ENS_NOM) like \'%'. protegeChaineOracle($adr_ens_nom_get) .'%\' ':'').
                'ORDER BY to_number(ADR_NUM_VOIRIE)';
    }
    else
    {
        $req =  'SELECT IDENT, ADR_ENS_LIB_TYPE, ADR_ENS_NOM, ADR_TYPE_BATI, ADR_BATI_LIB, OBSERVATIONS, CDPSRU, LCOMRU, ADR_NVOI_COMP_ADR, ADR_NUM_VOIRIE, ID_ADR_LOCATION '.
                'FROM SIGAIX.V_ADR_ADRESSE_PRINC '.
                'WHERE CDRURU=\''. protegeChaineOracle($cdruru) .'\' '.
                ($adr_num_voie != '' ? 'AND ADR_NUM_VOIRIE=\''. protegeChaineOracle($adr_num_voie) .'\' ':'').
                ($adr_ens_nom_get != '' ? 'AND UPPER(ADR_ENS_NOM) like \'%'. protegeChaineOracle($adr_ens_nom_get) .'%\' ':'');
    }
   
    $res = executeReq($dbSigAdresse, $req);
    $tab = array();
    $message = '';
    //$message = $cdruru .' # '. $adr_num_voie;
    $message = '<table cellpadding=0 cellspacing=0>';
    $numeroCourant = '';
    while (list($ident, $adr_ens_lib_type, $adr_ens_nom, $adr_type_bati, $adr_bati_lib, $observations, $cdpsru, $lcomru, $adr_nvoir_comp_adr, $adr_num, $id_adr_loc) = $res->fetchRow())
    {
        if ($force == 1 && $numeroCourant != $adr_num)
        {
            $message .= '<tr><td colspan=2 bgcolor="#EEEEEE">'. htmlentitiesIso('N° '). '<strong>'.$adr_num .'</strong></td></tr>';
            $numeroCourant = $adr_num;
        }
        
        $txt = '';
        
        if ($adr_bati_lib == '0')
            $adr_bati_lib = '';
        if ($adr_ens_nom == '0')
            $adr_ens_nom = '';
        
        if ($adr_bati_lib != '')
        {
            $txt .= htmlentitiesIso($adr_type_bati .' '. $adr_bati_lib .' '. $observations);
            if ($adr_ens_nom != '')
                $txt .= ', '. htmlentitiesIso($adr_ens_lib_type .' '. $adr_ens_nom);
        }
        else
        {
            if ($adr_ens_nom != '')
                $txt .= htmlentitiesIso($adr_ens_lib_type .' '. $adr_ens_nom);
        }
        
        if ($adr_nvoir_comp_adr != '')
                $txt .= ' '. htmlentitiesIso($adr_nvoir_comp_adr);
       
        if (empty($txt))
        {
        	if ($observations != '')
                $txt .= ' '. htmlentitiesIso( $observations);
            else
                $txt = htmlentitiesIso('Non défini');
        }
                
        $adr_ens_nom = htmlentitiesIso($adr_ens_nom);
        $adr_ens_nom = str_replace("'", "\\\'", $adr_ens_nom);
        
        //$txt = htmlentitiesIso($txt);
        $txt = str_replace("\n", "", $txt);
        $txt = str_replace("\r", "", $txt);
        $txt = str_replace('\\n', ' ', $txt);
        $txt2 = str_replace("'", "\\\'", $txt);
        
        //$message .= htmlentitiesIso(' - N° '.$adr_num);
        $message .= '<tr><td><img align=absbottom src="'.$imageArrow.'"></td><td><a href="#" onclick="sigAdresseLoadInfoVoie(\''.$ident.'\', \''.$adr_num.'\', \''.$cdpsru.'\', \''. htmlentitiesIso($lcomru) .'\', \''. $adr_ens_nom .'\', \''. $txt2 .'\', \''. $id_adr_loc .'\');return false;">';
        $message .= $txt;
        $message .= '</a></td></tr>';

    }
    $message .= '</table>';
    
    if ($adr_num_voie != '')
    {
        $messageCh = '<img align=absbottom src="'.$imageOk.'">';
        echo 'window.document.getElementById(\'sig_adresse_sous_adressage\').innerHTML = \''.str_replace("'", "\'", $message).'\';';
        echo 'window.document.getElementById(\'sig_adresse_adr_num_voie_check\').innerHTML = \''.str_replace("'", "\'", $messageCh).'\';tooltip.init();';
    }

    if ($adr_ens_nom_get != '')
    {
        $messageCh = '<img align=absbottom src="'.$imageOk.'">';
        echo 'window.document.getElementById(\'sig_adresse_sous_adressage\').innerHTML = \''.str_replace("'", "\'", $message).'\';';
        echo 'window.document.getElementById(\'sig_adresse_adr_ens_nom_check\').innerHTML = \''.str_replace("'", "\'", $messageCh).'\';tooltip.init();';
    }
}
else
{
    if ($adr_num_voie != '')
    {
        $messageCh = '<img align=absbottom src="'.$imageKo.'"> Le num&eacute;ro <strong>'. $adr_num_voie .'</strong> n\'est pas r&eacute;pertori&eacute; ! <a href="javascript:sigAdresseVerifAdrNumVoie(\'1\');">Cliquez ici pour afficher toutes les adresses de la voie</a>';
        echo 'window.document.getElementById(\'sig_adresse_sous_adressage\').innerHTML = \'\';';
        echo 'window.document.getElementById(\'sig_adresse_adr_num_voie_check\').innerHTML = \''.str_replace("'", "\'", $messageCh).'\';tooltip.init();';
    }
    if ($adr_ens_nom_get != '')
    {
        $messageCh = '<img align=absbottom src="'.$imageKo.'"> L\'ensemble <strong>'. htmlentitiesIso($adr_ens_nom_get) .'</strong> n\'a pas &eacute;t&eacute; trouv&eacute;e ! <a href="javascript:sigAdresseVerifAdrNumVoie(\'1\');">Cliquez ici pour afficher toutes les adresses de la voie</a>';
        echo 'window.document.getElementById(\'sig_adresse_sous_adressage\').innerHTML = \'\';';
        echo 'window.document.getElementById(\'sig_adresse_adr_ens_nom_check\').innerHTML = \''.str_replace("'", "\'", $messageCh).'\';tooltip.init();';
    }
}

?>