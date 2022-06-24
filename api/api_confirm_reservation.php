<?php
  
  declare(strict_types = 1);

  require_once(__DIR__. '/../utils/session.php');
  $session = new Session();

  require_once(__DIR__. '/../database/connection.db.php');
  require_once(__DIR__. '/../database/reservation.class.php');
  
  $db = getDatabaseConnection();

  $json = file_get_contents('php://input');
  $reservation_info = json_decode($json, true);  
  
  $reservation = new Reservation(null, $session->getId(), $session->getRestaurantId(), intval($reservation_info[0]), 'active', $reservation_info[1]);
  $newid = $reservation->add($db);

  echo $newid;  
?>