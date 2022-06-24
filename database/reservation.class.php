<?php

declare(strict_types=1);

require_once(__DIR__. '/../database/connection.db.php');
require_once(__DIR__. '/../database/restaurant.class.php');

class Reservation
{
    public ?int $id;
    public int $user_id;
    public int $restaurant_id;
    public int $quantity;
    public string $status;
    public string $datetime;
    public string $restaurant_name;


    public function __construct(?int $id, int $userid, int $restaurantid, int $quantity, string $status, string $datetime)
    {
        $this->id = $id;
        $this->user_id = $userid;
        $this->restaurant_id = $restaurantid;
        $this->quantity = $quantity;
        $this->status = $status;
        $this->datetime = $datetime;

        $db = getDatabaseConnection();
        $restaurant = Restaurant::getRestaurant($db, $this->restaurant_id);
        $this->restaurant_name = $restaurant->name;
    }


    static function getReservations(PDO $db, int $id, int $count) : array {
      $stmt = $db->prepare('SELECT * FROM Reservation WHERE UserId = ? LIMIT ?');
      $stmt->execute(array($id, $count));
  
      $reservations = array();
      while ($reservation = $stmt->fetch()) {
        $reservations[] = new Reservation(
          intval($reservation['ReservationId']),
          intval($reservation['UserId']),
          intval($reservation['RestaurantId']),
          intval($reservation['Quantity']),
          $reservation['Status'],
          $reservation['Datetime']
        );
      }
    
      return $reservations;
    }

    static function searchReservations(PDO $db, string $search, int $id, int $count) : array {
      $stmt = $db->prepare('
        SELECT ReservationId, Reservation.UserId, Reservation.RestaurantId, Reservation.Quantity, Reservation.Status, Reservation.Datetime
        FROM Reservation JOIN Restaurant USING (RestaurantId) 
        WHERE UserId = ? AND Restaurant.Name LIKE ? LIMIT ?
      ');
      $stmt->execute(array($id, $search . '%', $count));
  
      $reservations = array();
      while ($reservation = $stmt->fetch()) {
        $reservations[] = new Reservation(
          intval($reservation['ReservationId']),
          intval($reservation['UserId']),
          intval($reservation['RestaurantId']),
          intval($reservation['Quantity']),
          $reservation['Status'],
          $reservation['Datetime']
        );
      }
  
      return $reservations;
    }

    static function getRestaurantReservations(PDO $db, int $id) : array {
      $stmt = $db->prepare('
        SELECT ReservationId, Reservation.UserId, Reservation.RestaurantId, Reservation.Quantity, Reservation.Status, Reservation.Datetime, Restaurant.Name
        FROM Reservation JOIN Restaurant USING (RestaurantId) 
        WHERE RestaurantId = ?
      ');
      $stmt->execute(array($id));
  
      $reservations = array();
      while ($reservation = $stmt->fetch()) {
        $reservations[] = new Reservation(
          intval($reservation['ReservationId']),
          intval($reservation['UserId']),
          intval($reservation['RestaurantId']),
          intval($reservation['Quantity']),
          $reservation['Status'],
          $reservation['Datetime']
        );
      }
  
      return $reservations;
    }

      static function getReservation(PDO $db, int $id) : Reservation {
        $stmt = $db->prepare('SELECT * FROM Reservation WHERE ReservationId = ?');
        $stmt->execute(array($id));
    
        $reservation = $stmt->fetch();
    
        return new Reservation(
            intval($reservation['ReservationId']),
            intval($reservation['UserId']),
            intval($reservation['RestaurantId']),
            intval($reservation['Quantity']),
            $reservation['Status'],
            $reservation['Datetime']
          );
      }
      

      function add(PDO $db) : int{
        $stmt = $db->prepare('
            INSERT INTO Reservation (UserId, RestaurantId, Quantity, Status, Datetime)  VALUES
            (?, ?, ?, ?, ?)
          ');
    
        $stmt->execute(array($this->user_id,$this->restaurant_id,$this->quantity,$this->status,$this->datetime));
        return intval($db->lastInsertId());
      }
    
      function save(PDO $db) {
        $stmt = $db->prepare('UPDATE Reservation SET Status = ? WHERE ReservationId = ?');
    
        $stmt->execute(array($this->status, $this->id));
      }
    
      function remove(PDO $db) {
    
        $stmt = $db->prepare('DELETE FROM Reservation WHERE ReservationId = ?');
    
        $stmt->execute(array($this->id));
      }

    }