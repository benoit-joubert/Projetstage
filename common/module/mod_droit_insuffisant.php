<?php
    // Module qui est appell� quand le $P qu'on souhaite afficher
    // comporte un champs SECURE_DROIT et que l'utilisateur ne poss�de pas les droits en questions dans sa session.
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
        <font size=3><b>V</b></font>ous n'avez pas les <strong>droits suffisants</strong> pour acc�der � cette page.<br><br>
        Veuillez <a href="index.php"><strong>cliquez ici</strong></a> pour revenir � la page d'accueil du site.<br><br>
        
        Merci de votre compr�hension,<br><br>
        La D.S.I
        </td>
    </tr>
</table>
<?php
    $page->afficheFooter();
?>