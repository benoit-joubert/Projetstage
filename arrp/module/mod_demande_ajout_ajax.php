<?php
$action = isset($_POST['action']) ? $_POST['action'] : (isset($_GET['action']) ? $_GET['action'] : '');
$idDossier = isset($_POST['idDossier']) ? $_POST['idDossier'] : '';
$id_demande = isset($_SESSION[PROJET_NAME]['ID_DEMANDE']) ? $_SESSION[PROJET_NAME]['ID_DEMANDE'] : '';
$code_com = isset($_SESSION[PROJET_NAME]['CODE_COM']) ? $_SESSION[PROJET_NAME]['CODE_COM'] : $_SESSION[PROJET_NAME]['default_com'];
if(!in_array('admin',$_SESSION[PROJET_NAME]['droit']) && !in_array('saisie',$_SESSION[PROJET_NAME]['droit'])){
    $action = '';
}
$user_maj = $_SESSION[PROJET_NAME]['login_ldap'];
$date_maj = date('d/m/Y H:i:s');
$where = 'ID_DEMANDE=\'' . protegeChaineOracle($id_demande) . '\'';
executeReq($db,"alter session set nls_numeric_characters='.,'");
if($action == 'ChangeUsager'){
    $id_usager = isset($_POST['id_usager']) ? $_POST['id_usager'] : '';
    list($nb,$TabUsager) = getUsagersListing($dbOracle, 'WHERE ID_USAGERS=\'' . $id_usager . '\'');
    if(count($TabUsager) == 1){
        $UsagersNom = $TabUsager[$id_usager]['NOM_USAGER'];
        $IdQualiteR = $TabUsager[$id_usager]['TYPE'];
        $tab = getQualiteRepresentant($dbOracle,'ID_QLT_REPRESENTANT=\'' . $IdQualiteR . '\'');
        $QualiteRepresentant = isset($tab[$IdQualiteR]) ? $tab[$IdQualiteR]['LIB_QLT_REPRESENTANT'] : '';
        $UsagersTel = $TabUsager[$id_usager]['TEL'];
        $UsagersPortable = $TabUsager[$id_usager]['TEL_PORTABLE'];;
        $UsagersEmail = $TabUsager[$id_usager]['EMAIL'];
        $ok = 1;
    }else{
        $UsagersNom = '';
        $IdQualiteR = '';
        $QualiteRepresentant = '';
        $UsagersTel = '';
        $UsagersPortable = '';
        $UsagersEmail = '';
        $ok = 0;
    } 
    $tab = array('ok' => $ok,
                 'UsagersNom' => utf8_encode($UsagersNom),
                 'IdQualiteR' => utf8_encode($IdQualiteR),
                 'QualiteRepresentant' => utf8_encode($QualiteRepresentant),
                 'UsagersTel' => utf8_encode($UsagersTel),
                 'UsagersPortable' => utf8_encode($UsagersPortable),
                 'UsagersEmail' => utf8_encode($UsagersEmail)
                );
    echo json_encode($tab);
}

if($action == 'AddPARCELLE'){

    $id_parc = $code_com . '000' . substr('#' . $idDossier, -6);
    $nsec = str_replace('#','',substr($id_parc,-6,2));
    $sql =  'select ID_DEM_PARC FROM ARRP_DEMANDES_PARCELLES ' .
            'WHERE ID_DEMANDE=\'' . protegeChaineOracle($id_demande) . '\' '.
            'AND ID_PARC=\'' . protegeChaineOracle($id_parc) . '\'';
    $res = executeReq($db,$sql);
    if(!list($id_dem_parc) = $res->fetchRow()){
        /*
        $sql = 'select LABX,LABY from SIGAIX.PARCELLE_C_S where IDPARC=\'' . protegeChaineOracle($id_parc). '\'';
        $res = executeReq($db,$sql);
        list($labx,$laby) = $res->fetchRow();
        */
        $labx = $laby = '';
        $id_dem_parc = getMaxId($db,'ARRP_DEMANDES_PARCELLES','ID_DEM_PARC');
        $sql =  'insert into ARRP_DEMANDES_PARCELLES(ID_DEM_PARC,ID_DEMANDE,ID_PARC,NSEC,LABX,LABY) '.
                'values(' .
                            '\'' . $id_dem_parc . '\','.
                            '\'' . protegeChaineOracle($id_demande) . '\','.
                            '\'' . protegeChaineOracle($id_parc) . '\','.
                            '\'' . protegeChaineOracle($nsec) . '\','.
                            '\'' . protegeChaineOracle($labx) . '\','.
                            '\'' . protegeChaineOracle($laby) . '\''.
                        ')';
        $curs = executeReq($db,$sql);
    }
}

