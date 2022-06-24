<?php
  declare(strict_types = 1);

  require_once(__DIR__. '/../utils/session.php');
  $session = new Session();
  
  if($session->getUsertype() === 1 && $session->isOwner())
    $session->setUsertype(0);
  
  else if($session->getUsertype() === 0 && $session->isOwner())
    $session->setUsertype(1);

  header('Location: ' . $_SERVER['HTTP_REFERER']);
?>