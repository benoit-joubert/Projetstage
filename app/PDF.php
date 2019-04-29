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
                $this->Ln();
            }
            $this->Ln();
        }
    }
    function fillBody($numFile, $inst, $name, $address, $date) {

        $this->SetY($this->GetY() + 2);
        $this->SetFont('Times', '', 8);
        $this->SetXY(5, $this->GetY());
        $this->MultiCell(67, 2, $numFile . '    (Inst: ' . $inst . ')', '','L');
        $this->SetXY(72, $this->GetY());
        $this->MultiCell(67, 2, $name, '','C');
        $this->SetXY(139, $this->GetY());
        $this->MultiCell(67, 2, $date, '', 'R');
        $this->SetY($this->GetY() + 2);
        $this->SetXY(5, $this->GetY());
        $this->MultiCell(210, 2,$address, 'B', 'R');
    }

    function footer() {

       /* $this->SetY(-15);
        $this->SetFont('Arial','B',8);
        $date = date('d/m/Y');
        $this->SetX(30);
        $this->Cell(-10,10, $date,0,0,'C');
        $this->SetX(0);
        $this->Cell(370,10,'Page '.$this->PageNo().' sur {nb}',0,0,'C');*/
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
