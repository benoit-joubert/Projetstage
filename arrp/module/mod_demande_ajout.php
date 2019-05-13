<?php
$id_demandeur = isset($_POST['demandeur']) ? $_POST['demandeur'] : (isset($_GET['demandeur']) ? $_GET['demandeur'] : '');
$id_demande = isset($_POST['demande']) ? $_POST['demande'] : (isset($_GET['demande']) ? $_GET['demande'] : '');
$code_com = isset($_POST['code_com']) ? $_POST['code_com'] : (isset($_GET['code_com']) ? $_GET['code_com'] : $_SESSION[PROJET_NAME]['default_com']);
$from = isset($_POST['from']) ? $_POST['from'] : (isset($_GET['from']) ? $_GET['from'] : '201');
$action = isset($_POST['action']) ? $_POST['action'] : (isset($_GET['action']) ? $_GET['action'] : '');
$token = isset($_POST['token']) ? $_POST['token'] : (isset($_GET['token']) ? $_GET['token'] : '');
if(!isset($_SESSION[PROJET_NAME]['token'])){
    $_SESSION[PROJET_NAME]['token'] = '';
}

$msgDeleteFile = '';
$msgDeleteIcone = '';
$token = generateToken(6);
$_SESSION[PROJET_NAME]['token'] = $token;

$Demande = new ArrpDemandes($db);
$Demande->select(array('id_demande'=>$id_demande));
$id_demande     = $Demande->getIdDemande();
if($id_demande != ''){
    $id_demandeur   = $Demande->getIdDemandeur();
    $code_com       = $Demande->getCodeCom();
}
$contact            = $Demande->getContact();
$reference          = $Demande->getReference();
$date_demande       = $Demande->getDateDemande();
$date_reponse       = $Demande->getDateReponse();
$statut_demande     = $Demande->getStatutDemande();
$statut_aep         = $Demande->getStatutAep();
$statut_eu          = $Demande->getStatutEu();
$observations       = $Demande->getObservations();
$url_carte          = $Demande->getUrlCarte();
$id_signataire      = $Demande->getIdSignataire();
$id_attestant       = $Demande->getIdAttestant();
$id_interlocuteur   = $Demande->getIdInterlocuteur();


$_SESSION[PROJET_NAME]['ID_DEMANDE'] = $id_demande;

$Demandeur = new ArrpDemandeurs($db);
$Demandeur->select(array('id_demandeur'=>$id_demandeur));
$id_demandeur   = $Demandeur->getIdDemandeur();
$nom            = $Demandeur->getNom();
$prenom         = $Demandeur->getPrenom();
$demandeur = $nom . ' ' . $prenom;

if($code_com == ''){
    $code_com = $_SESSION[PROJET_NAME]['default_com'];
}
if(!in_array($code_com,$_SESSION[PROJET_NAME]['tab_code_com'])){
    die('Commune non valide');
}
$_SESSION[PROJET_NAME]['CODE_COM'] = $code_com;

$tabCommune = getCommunes($db,'CODE_COM=\'' . $code_com . '\'');
$lib_commune            = $tabCommune[$code_com]['LIB_COMMUNE'];
$mode_gest_voie         = $tabCommune[$code_com]['MODE_GEST_VOIE'];
$mode_gest_parc         = $tabCommune[$code_com]['MODE_GEST_PARC'];
$last_num_voie          = $tabCommune[$code_com]['LAST_NUM_VOIE'];
$format_parc_nb_lettre  = $tabCommune[$code_com]['FORMAT_PARC_NB_LETTRE'];
$format_parc_nb_chiffre = $tabCommune[$code_com]['FORMAT_PARC_NB_CHIFFRE'];

