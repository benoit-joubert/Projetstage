<?php
$id_agent = isset($_POST['agent']) ? $_POST['agent'] : (isset($_GET['agent']) ? $_GET['agent'] : '');
$action = isset($_POST['action']) ? $_POST['action'] : (isset($_GET['action']) ? $_GET['action'] : '');
$token = isset($_POST['token']) ? $_POST['token'] : (isset($_GET['token']) ? $_GET['token'] : '');

$token = generateToken(6);
$_SESSION[PROJET_NAME]['token'] = $token;

$courrier_entete = getParametre($db,'COURRIER_ENTETE');
$tab = explode('##',$courrier_entete);

$BOUTTONS = array();
$BOUTTONS[] = array(
                    'ACTION' => 'ValiderFormulaireParam(\'COURRIER_ENTETE\');',  
                    'ID' => 'bouton_submit_F1',
                    'TXT' => 'Sauver',
                    'IMG' => $page->getDesignUrl().'/images/toolbar/icon-32-save.png',
                    'TITLE' => 'Sauver',
                    );
/*
$BOUTTONS[] = array(
                    'ACTION' => "javascript:window.location='./index.php?P=" . substr($P,0,strlen($P)-2) ."';",
                    'TXT' => 'Retour',
                    'IMG' => $GENERAL_URL.'/images/nav_left_green.png',
                    'TITLE' => 'Retour',
                   );
*/
$page->afficheHeader();
?>
<div id="page-content" class="page-content">
    <section>
        <div class="row-fluid">
                
            <div class="span2">
            <?php include ('./module/mod_param_menu.php'); ?>
            </div>    
        
            <div class="span10">
                <form id="F1" name="F1" method="post" action="./index.php" enctype="multipart/form-data">
                    <?php
                    echo '<input type="hidden" name="P" value="' . $P . '01">';
                    echo '<input type="hidden" name="param_code" value="COURRIER_ENTETE">';
                    echo '<input type="hidden" name="token" value="' . $token . '">';
                    ?>
                    
                    <fieldset class="adminform" style="background-color:#F4F4F4;">
                        <legend>Entête Courrier</legend>
                        <table class="admintable" >
                            <?php
                                for($i=0;$i<6;$i++){
                                    echo '
                                    <tr>
                                        <td class="key">LIGNE ' . ($i+1) . ':</td>
                                        <td><input type="text" name="LIGNE' . $i . '" id="LIGNE' . $i . '" maxlength="64" style="width:450px;"  value="' . (isset($tab[$i]) ? $tab[$i] : '') . '" /></td>
                                    </tr>';
                                }
                            ?>
                        </table>
                    </fieldset>
                    <div id="dialog-erreur"></div>
                </form>
            </div>
        </div>
    </section>
</div>

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