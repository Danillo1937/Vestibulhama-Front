<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="/Vestibulhama/Src/cadastroQuestao/cadastroQuestao.css">
</head>
<body>
<?php
     include_once('../navbar/navbar.html');
      include_once('../BD/conexao.php');
     ?>
  <h1>Adicionar Nova <span>Questão</span></h1>

  <form method="post" action="cadastrarQuestao.php">
    <label for="Vestibular">Vestibular</label>
    <select name="vestibular" id="vestibular">
      <?php
      selectValues('vestibular', 'vest', $conexao);
      ?>
    </select>

    <label for="materia">Matéria</label>
    <select name="materia" id="materia">
      <?php
       selectValues('materia', 'mat', $conexao);
      ?>
      </select>

    <label for="enunciado">Enunciado da Questão</label>
    <input type="text" id="enunciado" name="enunciado">

    <label for="foto">Foto Complementar da Questão</label>
    <input type="file" id="foto" name="foto" accept="image/*">

    <label for="correta">Alternativa Correta (A, B, C, D, E)</label>
    <input type="text" id="correta" name="correta">

    <label for="altB">Alternativa 1</label>
    <input type="text" id="alt1" name="alt1">

    <label for="altC">Alternativa 2</label>
    <input type="text" id="alt2" name="alt2">

    <label for="altD">Alternativa 3</label>
    <input type="text" id="alt3" name="alt3">

    <label for="altE">Alternativa 4</label>
    <input type="text" id="alt4" name="alt4">

    <label for="ano">Ano da Prova</label>
    <select id="ano" name="ano">
      <option value="2024">2024</option>
      <option value="2023">2023</option>
      <option value="2022">2022</option>
    </select>

    <div class="buttons">
      <button type="submit"  class="btn">Adicionar Prova</button>
      <button type="submit" href = "../cadastroQuestao/cadastroQuestao.php" class="btn btn-alt">Adicionar Mais</button>
    </div>
  </form>


  <?php
  include_once('../footer/footer.html');
  function selectValues($table, $blabla, $conexao) 
  {
      $sql = "select * from $table order by nome";
    $resultado = mysqli_query($conexao, $sql);
    if(mysqli_num_rows($resultado) > 0) {
        while($blabla = mysqli_fetch_assoc($resultado)) {
            echo "<option value='{$blabla['id']}'>{$blabla['nome']}</option>";
        }
    } else {
        echo "<option value=''>Nenhum vestibular encontrado</option>";
    }
  }
  
  ?>
</body>

</html>