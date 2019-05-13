<?php
$id_agent = isset($_POST['agent']) ? $_POST['agent'] : (isset($_GET['agent']) ? $_GET['agent'] : '');
$action = isset($_POST['action']) ? $_POST['action'] : (isset($_GET['action']) ? $_GET['action'] : '');
$token = isset($_POST['token']) ? $_POST['token'] : (isset($_GET['token']) ? $_GET['token'] : '');
if(!isset($_SESSION[PROJET_NAME]['token'])){
    $_SESSION[PROJET_NAME]['token'] = generateToken(6);
}
if($_SESSION[PROJET_NAME]['token'] != $token){
    header("Location: ./index.php?P=8");
    exit;
}
$_SESSION[PROJET_NAME]['token'] = generateToken(6);
$param = '';
for($i=0;$i<6;$i++){
    $param .= ($param == '' ? '' : '##') . $_POST["LIGNE" . $i];
}
setParametre($db,'COURRIER_ENTETE',$param);
//$tab = explode('##',$courrier_entete);

$page->afficheHeader();

    echo 'Paramètre modifié';
    echo '<br/><img src="./images/loading.gif" />';
    echo '<script language="javascript">setTimeout("window.location=\'./index.php?P='.substr($P,0, strlen($P)-2).'\'",1000);</script>';

$page->afficheFooter();
?>