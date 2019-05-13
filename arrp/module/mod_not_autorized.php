<?php
if($_SESSION[PROJET_NAME]['authentified'] == 1 && $_SESSION[PROJET_NAME]['autorized'] == 1){
    deconnexionDesBases();
    header('Location: index.php');
    exit;
}

$page->afficheHeader();

$action = 'connexion';

echo '<form action="index.php" name="formconnexion" method="post">';
echo generateInputHidden('P');
echo generateInputHidden('action');

?>

<table>
    <tr>
        <td valign="top" align="left">
        <?
            echo '<img src="' . $page->designUrl.'/connexion/img_connexion' . rand(1,7) . '.gif">';
        ?>
        </td>
        <td valign="top" align="left">
            <table border=0>
                <tr>
                    <td height="240" valign="middle">
                    <?
                        echo '<font color="red" size="3">';
                            echo 'Vous n\'êtes pas autorisé(e) à acceder à cette application.<br><br>';
                            echo 'Veuillez contacter le service Informatique au <strong>'.PROJET_AFF_CONTACT_TEL.'</strong> .';
                        echo '</font>';
                    ?>
                    </td>
                </tr>
                <tr>
                    <td height="10"><td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</form>
<?
$page->afficheFooter();
?>