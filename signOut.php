<?php
  #Destroys the session when the user logs out, causing them to have to log back in again
  session_start();
  session_destroy();
  echo "Signing Out";
  header("Location: index.html");
?>
