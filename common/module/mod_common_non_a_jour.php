<?php
$page->afficheHeader();

if ($LAST_COMMON_CHECK_RESULT == 'common_non_a_jour')
{
?>
<table>
    <tr>
        <td valign="top" align="left">
        <?
            echo '<img src="' . $page->designUrl . '/maintenance/common_maj.gif">';
        ?>
        
        </td>
        <td valign="top" align="left"><br><br>
        <font size=3><b>L</b></font>a version de votre répertoire <strong><font color="red">common</font></strong> n'est <strong><font color="red">pas à jour</font></strong> par rapport aux différents <strong>serveurs de production</strong>.<br><br>
        
        Ceci peut entrainer des <strong>problèmes de compatibilité</strong> lors du <strong>passage en production</strong>.<br><br>
        
        <strong><font color="red">Veuillez le mettre à jour dès maintenant</font></strong>.<br><br><br>
        
        <a href="index.php"><strong>Cliquez ensuite ici</strong></a> pour revenir à la page d'accueil du site.<br><br><br>
        
        Merci de votre compréhension,<br><br>
        Le Service Etudes et Développements
        </td>
    </tr>
</table>
<?php
}
else if ($LAST_COMMON_CHECK_RESULT == 'svn_client_too_old')
{
?>
<table>
    <tr>
        <td valign="top" align="left">
        <?
            echo '<img src="' . $page->designUrl . '/maintenance/tortoise_maj.jpg">';
        ?>
        
        </td>
        <td valign="top" align="left"><br><br>
        <font size=3><b>L</b></font>a version de votre <strong><font color="red">Client Subversion (TortoiseSVN)</font></strong> n'est <strong><font color="red">pas à jour</font></strong> par rapport aux différents <strong>serveurs de production</strong>.<br><br>
        
        Ceci peut entrainer des <strong>problèmes de compatibilité</strong> lors du <strong>passage en production</strong>.<br><br>
        
        <strong><font color="red">Veuillez le mettre à jour dès maintenant</font></strong> (Contactez JC pour plus d'informations).<br><br><br>
        
        <a href="index.php"><strong>Cliquez ensuite ici</strong></a> pour revenir à la page d'accueil du site.<br><br><br>
        
        Merci de votre compréhension,<br><br>
        Le Service Etudes et Développements
        </td>
    </tr>
</table>
<?
}

$page->afficheFooter();
?>