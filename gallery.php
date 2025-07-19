<?php
$files = [];
$dir = "uploads/";

if (is_dir($dir)) {
  $all = scandir($dir);
  foreach ($all as $file) {
    if (!in_array($file, ['.', '..']) && preg_match('/\\.(jpg|jpeg|png|gif|bmp|webp)$/i', $file)) {
      $files[] = $file;
    }
  }
}

header('Content-Type: application/json');
echo json_encode($files);
?>