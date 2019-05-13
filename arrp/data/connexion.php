<?php
	/*********************
    * Connexion Oracle   *
    *********************/
    if ($PROD === 1){
        $dbHost	= 'sigprod';            // Adresse serveur
        $dbUser	= 'equipements';                     // Login
        $dbPass	= 'Sig6ForEqu';                       // Password
        $dbName	= '';                           // Nom de la base
        $dbType = 'oci8';                       // Type de la base de donnée
    }else{
        $dbHost	= 'sigtest';
        $dbUser	= 'equipements';
        $dbPass	= 'Sig6ForEqu';
        $dbName	= '';
        $dbType = 'oci8';
    }
    //$dbHost	= 'sigprod';
	
	$dsn	= $dbType . '://' . $dbUser . ':' . $dbPass . '@' . $dbHost . '/' . $dbName;
    $db = DB::connect($dsn, array('debug'=>true, 'portability' => MDB2_PORTABILITY_NONE));
	if (DB::isError($db))
	{
	    $MODE_MAINTENANCE = true;
		$test = new Erreur('Erreur d\'acc&egrave;s &agrave; la base de données Oracle',$db->getDebugInfo());
	}
    executeReq($db,'alter session set nls_date_format=\'DD/MM/YYYY\'');
    executeReq($db,'alter session set nls_numeric_characters=\'.,\'');
    executeReq($db,'alter session set nls_comp=\'linguistic\'');
    executeReq($db,'alter session set nls_sort=\'binary_ci\'');

?>