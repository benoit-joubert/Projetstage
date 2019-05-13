<?php
$action = isset($_POST['action']) ? $_POST['action'] : (isset($_GET['action']) ? $_GET['action'] : '');
$token = isset($_POST['token']) ? $_POST['token'] : (isset($_GET['token']) ? $_GET['token'] : '');
$id_agent = isset($_POST['id_agent']) ? $_POST['id_agent'] : (isset($_GET['id_agent']) ? $_GET['id_agent'] : '');
$type_agent = isset($_POST['type_agent']) ? $_POST['type_agent'] : (isset($_GET['type_agent']) ? $_GET['type_agent'] : '');
$agent = isset($_POST['agent']) ? $_POST['agent'] : '';
$actif = isset($_POST['actif']) ? $_POST['actif'] : '';
$is_default = isset($_POST['is_default']) ? $_POST['is_default'] : '';
$tel = isset($_POST['tel']) ? $_POST['tel'] : '';
$fax = isset($_POST['fax']) ? $_POST['fax'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$qualite = isset($_POST['qualite']) ? $_POST['qualite'] : '';
$qualite2 = isset($_POST['qualite2']) ? $_POST['qualite2'] : '';
if(!isset($_SESSION[PROJET_NAME]['token'])){
    $_SESSION[PROJET_NAME]['token'] = generateToken(6);
}
if(($_SESSION[PROJET_NAME]['token'] != $token) || ($type_agent != 'INTERLOCUTEUR' && $type_agent != 'ATTESTANT' && $type_agent != 'SIGNATAIRE')){
    header("Location: ./index.php?P=8");
    exit;
}
$_SESSION[PROJET_NAME]['token'] = generateToken(6);
$ok = 1;
$msg = '';
$BOUTTONS = array();
if($action == ''){
    $Agent = new ArrpAgents($db);
    $Agent->select(array('ID_AGENT'=>$id_agent));
    $Agent->setAgent($agent);
    $Agent->setActif($actif);
    $Agent->setIsDefault($is_default);
    $Agent->setQualite($qualite);
    $Agent->setQualite2($qualite2);
    $Agent->setTel($tel);
    $Agent->setFax($fax);
    $Agent->setEmail($email);
    if($id_agent == ''){
        $id_agent = getMaxId($db,'ARRP_AGENTS','ID_AGENT');
        $Agent->setIdAgent($id_agent);
        $Agent->setTypeAgent($type_agent);
        $res = $Agent->insert();
    }else{
        $res = $Agent->Update();
    }
    if (DB::isError($res)){
        $ok = 0;
        $msg = 'Erreur lors de la mise à jour des données..';
        $BOUTTONS[] = array(
                    'ACTION' => "javascript:window.location='index.php?P=" . substr($P,0,3) ."&agent=" . $id_agent . "&type=" . $type_agent . "';",
                    'TXT' => 'Retour',
                    'IMG' => $GENERAL_URL.'/images/nav_left_green.png',
                    'TITLE' => 'Retour',
                   );
    }else{
        if($is_default == '1'){
            $sql = 'update ARRP_AGENTS set is_default=0 where type_agent=\'' . $type_agent . '\' AND is_default=1 AND ID_AGENT != \'' . $id_agent . '\'';
            $curs = executeReq($db,$sql);
        }
        $msg = 'Données modifiées..';
    }
}elseif($action == 'supprimer'){
    $sql = 'select count(*) from ARRP_DEMANDES WHERE ID_'.$type_agent . '=\'' . protegeChaineOracle($id_agent) . '\'';
    $res = executeReq($db,$sql);
    list($nb) = $res->fetchRow();
    $P = substr($P,0, strlen($P)-2);
    if($nb==0){
        $sql = 'delete from ARRP_AGENTS WHERE ID_AGENT=\'' . protegeChaineOracle($id_agent) . '\' AND TYPE_AGENT=\'' . $type_agent . '\'';
        executeReq($db,$sql);
        $id_agent = '';
        $msg = ($type_agent == 'INTERLOCUTEUR' ? 'Interlocuteur' : ($type_agent == 'ATTESTANT' ? 'Attestant' : 'Signataire')) . ' supprimé';
    }else{
        $BOUTTONS = array();
        $BOUTTONS[] = array(
                    'ACTION' => "javascript:window.location='index.php?P=" . substr($P,0,3) ."&agent=" . $id_agent . "&type=" . $type_agent . "';",
                    'TXT' => 'Retour',
                    'IMG' => $GENERAL_URL.'/images/nav_left_green.png',
                    'TITLE' => 'Retour',
                   );
        $ok = 0;
        $msg =  'Impossible de supprimer ' . ($type_agent == 'INTERLOCUTEUR' ? 'l\'Interlocuteur' : ($type_agent == 'ATTESTANT' ? 'l\'Attestant' : 'le Signataire')) . '.<br/>'.
                'Des demandes lui font référence';
    }
}

$page->afficheHeader();

echo $msg;

if($ok == 1){
    echo '<br/><img src="./images/loading.gif" />';
    echo '<script language="javascript">setTimeout("window.location=\'./index.php?P='.substr($P,0, strlen($P)-2).'&agent='.$id_agent.'&type='.$type_agent.'\'",1000);</script>';
}

$page->afficheFooter();
?>