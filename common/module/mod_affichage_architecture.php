<?
$ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR']:'';

if ($ip == '' || $ip != '127.0.0.1')
{
    $page->afficheHeader();
    // Seul le développeur sur son poste en local peut afficher cette architecture
    echo 'ERREUR: Vous devez avoir une IP égale à 127.0.0.1 pour accéder à cette page! Votre IP actuelle: '.$ip;
    $page->afficheFooter();
}
else
{
    // Calcul de la pagination :
    // Si c'est des multiples de 10 ou de 100
    $interval = 10;
    $newTab = $PAGES;
    $nb10PasTrouve = $nb100PasTrouve = 0;
    foreach($newTab as $k => $v)
    {
        if (!is_integer($k))
            unset($newTab[$k]);
    }
    
    foreach($newTab as $P => $v)
    {
        if ($P != 0)
        {
            if (!isset($newTab[intval($P/10)]))
                $nb10PasTrouve++;
            if (!isset($newTab[intval($P/100)]))
                $nb100PasTrouve++;
        }
    }
    $P = 'P';
    if ($nb100PasTrouve < $nb10PasTrouve)
        affichePages(100);
    else
        affichePages(10);
}

?>