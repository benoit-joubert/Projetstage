<?php    
$BOUTTONS = array();
if(in_array('admin',$_SESSION[PROJET_NAME]['droit']) || in_array('saisie',$_SESSION[PROJET_NAME]['droit'])){
    $BOUTTONS[] = array(
                            'HREF' => './index.php?P=301&from=3',
                            'TXT' => 'Nouvelle',
                            'IMG' => $page->getDesignUrl().'/images/toolbar/icon-32-new.png',
                            'TITLE' => 'Cliquez ici pour <strong>ajouter</strong> un nouvelle demande',
                       );
}
$BOUTTONS[] = array(
                    'HREF' => './index.php?P=6',
                    'TXT' => 'Carte',
                    'IMG' => $GENERAL_URL.'/images/earth_location_32.png',
                    'TITLE' => 'Carte',
                   );
$BOUTTONS[] = array(
                    'ACTION' => "javascript:window.location='index.php?P=1';",
                    'TXT' => 'Retour',
                    'IMG' => $page->getDesignUrl().'/images/toolbar/icon-32-back.png',
                    'TITLE' => 'Retour',
                   );

$page->afficheHeader();
$user_login = isset($_SESSION[PROJET_NAME]['login_ldap']) ? $_SESSION[PROJET_NAME]['login_ldap'] : '';
//$tab = getUsersLiens($db,$user_login);
//print_jc($tab);
$onglet_actif = isset($_GET['onglet']) ? $_GET['onglet'] : 1;
if($onglet_actif != 1 && $onglet_actif != 2){
    $onglet_actif = 1;
}
?>
<script type="text/javascript" charset="utf-8">

    $(document).ready(function() {
        oTable = $('#ListDemande').DataTable({
            "bSortClasses": false,
            "bProcessing": true,
            "bServerSide": true,
            "bStateSave": true,
            "bRegex": true,
            "bFilter": true,
            "bCaseInsensitive": false,
            "sAjaxSource": "./index.php?P=310",
            "aLengthMenu": [[50, 100, 500], [50, 100, 500]],
            "iDisplayLength": 50,
            "aaSorting": [[ 0, "asc" ]],
            "bJQueryUI": false,
            "bPaginate": true,
            "sPaginationType": "full_numbers",
            "bAutoWidth": true,
            "aoColumns": [
                                    {"bSortable": true,"bSearchable": true,"sWidth": "25px"},
                                    {"bSortable": true,"bSearchable": true,"sWidth": "160px"},
                                    {"bSortable": true,"bSearchable": true},
                                    {"bSortable": true,"bSearchable": true},
                                    {"bSortable": true,"bSearchable": true},
                                    {"bSortable": true,"bSearchable": true,"sWidth": "90px"},
                                    {"bSortable": true,"bSearchable": true,"sWidth": "300px"},
                                    {"bSortable": true,"bSearchable": true,"sWidth": "70px"},
                                    {"bSortable": false,"bSearchable": false,"sWidth": "50px"}
                                 ],
            "columnDefs": [
                              { className: "dt-right", "targets": [0] },
                              { className: "dt-center", "targets": [5,7,8] },
                              { className: "dt-nowrap", "targets": [0,1,5] }
                            ],
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
                        }
        });
        $('#ListDemande_length select').select2({
                minimumResultsForSearch: 2,
                width: "off"
        });
    } );
</script> 

<?php
//Liens de l'onglet
$where = '';
//$tab = getDemandes($db,$where);
echo '<div style="overflow:auto;" class="panel"><div class="panel-body">';

echo '<TABLE id="ListDemande" class="table boo-table table-content table-bordered table-condensed table-striped table-hover">';
    echo '<thead><tr>'.
            '<th>#ID</th>'.
            '<th>Commune</th>'.
            '<th>Demandeur</th>'.
            '<th>R&eacute;f&eacute;rence de la demande</th>'.
            '<th>Contact</th>'.
            '<th>Date demande</th>'.
            '<th>Parcelle</th>'.
            '<th>Status</th>'.
            '<th>action</th>'.
         '</tr></thead>';
    echo '<tbody>';
        /*
        foreach($tab as $k => $v){
            echo '<tr>'.
                    '<td style="text-align:right;">' . $v['ID_DEMANDE'] . '</td>'.
                    '<td>' . $v['NOM'] . ' ' . $v['PRENOM'] . '</td>'.
                    '<td>' . $v['REFERENCE'] . '</td>'.
                    '<td>' . $v['CONTACT'] . '</td>'.
                    '<td style="text-align:center;">' . $v['DATE_DEMANDE'] . '</td>'.
                    '<td>' . $v['LIST_PARCELLE'] . '</td>'.
                    '<td>' . $v['LIB_STATUT_DEMANDE'] . '</td>'.
                    '<td style="text-align:center;">'.
                        '<a href="./index.php?P=301&from=3&demande=' . $k . '"><img src="./images/edit_24.png" border="0" title="Voir la demande" /></a>'.
                        '<a href="./index.php?P=201&demandeur='.$v['ID_DEMANDEUR'].'&from=3"><img src="./images/user1_into_24.png" title="Afficher le demandeur"/></a>'.
                    '</td>'.
                 '</tr>';
        }
        */
    echo '</tbody></table>';
echo '</div></div>';
            
$page->afficheFooter();
?>
