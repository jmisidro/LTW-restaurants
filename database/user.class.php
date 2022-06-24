<?php

declare(strict_types=1);

require_once(__DIR__. '/../database/dish.class.php');

class User
{
    public ?int $id;
    public ?string $name;
    public ?string $phonenumber;
    public ?string $address;
    public string $username;
    public string $email;
    public string $password;

    public function __construct(?int $id, ?string $name, ?string $phonenumber, ?string $address, string $username, string $email, string $password)
    {
        $this->id = $id;
        $this->name = $name;
        $this->phonenumber = $phonenumber;
        $this->address = $address;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
    }



    static function Exists(PDO $db, string $username, string $email) : bool {
        $stmt = $db->prepare('SELECT * FROM User WHERE lower(username) = ? OR lower(email) = ?');
    
        $stmt->execute(array(strtolower($username), strtolower($email)));
    
        if ($user = $stmt->fetch()) {
            return true;
        }
        return false;
      }
    
      static function Login(PDO $db, string $username, string $password) {
        $stmt = $db->prepare('SELECT * FROM User WHERE lower(username) = ?');
    
        $stmt->execute(array(strtolower($username)));
    
        if ($user = $stmt->fetch()) {
          if ($user && password_verify($password, $user['Password'])) {
            return new User(
                intval($user['UserId']),
                $user['Name'], 
                $user['PhoneNumber'],
                $user['Address'],
                $user['Username'],
                $user['Email'],
                $user['Password']
                );
          }
        }
        return null;
      }
    
      
      static function getUser(PDO $db, int $id) {
        $stmt = $db->prepare('SELECT * FROM User WHERE UserId = ?');
        $stmt->execute(array($id));
    
        $user = $stmt->fetch();
        return new User(
          intval($user['UserId']),
          $user['Name'], 
          $user['PhoneNumber'],
          $user['Address'],
          $user['Username'],
          $user['Email'],
          $user['Password']
          );
      }
    
      function isInfoComplete() : bool { 
          if(!empty($this->name) && !empty($this->phonenumber) && !empty($this->address))
            return true;

        return false;
      }
    
      function save(PDO $db) {
        $stmt = $db->prepare('
          UPDATE User SET Name = ?, PhoneNumber = ?, Address = ?
          WHERE UserId = ?
        ');
    
        $stmt->execute(array($this->name, $this->phonenumber, $this->address, $this->id));
      }

      function add(PDO $db) : int {
        $options = ['cost' => 12];
        $stmt = $db->prepare('
            INSERT INTO User (Username, Email, Password) VALUES
            (?, ?, ?)
          ');
    
        $stmt->execute(array(strtolower($this->username), strtolower($this->email), password_hash($this->password, PASSWORD_DEFAULT, $options)));
    
        return intval($db->lastInsertId());
      }


}
