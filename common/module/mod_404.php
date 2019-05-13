<?php
    // Module qui est appellé quand le $P qu'on souhaite afficher
    // n'est pas présent dans le tableau $PAGES (config.php)
    $page->afficheHeader();
?>
<table>
    <tr>
        <td valign="top" align="left">
        <?
            echo '<img src="' . $page->designUrl . '/maintenance/img_maintenance5.gif">';
        ?>
        
        </td>
        <td valign="top" align="left"><br><br>
        <font size=3><b>L</b></font>a page demandée est <strong>introuvable</strong>.<br><br>
        Veuillez <a href="index.php"><strong>cliquez ici</strong></a> pour revenir à la page d'accueil du site.<br><br>
        
        Merci de votre compréhension,<br><br>
        La D.S.I
        </td>
    </tr>
</table>
<?php
    $page->afficheFooter();
?>