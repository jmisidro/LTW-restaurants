<?php
  
  declare(strict_types = 1);

  require_once(__DIR__. '/../utils/session.php');
  $session = new Session();

  require_once(__DIR__. '/../database/connection.db.php');
  require_once(__DIR__. '/../database/order.class.php');
  
  $db = getDatabaseConnection();

  $json = file_get_contents('php://input');
  $orderinfo = json_decode($json, true);
  
  $order = new Order(null, $session->getRestaurantId(), $session->getId(), floatval($orderinfo), 'preparing', date('Y/m/d'));
  $newid = $order->add($db);

  echo $newid;  
?>