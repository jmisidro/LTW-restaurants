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
    $dish = Dish::getDish($db, $session->getDishId());

    // Verifies if this owner actually owns the restaurant
    if ($session->getId() !== intval($restaurant->owner_id)) {
        $session->addMessage('warning', 'You do not own this restaurant!');
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }

    $session->addMessage('info', 'You have removed this dish successfully.');

    $dish->remove($db);
    unlink("../imgs/dishes/originals/" . $session->getDishId() . ".jpg");
    unlink("../imgs/dishes/small/" . $session->getDishId() . ".jpg");
    unlink("../imgs/dishes/medium/" . $session->getDishId() . ".jpg");

    header("Location: ../pages/profile.php");          // redirect to the profile page
?>