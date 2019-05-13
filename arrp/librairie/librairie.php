<?php
function connexion($userInfo)
{
    global $db;
    $_SESSION[PROJET_NAME]['authentified'] = 0;
    $_SESSION[PROJET_NAME]['autorized'] = 0;
    //$_SESSION[PROJET_NAME]['userInfo'] = $userInfo;
    $login_ldap = is_array($userInfo['login']) ? $userInfo['login'][0] : $userInfo['login'];
    $login_ldap = strtolower($login_ldap);
	$sql = 'select LOGIN_LDAP,NOM,DROIT,ACTIF,CODE_COM,DEFAULT_COM from ARRP_USERS where LOGIN_LDAP=\'' . protegeChaineOracle($login_ldap).'\'';
	$res = executeReq($db,$sql);
	if(list($login_ldap,$nom,$droit,$actif,$code_com,$default_com) = $res->fetchRow()){
		$tabdroit = explode(',',str_replace(';',',',$droit));
		if($actif==1 && in_array('connect',$tabdroit)){
    		$_SESSION[PROJET_NAME]['login_ldap'] = $login_ldap;
    		$_SESSION[PROJET_NAME]['droit'] = $tabdroit;
            $_SESSION[PROJET_NAME]['code_com'] = '\'' . str_replace(',','\',\'',$code_com) . '\'';
            $_SESSION[PROJET_NAME]['tab_code_com'] = explode(',', $code_com);
            $_SESSION[PROJET_NAME]['default_com'] = $default_com;
            $_SESSION[PROJET_NAME]['authentified'] = 1;
    		$_SESSION[PROJET_NAME]['autorized'] = 1;
            $sql = 'update ARRP_USERS set LAST_LOGIN = SYSDATE where LOGIN_LDAP=\'' . protegeChaineOracle($login_ldap).'\'';
            $res = executeReq($db,$sql);
		}else{
		    //echo 'Droit insuffisant';
		    return false;
		}
	}
    return true;
}

function getDemandeurs($db,$where = '',$order=''){
    if($order==''){
        $order = 'NOM,PRENOM';
    }
    $tab = array();
    $sql =  'select ID_DEMANDEUR, NOM, PRENOM, ADRESSE, ADRESSE2, CP, VILLE, EMAIL, TEL1, TEL2, OBSERVATIONS '.
            'from ARRP_DEMANDEURS '.
            ($where == '' ? '' : ('where ' . $where . ' ')).
            'order by '.$order;
    //echo $sql;
    $res = executeReq($db,$sql);
    while(list($id_demandeur,$nom,$prenom,$adresse,$adresse2,$cp,$ville,$email,$tel1,$tel2,$observations) = $res->fetchRow()){
        $tab[$id_demandeur] = array(
                                    'ID_DEMANDEUR'  =>  $id_demandeur,
                                    'NOM'           =>  $nom,
                                    'PRENOM'        =>  $prenom,
                                    'ADRESSE'       =>  $adresse,
                                    'ADRESSE2'      =>  $adresse2,
                                    'CP'            =>  $cp,
                                    'VILLE'         =>  $ville,
                                    'EMAIL'         =>  $email,
                                    'TEL1'          =>  $tel1,
                                    'TEL2'          =>  $tel2,
                                    'OBSERVATIONS'  =>  $observations,
                                );
    }
    return $tab;
}

