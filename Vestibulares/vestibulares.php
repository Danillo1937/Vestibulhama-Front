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

    // Exibe os vestibulares disponíveis
    echo '<div class="container">';
     echo '<div class="card">';
      echo'<a href="anos.php?vestibular=1">';
        echo'  <img src="../images/usp.png" alt="Vunesp">';
        echo' <p>Fuvest</p>';
       echo'</a>';
     echo '</div>';
     echo '<div class="card">';
echo'<a href="anos.php?vestibular=2">';
    echo'<img src="../images/unesp.webp" alt="Fuvest">';
    echo'<p>Vunesp</p>';
    echo'</div>';
     echo '<div class="card">';
echo'</a>';
echo'<a href="anos.php?vestibular=3">';
    echo'<img src="../images/enem.jpg" alt="Enem">' ;
    echo'<p>Enem</p>';
echo'</a>';
    echo '</div>';
    echo '</div>';

    include_once('../footer/footer.html');
?>
</body>

</html>