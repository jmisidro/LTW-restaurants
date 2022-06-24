<?php
declare(strict_types = 1);

require_once(__DIR__. '/../utils/session.php');
$session = new Session();

require_once(__DIR__. '/../database/connection.db.php');
require_once(__DIR__. '/../database/restaurant.class.php');

require_once(__DIR__. '/../templates/common.tpl.php');
require_once(__DIR__. '/../templates/restaurant.tpl.php');

$db = getDatabaseConnection();
$restaurants = Restaurant::getRestaurants($db,15);
$categories = Restaurant::getRestaurantsCategories($db);

drawHeader($session);
drawRestaurants($restaurants);
drawLoginForm();
drawRegisterForm();
drawFiltersForm($session, $categories);
drawFooter();

?>