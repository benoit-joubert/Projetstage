<?php
set_time_limit(600);
if(isset($_POST['action']))
    $action = $_POST['action'];
elseif (isset($_GET['action']))
    $action = $_GET['action'];
else
    $action = '';
if (isset($_POST['id_demande']))
    $id_demande = $_POST['id_demande'];
elseif (isset($_GET['id_demande']))
    $id_demande = $_GET['id_demande'];
else
    $id_demande = '';

$tab = getDemandes($db,'ID_DEMANDE=\'' . protegeChaineOracle($id_demande) . '\'');
$ok = 1;
$msg = '';
if($id_demande == '' || !isset($tab[$id_demande])){
    $ok = 0;
    $msg = 'Demande introuvable';
}
$tabDemande = $tab[$id_demande];
$tab = getDemandeurs($db,'ID_DEMANDEUR=\'' . protegeChaineOracle($tabDemande['ID_DEMANDEUR']) . '\'');
if($id_demande == '' || !isset($tab[$tabDemande['ID_DEMANDEUR']])){
    $ok = 0;
    $msg = 'Demandeur introuvable';
}
$tabDemandeur = $tab[$tabDemande['ID_DEMANDEUR']];
if($ok == 1 && strlen($tabDemande['STATUT_AEP']) == 0){
    $ok = 0;
    $msg = 'Veuillez indiquer une réponse pour le réseau AEP';
}
if($ok == 1 && strlen($tabDemande['STATUT_EU']) == 0){
    $ok = 0;
    $msg = 'Veuillez indiquer une réponse pour le réseau EU';
}
if($ok == 1 && strlen($tabDemande['ID_INTERLOCUTEUR']) == 0){
    $ok = 0;
    $msg = 'Veuillez indiquer l\'interlocuteur de la demande';
}
if($ok == 1 && strlen($tabDemande['ID_ATTESTANT']) == 0){
    $ok = 0;
    $msg = 'Veuillez indiquer la personne attestant le courrier';
}
if($ok == 1 && strlen($tabDemande['ID_SIGNATAIRE']) == 0){
    $ok = 0;
    $msg = 'Veuillez indiquer le signataire du courrier';
}
if($ok == 0){
    $page->afficheHeader();
    echo '<br/><font color="red">' . $msg . '</font><br/>&nbsp;';
    $page->afficheFooter();
    deconnexionDesBases();
    exit;
}

$Commune = new ArrpCommunes($db);
$Commune->select(array('code_com'=>$tabDemande['CODE_COM']));
$code_com           = $Commune->getCodeCom();
$lib_commune        = $Commune->getLibCommune();
$lib_commune_min    = $Commune->getLibCommuneMin();

$tab = getAgent($db,'ID_AGENT=\'' . $tabDemande['ID_INTERLOCUTEUR'] . '\'');
if(isset($tab[$tabDemande['ID_INTERLOCUTEUR']])){
    $tab = $tab[$tabDemande['ID_INTERLOCUTEUR']];
    $interlocuteur = $tab['AGENT'];
    $interlocuteur_tel = $tab['TEL'];
    $interlocuteur_fax = $tab['FAX'];
}else{
    $interlocuteur = '';
    $interlocuteur_tel = '';
    $interlocuteur_fax = '';
}

$tab = getAgent($db,'ID_AGENT=\'' . $tabDemande['ID_ATTESTANT'] . '\'');
if(isset($tab[$tabDemande['ID_ATTESTANT']])){
    $tab = $tab[$tabDemande['ID_ATTESTANT']];
    $attestant = $tab['AGENT'];
    $attestant_qualite = $tab['QUALITE'];
    $attestant_qualite2 = $tab['QUALITE2'];
}else{
    $attestant = '';
    $attestant_qualite = '';
    $attestant_qualite2 = '';
}

$tab = getAgent($db,'ID_AGENT=\'' . $tabDemande['ID_SIGNATAIRE'] . '\'');
if(isset($tab[$tabDemande['ID_SIGNATAIRE']])){
    $tab = $tab[$tabDemande['ID_SIGNATAIRE']];
    $signataire = $tab['AGENT'];
    $signataire_qualite = $tab['QUALITE'];
    $signataire_qualite2 = $tab['QUALITE2'];
}else{
    $signataire = '';
    $signataire_qualite = '';
    $signataire_qualite2 = '';
}

$tab = getDemandesParcelles($db,'ID_DEMANDE=\'' . $tabDemande['ID_DEMANDE'] . '\'');
$parcelle = '';
$nb_parcelle = 0;
foreach($tab as $k => $v){
    $nb_parcelle++;
    //$parcelle .= ($parcelle == '' ? '' : ', ') . $v['SECTION'] . ' ' . ($v['PARCELLE'] + 0);
    $parcelle .= ($parcelle == '' ? '' : ', ') . $v['ID_PARC_ABR'];
}

$tab = getDemandesVoies($db,'ID_DEMANDE=\'' . $tabDemande['ID_DEMANDE'] . '\'');
$parcelle_adresse = '';
$nb_voie = 0;
foreach($tab as $k => $v){
    $nb_voie++;
    $parcelle_adresse .= ($parcelle_adresse == '' ? '' : "\n") . $v['RUE'];
}


