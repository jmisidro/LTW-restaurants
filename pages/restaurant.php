<?php
declare(strict_types = 1);

require_once(__DIR__. '/../utils/session.php');
$session = new Session();

$session->setRestaurantId(intval($_GET['id']));

require_once(__DIR__. '/../database/connection.db.php');
require_once(__DIR__. '/../database/dish.class.php');
require_once(__DIR__. '/../database/restaurant.class.php');
require_once(__DIR__. '/../database/favorites.db.php');
require_once(__DIR__. '/../database/review.class.php');

require_once(__DIR__. '/../templates/common.tpl.php');
require_once(__DIR__. '/../templates/dish.tpl.php');
require_once(__DIR__. '/../templates/restaurant.tpl.php');
require_once(__DIR__. '/../templates/review.tpl.php');

$db = getDatabaseConnection();
$restaurant = Restaurant::getRestaurant($db, intval($_GET['id']));
if ($restaurant !== NULL) {
    $dishes = Dish::getRestaurantDishes($db, intval($_GET['id']));
    $avg_price = Dish::avg_dish_price($dishes);
    if ($session->isLoggedIn())
        $fav = isFavRestaurant($db, $session->getId(), $session->getRestaurantId());
    $reviews = Review::getReviews($db, intval($_GET['id']), 6);
}
else {
    $session->addMessage('warning', 'This page does not exist!');
    die(header("Location: /"));         // redirect to the index page
}



drawHeader($session);
drawRestaurant_Info($restaurant, $session, $fav);
drawDishes($dishes, $session);
drawReviews($db, $reviews, $session);
drawEditReview();
drawCommentForm();
drawLoginForm();
drawRegisterForm();
drawReviewForm();
drawFooter();

?>