<?php
  declare(strict_types = 1);

  require_once(__DIR__. '/../utils/session.php');
  $session = new Session();

  require_once(__DIR__. '/../database/connection.db.php');
  require_once(__DIR__. '/../database/dish.class.php');

  $db = getDatabaseConnection();
  $dishes = Dish::searchDishes($db, $_GET['search'], $session->getRestaurantId(), 15);

  $loggedIn = $session->isLoggedIn() & ($session->getUsertype() === 0);

  echo json_encode(array('dishes' => $dishes, 'loggedIn' => $loggedIn));
?>