if($id_demande == ''){
    $tab = getCommunes($db,'CODE_COM in(' . $_SESSION[PROJET_NAME]['code_com'] . ')');
    //$SelectCommune = '<select style="width:370px;" name="code_com" id="code_com" onChange="window.location=\'./index.php?P=301&from='.$from.'&demandeur='.$id_demandeur.'&code_com=\'+this.value;">';
    $SelectCommune = '<select style="width:370px;" name="code_com" id="code_com">';
    $SelectCommune .= '<option value="">----</option>';
    foreach($tab as $k => $v){
        $SelectCommune .= '<option value="' . $v['CODE_COM'] . '">' . $v['LIB_COMMUNE'] . '</option>';
    }
    $SelectCommune .= '</select>';
    $SelectCommune = str_replace('value="'.$code_com.'"', 'value="'.$code_com.'" selected', $SelectCommune);
}

if($id_demandeur == ''){
    $tab = getDemandeurs($db);
    $SelectDemandeur = '<select style="width:370px;" name="id_demandeur" id="id_demandeur">';
    $SelectDemandeur .= '<option value="">----</option>';
    foreach($tab as $k => $v){
        $SelectDemandeur .= '<option value="' . $v['ID_DEMANDEUR'] . '">' . $v['NOM'] . ' ' . $v['PRENOM'] . '</option>';
    }
    $SelectDemandeur .= '</select>';
}
$SelectStatut = '<select class="tail3" name="statut_demande" id="statut_demande">';
    foreach($TAB_STATUT as $k => $v){
        $SelectStatut .= '<option value="' . $k . '">' . $v . '</option>';
    }
$SelectStatut .= '</select>';
$SelectStatut = str_replace('value="'.$statut_demande.'"', 'value="'.$statut_demande.'" selected', $SelectStatut);

$SelectStatut_Aep = '<select class="tail3" name="statut_aep" id="statut_aep">';
    $SelectStatut_Aep .= '<option value="">----</option>';
    $SelectStatut_Aep .= '<option value="1">OUI</option>';
    $SelectStatut_Aep .= '<option value="0">NON</option>';
$SelectStatut_Aep .= '</select>';
$SelectStatut_Aep = str_replace('value="'.$statut_aep.'"', 'value="'.$statut_aep.'" selected', $SelectStatut_Aep);

$SelectStatut_Eu = '<select class="tail3" name="statut_eu" id="statut_eu">';
    $SelectStatut_Eu .= '<option value="">----</option>';
    $SelectStatut_Eu .= '<option value="1">OUI</option>';
    $SelectStatut_Eu .= '<option value="0">NON</option>';
$SelectStatut_Eu .= '</select>';
$SelectStatut_Eu = str_replace('value="'.$statut_eu.'"', 'value="'.$statut_eu.'" selected', $SelectStatut_Eu);

$tab = getAgent($db,'ACTIF=1 AND TYPE_AGENT=\'INTERLOCUTEUR\'');
$SelectInterlocuteur = '<select style="width:370px;" name="id_interlocuteur" id="id_interlocuteur">';
    $SelectInterlocuteur .= '<option value="">----</option>';
    foreach($tab as $k => $v){
        if($id_demande == '' && $v['IS_DEFAULT']=='1'){
            $id_interlocuteur = $k;
        }
        $SelectInterlocuteur .= '<option value="' . $k . '">' . $v['AGENT'] . '</option>';
    }
$SelectInterlocuteur .= '</select>';
$SelectInterlocuteur = str_replace('value="'.$id_interlocuteur.'"', 'value="'.$id_interlocuteur.'" selected', $SelectInterlocuteur);

$tab = getAgent($db,'ACTIF=1 AND TYPE_AGENT=\'ATTESTANT\'');
$SelectAttestant = '<select style="width:370px;" name="id_attestant" id="id_attestant">';
    $SelectAttestant .= '<option value="">----</option>';
    foreach($tab as $k => $v){
        if($id_demande == '' && $v['IS_DEFAULT']=='1'){
            $id_attestant = $k;
        }
        $SelectAttestant .= '<option value="' . $k . '">' . $v['AGENT'] . '</option>';
    }
$SelectAttestant .= '</select>';
$SelectAttestant = str_replace('value="'.$id_attestant.'"', 'value="'.$id_attestant.'" selected', $SelectAttestant);

