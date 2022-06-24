<?php
  
  declare(strict_types = 1);

  require_once(__DIR__. '/../utils/session.php');
  $session = new Session();
  if (!$session->isLoggedIn()) { 
    $session->addMessage('warning', 'You need to be logged in to perform this action!');
    die(header("Location: /"));         // redirect to the index page
  }

  require_once(__DIR__. '/../database/connection.db.php');
  require_once(__DIR__. '/../database/reservation.class.php');
  
  $db = getDatabaseConnection();
  $reservation = Reservation::getReservation($db, intval($_POST['cancel-reservation-id']));
  $reservation->status = 'canceled';
  $reservation->save($db);
  $session->addMessage('info', 'This reservation has been canceled.');
  header('Location: ' . $_SERVER['HTTP_REFERER']);
?>