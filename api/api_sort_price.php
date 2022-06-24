<?php
  declare(strict_types = 1);

  require_once(__DIR__. '/../utils/session.php');
  $session = new Session();

  require_once(__DIR__. '/../database/connection.db.php');
  require_once(__DIR__. '/../database/restaurant.class.php');

  $db = getDatabaseConnection();

  $json = file_get_contents('php://input');
  $order = json_decode($json, true);
  $restaurants = Restaurant::sortRestaurantsPrice($db, 15);
  
  if ($order == 'asc') {
    echo json_encode($restaurants);
  } 
  else if($order == 'desc') {
    $reverse = array_reverse($restaurants);
    echo json_encode($reverse);
  }

?>