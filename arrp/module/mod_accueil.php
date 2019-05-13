<?php    
$BOUTTONS = array();

$BOUTTONS[] = array(
                        'HREF' => './index.php?P=2',
                        'TXT' => 'Demandeurs',
                        'IMG' => $GENERAL_URL . '/images/businessmen_32.png',
                        'TITLE' => 'Gestion des Demandeurs',
                   );
$BOUTTONS[] = array(
                        'HREF' => './index.php?P=3',
                        'TXT' => 'Demandes',
                        'IMG' => $GENERAL_URL . '/images/distribution_eau_reseau_32.jpg',
                        'TITLE' => 'Gestion des Demandes',
                   );
if(in_array('admin',$_SESSION[PROJET_NAME]['droit']) || in_array('parametrage',$_SESSION[PROJET_NAME]['droit'])){
    $BOUTTONS[] = array(
                            'HREF' => './index.php?P=8',
                            'TXT' => 'Param&eacute;trage',
                            'IMG' => $GENERAL_URL . '/images/gear.png',
                            'TITLE' => 'Param&eacute;trage',
                       );
}
$page->afficheHeader();
$user_login = isset($_SESSION[PROJET_NAME]['login_ldap']) ? $_SESSION[PROJET_NAME]['login_ldap'] : '';
//$tab = getUsersLiens($db,$user_login);
//print_jc($tab);
$selectedMois = isset($_GET['selectMois']) ? $_GET['selectMois'] : (isset($_SESSION[PROJET_NAME]['selectMois']) ? $_SESSION[PROJET_NAME]['selectMois'] : date('m'));
$_SESSION[PROJET_NAME]['selectMois'] = $selectedMois;
$selectedAnnee = isset($_GET['selectAnnee']) ? $_GET['selectAnnee'] : (isset($_SESSION[PROJET_NAME]['selectAnnee']) ? $_SESSION[PROJET_NAME]['selectAnnee'] : (date('Y')-1));
$_SESSION[PROJET_NAME]['selectAnnee'] = $selectedAnnee;
$onglet_actif = isset($_GET['onglet']) ? $_GET['onglet'] : (isset($_SESSION[PROJET_NAME]['onglet']) ? $_SESSION[PROJET_NAME]['onglet'] : 1);
if($onglet_actif == 3 && !in_array('stats',$_SESSION[PROJET_NAME]['droit'])){
    $onglet_actif = 1;
}
if($onglet_actif != 1 && $onglet_actif != 2 && $onglet_actif != 3){
    $onglet_actif = 1;
}
$_SESSION[PROJET_NAME]['onglet'] = $onglet_actif;
if($onglet_actif!=3){
    $aoColumns = '"aoColumns":[
                                    {"bSortable": true,"bSearchable": true,"sWidth": "35px"},
                                    {"bSortable": true,"bSearchable": true,"sWidth": "130px"},
                                    {"bSortable": true,"bSearchable": true},
                                    {"bSortable": true,"bSearchable": true},
                                    {"bSortable": true,"bSearchable": true},
                                    {"bSortable": true,"bSearchable": true,"sWidth": "130px"},
                                    {"bSortable": true,"bSearchable": true},
                                    {"bSortable": true,"bSearchable": true,"sWidth": "100px"},
                                    {"bSortable": false,"bSearchable": false,"sWidth": "50px"}
                                 ],
                "columnDefs": [
                              { className: "dt-right", "targets": [0] },
                              { className: "dt-center", "targets": [5] },
                              { className: "dt-nowrap", "targets": [0,1] }
                           ]
                ';
}else{
    $aoColumns = '"aoColumns":[
                                    {"bSortable": true,"bSearchable": false,"sWidth": "100px"},
                                    {"bSortable": false,"bSearchable": false},
                                    {"bSortable": false,"bSearchable": false}
                                 ]';
}
?>
<script type="text/javascript" charset="utf-8">

    $(document).ready(function() {
        oTable = $('#ListDemandeAccueil').DataTable({
            "aaSorting": [[ 0, "<?=($onglet_actif!=3 ? "desc" : "asc")?>"]],
            "bJQueryUI": false,
            "bPaginate": <?=($onglet_actif != 3 ? 'true' : 'false')?>,
            "bFilter":  <?=($onglet_actif != 3 ? 'true' : 'false')?>,
            "sPaginationType": "full_numbers",
            "bStateSave": true,
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
            "aLengthMenu": [[50, 100, 500], [50, 100, 500]],
            <?=$aoColumns?>
        });
        $('#ListDemande_length select').select2({
                minimumResultsForSearch: 2,
                width: "off"
        });
    } );

    function changePeriodeStats(){
        var mois = document.getElementById('selectMois').options[document.getElementById('selectMois').selectedIndex].value;
        var annee = document.getElementById('selectAnnee').options[document.getElementById('selectAnnee').selectedIndex].value;
        window.location = "./index.php?onglet=3&selectMois="+mois+"&selectAnnee="+annee;
    }

