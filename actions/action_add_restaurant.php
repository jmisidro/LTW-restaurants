<?php
  
  declare(strict_types = 1);

  require_once(__DIR__. '/../utils/session.php');
  $session = new Session();
  if (!$session->isLoggedIn()) { 
    $session->addMessage('warning', 'You need to be logged in to perform this action!');
    die(header("Location: /"));         // redirect to the index page
  }

  require_once(__DIR__. '/../database/connection.db.php');
  require_once(__DIR__. '/../database/restaurant.class.php');
  
  $db = getDatabaseConnection();
  $restaurant = new Restaurant(NULL, $_POST['name'], $session->getId(), $_POST['address'], $_POST['category'], NULL);
  $newid = $restaurant->add($db);
  $session->setRestaurantId($newid);
  $session->addMessage('info', 'Restaurant added. Please upload a photo for your restaurant.');
  header('Location: ' . $_SERVER['HTTP_REFERER']);
?>