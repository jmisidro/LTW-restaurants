<?php

declare(strict_types=1);

require_once(__DIR__. '/../database/dish.class.php');

class Owner
{
    public ?int $id;
    public ?string $name;
    public ?string $phonenumber;
    public string $username;
    public string $email;
    public string $password;

    public function __construct(?int $id, ?string $name, ?string $phonenumber, string $username, string $email, string $password)
    {
        $this->id = $id;
        $this->name = $name;
        $this->phonenumber = $phonenumber;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
    }


    static function Exists(PDO $db, string $username, string $email): bool
    {
        $stmt = $db->prepare('SELECT * FROM Owner WHERE lower(username) = ? OR lower(email)= ?');

        $stmt->execute(array(strtolower($username), strtolower($email)));

        if ($owner = $stmt->fetch()) {
            return true;
        }
        return false;
    }


    static function login(PDO $db, string $username, string $password)
    {
        $stmt = $db->prepare('SELECT * FROM Owner WHERE lower(username) = ?');

        $stmt->execute(array(strtolower($username)));

        if ($owner = $stmt->fetch()) {
            if ($owner && password_verify($password, $owner['Password'])) {
                return new Owner(
                    intval($owner['OwnerId']),
                    $owner['Name'],
                    $owner['PhoneNumber'],
                    $owner['Username'],
                    $owner['Email'],
                    $owner['Password']
                );
            }
        }

        return null;
    }

    static function getOwner(PDO $db, int $id) : Owner {
        $stmt = $db->prepare('SELECT * FROM Owner WHERE OwnerId = ?');
        $stmt->execute(array(strval($id)));
    
        $owner = $stmt->fetch();
        
        return new Owner(
            intval($owner['OwnerId']),
            $owner['Name'],
            $owner['PhoneNumber'],
            $owner['Username'],
            $owner['Email'],
            $owner['Password']
        );

      } 


    function add(PDO $db) //registar
    {
        $options = ['cost' => 12];
        $stmt = $db->prepare('
            INSERT INTO Owner (OwnerId, Username, Email, Password) VALUES
            (?, ?, ?, ?)
          ');

        $stmt->execute(array($this->id, strtolower($this->username), strtolower($this->email), password_hash($this->password, PASSWORD_DEFAULT, $options)));
    }


    function save(PDO $db) {
        $stmt = $db->prepare('
          UPDATE Owner SET Name = ?, PhoneNumber = ?
          WHERE OwnerId = ?
        ');
    
        $stmt->execute(array($this->name, $this->phonenumber, $this->id));
      }

}
