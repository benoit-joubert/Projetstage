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

// Recuperation des informations en base de donnee
if (strlen($voie) > 0)
{
    // recuperation des information de l'adresse
    /*
    $req = 'SELECT CDRURU, ADRESSE';
    $req .= ' FROM V_ADR_ADRESSE_PRINC';
    $req .= ' WHERE lower(ADRESSE) like \''.strtolower($voie).'%\'';
    $req .= ' group by CDRURU, ADRESSE';
    $req .= ' order by ADRESSE';
    $req .= ' limit 0, 10';
    
    $req = getReqOracleLimitWidthMySqlLimit($req);
    */
    
    $req = 'SELECT CDRURU, VOIE';
    if (defined('ORACLE_GIS') == true && ORACLE_GIS == true)
    {
        $req .= ', SECTEUR';
    }
    else
    {
        $req .= ', SECTEUR, LIB_ZONE';
    }
    $req .= ' FROM SIGAIX.VR_LISTE_VOIES';
    $req .= ' WHERE lower(VOIE) like \'%'. strtolower(protegeChaineOracle($voie)) .'%\'';
    
    if (defined('ORACLE_GIS') == true && ORACLE_GIS == true)
    {
        $req .= ' group by CDRURU, VOIE, SECTEUR';
    }
    else
    {
        $req .= ' group by CDRURU, VOIE, SECTEUR, LIB_ZONE';
    }
    $req .= ' order by VOIE';
    $req .= ' limit 0, 10';
    $req = getReqOracleLimitWidthMySqlLimit($req);
    
    //$req =  'SELECT distinct CDRURU, ADR '.
    //        'FROM ERP_ERP '.
    //        'WHERE ADR like \''. protegeChaineOracle($adresse) .'%\'';
    
    //$res = executeReq($db, $req);
    
    
    $res = executeReq($dbSigAdresse, $req);
    $tab = array();
    while ($row = $res->fetchRow(DB_FETCHMODE_ASSOC))
    {
        $adresse = $row['VOIE'].' ('.$row['SECTEUR'];
        
        if (defined('ORACLE_GIS') == true && ORACLE_GIS == true) {} else
        {
            if (strlen($row['LIB_ZONE']) > 0)
            {
                $adresse .= ' - '.$row['LIB_ZONE'];
            }
        }

        
        $adresse .= ')';
        
        $tab[] = array(
            'CDRURU' => $row['CDRURU'],
            'ADRESSE' => $adresse,
        );
    }
}

function getCdataValue($value) {
   $retour = str_replace('&', '&amp;', $value); 
   $retour = str_replace('<', '&lt;', $value);
   $retour = '<![CDATA['.$retour.']]>';
   return $retour;
}

header('Content-Type: text/xml;charset=ISO-8859-1');
/*
echo '<?xml version=\'1.0\' encoding=\'UTF-8\' ?><options><option>bain</option><option>bal</option><option>balcon</option><option>balle</option><option>ballon</option><option>banc</option><option>bande</option><option>banque</option><option>barque</option><option>bas</option></options>';
die();
*/
echo "<?xml version='1.0' encoding='ISO-8859-1' ?>";
echo '<livesearch_resultat>';
echo '<requete>'.$voie.'</requete>';

echo '<resultats>';

if (is_array($tab) == true
    && count($tab) > 0)
{
    foreach ($tab as $value)
    {
        echo '<item>';
        echo '<cdruru>'.getCdataValue($value['CDRURU']).'</cdruru>';
        echo '<adresse>'.getCdataValue($value['ADRESSE']).'</adresse>';
        echo '</item>';
    }
}

echo '</resultats>';

echo '</livesearch_resultat>';




?>