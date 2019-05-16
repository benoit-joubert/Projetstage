<?php

require 'pdf/fpdf.php';

class PDF extends FPDF {
    private $new2old = array(
        'á' => 'Ã¡',
        'À' => 'Ã?',
        'ä' => 'Ã¤',
        'Ä' => 'Ã?',
        'ã' => 'Ã£',
        'å' => 'Ã¥',
        'Å' => 'Ã?',
        'æ' => 'Ã¦',
        'Æ' => 'Ã?',
        'ç' => 'Ã§',
        'Ç' => 'Ã?',
        'é' => 'Ã©',
        'É' => 'Ã?',
        'è' => 'Ã¨',
        'È' => 'Ã?',
        'ê' => 'Ãª',
        'Ê' => 'Ã?',
        'ë' => 'Ã«',
        'Ë' => 'Ã?',
        'í' => 'Ã-­­',
        'Í' => 'Ã',
        'ì' => 'Ã¬',
        'Ì' => 'Ã?',
        'î' => 'Ã®',
        'Î' => 'Ã?',
        'ï' => 'Ã¯',
        'Ï' => 'Ã',
        'ñ' => 'Ã±',
        'Ñ' => 'Ã?',
        'ó' => 'Ã³',
        'Ó' => 'Ã?',
        'ò' => 'Ã²',
        'Ò' => 'Ã?',
        'ô' => 'Í',
        'Ô' => 'Ã?',
        'ö' => 'Ã¶',
        'Ö' => 'Ã?',
        'õ' => 'Ãµ',
        'Õ' => 'Ã?',
        'ø' => 'Ã¸',
        'Ø' => 'Ã?',
        '?' => 'Å?',
        '?' => 'Å?',
        'ß' => 'Ã?',
        'ú' => 'Ãº',
        'Ú' => 'Ã?',
        'ù' => 'Ã¹',
        'Ù' => 'Ã?',
        'û' => 'Ã»',
        'Û' => 'Ã?',
        'ü' => 'Ã¼',
        'Ü' => 'Ã?',
        '?' => 'â?¬',
        '?' => 'â??',
        '?' => 'â??',
        '?' => 'Æ?',
        '?' => 'â??',
        '?' => 'â?¦',
        '?' => 'â?¡',
        '?' => 'Ë?',
        '?' => 'â?°',
        '?' => 'Å ',
        '?' => 'â?¹',
        '?' => 'Å½',
        '?' => 'â??',
        '?' => 'â??',
        '?' => 'â?¢',
        '?' => 'â??',
        '?' => 'â??',
        '?' => 'Ë?',
        '?' => 'â?¢',
        '?' => 'Å¡',
        '?' => 'â?º',
        '?' => 'Å¾',
        '?' => 'Å¸',
        '¡' => 'Â¡',
        '¢' => 'Â¢',
        '£' => 'Â£',
        '¤' => 'Â¤',
        '¥' => 'Â¥',
        '¦' => 'Â¦',
        '§' => 'Â§',
        '¨' => 'Â¨',
        '©' => 'Â©',
        'ª' => 'Âª',
        '«' => 'Â«',
        '¬' => 'Â¬',
        '®' => 'Â®',
        '¯' => 'Â¯',
        '°' => 'Â°',
        '±' => 'Â±',
        '²' => 'Â²',
        '³' => 'Â³',
        '´' => 'Â´',
        'µ' => 'Âµ',
        '¶' => 'Â¶',
        '·' => 'Â·',
        '¸' => 'Â¸',
        '¹' => 'Â¹',
        'º' => 'Âº',
        '»' => 'Â»',
        '¼' => 'Â¼',
        '½' => 'Â½',
        '¾' => 'Â¾',
        '¿' => 'Â¿',
        'à' => 'Ã ',
        '?' => 'â? ',
        '?' => 'â?',
        'Á' => 'Ã',
        'â' => 'Ã¢',
        'Â' => 'Ã?',
        'Ã' => 'Ã?',
    );

