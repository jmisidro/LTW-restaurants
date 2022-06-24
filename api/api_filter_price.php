<?php
  declare(strict_types = 1);

  require_once(__DIR__. '/../utils/session.php');
  $session = new Session();

  require_once(__DIR__. '/../database/connection.db.php');
  require_once(__DIR__. '/../database/restaurant.class.php');

  $db = getDatabaseConnection();

  $json = file_get_contents('php://input');
  $value = json_decode($json, true);
  $restaurants = Restaurant::filterRestaurantsPrice($db, intval($value), 15);

  echo json_encode($restaurants);
?>