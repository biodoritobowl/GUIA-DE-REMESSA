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
        
    }

    

?>