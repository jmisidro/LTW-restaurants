<?php
declare(strict_types = 1);

require_once(__DIR__. '/../utils/session.php');
$session = new Session();

if (!$session->isLoggedIn()) { 
    $session->addMessage('warning', 'You need to be logged in to perform this action!');
    die(header("Location: /"));         // redirect to the index page
}
    
$session->setPage('add_dish.php');

require_once(__DIR__. '/../database/connection.db.php');
require_once(__DIR__. '/../database/restaurant.class.php');

require_once(__DIR__. '/../templates/common.tpl.php');
require_once(__DIR__. '/../templates/profile.tpl.php');
require_once(__DIR__. '/../templates/dish.tpl.php');

$db = getDatabaseConnection();
$restaurant = Restaurant::getRestaurant($db, $session->getRestaurantId());


// Verifies if this owner actually owns the restaurant
if ($session->getId() !== intval($restaurant->owner_id)) {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    // add ERROR to messages and display it on index.php
}

drawHeader($session);
if(!$session->getDishId())
    drawAddDish();
else
    drawAddDishUpload($session->getDishId());
drawFooter();

?>