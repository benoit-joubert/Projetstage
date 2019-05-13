<?
//print_jc($_SERVER);
// Vérification si la page de connexion doit etre en HTTPS ou pas
//if ($_SERVER['REMOTE_ADDR'] == '10.128.13.254' || $_SERVER['REMOTE_ADDR'] == '10.128.10.20' || (isset($_GET['u']) && $_GET['u'] == 'jc'))
//{
//    if (in_array($P, $tabDesPagesEnHTTPS))
//    {
//        // on demande la connexion HTTPS pour ce site, on vérifie si le site est en HTTPS
//        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on')
//        {
//            // HTTPS activé
//        }
//        else
//        {
//            // redirection
//            if (defined('SERVEUR_URL_RACINE'))
//            {
//                deconnexionDesBases();
//                $urlHTTPS = str_replace('http://', 'https://', SERVEUR_URL_RACINE . $_SERVER['REQUEST_URI']);
////                echo $urlHTTPS;
//                Header('Location: '.$urlHTTPS);
//                exit;
//            }
//        }
//    }
//}

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

$nbVersion3 = substr_count($page->designColor, '/3.0');
if ($nbVersion3 == 1)
{
    $FLECHE_RIGHT = '<img src="'.$page->getDesignUrl().'/images/j_arrow.png"/>';
}
$page->afficheHeader();

$action = 'connexionldap';
if (isset($_SESSION[PROJET_NAME]['agent_ldap']))
{
	unset ($_SESSION[PROJET_NAME]['agent_ldap']);
}

echo '<form action="" name="formconnexion" method="post" onSubmit="connexion();return false;">';
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
        <td valign="top" align="left">
            <?
            if ($nbVersion3 == 1)
            {
                echo '<fieldset class="adminform">';
                echo '<legend>';
            }
            ?>
            <strong>A</strong>uthentification requise afin d'acc&eacute;der &agrave; ce projet
            <?
            if ($nbVersion3 == 1)
            {
                echo '</legend>';
            }
            else
                echo '<br><br>';
            ?>
            <table>
                <tr>
                    <td valign="middle" align=center>
                    <?
                        echo $FLECHE_RIGHT;
                    ?>
                    </td>
                    <?php
                        if (!isset($agent_login_liste))
                        {
                            echo '<td>Nom d\'utilisateur:</td>';
                            echo    '<td><input '.
                                    'onFocus="setInfo(\'<img align=absbottom src='. $page->designUrl .'/connexion/about.gif>&nbsp;Tapez dans ce champs <strong>votre nom d\\\'utilisateur</strong> que<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;vous avez au <strong>d&eacute;marrage</strong> de votre <strong>ordinateur</strong>.\');" '.
                                    'onBlur="cacheInfo();" '.
                                    'type="text" size="30" id="agent_login" name="agent_login" value="'.$agent_login.'"></td>';
                        }
                        else
                        {
                            echo '<td>Sélectionnez votre nom d\'utilisateur:</td>';
                            echo '<td>'.$agent_login_liste.'</td>';
                        }
                    ?>
                </tr>
                <tr>
                    <td colspan="3" align="center"></td>
                </tr>
                <tr>
                    <td valign="middle">
                    <?
                        echo $FLECHE_RIGHT;
                    ?>
                    </td>
                    <td valign="middle">
                    <?
                        echo 'Mot de passe:';
                    ?>
                    </td>
                    <td style="width: 200px;">
                    <?
                        echo '<input '.
                        'onFocus="setInfo(\'<img align=absbottom src='. $page->designUrl .'/connexion/about.gif>&nbsp;Tapez dans ce champs <strong>votre mot de passe</strong> que<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;vous tapez au <strong>d&eacute;marrage de l\\\'ordinateur</strong>.\');" '.
                        'onBlur="cacheInfo();" '.
                        'type="password" size="30" id="agent_password" name="agent_password">';
                        echo ' <span id="agent_password_toggle" style="cursor:pointer;position: absolute;margin: 8px;font-size: 1.2em;">';
                        echo '<img id="agent_password_img" src="'. $page->designUrl .'/connexion/baseline_visibility_black_18dp.png" />';
                        echo '</span>';
                    ?>
                    </td>
                </tr>
                <tr>
                    <td height="10"></td>
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
                    <td height="10" colspan="3"></td>
                </tr>
                <?
                    }
                ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td align="right" style="padding-right: 26px;"><input name="boutton" class="soumettre" type="submit" value="Se connecter"></td>
                </tr>
                <tr>
                    <td colspan="3">
                        
                        <div id="progressbar"></div>
                        <span class="status" id="p3text"></span>
                        <div class="infobulle" style="visibility:hidden" id="info"></div>
                    </td>
                </tr>
            </table>
            <br><br><br>
            <?
            if ($nbVersion3 == 1)
            {
                echo '</fieldset>';
            }
            ?>
        </td>
    </tr>
</table>
</form>
<script type="text/javascript">
document.querySelector('#agent_password_toggle').addEventListener('click', function(event) {
    event.preventDefault();
    if ( document.querySelector('#agent_password').getAttribute('type') == 'password' )
    {
        document.querySelector('#agent_password').setAttribute('type', 'text');
        document.querySelector('#agent_password_img').setAttribute('src', '<?=$page->designUrl?>/connexion/baseline_visibility_off_black_18dp.png');
    }
    else
    {
        document.querySelector('#agent_password').setAttribute('type', 'password');
        document.querySelector('#agent_password_img').setAttribute('src', '<?=$page->designUrl?>/connexion/baseline_visibility_black_18dp.png');
    }
});
</script>

<?
//include($MODULE_PATH . "/mod_footer.php");
$page->afficheFooter();
?>