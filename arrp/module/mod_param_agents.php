<?php
if(isset($_POST['type']))
    $type = $_POST['type'];
elseif (isset($_GET['type']))
    $type = $_GET['type'];
else
    $type = '';
if($type != 'INTERLOCUTEUR' && $type != 'ATTESTANT' && $type != 'SIGNATAIRE'){
	header("Location: ./index.php?P=8");
	exit;
}
$token = generateToken(6);
$_SESSION[PROJET_NAME]['token'] = $token;

$lib = $type == 'SIGNATAIRE' ? 'Nouveau' : 'Nouvel';
$BOUTTONS = array();
$BOUTTONS[] = array(
                    'ACTION' => "javascript:window.location='./index.php?P=" . $P ."01&type=" . $type . "';",
                    'TXT' => $lib,
                    'IMG' => $page->getDesignUrl().'/images/toolbar/icon-32-new.png',
                    'TITLE' => $lib,
                   );

$page->afficheHeader();
?>
        
<div id="page-content" class="page-content">
    <section>
	    <div class="row-fluid">
	            
		    <div class="span2">
		    <?php include ('./module/mod_param_menu.php'); ?>
		    </div>    
	    
		    <div class="span10">
		    <script type="text/javascript" charset="utf-8">

			    $(document).ready(function() {
			        oTable = $('#ListInterlocuteur').DataTable({
			            "aaSorting": [[ 1, "asc" ]],
			            "bJQueryUI": false,
			            "bPaginate": true,
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
			            "aoColumns": [
			                                    {"bSortable": true,"bSearchable": true,"sWidth": "40px"},
			                                    {"bSortable": true,"bSearchable": true},
			                                    {"bSortable": false,"bSearchable": false,"sWidth": "140px"},
			                                    {"bSortable": false,"bSearchable": false,"sWidth": "140px"},
			                                    {"bSortable": false,"bSearchable": false,"sWidth": "250px"},
			                                    {"bSortable": false,"bSearchable": false,"sWidth": "40px"},
			                                    {"bSortable": false,"bSearchable": false,"sWidth": "40px"}
			                                 ]
			        });
			        $('#ListInterlocuteur_length select').select2({
			                minimumResultsForSearch: 2,
			                width: "off"
			        });
			    } );
			    $(document).ready(function() {
			        oTable = $('#ListAttestant').DataTable({
			            "aaSorting": [[ 1, "asc" ]],
			            "bJQueryUI": false,
			            "bPaginate": true,
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
			            "aoColumns": [
			                                    {"bSortable": true,"bSearchable": true,"sWidth": "40px"},
			                                    {"bSortable": true,"bSearchable": true,"sWidth": "400px"},
			                                    {"bSortable": false,"bSearchable": false},
			                                    {"bSortable": false,"bSearchable": false,"sWidth": "40px"},
			                                    {"bSortable": false,"bSearchable": false,"sWidth": "40px"}
			                                 ]
			        });
			        $('#ListAttestant_length select').select2({
			                minimumResultsForSearch: 2,
			                width: "off"
			        });
			    } );
			</script>
		        <?php
		        if($type == 'INTERLOCUTEUR' || $type == 'ATTESTANT' || $type == 'SIGNATAIRE'){
		        	$where = 'TYPE_AGENT=\'' . $type . '\'';
					$tab = getAgent($db,$where);
					echo '<div style="overflow:auto;" class="panel"><div class="panel-body">';
					if($type=='INTERLOCUTEUR'){
						echo '<TABLE id="ListInterlocuteur" class="table boo-table table-content table-bordered table-condensed table-striped table-hover">';
						    echo '<thead><tr>'.
						            '<th>#ID</th>'.
						            '<th>' . ($type == 'INTERLOCUTEUR' ? 'Interlocuteur' : 'Attestant') . '</th>'.
						            '<th>T&eacute;l</th>'.
						            '<th>Fax</th>'.
						            '<th>Email</th>'.
						            '<th>Status</th>'.
						            '<th>action</th>'.
						         '</tr></thead>';
						    echo '<tbody>';
						        foreach($tab as $k => $v){
						            echo '<tr>'.
						                    '<td style="text-align:right;">' . $v['ID_AGENT'] . '</td>'.
						                    '<td>' . $v['AGENT'] . '</td>'.
						                    '<td>' . $v['TEL'] . '</td>'.
						                    '<td>' . $v['FAX'] . '</td>'.
						                    '<td>' . $v['EMAIL'] . '</td>'.
						                    '<td style="text-align:center;"><img src="./images/' . ($v['ACTIF'] == '1' ? 'yes.png' : 'no.png'). '" /></td>'.
						                    '<td style="text-align:center;">
						                    <a href="./index.php?P=' . $P . '01&agent=' . $k . '"><img src="./images/edit_24.png" border="0" title="Modifier" /></a>
						                    <a href="javascript:void(0)" onClick="SupprimerAgent('.$k.')"><img src="./images/delete_24.png" border="0" title="Supprimer" /></a>
						                    </td>'.
						                 '</tr>';
						        }
						  echo '</tbody></table>';
					}elseif($type == 'ATTESTANT'){
						echo '<TABLE id="ListAttestant" class="table boo-table table-content table-bordered table-condensed table-striped table-hover">';
						    echo '<thead><tr>'.
						            '<th>#ID</th>'.
						            '<th>Attestant</th>'.
						            '<th>Qualit&eacute;</th>'.
						            '<th>Status</th>'.
						            '<th>action</th>'.
						         '</tr></thead>';
						    echo '<tbody>';
						        foreach($tab as $k => $v){
						            echo '<tr>'.
						                    '<td style="text-align:right;">' . $v['ID_AGENT'] . '</td>'.
						                    '<td>' . $v['AGENT'] . '</td>'.
						                    '<td>' . $v['QUALITE'] . '</td>'.
						                    '<td style="text-align:center;"><img src="./images/' . ($v['ACTIF'] == '1' ? 'yes.png' : 'no.png'). '" /></td>'.
						                    '<td style="text-align:center;">
						                    <a href="./index.php?P=' . $P . '01&agent=' . $k . '"><img src="./images/edit_24.png" border="0" title="Modifier" /></a>
						                    <a href="javascript:void(0)" onClick="SupprimerAgent('.$k.')"><img src="./images/delete_24.png" border="0" title="Supprimer" /></a>
						                    </td>'.
						                 '</tr>';
						        }
						  echo '</tbody></table>';
					}else{
						echo '<TABLE id="ListAttestant" class="table boo-table table-content table-bordered table-condensed table-striped table-hover">';
						    echo '<thead><tr>'.
						            '<th>#ID</th>'.
						            '<th>Signataire</th>'.
						            '<th>Qualit&eacute;</th>'.
						            '<th>Status</th>'.
						            '<th>action</th>'.
						         '</tr></thead>';
						    echo '<tbody>';
						        foreach($tab as $k => $v){
						            echo '<tr>'.
						                    '<td style="text-align:right;">' . $v['ID_AGENT'] . '</td>'.
						                    '<td>' . $v['AGENT'] . '</td>'.
						                    '<td>' . $v['QUALITE'] . '</td>'.
						                    '<td style="text-align:center;"><img src="./images/' . ($v['ACTIF'] == '1' ? 'yes.png' : 'no.png'). '" /></td>'.
						                    '<td style="text-align:center;">
						                    <a href="./index.php?P=' . $P . '01&agent=' . $k . '"><img src="./images/edit_24.png" border="0" title="Modifier" /></a>
						                    <a href="javascript:void(0)" onClick="SupprimerAgent('.$k.')"><img src="./images/delete_24.png" border="0" title="Supprimer" /></a>
						                    </td>'.
						                 '</tr>';
						        }
						  echo '</tbody></table>';
					}

					echo '</div></div>';
				}
		        ?>
		    </div>
	    </div>
    </section>

</div>
<div id="dialog-confirm"></div>
<script>

function SupprimerAgent(IdAgent){
	<?php
		if($type == 'INTERLOCUTEUR'){
			echo 'var typeagent="l\'Interlocuteur";';
		}elseif($type == 'ATTESTANT'){
			echo 'var typeagent="l\'Attestant";';
		}else{
			echo 'var typeagent="le Signataire";';
		}
	?>
	var msg = 'Etes-vous s&ucirc;r(e) de vouloir<br/>supprimer ' +typeagent + ' <b>' + IdAgent + '</b> ?';
    $("#dialog-confirm").html("<img src='./images/imagesQuestion1_48.png' border='0' /><br/>" + msg);
    // Define the Dialog and its properties.
    $("#dialog-confirm").dialog({
        resizable: false,
        modal: true,
        title: "Confirmation Suppression",
        height: 250,
        width: 400,
        buttons: {
            "OK": function () {
                $(this).dialog('close');
                window.location="./index.php?P=<?=$P?>0101&action=supprimer&type_agent=<?=$type?>&id_agent="+IdAgent+"&token=<?=$token?>";
            },
            "Annuler": function () {
                $(this).dialog('close');
            }
        }
    });
    return false;
}

</script>
<?
$page->afficheFooter();
?>