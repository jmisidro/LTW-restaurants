<?php

declare(strict_types=1);

require_once(__DIR__. '/../database/connection.db.php');
require_once(__DIR__. '/../database/restaurant.class.php');

class Order
{
    public ?int $id;
    public int $restaurant_id;
    public int $user_id;
    public float $total;
    public string $status;
    public string $date;
    public string $restaurant_name;


    public function __construct(?int $id, int $restaurantid, int $userid, float $total, string $status, string $date)
    {
        $this->id = $id;
        $this->restaurant_id = $restaurantid;
        $this->user_id = $userid;
        $this->total = $total;
        $this->status = $status;
        $this->date = $date;

        $db = getDatabaseConnection();
        $restaurant = Restaurant::getRestaurant($db, $this->restaurant_id);
        $this->restaurant_name = $restaurant->name;
    }


    static function getOrders(PDO $db, int $id, int $count) : array {
      $stmt = $db->prepare('SELECT * FROM Orders WHERE UserId = ? LIMIT ?');
      $stmt->execute(array($id, $count));
  
      $orders = array();
      while ($order = $stmt->fetch()) {
        $orders[] = new Order(
          intval($order['OrderId']),
          intval($order['RestaurantId']),
          intval($order['UserId']),
          floatval($order['Total']),
          $order['Status'], 
          $order['Date']
        );
      }
    
      return $orders;
    }


      static function searchOrders(PDO $db, string $search, int $id, int $count) : array {
        $stmt = $db->prepare('
          SELECT OrderId, Orders.RestaurantId, Orders.UserId, Orders.Total, Orders.Status, Orders.Date
          FROM Orders JOIN Restaurant USING (RestaurantId) 
          WHERE UserId = ? AND Restaurant.Name LIKE ? LIMIT ?
        ');
        $stmt->execute(array($id, $search . '%', $count));
    
        $orders = array();
        while ($order = $stmt->fetch()) {
          $orders[] = new Order(
            intval($order['OrderId']),
            intval($order['RestaurantId']),
            intval($order['UserId']),
            floatval($order['Total']),
            $order['Status'], 
            $order['Date']
          );
        }
    
        return $orders;
      }

      static function getOrder(PDO $db, int $id) {
        $stmt = $db->prepare('SELECT * FROM Orders WHERE OrderId = ?');
        $stmt->execute(array($id));
    
        $order = $stmt->fetch();
        if($order == false) return null;
    
        return new Order(
            intval($order['OrderId']),
            intval($order['RestaurantId']),
            intval($order['UserId']),
            floatval($order['Total']),
            $order['Status'], 
            $order['Date']
          );
      }
      static function getRestaurantOrders(PDO $db, int $id) : array {
        $stmt = $db->prepare('
          SELECT OrderId, Orders.RestaurantId, Orders.UserId, Orders.Total, Orders.Status, Orders.Date, Restaurant.Name
          FROM Orders JOIN Restaurant USING (RestaurantId) 
          WHERE RestaurantId = ?
        ');
        $stmt->execute(array($id));
    
        $orders = array();
        while ($order = $stmt->fetch()) {
          $orders[] = new Order(
            intval($order['OrderId']),
            intval($order['RestaurantId']),
            intval($order['UserId']),
            floatval($order['Total']),
            $order['Status'], 
            $order['Date'],
            $order['Name']
          );
        }
    
        return $orders;
      }

      function add(PDO $db) : int{
        $stmt = $db->prepare('
            INSERT INTO Orders (RestaurantId, UserId, Total, Status, Date)  VALUES
            (?, ?, ?, ?, ?)
          ');
    
        $stmt->execute(array($this->restaurant_id,$this->user_id,$this->total,$this->status,$this->date));
        return intval($db->lastInsertId());
      }
    
      function save(PDO $db) {
        $stmt = $db->prepare('UPDATE Orders SET Status = ? WHERE OrderId = ?');
    
        $stmt->execute(array($this->status, $this->id));
      }
    
      function remove(PDO $db) {
    
        $stmt = $db->prepare('DELETE FROM Orders WHERE OrderId = ?');
    
        $stmt->execute(array($this->id));
      }

    }