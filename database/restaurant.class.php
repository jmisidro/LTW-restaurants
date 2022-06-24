<?php

declare(strict_types=1);

require_once(__DIR__. '/../database/dish.class.php');

class Restaurant
{
    public ?int $id;
    public string $name;
    public int $owner_id;
    public string $address;
    public string $category;
    public ?float $avg_price;

    public function __construct(?int $id, string $name, int $owner_id, string $address, string $category, ?float $avg_price)
    {
        $this->id = $id;
        $this->name = $name;
        $this->owner_id = $owner_id;
        $this->address = $address;
        $this->category = $category;
        $this->avg_price = $avg_price;
    }


    static function getRestaurant(PDO $db, int $id)
    {
        $stmt = $db->prepare('SELECT * FROM Restaurant  WHERE RestaurantId = ?');
        $stmt->execute(array($id));

        $restaurant = $stmt->fetch();
        if($restaurant == false) return null;

        $avgprice = Dish::avg_dish_price(Dish::getRestaurantDishes($db, $id));

        return new Restaurant(
            intval($restaurant['RestaurantId']),
            $restaurant['Name'],
            intval($restaurant['OwnerId']),
            $restaurant['Address'],
            $restaurant['Category'],
            $avgprice
        );
    }

    static function getFavoriteRestaurants(PDO $db, int $id): array
    {
        $stmt = $db->prepare('
          SELECT Restaurant.RestaurantId, Restaurant.OwnerId, Restaurant.Name, Restaurant.Address, Restaurant.Category
          FROM (Restaurant JOIN FavRestaurants using (RestaurantId)) JOIN User using (UserId)
          WHERE UserId = ?
        ');
        $stmt->execute(array($id));

        $restaurants = array();

        while ($restaurant = $stmt->fetch()) {
            $avgprice = Dish::avg_dish_price(Dish::getRestaurantDishes($db, intval($restaurant['RestaurantId'])));
            $restaurants[] = new Restaurant(
                intval($restaurant['RestaurantId']),
                $restaurant['Name'],
                intval($restaurant['OwnerId']),
                $restaurant['Address'],
                $restaurant['Category'],
                $avgprice
            );
        }

        return $restaurants;
    }


    static function searchOwnerRestaurants(PDO $db, string $search, int $OwnerId, int $count): array
    {
        $stmt = $db->prepare('
    SELECT Restaurant.RestaurantId, Restaurant.Name, Restaurant.OwnerId, Restaurant.Address, Restaurant.Category
    FROM Restaurant JOIN Owner USING (OwnerId) 
    WHERE OwnerId = ? AND Restaurant.Name LIKE ? LIMIT ?
    ');
        $stmt->execute(array($OwnerId, $search . '%', $count));

        $restaurants = array();
        while ($restaurant = $stmt->fetch()) {
            $avgprice = Dish::avg_dish_price(Dish::getRestaurantDishes($db, intval($restaurant['RestaurantId'])));
            $restaurants[] = new Restaurant(
                intval($restaurant['RestaurantId']),
                $restaurant['Name'],
                intval($restaurant['OwnerId']),
                $restaurant['Address'],
                $restaurant['Category'],
                $avgprice
            );
        }
        return $restaurants;
    }

    static function getOwnerRestaurants(PDO $db, int $id): array
    {
        $stmt = $db->prepare('
      SELECT Restaurant.RestaurantId, Restaurant.Name, Restaurant.OwnerId, Restaurant.Address, Restaurant.Category
      FROM Restaurant JOIN Owner USING (OwnerId) 
      WHERE OwnerId = ?
    ');
        $stmt->execute(array($id));

        $restaurants = array();

        while ($restaurant = $stmt->fetch()) {
            $avgprice = Dish::avg_dish_price(Dish::getRestaurantDishes($db, intval($restaurant['RestaurantId'])));
            $restaurants[] = new Restaurant(
                intval($restaurant['RestaurantId']),
                $restaurant['Name'],
                intval($restaurant['OwnerId']),
                $restaurant['Address'],
                $restaurant['Category'],
                $avgprice
            );
        }

        return $restaurants;
    }

    static function searchRestaurants(PDO $db, string $search, int $count): array
    {
        $stmt = $db->prepare('SELECT * FROM Restaurant WHERE Name LIKE ? LIMIT ?');
        $stmt->execute(array($search . '%', $count));

        $restaurants = array();
        while ($restaurant = $stmt->fetch()) {
            $avgprice = Dish::avg_dish_price(Dish::getRestaurantDishes($db, intval($restaurant['RestaurantId'])));
            $restaurants[] = new Restaurant(
                intval($restaurant['RestaurantId']),
                $restaurant['Name'],
                intval($restaurant['OwnerId']),
                $restaurant['Address'],
                $restaurant['Category'],
                $avgprice
            );
        }

        return $restaurants;
    }

    static function getRestaurants(PDO $db, int $count) : array {
        $stmt = $db->prepare('SELECT * FROM Restaurant LIMIT ?');
        $stmt->execute(array($count));
    
        $restaurants = array();
        while ($restaurant = $stmt->fetch()) {
          $avgprice = Dish::avg_dish_price(Dish::getRestaurantDishes($db, intval($restaurant['RestaurantId'])));
          $restaurants[] = new Restaurant(
            intval($restaurant['RestaurantId']),
            $restaurant['Name'],
            intval($restaurant['OwnerId']),
            $restaurant['Address'],
            $restaurant['Category'],
            $avgprice
        );
        }
        return $restaurants;
    }

    static function getRestaurantsCategories(PDO $db) : array {
        $stmt = $db->prepare('SELECT Category FROM Restaurant GROUP BY Category ORDER BY Category ASC');
        $stmt->execute();
    
        $categories = array();
        while ($restaurant = $stmt->fetch()) {
          $categories[] = $restaurant['Category'];
        }

        return $categories;
    }


    static function filterRestaurantsCategory(PDO $db, string $category, int $count): array
    {
        $stmt = $db->prepare('SELECT * FROM Restaurant WHERE lower(Category) = ? LIMIT ?');
        $stmt->execute(array(strtolower($category), $count));

        $restaurants = array();
        while ($restaurant = $stmt->fetch()) {
            $avgprice = Dish::avg_dish_price(Dish::getRestaurantDishes($db, intval($restaurant['RestaurantId'])));
            $restaurants[] = new Restaurant(
                intval($restaurant['RestaurantId']),
                $restaurant['Name'],
                intval($restaurant['OwnerId']),
                $restaurant['Address'],
                $restaurant['Category'],
                $avgprice
            );
        }

        return $restaurants;
    }


    static function filterRestaurantsPrice(PDO $db, int $price, int $count) : array {
        $stmt = $db->prepare('SELECT * FROM Restaurant LIMIT ?');
        $stmt->execute(array($count));
    
        $restaurants = array();
        while ($restaurant = $stmt->fetch()) {
            $avgprice = Dish::avg_dish_price(Dish::getRestaurantDishes($db, intval($restaurant['RestaurantId'])));
            if (isPriceAMatch($avgprice, $price)) {
                $restaurants[] = new Restaurant(
                    intval($restaurant['RestaurantId']),
                    $restaurant['Name'],
                    intval($restaurant['OwnerId']),
                    $restaurant['Address'],
                    $restaurant['Category'],
                    $avgprice
                );
            }
        }

        return $restaurants;
    }

    static function sortRestaurantsName(PDO $db, int $count): array
    {
        $stmt = $db->prepare('SELECT * FROM Restaurant ORDER BY Name ASC LIMIT ?');
        $stmt->execute(array($count));

        $restaurants = array();
        while ($restaurant = $stmt->fetch()) {
            $avgprice = Dish::avg_dish_price(Dish::getRestaurantDishes($db, intval($restaurant['RestaurantId'])));
            $restaurants[] = new Restaurant(
                intval($restaurant['RestaurantId']),
                $restaurant['Name'],
                intval($restaurant['OwnerId']),
                $restaurant['Address'],
                $restaurant['Category'],
                $avgprice
            );
        }

        return $restaurants;
    }

    static function sortRestaurantsCategory(PDO $db, int $count): array
    {
        $stmt = $db->prepare('SELECT * FROM Restaurant ORDER BY Category ASC LIMIT ?');
        $stmt->execute(array($count));

        $restaurants = array();
        while ($restaurant = $stmt->fetch()) {
            $avgprice = Dish::avg_dish_price(Dish::getRestaurantDishes($db, intval($restaurant['RestaurantId'])));
            $restaurants[] = new Restaurant(
                intval($restaurant['RestaurantId']),
                $restaurant['Name'],
                intval($restaurant['OwnerId']),
                $restaurant['Address'],
                $restaurant['Category'],
                $avgprice
            );
        }

        return $restaurants;
    }

    static function sortRestaurantsPrice(PDO $db, int $count): array
    {
        $stmt = $db->prepare('SELECT * FROM Restaurant LIMIT ?');
        $stmt->execute(array($count));

        $restaurants = array();
        while ($restaurant = $stmt->fetch()) {
            $avgprice = Dish::avg_dish_price(Dish::getRestaurantDishes($db, intval($restaurant['RestaurantId'])));
            $restaurants[] = new Restaurant(
                intval($restaurant['RestaurantId']),
                $restaurant['Name'],
                intval($restaurant['OwnerId']),
                $restaurant['Address'],
                $restaurant['Category'],
                $avgprice
            );
        }

        // Orders By avgprice
        usort($restaurants, function($a, $b) {
            return $a->avgprice - $b->avgprice;
        });
        
        return $restaurants;

    }
      
    function save(PDO $db)
    {

        $stmt = $db->prepare('
            UPDATE Restaurant SET Name = ?, Address = ?, Category = ?
            WHERE RestaurantId = ?
          ');

        $stmt->execute(array($this->name, $this->address, $this->category, $this->id));
    }

    function remove(PDO $db)
    {

        $stmt = $db->prepare('DELETE FROM Restaurant WHERE RestaurantId = ?');

        $stmt->execute(array($this->id));
    }


    function add(PDO $db): int
    {

        $stmt = $db->prepare('
        INSERT INTO Restaurant (Name, OwnerId, Address, Category)  VALUES
        (?, ?, ?, ?)
      ');

        $stmt->execute(array($this->name, $this->owner_id, $this->address, $this->category));
        return intval($db->lastInsertId());
    }
}

// Aux function to match the given value of price in filterPrice function
function isPriceAMatch(float $avgprice, int $price) : bool {
    switch($avgprice) {
        case $avgprice <= 10.0:
            return 1 === $price;
            break;
        case $avgprice >= 10.0 && $avgprice <= 30.0:
            return 2 === $price;
            break;
        case $avgprice >= 30.0 && $avgprice <= 50.0:
            return 3 === $price;
            break;
        case $avgprice >= 50.0 && $avgprice <= 100.0:
            return 4 === $price;
            break;
        default:
            break;
    }
}


?>