$total = 0;
$pdf = new MY_FPDF('P');
$pdf->AliasNbPages('{nb}');
$pdf->AddFont('gandhisans','','gandhisans.php');
$pdf->AddFont('gandhisans','B','gandhisansb.php');
$pdf->AddFont('gandhisans','I','gandhisansi.php');
$pdf->AddFont('gandhisans','BI','gandhisansbi.php');
$pdf->SetLeftMargin(15);
$pdf->SetRightMargin(15);
$pdf->SetFillColor(228,228,228);
$pdf->setEnteteTexteTaille(9);
$pdf->setEnteteLongueur(45);
$pdf->SetAutoPageBreak(false);
$EnteteText = getParametre($db,'COURRIER_ENTETE');
$EnteteText = str_replace('##',"\n",$EnteteText);
/*
$EnteteText = "DIRECTION GENERALE DES SERVICES TECHNIQUE,".
              "\nENVIRONNEMENT URBAIN ET HYDRAULIQUE".
              "\nDirection des Projets Hydroliques & Pluvial".
              "\nService Bureau d'Etudes".
              "\n3 rue Loubet".
              "\n13100 AIX EN PROVENCE";
*/
$pdf->setEnteteTexte($EnteteText);
$pdf->retraitX = 17;
$pdf->retraitY = 15;
$b = 0;
$pdf->SetTextColor(180);
$pdf->AddPage();
$pdf->afficheLogo2(); // Affichage du logo
$pdf->SetTextColor(0);
$pdf->retraitX = 10;
$pdf->retraitY = 15;
$pdf->SetFont('gandhisans','',11);
$pdf->setXY(140,20);
$pdf->Cell(60,5,'Aix en Provence, le ',$b,0,'L');
$demandeur = $tabDemandeur['NOM'] . "\n" . $tabDemandeur['PRENOM']  . "\n";
$demandeur .= $tabDemandeur['ADRESSE'] . ($tabDemandeur['ADRESSE2'] == '' ? '' : "\n" . $tabDemandeur['ADRESSE2']) . "\n";
$demandeur .= $tabDemandeur['CP'] . ' ' . $tabDemandeur['VILLE'];
//$y = 55;
$y = 45;
$pdf->setXY(105,$y);
$pdf->SetFont('gandhisans','b',11);
$pdf->MultiCell(85,5,$demandeur,$b,'C');
//$y = $pdf->getY() + 15;
/*
$pdf->setXY(105,$y);
$pdf->Cell(90,5,'Aix en Provence, le ' . date('d/m/Y'),$b,0,'R');
*/
$x = 10;
$y = 80;
$h = 5;
$pdf->SetFont('gandhisans','',10);
$pdf->setXY($x,$y);
$pdf->Cell(32,$h,'Interlocuteur : ',$b,0,'R');
//$pdf->SetFont('gandhisans','',10);
$pdf->Cell(130,$h,$interlocuteur,$b,0,'L');
//$pdf->SetFont('gandhisans','b',10);
$y += $h;
$pdf->setXY($x,$y);
$pdf->Cell(32,$h,'Tél : ',$b,0,'R');
//$pdf->SetFont('gandhisans','',10);
$pdf->Cell(130,$h,$interlocuteur_tel,$b,0,'L');
//$pdf->SetFont('gandhisans','b',10);
$y += $h;
$pdf->setXY($x,$y);
$pdf->Cell(32,$h,'Fax : ',$b,0,'R');
//$pdf->SetFont('gandhisans','',10);
$pdf->Cell(130,$h,$interlocuteur_fax,$b,0,'L');

//$pdf->SetFont('gandhisans','b',10);
$y += $h;
$pdf->setXY($x,$y);
$pdf->Cell(32,$h,'Rédigé le : ',$b,0,'R');
//$pdf->SetFont('gandhisans','',10);
$pdf->Cell(130,$h,date('d/m/Y'),$b,0,'L');

$y += 2*$h;
$pdf->setXY($x,$y);
//$pdf->SetFont('gandhisans','b',10);
$pdf->Cell(32,$h,'Demandeur : ',$b,0,'R');
//$pdf->SetFont('gandhisans','',10);
$pdf->Cell(130,$h,$tabDemande['CONTACT'],$b,0,'L');
//$pdf->SetFont('gandhisans','b',10);
$y += $h;
$pdf->setXY($x,$y);
$pdf->Cell(32,$h,'Référence : ',$b,0,'R');
//$pdf->SetFont('gandhisans','',10);
$pdf->Cell(130,$h,$tabDemande['REFERENCE'],$b,0,'L');
//$pdf->SetFont('gandhisans','b',10);
$y += $h;
$pdf->setXY($x,$y);
$pdf->Cell(32,$h,'Commune :',$b,0,'R');
//$pdf->SetFont('gandhisans','',10);
$pdf->Cell(130,$h,$lib_commune,$b,0,'L');
//$pdf->SetFont('gandhisans','b',10);
$y += $h;
$pdf->setXY($x,$y);
$pdf->Cell(32,$h,'Parcelle' . ($nb_parcelle>1 ? 's' : '').' : ',$b,0,'R');
//$pdf->SetFont('gandhisans','',10);
$pdf->Cell(130,$h,$parcelle,$b,0,'L');
//$pdf->SetFont('gandhisans','b',10);
$y += $h;
$pdf->setXY($x,$y);
$pdf->Cell(32,$h,'Adresse : ',$b,0,'R');
//$pdf->SetFont('gandhisans','',10);
$pdf->MultiCell(100,$h,$parcelle_adresse,$b,'L');
//$pdf->SetFont('gandhisans','b',11);

