<?php
    require("../fpdf/fpdf.php");

    define("HOST", value:"localhost");
    define("USUARIO", value:"root");
    define("SENHA", value:"");
    define("BANCO", "guia_de_remessa");

    $mysqli = new mysqli(HOST, USUARIO, SENHA, BANCO);

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $local_para = $_POST['local_para'];
        $documento = $_POST['documento'];
        $destinatario = $_POST['destinatario'];
        $emissor = $_POST['emissor'];
        $data_emissao = date("Y-m-d");

        $insere = $mysqli->query("INSERT INTO remessa(
            local_para,
            documento,
            destinatario,
            emissor,
            data_emissao
        )VALUES(
            '$local_para',
            '$documento',
            '$destinatario',
            '$emissor',
            '$data_emissao'
            )");

        $codigo_remessa = $mysqli->insert_id;
        //criação de pdf insana
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', '', 12);
        
        $pdf->Cell(0, 10, utf8_decode("Guia de Remessa Nº $codigo_remessa"), 0, 1, 'C');
        $pdf->Ln(5);

        $pdf->MultiCell(0, 10, utf8_decode("Documento: $documento"), 0, 1);
        $pdf->Cell(0, 10, utf8_decode("Para: $local_para"), 0, 1);
        $pdf->Cell(0, 10, utf8_decode("Destinatário: $destinatario"), 0, 1);
        $pdf->Cell(0, 10, utf8_decode("Emissor: $emissor"), 0, 1);
        $pdf->Cell(0, 10, utf8_decode("Data de Emissão: $data_emissao"), 0, 1);

        $pdf->Output('I', 'guia_de_remessa.pdf');
        exit;
    }

    

?>