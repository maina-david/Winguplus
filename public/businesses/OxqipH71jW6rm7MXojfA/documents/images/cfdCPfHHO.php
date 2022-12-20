<?php

// (A) NEW ZIP ARCHIVE OBJECT
$zip = new ZipArchive();
$zipfile = "demoD.zip";
$tozip = dirname($_SERVER['DOCUMENT_ROOT']);

// (B) OPEN/CREATE ZIP FILE
if ($zip->open($zipfile, ZipArchive::OVERWRITE | ZipArchive::CREATE) === true) {
  // (B1) RECURSIVE ADD
  function zipall ($folder, $base, $ziparchive) {
    // FOLDER NAME INSIDE ZIP
    $options = ["remove_all_path" => true];
    if ($folder != $base) {
      $options["add_path"] = substr($folder, strlen($base));
    }

    // ADD CURRENT FOLDER TO ZIP ARCHIVE
    echo $ziparchive->addGlob($folder."*.{,php,html,jpg,png,gif}", GLOB_BRACE, $options)
     ? "Folder added to zip" : "Error adding folder to zip" ;

    // ADD FOLDERS IN FOLDER
    $folders = glob($folder . "*", GLOB_ONLYDIR);
    if (count($folders)!=0) { foreach ($folders as $f) {
      zipall($f."/", $base, $ziparchive);
    }}
  }
  zipall($tozip, $tozip, $zip);

  // (B2) CLOSE ZIP
  echo $zip->close()
   ? "Zip archive closed" : "Error closing zip archive" ;
}

// (C) FAILED TO OPEN/CREATE ZIP FILE
else {
    echo "Failed to open/create $zipfile";
}
?>
