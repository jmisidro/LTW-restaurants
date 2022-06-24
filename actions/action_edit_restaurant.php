<?php
  require_once(__DIR__. '/../utils/session.php');
  $session = new Session();                                      // starts the session

  if (!$session->isLoggedIn()) { 
    $session->addMessage('warning', 'You need to be logged in to perform this action!');
    die(header("Location: /"));
  }

  require_once(__DIR__. '/../database/connection.db.php');
  require_once(__DIR__. '/../database/restaurant.class.php');

  $db = getDatabaseConnection();
  $restaurant = new Restaurant($session->getRestaurantId(), $_POST['name'], $session->getId(), $_POST['address'], $_POST['category'], NULL);
  $restaurant->save($db);
  $session->addMessage('info', 'The restaurant was updated successfully.');
  
  header("Location: ../pages/profile.php");          // redirect to the profile page
?>