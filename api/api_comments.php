<?php
  declare(strict_types = 1);

  require_once(__DIR__. '/../utils/session.php');
  $session = new Session();

  require_once(__DIR__. '/../database/connection.db.php');
  require_once(__DIR__. '/../database/review.class.php');
  require_once(__DIR__. '/../database/restaurant.class.php');
  require_once(__DIR__. '/../database/owner.class.php');

  $db = getDatabaseConnection();
  $comments = getComments($db, $session->getRestaurantId());
  $restaurant = Restaurant::getRestaurant($db, $session->getRestaurantId());
  $owner = Owner::getOwner($db, $restaurant->owner_id);


  echo json_encode(array('owner' => $owner, 'comments' => $comments, 'restaurant' => $restaurant));
?>