if($action == 'DeletePARCELLE'){
    $sql =  'delete FROM ARRP_DEMANDES_PARCELLES ' .
            'WHERE ID_DEMANDE=\'' . protegeChaineOracle($id_demande) . '\' '.
            'AND ID_DEM_PARC=\'' . protegeChaineOracle($idDossier) . '\'';
    $curs = executeReq($db,$sql);
}

if($action == 'AddPARCELLE' || $action == 'DeletePARCELLE'){
    $tabParc = getDemandesParcelles($db,$where);
    $chParc = getChaineForDemandesParcelles($tabParc);
    echo 'window.document.getElementById(\'DivParcelle\').innerHTML = \''.str_replace("'", "\'", $chParc).'\';tooltip.init();';
    //echo '$("#div2ImgLoading").css({"visibility": "hidden"});';
    echo 'MSG="OK";';
}

if($action == 'AddVOIE'){
    $cdruru = $idDossier;
    $sql =  'select ID_DEM_VOIE FROM ARRP_DEMANDES_VOIES ' .
            'WHERE ID_DEMANDE=\'' . protegeChaineOracle($id_demande) . '\' '.
            'AND CDRURU=\'' . protegeChaineOracle($cdruru) . '\'';
    $res = executeReq($db,$sql);
    if(!list($id_dem_voie) = $res->fetchRow()){
        $id_dem_voie = getMaxId($db,'ARRP_DEMANDES_VOIES','ID_DEM_VOIE');
        if($code_com == '13001'){
            $sql = 'select distinct RUE from sigaix.VR_LISTE_VOIES where cdruru=\'' . $cdruru . '\'';
            $res = executeReq($db,$sql);
            list($libelle_voie) = $res->fetchRow();
        }else{
            $sql = 'select distinct RUE from ARRP_VOIES where cdruru=\'' . $cdruru . '\'';
            $res = executeReq($db,$sql);
            if(list($lib) = $res->fetchRow()){
                $libelle_voie = $lib;
            }else{
                $cdruru = getMaxId($db,'ARRP_COMMUNES','LAST_NUM_VOIE','CODE_COM=\'' . $code_com . '\'');
                $libelle_voie = supprimeaccent(utf8_decode($_POST['libelle_voie']));
                $libelle_voie = strtoupper($libelle_voie);
                $sql = 'insert into ARRP_VOIES(CDRURU,CODE_COM,RUE) '.
                        'values('.
                                    '\'' . $cdruru . '\','.
                                    '\'' . $code_com . '\','.
                                    '\'' . protegeChaineOracle($libelle_voie) . '\''.
                                ')';
                $curs = executeReq($db,$sql);
                $sql = 'update ARRP_COMMUNES set LAST_NUM_VOIE=\'' . $cdruru . '\' WHERE CODE_COM=\'' . $code_com . '\'';
                $curs = executeReq($db,$sql);
            }
        }
        $sql =  'insert into ARRP_DEMANDES_VOIES(ID_DEM_VOIE,ID_DEMANDE,CDRURU,LIBELLE_VOIE) '.
                'values(' .
                            '\'' . $id_dem_voie . '\','.
                            '\'' . protegeChaineOracle($id_demande) . '\','.
                            '\'' . protegeChaineOracle($cdruru) . '\','.
                            '\'' . protegeChaineOracle($libelle_voie) . '\''.
                        ')';
        $curs = executeReq($db,$sql);
    }
}

if($action == 'DeleteVOIE'){
    $sql =  'delete FROM ARRP_DEMANDES_VOIES ' .
            'WHERE ID_DEMANDE=\'' . protegeChaineOracle($id_demande) . '\' '.
            'AND ID_DEM_VOIE=\'' . protegeChaineOracle($idDossier) . '\'';
    $curs = executeReq($db,$sql);
}

