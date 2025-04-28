<?php
    require_once("conexao.php");
    require_once("../fpdf/fpdf.php");

    
    $mysqli = new mysqli(HOST, USUARIO, SENHA, BANCO);

    if (isset($_GET['id'])) {
        $id = (int) $_GET['id'];
    
        $stmt = $mysqli->prepare("SELECT * FROM remessa WHERE codigo = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $resultado = $stmt->get_result();
    
        if ($resultado->num_rows > 0) {
            $remessa = $resultado->fetch_assoc();
    
            $codigo_remessa = $remessa['codigo'];
            $local_para = $remessa['local_para'];
            $documento = $remessa['documento'];
            $destinatario = $remessa['destinatario'];
            $emissor = $remessa['emissor'];
            $data_emissao = $remessa['data_emissao'];
    
            // Gerar o PDF
            $pdf = new FPDF();
            $pdf->AddPage();
            $pdf->SetFont('Arial', '', 12);
    
            $pdf->Cell(0, 10, utf8_decode("Guia de Remessa Nº $codigo_remessa"), 0, 1, 'C');
            $pdf->Ln(5);
    
            $pdf->MultiCell(0, 10, utf8_decode("Documento: $documento"), 0, 1);
            $pdf->Cell(0, 10, utf8_decode("Para: $local_para"), 0, 1);
            $pdf->Cell(0, 10, utf8_decode("Destinatário: $destinatario"), 0, 1);
            $pdf->Cell(0, 10, utf8_decode("Emissor: $emissor"), 0, 1);
            $pdf->Cell(0, 10, utf8_decode("Data de Emissão: " . date('d/m/Y', strtotime($data_emissao))), 0, 1);
    
            $pdf->Output('I', "guia_de_remessa_$codigo_remessa.pdf");
            exit;  
        }
    }
?>