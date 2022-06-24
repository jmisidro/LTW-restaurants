<?php
  declare(strict_types = 1);

  require_once(__DIR__. '/../utils/session.php');
  $session = new Session();

  $json = file_get_contents('php://input');
  $dishid = json_decode($json, true);
  
  $session->removeCartitem($dishid);
?>