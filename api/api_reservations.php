<?php
  declare(strict_types = 1);

  require_once(__DIR__. '/../utils/session.php');
  $session = new Session();

  require_once(__DIR__. '/../database/connection.db.php');
  require_once(__DIR__. '/../database/reservation.class.php');

  $db = getDatabaseConnection();
  $reservations = Reservation::searchReservations($db, $_GET['search'], $session->getId(), 15);

  echo json_encode($reservations);
?>