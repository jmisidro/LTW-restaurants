<?php
    require_once(__DIR__. '/../utils/session.php');
    $session = new Session();                                      // starts the session
  
    if (!$session->isLoggedIn()) { 
      $session->addMessage('warning', 'You need to be logged in to perform this action!');
      die(header("Location: /"));
    }

    require_once(__DIR__. '/../database/connection.db.php');
    require_once(__DIR__. '/../database/dish.class.php');

    $db = getDatabaseConnection();

    $dish = new Dish($session->getDishId(), $session->getRestaurantId(), $_POST['name'], $_POST['description'], floatval($_POST['price']), $_POST['category']);
    $dish->save($db);
    $session->addMessage('info', 'The dish was updated successfully.');
    
    header("Location: ../pages/profile.php"); 
?>