function getDemandes($db,$where = '',$order=''){
    if($order==''){
        $order = 'DATE_DEMANDE DESC,ID_DEMANDE DESC ';
    }
    $tab = array();
    $sql =  'select ID_DEMANDE, CONTACT, REFERENCE, DATE_DEMANDE, DATE_REPONSE, STATUT_DEMANDE, STATUT_AEP, STATUT_EU, '.
            'OBS_DEMANDE, ID_SIGNATAIRE, ID_ATTESTANT, ID_INTERLOCUTEUR, LIST_PARCELLE,LIST_PARCELLE_ABR, '.
            'ID_DEMANDEUR, NOM, PRENOM, ADRESSE, ADRESSE2, CP, VILLE, EMAIL, TEL1, TEL2, CODE_COM, LIB_COMMUNE '.
            'from ARRP_V_DEMANDES '.
            ($where == '' ? '' : ('where ' . $where . '')).
            'order by '.$order;
    //echo $sql;
    $res = executeReq($db,$sql);
    while(list($id_demande, $contact, $reference, $date_demande, $date_reponse, $statut_demande, $statut_aep, $statut_eu,$obs_demande, $id_signataire, $id_attestant, $id_interlocuteur, $list_parcelle, $list_parcelle_abr,
                $id_demandeur, $nom, $prenom, $adresse, $adresse2, $cp, $ville, $email, $tel1, $tel2, $code_com, $lib_commune) = $res->fetchRow()){
        if($statut_demande=='0'){
            $status = 'A traiter';
        }elseif($statut_demande=='1'){
            $status = 'En cours';
        }elseif($statut_demande=='5'){
            $status = 'Trait&eacute;e';
        }elseif($statut_demande=='9'){
            $status = 'Archiv&eacute;e';
        }else{
            $status = 'Inconnue';
        }
        $tab[$id_demande] = array(
                                    'ID_DEMANDE'            =>  $id_demande,
                                    'CONTACT'               =>  $contact,
                                    'REFERENCE'             =>  $reference,
                                    'DATE_DEMANDE'          =>  $date_demande,
                                    'DATE_REPONSE'          =>  $date_reponse,
                                    'STATUT_DEMANDE'        =>  $statut_demande,
                                    'LIB_STATUT_DEMANDE'    =>  $status,
                                    'STATUT_AEP'            =>  $statut_aep,
                                    'STATUT_EU'             =>  $statut_eu,
                                    'OBSERVATIONS'          =>  $obs_demande,
                                    'ID_SIGNATAIRE'         =>  $id_signataire,
                                    'ID_ATTESTANT'          =>  $id_attestant,
                                    'ID_INTERLOCUTEUR'      =>  $id_interlocuteur,
                                    'LIST_PARCELLE'         =>  $list_parcelle,
                                    'LIST_PARCELLE_ABR'     =>  $list_parcelle_abr,
                                    'ID_DEMANDEUR'          =>  $id_demandeur,
                                    'NOM'                   =>  $nom,
                                    'PRENOM'                =>  $prenom,
                                    'ADRESSE'               =>  $adresse,
                                    'ADRESSE2'              =>  $adresse2,
                                    'CP'                    =>  $cp,
                                    'VILLE'                 =>  $ville,
                                    'EMAIL'                 =>  $email,
                                    'TEL1'                  =>  $tel1,
                                    'TEL2'                  =>  $tel2,
                                    'CODE_COM'              =>  $code_com,
                                    'LIB_COMMUNE'           =>  $lib_commune,
                                );
    }
    return $tab;
}

function getDemandesParcelles($db,$where=''){
    $tab = array();
    $sql =  'select ID_DEM_PARC, ID_DEMANDE, ID_PARC, NSEC '.
            'from ARRP_DEMANDES_PARCELLES '.
            ($where == '' ? '' : ('where ' . $where . ' ')).
            'order by ID_DEM_PARC';
    //echo $sql;
    $res = executeReq($db,$sql);
    while(list($id_dem_parc, $id_demande, $id_parc, $nsec) = $res->fetchRow()){
        $tab[$id_dem_parc] = array(
                                    'ID_DEM_PARC'  =>  $id_dem_parc,
                                    'ID_DEMANDE'   =>  $id_demande,
                                    'ID_PARC'      =>  $id_parc,
                                    'ID_PARC_ABR'  =>  str_replace('#','',substr($id_parc,-6,2)) . ' ' . substr($id_parc,-4),
                                    'SECTION'      =>  $nsec,
                                    'PARCELLE'     =>  substr($id_parc,-4),
                                );
    }
    return $tab;
}

