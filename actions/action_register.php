<?php
  require_once(__DIR__. '/../utils/session.php');
  $session = new Session();                                         // starts the session

  require_once(__DIR__. '/../database/connection.db.php');                 // database connection
  require_once(__DIR__. '/../database/user.class.php');                      // user table queries
  require_once(__DIR__. '/../database/owner.class.php');                      // user table queries

  $db = getDatabaseConnection();

  if (User::Exists($db, $_POST['username'], $_POST['email']) || Owner::Exists($db, $_POST['username'], $_POST['email'])) {    // user || owner already exists
    $session->addMessage('error', 'This username or email is already registered!');
    header('Location: ' . $_SERVER['HTTP_REFERER']);         // redirect to the page we came from
  }
  else {
    if ($_POST['account_type'] == 'Customer') // checks the select form
    {
        // Register
        $new_user = new User(null,null,null,null,$_POST['username'], $_POST['email'], $_POST['password']);
        $new_user->add($db);
        // Login
        $user = User::Login($db, $_POST['username'], $_POST['password']);

        if ($user)  { // test if user exists
          $session->setId($user->id);                 // store the user id
          $session->setUsername($user->username);     // store the username
          $session->setUsertype(0);                     // store the user type (0 for customer, 1 for restaurant owner)
        }
    }
    else if ($_POST['account_type'] == 'Owner') // checks the select form
    {
      // Register
      $new_user = new User(null,null,null,null,$_POST['username'], $_POST['email'], $_POST['password']);
      $new_user->id;
      $newid = $new_user->add($db);

      $new_owner = new Owner($new_user->id,null,null,$_POST['username'], $_POST['email'], $_POST['password']);
      $newid = $new_owner->add($db);

      // Login
      $owner = Owner::Login($db, $_POST['username'], $_POST['password']);

      if ($owner) {  // test if owner exists
        $session->setId($owner->id);                // store the user id
        $session->setUsername($owner->username);    // store the username
        $session->setUsertype(1);                     // store the user type (0 for customer, 1 for restaurant owner)
      }
    }

    header('Location: ' . $_SERVER['HTTP_REFERER']);         // redirect to the page we came from
  }

?>