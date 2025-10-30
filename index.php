<?php
$pageTitle = 'Vestibulhama';
include_once($_SERVER['DOCUMENT_ROOT'] . '/Vestibulhama-Front/includes/head.php');
echo "<link rel=\"stylesheet\" href=\"/Vestibulhama-Front/HomePage/homepage.css\">";
include_once($_SERVER['DOCUMENT_ROOT'] . '/Vestibulhama-Front/navbar/navbar.php');
?>
<div class="container">
    <div class="banner-principal">
        <a href="https://querobolsa.com.br/revista/turma-de-verao"><img class ="banner" src="images/img.png" alt="Estudar de Verão 2024"></a>
    </div>

    <div class="imagens-laterais">
        <a href="https://www.gov.br/mec/pt-br/assuntos/noticias/2025/marco/enem-2025-periodo-para-pedir-isencao-da-taxa-comeca-em-14-4"><img src="images/enem.webp" alt="Estudantes felizes"></a>
        <a href="https://www.estudarfora.org.br/rotina-de-estudos/"><img src="images/estudando.webp" alt="Pessoa fazendo prova"></a>
        <a href="https://vestibular2025.uneb.br/"><img src="images/vest.jpg" alt="Pessoa fazendo prova"></a>
        <a href="https://vestibular2024.uneb.br/"><img src="images/menina2.jpg" alt="Pessoa fazendo prova"></a>
    </div>
</div>
    <section class="recursos-servicos">
        <h2 id="servicos">Recursos e <span class ="span">Serviços</span></h2>
        <div class="cards">
            <div class="card">
                <a href="Vestibulares/vestibulares.php"><img src="images/pessoaescrevendo.jpg" alt="Vestibulares"></a>
                <p>Vestibulares</p>
            </div>

            <a href=""></a>
            <div class="card">
                <a href="ranking/ranking.php"><img src="images/pessoamedalha.jpg" alt="Ranking de Notas"></a>
                <p>Ranking de Notas</p>
            </div>
            <div class="card">
                <a href="VestibularesSelecao/VestibularesEscolha.php"><img src="images/assinalandoquestao.png" alt="Simulados Aleatórios"></a>
                <p>Personalizar Prova</p>
            </div>
        </div>
    </section>

     <section class="sobre-nos">
        <h2>Sobre <span class="span">Nós</span></h2>
        <div class="sobre-container">
            <img src="images/rafiki.png" alt="Pessoa curiosa">
            <p class = "pSobre">
                O VestibuLhama é um site que facilita o acesso às provas dos principais vestibulares do Brasil. Além de reunir exames anteriores, a plataforma permite que os usuários resolvam as questões diretamente no site, tornando os estudos mais práticos e interativos. Com uma interface intuitiva, o VestibuLhama é a ferramenta ideal para quem busca se preparar e alcançar a aprovação.
            </p>
        </div>
    </section>
    
    <?php
  include_once('footer/footer.html');
?>

</body>

</html>
