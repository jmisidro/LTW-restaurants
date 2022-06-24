<?php
  require_once(__DIR__. '/../utils/session.php');
  $session = new Session();                                      // starts the session

  require_once(__DIR__. '/../database/connection.db.php');                 // database connection
  require_once(__DIR__. '/../database/user.class.php');                      // user table queries
  require_once(__DIR__. '/../database/owner.class.php');   

  $db = getDatabaseConnection();

  $user = User::Login($db, $_POST['username'], $_POST['password']);
  $owner = Owner::Login($db, $_POST['username'], $_POST['password']);

  if ($owner) { // test if owner exists
    $session->setId($owner->id);                // store the user id
    $session->setUsername($owner->username);    // store the username
    $session->setUsertype(1);                     // store the user type (0 for customer, 1 for restaurant owner)
  }
  else if ($user && !$owner) { // test if user exists and owner doesn't
    $session->setId($user->id);                 // store the user id
    $session->setUsername($user->username);     // store the username
    $session->setUsertype(0);                     // store the user type (0 for customer, 1 for restaurant owner)
  }
  else {
    $session->addMessage('error', 'Wrong password!');
  }

  header('Location: ' . $_SERVER['HTTP_REFERER']);         // redirect to the page we came from
?>