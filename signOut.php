<?php
  session_start();
  session_destroy();
  echo "Signing Out";
  header("Location: index.html");
?>
