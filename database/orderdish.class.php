<?php

declare(strict_types=1);

require_once(__DIR__. '/../database/connection.db.php');
require_once(__DIR__. '/../database/order.class.php');
require_once(__DIR__. '/../database/dish.class.php');


class OrderDish
{
    public Order $order;
    public Dish $dish;
    public int $quantity;


    public function __construct(int $orderid, int $dishid, int $quantity)
    {
        $db = getDatabaseConnection();
        $this->order = Order::getOrder($db, $orderid);
        $this->dish = Dish::getDish($db, $dishid);
        $this->quantity = $quantity;
    }


      static function getOrderDish(PDO $db, int $orderid, int $dishid) : Order {
        $stmt = $db->prepare('SELECT * FROM OrdersDish WHERE OrderId = ? AND DishId = ?');
        $stmt->execute(array($orderid, $dishid));
    
        $order = $stmt->fetch();
    
        return new Order(
            intval($order['OrderId']),
            intval($order['RestaurantId']),
            intval($order['UserId']),
            floatval($order['Total']),
            $order['Status'], 
            $order['Date']
          );
      }

      function add(PDO $db) {
        $stmt = $db->prepare('
            INSERT INTO OrdersDish (OrderId, DishId, Quantity)  VALUES
            (?, ?, ?)
          ');
    
        $stmt->execute(array($this->order->id,$this->dish->id,$this->quantity));
      }
    
    
      function remove(PDO $db) {
    
        $stmt = $db->prepare('DELETE FROM OrdersDish WHERE OrderId = ? AND DishId = ?');
    
        $stmt->execute(array($this->order->id,$this->dish->id));
      }

    }