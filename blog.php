<?php


  if (isset($_GET['id']) && trim($_GET['id'] != '')) {
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
  }
  else {
    $title = 'All Posts:';

    $handle = opendir('.'); 
    while (($filename = readdir($handle)) !== false){ 
      $file = file($filename);

      if(substr(strrchr($filename, '.'), 1) == 'txt') {
        $post[substr($filename, 0, 8)] = $file[0];
      }
    }

    krsort($post);

    $text = '';
    $previousYear = '';
    foreach ($post as $key => $value) {
      $year = substr($key, 0, 4);
      $date = substr($key, 6, 2) . ' ' . substr(date('F', mktime(0, 0, 0, substr($key, 4, 2))), 0, 3);

      if ($year != $previousYear) {
        $text .= '<br /><span class="header">' . $year . '</span><br />';
      }

      $text .= '<span class="time_link">' . $date . ':</span>&nbsp;<a href="">' . trim($value) . '</a><br />';

      $previousYear = substr($key, 0, 4);
    }
  }

  $pageHtml = file_get_contents('template.html');
  $pageHtml = str_replace('__TITLE__', $title, $pageHtml);
  $pageHtml = str_replace('__DATE__', '', $pageHtml);
  $pageHtml = str_replace('__TEXT__', $text, $pageHtml);

  echo $pageHtml;

?>

