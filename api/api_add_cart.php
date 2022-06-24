<?php
  declare(strict_types = 1);

  require_once(__DIR__. '/../utils/session.php');
  $session = new Session();

  require_once(__DIR__. '/../database/connection.db.php');
  require_once(__DIR__. '/../database/dish.class.php');

  $db = getDatabaseConnection();

  $json = file_get_contents('php://input');
  $dishid = json_decode($json, true);
  $dish = Dish::getDish($db, intval($dishid));

  if ($session->getCartRestaurantId() == null)
    $session->setCartRestaurantId(intval($dish->restaurant_id));
  else if ($session->getCartRestaurantId() !== intval($dish->restaurant_id)) {
    //$session->addMessage('info', 'You may only order from one restaurant at a time.');
    die(header('Location: ' . $_SERVER['HTTP_REFERER']));         // redirect to the index page
  }
  $session->addCartitem($dishid);
  $session->increaseCartQuantity();
?>