</script> 

<?php
//echo '<div role="tabpanel" style="padding:0 5px;>';
    //<!-- Nav tabs -->
    echo '<ul class="nav nav-tabs" role="tablist">';
        
            echo '<li role="presentation"'.($onglet_actif == 1 ? ' class="active"' : '').'><a href="./index.php?onglet=1" aria-controls="home" role="tab">Demandes &agrave; traiter</a></li>';
            echo '<li role="presentation"'.($onglet_actif == 2 ? ' class="active"' : '').'><a href="./index.php?onglet=2" aria-controls="home" role="tab">Demandes en cours de traitement</a></li>';
            if(in_array('stats',$_SESSION[PROJET_NAME]['droit'])){
                echo '<li role="presentation"'.($onglet_actif == 3 ? ' class="active"' : '').'><a href="./index.php?onglet=3" aria-controls="home" role="tab">Statistiques</a></li>';
            }

    echo '</ul>';

    //<!-- Tab panes -->
    echo '<div class="tab-content">';
            echo '<div role="tabpanel" class="tab-pane'.($onglet_actif == 1 ? ' active' : '').'" id="Onglet_1">';
                //Liens de l'onglet
                $where = 'STATUT_DEMANDE=0';
                $tab = $onglet_actif == 1 ? getDemandes($db,$where) : array();
                echo '<div style="overflow:auto;" class="panel"><div class="panel-body">';
                if($onglet_actif == 1){
                    afficheDemandes($tab,$onglet_actif);
                }
                echo '</div></div>';
            echo '</div>'; // FIN <div role="tabpanel" class="tab-pane'.($onglet_actif == $k ? ' active' : '').'" id="' . $k . '">'
            echo '<div role="tabpanel" class="tab-pane'.($onglet_actif == 2 ? ' active' : '').'" id="Onglet_2">';
                //Liens de l'onglet
                $where = 'STATUT_DEMANDE=1';
                $tab = $onglet_actif == 2 ? getDemandes($db,$where) : array();
                echo '<div style="overflow:auto;" class="panel"><div class="panel-body" >';
                if($onglet_actif == 2){
                    afficheDemandes($tab,$onglet_actif);
                }
                echo '</div></div>';
            echo '</div>';
            if(in_array('stats',$_SESSION[PROJET_NAME]['droit'])){
                echo '<div role="tabpanel" class="tab-pane'.($onglet_actif == 3 ? ' active' : '').'" id="Onglet_3">';
                    if($onglet_actif == 3){
                        $selectMois = '<select class="tail3" name="selectMois" id="selectMois" onChange="changePeriodeStats()">';
                            foreach($TAB_MOIS as $k => $v){
                                $selectMois .= '<option value="' . $k . '">' . $v . '</option>';
                            }
                        $selectMois .= '</select>';
                        $selectMois = str_replace('value="'.$selectedMois.'"', 'value="'.$selectedMois.'" selected', $selectMois);
                        $i = date('Y');
                        $selectAnnee = '<select class="tail3" name="selectAnnee" id="selectAnnee"  onChange="changePeriodeStats()">';
                            for($a=$i;$a>2015;$a--){
                                $selectAnnee .= '<option value="' . $a . '">' . $a . '</option>';
                            }
                        $selectAnnee .= '</select>';
                        $selectAnnee = str_replace('value="'.$selectedAnnee.'"', 'value="'.$selectedAnnee.'" selected', $selectAnnee);
                        echo 'Afficher les statistiques &agrave; partir de: ' . $selectMois . $selectAnnee;
                    }
                    echo '<div style="overflow:auto;" class="panel"><div class="panel-body" >';
                    if($onglet_actif == 3){
                        afficheStats($selectedMois,$selectedAnnee);
                    }
                    echo '</div></div>';
                echo '</div>'; // FIN <div role="tabpanel" class="tab-pane'.($onglet_actif == $k ? ' active' : '').'" id="' . $k . '">'
            }
    echo '</div>'; // FIN <div class="tab-content">
//echo '</div>'; // FIN <div role="tabpanel" style="padding:0 10px;">


