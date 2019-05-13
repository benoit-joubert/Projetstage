<?php

$BOUTTONS = array();
if(in_array('admin',$_SESSION[PROJET_NAME]['droit']) || in_array('saisie',$_SESSION[PROJET_NAME]['droit'])){
    $BOUTTONS[] = array(
                        'ACTION' => 'javascript:window.location=\'index.php?P=201\';',
                        'TXT' => 'Nouveau',
                        'IMG' => $page->getDesignUrl().'/images/toolbar/icon-32-new.png',
                        'TITLE' => 'Cliquez ici pour <strong>ajouter</strong> un nouveau demandeur',
                       );
}
$BOUTTONS[] = array(
                    'ACTION' => "javascript:window.location='index.php?P=1';",
                    'TXT' => 'Retour',
                    'IMG' => $page->getDesignUrl().'/images/toolbar/icon-32-back.png',
                    'TITLE' => 'Retour',
                   );
$page->afficheHeader();

?>

<script type="text/javascript" charset="utf-8">

    $(document).ready(function() {
        oTable = $('#ListDemandeurs').DataTable({
            "bSortClasses": false,
            "bProcessing": true,
            "bServerSide": true,
            "bStateSave": true,
            "bRegex": true,
            "bFilter": true,
            "bCaseInsensitive": false,
            "sAjaxSource": "./index.php?P=210",
            "aLengthMenu": [[50, 100, 500], [50, 100, 500]],
            "iDisplayLength": 50,
            "aaSorting": [[ 0, "asc" ]],
            "bJQueryUI": false,
            "bPaginate": true,
            "sPaginationType": "full_numbers",
            "bAutoWidth": true,
            "aoColumns": [
                                {"bSortable": true,"bSearchable": true,"sWidth": "30px"},
                                {"bSortable": true,"bSearchable": true,"sWidth": "400px"},
                                {"bSortable": true,"bSearchable": true},
                                {"bSortable": true,"bSearchable": true},
                                {"bSortable": false,"bSearchable": true,"sWidth": "40px"},
                                {"bSortable": false,"bSearchable": true,"sWidth": "150px"},
                                {"bSortable": false,"bSearchable": true,"sWidth": "100px"},
                                <?php
                                if(in_array('admin',$_SESSION[PROJET_NAME]['droit']) || in_array('saisie',$_SESSION[PROJET_NAME]['droit'])){
                                    echo '{"bSortable": false,"bSearchable": false,"sWidth": "40px"},';
                                }
                                ?>
                                {"bSortable": false,"bSearchable": false,"sWidth": "40px"}
                            ],
            "columnDefs": [
                              { className: "dt-right", "targets": [0,4,6] },
                              { className: "dt-center", "targets": [7,8] },
                              { className: "dt-nowrap", "targets": [0,5,6] }
                            ],
            "oLanguage": {
                            sSearch: 'Recherche:&nbsp;',
                            sInfo: 'Le total est de _TOTAL_ lignes (affichant de _START_ &agrave; _END_)',
                            sInfoFiltered: " - sur un total de _MAX_ lignes",
                            sInfoEmpty: "Aucune donnée",
                            sLengthMenu: 'Afficher _MENU_ lignes&nbsp;&nbsp;&nbsp;',
                            sZeroRecords: 'Aucune donnée trouvée...',
                            oPaginate: {
                                            sNext: '<i class="arrowicon-r-black"></i>',
                                            sPrevious: '<i class="arrowicon-l-black"></i>',
                                            sFirst: "Premi&egrave;re",
                                            sLast: "Derni&egrave;re"
                            }
                        }
            
        });
        $('#ListDemandeurs_length select').select2({
                minimumResultsForSearch: 2,
				width: "off"
		});
    } );
</script> 

<?php
          
$chaine = '<TABLE id="ListDemandeurs" class="table boo-table table-content table-bordered table-condensed table-striped table-hover">';
    $chaine .= '<thead>'.
                    '<tr style="heigth:20px;">'.
                        '<th>#ID</th>'.
                        '<th>Nom</th>'.
                        '<th>Prénom</th>'.
                        '<th>Adresse</th>'.
                        '<th>CP</th>'.
                        '<th>Ville</th>'.
                        '<th>Tél</th>'.
                        ((in_array('admin',$_SESSION[PROJET_NAME]['droit']) || in_array('saisie',$_SESSION[PROJET_NAME]['droit'])) ? '<th>Demande</th>' : '').
                        '<th>Action</th>'.
                    '</tr>'.
                '</thead>'.
                '<tbody>';
/*
    $tab = getDemandeurs($db);

    foreach ($tab as $k => $v){
        $chaine .= '<tr>'.
                        '<td style="text-align:right;">' . '<a href="./index.php?P=201&demandeur='.$v['ID_DEMANDEUR'].'&action=modifier">' . $v['ID_DEMANDEUR'] . '</a>' . '</td>'.
                        '<td>' . htmlentitiesIso($v['NOM']) . '</td>'.
                        '<td>' . htmlentitiesIso($v['PRENOM']) . '</td>'.
                        '<td>' . htmlentitiesIso($v['ADRESSE']) . '</td>'.
                        '<td>' . htmlentitiesIso($v['CP']) . '</td>'.
                        '<td>' . htmlentitiesIso($v['VILLE']) . '</td>'.
                        '<td>' . htmlentitiesIso($v['TEL1']) . '</td>'.
                        ((in_array('admin',$_SESSION[PROJET_NAME]['droit']) || in_array('saisie',$_SESSION[PROJET_NAME]['droit'])) ? 
                        ('<td style="text-align:center;">' . '<a href="./index.php?P=301&from=2&demandeur='.$v['ID_DEMANDEUR'].'"><img src="./images/distribution_eau_reseau_24.jpg" border="0" title="Ajouter une nouvelle demande"/></a>' . '</td>') : '').
                        '<td style="text-align:center;">' . '<a href="./index.php?P=201&demandeur='.$v['ID_DEMANDEUR'].'&action=modifier"><img src="./images/edit_24.png" border="0"  title="Voir"/></a>' . '</td>'.
                    '</tr>';
    }
    
    //$tabWidget->draw();
*/
    $chaine .= '</tbody>';
$chaine .= '</TABLE>';
echo $chaine;

$page->afficheFooter();
?>