    function headerRegistered() {

        $this->SetXY(17, 15);
        $this->Image('../images/logoMairie.png', $this->GetX(), $this->GetY(), 14 , 24);
        $this->SetXY(182, 15);
        $this->Image('../images/logoMairie.png', $this->GetX(), $this->GetY(), 14 , 24);

        $this->SetXY(73, 15);
        $this->SetFont('Times','B',14);
        $this->Cell(60,5,'VILLE D\'AIX EN PROVENCE',0,0,'C');
        $this->SetXY(73, 22);
        $this->SetFont('Times','B',10);
        $this->Cell(60,5,'Station Thermale et Climatique',0,0,'C');
        $this->SetXY(73, 27);
        $this->SetFont('Times','B',12);
        $this->Cell(60,7,'DEPARTEMENT AMENAGEMENT URBAIN',0,0,'C');
        $this->SetXY(73, 33);
        $this->SetFont('Times','B',10);
        $this->Cell(60,7,'Direction de l\'Urbanisme et du Foncier',0,0,'C');
        $this->SetXY(73, 40);
        $this->Cell(60,7,'Bureau de l\'Application de Droit des Sols',0,0,'C');
        $this->SetXY(73, 47);
        $this->Cell(60,7,'Tel. : 04.42.91.96.07',0,0,'C');
        $this->SetXY(56, 55);
        $this->SetFont('Times','B',14);
        $this->SetFillColor(177, 181, 188);
        $this->Cell(93,7,'LISTES DES RECOMMANDES',1,0,'C',true);

        $this->SetXY(5, 64);
        $this->SetFont('Arial','B',10);
        $this->SetDrawColor(139, 0, 0);
        $this->Cell(67,8,'N. Dossier','TB',0,'L');
        $this->Cell(67,8,'NOM - ADRESSE','TB',0,'C');
        $this->Cell(67,8,'Date','TB',0,'R');
    }

