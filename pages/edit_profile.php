<?php
    declare(strict_types = 1);

    require_once(__DIR__. '/../utils/session.php');
    $session = new Session();

    if (!$session->isLoggedIn()) { 
        $session->addMessage('warning', 'You need to be logged in to perform this action!');
        die(header("Location: /"));         // redirect to the index page
    }

    $session->setPage('edit_profile.php');


    require_once(__DIR__. '/../database/connection.db.php');
    require_once(__DIR__. '/../database/user.class.php');
    require_once(__DIR__. '/../database/owner.class.php');

    require_once(__DIR__. '/../templates/common.tpl.php');
    require_once(__DIR__. '/../templates/profile.tpl.php');

    $db = getDatabaseConnection();
    if ($session->getUsertype() === 0)
        $user = User::getUser($db, $session->getId());
    else $owner = Owner::getOwner($db, $session->getId());

    drawHeader($session);

    if ($user)
        drawEditProfile($user, $session);
    else if ($owner)
        drawEditProfile($owner, $session);

    drawFooter();

?>