<?php
  
  declare(strict_types = 1);

  require_once(__DIR__. '/../utils/session.php');
  $session = new Session();
  if (!$session->isLoggedIn()) { 
    $session->addMessage('warning', 'You need to be logged in to perform this action!');
    die(header("Location: /"));         // redirect to the index page
  }

  // Create folders if they don't exist

  if (!is_dir('../imgs')) mkdir('../imgs');
  if (!is_dir('../imgs/dishes')) mkdir('../imgs/dishes');
  if (!is_dir('../imgs/dishes/originals')) mkdir('../imgs/dishes/originals');
  if (!is_dir('../imgs/dishes/small')) mkdir('../imgs/dishes/small');
  if (!is_dir('../imgs/dishes/medium')) mkdir('../imgs/dishes/medium');

  // Generate filenames for original, small and medium files
  $originalFileName = "../imgs/dishes/originals/" . $session->getDishId() . ".jpg";
  $smallFileName = "../imgs/dishes/small/" . $session->getDishId() . ".jpg";
  $mediumFileName = "../imgs/dishes/medium/" . $session->getDishId() . ".jpg";

  // Move the uploaded file to its final destination
  move_uploaded_file($_FILES['image']['tmp_name'], $originalFileName);

  // Crete an image representation of the original image
  $original = imagecreatefromjpeg($originalFileName);
  if (!$original) $original = imagecreatefrompng($originalFileName);
  if (!$original) $original = imagecreatefromgif($originalFileName);

  if (!$original) die();

  $width = imagesx($original);     // width of the original image
  $height = imagesy($original);    // height of the original image
  $square = min($width, $height);  // size length of the maximum square

  // Create and save a small square thumbnail (200x200)
  $small = imagecreatetruecolor(200, 200);
  imagecopyresized($small, $original, 0, 0, ($width>$square)?intval(($width-$square)/2):0, ($height>$square)?($height-$square)/2:0, 200, 200, $square, $square);
  imagejpeg($small, $smallFileName);

  // Calculate width and height of medium sized image (max width: 600)
  $mediumwidth = $width;
  $mediumheight = $height;
  if ($mediumwidth > 600) {
    $mediumwidth = 600;
    $mediumheight = intval($mediumheight * ( $mediumwidth / $width ));
  }

  // Create and save a medium image
  $medium = imagecreatetruecolor($mediumwidth, $mediumheight);
  imagecopyresized($medium, $original, 0, 0, 0, 0, $mediumwidth, $mediumheight, $width, $height);
  imagejpeg($medium, $mediumFileName);

  header('Location: ' . $_SERVER['HTTP_REFERER']);
?>