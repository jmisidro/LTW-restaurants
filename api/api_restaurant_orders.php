<?php
  declare(strict_types = 1);

  require_once(__DIR__. '/../utils/session.php');
  $session = new Session();

  require_once(__DIR__. '/../database/connection.db.php');
  require_once(__DIR__. '/../database/order.class.php');

  $db = getDatabaseConnection();
  $orders = Order::getRestaurantOrders($db, intval($_GET['id']));

  echo json_encode($orders);
?>