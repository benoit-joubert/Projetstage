<?

if (isset($_SESSION[PROJET_NAME]['agent_ldap']['login']) && in_array(strtolower($_SESSION[PROJET_NAME]['agent_ldap']['login']),array('marinjc','kempffe','fitzailos','villaj','cattierl','filliardl','boublenzai','bonoc','adinanid','paulp')))
    $isUserGrantedToModifyMessage = true;
else
    $isUserGrantedToModifyMessage = false;

if ($isUserGrantedToModifyMessage == false) // on récupère la valeur mis en dur pour des agents admin du site
    $isUserGrantedToModifyMessage = getUserCanModifyAlerteMessage();

if ($isUserGrantedToModifyMessage == false)
    die('Accès interdit');

//
if (isset($_POST['message_information']) && trim($_POST['message_information']) != '')
{
    $ch = '<?'."\n";
    $ch .= '/*********************************'."\n";
    $ch .= ' * Fichier généré automatiquement'."\n";
    $ch .= ' * ATTENTION !!'."\n";
    $ch .= ' * NE PAS EDITER !!'."\n";
    $ch .= ' ********************************/'."\n\n";
    $ch .= '$tabSiteMessage = array('."\n";
    
    $date = mktime ($_POST['message_dateh'], $_POST['message_datei'], $_POST['message_dates'], $_POST['message_datem'], $_POST['message_datej'],$_POST['message_datea']);
    
    $ch .= "\t\t".'\'MESSAGE\' => "'.str_replace('"', '\"', trim($_POST['message_information'])).'",'."\n";
    $ch .= "\t\t".'\'DATE\' => "'.str_replace('"', '\"', $date).'",'."\n";
    $ch .= "\t\t".'\'COLOR\' => "'.str_replace('"', '\"', $_POST['color']).'",'."\n";
    $ch .= "\t".');'."\n";
    $ch .= "?>";
    
    $fic = fopen($DATA_PATH.'/config_message.php', 'w');
    fwrite($fic, $ch);
    fclose($fic);
}

if (isset($_POST['message_information_general']) && trim($_POST['message_information_general']) != '')
{
    $ch = '<?'."\n";
    $ch .= '/*********************************'."\n";
    $ch .= ' * Fichier généré automatiquement'."\n";
    $ch .= ' * ATTENTION !!'."\n";
    $ch .= ' * NE PAS EDITER !!'."\n";
    $ch .= ' ********************************/'."\n\n";
    $ch .= '$tabSiteMessageGeneral = array('."\n";
    
    $date = mktime ($_POST['message_general_dateh'], $_POST['message_general_datei'], $_POST['message_general_dates'], $_POST['message_general_datem'], $_POST['message_general_datej'],$_POST['message_general_datea']);
    
    $ch .= "\t\t".'\'MESSAGE\' => "'.str_replace('"', '\"', trim($_POST['message_information_general'])).'",'."\n";
    $ch .= "\t\t".'\'DATE\' => "'.str_replace('"', '\"', $date).'",'."\n";
    $ch .= "\t\t".'\'COLOR\' => "'.str_replace('"', '\"', $_POST['color2']).'",'."\n";
    $ch .= "\t".');'."\n";
    $ch .= "?>";
    
    $fic = fopen(COMMON_PATH.'/data/config_message.php', 'w');
    fwrite($fic, $ch);
    fclose($fic);
}

deconnexionDesBases();
header('Location: index.php?P=A');
exit;

?>