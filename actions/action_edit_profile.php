<?php
  require_once(__DIR__. '/../utils/session.php');
  $session = new Session();                                      // starts the session

  if (!$session->isLoggedIn()) { 
    $session->addMessage('warning', 'You need to be logged in to perform this action!');
    die(header("Location: /"));         // redirect to the index page
  }

  function is_phone_number($element) {
    return preg_match ('/^\d{9}|\d{3}-\d{3}-\d{3}$/', $element);
}

  require_once(__DIR__. '/../database/connection.db.php');
  require_once(__DIR__. '/../database/user.class.php');
  require_once(__DIR__. '/../database/owner.class.php');

  require_once(__DIR__. '/../templates/common.tpl.php');
  require_once(__DIR__. '/../templates/profile.tpl.php');

  $db = getDatabaseConnection();
  if ($session->getUsertype() === 0)
    $user = User::getUser($db, $session->getId());
  else if ($session->getUsertype() === 1) 
    $owner = Owner::getOwner($db, $session->getId());

  if ($user) { // test if user exists
    if(is_phone_number($_POST['PhoneNumber'])) {
      $phoneNumber = preg_replace('/[^\w\d\s\.!,\?]/', '', $_POST['PhoneNumber']);
      $user->name = $_POST['name'];
      $user->phonenumber = $phoneNumber;
      $user->address = $_POST['Address'];
      $user->save($db);
      $session->addMessage('info', 'You updated your information successfully.');
    }
    else {
      $session->addMessage('warning', 'The phone number you introduced is not valid.');
    }
  }
  else if ($owner) { // test if owner exists
    if(is_phone_number($_POST['PhoneNumber'])) {
      $phoneNumber = preg_replace('/[^\w\d\s\.!,\?]/', '', $_POST['PhoneNumber']);

      $user = User::getUser($db,$session->getId());
      $user->name = $_POST['name'];
      $user->phonenumber = $phoneNumber;
      $user->save($db);
      $owner->name = $_POST['name'];
      $owner->phonenumber = $phoneNumber;
      $owner->save($db);

      $session->addMessage('info', 'You updated your information successfully.');
    }
    else {
      $session->addMessage('warning', 'The phone number you introduced is not valid.');
    }
  }
  else {
    $session->addMessage('warning', 'An error occured while editing your information.');
  }

  header("Location: ../pages/profile.php");          // redirect to the profile page
?>