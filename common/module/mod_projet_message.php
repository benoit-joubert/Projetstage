<?
$page->afficheHeader();

$isUserGrantedToModifyMessageGeneral = false;
if (isset($_SESSION[PROJET_NAME]['agent_ldap']['login']) && in_array(strtolower($_SESSION[PROJET_NAME]['agent_ldap']['login']),array('marinjc','kempffe','fitzailos','villaj','cattierl','filliardl','boublenzai','bonoc','adinanid','paulp')))
{
    $isUserGrantedToModifyMessage = true;
    $isUserGrantedToModifyMessageGeneral = true;
}
else
    $isUserGrantedToModifyMessage = false;

if ($isUserGrantedToModifyMessage == false) // on récupère la valeur mis en dur pour des agents admin du site
    $isUserGrantedToModifyMessage = getUserCanModifyAlerteMessage();

if ($isUserGrantedToModifyMessage == false)
    die('Accès interdit');

// récupération des infos déjà saisies
$fichierMessage = $DATA_PATH.'/config_message.php';
if (file_exists($fichierMessage))
    @include($fichierMessage);
if (!isset($tabSiteMessage))
    $tabSiteMessage = array();
if (isset($tabSiteMessage['DATE']))
{
    $message_information = str_replace('"', htmlentities('"'), $tabSiteMessage['MESSAGE']);
    $message_date = $tabSiteMessage['DATE'];
    $message_color = $tabSiteMessage['COLOR'];
}
else
{
    $message_information = '';
    $message_date = time();
    $message_color = 'green';
}

$selectTypeMessage =    '<select name="color">'.
                            '<option value="#B9F355">Message d\'information standard</option>'.
                            '<option value="red">Message d\'alerte important ou critique</option>'.
                        '</select>';
$selectTypeMessage = str_replace('value="'.$message_color.'"', 'value="'.$message_color.'" selected', $selectTypeMessage);

// récupération des infos déjà saisies pour le message général à tous les sites intranet
$fichierMessage = COMMON_PATH.'/data/config_message.php';
if (file_exists($fichierMessage))
    @include($fichierMessage);
if (!isset($tabSiteMessageGeneral))
    $tabSiteMessageGeneral = array();
if (isset($tabSiteMessageGeneral['DATE']))
{
    $message_information_general = str_replace('"', htmlentities('"'), $tabSiteMessageGeneral['MESSAGE']);
    $message_general_date = $tabSiteMessageGeneral['DATE'];
    $message_color2 = $tabSiteMessageGeneral['COLOR'];
}
else
{
    $message_information_general = '';
    $message_general_date = time();
    $message_color2 = 'green';
}

list($message_datej, $message_datem, $message_datea, $message_dateh, $message_datei, $message_dates) = explode('/', date('d/m/Y/H/i/s', $message_date));
list($message_general_datej, $message_general_datem, $message_general_datea, $message_general_dateh, $message_general_datei, $message_general_dates) = explode('/', date('d/m/Y/H/i/s', $message_general_date));

?>
<form name="F1" action="index.php" method="POST">
<input type="hidden" name="P" value="AS">
<table>
    <tr>
        <td colspan=2><strong>Message à diffuser à tous les utilisateurs du site actuel :</strong></td>
    </tr>
    <tr>
        <td>Message :</td>
        <td><input name="message_information" size="150" value="<?=$message_information?>"></td>
    </tr>
    <tr>
        <td>Heure actuelle :</td>
        <td>
            <input size="2" value="<?=date('d')?>" readonly> / 
            <input size="2" value="<?=date('m')?>" readonly> / 
            <input size="4" value="<?=date('Y')?>" readonly> à 
            <input size="2" value="<?=date('H')?>" readonly> H 
            <input size="2" value="<?=date('i')?>" readonly> et 
            <input size="2" value="<?=date('s')?>" readonly> sec.
        </td>
    </tr>
    <tr>
        <td>Date de Fin du message :</td>
        <td>
            <input name="message_datej" size="2" value="<?=$message_datej?>"> / 
            <input name="message_datem" size="2" value="<?=$message_datem?>"> / 
            <input name="message_datea" size="4" value="<?=$message_datea?>"> à 
            <input name="message_dateh" size="2" value="<?=$message_dateh?>"> H 
            <input name="message_datei" size="2" value="<?=$message_datei?>"> et 
            <input name="message_dates" size="2" value="<?=$message_dates?>"> sec.
            <span class="erreur"><strong>Veuillez bien indiquer une date de fin!</strong></span>
        </td>
    </tr>
    <tr>
        <td>Type de message :</td>
        <td><?=$selectTypeMessage?></td>
    </tr>
    <tr>
        <td colspan="2"><span class="erreur"><strong>ATTENTION :</strong></span> Ce message sera affiché sur toutes les pages du site !<br/><br/></td>
    </tr>
<?
if ($isUserGrantedToModifyMessageGeneral == true)
{
    $selectTypeMessage2 =    '<select name="color2">'.
                            '<option value="#B9F355">Message d\'information standard</option>'.
                            '<option value="red">Message d\'alerte important ou critique</option>'.
                        '</select>';
    $selectTypeMessage2 = str_replace('value="'.$message_color2.'"', 'value="'.$message_color2.'" selected', $selectTypeMessage2);
?>
    <tr>
        <td colspan=2><strong>Message à diffuser sur <u>TOUS</u> les sites présents sur <u>CE SERVEUR</u> (http://<?=$serveurName?>/*****) en même temps :</strong></td>
    </tr>
    <tr>
        <td>Message :</td>
        <td><input name="message_information_general" size="100" value="<?=$message_information_general?>"></td>
    </tr>
    <tr>
        <td>Heure actuelle :</td>
        <td>
            <input size="2" value="<?=date('d')?>" readonly> / 
            <input size="2" value="<?=date('m')?>" readonly> / 
            <input size="4" value="<?=date('Y')?>" readonly> à 
            <input size="2" value="<?=date('H')?>" readonly> H 
            <input size="2" value="<?=date('i')?>" readonly> et 
            <input size="2" value="<?=date('s')?>" readonly> sec.
        </td>
    </tr>
    <tr>
        <td>Date de Fin du message :</td>
        <td>
            <input name="message_general_datej" size="2" value="<?=$message_general_datej?>"> / 
            <input name="message_general_datem" size="2" value="<?=$message_general_datem?>"> / 
            <input name="message_general_datea" size="4" value="<?=$message_general_datea?>"> à 
            <input name="message_general_dateh" size="2" value="<?=$message_general_dateh?>"> H 
            <input name="message_general_datei" size="2" value="<?=$message_general_datei?>"> et 
            <input name="message_general_dates" size="2" value="<?=$message_general_dates?>"> sec.
            <span class="erreur"><strong>Veuillez bien indiquer une date de fin!</strong></span>
        </td>
    </tr>
    <tr>
        <td>Type de message :</td>
        <td><?=$selectTypeMessage2?></td>
    </tr>
    <tr>
        <td colspan="2"><span class="erreur"><strong>ATTENTION :</strong></span> Ce message sera affiché sur toutes les pages de tous les sites intranet !<br/><br/></td>
    </tr>
<?
}
?>
    <tr>
        <td colspan="2" align="center"><input type="submit" class="soumettre" value="Enregistrer"></td>
    </tr>
</table>
</form>

<?
$page->afficheFooter();
?>