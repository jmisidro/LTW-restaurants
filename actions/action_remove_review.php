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
    
    $review = Review::getReview($db, intval($_POST['edit-id']));

    if ($session->getId() !== intval($review->userId)) {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }

    $session->addMessage('info', 'You have removed this review successfully.');

    $review->remove($db, $review->id);

    header('Location: ' . $_SERVER['HTTP_REFERER']);
?>