$tab = getAgent($db,'ACTIF=1 AND TYPE_AGENT=\'SIGNATAIRE\'');
$SelectSignataire = '<select style="width:370px;" name="id_signataire" id="id_signataire">';
    $SelectSignataire .= '<option value="">----</option>';
    foreach($tab as $k => $v){
        if($id_demande == '' && $v['IS_DEFAULT']=='1'){
            $id_signataire = $k;
        }
        $SelectSignataire .= '<option value="' . $k . '">' . $v['AGENT'] . '</option>';
    }
$SelectSignataire .= '</select>';
$SelectSignataire = str_replace('value="'.$id_signataire.'"', 'value="'.$id_signataire.'" selected', $SelectSignataire);


$BOUTTONS = array();
if(in_array('admin',$_SESSION[PROJET_NAME]['droit']) || in_array('saisie',$_SESSION[PROJET_NAME]['droit'])){
    $BOUTTONS[] = array(
                        'ACTION' => 'ValiderFormulaireDemande();',  
                        'ID' => 'bouton_submit_F1',
                        'TXT' => 'Sauver',
                        'IMG' => $page->getDesignUrl().'/images/toolbar/icon-32-save.png',
                        'TITLE' => 'Sauver',
                        );
 
     if($id_demande != ''){
        $BOUTTONS[] = array(
                            'ACTION' => 'ImprimerCourrier();',  
                            'ID' => 'bouton_primt_F1',
                            'TXT' => 'Imprimer',
                            'IMG' => $page->getDesignUrl().'/images/toolbar/icon-32-print.png',
                            'TITLE' => 'Sauver',
                            );
    }
}

if($id_demande != ''){
    $BOUTTONS[] = array(
                        'HREF' => './index.php?P=6&id_demande=' . $id_demande.'&from=' . $from . '&MapFrom=301',
                        'TXT' => 'Carte',
                        'IMG' => $GENERAL_URL.'/images/earth_location_32.png',
                        'TITLE' => 'Carte',
                       );
}

if($id_demande != '' && in_array('admin',$_SESSION[PROJET_NAME]['droit'])){
    $BOUTTONS[] = array(
                        'ACTION' => 'SupprimerDemande('.$id_demandeur.','.$id_demande.',201);',  
                        'ID' => 'bouton_submit_F1',
                        'TXT' => 'Supprimer',
                        'IMG' => $page->getDesignUrl().'/images/toolbar/icon-32-delete.png',
                        'TITLE' => 'Supprimer cette demande',
                        );    
}

$BOUTTONS[] = array(
                    'ACTION' => "javascript:window.location='index.php?P=" . $from . "&demandeur=".$id_demandeur."';",
                    'TXT' => 'Retour',
                    'IMG' => $page->getDesignUrl().'/images/toolbar/icon-32-back.png',
                    'TITLE' => 'Retour',
                   );

$page->afficheHeader();
?>

