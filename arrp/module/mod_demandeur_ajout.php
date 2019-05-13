<?php
$id_demandeur = isset($_POST['demandeur']) ? $_POST['demandeur'] : (isset($_GET['demandeur']) ? $_GET['demandeur'] : '');
$id_demande = isset($_POST['demande']) ? $_POST['demande'] : (isset($_GET['demande']) ? $_GET['demande'] : '');
$from = isset($_POST['from']) ? $_POST['from'] : (isset($_GET['from']) ? $_GET['from'] : '2');
$action = isset($_POST['action']) ? $_POST['action'] : (isset($_GET['action']) ? $_GET['action'] : '');
$token = isset($_POST['token']) ? $_POST['token'] : (isset($_GET['token']) ? $_GET['token'] : '');
if(!isset($_SESSION[PROJET_NAME]['token'])){
    $_SESSION[PROJET_NAME]['token'] = '';
}
$msgDeleteFile = '';
$msgDeleteIcone = '';
$token = generateToken(6);
$_SESSION[PROJET_NAME]['token'] = $token;

$Demandeur = new ArrpDemandeurs($db);
$Demandeur->select(array('id_demandeur'=>$id_demandeur));
$id_demandeur   = $Demandeur->getIdDemandeur();
$nom            = $Demandeur->getNom();
$prenom         = $Demandeur->getPrenom();
$adresse        = $Demandeur->getAdresse();
$adresse2       = $Demandeur->getAdresse2();
$cp             = $Demandeur->getCp();
$ville          = $Demandeur->getVille();
$tel1           = $Demandeur->getTel1();
$tel2           = $Demandeur->getTel2();
$email          = $Demandeur->getEmail();
$observations   = $Demandeur->getObservations();

$BOUTTONS = array();
if(in_array('admin',$_SESSION[PROJET_NAME]['droit']) || in_array('saisie',$_SESSION[PROJET_NAME]['droit'])){
    $BOUTTONS[] = array(
                        'ACTION' => 'ValiderFormulaireDemandeur();',  
                        'ID' => 'bouton_submit_F1',
                        'TXT' => 'Sauver',
                        'IMG' => $page->getDesignUrl().'/images/toolbar/icon-32-save.png',
                        'TITLE' => 'Sauver',
                        );
}
if($id_demandeur != '' && in_array('admin',$_SESSION[PROJET_NAME]['droit'])){
    $BOUTTONS[] = array(
                        'ACTION' => 'SupprimerDemandeur(' . $id_demandeur . ');',  
                        'ID' => 'bouton_submit_F1',
                        'TXT' => 'Supprimer',
                        'IMG' => $page->getDesignUrl().'/images/toolbar/icon-32-delete.png',
                        'TITLE' => 'Supprimer ce demandeur',
                        );    
}
$BOUTTONS[] = array(
                    'ACTION' => "javascript:window.location='./index.php?P=" . $from . "&demandeur=".$id_demandeur."&demande=" . $id_demande . "';",
                    'TXT' => 'Retour',
                    'IMG' => $page->getDesignUrl().'/images/toolbar/icon-32-back.png',
                    'TITLE' => 'Retour',
                   );

$page->afficheHeader();
?>
    <script type="text/javascript" charset="utf-8">
    $(document).ready(function() {
        <?php
        if($id_demandeur == ''){
            /*
            echo "$('#code_com').select2({
    				minimumResultsForSearch: 2,
    		});";
            */
        }
        ?>
    } );

</script> 
<script type="text/javascript" charset="utf-8">
    $(document).ready(function() {
        oTable = $('#ListDemande').DataTable({
            "aaSorting": [[ 0, "desc" ]],
            "bJQueryUI": false,
            "bPaginate": true,
            "bStateSave": false,
            "oLanguage": {
                            sSearch: 'Recherche:&nbsp;',
                            sInfo: 'Le total est de _TOTAL_ lignes (affichant de _START_ &agrave; _END_)',
                            sInfoFiltered: " - sur un total de _MAX_ lignes",
                            sInfoEmpty: "Aucune donn&eacute;e",
                            sLengthMenu: 'Afficher _MENU_ lignes&nbsp;&nbsp;&nbsp;',
                            sZeroRecords: 'Aucune donn&eacute;e trouv&eacute;e...',
                            oPaginate: {
                                            sNext: '<i class="arrowicon-r-black"></i>',
                                            sPrevious: '<i class="arrowicon-l-black"></i>',
                                            sFirst: "Premi&egrave;re",
                                            sLast: "Derni&egrave;re"
                            }
                        },
            "aLengthMenu": [[10, 20, 50], [10, 20, 50]],
            "aoColumns": [
                                    {"bSortable": true,"bSearchable": true,"sWidth": "25px"},
                                    {"bSortable": true,"bSearchable": true,"sWidth": "150px"},
                                    {"bSortable": true,"bSearchable": true},
                                    {"bSortable": true,"bSearchable": true},
                                    {"bSortable": true,"bSearchable": true,"sWidth": "60px"},
                                    {"bSortable": false,"bSearchable": false,"sWidth": "60px"},
                                    {"bSortable": false,"bSearchable": false,"sWidth": "30px"}
                                 ],
            "columnDefs": [
                              { className: "dt-right", "targets": [0] },
                              { className: "dt-center", "targets": [4,6] },
                              { className: "dt-nowrap", "targets": [0,1] }
                            ]
        });
        $('#ListDemande_length select').select2({
                minimumResultsForSearch: 2,
                width: "off"
        });
    } );
