<?php

require_once(__DIR__. '/../utils/session.php');
$session = new Session();

$session->setDishId(intval($_GET['id']));

require_once(__DIR__. '/../database/connection.db.php');
require_once(__DIR__. '/../database/dish.class.php');
require_once(__DIR__. '/../database/restaurant.class.php');

require_once(__DIR__. '/../templates/common.tpl.php');
require_once(__DIR__. '/../templates/dish.tpl.php');
require_once(__DIR__. '/../templates/restaurant.tpl.php');

$db = getDatabaseConnection();
$dish = Dish::getDish($db, intval($_GET['id']));
if ($dish !== NULL)
    $restaurant = Restaurant::getRestaurant($db, $dish->restaurant_id);
else {
    $session->addMessage('warning', 'This page does not exist!');
    die(header("Location: /"));         // redirect to the index page
}

drawHeader($session);
drawRestaurant_Name($restaurant);
drawDish($db, $dish, $session);
drawLoginForm();
drawRegisterForm();
drawFooter();

?>