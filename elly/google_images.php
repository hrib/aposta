<?php
session_start();

$imgurl = 'https://www.google.co.uk/search?q=php+google+images+search&newwindow=1&safe=off&biw=1366&bih=626&source=lnms&tbm=isch&tbs=qdr:y&sa=X&ved=0ahUKEwj95uHemqjMAhXHI8AKHVx2CwE4ChD8BQgHKAE';
file_put_contents("image.jpg", file_get_contents($imgurl));
echo "<img src='image.jpg'>";

?>
