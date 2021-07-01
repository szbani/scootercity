<?php

  $target_dir = "../sec_images/";
  $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
  } else {
    array_push($errors, "A kiválasztott fájl nem egy kép");
  }


// Check if file already exists
if (file_exists($target_file)) {
  array_push($errors, "Már létezik egy ilyen nevű fájl.");
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 5000000) {
  array_push($errors, "Túl nagy a fájl.");
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
  echo "Sorry, only JPG, JPEG & PNG  files are allowed.";
  array_push($errors, "A fájl nem JPG, JPEG vagy PNG típusú.");
}

// Check if $uploadOk is set to 0 by an error
if (count($errors) != 0) {
  array_push($errors, "Nem lett feltöltve a képed!");
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
  } else {
    array_push($errors, "Hiba történt a fájl feltöltésekor!");
  }
}



?>