<form id="F1" name="F1" method="post" action="./index.php" enctype="multipart/form-data">
    <?php
    echo '<input type="hidden" name="P" value="302">';
    if($id_demandeur != ''){
        echo '<input type="hidden" name="id_demandeur" value="' . $id_demandeur . '">';
    }
    echo '<input type="hidden" name="id_demande" value="' . $id_demande . '">';
    echo '<input type="hidden" name="action" value="">';
    echo '<input type="hidden" name="token" value="' . $token . '">';
    echo '<input type="hidden" name="from" value="' . $from . '">';
    ?>
    <table class="admintable" style="width:100%;">
        <tr>
            <td style="vertical-alig:top; width:45%;">
                <fieldset class="adminform" style="background-color:#F4F4F4;">
                <legend>Demande <?echo ($id_demande=='' ? '' : '<small>#'.$id_demande.'</small>')?></legend>
                    <table class="admintable">
                        <tr>
                            <td class="key">Commune :</td>
                            <td>
                            <?php
                            if($id_demande == ''){
                                echo $SelectCommune;
                            }else{
                                echo '<input type="hidden" name="code_com" id="code_com" value="'.$code_com.'" />';
                                echo '<input type="text" name="lib_commune" id="lib_commune" class="span4"  value="'.$lib_commune.'" readonly />';
                            }
                            ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="key">
                                Demandeur :
                                <?php
                                    if($id_demandeur != ''){
                                        echo '<a href="./index.php?P=201&demandeur='.$id_demandeur.'&demande=' . $id_demande . '&from=301"><img src="./images/user1_into_24.png" title="Afficher le demandeur"/></a>';
                                    }
                                ?>
                            </td>
                            <td>
                            <?php
                            if($id_demandeur != ''){
                                echo '<input type="text" name="demandeur" id="demandeur" class="span4"  value="'.$demandeur.'" readonly />';
                            }else{
                                echo $SelectDemandeur;
                            }
                            ?>
                            </td>
                        </tr>

                        <tr>
                            <td class="key">Contact :</td>
                            <td><input type="text" name="contact" id="contact" maxlength="64" class="span4"  value="<?=$contact?>" /></td>
                        </tr>
                        <tr>
                            <td class="key">Référence :</td>
                            <td><input type="text" name="reference" id="reference" maxlength="64" class="span4"  value="<?=$reference?>" /></td>
                        </tr>
                        <tr>
                            <td class="key">Date demande :</td>
                            <td><input type="text" name="date_demande" id="date_demande" maxlength="10" class="tailDate"  value="<?=$date_demande?>" /></td>
                        </tr>
                        <tr>
                            <td class="key">Date réponse :</td>
                            <td><input type="text" name="date_reponse" id="date_reponse" maxlength="10" class="tailDate"  value="<?=$date_reponse?>" /></td>
                        </tr>
                        <tr>
                            <td class="key">Statut :</td>
                            <td><?=$SelectStatut?></td>
                        </tr>
                        <tr>
                            <td class="key">Raccordable AEP:</td>
                            <td><?=$SelectStatut_Aep?></td>
                        </tr>
                        <tr>
                            <td class="key">Raccordable EU:</td>
                            <td><?=$SelectStatut_Eu?></td>
                        </tr>
                        <tr>
                            <td class="key">Interlocuteur :</td>
                            <td><?=$SelectInterlocuteur?></td>
                        </tr>
                        <tr>
                            <td class="key">Attestant :</td>
                            <td><?=$SelectAttestant?></td>
                        </tr>
                        <tr>
                            <td class="key">Signataire :</td>
                            <td><?=$SelectSignataire?></td>
                        </tr>
                        <tr>
                            <td class="key">Observations :</td>
                            <td><textarea name="observations" id="observations" rows="2" style="width:550px;"><?=$observations?></textarea></td>
                        </tr>
                    </table>
                </fieldset>
                <div id="dialog-erreur"></div>
                <div id="dialog-confirm"></div>
            </td>
            <td style="vertical-align: top; width:65%;">
            <?php
            if($id_demande != ''){
                $where = 'ID_DEMANDE=\'' . protegeChaine($id_demande) . '\'';
                echo '<fieldset class="adminform" style="background-color:#F4F4F4;">';
                    echo '<legend>Parcelle &nbsp;';
                    if(in_array('admin',$_SESSION[PROJET_NAME]['droit']) || in_array('saisie',$_SESSION[PROJET_NAME]['droit'])){
                        echo '<a href="javascript:void(0)" onClick="AddParcelle()"><img src="./images/add_24.png" /></a>';
                    }
                    echo '</legend>';
                    echo '<div id="msgAddParcelle" class="msgAdd"></div>';
                    echo '<div id="DivParcelle">';
                        $tabParc = getDemandesParcelles($db,$where);
                        $chParc = getChaineForDemandesParcelles($tabParc);
                        echo $chParc;
                    echo '</div>';
                echo '</fieldset>';
                echo '<fieldset class="adminform" style="background-color:#F4F4F4;">';
                    echo '<legend>Rue &nbsp;';
                    if(in_array('admin',$_SESSION[PROJET_NAME]['droit']) || in_array('saisie',$_SESSION[PROJET_NAME]['droit'])){
                        echo '<a href="javascript:void(0)" onClick="AddVoie()"><img src="./images/add_24.png" /></a>';
                    }
                    echo '</legend>';
                    echo '<div id="msgAddVoie" class="msgAdd"></div>';
                    echo '<div id="DivVoie">';
                        $tabVoie = getDemandesVoies($db,$where);
                        $chVoie = getChaineForDemandesVoies($tabVoie);
                        echo $chVoie;
                    echo '</div>';
                echo '</fieldset>';
                echo '<fieldset class="adminform" style="background-color:#F4F4F4;">';
                    echo '<legend>Documents &nbsp;';
                    if(in_array('admin',$_SESSION[PROJET_NAME]['droit']) || in_array('saisie',$_SESSION[PROJET_NAME]['droit'])){
                        echo '<a href="javascript:void(0)" onClick="AddDocument()"><img src="./images/add_24.png" /></a>';
                    }
                    echo '</legend>';
                    echo '<div id="msgAddDoc" class="msgAdd"></div>';
                    echo '<div id="DivDocument">';
                        $tabDoc = getDocuments($db,$where);
                        $chDoc = getChaineForDemandesDocuments($tabDoc);
                        echo $chDoc;
                    echo '</div>';
                echo '</fieldset>';
                echo '</fieldset>';
            }
            ?>
            </td>
        </tr>

    </table>