function afficheDemandes( $tab,$onglet_actif){
    echo '<TABLE id="ListDemandeAccueil" class="table boo-table table-content table-bordered table-condensed table-striped table-hover" style="width:99%;">';
    echo '<thead><tr>'.
            '<th>#ID</th>'.
            '<th>Commune</th>'.
            '<th>Demandeur</th>'.
            '<th>R&eacute;f&eacute;rence de la demande</th>'.
            '<th>Contact</th>'.
            '<th>Date de la demande</th>'.
            '<th>Parcelle</th>'.
            '<th>Status</th>'.
            '<th>action</th>'.
         '</tr></thead>';
    echo '<tbody>';
        foreach($tab as $k => $v){
            echo '<tr>'.
                    '<td>' . $v['ID_DEMANDE'] . '</td>'.
                    '<td>' . $v['LIB_COMMUNE'] . '</td>'.
                    '<td>' . $v['NOM'] . ' ' . $v['PRENOM'] . '</td>'.
                    '<td>' . $v['REFERENCE'] . '</td>'.
                    '<td>' . $v['CONTACT'] . '</td>'.
                    '<td>' . $v['DATE_DEMANDE'] . '</td>'.
                    '<td>' . $v['LIST_PARCELLE_ABR'] . '</td>'.
                    '<td>' . $v['LIB_STATUT_DEMANDE'] . '</td>'.
                    '<td style="text-align:center;">'.
                        '<a href="./index.php?P=301&from=0&demande=' . $k . '"><img src="./images/edit_24.png" border="0" title="Voir" /></a>'.
                        '<a href="./index.php?P=201&demandeur='.$v['ID_DEMANDEUR'].'&from=0"><img src="./images/user1_into_24.png" title="Afficher le demandeur"/></a>'.
                    '</td>'.
                 '</tr>';
        }
    echo '</tbody></table>';
}
function afficheStats($selectedMois,$selectedAnnee){
    global $db;
    $tab = array();
    $m = $selectedMois;
    $y = $selectedAnnee;
    $firstDate = '01/' . substr('0' . $selectedMois, -2) . '/' . $selectedAnnee;
    for($i=0;$i<12;$i++){
        $d = $y . '-' . substr('0' . $m, -2);
        $tab[$d] = array(
                            'DATE_DEMANDE' =>  0,
                            'DATE_REPONSE' =>  0,
                        );
        $m++;
        if($m>12){
            $m = 1;
            $y++;
        }
    }
    $lastDate = '01/' . substr('0' . $m, -2) . '/' . $y;
    $tab['TOTAUX'] = array(
                            'DATE_DEMANDE' =>  0,
                            'DATE_REPONSE' =>  0,
                        );
    $selectedMois++;
    if($selectedMois > 12){
        $selectedMois = 1;
        $selectedAnnee++;
    }
    //Demande
    $tabChamp = array('DATE_DEMANDE','DATE_REPONSE');
    foreach($tabChamp as $champ){
        $sql = 'select to_char(' . $champ . ',\'YYYY-MM\'),count(*) '.
                'from ARRP_DEMANDES '.
                'WHERE ' . $champ . '>=to_date(\'' . $firstDate . '\',\'DD/MM/YYYY\') AND ' . $champ . '<to_date(\'' . $lastDate . '\',\'DD/MM/YYYY\') '.
                ($champ == 'DATE_REPONSE' ? 'AND STATUT_DEMANDE=5 ' : '').
                'group by to_char(' . $champ . ',\'YYYY-MM\')';
        //echo '<br/>' . $sql . '<br/>';
        $res = executeReq($db,$sql);
        while(list($periode,$nb) = $res->fetchRow()){
            $tab[$periode][$champ] = $nb;
            $tab['TOTAUX'][$champ] += $nb;
        }
    }
    echo '<TABLE id="ListDemandeAccueil" class="table boo-table table-content table-bordered table-condensed table-striped table-hover" style="width:700px;">';
    echo '<thead><tr>'.
            '<th>Mois</th>'.
            '<th>Nombre de demandes</th>'.
            '<th>Nombre de demandes trait&eacute;s</th>'.
         '</tr></thead>';
    echo '<tbody>';
        foreach($tab as $k => $v){
            echo '<tr>'.
                    '<td style="text-align:right;' . ($k=='TOTAUX'  ? 'font-weight:bold;' : '') . '">' . $k . '</td>'.
                    '<td style="text-align:right;' . ($k=='TOTAUX'  ? 'font-weight:bold;' : '') . '">' . ($v['DATE_DEMANDE']) . '</td>'.
                    '<td style="text-align:right;' . ($k=='TOTAUX'  ? 'font-weight:bold;' : '') . '">' . $v['DATE_REPONSE'] . '</td>'.
                 '</tr>';
        }
    echo '</tbody></table>';
}
$page->afficheFooter();
?>
