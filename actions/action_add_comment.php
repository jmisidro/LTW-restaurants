<?php
  
  declare(strict_types = 1);

  require_once(__DIR__. '/../utils/session.php');
  $session = new Session();
  if (!$session->isLoggedIn()) { 
    $session->addMessage('warning', 'You need to be logged in to perform this action!');
    die(header("Location: /"));         // redirect to the index page
  }

  require_once(__DIR__. '/../database/connection.db.php');
  require_once(__DIR__. '/../database/review.class.php');
  
  $db = getDatabaseConnection();


  addComment($db, intval($_POST['add-comment-id']), $session->getId(), $_POST['comment'], date('Y/m/d'));
  
  $session->addMessage('info', 'Comment added.');
  header('Location: ' . $_SERVER['HTTP_REFERER']);

?>