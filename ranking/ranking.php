<?php
$pageTitle = 'Ranking de Simulados';
include_once($_SERVER['DOCUMENT_ROOT'] . '/Vestibulhama-Front/includes/head.php');
echo "<link rel=\"stylesheet\" href=\"/Vestibulhama-Front/ranking/ranking.css\">";
include_once($_SERVER['DOCUMENT_ROOT'] . '/Vestibulhama-Front/navbar/navbar.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/Vestibulhama-Front/BD/conexao.php');

$query = "SELECT r.nome_usuario, v.nome AS vestibular, r.ano, r.acertos, r.total_questoes, r.data_registro 
          FROM ranking r
          JOIN vestibular v ON r.vestibular_id = v.id
          ORDER BY r.acertos DESC, r.data_registro ASC
          LIMIT 20";

$result = mysqli_query($conexao, $query);

echo "<h2>Ranking de Simulados</h2>";
echo "<table>";
echo "<tr style='background-color:#2e2e2e;'><th style='padding:10px;'>Usuário</th><th>Vestibular</th><th>Ano</th><th>Acertos</th><th>Total</th><th>Data</th></tr>";

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr style='text-align:center;'>";
    echo "<td>" . htmlspecialchars($row['nome_usuario']) . "</td>";
    echo "<td>" . htmlspecialchars($row['vestibular']) . "</td>";
    echo "<td>" . $row['ano'] . "</td>";
    echo "<td>" . $row['acertos'] . "</td>";
    echo "<td>" . $row['total_questoes'] . "</td>";
    echo "<td>" . date('d/m/Y H:i', strtotime($row['data_registro'])) . "</td>";
    echo "</tr>";
}
echo "</table>";
echo "</div>"; /* close table-wrapper */
echo "</div>"; /* close pai */
mysqli_close($conexao);
include_once('../footer/footer.html');
?>
</body>
</html>

