<?php
    $page->afficheHeader();
?>
<table>
    <tr>
        <td valign="top" align="left">
        <?
            echo '<img src="' . $page->designUrl . '/maintenance/img_maintenance' . rand(2,2) . '.gif">';
        ?>
        
        </td>
        <td valign="top" align="left"><br><br>
        <font size=3><b>L</b></font>e site <b><?=PROJET_AFF_NOM?></b> reçoit actuellement trop de connexions...<br><br>
        L'accès au site est temporairement coupé.<br><br>
        Veuillez <a onclick="javascript:window.location.reload();" href="#"><strong>cliquez ici</strong></a> dans quelques minutes pour tenter d'accéder au site <b><?=PROJET_AFF_NOM?></b>.<br><br>
        Merci de votre compréhension,<br><br>
        Le <b>W</b>ebmaster
        </td>
    </tr>
</table>
<?php
    $page->afficheFooter();
?>