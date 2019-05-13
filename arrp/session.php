<?PHP
if (isset($PHPSESSID)){
	session_start($PHPSESSID);
}else{
	session_start();
}

if (!isset($_SESSION[PROJET_NAME]))
{
    $_SESSION[PROJET_NAME] = array(
                                    'authentified' => 0,
                                    'autorized'    => 0,
                                    'page_demandee' => '',
                                    'droit' => array(),
                                  );
}

/*
if(!isset($_SESSION[PROJET_NAME]['authentified']))
{
    $_SESSION[PROJET_NAME]['authentified'] = 0; 
}
*/
?>