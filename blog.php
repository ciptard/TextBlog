<?php

  $post = $_GET['id'];
  $file = explode("\n", file_get_contents($post . '.txt'));

  $text = '';
  for ($i = 1; $i < sizeof($file); $i++) {
    if (trim($file[$i]) != '') {
      $text .= "      <p>\n        " . $file[$i] . "\n      </p>\n";
    }
  }

  $title = $file[0];
  $date = substr($post, 4, 2) . '.' . substr($post, 6, 2) . '.' . substr($post, 0, 4);

  $pageHtml = file_get_contents('template.html');
  $pageHtml = str_replace('__TITLE__', $title, $pageHtml);
  $pageHtml = str_replace('__DATE__', $date, $pageHtml);
  $pageHtml = str_replace('__TEXT__', $text, $pageHtml);

  echo $pageHtml;

?>
