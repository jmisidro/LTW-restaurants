<?php
  declare(strict_types = 1);

  require_once(__DIR__. '/../utils/session.php');
  $session = new Session();
  $session->logout();

  if ($session->getPage() === 'profile.php' || $session->getPage() === 'edit_profile.php' || $session->getPage() === 'edit_restaurant.php' || $session->getPage() === 'edit_dish.php' || $session->getPage() === 'add_restaurant.php' || $session->getPage() === 'add_dish.php') {
    die(header("Location: /"));         // redirect to the index page
  }
  else
    header('Location: ' . $_SERVER['HTTP_REFERER']);
?>