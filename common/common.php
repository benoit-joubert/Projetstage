<?php
    function getMicroTimeCommon()
    {
    	list($usec, $sec) = explode(" ",microtime()); 
    	return ((float)$usec + (float)$sec); 
    }
    
    $tabTempsDesPages = array(
                                'common_start' => getMicroTimeCommon(),
                             );
    
    
    // Liste des serveurs de production
    $serveurProd = array(   'sigweb.mairie-aixenprovence.fr',
                            'webdsi.intranet',
                            'web1.intranet',
                            'web2.intranet',
                            'sproxyma.intranet',
                            'ssarin.intranet',
                            'ipp.intranet',
                            'sneptune.intranet',
                            'smagellan.intranet',
                            'aixbox.mairie-aixenprovence.fr',
                            'eadministration.mairie-aixenprovence.fr',
                            'eadm-secure.mairie-aixenprovence.fr',
                            );
    
    define('SHERA_IP', '10.128.4.13');
    define('SDAUPHIN_IP', '10.128.4.9'); // sdauphin.intranet = spolaris.intranet
    define('SARRAKIS_IP', '10.128.4.10'); // sarrakis.intranet <=> web1.intranet
    define('SARRAKIS2_IP', '10.128.4.12'); // sarrakis2.intranet <=> web2.intranet
    define('SARRAKISBD_IP', '10.128.4.232'); // serveur de base de données MYSQL
    define('SDELPHINUS_IP', '10.128.4.54'); // sdelphinus.intranet = serveur de base de données MYSQL
    define('SERVEUR_SOURCE_IP', '10.128.4.40'); // IP serveur de source
    define('EADMBD_IP', '192.168.50.6'); // IP de la BDD sur eadm
    define('EADM_SECUREBD_IP', '192.168.50.200'); // IP de la BDD sur eadm-secure
    define('IP_FROM_INTERNET', '192.168.60.'); // IP des visiteurs qui proviennent d'internet ATTENTION il existe apparement 192.168.60.
    
    $tabDesPagesEnHTTPS = array(); // contient les pages qui doivent etre en HTTPS
    
    $PRODTEST = 0;
    $dbSigAdresse = '';
    
    if (isset($_SERVER['SERVER_NAME']))
        $serveurName = $_SERVER['SERVER_NAME'];
    else
        $serveurName = 'INCONNU';

    if (isset($_SERVER['SERVER_ADDR']))
        $serveurAddr = $_SERVER['SERVER_ADDR'];
    else
        $serveurAddr = '';

    if (strlen($serveurAddr) == 13 && substr($serveurAddr, 0, 12) == '192.168.50.3') // eadm-web0 / eadm-web1 / eadm-web2
        $serveurName = 'eadm-secure.mairie-aixenprovence.fr';

    if ($serveurName == '192.168.50.5')
        $serveurName = 'aixbox.mairie-aixenprovence.fr';

    if ($serveurName == SARRAKIS2_IP)
        $serveurName = 'web2.intranet';
   
    // Test pour savoir si la personne vient d'internet ou non
    if ((isset($_SERVER['HTTP_VIA']) &&
        $_SERVER['HTTP_VIA'] != '' &&
        substr_count($_SERVER['HTTP_VIA'], '.mairie-aixenprovence.fr') > 0)
        ||
        (isset($_SERVER['HTTP_X_FORWARDED_SERVER']) &&
        $_SERVER['HTTP_X_FORWARDED_SERVER'] != '' &&
        substr_count($_SERVER['HTTP_X_FORWARDED_SERVER'], '.mairie-aixenprovence.fr') > 0)
        )
    {
        define('USER_FROM_INTERNET', '1');
    }
    else
        define('USER_FROM_INTERNET', '0');
    
    //echo substr(str_replace('.', '', phpversion()), 0, 3).']';
    if (substr(str_replace('.', '', phpversion()), 0, 3) >= 530)
    {
        $USE_PEAR2 = true;
        //echo 'here';
    }
    if (in_array($serveurName, $serveurProd) || 
        strpos($serveurName, '.prod.intranet') > 0 || 
        strpos($serveurName, '.test.intranet') > 0 || 
        strpos($serveurName, 'ww.intranet') > 0)
    {
        // On est sur un serveur en Production
        $PROD = 1;
        if (in_array($serveurName, $serveurProd)) // Si c'est un serveur de production
        {
            /*if ($serveurName == 'sgeo.intranet') // SGEO
            {
                define('RACINE', 'd:/sigweb');
                define('SERVEUR_PROD', 'SGEO');
                define('SERVEUR_PROD_ID', '');
            }
            else*/
            if ($serveurName == 'starentule.intranet') // STARENTULE
            {
                define('RACINE', 'r:/sigweb');
                define('SERVEUR_PROD', 'STARENTULE');
                define('SERVEUR_PROD_ID', '6');
                $USE_PEAR2 = true; // inclusion de PEAR 2
            }
            else if ($serveurName == 'sproxyma.intranet' || $serveurName == 'ipp.intranet') // SPROXYMA
            {
                define('RACINE', 'r:/web');
                define('SERVEUR_PROD', 'SPROXYMA');
                define('SERVEUR_PROD_ID', '4');
            }
            else if ($serveurName == 'ssarin.intranet') // SSARIN
            {
                define('RACINE', 'c:/data1/web');
                define('SERVEUR_PROD', 'SSARIN');
                define('SERVEUR_PROD_ID', '4');
            }
            else if ($serveurName == 'sneptune.intranet') // SNEPTUNE
            {
                define('RACINE', '/srv/www/htdocs');
                define('SERVEUR_PROD', 'SNEPTUNE');
                define('SERVEUR_PROD_ID', '5');
            }/*
            else if ($serveurName == 'smagellan.intranet') // SMAGELLAN
            {
                define('RACINE', 'r:/sigweb');
                define('SERVEUR_PROD', 'SMAGELLAN');
                define('SERVEUR_PROD_ID', '6');
            }*/
            else if ($serveurName == 'sigweb.mairie-aixenprovence.fr') // SSARGAS
            {
                define('RACINE', 'd:/sigweb');
                define('SERVEUR_PROD', 'SSARGAS');
            }
            else if ($serveurName == 'aixbox.mairie-aixenprovence.fr') // EADM AIXBOX
            {
                define('RACINE', '/data1/web');
                define('SERVEUR_PROD', 'EADM');
                define('SERVEUR_PROD_ID', '8');
                define('FROM_INTRANET', '1');
            }
            else if ($serveurName == 'eadministration.mairie-aixenprovence.fr') // EADM EADMINISTRATION
            {
                define('RACINE', '/data1/web');
                define('SERVEUR_PROD', 'EADM');
                define('SERVEUR_PROD_ID', '8');
                define('FROM_INTRANET', '0');
            }
            else if ($serveurName == 'eadm-secure.mairie-aixenprovence.fr') // EADM EADMINISTRATION SECURISE
            {
                define('RACINE', '/data1/web');
                define('SERVEUR_PROD', 'EADM-SECURE');
                define('SERVEUR_PROD_ID', '10');
                /*define('RACINE', '/data1/websecure');
                define('SERVEUR_PROD', 'EADM-SECURE');
                define('SERVEUR_PROD_ID', '10');
                define('FROM_INTRANET', '0');*/
            }
            else if ($serveurName == 'web1.intranet') // SARRAKIS = ANCIEN SPOLARIS
            {
                define('RACINE', '/data1/web');
                define('SERVEUR_PROD', 'SARRAKIS');
                define('SERVEUR_PROD_ID', '2');
                define('SERVEUR_URL_RACINE', 'http://web1.intranet');
//                $tabDesPagesEnHTTPS[] = 'C_AJAX';
            }
            else if ($serveurName == 'web2.intranet') // web2.intranet => SARRAKIS2
            {
                define('RACINE', '/data1/web');
                define('SERVEUR_PROD', 'SARRAKIS2');
                define('SERVEUR_PROD_ID', '9');
                define('SERVEUR_URL_RACINE', 'http://web2.intranet');
//                $tabDesPagesEnHTTPS[] = 'C_AJAX';
            }
            /*else if ($serveurName == '192.168.50.31') // eadm-web0
            {
                define('RACINE', '/data1/web');
                define('SERVEUR_PROD', 'EADM-WEB0');
                define('SERVEUR_PROD_ID', '11');
            }
            else if ($serveurName == '192.168.50.32') // eadm-web1
            {
                define('RACINE', '/data1/web');
                define('SERVEUR_PROD', 'EADM-WEB1');
                define('SERVEUR_PROD_ID', '12');
            }*/
            else // SHERA
            {
                die('vieux serveur de production SHERA');
                //define('RACINE', 'd:/web');
                //define('SERVEUR_PROD', 'SHERA');
                //define('SERVEUR_PROD_ID', '1');
            }
            
            define('COMMON_PATH', RACINE .'/common');
            //define('SERVEUR_PROD', 'SHERA');
        }
        else // SPOLARIS
        {
            if (strpos($serveurName, '.prod.intranet') > 0 ||
                strpos($serveurName, 'ww.intranet') > 0)
            {
                define('RACINE', '/data1/web'); // PROD
                define('SERVEUR_PROD_ID', '2');
            }
            else // alors on est en test
            {
                define('RACINE', '/data1/webtest'); // TEST
                $PRODTEST = 1;
                define('SERVEUR_PROD_ID', '3');
            }
            define('COMMON_PATH', RACINE .'/common');
            define('SERVEUR_PROD', 'SPOLARIS');
        }
    }
    else
    {
        //print_r($_SERVER);
        // On est sur un serveur en Préproduction ou en local
        $PROD = 0;
        if (!defined('RACINE'))
            define('RACINE', isset($_SERVER['DOCUMENT_ROOT']) ? $_SERVER['DOCUMENT_ROOT']:'D:/sigweb');
        define('COMMON_PATH', RACINE . '/common');
        define('SERVEUR_PROD', 'LOCAL');
//         define('SERVEUR_PROD', 'SARRAKIS');
        define('SERVEUR_PROD_ID', '7');
//        $tabDesPagesEnHTTPS[] = 'C_AJAX';
        define('SERVEUR_URL_RACINE', 'http://127.0.0.1');
    }
    
    define('COMMON_MODULE_PATH', COMMON_PATH . '/module');
    
    //if((SERVEUR_PROD == 'STARENTULE') || (isset($USE_PEAR2) && $USE_PEAR2 == 1))
    if (isset($USE_PEAR2) && $USE_PEAR2 == true)
        define('PEAR_PATH',COMMON_PATH.'/PEAR2');
    else
        define('PEAR_PATH',COMMON_PATH.'/PEAR');

    $tabTempsDesPages['common_modules_start'] = getMicroTimeCommon();
    
    /* Class Page qui permet d'ajouter header / footer facilement */
    require(COMMON_PATH .'/dsi/class_page/1.0/class_page.php');
    
    /* Class Projet qui permet de gérer les projets sur la base mysql de shera */
    require(COMMON_PATH .'/dsi/class_projet/1.0/class_projet.php');
    $gestionProjet = new GestionProjet();
    
    /* Class Erreur qui génère une erreur lors d'une requete SQL */
    require(COMMON_PATH .'/dsi/class_erreur/1.0/class_erreur.php');
    
    /* Class mail_perso qui permet d'envoyer un mail */
    require(COMMON_PATH .'/dsi/class_mail_perso/1.0/class_mail_perso.php');
    
    /* Class objet_bdd qui permet de créer des objets php représentant les tables d'une base de données */
    require(COMMON_PATH .'/dsi/class_objet_bdd/1.0/class_objet_bdd.php');
    
    /* Class class_ldap qui permet d'authentifier une personne ou d'accéder à des objets */
    require(COMMON_PATH .'/dsi/class_ldap/1.0/class_ldap.php');
    
    /* Class class_graph qui permet de générer des images en 3D pour les stats */
    require(COMMON_PATH .'/dsi/class_graph/1.0/class_graph.php');
    
    /* Class generate_module qui permet de créer des module PHP (list, ajout, ajout_save) représentant les tables d'une base de données */
    require(COMMON_PATH .'/dsi/class_generate_module/1.0/class_generate_module.php');
    
    /* Class class_table qui permet de générer des tableaux pour le design v2 */
    if (!(isset($DONT_LOAD_CLASS_TABLE) && $DONT_LOAD_CLASS_TABLE == 1))
        require(COMMON_PATH .'/dsi/class_table/1.0/class_table.php');
    
    /* Fichier de fonctions communes à tous les projets DSI */
    require(COMMON_PATH .'/dsi/lib/1.0/lib.php');
    
    /* Class contenant les fonctions du common */
    require(COMMON_PATH .'/dsi/class_common.php');
    
    /* Class pour générer des fichier RSS */
    require(COMMON_PATH .'/dsi/class_rss.php');
    
    /* Class de connexion aux BDD */
    if (PEAR_PATH == COMMON_PATH.'/PEAR2')
    {
        require(PEAR_PATH .'/MDB2.php');
        define('DB_FETCHMODE_ASSOC', MDB2_FETCHMODE_ASSOC);
    }
    else
        require(PEAR_PATH .'/DB.php');
    
    /* Class pour traiter des flux XML */
    require(PEAR_PATH .'/Serializer.php');
    require(PEAR_PATH .'/Unserializer.php');

    /* Class pour envoyer les mails */
    require(PEAR_PATH .'/Mail.php');
    require(PEAR_PATH .'/Mail/mime.php');
    
    /* Class pour convertir les nombres en lettre */
    require(PEAR_PATH .'/Numbers/Words.php');
    
    /* Classe pour générer des fichiers EXCEL */
     define('PHPEXCEL_PATH', COMMON_PATH .'/phpexcel/1.6.6/Classes'); // Répertoire contenant la class phpexcel
