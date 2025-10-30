<?php
$pageTitle = 'Escolha Vestibulares';
session_start();

// Se o formulário foi enviado, salva os vestibulares na sessão e redireciona
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // processar o POST antes de qualquer saída HTML
    $_SESSION['vestibulares'] = $_POST['vestibulares'] ?? [];
    header("Location: escolherAnos.php");
    exit;
}

include_once($_SERVER['DOCUMENT_ROOT'] . '/Vestibulhama-Front/includes/head.php');
echo "<link rel=\"stylesheet\" href=\"/Vestibulhama-Front/VestibularesSelecao/vestibularesEscolha.css\">";
include_once($_SERVER['DOCUMENT_ROOT'] . '/Vestibulhama-Front/navbar/navbar.php');
?>

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
?>

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