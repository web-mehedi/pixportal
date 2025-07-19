<?php
$target_dir = "uploads/";
if (!is_dir($target_dir)) {
  mkdir($target_dir, 0755, true);
}

$msgs = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['photos'])) {
  $allowed = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];
  $files = $_FILES['photos'];

  for ($i = 0; $i < count($files['name']); $i++) {
    if ($files['error'][$i] === 0) {
      $filename = time() . "-" . rand(1000, 9999) . "-" . basename($files['name'][$i]);
      $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

      if (!in_array($ext, $allowed)) {
        $msgs[] = "❌ Invalid file: {$files['name'][$i]}";
        continue;
      }

      $target_file = $target_dir . $filename;
      if (move_uploaded_file($files['tmp_name'][$i], $target_file)) {
        $msgs[] = "✅ Uploaded: {$files['name'][$i]}";
      } else {
        $msgs[] = "❌ Failed: {$files['name'][$i]}";
      }
    } else {
      $msgs[] = "❌ Error uploading: {$files['name'][$i]}";
    }
  }

  $msg = urlencode(implode("\\n", $msgs));
  header("Location: index.html?msg=$msg");
  exit;
}

header("Location: index.html?msg=❌ No files uploaded.");
exit;
?>