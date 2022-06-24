<?php
declare(strict_types = 1);

require_once(__DIR__. '/../utils/session.php');
$session = new Session();

if (!$session->isLoggedIn()) { 
    $session->addMessage('warning', 'You need to be logged in to perform this action!');
    die(header("Location: /"));         // redirect to the index page
}


require_once(__DIR__. '/../database/connection.db.php');
require_once(__DIR__. '/../database/restaurant.class.php');
require_once(__DIR__. '/../database/dish.class.php');

$db = getDatabaseConnection();
$restaurant = Restaurant::getRestaurant($db, $session->getRestaurantId());

// Verifies if this owner actually owns the restaurant
if ($session->getId() !== intval($restaurant->owner_id)) {
    $session->addMessage('warning', 'You do not own this restaurant!');
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}

$session->addMessage('info', 'You have removed this restaurant successfully.');
$dishes = Dish::getRestaurantDishes($db, $session->getRestaurantId());

foreach ($dishes as $dish) {
    unlink("../imgs/dishes/originals/" . $dish->id . ".jpg");
    unlink("../imgs/dishes/small/" . $dish->id . ".jpg");
    unlink("../imgs/dishes/medium/" . $dish->id . ".jpg");
    $dish->remove($db);
}

$restaurant->remove($db);
unlink("../imgs/restaurants/originals/" . $session->getRestaurantId() . ".jpg");
unlink("../imgs/restaurants/small/" . $session->getRestaurantId() . ".jpg");
unlink("../imgs/restaurants/medium/" . $session->getRestaurantId() . ".jpg");

header("Location: ../pages/profile.php");          // redirect to the profile page

?>