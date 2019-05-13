<?php
    $page->afficheHeader();
    
    // on essaye de récupérer le pourquoi du mode maintenance
    $messageErreurMaintenance = '';
    if (isset($dbLog) && get_class($dbLog) == 'db_error' && DB::isError($dbLog))
	{
		$messageErreurMaintenance = $dbLog->getDebugInfo();
	}
	if (isset($dbOracle) && get_class($dbOracle) == 'db_error' && DB::isError($dbOracle))
	{
		$messageErreurMaintenance = $dbOracle->getDebugInfo();
	}
	if (isset($dbAccess) && get_class($dbAccess) == 'db_error' && DB::isError($dbAccess))
	{
		$messageErreurMaintenance = $dbAccess->getDebugInfo();
	}
	if (isset($db) && get_class($db) == 'db_error' && DB::isError($db))
	{
		$messageErreurMaintenance = $db->getDebugInfo();
	}
	// Suppression de l'affichage du mot de passe
	if ($messageErreurMaintenance != '')
	{
	    $messageErreurMaintenance = eregi_replace('(.*):(.*)@(.*)','\\1:******@\\3',$messageErreurMaintenance);
	}
	if ($messageErreurMaintenance != '')
	    $messageErreurMaintenance = '<br><br><strong>Détail de l\'erreur:</strong> <span class=s>'.$messageErreurMaintenance.'</span>';
?>
<table>
    <tr>
        <td valign="top" align="left">
        <?
            echo '<img src="' . $page->designUrl . '/maintenance/img_maintenance' . rand(2,2) . '.gif">';
        ?>
        
        </td>
        <td valign="top" align="left"><br><br>
        <font size=3><b>U</b></font>n serveur de <strong>base de données</strong> indispensable au site est actuellement <strong>injoignable</strong>...<br><br>
        L'accès au site a donc été coupé automatiquement.<br><br>
        Un mail a été envoyé au service informatique afin de le prévenir du problème.<br><br><br>
        Veuillez <a onclick="javascript:window.location.reload();" href="#"><strong>cliquez ici</strong></a> afin d'accéder de nouveau au service.<br><br>
        Si le problème persiste (<strong>supérieur à 15 min</strong>),<br>Contacter le service informatique au 94.42 en indiquant ceci:<br><br>
        "Erreur de Base de Données sur le Projet <strong><?=PROJET_NAME?></strong> sur le serveur <strong><?=SERVEUR_PROD?></strong>"<?=$messageErreurMaintenance?>
        <br><br>
        Merci de votre compréhension,<br><br>
        La D.S.I
        </td>
    </tr>
</table>
<?php
    $page->afficheFooter();
?>