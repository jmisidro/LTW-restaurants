<?php
  
  declare(strict_types = 1);

  require_once(__DIR__. '/../utils/session.php');
  $session = new Session();
  if (!$session->isLoggedIn()) { 
    $session->addMessage('warning', 'You need to be logged in to perform this action!');
    die(header("Location: /"));         // redirect to the index page
  }

  // Create folders if they don't exist

  if ($session->getUsertype() == 0) {

    if (!is_dir('../imgs')) mkdir('../imgs');
    if (!is_dir('../imgs/profile/users/originals')) mkdir('../imgs/profile/users/originals');
    if (!is_dir('../imgs/profile/users/small')) mkdir('../imgs/profile/users/small');
    if (!is_dir('../imgs/profile/users/medium')) mkdir('../imgs/profile/users/medium');

    // Generate filenames for original, small and medium files
    $originalFileName = "../imgs/profile/users/originals/" . $session->getId() . ".jpg";
    $smallFileName = "../imgs/profile/users/small/" . $session->getId() . ".jpg";
    $mediumFileName = "../imgs/profile/users/medium/" . $session->getId() . ".jpg";
  }
  else if ($session->getUsertype() == 1) {

    if (!is_dir('../imgs')) mkdir('../imgs');
    if (!is_dir('../imgs/profile/owners/originals')) mkdir('imgs/profile/owners/originals');
    if (!is_dir('../imgs/profile/owners/small')) mkdir('imgs/profile/owners/small');
    if (!is_dir('../imgs/profile/owners/medium')) mkdir('imgs/profile/owners/medium');

    // Generate filenames for original, small and medium files
    $originalFileName = "../imgs/profile/owners/originals/" . $session->getId() . ".jpg";
    $smallFileName = "../imgs/profile/owners/small/" . $session->getId() . ".jpg";
    $mediumFileName = "../imgs/profile/owners/medium/" . $session->getId() . ".jpg";
  }

  // Move the uploaded file to its final destination
  if ($_FILES['cover_image']['size'] == 0 && $_FILES['cover_image']['error'] == 0)
{
/*     $session->addMessage("warning","Image not selected!");
    header('Location: ' . $_SERVER['HTTP_REFERER']); */
}
  move_uploaded_file($_FILES['image']['tmp_name'], $originalFileName);

  // Create an image representation of the original image
  $original = imagecreatefromjpeg($originalFileName);
  if (!$original) $original = imagecreatefrompng($originalFileName);
  if (!$original) $original = imagecreatefromgif($originalFileName);

  if (!$original) die();

  $width = imagesx($original);     // width of the original image
  $height = imagesy($original);    // height of the original image
  $square = min($width, $height);  // size length of the maximum square

  // Create and save a small square thumbnail (100x100) -> Small Icon Picture
  $small = imagecreatetruecolor(100, 100);
  imagecopyresized($small, $original, 0, 0, ($width>$square)?($width-$square)/2:0, intval(($height>$square)?($height-$square)/2:0), 100, 100, $square, $square);
  imagejpeg($small, $smallFileName);

  // Create and save a medium square thumbnail (300x300) -> Profile Picture
  $medium = imagecreatetruecolor(300, 300);
  imagecopyresized($medium, $original, 0, 0, ($width>$square)?($width-$square)/2:0, intval(($height>$square)?($height-$square)/2:0), 300, 300, $square, $square);
  imagejpeg($medium, $mediumFileName);

  header('Location: ' . $_SERVER['HTTP_REFERER']);
?>