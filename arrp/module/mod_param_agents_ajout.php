<?php
$id_agent = isset($_POST['agent']) ? $_POST['agent'] : (isset($_GET['agent']) ? $_GET['agent'] : '');
$action = isset($_POST['action']) ? $_POST['action'] : (isset($_GET['action']) ? $_GET['action'] : '');
$token = isset($_POST['token']) ? $_POST['token'] : (isset($_GET['token']) ? $_GET['token'] : '');
$token = generateToken(6);
$_SESSION[PROJET_NAME]['token'] = $token;

$Agent = new ArrpAgents($db);
$Agent->select(array('ID_AGENT'=>$id_agent));

$id_agent       = $Agent->getIdAgent();
$agent          = $Agent->getagent();
$type_agent     = $Agent->getTypeAgent();
$qualite        = $Agent->getQualite();
$qualite2       = $Agent->getQualite2();
$tel            = $Agent->getTel();
$fax            = $Agent->getFax();
$email          = $Agent->getEmail();
$actif          = $Agent->getActif();
$is_default     = $Agent->getIsDefault();
if($id_agent == ''){
    $actif      = '1';
    $is_default = '0';
}
if($type_agent == ''){
    if(substr($P,0,3) == '801'){
        $type_agent = 'INTERLOCUTEUR';
    }elseif(substr($P,0,3) == '802'){
        $type_agent = 'ATTESTANT';
    }elseif(substr($P,0,3) == '803'){
        $type_agent = 'SIGNATAIRE';
    }
}
if($type_agent != 'INTERLOCUTEUR' && $type_agent != 'ATTESTANT' && $type_agent != 'SIGNATAIRE'){
    header("Location: ./index.php?P=8");
    exit;
}
if($type_agent == 'INTERLOCUTEUR'){
    $lib = 'Interloculteur';
}elseif($type_agent == 'ATTESTANT'){
    $lib = 'Attestant';
}else{
    $lib = 'Signataire';
}

$SelectAgentActif = '<select class="tailOuiNon" name="actif" id="actif">';
    $SelectAgentActif .= '<option value="">----</option>';
    $SelectAgentActif .= '<option value="1">OUI</option>';
    $SelectAgentActif .= '<option value="0">NON</option>';
$SelectAgentActif .= '</select>';
$SelectAgentActif = str_replace('value="'.$actif.'"', 'value="'.$actif.'" selected', $SelectAgentActif);

$SelectIsDefault = '<select class="tailOuiNon" name="is_default" id="is_default">';
    $SelectIsDefault .= '<option value="1">OUI</option>';
    $SelectIsDefault .= '<option value="0">NON</option>';
$SelectIsDefault .= '</select>';
$SelectIsDefault = str_replace('value="'.$is_default.'"', 'value="'.$is_default.'" selected', $SelectIsDefault);


$BOUTTONS = array();
$BOUTTONS[] = array(
                    'ACTION' => 'ValiderFormulaireAgent(\'' . $type_agent . '\');',  
                    'ID' => 'bouton_submit_F1',
                    'TXT' => 'Sauver',
                    'IMG' => $page->getDesignUrl().'/images/toolbar/icon-32-save.png',
                    'TITLE' => 'Sauver',
                    );
$BOUTTONS[] = array(
                    'ACTION' => "javascript:window.location='index.php?P=" . substr($P,0,3) ."&type=" . $type_agent . "';",
                    'TXT' => 'Retour',
                    'IMG' => $page->getDesignUrl().'/images/toolbar/icon-32-back.png',
                    'TITLE' => 'Retour',
                   );

$page->afficheHeader();
?>

