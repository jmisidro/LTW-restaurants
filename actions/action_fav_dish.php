<?php
  
  declare(strict_types = 1);

  require_once(__DIR__. '/../utils/session.php');
  $session = new Session();
  if (!$session->isLoggedIn()) { 
    $session->addMessage('warning', 'You need to be logged in to perform this action!');
    header('Location: ' . $_SERVER['HTTP_REFERER']);         // redirect to the page we came from
  }

  require_once(__DIR__. '/../database/connection.db.php');
  require_once(__DIR__. '/../database/favorites.db.php');
  
  $db = getDatabaseConnection();

  addFavDish($db, $session->getId(), $session->getDishId());
  $session->addMessage('info', 'You have added this dish to your favorites.');
  header('Location: ' . $_SERVER['HTTP_REFERER']);
?>