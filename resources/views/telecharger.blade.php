<?php

//$file_url = $_SERVER['SERVER_NAME']."/public/storage/1578851489lettre-motiv2.pdf";
header('Content-Type: application/octet-stream');
header("Content-Transfer-Encoding: Binary");
header("Content-disposition: attachment; filename=\"" . basename($file_url) . "\"");
readfile($file_url);
?>