//     define('PHPEXCEL_PATH', COMMON_PATH .'/phpexcel/1.7.6/Classes'); // Répertoire contenant la class phpexcel
//    define('PHPEXCEL_PATH', COMMON_PATH .'/phpexcel/1.7.9/Classes'); // Répertoire contenant la class phpexcel
    
    /* Fichier pour créer les graphique en flash */
    define('CHARTS_PATH', COMMON_PATH .'/flash/charts/charts_4.5'); // Répertoire contenant la class snoopy
    require(CHARTS_PATH .'/charts.php');
    
    /* Snoopy */
    define('SNOOPY_PATH', COMMON_PATH .'/snoopy/1.2.3'); // Répertoire contenant la class snoopy
    
    /* PDF */
    define('FPDF_FONTPATH', COMMON_PATH .'/pdf/fpdf/font/'); // Répertoire commun des fonts
    require(COMMON_PATH . '/pdf/fpdf/fpdf_1.6/fpdf.php'); // class générant les PDF
    require(COMMON_PATH . '/pdf/fpdf/script/fpdf_js.php'); // Javascript dans un fichier PDF
    require(COMMON_PATH . '/pdf/fpdf/script/js_form.php'); // Formulaire dans un fichier PDF
    require(COMMON_PATH . '/pdf/fpdf/script/fpdf_protection.php'); // Protéger un fichier PDF
    require(COMMON_PATH . '/pdf/fpdf/script/etiquettes.php'); // Générer des étiquettes dans un fichier PDF
    require(COMMON_PATH . '/pdf/fpdf/script/fpdf_gradients.php'); // Générer des dégradés de couleurs
    require(COMMON_PATH . '/pdf/fpdf/dsi/fpdf_mairie.php'); // Générer des PDF de type Mairie
    define('PARAGRAPH_STRING', '~~~');
    require(COMMON_PATH . '/pdf/fpdf/script/class.multicelltag.php'); // Générer des dégradés de couleurs
    require(COMMON_PATH . '/pdf/fpdf/dsi/fpdf_mairie_2.php'); // Nouvelle version de PDF_Mairie
    require(COMMON_PATH . '/pdf/fpdf/script/etiquettes_tag.php'); // Générer des étiquettes avec des balises HTML
    
