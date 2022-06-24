<?php
  
  declare(strict_types = 1);

  require_once(__DIR__. '/../utils/session.php');
  $session = new Session();

  require_once(__DIR__. '/../database/connection.db.php');
  require_once(__DIR__. '/../database/orderdish.class.php');
  
  $db = getDatabaseConnection();

  $json = file_get_contents('php://input');
  $orderdish_info = json_decode($json, true);
  
  $orderdish = new OrderDish(intval($orderdish_info[0]), intval($orderdish_info[1]), intval($orderdish_info[2]));
  $orderdish->add($db);
  
  //$session->addMessage('info', 'Order submited.');
?>