</script> 

<form id="F1" name="F1" method="post" action="./index.php" enctype="multipart/form-data">
    <?php
    echo '<input type="hidden" name="P" value="202">';
    echo '<input type="hidden" name="id_demandeur" value="' . $id_demandeur . '">';
    echo '<input type="hidden" name="action" value="">';
    echo '<input type="hidden" name="token" value="' . $token . '">';
    ?>
    <table class="admintable" style="width:100%;">
        <tr>
            <td style="vertical-alig:top; width:45%;">
                <fieldset class="adminform" style="background-color:#F4F4F4;">
                <legend>Demandeur <?echo ($id_demandeur=='' ? '' : '<small>#'.$id_demandeur.'</small>')?></legend>
                    <table class="admintable">
                        <tr>
                            <td class="key">Nom ou Dénomination :</td>
                            <td><input type="text" name="nom" id="nom" maxlength="128" class="span4"  value="<?=$nom?>" /></td>
                        </tr>
                        <tr>
                            <td class="key">Prénom ou Dénomination 2:</td>
                            <td><input type="text" name="prenom" id="prenom" maxlength="64" class="span4"  value="<?=$prenom?>" /></td>
                        </tr>
                        <tr>
                            <td class="key">Adresse :</td>
                            <td><input type="text" name="adresse" id="adresse" maxlength="128" class="span6"  value="<?=$adresse?>" /></td>
                        </tr>
                        <tr>
                            <td class="key">Complément Adresse :</td>
                            <td><input type="text" name="adresse2" id="adresse2" maxlength="128" class="span6"  value="<?=$adresse2?>" /></td>
                        </tr>
                        <tr>
                            <td class="key">CP, Ville :</td>
                            <td>
                                <input type="text" name="cp" id="cp" maxlength="5" class="tail2" value="<?=$cp?>" />&nbsp;
                                <input type="text" name="ville" id="ville" maxlength="128" style="width:480px;" value="<?=$ville?>" />
                            </td>
                        </tr>
                        <tr>
                            <td class="key">Téléphone :</td>
                            <td><input type="text" name="tel1" id="tel1" maxlength="16" class="span3"  value="<?=$tel1?>" /></td>
                        </tr>
                        <tr>
                            <td class="key">Portable :</td>
                            <td><input type="text" name="tel2" id="tel2" maxlength="16" class="span3"  value="<?=$tel2?>" /></td>
                        </tr>
                        <tr>
                            <td class="key">Email :</td>
                            <td><input type="text" name="email" id="email" maxlength="128" class="span4"  value="<?=$email?>" /></td>
                        </tr>
                        <tr>
                            <td class="key">Observations :</td>
                            <td><textarea name="observations" id="observations" rows="2" style="width:550px;"><?=$observations?></textarea></td>
                        </tr>
                    </table>
                </fieldset>
                <div id="dialog-erreur"></div>
            </td>
            <td style="vertical-align: top; width:65%;">
            <?php
            if($id_demandeur != ''){
                $where = 'ID_DEMANDEUR=\'' . protegeChaine($id_demandeur) . '\'';
                $tab = getDemandes($db,$where);
                echo '<fieldset class="adminform" style="background-color:#F4F4F4;">';
                    echo '<legend>Demandes &nbsp;';
                    if(in_array('admin',$_SESSION[PROJET_NAME]['droit']) || in_array('saisie',$_SESSION[PROJET_NAME]['droit'])){
                        echo '<a href="./index.php?P=301&demandeur=' . $id_demandeur . '"><img src="./images/add_24.png" /></a>';
                    }
                    echo '</legend>';
                    echo '<TABLE id="ListDemande" class="table boo-table table-content table-bordered table-condensed table-striped table-hover">';
                    echo '<thead><tr>'.
                            '<th>#ID</th>'.
                            '<th>Commune</th>'.
                            '<th>R&eacute;f&eacute;rence de la demande</th>'.
                            '<th>Parcelle</th>'.
                            '<th>Date</th>'.
                            '<th>Status</th>'.
                            '<th>action</th>'.
                         '</tr></thead>';
                    echo '<tbody>';
                        foreach($tab as $k => $v){
                            echo '<tr>'.
                                    '<td style="text-align:right;">' . $v['ID_DEMANDE'] . '</td>'.
                                    '<td>' . $v['LIB_COMMUNE'] . '</td>'.
                                    '<td>' . $v['REFERENCE'] . '</td>'.
                                    '<td>' . $v['LIST_PARCELLE_ABR'] . '</td>'.
                                    '<td style="text-align:center;">' . $v['DATE_DEMANDE'] . '</td>'.
                                    '<td>' . $v['LIB_STATUT_DEMANDE'] . '</td>'.
                                    '<td style="text-align:center;">'.
                                    '<a href="./index.php?P=301&demande=' . $k . '"><img src="./images/edit_24.png" border="0" title="Voir" /></a>'.
                                    (in_array('admin',$_SESSION[PROJET_NAME]['droit']) ? ('<a href="javascript:void(0)" onClick="SupprimerDemande('.$v['ID_DEMANDEUR'].','.$v['ID_DEMANDE'].',201)"><img src="./images/delete_24.png" title="Supprimer cette demande" /></a>') : '').
                                    '</td>'.
                                 '</tr>';
                        }
                    echo '</tbody></table>';
                echo '</fieldset>';
            }
            ?>
            </td>
        </tr>

    </table>
</form>
<div id="dialog-confirm"></div>
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