    function bodyRegistered($json)
    {
        foreach($this->new2old as $key => $value ) {
            $new[] = $key;
            $old[] = $value;
        }
        $json = json_decode($json);
        $cpt = 2;
        $db = oci_connect('GEOPC_RECOMMANDEES', 'test', 'sdiadem-cluster.intranet/SIGTEST');
        foreach ($json as $array) {
            $nbe = count($json, COUNT_RECURSIVE);
            if ($nbe > 1) {
                foreach ($array as $registered) {
                    $sql = 'SELECT ID_ARRETE FROM T_COMPLETE WHERE DOSSIER = \'' . $registered->DOSSIER . '\'';
                    $stid = oci_parse($db, $sql);
                    oci_execute($stid);
                    $numero = '';
                    while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
                        foreach ($row as $item) {
                            $numero = $item;
                        }
                    }
                    $this->fillBodyRegistered(str_replace($old, $new,$registered->DEMANDEUR), '', str_replace($old, $new,$registered->ADRESSE), str_replace($old, $new,$registered->CODE_POSTAL), str_replace($old, $new,$registered->VILLE), str_replace($old, $new,$registered->DOSSIER), str_replace($old, $new,$registered->TYPE_ENVOI), str_replace($old, $new,$registered->INSTRUCT), $numero);
                    if ($cpt != $nbe) {
                        $this->AddPage('P', 'A4', 0);
                        $cpt += 1;
                    }
                }
            } else {
                $sql = 'SELECT ID_ARRETE FROM T_COMPLETE WHERE DOSSIER = \'' . $array->DOSSIER . '\'';
                $stid = oci_parse($db, $sql);
                oci_execute($stid);
                $numero = '';
                while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
                    foreach ($row as $item) {
                        $numero = $item;
                    }
                }
                $this->fillBodyRegistered(str_replace($old, $new,$array->DEMANDEUR), '', str_replace($old, $new,$array->ADRESSE), str_replace($old, $new,$array->CODE_POSTAL), str_replace($old, $new,$array->VILLE), str_replace($old, $new,$array->DOSSIER), str_replace($old, $new,$array->TYPE_ENVOI), str_replace($old, $new,$array->INSTRUCT), $numero);
                }
            }
        }

    function fillBodyRegistered($recipient, $recipient_comp, $address, $pc, $city, $fileNum, $type, $instruct, $idarret){

        //Cross R1 Yellow Part
        $this->SetY(30);
        $this->SetX(85);
        $this->SetFont('Arial','B',12);
        $this->MultiCell(0,3,'X',0,'L');
        //Cross Lettre Yellow Part
        $this->Ln();
        $this->SetX(85);
        $this->MultiCell(0,2,'X',0,'L');
        //Line Recipient Yellow and White part
        $this->Ln(4);
        $this->SetX(36);
        $this->MultiCell(70,4,$recipient,0,'L');
        $this->Ln(-7);
        $this->SetX(122);
        $this->MultiCell(0,4,$recipient,0,'L');
        //Line Recipient_Comp Yellow and White part
        $this->Ln(1);
        $this->SetX(122);
        $this->MultiCell(0,2,$recipient_comp,0,'L');
        $this->SetX(36);
        $this->MultiCell(0,3,$recipient_comp,0,'L');
        //Line Address Yellow and White part
        $this->Ln(-1);
        $this->SetX(36);
        $this->MultiCell(70,4,$address,0,'L');
        $this->Ln(-9);
        $this->SetX(122);
        $this->MultiCell(70,4,$address,0,'L');
        //Line CP Yellow and White part
        $this->Ln(7);
        $this->SetX(36);
        $this->MultiCell(0,0,$pc,0,'L');
        $this->SetX(51);
        $this->MultiCell(0,0,$city,0,'L');
        $this->SetX(122);
        $this->MultiCell(0,0,$pc,0,'L');
        $this->SetX(137);
        $this->MultiCell(0,0,$city,0,'L');
        //Line FileNum and Type Yellow and White part
        $this->Ln(5);
        $this->SetX(36);
        $this->MultiCell(0,0,'N: ' . $fileNum,0,'L');
        $this->Ln(-2);
        $this->SetX(69);
        if ($type == 'Arrete') {
            $this->MultiCell(60,4,$type . ' ' . $idarret,0,'L');
        }
        else {
            $this->MultiCell(60,4,$type,0,'L');
        }
        $this->Ln(-2);
        $this->SetX(122);
        $this->MultiCell(0,0,'N: ' . $fileNum,0,'L');
        $this->Ln(-2);
        $this->SetX(158);
        if ($type == 'Arrete') {
            $this->MultiCell(60,4,$type . ' ' . $idarret,0,'L');
        }
        else {
            $this->MultiCell(60,4,$type,0,'L');
        }
        //Cross Grey Part
        $this->SetXY(98,132);
        $this->MultiCell(0,3,'X',0,'L');
        $this->Ln();
        $this->SetX(98);
        $this->MultiCell(0,3,'X',0,'L');
        //Destinataire Grey Part
        $this->Ln();
        $this->SetX(55);
        $this->MultiCell(70,4,$recipient,0,'L');
        //Line Recipient_Comp Grey part
        $this->Ln();
        $this->SetX(55);
        $this->MultiCell(0,3,$recipient_comp,0,'L');
        //Line Address Grey Part
        $this->Ln(-6);
        $this->SetX(55);
        $this->MultiCell(70,4,$address,0,'L');
        //Line CP and City Grey part
        $this->Ln(5);
        $this->SetX(55);
        $this->MultiCell(0,0,$pc,0,'L');
        $this->SetX(70);
        $this->MultiCell(0,0,$city,0,'L');
        //FileNum and Type Grey Part
        $this->Ln(6);
        $this->SetX(54);
        $this->MultiCell(0,0,'N: ' . $fileNum,0,'L');
        $this->SetX(88);
        if ($type == 'Arrete') {
            $this->MultiCell(0, 0, $type . ' ' . $idarret, 0, 'L');
        }
        else {
            $this->MultiCell(0, 0, $type, 0, 'L');
        }
        //shipping agent Grey Part
        $this->Ln(12);
        $this->SetX(56);
        $this->SetFont('Arial','',12);
        $this->MultiCell(0,0, 'VILLE D\'AIX EN PROVENCE',0,'L');
        $this->Ln(5);
        $this->SetX(56);
        $this->MultiCell(0,0, 'DIRECTION DE L\'URBANISME ( A.D.S. )',0,'L');
        $this->Ln(5);
        $this->SetX(56);
        $this->MultiCell(0,0, '12, Rue Pierre et Marie CURIE CS 30715',0,'L');
        $this->Ln(5);
        $this->SetX(56);
        $this->MultiCell(0,0, '13616 - Aix en Provence -  CEDEX 1',0,'L');
        //Recipient Red Part
        $this->Ln(36.5);
        $this->SetX(56);
        $this->MultiCell(70,4,$recipient,0,'L');
        $this->Ln(5);
        $this->SetX(56);
        $this->MultiCell(0,0,$recipient_comp,0,'L');
        //Adress Red Part
        $this->Ln(-2);
        $this->SetX(56);
        $this->MultiCell(70,4,$address,0,'L');
        //PC and City Red Part
        $this->Ln(4);
        $this->SetX(56);
        $this->MultiCell(0,0,$pc,0,'L');
        $this->SetX(70);
        $this->MultiCell(0,0,$city,'L');
        //FileNum Red Part
        $this->Ln(8);
        $this->SetX(56);
        $this->MultiCell(0,0,'N: ' . $fileNum,0,'L');
        //Type Red Part
        if ($type == 'Arrete'){
            $this->Ln(-1);
            $this->SetX(96);
            $this->MultiCell(0, 0, $type  . ' ' . $idarret, 0, 'L');
            $this->SetFont('Arial', 'B', 10);
            $this->Ln(-2);
            $this->SetX(119);
            $this->MultiCell(0,2,'(Inst: '.$instruct.')',0,'L');
        }
        else {
            $this->Ln(-2);
            $this->SetX(89);
            $this->SetFont('Arial', '', 10);
            $this->MultiCell(60, 4, $type, 0, 'L');
            $this->SetFont('Arial', 'B', 10);
            $this->Ln(-6);
            $this->SetX(119);
            $this->MultiCell(0,2,'(Inst: '.$instruct.')',0,'L');
        }
        //Shipping Red Part
        $this->SetFont('Arial','B',10);
        $this->Ln(4);
        $this->SetXY(56,264);
        $this->MultiCell(0,0, 'VILLE D\'AIX EN PROVENCE' ,0,'L');
        $this->Ln(5);
        $this->SetX(56);
        $this->MultiCell(0,0, 'DIRECTION DE L\'URBANISME ( A.D.S. )',0,'L');
        $this->Ln(4);
        $this->SetX(56);
        $this->MultiCell(0,0, '12, Rue Pierre et Marie CURIE CS 30715',0,'L');
        $this->Ln(3.9);
        $this->SetX(56);
        $this->MultiCell(0,0,'13616 - Aix en Provence -  CEDEX 1', 0,'L');
    }

    function body($json) {

        foreach( $this->new2old as $key => $value ) {
            $new[] = $key;
            $old[] = $value;
        }
        $this->headerRegistered();
        $json = json_decode($json);
        $fileTypes = array();
        foreach ($json as $registered){
            if (!in_array($registered->TYPE_ENVOI, $fileTypes))array_push($fileTypes, $registered->TYPE_ENVOI);
        }

        $this->SetXY(5, 74);

        foreach ($fileTypes as $fileType) {
            $this->SetFont('Arial', 'B', 12);
            $this->SetX(5);
            $this->Cell(201, 4, $fileType, 0, 0, 'L');
            $this->SetXY(5, $this->GetY() + 5);
            $this->Cell(201, 1, '', 'T', 0, 'C');
            foreach ($json as $registered){
                if ($registered->TYPE_ENVOI == $fileType) {
                    $this->fillBody(str_replace($old, $new,$registered->DOSSIER), str_replace($old, $new,$registered->INSTRUCT), str_replace($old, $new,$registered->CIVILITE_DEMANDEUR) . ' '. str_replace($old, $new,$registered->DEMANDEUR), str_replace($old, $new,$registered->ADRESSE) . ' ' . str_replace($old, $new,$registered->CODE_POSTAL) . ' ' . str_replace($old, $new,$registered->VILLE), str_replace($old, $new,$registered->DATE_CREATION));
                }
            }
            $this->Ln();
        }
        $this->footerRegistered();
    }

    function fillBody($numFile, $inst, $name, $address, $date) {

        //$this->SetY($this->GetY() + 1);
        $this->Ln(1);
        $this->SetFont('Times', '', 8);
        $this->SetXY(5, $this->GetY());
        $this->MultiCell(67, 2, $numFile . '    (Inst: ' . $inst . ')', '','L');
        $this->SetXY(72, $this->GetY() - 2);
        $this->MultiCell(67, 2, $name, '','C');
        $this->SetXY(139, $this->GetY() - 2);
        $this->MultiCell(67, 2, $date, '', 'R');
        $this->SetXY(5, $this->GetY() + 3);
        $this->MultiCell(201, 4,$address, 'B', 'C');
    }

    function footerRegistered() {

        $this->SetY(-30.01);
        $this->SetFont('Arial','B',8);
        $date = date('d/m/Y');
        $this->SetX(30);
        $this->Cell(-10,10, $date,0,0,'C');
        $this->SetX(0);
        $this->Cell(370,10,'Page '.$this->PageNo().' sur {nb}',0,0,'C');
    }
}

if (isset($_POST['function'])) {

    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage('P','A4',0);

    $function = $_POST['function'];
    $params = $_POST['params'];

    $calledFunction = ' $pdf->' . $_POST['function'] . '(';
    foreach ($params as $param => $value) {
        $calledFunction .= $value . ', ';
    }
    $calledFunction = substr($calledFunction,0,-2);
    $calledFunction .= ');';

    eval($calledFunction);

    $pdfString = $pdf->Output('', 'S');
    $pdfBase64 = base64_encode($pdfString);
    echo 'data:application/pdf;base64,' . $pdfBase64;
}