//     require(COMMON_PATH . '/pdf/FPDI_1.3.1/fpdi.php'); // Concatener des PDF
    require(COMMON_PATH . '/pdf/FPDI-1.4.2/fpdi.php'); // Concatener des PDF
    
    require(COMMON_PATH . '/image/phpqrcode/qrlib.php'); // Concatener des PDF
    
    /* TCPDF */
    if (defined('NO_TCPDF_REQUIRE') == true && NO_TCPDF_REQUIRE == true) {}
    else
    {
        //require(COMMON_PATH . '/pdf/tcpdf/tcpdf.php'); // class générant les PDF nouvelle version
    }

    /* RTF */
    define('PHPRTFLITE_PATH', COMMON_PATH .'/phprtflite/rtf/'); // Répertoire contenant les class rtf
    
    /* JGRAPH */
    if (substr(phpversion(), 0, 1) == '5') // Inclusion de JPGRAPH pour PHP 5
        define('JGRAPH_PATH', COMMON_PATH .'/image/jpgraph/jpgraph-2.1.4/src');
    else // php 4
        define('JGRAPH_PATH', COMMON_PATH .'/image/jpgraph/jpgraph_1.20.4a/src');

    /* EXCEL */
    define('EXCEL_PATH', COMMON_PATH .'/excel');
    
    /* LIBRAIRIE JAVASCRIPT */
    if (SERVEUR_PROD == 'EADM') // depuis internet...
        define('JS_URL', 'http://eadministration.mairie-aixenprovence.fr/js');
    else if (SERVEUR_PROD == 'EADM-SECURE') // depuis internet...
        define('JS_URL', '../js');
    else
    {
        if ($PROD == 1)
        {
            if (SERVEUR_PROD == 'SARRAKIS2')
            {
                //define('JS_URL', 'http://web2.intranet/js');
                define('JS_URL', '../js');
            }
            else
            {
                //define('JS_URL', 'http://web1.intranet/js');
                define('JS_URL', '../js');
            }
        }
        else
        {
            if (isset($_SERVER['SERVER_NAME']))
            {
                define('JS_URL', '../js');
                //define('JS_URL', 'http://'.$_SERVER['SERVER_NAME'].'/js');
            }
            else
                define('JS_URL', 'http://web1.intranet/js');
        }
    }
	
    define('JS_FORMCHECK_URL', JS_URL.'/formcheck');
    define('JS_MOORAINBOW_URL', JS_URL.'/moorainbow');
    define('JS_DTREE_URL', JS_URL.'/dtree');
    define('JS_EXTJS_URL', JS_URL.'/extjs');
    define('JS_AMCHARTS_URL', JS_URL.'/amcharts');
    define('JS_MOOTOOLS_URL', JS_URL.'/mootools');
    define('JS_CALENDAR_URL', JS_URL.'/js-calendar/1.9');
    define('JS_JQUERY_MOBILE', JS_URL.'/jquery.mobile-1.0.1');
    //define('JS_JQUERY_UI_URL', JS_URL.'/jquery-ui-1.8.22.custom');
    define('JS_JQUERY_UI_URL', JS_URL.'/jquery-ui-1.10.0.custom');
    
    define('JS_SIG_ADRESSE_URL', JS_URL.'/sig_outils');
    define('JS_BOOTSTRAP_URL', JS_URL.'/bootstrap');
    define('JS_JQUERY_ADDON_URL', JS_URL.'/jquery-addon');
    
    /* XMPP => Utiliser pour interagir avec le serveur de messagerie instantanné EJabberd */
    define('XMPPHP_PATH', COMMON_PATH .'/xmpphp');
    require(XMPPHP_PATH."/xmpp.php");
    
    /* SIG => classe qui affiche les cartes */
    require(COMMON_PATH . '/dsi/sig/class_sigmap.php');
    
    // Pour gérer les sites qui sont en mode maintenance
    $fichierMaintenance = COMMON_PATH.'/data/config_maintenance.php';
    if (file_exists($fichierMaintenance))
        @include($fichierMaintenance);
    if (!isset($tabSiteEnMaintenance))
        $tabSiteEnMaintenance = array();
    // Fin du mode maintenance
    
    $tabTempsDesPages['common_modules_end'] = getMicroTimeCommon();
    
    if (isset($_GET['action']) && $_GET['action'] == 'CONNECT' && isset($_GET['i']) && isset($_GET['ticket']))
    {
        if (!$gestionProjet->isConnected())
            $gestionProjet->connexion();
        
        $AUTO_CONNECT = 1; // pour rediriger la page au lieu de l'afficher (mod_connexion_ldap_ajax_reponse.php)
        //echo 'ee';
        // vérification si le ticket est bon
        if ($gestionProjet->isTicketCorrect($_GET['i'], $_GET['ticket']))
        {
            
            
            if ($gestionProjet->getTicketAction() == 'ldap') // connexion ldap standard
            {
                $_POST['agent_login']       = $gestionProjet->getTicketLogin();
                $_POST['agent_password']    = $gestionProjet->getTicketPassword();
                $_POST['action']            = 'connexionldap';
                $_POST['P']                 = 'C_AJAX_REPONSE';
            }
            else if ($gestionProjet->getTicketAction() == 'oracle') // connexion entre les appli à charles (RH)
            {
                $_POST['utilisateur']           = $gestionProjet->getTicketLogin();
                $_POST['utilisateur_password']  = $gestionProjet->getTicketPassword();
                $_POST['action']                = 'connexion';
            }
            else
            {
                
            }
            // Effacement du ticket
            //$dbProjet->deleteTicket($_GET['i']);
        }
        else
        {
            // pas le bon ticket, on redirige
            //header('Location: index.php');
            //exit;
            echo '<html><head><title>Redirection...</title><meta http-equiv="refresh" content="2; URL=index.php"></head><body>Erreur de connexion ticket invalide...</body></html>';
            exit;
        }
        
    }
    
    if ($PROD == 0) // on est sur un serveur de préproduction
    {
        $fichierCommonCheck = COMMON_PATH.'/data/common_check.php';
        if (file_exists($fichierCommonCheck))
            @include($fichierCommonCheck);
        $lastCommonCheck = isset($LAST_COMMON_CHECK_TIME) ? $LAST_COMMON_CHECK_TIME:0;
        $lastCommonCheckResult = isset($LAST_COMMON_CHECK_RESULT) ? $LAST_COMMON_CHECK_RESULT:'';
        $lanceCheck = false;
        if (time() - $lastCommonCheck > 43200) // => 12 heures
        {
            $lanceCheck = true;
        }
        else
        {
            // on a fait le test il y a moins de 12 heures, on refait le test si le résultat indique que le common n'est pas à jour
            if ($lastCommonCheckResult == 'common_non_a_jour' || $lastCommonCheckResult == 'svn_client_too_old')
            {
                $lanceCheck = true;
            }
        }
        
        // Vérification si l'on a le PROJET_ID de défini et qu'il correspond à phpmyadmin (PROJET_ID=42)
        if (!(isset($PROJET_ID) && $PROJET_ID == 42))
        {
            if ($lanceCheck == true)
            {
                // on vérifie si le common est à jour
                $isAJour = isLocalDirectoryUpdatedToLastRevision(COMMON_PATH);
                if ($isAJour == 'common_non_a_jour' || $isAJour == 'svn_client_too_old')
                {
                    $P = 'CNAJ';
                }
                $LAST_COMMON_CHECK_TIME = time();
                $LAST_COMMON_CHECK_RESULT = $isAJour;
                
                $chFic =    '<?'."\n".
                            '// NE PAS EDITER, FICHIER GENERE AUTOMATIQUEMENT PAR LE COMMON'."\n".
                            '$LAST_COMMON_CHECK_TIME = '. $LAST_COMMON_CHECK_TIME .'; // '. date('d/m/Y à H:i:s', $LAST_COMMON_CHECK_TIME) ."\n".
                            '$LAST_COMMON_CHECK_RESULT = \''. protegeChaine($LAST_COMMON_CHECK_RESULT) .'\';'."\n".
                            '?>';
                $f = @fopen($fichierCommonCheck, 'w');
                if ($f)
                {
                    fwrite($f, $chFic);
                    fclose($f);
                }
                
            }
        }
    }
    
    /* Chargement de l'objet de log */
    if ($PROD == 1 && !isset($NO_LOG) && $serveurName != 'sigweb.mairie-aixenprovence.fr')
    {
        $tabTempsDesPages['common_stats_connexion_start'] = getMicroTimeCommon();
        require(COMMON_PATH .'/connexion.php');
        $tabTempsDesPages['common_stats_connexion_end'] = getMicroTimeCommon();
    }
    
    $tabTempsDesPages['common_end'] = getMicroTimeCommon();
    
?>