</form>
<div id="dialog-add">
    <form name="F2" id="F2">
    <br/>
    <table>
        <tr>
            <td>Commune:</td><td style="text-align:left;"><?=$lib_commune?></td>
        </tr>
        <tr>
        <?php
            if($code_com == '13001'){ //AIX
                $sql = 'select distinct nsec from sigaix.parcelle_c_s order by nsec';
                $res = executeReq($db,$sql);
                $SelectNsec = '<select style="width:90px;" name="SelectNsec" id="SelectNsec" onChange="ChargeSelectParcelle();">';
                    $SelectNsec .= '<option value="-1">----</option>';
                    while(list($nsec) = $res->fetchRow()){
                        $SelectNsec .= '<option value="' . $nsec . '">' . $nsec . '</option>';
                    }
                $SelectNsec .= '</select>';
                echo '<td style="width:80px;border:1px;">Section: </td><td style="text-align:left;">' . $SelectNsec . '</td>';
            }else{
                echo '<td style="width:80px;border:1px;">Section: </td>';
                echo '<td style="text-align:left;"><input type="text" class="span1" name="SelectNsec" id="SelectNsec" maxlength="2" value="" /></td>';
            }
            
        ?>
        </tr>
        <tr>
            <td>Parcelle:</td>
            <td style="text-align:left;">
            <div name="DivParcelle" id="DivParcelle">
                <?php
                if($code_com == '13001'){
                    echo '<select style="width:90px;" name="SelectParcelle" id="SelectParcelle"><option value="-1">----</option></select> ou ';
                }else{
                    echo '<input type="hidden" name="SelectParcelle" id="SelectParcelle" value="">';
                }
                ?>
                <input type="text" class="span1" name="id_parc" id="id_parc" maxlength="<?=$format_parc_nb_chiffre?>" value="" />
            </div>
            </td>
        </tr>
    </table>
        <input type="hidden" name="format_parc_nb_lettre" id="format_parc_nb_lettre" value="<?=$format_parc_nb_lettre?>" />
        <input type="hidden" name="format_parc_nb_chiffre" id="format_parc_nb_chiffre" value="<?=$format_parc_nb_chiffre?>" />
    </form>
