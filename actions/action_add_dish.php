<?php
  
  declare(strict_types = 1);

  require_once(__DIR__. '/../utils/session.php');
  $session = new Session();
  if (!$session->isLoggedIn()) { 
    $session->addMessage('warning', 'You need to be logged in to perform this action!');
    die(header("Location: /"));         // redirect to the index page
  }

  require_once(__DIR__. '/../database/connection.db.php');
  require_once(__DIR__. '/../database/dish.class.php');
  
  $db = getDatabaseConnection();
  $newdish = new Dish(NULL,$session->getRestaurantId(), $_POST['name'], $_POST['description'], floatval($_POST['price']), $_POST['category']);
  $newid = $newdish->add($db);
  $session->setDishId($newid);
  $session->addMessage('info', 'Dish added. Please upload a photo for your dish.');
  header('Location: ' . $_SERVER['HTTP_REFERER']);
?>