<?php
  
  declare(strict_types = 1);

  require_once(__DIR__. '/../utils/session.php');
  $session = new Session();

  require_once(__DIR__. '/../database/connection.db.php');
  require_once(__DIR__. '/../database/order.class.php');
  
  $db = getDatabaseConnection();

  $json = file_get_contents('php://input');
  $orderinfo = json_decode($json, true);
  $order = Order::getOrder($db, intval($orderinfo[0]));
  
  $order->status = $orderinfo[1];
  $order->save($db);
  
  //$session->addMessage('info', 'Order status changed.');
?>