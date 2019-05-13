<?

if (isset($_POST['agent_login'])) // Défini en POST ?
{
    $agent_login = $_POST['agent_login'];
}
else
{
    if (isset($_SESSION[PROJET_NAME]['agent_login'])) // Dans la session ?
        $agent_login = $_SESSION[PROJET_NAME]['agent_login'];
    else
    {
        if (isset($_COOKIE['agent_login'])) // Dans le cookie ?
            $agent_login = $_COOKIE['agent_login'];
        else // Valeur par défaut
            $agent_login = '';
    }
}

if (!isset($FLECHE_RIGHT))
    $FLECHE_RIGHT   = '<font color="red"><b>'.htmlentities('»').'</b>&nbsp;</font>';
$page->afficheHeader();

$action = 'connexionldap';

echo '<form action="index.php" name="formconnexion" method="post" onSubmit="document.formconnexion.boutton.style.visibility=\'hidden\';window.document.getElementById(\'agent_login_txt\').style.visibility=\'hidden\';window.document.getElementById(\'agent_password_txt\').style.visibility=\'hidden\';window.document.getElementById(\'agent_patientez_txt\').style.visibility=\'visible\';">';
echo '<input type="hidden" name="P" value="'.$P.'">';
echo '<input type="hidden" name="action" value="'.$action.'">';

?>

<table>
    <tr>
        <td valign="top" align="left">
        <?
            echo '<img src="' . $page->designUrl . '/connexion/img_connexion' . rand(1,7) . '.gif">';
        ?>
        </td>
        <td valign="top" align="left">Authentification requise<br><br>
            <table border=0>
                <tr>
                    <td valign="middle">
                    <?
                        echo $FLECHE_RIGHT;
                    ?>
                    </td>
                    <?php
                        if (!isset($agent_login_liste))
                        {
                            echo '<td>Tapez votre nom d\'utilisateur:</td>';
                            echo    '<td><input '.
                                    'onFocus="javascript:window.document.getElementById(\'agent_login_txt\').style.visibility=\'visible\';" '.
                                    'onBlur="javascript:window.document.getElementById(\'agent_login_txt\').style.visibility=\'hidden\';" '.
                                    'type="text" size="30" name="agent_login" value="'.$agent_login.'"></td>';
                        }
                        else
                        {
                            echo '<td>Sélectionnez votre nom d\'utilisateur:</td>';
                            echo '<td>'.$agent_login_liste.'</td>';
                        }
                    ?>
                </tr>
                <tr>
                    <td colspan="3" align="center"><td>
                </tr>
                <tr>
                    <td valign="middle">
                    <?
                        echo $FLECHE_RIGHT;
                    ?>
                    </td>
                    <td valign="middle">
                    <?
                        echo 'Tapez votre Mot de passe:';
                    ?>
                    <td>
                    <?
                        echo '<input '.
                        'onFocus="javascript:window.document.getElementById(\'agent_password_txt\').style.visibility=\'visible\';" '.
                        'onBlur="javascript:window.document.getElementById(\'agent_password_txt\').style.visibility=\'hidden\';" '.
                        'type="password" size="30" name="agent_password">';
                    ?>
                    </td>
                </tr>
                <tr>
                    <td height="10"><td>
                </tr>

                <?
                    if (isset($libErreur) && strlen($libErreur) > 0)
                    {
                ?>
                <tr>
                    <td colspan="3">
                    <?
                        echo '<font color="#FF0000">' . $libErreur . '</font><br>';
                        //echo $FLECHE_RIGHT .'<a href="' . $GENERAL_URL . '/index.php?P=6">Cliquez ici si vous avez perdu votre mot de passe!</a>';
                        //document.formconnexion.submit();
                    ?>
                    </td>
                </tr>
                <tr>
                    <td height="10"><td>
                </tr>
                <?
                    }
                ?>
                <tr>
                    <td colspan="3" align="center"><input name="boutton" class="soumettre" type="submit" value="Se connecter"><td>
                </tr>
                <tr>
                    <td colspan="3">
                        <div class="infobulle" style="visibility:hidden" id="agent_login_txt"><img align="absbottom" src="<?=$page->designUrl?>/connexion/about.gif">&nbsp;Tapez dans ce champs <strong>votre nom d'utilisateur</strong> que<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;vous avez au <strong>démarrage</strong> de votre <strong>ordinateur</strong>.</div>
                        <div class="infobulle" style="visibility:hidden" id="agent_password_txt"><img align="absbottom" src="<?=$page->designUrl?>/connexion/about.gif">&nbsp;Tapez dans ce champs <strong>votre mot de passe</strong> que<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;vous tapez au <strong>démarrage de l'ordinateur</strong>.</div>
                        <div class="infobulle" style="visibility:hidden" id="agent_patientez_txt"><img align="absbottom" src="<?=$page->designUrl?>/connexion/about.gif">&nbsp;Connexion en cours... <strong>Veuillez patientez</strong>...</div>
                    <td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</form>
<?
//include($MODULE_PATH . "/mod_footer.php");
$page->afficheFooter();
?>