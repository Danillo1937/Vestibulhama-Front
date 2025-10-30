<?php
$pageTitle = 'Vestibulares';
include_once($_SERVER['DOCUMENT_ROOT'] . '/Vestibulhama-Front/includes/head.php');
echo "<link rel=\"stylesheet\" href=\"/Vestibulhama-Front/Vestibulares/vestibulares.css\">";
include_once($_SERVER['DOCUMENT_ROOT'] . '/Vestibulhama-Front/navbar/navbar.php');

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

include_once($_SERVER['DOCUMENT_ROOT'] . '/Vestibulhama-Front/footer/footer.html');
?>
</body>
</html>