<?php

declare(strict_types=1);

require_once(__DIR__. '/../database/dish.class.php');

class Review
{
    public ?int $id;
    public int $restaurant_id;
    public int $user_id;
    public int $rating;
    public string $comment;
    public string $date;




    public function __construct(?int $id, int $restaurant_id, int $user_id, int $rating, string $comment, string $date)
    {
        $this->id = $id;
        $this->restaurant_id = $restaurant_id;
        $this->user_id = $user_id;
        $this->rating = $rating;
        $this->comment = $comment;

        $this->date = $date;
    }

    static function getReviews(PDO $db, int $RestaurantId, int $count) : array {
        $stmt = $db->prepare('SELECT * FROM Review WHERE RestaurantId = ? LIMIT ?');
        $stmt->execute(array($RestaurantId,$count));


        $reviews = array();
        while ($review = $stmt->fetch()) {

             $date_time = strtotime($review['Date']);
             $date = date('Y-m-d', $date_time);

            $reviews[] =  new Review(
                intval($review['ReviewId']),
                intval($review['RestaurantId']),
                intval($review['UserId']),
                intval($review['Rating']),
                $review['Comment'],
                $date
            );
        }
        return $reviews;
    }

  function add(PDO $db){

    $stmt = $db->prepare('
        INSERT INTO Review (RestaurantId, UserId, Rating, Comment, Date) VALUES
        (?, ?, ?, ?, ?)
      ');

    $stmt->execute(array($this->restaurant_id, $this->user_id, $this->rating, $this->comment, $this->date /*date('Y/m/d')*/));
  }

  function getReview(PDO $db, int $id){
    $stmt = $db->prepare('SELECT * FROM Review WHERE ReviewId = ?');
    
    $stmt->execute(array($id));

    $review = $stmt->fetch();
    
    $date_time = strtotime($review['Date']);
    $date = date('Y-m-d', $date_time);

    return new Review(
        intval($review['ReviewId']),
        intval($review['RestaurantId']),
        intval($review['UserId']),
        intval($review['Rating']),
        $review['Comment'],
        $date
    );
  }

  function remove(PDO $db, int $id){

    $stmt = $db->prepare('
    DELETE FROM Review WHERE ReviewId = ?');
    
    $stmt->execute(array($id));
  }

  function editReview(PDO $db){
    $stmt = $db->prepare('
          UPDATE Review SET Rating = ?, Comment = ?, Date = ?
          WHERE ReviewId = ?
        ');
    
    $stmt->execute(array($this->rating,$this->comment,$this->date, $this->id));
  }
    
/*     function save(PDO $db)
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
    } */

}


function getComments(PDO $db, int $id) : array{
  $stmt = $db->prepare('SELECT * FROM ReviewComments WHERE RestaurantId = ?');
  $stmt->execute(array($id));


  $comments = array();
  while ($comment = $stmt->fetch()) {
      
    $date_time = strtotime($comment['date']);
    $date = date('Y-m-d', $date_time);

    $comments[] = array(
        'CommentId' => $comment['CommentId'],
        'ReviewId' => $comment['ReviewId'],
        'RestaurantId' => $comment['RestaurantId'],
        'Comment' => $comment['Comment'],
        'date' => $date
    );
  }
  return $comments;
}

function addComment(PDO $db, int $ReviewId, int $RestaurantId, string $comment, string $date){
  $stmt = $db->prepare('
  INSERT INTO ReviewComments (ReviewId, RestaurantId, Comment, Date) VALUES
  (?, ?, ?, ?)');
  $stmt->execute(array($ReviewId,$RestaurantId,$comment, $date));
}