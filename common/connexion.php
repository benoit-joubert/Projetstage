<?php
    /*********************
    * Connexion Mysql    *
    *********************/
    if ($PROD == 1)
    {
        if (SERVEUR_PROD == 'EADM') // depuis internet...
            $dbHost	= EADMBD_IP;
        else if (SERVEUR_PROD == 'EADM-SECURE') // depuis internet...
            $dbHost = EADM_SECUREBD_IP;
        else
            $dbHost	= SDELPHINUS_IP;
    }
    else
    {
        $dbHost	= '127.0.0.1';
    }
    $dbUser	= 'stats';
    $dbPass	= 'stats_password';
    $dbName	= 'stats_projets';
    $dbType = 'mysql';

	$dsn	= $dbType . '://' . $dbUser . ':' . $dbPass . '@' . $dbHost . '/' . $dbName;

	$dbLog 	= DB::connect($dsn, array('debug'=>true));
    
	if (DB::isError($dbLog))
	{
	    
	    if (substr(SERVEUR_PROD, 0, 4) == 'EADM') // depuis internet...
	    {
    	    die('<font size=3><b>L</b></font>e site reçoit actuellement trop de connexions...<br><br>
        L\'accès au site est temporairement coupé.<br><br>
        Veuillez <a onclick="javascript:window.location.reload();" href="#"><strong>cliquez ici</strong></a> dans quelques minutes pour tenter d\'accéder à la page demandée.<br><br>
        Merci de votre compréhension,<br><br>
        Le <b>W</b>ebmaster'
    	        );
    	}
    	else
    	    die('<strong><font color="red">Erreurs critiques</font></strong> :<br><br>'.
    	        '- Le serveur <b>'.SERVEUR_PROD.'</b> n\'arrive pas à contacter le serveur de base de données <b>sdelphinus.intranet</b> => Contactez le service informatique (<b>94.42</b>) en indiquant ce message d\'erreur.<br>'
    	        );
	}
	else
	{
	    // On log les accès au common
	    $projetIdPrecedent = '';
	    if (isset($PROJET_ID))
	    {
	        $projetIdPrecedent = $PROJET_ID;
	    }
	    $PROJET_ID = 15; // Common
	    $tempsDebut = time();
	    $stats_id = logPage('', 15);
	    if ($stats_id != '')
	    {
	        $tempsFin = time();
	        $t = number_format($tempsFin - $tempsDebut, 4, '.', '');
	        executeReq($dbLog, 'update `stats` set `stats_page_time`=\''.$t.'\' where `stats_id`=\''. $stats_id .'\'', false);
	    }
	    $PROJET_ID = $projetIdPrecedent;
	    // Fin du log common
	}
?>