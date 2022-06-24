<?php

declare(strict_types=1);

class Dish
{
    public ?int $id;
    public int $restaurant_id;
    public string $name;
    public ?string $description;
    public float $price;
    public ?string $category;

    public function __construct(?int $id, int $restaurant_id, string $name, ?string $description, float $price, ?string $category)
    {
        $this->id = $id;
        $this->restaurant_id = $restaurant_id;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->category = $category;
    }

    static function avg_dish_price(array $dishes) : float{
      $price_Sum = 0;
      foreach ($dishes as $dish) {
        $price_Sum += $dish->price;
      }

      return $price_Sum / sizeof($dishes);
    } 

    static function getDishes(PDO $db, int $count) : array {
        $stmt = $db->prepare('SELECT * FROM Dish LIMIT ?');
        $stmt->execute(array($count));
    
        $dishes = array();
        while ($dish = $stmt->fetch()) {
          $dishes[] = new Dish(
            intval($dish['DishId']),
            intval($dish['RestaurantId']),
            $dish['Name'],
            $dish['Description'], 
            floatval($dish['Price']),
            $dish['Category']
          );
        }
    
        return $dishes;
      }


      static function searchDishes(PDO $db, string $search, int $restId, int $count) : array {
        $stmt = $db->prepare('SELECT * FROM Dish WHERE RestaurantId = ? AND Name LIKE ? LIMIT ?');
        $stmt->execute(array($restId, $search . '%', $count));
    
        $dishes = array();
        while ($dish = $stmt->fetch()) {
          $dishes[] = new Dish(
            intval($dish['DishId']),
            intval($dish['RestaurantId']),
            $dish['Name'],
            $dish['Description'], 
            floatval($dish['Price']),
            $dish['Category']
          );
        }
         return $dishes;
      }

      static function getDish(PDO $db, int $id) {
        $stmt = $db->prepare('SELECT * FROM Dish WHERE DishId = ?');
        $stmt->execute(array($id));
    
        $dish = $stmt->fetch();
        if($dish == false) return null;

        return new Dish(
          intval($dish['DishId']),
          intval($dish['RestaurantId']),
          $dish['Name'],
          $dish['Description'], 
          floatval($dish['Price']),
          $dish['Category']
        );
      }

      static function getRestaurantDishes(PDO $db, int $id) : array {
        $stmt = $db->prepare('
          SELECT DishId, Dish.Name, Price, Dish.Description, Dish.Category, Dish.RestaurantId
          FROM Dish JOIN Restaurant USING (RestaurantId) 
          WHERE RestaurantId = ?
        ');
        $stmt->execute(array($id));
    
        $dishes = array();
    
        while ($dish = $stmt->fetch()) {
          $dishes[] = new Dish(
            intval($dish['DishId']),
            intval($dish['RestaurantId']),
            $dish['Name'],
            $dish['Description'], 
            floatval($dish['Price']),
            $dish['Category']
          );
        }
    
        return $dishes;
      }

      static function getOrderDishes(PDO $db, int $id) : array {
        $stmt = $db->prepare('
          SELECT Dish.DishId, Dish.Name, Dish.Price, Dish.Description, Dish.Category, OrdersDish.Quantity
          FROM Dish JOIN OrdersDish USING (DishId) 
          WHERE OrderId = ?
        ');
        $stmt->execute(array($id));
    
        $dishes = array();
    
        while ($dish = $stmt->fetch()) {
          $dishes[] = array(
            'DishId' => intval($dish['DishId']),
            'RestaurantId' => intval($dish['RestaurantId']),
            'Name' => $dish['Name'],
            'Description' => $dish['Description'], 
            'Price' => floatval($dish['Price']),
            'Category' => $dish['Category'],
            'Quantity' => $dish['Quantity']
          );
        }
    
        return $dishes;
      }
      
/*       CREATE TABLE Dish
(
    DishId INTEGER  NOT NULL,
    RestaurantId INTEGER REFERENCES Restaurant (RestaurantId) 
    ON DELETE NO ACTION ON UPDATE NO ACTION,
    Name NVARCHAR(160),
    Description NVARCHAR(200),
    Price REAL,
    Category NVARCHAR(20),
    CONSTRAINT PK_Dish PRIMARY KEY  (DishId)
    FOREIGN KEY (RestaurantId) REFERENCES Restaurant (RestaurantId)
		ON DELETE NO ACTION ON UPDATE NO ACTION
); */
      static function getFavoriteDishes(PDO $db, int $id): array
      {
          $stmt = $db->prepare('
            SELECT Dish.DishId, Dish.RestaurantId, Dish.Name, Dish.Description, Dish.Price, Dish.Category
            FROM (Dish JOIN FavDishes using (DishId)) JOIN User using (UserId)
            WHERE UserId = ?
          ');
          $stmt->execute(array($id));
  
          $dishes = array();
          while ($dish = $stmt->fetch()) {
            $dishes[] = new Dish(
              intval($dish['DishId']),
              intval($dish['RestaurantId']),
              $dish['Name'],
              $dish['Description'], 
              floatval($dish['Price']),
              $dish['Category']
            );
          }
           return $dishes;
        }

      function add(PDO $db) : int{

        $stmt = $db->prepare('
            INSERT INTO Dish (RestaurantId, Name, Description, Price, Category)  VALUES
            (?, ?, ?, ?, ?)
          ');
    
        $stmt->execute(array($this->restaurant_id,$this->name,$this->description,$this->price,$this->category));
        return intval($db->lastInsertId());
      }
    
      function save(PDO $db) {
        $stmt = $db->prepare('
          UPDATE Dish SET Name = ?, Description = ?, Price = ?, Category = ?
          WHERE DishId = ?
        ');
    
        $stmt->execute(array($this->name, $this->description, $this->price, $this->category, $this->id));
      }
    
      function remove(PDO $db) {
    
        $stmt = $db->prepare('DELETE FROM Dish WHERE DishId = ?');
    
        $stmt->execute(array($this->id));
      }

    }

    
?>