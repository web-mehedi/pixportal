<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $filename = basename($_POST['filename']);
  $file = __DIR__ . "/uploads/" . $filename;

  if (file_exists($file)) {
    unlink($file);
    echo "✅ Image deleted.";
  } else {
    echo "❌ File not found.";
  }
} else {
  echo "❌ Invalid request.";
}
?><?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $filename = basename($_POST['filename']);
  $file = __DIR__ . "/uploads/" . $filename;

  if (file_exists($file)) {
    unlink($file);
    echo "✅ Image deleted.";
  } else {
    echo "❌ File not found.";
  }
} else {
  echo "❌ Invalid request.";
}
?>