</div>
<div id="dialog-addVoie">
    <br/>
    <table>
        <tr>
            <td>Commune:</td><td style="text-align:left;"><?=$lib_commune?></td>
        </tr>
        <tr>
            <td style="width:75px;">Voie:</td>
            <td style="text-align:left;width:300px;">
                <?php
                    $tab = getVoie($db,$code_com);
                    $SelectVoie = '<select style="width:355px;" name="cdruru" id="cdruru" onChange="ChangeRue(this)">';
                        $SelectVoie .= '<option value="-1">-----</option>';
                        foreach($tab as $k => $v){
                            $SelectVoie .= '<option value="' . $k . '">' . $v['VOIE'] . '</option>';
                        }
                    $SelectVoie .= '</select>';
                    echo $SelectVoie;
                ?>
            </td>
        </tr>
        <?php
            if($code_com == '13001'){
                echo '<input type="hidden" name="libelle_voie" id="libelle_voie" />';
            }else{
                echo '<tr>'.
                        '<td>&nbsp;</td>'.
                        '<td><input type="text" style="width:345px;" name="libelle_voie" id="libelle_voie" /></td>'.
                     '</tr>';
            }
        ?>
    </table>

</div>

<div id="dialog-addDoc">
    <form name="F3" id="F3" method="post" enctype="multipart/form-data">
    <input type="hidden" name="P" value="303">
    <input type="hidden" name="id_demande" value="<?=$id_demande?>" />
    <input type="hidden" name="action" value="AddDOCUMENT" />
    <br/>
    <table>
        <tr>
            <td>Commune:</td><td style="text-align:left;"><?=$lib_commune?></td>
        </tr>
        <tr>
            <td style="width:75px;">Document:</td>
            <td style="text-align:left;">
                <input type="text" style="width:370px;" name="nom_doc" id="nom_doc" maxlength="128" value="" />
            </td>
        </tr>
        <tr>
            <td>Fichier:</td>
            <td style="text-align:left;">
                <input type="file" style="width:380px;" name="fichier" id="fichier" value="" />
            </td>
        </tr>
    </table>
    </form>
</div>
<div id="flash_success"></div>
<script type="text/javascript" language="JavaScript">
    function ChangeRue(rue){
        var code_com = "<?=$code_com?>";
        if(code_com != '13001'){
            if(rue.selectedIndex > 0){
                document.getElementById("libelle_voie").value="";
                document.getElementById("libelle_voie").style.visibility = 'hidden';
                //$("#libelle_voie").style="disabled='disbled'";
            }else{
                document.getElementById("libelle_voie").style.visibility = 'visible';
            }
        }
        
    }
    $(document).ready( function() {
        $("#date_demande").datetimepicker({    
            defaultDate:"<?=($date_demande=='' ? date('d/m/Y') : $date_demande)?>"
        });
        $("#date_reponse").datetimepicker({    
            defaultDate:"<?=($date_reponse=='' ? date('d/m/Y') : $date_reponse)?>"
        });
        //alert(document.getElementById('SelectNsec').selectedIndex );
        if(typeof(document.getElementById('SelectNsec').selectedIndex) !== 'undefined'){
            $("#SelectNsec").select2();
        }
        $("#cdruru").select2();
        if(typeof(document.getElementById('SelectParcelle').selectedIndex) !== 'undefined'){
            $("#SelectParcelle").select2();
        }
        <?php
        if($id_demandeur == ''){
            echo '$("#id_demandeur").select2();';
        }
        if($id_demande == ''){
            echo '$("#code_com").select2();';
        }
        ?>
        $("#statut_demande").select2();
        $("#id_interlocuteur").select2();
        $("#id_attestant").select2();
        $("#id_signataire").select2();
        $("#statut_eu").select2();
        $("#statut_aep").select2();
        $("#dialog-add").dialog();
        $("#dialog-add").dialog('close');
        $("#dialog-addVoie").dialog();
        $("#dialog-addVoie").dialog('close');
        $("#dialog-addDoc").dialog();
        $("#dialog-addDoc").dialog('close');

        var options = { 
                            target:        '#flash_success',  // your response show in this ID
                            success:       afterSuccess,
                            resetForm: true
                        };

        $("#F3").submit(function() {
            $(this).ajaxSubmit(options);
            // return false to prevent standard browser submit and page navigation
            return false;
        });

        var MSG = '';
        function afterSuccess()
        {
            
        }
    });
</script>
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