<?php
declare(strict_types = 1);

require_once(__DIR__. '/../utils/session.php');
$session = new Session();

if (!$session->isLoggedIn()) { 
    $session->addMessage('warning', 'You need to be logged in to perform this action!');
    die(header("Location: /"));         // redirect to the index page
}

$session->setDishId(intval($_POST['edit-id']));
$session->setPage('edit_dish.php');

require_once(__DIR__. '/../database/connection.db.php');
require_once(__DIR__. '/../database/dish.class.php');
require_once(__DIR__. '/../database/owner.class.php');
require_once(__DIR__. '/../database/restaurant.class.php');

require_once(__DIR__. '/../templates/common.tpl.php');
require_once(__DIR__. '/../templates/profile.tpl.php');
require_once(__DIR__. '/../templates/restaurant.tpl.php');
require_once(__DIR__. '/../templates/dish.tpl.php');

$db = getDatabaseConnection();
$owner = Owner::getOwner($db, $session->getId());
$restaurant = Restaurant::getRestaurant($db, $session->getRestaurantId());
$dish = Dish::getDish($db, $session->getDishId());


// Verifies if this owner actually owns the restaurant
if ($session->getId() !== intval($restaurant->owner_id)) {
    $session->addMessage('warning', 'You do not own this restaurant!');
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}

drawHeader($session);
drawEditDish($dish);
drawRemoveDishForm();
drawFooter();

?>