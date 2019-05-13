<?php
    $USE_PEAR2 = true;
    require_once('./../common/common.php');
    require_once('./data/config.php');
    require_once('./session.php');
    require_once($DATA_PATH . '/connexion.php');
    require_once($GENERAL_PATH . '/librairie/librairie.php');

    if($PROD == 1 && SERVEUR_PROD == 'SARRAKIS2' && (!isset($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] != 'on')){
        deconnexionDesBases();
        $url = str_replace('http:','https:',$GENERAL_URL);
        header('Location: ' . $url . '/index.php');
        exit;
    }
    $temps0 = getMicroTime();
    if($PROD === 1){
        $page = new Page(100);
    }else{
        $page = new Page(100,'','http://127.0.0.1/img/design');
    }
    //$page->setDesign('noir-vert/2.0');
    $page->setDesign('noir-bleu/3.0');
/*    
    $page = new BootStrap(100, '', 'http://'.$_SERVER['SERVER_NAME'].'/img/design');
	$page->setDesign('bootstrap/1.0');
*/  
    //Dans le cas d'une mise à jour de l'utilisateur
    //on change le design par defaut s'il n'est pas forcé (level<=1)
    if (isset($_GET['action']) && $_GET['action'] == 'logout')
    {
        $_SESSION[PROJET_NAME]['authentified'] = 0;
        deconnexionDesBases();
        header('Location: index.php');
        exit;
    }
    
    if (isset($_POST['P']))
        $P = $_POST['P'];
    elseif (isset($_GET['P']))
        $P = $_GET['P'];
    else
        $P = '0';

    if(substr($P,0,1) == '8' && !in_array('admin',$_SESSION[PROJET_NAME]['droit']) && !in_array('parametrage',$_SESSION[PROJET_NAME]['droit'])){
        $P = '0';
    }

    @include_once($DATA_PATH . '/objet_bdd/all_classes.php');
    if (!isset($ALL_CLASSE_LOADED))
    {
        $ob = new ObjetBdd($db);
        $ob->setTables(array(   'ARRP_AGENTS',
                                'ARRP_COMMUNES',
                                'ARRP_DEMANDES',
                                'ARRP_DEMANDES_PARCELLES',
                                'ARRP_DEMANDES_VOIES',
                                'ARRP_DEMANDEURS',
                                'ARRP_DODUMENTS',
                                'ARRP_VOIES',
                                'ARRP_USERS', ));
        $ob->setAllObjetsForTables();
        @include_once($DATA_PATH . '/objet_bdd/all_classes.php');
    }
	//$_SESSION[PROJET_NAME]['authentified']=1;
	// Vérification si l'on est sur une page qui demande une authentification
    if (isset($PAGES[$P]['SECURE_ACCESS']) && $PAGES[$P]['SECURE_ACCESS'] == 1 && $_SESSION[PROJET_NAME]['authentified'] != 1)
    {
        $_SESSION[PROJET_NAME]['page_demandee'] = $_SERVER['REQUEST_URI'];
        //$P = 1;
        $P = 'C_AJAX';
    }

    if($_SESSION[PROJET_NAME]['authentified'] == 1 && $_SESSION[PROJET_NAME]['autorized'] != 1){
        $P = '1';
    }

    // Inclusion du module demandé
    require_once(getModuleToLoad($P));
    
    // Déconnexion des bases de données
    deconnexionDesBases();
?>