if($action == 'AddVOIE' || $action == 'DeleteVOIE'){
    $tabVoie = getDemandesVoies($db,$where);
    $chVoie = getChaineForDemandesVoies($tabVoie);
    
    echo 'window.document.getElementById(\'DivVoie\').innerHTML = \''.str_replace("'", "\'", $chVoie).'\';tooltip.init();';
    //echo '$("#div2ImgLoading").css({"visibility": "hidden"});';
    echo 'MSG="OK";';
}
$js = '';
if($action == 'AddDOCUMENT'){
    $js = '<script>';
    $msg = '';
    $nom_doc = isset($_POST['nom_doc']) ? $_POST['nom_doc'] : '';
    if($nom_doc == ''){
        $msg = '<font color="red">Erreur nom document</font>';
    }
    if(!isset($_FILES['fichier']) || !is_uploaded_file($_FILES['fichier']['tmp_name']))
    {
        $msg = '<font color="red">Erreur fichier</font>';
    }
    if($msg == ''){
        $targetFolder = $GENERAL_PATH . '/uploads/documents/' . date('Y.m'); // Relative to the root
        if (is_dir($targetFolder) === false) {
            mkdir($targetFolder, 0776, true);
        }
        $tempFile = $_FILES['fichier']['tmp_name'];
        $name = $_FILES['fichier']['name'];
        $name = utf8_decode($name);
        $name = preg_replace("/[^a-zA-Z0-9_.\-\[\]]/i", "", strtr($name, "()á?â?äé??ëí?î?ó?ô?öú??üçÁ?Â?ÄÉ??ËÍ?Î?Ó?Ô?ÖÚ??ÜÇ% ", "[]aaaaaeeeeiiiiooooouuuucAAAAAEEEEIIIIOOOOOUUUUC__"));
        $name = strtolower($name);
        $fileParts = pathinfo($name);
        $file_extension = '.' . strtolower($fileParts['extension']);
        if(!in_array($file_extension,$TYPE_DOC_AUTORISE)){
            $msg = '<font color="red">Erreur tyde de fichier</font>';
        }else{
            $name = str_replace($file_extension,'',$name) . '_' . $code_com .'_' . generateToken(6) . $file_extension;
            $targetFile = $targetFolder . '/' . $name;
            if(!move_uploaded_file($tempFile,$targetFile)){
                $msg = '<font color="red">Erreur lors du déplacement du fichier..</font>';
            }else{
                //echo $sql;
                $id_document = getMaxId($db,'ARRP_DOCUMENTS','ID_DOCUMENT');
                $observations = '';
                $sql =  'insert into ARRP_DOCUMENTS(ID_DOCUMENT,ID_DEMANDE,NOM_DOC,NOM_FICHIER,OBSERVATIONS,USER_SAISIE,DATE_SAISIE) '.
                        'values(' .
                                    '\'' . $id_document . '\','.
                                    '\'' . protegeChaineOracle($id_demande) . '\','.
                                    '\'' . protegeChaineOracle($nom_doc) . '\','.
                                    '\'' . protegeChaineOracle(date('Y.m') . '/' . $name) . '\','.
                                    '\'' . protegeChaineOracle($observations) . '\','.
                                    '\'' . protegeChaineOracle($user_maj) . '\','.
                                    'to_date(\'' . protegeChaineOracle($date_maj) . '\',\'dd/mm/yyyy hh24:mi:ss\')'.
                                ')';
                $curs = executeReq($db,$sql);
                $msg = '<font color="green">Document ajouté</font>';
            }
        }
    }
}

if($action == 'DeleteDOCUMENT'){
    $w = 'ID_DEMANDE=\'' . protegeChaineOracle($id_demande) . '\' '.
         'AND ID_DOCUMENT=\'' . protegeChaineOracle($idDossier) . '\'';
    $tab = getDocuments($db,$w);
    foreach($tab as $k => $v){
        if(file_exists($GENERAL_PATH . '/uploads/documents/' . $v['NOM_FICHIER'])){
            @unlink($GENERAL_PATH . '/uploads/documents/' . $v['NOM_FICHIER']);
        }
    }
    $sql =  'delete FROM ARRP_DOCUMENTS WHERE ' . $w;
    $curs = executeReq($db,$sql);
    $msg = 'Document supprimé';
}

