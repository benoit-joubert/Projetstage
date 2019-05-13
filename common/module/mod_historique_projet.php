<?
$page->afficheHeader();

$data = getHistoriqueForProjet('/web/'.PROJET_NAME.'/');

echo '<a href="http://web1.intranet/uvc/">Dépannage à distance</a><br><br>';

$table = new Table();

// Définition des colonnes
$table->ajouteColonne('Version', '', '50', 'right');
$table->ajouteColonne('Information', '');
$table->ajouteColonne('Date', '', '110');
$table->ajouteColonne('<img align=absbottom src="'.$page->designUrl.'/pagination/user1.gif">&nbsp;Auteur');

$revision = ''; // contient le numéro de révision du site actuellement en production
if (file_exists($DATA_PATH.'/revision.php'))
    include($DATA_PATH.'/revision.php');

foreach($data as $v)
{
    $rev = $v['REV']/1000;
    if ($v['REV'] > $revision)
        $rev = '<img align=absbottom title="Version non disponible sur ce site actuellement!" src="'.$page->designUrl.'/pagination/warning.gif">&nbsp;<strike>'.$rev.'</strike>';

    $table->ajouteValeur(array(
                                $rev,
                                str_replace("\n","<br>&nbsp;",$v['MSG']),
                                $v['DATE'],
                                $v['AUTEUR'],
                               ));
}

$table->draw();

$page->afficheFooter();
?>