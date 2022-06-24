<?php
declare(strict_types = 1);

require_once(__DIR__. '/../utils/session.php');
$session = new Session();

if (!$session->isLoggedIn()) { 
    $session->addMessage('warning', 'You need to be logged in to perform this action!');
    die(header("Location: /"));         // redirect to the index page
}


require_once(__DIR__. '/../database/connection.db.php');
require_once(__DIR__. '/../database/favorites.db.php');

$db = getDatabaseConnection();
if($_POST['remove-id']){
removeFavDish($db, $session->getId(), intval($_POST['remove-id']));
}
else{
    removeFavDish($db, $session->getId(), $session->getDishId());
}
$session->addMessage('info', 'You have removed this dish from your favorites.');
header('Location: ' . $_SERVER['HTTP_REFERER']);

?>