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
                            'sproxyma.intranet',
                            'ipp.intranet',
                            'sneptune.intranet',
                            'smagellan.intranet',
                            'starentule.intranet',
                            'aixbox.mairie-aixenprovence.fr',
                            );
    
    define('SHERA_IP', '10.128.4.13');
    define('SDAUPHIN_IP', '10.128.4.9'); // sdauphin.intranet = spolaris.intranet
    define('SARRAKIS_IP', '10.128.4.10'); // sarrakis.intranet
    define('SDELPHINUS_IP', '10.128.4.54'); // sdelphinus.intranet = serveur de base de données MYSQL
    define('SERVEUR_SOURCE_IP', '10.128.4.40'); // IP serveur de source
    define('EADMBD_IP', '192.168.50.6');
    define('IP_FROM_INTERNET', '192.168.60.'); // IP des visiteurs qui proviennent d'internet ATTENTION il existe apparement 192.168.60.
    
    $tabDesPagesEnHTTPS = array(); // contient les pages qui doivent etre en HTTPS
    
    $PRODTEST = 0;
    
    if (isset($_SERVER['SERVER_NAME']))
        $serveurName = $_SERVER['SERVER_NAME'];
    else
        $serveurName = 'INCONNU';
    
    if ($serveurName == '192.168.50.5')
        $serveurName = 'aixbox.mairie-aixenprovence.fr';
   
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
    
    if (in_array($serveurName, $serveurProd) || 
        strpos($serveurName, '.prod.intranet') > 0 || 
        strpos($serveurName, '.test.intranet') > 0 || 
        strpos($serveurName, 'ww.intranet') > 0)
    {
        // On est sur un serveur en Production
        $PROD = 1;
        if (in_array($serveurName, $serveurProd)) // Si c'est un serveur de production
        {
            if ($serveurName == 'sproxyma.intranet' || $serveurName == 'ipp.intranet') // SPROXYMA
            {
                define('RACINE', 'r:/web');
                define('SERVEUR_PROD', 'SPROXYMA');
                define('SERVEUR_PROD_ID', '4');
            }
            else if ($serveurName == 'sneptune.intranet') // SNEPTUNE
            {
                define('RACINE', '/srv/www/htdocs');
                define('SERVEUR_PROD', 'SNEPTUNE');
                define('SERVEUR_PROD_ID', '5');
            }
            else if ($serveurName == 'smagellan.intranet') // SMAGELLAN
            {
                define('RACINE', 'r:/sigweb');
                define('SERVEUR_PROD', 'SMAGELLAN');
                define('SERVEUR_PROD_ID', '6');
            }
            else if ($serveurName == 'starentule.intranet') // STARENTULE
            {
                define('RACINE', 'r:/sigweb');
                define('SERVEUR_PROD', 'STARENTULE');
                define('SERVEUR_PROD_ID', '6');
            }
            else if ($serveurName == 'sigweb.mairie-aixenprovence.fr') // SSARGAS
            {
                define('RACINE', 'd:/sigweb');
                define('SERVEUR_PROD', 'SSARGAS');
            }
            else if ($serveurName == 'aixbox.mairie-aixenprovence.fr') // SSARGAS
            {
                define('RACINE', '/data1/web');
                define('SERVEUR_PROD', 'EADM');
                define('SERVEUR_PROD_ID', '8');
            }
            else // SARRAKIS = ANCIEN SPOLARIS
            {
                define('RACINE', '/data1/web');
                define('SERVEUR_PROD', 'SARRAKIS');
                define('SERVEUR_PROD_ID', '2');
                define('SERVEUR_URL_RACINE', 'http://web1.intranet');
//                $tabDesPagesEnHTTPS[] = 'C_AJAX';
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
        define('RACINE', isset($_SERVER['DOCUMENT_ROOT']) ? $_SERVER['DOCUMENT_ROOT']:'D:/sigweb');
        define('COMMON_PATH', RACINE . '/common');
        define('SERVEUR_PROD', 'LOCAL');
        define('SERVEUR_PROD_ID', '7');
//        $tabDesPagesEnHTTPS[] = 'C_AJAX';
//        define('SERVEUR_URL_RACINE', 'http://127.0.0.1');
    }
    
    define('COMMON_MODULE_PATH', COMMON_PATH . '/module');
    
    if((SERVEUR_PROD == 'STARENTULE') || (isset($PEAR2) && $PEAR2 == 1))
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
    if(PEAR_PATH == COMMON_PATH.'/PEAR2')
        require(PEAR_PATH.'/MDB2.php');
    else
        require(PEAR_PATH.'/DB.php');
    
    /* Class pour traiter des flux XML */
    require(PEAR_PATH.'/Serializer.php');
    require(PEAR_PATH.'/Unserializer.php');

    /* Class pour envoyer les mails */
    require(PEAR_PATH.'/Mail.php');
    require(PEAR_PATH.'/Mail/mime.php');
    
    /* Class pour convertir les nombres en lettre */
    require(PEAR_PATH.'/Numbers/Words.php');
    
    /* Classe pour générer des fichiers EXCEL */
    define('PHPEXCEL_PATH', COMMON_PATH .'/phpexcel/1.6.6/Classes'); // Répertoire contenant la class phpexcel
    
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
    require(COMMON_PATH . '/pdf/fpdf/script/etiquettes_tag.php'); // Générer des étiquettes avec des balises HTML
    if(PEAR_PATH == COMMON_PATH.'/PEAR2')
        require(COMMON_PATH . '/pdf/FPDI-1.4.2/fpdi.php'); // Concatener des PDF
    else
        require(COMMON_PATH . '/pdf/FPDI_1.3.1/fpdi.php'); // Concatener des PDF
    
    /* RTF */
    define('PHPRTFLITE_PATH', COMMON_PATH .'/phprtflite/rtf/'); // Répertoire contenant la class snoopy
    
    /* JGRAPH */
    if (substr(phpversion(), 0, 1) == '5') // Inclusion de JPGRAPH pour PHP 5
        define('JGRAPH_PATH', COMMON_PATH .'/image/jpgraph/jpgraph-2.1.4/src');
    else // php 4
        define('JGRAPH_PATH', COMMON_PATH .'/image/jpgraph/jpgraph_1.20.4a/src');

    /* EXCEL */
    define('EXCEL_PATH', COMMON_PATH .'/excel');
    
    /* LIBRAIRIE JAVASCRIPT */
    if (SERVEUR_PROD == 'EADM') // depuis internet...
        define('JS_URL', 'http://aixbox.mairie-aixenprovence.fr/js');
    else
        define('JS_URL', 'http://web1.intranet/js');
    define('JS_FORMCHECK_URL', JS_URL.'/formcheck');
    define('JS_MOORAINBOW_URL', JS_URL.'/moorainbow');
    define('JS_DTREE_URL', JS_URL.'/dtree');
    define('JS_EXTJS_URL', JS_URL.'/extjs');
    define('JS_AMCHARTS_URL', JS_URL.'/amcharts');
    
    /* XMPP => Utiliser pour interagir avec le serveur de messagerie instantanné EJabberd */
    define('XMPPHP_PATH', COMMON_PATH .'/xmpphp');
    require(XMPPHP_PATH."/xmpp.php");
    
    /* SIG => classe qui affiche les cartes */
    if (class_exists('MapSig') == false
        && file_exists(COMMON_PATH . '/sig/class_map/1.0/class_mapSig.php') == true)
    {
        require(COMMON_PATH . '/sig/class_map/1.0/class_mapSig.php');
    }
    
    if (class_exists('SigMap') == false)
    {
        require(COMMON_PATH . '/dsi/sig/class_sigmap.php');
    }
    
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