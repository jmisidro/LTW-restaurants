<?php

    declare(strict_types = 1);

    function isFavRestaurant(PDO $db, int $id, int $restaurantId) : bool{
        $stmt = $db->prepare('
            SELECT * FROM FavRestaurants WHERE UserId = ? AND RestaurantId = ?
        ');
    
        $stmt->execute(array($id, $restaurantId));

        $fav = $stmt->fetch();

        if ($fav)
            return true;
        else
            return false;
    }

    function addFavRestaurant(PDO $db, int $id, int $restaurantId) {
        $stmt = $db->prepare('
            INSERT INTO FavRestaurants (UserId, RestaurantId) VALUES
            (?, ?)
        ');
    
        $stmt->execute(array($id, $restaurantId));
    }

    function removeFavRestaurant(PDO $db, int $id, int $restaurantId) {
        $stmt = $db->prepare('
            DELETE FROM FavRestaurants WHERE UserId = ? AND RestaurantId = ?
        ');
    
        $stmt->execute(array($id, $restaurantId));
    }

    function isFavDish(PDO $db, int $id, int $DishId) : bool{
        $stmt = $db->prepare('
            SELECT * FROM FavDishes WHERE UserId = ? AND DishId = ?
        ');
    
        $stmt->execute(array($id, $DishId));

        $fav = $stmt->fetch();

        if ($fav)
            return true;
        else
            return false;
    }

    function addFavDish(PDO $db, int $id, int $DishId) {
        $stmt = $db->prepare('
            INSERT INTO FavDishes (UserId, DishId) VALUES
            (?, ?)
        ');
    
        $stmt->execute(array($id, $DishId));
    }

    function removeFavDish(PDO $db, int $id, int $DishId) {
        $stmt = $db->prepare('
            DELETE FROM FavDishes WHERE UserId = ? AND DishId = ?
        ');
    
        $stmt->execute(array($id, $DishId));
    }

?>