function getDemandesVoies($db,$where=''){
    $tab = array();
    /*
    $sql =  'select ID_DEM_VOIE, ID_DEMANDE, D.CDRURU, V.RUE, V.VOIE, V.LIBVOIE, V.SECTEUR '.
            'from ARRP_DEMANDES_VOIES D, SIGAIX.VR_LISTE_VOIES V '.
            'WHERE D.CDRURU=V.CDRURU '.
            ($where == '' ? '' : ('and ' . $where . ' ')).
            'order by ID_DEM_VOIE';
    */
    //update ARRP_DEMANDES_VOIES v set v.LIBELLE_VOIE=(select distinct rue from sigaix.VR_LISTE_VOIES where cdruru=v.cdruru) where v.LIBELLE_VOIE is null;
    $sql =  'select ID_DEM_VOIE, ID_DEMANDE, CDRURU, LIBELLE_VOIE '.
            'from ARRP_DEMANDES_VOIES '.
            ($where == '' ? '' : ('WHERE ' . $where . ' ')).
            'order by LIBELLE_VOIE,ID_DEM_VOIE';
    //echo $sql;
    $res = executeReq($db,$sql);
    while(list($id_dem_voie, $id_demande, $cdruru, $rue) = $res->fetchRow()){
        $tab[$id_dem_voie] = array(
                                    'ID_DEM_VOIE'   =>  $id_dem_voie,
                                    'ID_DEMANDE'    =>  $id_demande,
                                    'CDRURU'        =>  $cdruru,
                                    'RUE'           =>  $rue,
                                );
    }
    return $tab;
}

function getVoie($db,$code_com,$where=''){
    $tab = array();
    if($code_com == '13001'){
        if($where == ''){
            $where = 'CDRURU < 99999';
        }
        $sql =  'select CDRURU, RUE, VOIE, SECTEUR '.
                'from SIGAIX.VR_LISTE_VOIES '.
                ($where == '' ? '' : ('WHERE ' . $where . ' ')).
                'order by RUE,CDRURU';
    }else{
        $sql =  'select CDRURU, RUE, RUE as VOIE, NULL '.
                'from ARRP_VOIES ' .
                'WHERE CODE_COM=\'' . $code_com . '\' ' .
                ($where == '' ? '' : ('AND ' . $where . ' ')).
                'order by RUE,CDRURU';
    }
    //echo $sql;
    $res = executeReq($db,$sql);
    while(list($cdruru, $rue, $voie, $secteur) = $res->fetchRow()){
        $tab[$cdruru] = array(
                                    'CDRURU'        =>  $cdruru,
                                    'RUE'           =>  $rue,
                                    'VOIE'          =>  $voie,
                                    'SECTEUR'       =>  $secteur,
                                );
    }
    return $tab;
}

function getDocuments($db,$where=''){
    $tab = array();
    $sql =  'select ID_DOCUMENT, ID_DEMANDE, NOM_DOC, NOM_FICHIER, OBSERVATIONS '.
            'from ARRP_DOCUMENTS '.
            ($where == '' ? '' : ('where ' . $where . ' ')).
            'order by ID_DOCUMENT';
    //echo $sql;
    $res = executeReq($db,$sql);
    while(list($id_document, $id_demande, $nom_doc, $nom_fichier, $observations) = $res->fetchRow()){
        $tab[$id_document] = array(
                                    'ID_DOCUMENT'   =>  $id_document,
                                    'ID_DEMANDE'    =>  $id_demande,
                                    'NOM_DOC'       =>  $nom_doc,
                                    'NOM_FICHIER'   =>  $nom_fichier,
                                    'OBSERVATIONS'  =>  $observations,
                                );
    }
    return $tab;
}

function getAgent($db,$where='',$order='AGENT'){
    $sql =  'select ID_AGENT,TYPE_AGENT,AGENT,QUALITE,QUALITE2,TEL,FAX,EMAIL,IS_DEFAULT,ACTIF '.
            'from ARRP_AGENTS '.
            ($where == '' ? '' : 'WHERE ' . $where . ' ').
            'order by ' . $order;
    $res = executeReq($db,$sql);
    $tab =array();
    while(list($id_agent,$type_agent,$agent,$qualite,$qualite2,$tel,$fax,$email,$is_default,$actif) = $res->fetchRow()){
        $tab[$id_agent] = array(
                                    'ID_AGENT'      =>  $id_agent,
                                    'TYPE_AGENT'    =>  $type_agent,
                                    'AGENT'         =>  $agent,
                                    'QUALITE'       =>  $qualite,
                                    'QUALITE2'      =>  $qualite2,
                                    'TEL'           =>  $tel,
                                    'FAX'           =>  $fax,
                                    'EMAIL'         =>  $email,
                                    'IS_DEFAULT'    =>  $is_default,
                                    'ACTIF'         =>  $actif,
                                );
    }
    return $tab;
}

