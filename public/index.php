<?php require_once("conexao.php"); ?> 


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guia de Remessa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    
    
    <div class="container">
        <h2>Formulário para Guia de Remessa</h2>
    <form action="index.php" method="POST" enctype="multipart/form-data">
    <div class="row g-3">
            <div class="col-6">
                <label for="local_para" class="form-label">Local</label>
                <input placeholder="E.M. Escola Fictícia " type="text" class="form-control" name="local_para" id="local_para" required>
            </div>
            <div class="col-6">
                <label for="destinatario" class="form-label">Destinatário</label>
                <input placeholder="Direção" type="text" class="form-control" name="destinatario" id="destinatario" required>
            </div>
            <div class="col-12">
                <label for="documento" class="form-label">Documento</label>
                <textarea placeholder="Insira documentos aqui" class="form-control" name="documento" id="documento" rows="4" required></textarea>
            </div>
            <div class="col-6">
                <label for="emissor" class="form-label">Emitido por</label>
                <input placeholder="Insira nome aqui" type="text" class="form-control" name="emissor" id="emissor" required>
            </div>
            <div class="col-12">
                <button name="enviar" type="submit" class="btn btn-primary">Enviar</button>
            </div>
        </div>
    </div>

    <?php
        if(isset($_POST['enviar'])){
            $local_para = $_POST['local_para'];
            $documento = $_POST['documento'];
            $destinatario = $_POST['destinatario'];
            $emissor = $_POST['emissor'];
            $data_emissao = date("Y-m-d");
        }
    ?>

        <div class="container">
            <hr>
            <h3>Remessas Antigas</h3>

            <?php
            
            $mysqli = new mysqli(HOST, USUARIO, SENHA, BANCO);

            
            $resultado = $mysqli->query("SELECT codigo, local_para, data_emissao FROM remessa ORDER BY codigo DESC");

            if ($resultado->num_rows > 0) {
                echo "<ul>";
                while ($remessa = $resultado->fetch_assoc()) {
                    echo "<li>";
                    echo "<a href='gerar_pdf.php?id=" . $remessa['codigo'] . "' target='_blank'>";
                    echo "Guia nº " . $remessa['codigo'] . " - " . htmlspecialchars($remessa['local_para']) . " (" . htmlspecialchars($remessa['data_emissao']) . ")";  
                    echo "</a>";
                    echo "</li>";
                }
                echo "</ul>";
            } else {
                echo "<div class='alert alert-warning' role='alert'> Nenhuma remessa encontrada! </div>";
            }
?>
        </div>
</body>
</html>