<form id="F1" name="F1" method="post" action="./index.php" enctype="multipart/form-data">
    <?php
    echo '<input type="hidden" name="P" value="' . $P . '01">';
    echo '<input type="hidden" name="id_agent" value="' . $id_agent . '">';
    echo '<input type="hidden" name="action" value="">';
    echo '<input type="hidden" name="type_agent" value="' . $type_agent . '">';
    echo '<input type="hidden" name="token" value="' . $token . '">';
    ?>
    <table class="admintable" style="width:100%;">
        <tr>
            <td style="vertical-alig:top; width:50%;">
                <fieldset class="adminform" style="background-color:#F4F4F4;">
                <legend><?echo $lib . ' ' . ($id_agent=='' ? '' : '<small>#'.$id_agent.'</small>')?></legend>
                    <table class="admintable">
                        <tr>
                            <td class="key"><?=$lib?> :</td>
                            <td><input type="text" name="agent" id="agent" maxlength="64" class="span4"  value="<?=$agent?>" /></td>
                        </tr>
                        <?php
                            if($type_agent == 'INTERLOCUTEUR'){
                                echo '
                                <tr>
                                    <td class="key">Téléphone :</td>
                                    <td><input type="text" name="tel" id="tel" maxlength="32" class="span2"  value="' . $tel . '" /></td>
                                </tr>
                                <tr>
                                    <td class="key">Fax :</td>
                                    <td><input type="text" name="fax" id="fax" maxlength="32" class="span2"  value="' . $fax . '" /></td>
                                </tr>
                                <tr>
                                    <td class="key">Email :</td>
                                    <td><input type="text" name="email" id="email" maxlength="128" class="span4"  value="' . $email . '" /></td>
                                </tr>
                                ';
                            }else{
                                echo '
                                <tr>
                                    <td class="key">Qualité :</td>
                                    <td><input type="text" name="qualite" id="qualite" maxlength="250" class="span7"  value="' . $qualite . '" /></td>
                                </tr>
                                ';
                            }
                        ?>
                        <tr>
                            <td class="key">Par défaut :</td>
                            <td><?=$SelectIsDefault?></td>
                        </tr>
                        <tr>
                            <td class="key">Actif :</td>
                            <td><?=$SelectAgentActif?></td>
                        </tr>
                    </table>
                </fieldset>
                <div id="dialog-erreur"></div>
            </td>
        </tr>

    </table>
</form>
<?php
/*
$ch .= '<form id="F1" name="F1" method="post" action="./index.php">'.
        '<input type="hidden" name="P" value="20101">'.
        '<input type="hidden" name="id_demandeur" id="id_demandeur" value="'.$id_demandeur.'" />';
    $ch .= '<div class="ui-corner-all custom-corners">'.
            '<div class="ui-bar ui-bar-a">'.
                '<h3>Widget</h3>'.
            '</div>'.
            '<div class="ui-body ui-body-a">'.
                '<div class="ui-field-contain">'.
                    '<label for="enseigne">Widget:</label>'.
                    '<div class="ui-input-text ui-body-inherit ui-corner-all ui-shadow-inset"><input name="widget_libelle" id="widget_libelle" type="text" maxlength="64" value="' . $widget_libelle . '" /></div>'.
                '</div>'.
                '<div class="ui-field-contain">'.
                    '<label for="nom_commerce">Description :</label>'.
                    '<div class="ui-input-text ui-body-inherit ui-corner-all ui-shadow-inset"><input name="widget_desc" id="widget_desc" type="text" maxlength="256"  value="' . $widget_desc .'" /></div>'.
                '</div>'.
            '</div>'.
            '<div class="ui-bar ui-bar-a">'.
                '<h3>Liens</h3>'.
            '</div>'.
            '<div class="ui-body ui-body-a">'.
                
            '</div>';
            if($id_demandeur == 'xx'){
                //$tabDispositifs = getDispositifsForEtablissements($rowid_etablissement);
                $ch .=  '<div class="ui-bar ui-bar-a">'.
                            '<h3>Aperçu</h3>'.
                        '</div>'.
                        '<div class="ui-body ui-body-a">';
                            
                            

                $ch .=  '</div>';
            }
$ch .= '</div><!-- <div class="ui-corner-all custom-corners"> -->';

$ch .= '</form>';
*/

//echo $ch;

$page->afficheFooter();
?>