function getCommunes($db,$where = '',$order=''){
    if($order==''){
        $order = 'LIB_COMMUNE';
    }
    $tab = array();
    $sql =  'select CODE_COM, LIB_COMMUNE, LIB_COMMUNE_MIN, CODE_POSTAL, MODE_GEST_VOIE, MODE_GEST_PARC, LAST_NUM_VOIE, FORMAT_PARC '.
            'from ARRP_COMMUNES '.
            ($where == '' ? '' : ('where ' . $where . ' ')).
            'order by '.$order;
    //echo $sql;
    $res = executeReq($db,$sql);
    while(list($code_com, $lib_commune, $lib_commune_min, $code_postal, $mode_gest_voie, $mode_gest_parc, $last_num_voie, $format_parc) = $res->fetchRow()){
        $pos = stripos($format_parc, '#');
        if($pos > 0){
            $format_parc_nb_lettre  = $pos;
            $format_parc_nb_chiffre = strlen($format_parc) - $pos;
        }else{
            $format_parc_nb_lettre  = 2;
            $format_parc_nb_chiffre = 4;
        }
        $tab[$code_com] = array(
                                    'CODE_COM'                  =>  $code_com,
                                    'LIB_COMMUNE'               =>  $lib_commune,
                                    'LIB_COMMUNE_MIN'           =>  $lib_commune_min,
                                    'CODE_POSTAL'               =>  $code_postal,
                                    'MODE_GEST_VOIE'            =>  $mode_gest_voie,
                                    'MODE_GEST_PARC'            =>  $mode_gest_parc,
                                    'LAST_NUM_VOIE'             =>  $last_num_voie,
                                    'FORMAT_PARC'               =>  $format_parc,
                                    'FORMAT_PARC_NB_LETTRE'     =>  $format_parc_nb_lettre,
                                    'FORMAT_PARC_NB_CHIFFRE'    =>  $format_parc_nb_chiffre,

                                );
    }
    return $tab;
}

function DeleteDemandeur($db,$id_demandeur){
    global $GENERAL_PATH;
    $tabSql = array();
    $tabDoc = array();
    $sql = 'select ID_DEMANDE from ARRP_DEMANDES where ID_DEMANDEUR=\'' . protegeChaineOracle($id_demandeur) . '\'';
    $res = executeReq($db,$sql);
    $ok = 1;
    $db->beginTransaction();
    while(list($id_demande) = $res->fetchRow()){
        if($ok == 1 && DeleteDemande($db,$id_demande,true)==false){
            $ok = 0;
        }
    }
    if($ok == 1){
        $sql = 'delete from ARRP_DEMANDEURS where ID_DEMANDEUR=\'' . protegeChaineOracle($id_demandeur) . '\'';
        $curs = executeReq($db,$sql);
        if (DB::isError($curs)){
            $ok = 0;
        }
    }
    if($ok == 1){
        $db->commit();
        return true;
    }else{
        $db->rollback();
        return false;
    }
}

function DeleteDemande($db,$id_demande,$inTransaction=false){
    global $GENERAL_PATH;
    $tabSql = array();
    $tabDoc = array();
    $sql = 'select NOM_FICHIER from ARRP_DOCUMENTS where ID_DEMANDE=\'' . protegeChaineOracle($id_demande) . '\'';
    $res = executeReq($db,$sql);
    while(list($fichier) = $res->fetchRow()){
        $tabDoc[] = $fichier;
    }
    if($inTransaction == false)
        $db->beginTransaction();
    $tabSql[] = 'delete from ARRP_DEMANDES_PARCELLES where ID_DEMANDE=\'' . protegeChaineOracle($id_demande) . '\'';
    $tabSql[] = 'delete from ARRP_DEMANDES_VOIES where ID_DEMANDE=\'' . protegeChaineOracle($id_demande) . '\'';
    $tabSql[] = 'delete from ARRP_DOCUMENTS where ID_DEMANDE=\'' . protegeChaineOracle($id_demande) . '\'';
    $tabSql[] = 'delete from ARRP_DEMANDES where ID_DEMANDE=\'' . protegeChaineOracle($id_demande) . '\'';
    $ok = 1;
    foreach($tabSql as $sql){
        if($ok == 1){
            $curs = executeReq($db,$sql);
            if (DB::isError($curs)){
                $ok = 0;
            }
        }
    }
    foreach($tabDoc as $fichier){
        if($ok==1 && file_exists($GENERAL_PATH . '/uploads/documents/'.$fichier)){
            if(unlink($GENERAL_PATH . '/uploads/documents/'.$fichier) == false){
                $ok = 0;
            }
        }
    }
    if($ok == 1){
        if($inTransaction == false)
            $db->commit();
        return true;
    }else{
        if($inTransaction == false)
            $db->rollback();
        return false;
    }
}

