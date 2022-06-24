<?php
declare(strict_types = 1);

require_once(__DIR__. '/../utils/session.php');
$session = new Session();

$items = $session->getCartItems();
if(!$session->isLoggedIn()) {
    $session->addMessage('info', 'Please login or register before you make a purchase.');
    die(header("Location: /"));         // redirect to the index page
}
else if($session->getUsertype() == 1) {
    $session->addMessage('info', "You need to 'View as Customer' to use the Cart.");
    die(header("Location: ../pages/profile.php"));         // redirect to the index page
}

require_once(__DIR__. '/../database/connection.db.php');
require_once(__DIR__. '/../database/restaurant.class.php');
require_once(__DIR__. '/../database/dish.class.php');

require_once(__DIR__. '/../templates/common.tpl.php');
require_once(__DIR__. '/../templates/cart.tpl.php');

$db = getDatabaseConnection();

$quantities = array();
$dishes = array();

foreach($items as $dishid => $quantity){
    $dish = Dish::getDish($db, intval($dishid));
    $restid = $dish->restaurant_id;
    array_push($dishes , $dish);
    array_push($quantities , $quantity);
}

if ($restid)
    $restaurant = Restaurant::getRestaurant($db, intval($restid));


drawHeader($session);
drawCart($dishes, $restaurant, $quantities, $session);
drawFooter();

?>