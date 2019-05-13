<?php

    $page->afficheHeader();
    if (isset($PROJET_ID) && array_key_exists($PROJET_ID, $tabSiteEnMaintenance))
    {
        $messageMaintenance = $tabSiteEnMaintenance[$PROJET_ID]['MESSAGE'];
    }
    if (isset($messageMaintenance) && $messageMaintenance != '')
    {
        $messageMaintenance =       '<img align=absbottom src="' . $page->designUrl . '/maintenance/about.gif"><b><span class=s>&nbsp;Message de la DSI :</span></b><br>'.
                                    '<span class=s><b>'.htmlentities('»').'</b>&nbsp;</span><i>'.$messageMaintenance.'</i><br><br>';
        $messageMaintenance = str_replace("\n", '</i><br><span class=s><b>'.htmlentities('»').'</b>&nbsp;</span><i>', $messageMaintenance);
    }
    else
        $messageMaintenance = '';
?>
<table>
    <tr>
        <td valign="top" align="left">
        <?
            echo '<img width=220 src="' . $page->designUrl . '/maintenance/img_maintenance6.gif">';
        ?>
        
        </td>
        <td valign="top" align="left"><br><br>
        <font size=3><b>U</b></font>ne <strong>opération de maintenance</strong> est actuellement en cours sur cette application...<br><br>
        L'accès au site a donc été coupé <strong>temporairement</strong>.<br><br>
        <?=$messageMaintenance?>
        Dans quelques instants, veuillez <a onclick="javascript:window.location.reload();" href="#"><strong>cliquez ici</strong></a> afin de tenter un accès à l'application.<br><br>
        Si le problème persiste (<strong>supérieur à une journée</strong>),<br>Contacter le service informatique au 94.42.<br><br>
        Merci de votre compréhension,<br><br>
        La D.S.I
        </td>
    </tr>
</table>
<?php
    $page->afficheFooter();
?>