function getChaineForDemandesParcelles($tab)
{
    $ch  = '<TABLE id="ListParcelle" class="table boo-table table-content table-bordered table-condensed table-striped table-hover span3 font14">'.
                '<thead>'.
                    '<tr>'.
                        '<th>Parcelle</th>'.
                        '<th style="width:50px;">action</th>'.
                    '</tr>'.
                '</thead>'.
                '<tbody>';
                foreach($tab as $k => $v){
                    $ch .= '<tr>'.
                                '<td>'.$v['ID_PARC_ABR'] . '</td>'.
                                '<td style="text-align:center">'.
                                ((in_array('admin',$_SESSION[PROJET_NAME]['droit']) || in_array('saisie',$_SESSION[PROJET_NAME]['droit'])) ? ('<a href="javascript:void(0)" onClick="SupprimerParcelle(' . $v['ID_DEM_PARC'] . ',\'' . $v['ID_PARC_ABR'] . '\')"><img src="./images/delete_24.png" /></a>') : '').
                                '</td>'.
                            '</tr>';
                }


        $ch .=  '</tbody></table>';
    return $ch;
}

function getChaineForDemandesVoies($tab){
    $ch =  '<TABLE id="ListRue" class="table boo-table table-content table-bordered table-condensed table-striped table-hover span6 font14">'.
                '<thead>'.
                    '<tr>'.
                        '<th style="width:50px;">CDRURU</th>'.
                        '<th>Rue</th>'.
                        '<th style="width:50px;">action</th>'.
                    '</tr>'.
                '</thead>'.
                '<tbody>';
                foreach($tab as $k => $v){
                    $cdruru = substr($v['CDRURU'],-6)+0;
                    $ch .= '<tr>'.
                                '<td style="text-align:right;">'. $cdruru . '</td>'.
                                '<td>'.$v['RUE'] . '</td>'.
                                '<td style="text-align:center">'.
                                ((in_array('admin',$_SESSION[PROJET_NAME]['droit']) || in_array('saisie',$_SESSION[PROJET_NAME]['droit'])) ? ('<a href="javascript:void(0)" onClick="SupprimerVoie(' . $v['ID_DEM_VOIE'] . ',\'' . $cdruru . '\')"><img src="./images/delete_24.png" /></a>') : '').
                                '</td>'.
                            '</tr>';
                }
        $ch .=  '</tbody></table>';
    
    return $ch;
}

function getChaineForDemandesDocuments($tab){
    $ch =   '<table id="ListDocuments" class="table boo-table table-content table-bordered table-condensed table-striped table-hover span6 font14">'.
                '<thead>'.
                    '<tr>'.
                        '<th style="width:50px;">#ID</th>'.
                        '<th>Document</th>'.
                        '<th style="width:50px;">Voir</th>'.
                        '<th style="width:50px;">action</th>'.
                    '</tr>'.
                '</thead>'.
                '<tbody>';
                foreach($tab as $k => $v){
                    $ch .= '<tr>'.
                                '<td style="text-align:right;">'.$v['ID_DOCUMENT'] . '</td>'.
                                '<td>'.$v['NOM_DOC'] . '</td>'.
                                '<td style="text-align:center"><a href="./uploads/documents/' . $v['NOM_FICHIER'] . '" target="blank"><img src="./images/document_24.png" /></a></td>'.
                                '<td style="text-align:center">'.
                                ((in_array('admin',$_SESSION[PROJET_NAME]['droit']) || in_array('saisie',$_SESSION[PROJET_NAME]['droit'])) ? ('<a href="javascript:void(0)" onClick="SupprimerDocument(' . $v['ID_DOCUMENT'] . ',\'' . $v['ID_DOCUMENT'] . '\')"><img src="./images/delete_24.png" /></a>') : '').
                                '</td>'.
                            '</tr>';
                }
        $ch .= '</tbody></table>';
    return $ch;
}

