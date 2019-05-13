<?php
    // Module qui est appellé quand le $P qu'on souhaite afficher
    // comporte un champs SECURE_DROIT et que l'utilisateur ne possède pas les droits en questions dans sa session.
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
        <font size=3><b>V</b></font>ous n'avez pas les <strong>droits suffisants</strong> pour accéder à cette page.<br><br>
        Veuillez <a href="index.php"><strong>cliquez ici</strong></a> pour revenir à la page d'accueil du site.<br><br>
        
        Merci de votre compréhension,<br><br>
        La D.S.I
        </td>
    </tr>
</table>
<?php
    $page->afficheFooter();
?>