<?php

require 'fpdf.php';

class PDF extends FPDF {

    function header() {

        $this->SetXY(17, 15);
        $this->Image('img/logoMairie.png', $this->GetX(), $this->GetY(), 14 , 24);
        $this->SetXY(182, 15);
        $this->Image('img/logoMairie.png', $this->GetX(), $this->GetY(), 14 , 24);

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

    function bodyRegistered($recipient,$recipient_comp,$address,$pc,$city,$filenum,$type,$instruct,$shipping_1,$shipping_2,$shipping_3,$shipping_4){
        //Cross R1 Yellow Part
        $this->SetY(27);
        $this->SetX(88);
        $this->SetFont('Arial','B',12);
        $this->Cell(0,8,'X',0,0,'L');
        $this->Ln();
        //Cross Lettre Yellow Part
        $this->SetX(88);
        $this->Cell(0,4,'X',0,0,'L');
        $this->Ln();
        //Line Recipient Yellow and White part
        $this->SetX(36);
        $this->Cell(0,8,$recipient,0,0,'L');
        $this->SetX(122);
        $this->Cell(0,7,$recipient,0,0,'L');
        $this->Ln();
        //Line Recipient_Comp Yellow and White part
        $this->SetX(36);
        $this->Cell(0,3,$recipient_comp,0,0,'L');
        $this->SetX(122);
        $this->Cell(0,3,$recipient_comp,0,0,'L');
        $this->Ln();
        //Line Address Yellow and White part
        $this->SetX(36);
        $this->Cell(0,8,$address,0,0,'L');
        $this->SetX(122);
        $this->Cell(0,8,$address,0,0,'L');
        $this->Ln();
        //Line CP andYellow and White part
        $this->SetX(36);
        $this->Cell(0,12,$pc,0,0,'L');
        $this->SetX(51);
        $this->Cell(0,12,$city,0,0,'L');
        $this->SetX(122);
        $this->Cell(0,10,$pc,0,0,'L');
        $this->SetX(137);
        $this->Cell(0,10,$city,0,0,'L');
        $this->Ln();
        //Line FileNum and Type Yellow and White part
        $this->SetX(36);
        $this->Cell(0,2,$filenum,0,0,'L');
        $this->SetX(69);
        $this->Cell(0,2,$type,0,0,'L');
        $this->SetX(122);
        $this->Cell(0,0,$filenum,0,0,'L');
        $this->SetX(155);
        $this->Cell(0,0,$type,0,0,'L');
        //Cross Grey Part
        $this->SetXY(101,130);
        $this->Cell(0,8,'X',0,0,'L');
        $this->Ln();
        $this->SetX(101);
        $this->Cell(0,3,'X',0,0,'L');
        $this->Ln();
        //Destinataire Grey Part
        $this->SetX(55);
        $this->Cell(0,8,$recipient,0,0,'L');
        $this->Ln();
        //Line Recipient_Comp Grey part
        $this->SetX(55);
        $this->Cell(0,3,$recipient_comp,0,0,'L');
        $this->Ln();
        //Line Address Grey Part
        $this->SetX(55);
        $this->Cell(0,6,$address,0,0,'L');
        $this->Ln(12);
        //Line CP and City Grey part
        $this->SetX(55);
        $this->Cell(0,2,$pc,0,0,'L');
        $this->SetX(70);
        $this->Cell(0,2,$city,0,0,'L');
        $this->Ln();
        //FileNum and Type Grey Part
        $this->SetX(54);
        $this->Cell(0,6,$filenum,0,0,'L');
        $this->SetX(88);
        $this->Cell(0,6,$type,0,0,'L');
        $this->Ln(13);
        //shipping agent Grey Part
        $this->SetX(56);
        $this->SetFont('Arial','',12);
        $this->Cell(0,0,$shipping_1,0,0,'L');
        $this->Ln(5);
        $this->SetX(56);
        $this->Cell(0,0,$shipping_2,0,0,'L');
        $this->Ln(5);
        $this->SetX(56);
        $this->Cell(0,0,$shipping_3,0,0,'L');
        $this->Ln(5);
        $this->SetX(56);
        $this->Cell(0,0,$shipping_4,0,0,'L');
        $this->Ln(40);
        //Recipient Red Part
        $this->SetX(56);
        $this->Cell(0,0,$recipient,0,0,'L');
        $this->Ln(5);
        $this->SetX(56);
        $this->Cell(0,0,$recipient_comp,0,0,'L');
        $this->Ln(5);
        $this->SetX(56);
        $this->Cell(0,0,$address,0,0,'L');
        $this->Ln(10);
        $this->SetX(56);
        $this->Cell(0,0,$pc,0,0,'L');
        $this->SetX(86);
        $this->Cell(0,0,$city,'L');
        $this->Ln(4);
        $this->SetX(56);
        $this->Cell(0,0,$filenum,0,0,'L');
        $this->SetX(91);
        $this->Cell(0,0,$type,0,0,'L');
        $this->SetX(121);
        $this->Cell(0,0,$instruct,0,0,'L');
        $this->Ln(5);
        $this->SetX(56);
        //Shipping Red Part
        $this->SetFont('Arial','B',12);
        $this->Cell(0,0,$shipping_1,0,0,'L');
        $this->Ln(5);
        $this->SetX(56);
        $this->Cell(0,0,$shipping_2,0,0,'L');
        $this->Ln(4);
        $this->SetX(56);
        $this->Cell(0,0,$shipping_3,0,0,'L');
        $this->Ln(3.9);
        $this->SetX(56);
        $this->Cell(0,0,$shipping_4,0,0,'L');
    }

    function body($json) {

        $json = json_decode($json);
        $fileTypes = array();
        foreach ($json as $registered){
            if (!in_array($registered->TYPE_ENVOI, $fileTypes))array_push($fileTypes, $registered->TYPE_ENVOI);
        }

        $this->SetXY(5, 74);

        foreach ($fileTypes as $fileType) {
            $this->SetFont('Arial', 'B', 12);
            $this->Cell(201, 4, $fileType, 0, 0, 'L');
            $this->SetXY(5, $this->GetY() + 4);
            $this->Cell(201, 1, '', 'T', 0, 'C');
            foreach ($json as $registered){
                if ($registered->TYPE_ENVOI == $fileType) {
                    $this->fillBody($registered->DOSSIER, $registered->INSTRUCT, $registered->CIVILITE_DEMANDEUR . ' '.$registered->DEMANDEUR, $registered->ADRESSE . ' ' . $registered->CODE_POSTAL . ' ' . $registered->VILLE, $registered->DATE_CREATION);
                }
                //$this->Ln();
            }
            $this->Ln();
        }
    }
    function fillBody($numFile, $inst, $name, $address, $date) {

        //$this->SetY($this->GetY() + 1);
        $this->Ln(1);
        $this->SetFont('Times', '', 8);
        $this->SetX(5);
        $this->MultiCell(67, 1, $numFile . '              (Inst: ' . $inst . ')', '','L');
        $this->SetX(72);
        $this->MultiCell(67, 2, $name, '','C');
        $this->SetX(180);
        $this->MultiCell(67, 0, $date, '', 'L');
        $this->Ln(2);
        //$this->SetY($this->GetY() + 2);
        $this->SetX(5);
        $this->MultiCell(201, 3,$address, 'B', 'C');
    }

    function footer() {

       $this->SetY(-15);
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
    //$pdf->Image('img/pdf.jpg', 0, 0, 217, 298);
    $pdf->header();

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