function getParametre($db,$param_code){
    $sql =  'select PARAM_VALUE '.
            'from ARRP_PARAMETRES '.
            'where PARAM_CODE=\'' . protegeChaineOracle($param_code) . '\'';
    $res = executeReq($db,$sql);
    list($param_value) = $res->fetchRow();
    return $param_value;
}

function setParametre($db,$param_code,$param_value,$param_desc=''){
    $sql =  'select PARAM_CODE '.
            'from ARRP_PARAMETRES '.
            'where PARAM_CODE=\'' . protegeChaineOracle($param_code) . '\'';
    $res = executeReq($db,$sql);
    if(list($p_v) = $res->fetchRow()){
        $sql =  'UPDATE ARRP_PARAMETRES set '.
                'PARAM_VALUE=\'' . protegeChaineOracle($param_value) . '\''.
                ($param_desc=='null' ? ',PARAM_DESC=null' : ($param_desc != '' ? 'PARAM_DESC=\'' . protegeChaineOracle($param_desc) . '\'' : '')). ' ' .
                'WHERE PARAM_CODE=\'' . protegeChaineOracle($param_code) . '\'';
    }else{
        $sql =  'INSERT INTO ARRP_PARAMETRES (PARAM_CODE,PARAM_VALUE,PARAM_DESC)'.
                'values('.
                            '\'' . protegeChaineOracle($param_code) . '\','.
                            '\'' . protegeChaineOracle($param_value) . '\','.
                            '\'' . protegeChaineOracle($param_desc) . '\''.
                        ')';
    }
    $curs = executeReq($db,$sql);
    return (DB::isError($curs)) ? false: true;
}

function generateInputHidden($nom_variable)
{
    eval('global $' . $nom_variable . ';');
    eval('$'.'value = $' . $nom_variable . ';');
    $ch = '<input type="hidden" name="' . $nom_variable . '" value="' . $value . '">' . "\n";
    return $ch;
}

class MY_FPDF extends PDF_Mairie{
    function afficheLogo2($couleur='COULEUR', $tailleLogoWidth = 43){
        global $GELERAL_PATH;
        $border = 0;
        $x = $this->retraitX + (($this->enteteLongueur  - $tailleLogoWidth) / 2) - 0.5;
        //if ($couleur == 'COULEUR')
            $this->Image($GELERAL_PATH . './images/regie_eaux_pays_aix2.jpg',$x,$this->retraitY, $tailleLogoWidth);
        //else
            //$this->Image(FPDF_FONTPATH . 'blasonaix_officiel_2015_nb.jpg',$x,$this->retraitY, $tailleLogoWidth);
        
        // Aix en provence
        //$x = 5;
        $x = $this->retraitX;
        $y = $this->retraitY+$tailleLogoWidth/2+3;

        $this->setXY($x,$y);
        $this->SetFont('gandhisans','',$this->enteteTexteTaille);
        $this->MultiCell($this->enteteLongueur, 3, $this->enteteTexte, $border, 'L');

        $x = 2;
        $y = 253.5;
        $this->setXY($x,$y);
        $this->Image($GELERAL_PATH . './images/regie_eaux_pays_aix_bas.jpg',$x,$y, 208);
    }
}

function getMaxId($db,$table,$colonne,$where=''){
    $sql =  'select nvl(max(' . $colonne . '),0)+1 from ' . $table . ($where == '' ? '' : ' where ' . $where);
    $curs = executeReq($db,$sql);
    list($nb) = $curs->fetchRow();
    if($nb == ''){
        $nb = 1;
    }
    return $nb;
}

function protegeChaineForLiveSearch($ch)
{
    return htmlentitiesIso(str_replace("'", "\'", $ch));
}

if(!function_exists('generateToken')){
    function generateToken($longueur=32){
        $chrs = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S' ,'T', 'U', 'V', 'W', 'X', 'Y', 'Z', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
        $f='';
        $n=count($chrs)-1;
        for($i=0;$i<$longueur;$i++){
            $f.=$chrs[mt_rand(0,$n)];
        }
        return $f;
    }
}

?>