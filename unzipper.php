<?php
// Bitte .zip Datei in den gleichen Ordner wie Skript hochladen
$file = './pack.zip'; //Dateiname entsprechend �ndern

$path = pathinfo(realpath($file), PATHINFO_DIRNAME);

$zip = new ZipArchive;
$res = $zip->open($file);
if ($res === TRUE) {
  $zip->extractTo($path);
  $zip->close();
  echo "Success! $file has been extracted to $path.";
} else {
  echo "Nie znaleziono pliku $file.";
}
?>
