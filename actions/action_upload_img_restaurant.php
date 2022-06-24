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
  if (!is_dir('../imgs/restaurants')) mkdir('../imgs/restaurants');
  if (!is_dir('../imgs/restaurants/originals')) mkdir('../imgs/restaurants/originals');
  if (!is_dir('../imgs/restaurants/small')) mkdir('../imgs/restaurants/small');
  if (!is_dir('../imgs/restaurants/medium')) mkdir('../imgs/restaurants/medium');

  // Generate filenames for original, small and medium files
  $originalFileName = "../imgs/restaurants/originals/" . $session->getRestaurantId() . ".jpg";
  $smallFileName = "../imgs/restaurants/small/" . $session->getRestaurantId() . ".jpg";
  $mediumFileName = "../imgs/restaurants/medium/" . $session->getRestaurantId() . ".jpg";

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

  // Create and save a small square thumbnail (300x300)
  $small = imagecreatetruecolor(300, 300);
  imagecopyresized($small, $original, 0, 0, ($width>$square)?intval(($width-$square)/2):0, ($height>$square)?($height-$square)/2:0, 300, 300, $square, $square);
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