$y = $pdf->getY() + 1.5*$h;
$pdf->SetFont('gandhisans','b',14);
$width = 60;
$x2 = ($pdf->w - $width) / 2;
$pdf->setXY($x2,$y);
$pdf->Cell($width,3*$h,'ATTESTATION',1,0,'C',1);
$y = $pdf->getY() + 3*$h + 1.5*$h;
$pdf->setXY($x,$y);
$txt = $attestant_qualite . ', atteste que ' . ($nb_parcelle>1 ? 'les' : 'la') . ' parcelle'. ($nb_parcelle>1 ? 's' : '') . ' citée'. ($nb_parcelle>1 ? 's' : '') . ' en objet, ' . ($nb_parcelle>1 ? 'sont' : 'est') . ' actuellement :';
$pdf->SetFont('gandhisans','',11);
//$b=1;
$pdf->MultiCell(185,$h,$txt,$b,'J');
$y = $pdf->getY() + $h;
$pdf->SetFont('gandhisans','b',11);
$pdf->setXY($x+4,$y);
$txt = '- ' . ($tabDemande['STATUT_AEP']=='1' ? 'Raccordable' : 'Non raccordable') . ($nb_parcelle>1 ? 's' : '') . ' au réseau public d\'Adduction d\'Eau Potable de la Régie des Eaux du Pays d\'Aix';
$pdf->Cell(185,$h,$txt,$b,0,'L');
$y += $h;
$pdf->setXY($x+4,$y);
$txt = '- ' . ($tabDemande['STATUT_EU']=='1' ? 'Raccordable' : 'Non raccordable') . ($nb_parcelle>1 ? 's' : '') . ' au réseau public d\'Eaux Usées de la Régie des Eaux du Pays d\'Aix';
$pdf->Cell(185,$h,$txt,$b,0,'L');

$y += 2*$h + 1;
$y_start = $y - 1;
$pdf->setXY($x+1,$y);
$pdf->SetFont('gandhisans','b',10);
$pdf->Cell(29,$h-1,'Observations :',$b,0,'L');
$pdf->SetFont('gandhisans','',10);
$obs = $tabDemande['OBSERVATIONS'] == '' ? 'Néant' : $tabDemande['OBSERVATIONS'];
$pdf->MultiCell(155,$h-1,$obs,$b,'L');
$y_fin = $pdf->getY()+1;
$pdf->setXY($x,$y_start);
$h2 = ($y_fin-$y_start < 15 ? 15 : $y_fin-$y_start);
$pdf->Cell(29+155+5,$h2,'',1,0);
$y = $y_start + $h2 + $h;
$pdf->setXY($x,$y);
$pdf->SetFont('gandhisans','i',10);
$pdf->Cell(185,$h,'La présente attestation ne vaut pas certificat de conformité ni de raccordement.',$b,0,'L');
$y = 245;
$pdf->SetFont('gandhisans','',11);
$pdf->setXY(125,$y);
$pdf->MultiCell(70,$h-1,$signataire . "\n\n" . str_replace('\n',"\n",$signataire_qualite),0,'C');

/*
$y = 277;
$y1 = $y2 = $y;
$x2 = $pdf->w - 10;
$pdf->line($x,$y1,$x2,$y2); // Trait bas
$y += 1;

$pdf->SetFont('gandhisans','',8);
$pdf->setXY($x+5,$y);
$param_nota = getParametre($db,'COURRIER_NOTA');
$pdf->MultiCell(180,$h-2,$param_nota,$b,'J');
$y_fin = $pdf->getY();
$x1 = $x+5+0.7;
$y1 = $y+$h-2.1;
$x2 = $x1+10;
$y2 = $y1;
$pdf->line($x1,$y1,$x2,$y2);//NOTA
*/

/*
$y = $y1+1;
$pdf->SetFont('gandhisans','i',8);
$pdf->setXY($x,$y);
//$param_bas_page = 'Place de l\'Hôtel de Ville - 13616 Aix-en-Provence - Cedex1 - tél.: 04 42 91 95 95 - Télécopie: 04 42 91 90 75 - Internet: www.aixenprovence.fr';

$pdf->Image($GELERAL_PATH . './images/rem_horizontal_2.jpg',$x,$y, 50,8);
$y = $y1+2;
$pdf->setXY($x+51,$y);
$param_bas_page = getParametre($db,'COURRIER_BAS_PAGE');
$pdf->MultiCell(110,$h-2,$param_bas_page,$b,'J');
*/
$pdf->output();
unset($pdf);

?>
