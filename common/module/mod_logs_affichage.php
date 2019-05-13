<?
$page->afficheHeader();

if (isset($_GET['log_user']))
    $log_user = $_GET['log_user'];
else
    $log_user = '';

if (isset($_GET['nep'])) // = Nombre d'élément par page
    $nep = $_GET['nep'];
else
    $nep = '30';

if (isset($_GET['pn']))
    $pn = $_GET['pn'];
else
    $pn = 0;

$selectElement =    '<select name="nep" onChange="javascript:document.location.href=\'index.php?P=L&log_user='.$log_user.'&nep=\'+this.value;">'.
                    '<option value="10">10</option>'.
                    '<option value="20">20</option>'.
                    '<option value="30">30</option>'.
                    '<option value="40">40</option>'.
                    '<option value="50">50</option>'.
                    '</select>';
$selectElement = str_replace('value="'. $nep .'"', 'value="'. $nep .'" selected', $selectElement);

// Récupération de la liste des username
$req = 'SELECT distinct log_user '.
        'FROM logs ';
$res = executeReq($db, $req);
$selectUser = '<select name="log_user" onChange="javascript:document.location.href=\'index.php?P=L&log_user=\'+this.value;">';
$selectUser .= '<option value="">:: Veuillez sélectionner un nom d\'utilisateur</option>';
while(list($username) = $res->fetchRow())
{
    $selectUser .= '<option value="'. $username .'">'. $username .'</option>';
}
$selectUser .= '</select>';

// récupération des logs
$reqCount = 'SELECT count(*) '.
            'FROM logs ';

$req =  'SELECT log_id, log_time, log_ip, log_user, log_description '.
        'FROM logs ';

if ($log_user != '')
{
    $req .= 'WHERE log_user=\''.protegeChaine($log_user).'\'';
    $reqCount .= 'WHERE log_user=\''.protegeChaine($log_user).'\'';
    $selectUser = str_replace('value="'. $log_user .'"', 'value="'. $log_user .'" selected', $selectUser);
}

$resCount = executeReq($db, $reqCount);
list($nbResultatMax) = $resCount->fetchRow();

$req .= 'order by log_time desc, log_id desc ';
$req .= 'LIMIT '.($pn*$nep).', '.$nep.' ';

$res = executeReq($db, $req);

echo '<center>Nom d\'utilisateur: '.$selectUser.'&nbsp;&nbsp;Eléments par page: '.$selectElement.'</center><br>';

// Affichage du nombre de résultat
$lienPaginationParametre = 'index.php?P=L&log_user='.$log_user.'&nep='.$nep;

$chPaginationResultat = getPaginationResultat($nbResultatMax, $nep, $pn);
$chPagination = getPagination($nbResultatMax, $nep, $pn, $lienPaginationParametre);

$nbVersion2 = substr_count($page->designColor, '/2.0');
$nbVersion2 += substr_count($page->designColor, '/2_0');
if ($nbVersion2 == 1)
{
    if ($chPaginationResultat != '')
    {
        echo '&nbsp;'.$chPaginationResultat.'<br>';
    }
    // Affichage de la pagination
    
    if ($chPagination != '')
    {
        echo '<center>&nbsp;'.$chPagination.'</center><br>';
    }
    else
        echo '<br>';
        
    echo '<table class="adminlist">'.
        '<tr>'.
            '<th>&nbsp;-&nbsp;</th>'.
            '<th>&nbsp;Auteur&nbsp;</th>'.
            '<th width="100">&nbsp;IP&nbsp;</th>'.
            '<th width="140">&nbsp;Date&nbsp;</th>'.
            '<th>&nbsp;Description&nbsp;</th>'.
        '</tr>';
    $i = 0;
    while(list($log_id, $log_time, $log_ip, $log_user, $log_description) = $res->fetchRow())
    {
    //for($i=0; $i < $logs->size(); $i++)
    //{
    //    $o = $logs->get($i);
        $bgcolor = ($i)%2 == 0 ? '#FFFFFF':'#DDDDDD';
        echo '<tr class="row'.($i%2).'">'.
                '<td>&nbsp;<img src="'. $page->designUrl . '/pagination/user1.gif"></td>'.
                '<td>&nbsp;'. $log_user .'</td>'.
                '<td>&nbsp;'. $log_ip .'</td>'.
                '<td>'. date('Y-m-d à H\hi s\s.',$log_time) .'</td>'.
                '<td>&nbsp;'. $log_description .'</td>'.
            '</tr>';
        $i++;
    }
    echo '</table>';
    if ($chPagination != '')
    {
        echo '<center>&nbsp;'.$chPagination.'</center><br>';
    }
    else
        echo '<br>';
}
else
{
    if ($chPaginationResultat != '')
    {
        echo '&nbsp;'.$chPaginationResultat.'<br>';
    }
    // Affichage de la pagination
    
    if ($chPagination != '')
    {
        echo '<center>&nbsp;'.$chPagination.'</center><br>';
    }
    else
        echo '<br>';
        
    echo '<table class="tableau">'.
        '<tr>'.
            '<th>&nbsp;-&nbsp;</th>'.
            '<th>&nbsp;Auteur&nbsp;</th>'.
            '<th width="140">&nbsp;Date&nbsp;</th>'.
            '<th>&nbsp;Description&nbsp;</th>'.
        '</tr>';
    $i = 0;
    while(list($log_id, $log_time, $log_ip, $log_user, $log_description) = $res->fetchRow())
    {
    //for($i=0; $i < $logs->size(); $i++)
    //{
    //    $o = $logs->get($i);
        $bgcolor = ($i)%2 == 0 ? '#FFFFFF':'#DDDDDD';
        echo '<tr bgcolor="'.$bgcolor.'">'.
                '<td>&nbsp;<img src="'. $page->designUrl . '/pagination/user1.gif"></td>'.
                '<td>&nbsp;'. $log_user .'</td>'.
                '<td>'. date('Y-m-d à H\hi:s',$log_time) .'</td>'.
                '<td>&nbsp;'. $log_description .'</td>'.
            '</tr>';
        $i++;
    }
    echo '</table>';
    if ($chPagination != '')
    {
        echo '<center>&nbsp;'.$chPagination.'</center><br>';
    }
    else
        echo '<br>';
}

$page->afficheFooter();
?>