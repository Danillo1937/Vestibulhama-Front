<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Vestibulares/vestibulares.css">
    <title>Vestibulares</title>
</head>

<body>
<?php
    
    include_once('../navbar/navbar.html');
    $setor = 0;

    if($setor == 0){
    echo '<div class="container">';
    echo '<div class="card">';
    echo '  <a href="ProvaAno.html">';
    echo '      <img src="../images/unesp.webp" alt="Vunesp">';
    echo '      <p>Vunesp</p>';
    echo '  </a>';
    echo ' </div>';
    echo '<div class="card">';
    echo '  <a href="ProvaAno.html">';
    echo '      <img src="../images/usp.png" alt="Fuvest">';
    echo '      <p>Fuvest</p>';
    echo '  </a>';
    echo ' </div>';
    echo '<div class="card">';
    echo '  <a href="ProvaAno.html"><img src="../images/enem.jpg" alt="Enem">';
    echo '      <p>Enem</p>';
    echo '  </a>';
    echo '</div>';
    echo '</div>';
   }

   if($setor == 1){
    echo ' <div class="container">';
    echo '<div class="card">';
    echo '   <a href="">';
    echo '       <img src="../images/2022.png" alt="2022">';
    echo '       <p>Questões 2022</p>';
    echo '   </a>';
    echo ' </div>';
    echo '<div class="card">';
    echo '   <a href="">';
    echo '       <img src="../images/2023.png" alt="2023">';
    echo '   <p>Questões 2023</p>';
    echo '   </a>';
    echo '</div>';
    echo '<div class="card">';
    echo '   <a href="">';
    echo '       <a href="../Html/enem.html"><img src="../images/2024.png" alt="2024"></a>';
    echo '      <p>Questões 2024</p>';
    echo '   </a>';
    echo '</div>';
    echo '</div>';
    }

    

    include_once('../footer/footer.html')
    ?>

</body>

</html>