<?php
    declare(strict_types = 1);

    require_once('../utils/session.php');
    $session = new Session();

    if (!$session->isLoggedIn()) { 
        $session->addMessage('warning', 'You need to be logged in to perform this action!');
        die(header("Location: /"));         // redirect to the index page
    }


    require_once('../database/connection.db.php');
    require_once('../database/order.class.php');
    require_once('../database/restaurant.class.php');
    require_once('../database/dish.class.php');
    
    require_once('../templates/common.tpl.php');
    require_once('../templates/order.tpl.php');

    $db = getDatabaseConnection();
    $order =  Order::getOrder($db, intval($_GET['id']));
    if ($order !== NULL)
        $dishes = Dish::getOrderDishes($db, intval($_GET['id']));
    else {
        $session->addMessage('warning', 'This page does not exist!');
        die(header("Location: /"));         // redirect to the index page
    }

    // Verifies if this user can view this page
    if ($session->getUsertype() == 0) {
        if ($session->getId() !== $order->user_id) {
            $session->addMessage('warning', 'You do not have access to this information!');
            die(header("Location: /"));         // redirect to the index page
        }
    }
    // Verifies if this owner can view this page
    else if ($session->getUsertype() == 1) {
        $restaurant = Restaurant::getRestaurant($db, $order->restaurant_id);
        if ($session->getId() !== $restaurant->owner_id) {
            $session->addMessage('warning', 'You do not own this restaurant!');
            die(header("Location: /"));         // redirect to the index page
        }
    }

    drawHeader($session);
    drawReceipt($order, $dishes);
    drawFooter();

?>