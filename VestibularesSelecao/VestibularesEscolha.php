<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../VestibularesSelecao/vestibularesEscolha.css">
    <title>Vestibulares</title>
</head>
<?php
session_start();
include_once('../navbar/navbar.php');

// Se o formulário foi enviado, salva os vestibulares na sessão e redireciona
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['vestibulares'] = $_POST['vestibulares'] ?? [];
    header("Location: escolherAnos.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../VestibularesSelecao/vestibularesEscolha.css">
    <title>Vestibulares</title>
</head>
<body>
    <form method="post">
        <h2 style = "text-align:center; color: white;">Escolha os vestibulares:</h2>
        <div class="container">
            <div class="card">
                <label>
                    <input type="checkbox" name="vestibulares[]" value="1">
                    <img src="../images/usp.png" alt="Fuvest">
                    <p>Fuvest</p>
                </label>
            </div>

            <div class="card">
                <label>
                    <input type="checkbox" name="vestibulares[]" value="2">
                    <img src="../images/unesp.webp" alt="Vunesp">
                    <p>Vunesp</p>
                </label>
            </div>

            <div class="card">
                <label>
                    <input type="checkbox" name="vestibulares[]" value="3">
                    <img src="../images/enem.jpg" alt="Enem">
                    <p>Enem</p>
                </label>
            </div>
        </div>

        <div style="text-align:center; margin-top:20px;">
            <button type="submit" class="botao">Próximo</button>
        </div>
    </form>

    <?php include_once('../footer/footer.html'); ?>
</body>
</html>
</body>

</html>