if($action == 'AddDOCUMENT' || $action == 'DeleteDOCUMENT'){
    $tabDoc = getDocuments($db,$where);
    $chDoc  = getChaineForDemandesDocuments($tabDoc);
    if($action == 'AddDOCUMENT'){
        echo '<script>';
    }
    echo 'window.document.getElementById(\'DivDocument\').innerHTML = \''.str_replace("'", "\'", $chDoc).'\';tooltip.init();';
    echo 'window.document.getElementById(\'msgAddDoc\').innerHTML = \''.str_replace("'", "\'", $msg).'\';tooltip.init();';
    if($action == 'AddDOCUMENT'){
        echo '</script>';
    }
}
/*
if($action == 'SearchParcelle'){
    $q = isset($_GET['q']) ? $_GET['q'] : '';
    $nsec = isset($_GET['nsec']) ? $_GET['nsec'] : '';
    $tab = array();
    $sql = '';
    if($q != '' && $nsec != ''){
        $sql =  'SELECT IDPARC FROM SIGAIX.PARCELLE_C_S WHERE IDPARC like \'13001000' . protegeChaineOracle($nsec) . protegeChaineOracle($q) . '%\' order by IDPARC';
        $res = executeReq($db,$sql);
        $tab = array();
        while (list($idparc) = $res->fetchRow())
        {
            $tab[] = array(
                            'IDPARC' => substr($idparc,-6)
                          );
        }
    }
    
    $serializer_options = array (
                                   'addDecl' => TRUE,
                                   'encoding' => 'ISO-8859-15',
                                   'indent' => '    ',
                                   'rootName' => 'livesearch_resultat',
                                   'defaultTagName' => 'item',
                             );
    $Serializer = new XML_Serializer($serializer_options); 


    $status = $Serializer->serialize(array(
                                            'requete' => $sql,
                                            'resultats' => $tab,
                                            )
                                    );
    if (PEAR::isError($status))
    {
        die($status->getMessage());
    }

    header('Content-type: text/xml');
    echo $Serializer->getSerializedData();
}
*/
if($action == 'SearchParcelle'){
    $nsec = isset($_GET['nsec']) ? $_GET['nsec'] : '';
    $tab = array();
    $sql = '';
    if($nsec != ''){
        $sql =  'SELECT IDPARC FROM SIGAIX.PARCELLE_C_S WHERE NSEC = \'' . protegeChaineOracle($nsec) . '\' order by IDPARC';
        $res = executeReq($db,$sql);
        $tab = array();
        while (list($idparc) = $res->fetchRow())
        {
            $tab[] = array(
                            'IDPARC' => substr($idparc,-4)
                          );
        }
    }
    
    $serializer_options = array (
                                   'addDecl' => TRUE,
                                   'encoding' => 'ISO-8859-15',
                                   'indent' => '    ',
                                   'rootName' => 'livesearch_resultat',
                                   'defaultTagName' => 'item',
                             );
    $Serializer = new XML_Serializer($serializer_options); 


    $status = $Serializer->serialize(array(
                                            'requete' => $sql,
                                            'resultats' => $tab,
                                            )
                                    );
    if (PEAR::isError($status))
    {
        die($status->getMessage());
    }

    header('Content-type: text/xml');
    echo $Serializer->getSerializedData();
}
/*
if($action == 'SearchParcelle'){
    $nsec = isset($_POST['nsec']) ? $_POST['nsec'] : '';
    $tab = array();
    $sql = '';
    $ch = '';
    if($nsec != ''){
        $sql =  'SELECT IDPARC FROM SIGAIX.PARCELLE_C_S WHERE NSEC = \'' . protegeChaineOracle($nsec) . '\' order by IDPARC';
        $res = executeReq($db,$sql);
        $tab = array();
        $ch = '<select style="width:120px;" name="SelectParcelle" id="SelectParcelle">';
        $ch .= '<option value="">----</option>';
        while (list($idparc) = $res->fetchRow())
        {
            $ch .= '<option value="' . $idparc . '">' . substr($idparc,-6) . '</option>';
        }
        $ch .= '</select>';
    }
    echo 'window.document.getElementById(\'DivParcelle\').innerHTML = \''.str_replace("'", "\'", $ch).'\';';
    echo '$("#SelectParcelle").select2();';
    echo '$("#SelectParcelle").trigger("change");';
}
*/
/*
echo 'ok=0;';
echo 'msg="action: ' . $action . '; id_manifestation: ' . $id_manifestation . '; id_lieux: ' . $id_lieux . '; ' . $date_debut . '; date_fin: ' . $date_fin . '";';
*/
?>