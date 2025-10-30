<?php
$pageTitle = 'Prova Montada';
session_start();
include_once($_SERVER['DOCUMENT_ROOT'] . '/Vestibulhama-Front/includes/head.php');
echo "<link rel=\"stylesheet\" href=\"/Vestibulhama-Front/VestibularesSelecao/vestibulaMontado.css\">";
include_once($_SERVER['DOCUMENT_ROOT'] . '/Vestibulhama-Front/navbar/navbar.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/Vestibulhama-Front/BD/conexao.php');

// Recupera filtros da sessão
$vestibulares = $_SESSION['vestibulares'] ?? [];
$anos = $_SESSION['anos'] ?? [];
$materias = $_SESSION['materias'] ?? [];

if (empty($vestibulares) || empty($anos) || empty($materias)) {
    echo "<p style='color:red; text-align:center;'>Você precisa selecionar vestibulares, anos e matérias antes de montar a prova.</p>";
    exit;
}

// Monta strings para o SQL
$vestStr = implode(',', array_map('intval', $vestibulares));
$anoStr = implode(',', array_map('intval', $anos));
$matStr = implode(',', array_map('intval', $materias));

// Busca questões filtradas
$query = "SELECT q.id, q.enunciado, q.foto, q.a, q.b, q.c, q.d, q.e, q.alt_correta,
                 v.nome AS vestibular, m.nome AS materia, q.ano
          FROM questao q
          JOIN vestibular v ON q.id_vestibular = v.id
          JOIN materia m ON q.id_materia = m.id
          WHERE q.id_vestibular IN ($vestStr)
          AND q.ano IN ($anoStr)
          AND q.id_materia IN ($matStr)
          ORDER BY RAND()";

$result = mysqli_query($conexao, $query);

// Se não houver questões
if (mysqli_num_rows($result) === 0) {
    echo "<p style='color:yellow; text-align:center;'>Nenhuma questão encontrada para os filtros escolhidos.</p>";
    exit;
}

// Se o usuário enviou respostas
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['resposta'])) {
    $respostas = $_POST['resposta'];
    $acertos = 0;
    $total = count($respostas);

    foreach ($respostas as $idQuestao => $resposta) {
        $sql = "SELECT alt_correta FROM questao WHERE id = ?";
        $stmt = mysqli_prepare($conexao, $sql);
        mysqli_stmt_bind_param($stmt, "i", $idQuestao);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        if ($row = mysqli_fetch_assoc($res)) {
            if (strtoupper($resposta) === strtoupper($row['alt_correta'])) {
                $acertos++;
            }
        }
    }

    echo "<div style='text-align:center; color:white; margin-top:20px;'>";
    echo "<h2>Resultado</h2>";
    echo "<p>Você acertou <span style='color:lime;'>$acertos</span> de $total questões.</p>";
    echo "</div>";

    include_once($_SERVER['DOCUMENT_ROOT'] . '/Vestibulhama-Front/footer/footer.html');
    exit;
}

// Exibe as questões
echo "<h2 style='text-align:center; color:white;'>Prova Personalizada</h2>";
echo "<form method='post'>";
echo "<div class='questoes-container'>";

while ($q = mysqli_fetch_assoc($result)) {
    echo "<div class='questao' style='font-size:20px; margin-bottom:20px; color:white;'>";
    echo "<p class = 'pergunta'>{$q['vestibular']} {$q['ano']} - {$q['materia']}</p>";
    echo "<p class = 'pergunta'>{$q['enunciado']}</p>";

    if (empty($q['foto'])) {
        echo "foto";
    }else{
        echo "<img src='../images_U/{$q['foto']}' alt='Questão sem imagem' style='max-width:300px;'><br>";
    }

    foreach (['a','b','c','d','e'] as $i => $alt) {
        $letra = chr(65 + $i);
        echo "<label style='display:block; margin:5px;'>";
        echo "<input type='radio' name='resposta[{$q['id']}]' value='$letra'> $letra) {$q[$alt]}";
        echo "</label>";
    }

    echo "</div><hr>";
}

echo "<div style='text-align:center; margin-top:20px;'>";
echo "<button type='submit' class='botao'>Enviar Respostas</button>";
echo "</div>";

echo "</div>";
echo "</form>";

include_once($_SERVER['DOCUMENT_ROOT'] . '/Vestibulhama-Front/footer/footer.html');
mysqli_close($conexao);
?>
</body>
</html>