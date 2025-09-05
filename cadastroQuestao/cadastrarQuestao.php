<?php

if(isset($_POST['vestibular']) && isset($_POST['materia']) && isset($_POST['enunciado']) && isset($_POST['correta']) 
    && isset($_POST['alt1']) && isset($_POST['alt2']) && isset($_POST['alt3']) && isset($_POST['alt4']) && isset($_POST['ano'])) {

    $faculdade = $_POST['vestibular'];
    $materia = $_POST['materia'];
    $enunciado = $_POST['enunciado'];
    $correta = $_POST['correta'];
    $alt1 = $_POST['alt1'];
    $alt2 = $_POST['alt2'];
    $alt3 = $_POST['alt3'];
    $alt4 = $_POST['alt4'];
    $alt5 = $_POST['alt5'];
    $ano = $_POST['ano'];

    if(isset($_FILES['foto']['name'])){
                //Pegando o nome temporário da foto
                $tmp_foto = $_FILES['foto']['tmp_name'];
                //Pegando o nome da foto
                $nome_foto = $_FILES['foto']['name'];
                //Pegando a extensão da foto
                $ext = strrchr($nome_foto,".");
                //Gera um nome aleatório para a imagem
                $novonome = md5(microtime()).$ext;
                //Especifica a pasta onde será salva a imagem
                $destino = "images_U/".$novonome;
                //Salva a imagem na pasta
                move_uploaded_file($tmp_foto, $destino);
                //define o nome da foto para ser inserido na tabela
                $foto = $novonome;
            }else{
                //Não foi enviada foto, assume a foto padrão
                $foto = "padrao.png";
            }
    include_once('../BD/conexao.php');   

    // Corrija os nomes das colunas conforme sua tabela
    $query = "insert into questao (id_vestibular, id_materia, enunciado, foto, alt_correta, alt1, alt2, alt3, alt4, alt5, ano) 
              values ('$faculdade', '$materia', '$enunciado', '$foto', '$correta', '$alt1', '$alt2', '$alt3', '$alt4', '$alt5', '$ano')";

    if(mysqli_query($conexao, $query)) {
        echo "Questão adicionada com sucesso!";
    } else {
        echo "Erro ao adicionar questão: " . mysqli_error($conexao);
    } 
    

    mysqli_close($conexao);
    }else {
        echo "Preencha todos os campos!";
    }




?>