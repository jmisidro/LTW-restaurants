<?php
declare(strict_types = 1);

require_once(__DIR__. '/../utils/session.php');
$session = new Session();

if (!$session->isLoggedIn()) { 
    $session->addMessage('warning', 'You need to be logged in to perform this action!');
    die(header("Location: /"));         // redirect to the index page
}

$session->clearRestaurantId();
$session->clearDishId();
$session->setPage('profile.php');

require_once(__DIR__. '/../database/connection.db.php');
require_once(__DIR__. '/../database/restaurant.class.php');
require_once(__DIR__. '/../database/owner.class.php');
require_once(__DIR__. '/../database/user.class.php');

require_once(__DIR__. '/../templates/common.tpl.php');
require_once(__DIR__. '/../templates/profile.tpl.php');
require_once(__DIR__. '/../templates/restaurant.tpl.php');
require_once(__DIR__. '/../templates/dish.tpl.php');

$db = getDatabaseConnection();
if ($session->getUsertype() === 0)
    $user = User::getUser($db, $session->getId());
else if ($session->getUsertype() === 1) 
    $owner = Owner::getOwner($db, $session->getId());

if (isset($owner)) {
    $restaurants = Restaurant::getOwnerRestaurants($db, $session->getId());
}
else if ($user){
    $favrestaurants = Restaurant::getFavoriteRestaurants($db, $session->getId());
    $favdishes = Dish::getFavoriteDishes($db, $session->getId());
}

drawHeader($session);

if ($user){
    drawUser($user, $session);
    drawFavoriteRestaurantsProfile($favrestaurants);
    drawFavoriteDishesProfile($favdishes);
}
else if ($owner) {
    drawOwner($owner, $session);
    drawRestaurantsProfile($restaurants);
}

drawFooter();

?>