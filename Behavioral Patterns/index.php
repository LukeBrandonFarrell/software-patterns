<?php
  // Gets all the files in directory to create a clickable list.
  foreach (glob("*") as $filename) {
      echo '<a style="display:block;" href=' . basename($filename) . '>' . $filename . ' ' . filesize($filename) . "-bytes </a><br>";
  }
?>
