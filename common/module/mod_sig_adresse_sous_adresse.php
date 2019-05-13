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


$imageArrow = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAMAAADXT/YiAAAAB3RJTUUH0wgIDSATtFhRIAAAAAlwSFlzAAALEgAACxIB0t1+/AAAAARnQU1BAACxjwv8YQUAAAAGUExURf////+EALS1utwAAAABdFJOUwBA5thmAAAAGUlEQVR42mNgwA4YESxGBIsRwWLEFEPVCwACjAARsqp7+wAAAABJRU5ErkJggg==';

/////////////////////////

if (isset($_GET['cdruru'])) {
    $cdruru = $_GET['cdruru'];
} else {
    $cdruru = '';
}

if (isset($_GET['adr_num_voie'])) {
    $adr_num_voie = $_GET['adr_num_voie'];
} else {
    $adr_num_voie = '';
}

if (isset($_GET['adr_ens_nom'])) {
    $adr_ens_nom_get = strtoupper($_GET['adr_ens_nom']);
} else {
    $adr_ens_nom_get = '';
}

if (isset($_GET['force'])) {
    $force = $_GET['force'];
} else {
    $force = '';
}

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
        $txt2 = str_replace("'", "\\\'", $txt);

        //$message .= htmlentitiesIso(' - N° '.$adr_num);
        $message .= '<tr><td><img align=absbottom src="'.$imageArrow.'"></td><td><a href="#" onclick="sigAdresseLoadInfoVoie(\''.$ident.'\', \''.$adr_num.'\', \''.$cdpsru.'\', \''. htmlentitiesIso($lcomru) .'\', \''. $adr_ens_nom .'\', \''. $txt2 .'\', \''. $id_adr_loc .'\');return false;">';
        $message .= $txt;
        $message .= '</a></td></tr>';

    }
    $message .= '</table>';

    if ($adr_num_voie != '')
    {
        $messageCh = '<img align=absbottom src=images/icon-16-checkin.png>';
        echo 'window.document.getElementById(\'sig_adresse_sous_adressage\').innerHTML = \''.str_replace("'", "\'", $message).'\';';
        echo 'window.document.getElementById(\'sig_adresse_adr_num_voie_check\').innerHTML = \''.str_replace("'", "\'", $messageCh).'\';tooltip.init();';
    }

    if ($adr_ens_nom_get != '')
    {
        $messageCh = '<img align=absbottom src=images/icon-16-checkin.png>';
        echo 'window.document.getElementById(\'sig_adresse_sous_adressage\').innerHTML = \''.str_replace("'", "\'", $message).'\';';
        echo 'window.document.getElementById(\'sig_adresse_adr_ens_nom_check\').innerHTML = \''.str_replace("'", "\'", $messageCh).'\';tooltip.init();';
    }
}
else
{
    if ($adr_num_voie != '')
    {
        $messageCh = '<img align=absbottom src=images/icon-16-checkno.png> Le num&eacute;ro <strong>'. $adr_num_voie .'</strong> n\'est pas r&eacute;pertori&eacute; ! <a href="javascript:sigAdresseVerifAdrNumVoie(\'1\');">Cliquez ici pour afficher toutes les adresses de la voie</a>';
        echo 'window.document.getElementById(\'sig_adresse_sous_adressage\').innerHTML = \'\';';
        echo 'window.document.getElementById(\'sig_adresse_adr_num_voie_check\').innerHTML = \''.str_replace("'", "\'", $messageCh).'\';tooltip.init();';
    }
    if ($adr_ens_nom_get != '')
    {
        $messageCh = '<img align=absbottom src=images/icon-16-checkno.png> L\'ensemble <strong>'. htmlentitiesIso($adr_ens_nom_get) .'</strong> n\'a pas &eacute;t&eacute; trouv&eacute;e ! <a href="javascript:sigAdresseVerifAdrNumVoie(\'1\');">Cliquez ici pour afficher toutes les adresses de la voie</a>';
        echo 'window.document.getElementById(\'sig_adresse_sous_adressage\').innerHTML = \'\';';
        echo 'window.document.getElementById(\'sig_adresse_adr_ens_nom_check\').innerHTML = \''.str_replace("'", "\'", $messageCh).'\';tooltip.init();';
    }
}

?>