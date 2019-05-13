<?
$chRetour = '';
$timeRedirect = 0; 
if (isset($_POST['action']) && isset($_POST['agent_login']) && isset($_POST['agent_password']) && $_POST['action'] == 'connexionldap' && strlen($_POST['agent_password']) > 0)
{
    $ldap = new Ldap($_POST['agent_login'], $_POST['agent_password'], PROJET_CLE_LDAP);
    if ($ldap->connecteAgent() == true)
    {
        setcookie('agent_login',$_POST['agent_login'],time()+60*60*24*365); // Cookies 1 an

        if (function_exists('connexion')) // une fonction de connexion Existe, on la lance
        {
            $return = connexion($ldap->userInfo); // on lance la fonction
            if ($return === true)
            {
            	$_SESSION[PROJET_NAME]['authentified'] = 1;
                // connexion OK
                if (!isset($_SESSION[PROJET_NAME]['agent_ldap']))
                    $_SESSION[PROJET_NAME]['agent_ldap'] = $ldap->userInfo;
            }
            else
            {
                $_SESSION[PROJET_NAME]['authentified'] = 0;
                $chRetour .= 'setInfo2(\'<br><br><img align=absbottom src='. $page->designUrl .'/connexion/forbidden_16.png>&nbsp;<font color=red><strong>ERREUR</strong></font>\', 1);';
                $chRetour .= 'setInfo2(\'<br><br><font color=red>'. str_replace('\'','\\\'',$return) .'</font>\', 1);';
                $chRetour .= 'document.formconnexion.boutton.style.visibility=\'visible\';';
            }
        }
        else // si pas de fonction => connexion OK
        {
            $_SESSION[PROJET_NAME]['authentified'] = 1;
            $_SESSION[PROJET_NAME]['agent_login'] = $_POST['agent_login'];
            $_SESSION[PROJET_NAME]['agent_ldap'] = $ldap->userInfo;
        }
        
        if ($_SESSION[PROJET_NAME]['authentified'] == 1) // Connexion OK
        {
            
            // on récupère la liste des projets auquel l'agent à le droit d'accéder
            setApplicationUser(getApplicationInfo($_SESSION[PROJET_NAME]['agent_ldap']['description']));
            
            $chRetour .= 'setInfo2(\'<br><br><img align=absbottom src='. $page->designUrl .'/connexion/check_16.png>&nbsp;<font color=green><strong>ACCESS AUTORISE</strong></font>\', 1);';
            
            // La personne possède un matricule
            if ($ldap->userInfo['matricule'] != '')
            {
                $matricule = $ldap->userInfo['matricule'];
                $chRetour .= 'setInfo2(\'<br><br><img align=absbottom src='. $page->designUrl .'/connexion/id_card_16.png>&nbsp;Matricule RH agent: <strong>'. $matricule .'</strong>\', 1);';
                $timeRedirect += 1;
            }
            
            // La personne possède un mot de passe qui expire, on lui affiche quand il expire exactement
            if ($ldap->userInfo['password_expiration'] != '')
            {
                $chRetour .= 'setInfo2(\'<br><br><img align=absbottom src='. $page->designUrl .'/connexion/clock_16.png>&nbsp;Votre <strong>mot de passe</strong> expire dans <strong>'.$ldap->userInfo['password_expiration'].'</strong>\', 1);';
                $timeRedirect += 2;
            }
            
            // La personne voulait aller sur une page... on la redirige
            if ($_SESSION[PROJET_NAME]['page_demandee'] != '')
            {
                $timeRedirect += 1;
                $chRetour .= 'setInfo2(\'<br><br><img align=absbottom src='. $page->designUrl .'/connexion/redo_16.png>&nbsp;<strong>Redirection</strong> vers la page demand&eacute;e en cours...\', 1);';
                //$chRetour .= 'affichePoint();';
                // Redirection avec 2 sec
                $chRetour .= 'setTimeout(\'loadUrl(\\\''.$_SESSION[PROJET_NAME]['page_demandee'].'\\\')\', '.$timeRedirect.'000);';
            }
        }
        else
        {
            //$chRetour .= 'setInfo2(\'<br><br>&nbsp;ERREUR AUTHENTIFICATION #1\', 1);';
        }
        
    }
    else
    {
        //$_SESSION[PROJET_NAME]['authentified'] = 0;
        $libErreur = $ldap->getErrorMessage(); // on récupère le message d'erreur
        $libErreur = str_replace('<br>','brbrbr', $libErreur);
        $libErreur = str_replace('<strong>','strongstrongstrong', $libErreur);
        $libErreur = str_replace('</strong>','strongpasstrong', $libErreur);
        $libErreur = htmlentitiesIso($libErreur);
        $libErreur = str_replace('brbrbr', '<br>', $libErreur);
        $libErreur = str_replace('strongstrongstrong', '<strong>', $libErreur);
        $libErreur = str_replace('strongpasstrong', '</strong>', $libErreur);
        $libErreur = str_replace('\'','\\\'', $libErreur);
        $chRetour .= 'setInfo2(\'<br><br><img align=absbottom src='. $page->designUrl .'/connexion/forbidden_16.png>&nbsp;<font color=red><strong>ERREUR</strong></font>\', 1);';
        $chRetour .= 'setInfo2(\'<br><br><font color=red>'.$libErreur.'</font>\', 1);';
        $chRetour .= 'document.formconnexion.boutton.style.visibility=\'visible\';';
//        $chRetour .= 'alert(\'ee\');';
        $chRetour .= 'window.document.getElementById(\'progressbar\').innerHTML = \'\';';
        if ($ldap->isChoixMultiple == true) // plusieurs agents possible pour le nom de connexion
        {
            $agent_login_liste = $ldap->getAgentLoginListe(); // on récupère le SELECT des agents
        }
    }
}
else
{
    $chRetour .= 'setInfo2(\'<br><br>&nbsp;ERREUR AUTHENTIFICATION #2\', 1);';
}

if (!isset($AUTO_CONNECT))
    echo $chRetour;
else
{
    deconnexionDesBases();
    header('location: index.php');
    exit;
}

?>