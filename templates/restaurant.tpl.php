<?php 
  declare(strict_types = 1); 

  require_once(__DIR__. '/../utils/session.php');
?>

<?php function drawRestaurants(array $restaurants) { ?>
 <!-- Draw Restaurant Icons on index.php -->
    <section class="Restaurant_header">
        <h2>Restaurants</h2>
        <section class="search-filters-restaurants">
          <i class="fa-solid fa-sliders filtericon"></i>
          <input id="searchrestaurant" placeholder="Search Restaurants" type="text" name="search">
          <i class='bx bx-search searchicon'></i>
        </section> 
    </section>
    <section id="restaurants">
<?php foreach ($restaurants as $restaurant) { ?>
    <article>
      <a href="../pages/restaurant.php?id=<?=$restaurant->id?>">
        <?php $restid = $restaurant->id;
          if(file_exists("../imgs/restaurants/small/$restid.jpg")) { ?>
            <img src="../imgs/restaurants/small/<?=$restaurant->id?>.jpg">
          <?php } else { ?>
            <img src="../imgs/restaurants/default.jpg">
          <?php } ?>
          </a>
          <a href="../pages/restaurant.php?id=<?=$restaurant->id?>"><?=$restaurant->name?></a>
    </article>
<?php } ?>
    </section>
<?php } ?>

<?php function drawRestaurantsProfile(array $restaurants) { ?>
 <!-- Draw Restaurant Icons on profile.php -->
    <section class="Restaurant_header">
        <h2>Your Restaurants</h2>
        <form>
            <button name="add" formaction="../pages/add_restaurant.php" formmethod="post">Add Restaurant</button>
        </form>
        <form class="searchrestaurant-profile" method="get">
            <input id="searchrestaurant-profile" placeholder="Search Restaurants" type="text" name="search">
            <i class='bx bx-search searchicon'></i>
        </form> 
    </section>
    <section id="restaurants">
<?php foreach ($restaurants as $restaurant) { ?>
    <article>
        <?php $restid = $restaurant->id;
          if(file_exists("../imgs/restaurants/small/$restid.jpg")) { ?>
            <img src="../imgs/restaurants/small/<?=$restaurant->id?>.jpg">
        <?php } else { ?>
          <img src="../imgs/restaurants/default.jpg">
        <?php } ?>
        <form>
            <input id="edit-id" type="text" name="edit-id" value="<?=$restaurant->id?>">
            <button name="edit" formaction="../pages/edit_restaurant.php" formmethod="post">Edit</button>
        </form>
        <a href="../pages/restaurant.php?id=<?=$restaurant->id?>"><?=$restaurant->name?></a>
    </article>
<?php } ?>
    </section>
<?php } ?>

<?php function drawFavoriteRestaurantsProfile(array $restaurants) { ?>
 <!-- Draw Restaurant Icons on profile.php -->
    <section class="Restaurant_header">
        <h2>Your Favorite Restaurants</h2> 
    </section>
    <section id="restaurants">
      <?php if($restaurants == NULL) { ?>
        <p>You haven't favorited any restaurants!</p>
      <?php } ?>
      <?php foreach ($restaurants as $restaurant) { ?>
    <article>
        <?php $restid = $restaurant->id;
        if(file_exists("../imgs/restaurants/small/$restid.jpg")) { ?>
          <img src="../imgs/restaurants/small/<?=$restaurant->id?>.jpg">
        <?php } else { ?>
          <img src="../imgs/restaurants/default.jpg">
        <?php } ?>
        <form>
            <input id="remove-id" type="text" name="remove-id" value="<?=$restaurant->id?>">
            <button name="remove" formaction="../actions/action_remove_fav_restaurant.php" formmethod="post">Remove</button>
        </form>
        <a href="../pages/restaurant.php?id=<?=$restaurant->id?>"><?=$restaurant->name?></a>
    </article>
  <?php } ?>
    </section>
<?php } ?>

<?php function drawRestaurant(Restaurant $restaurant) { ?>
 <!-- Draw Main on Restaurant.php -->
 <article>
    <img src="../imgs/restaurants/small/<?=$restaurant->id?>.jpg">
    <a href="../pages/restaurant.php?id=<?=$restaurant->id?>"><?=$restaurant->name?></a>
</article>
<?php } ?>

<?php function drawRestaurant_Name(Restaurant $restaurant)
{ ?> <!-- Draw Name on dish.php -->
  <h2 id="restaurant_name"><a href="../pages/restaurant.php?id=<?=$restaurant->id?>"><?=$restaurant->name?></a></h2>
<?php } ?>

<?php function drawRestaurant_Info(Restaurant $restaurant, Session $session, ?bool $isfav = false)
{ ?> <!-- Draw Restaurant Info on Restaurant.php -->
<?php 
    switch($restaurant->avg_price) {
        case $restaurant->avg_price <= 10:
            $euros = '€';
            break;
        case $restaurant->avg_price >= 10 && $restaurant->avg_price <= 30:
            $euros = '€€';
            break;
        case $restaurant->avg_price >= 30 && $restaurant->avg_price <= 50:
            $euros = '€€€';
            break;
        case $restaurant->avg_price >= 50 && $restaurant->avg_price <= 100:
            $euros = '€€€€';
            break;
        default:
            break;
    }

?>
    <?php if ($isfav == true) { ?>
        <section class="Rest_header active">
    <?php } else { ?>
        <section class="Rest_header">
        <?php } ?>  
        <h2><?= $restaurant->name ?></h2>
        <?php if ($session->isLoggedIn() && $session->getUsertype() == 0) { ?>
          <a href="../actions/action_fav_rest.php"><i class='bx bxs-heart' ></i></a>
          <a id="make-reservation" href="../pages/make_reservation.php">Make a Reservation</a>
        <?php } ?> 
    </section>
        <article id="Rest_info"> <!-- Draw Restaurant Map using Google Maps' API; maybe add a desprition -->
            <?php $restid = $restaurant->id;
            if(file_exists("../imgs/restaurants/medium/$restid.jpg")) { ?>
              <img src="../imgs/restaurants/medium/<?=$restaurant->id?>.jpg">
            <?php } else { ?>
              <img src="../imgs/restaurants/default.jpg">
            <?php } ?>
            <p id="Adress">Address: <?= $restaurant->address ?></p>
            <p id="Price">Price: <?= $euros ?></p> <!-- Uses a function to calculate the average price of a restaurant's dishes -->
            <p id="Category">Category: <?= $restaurant->category?></p>
        </article>
    </section>
<?php } ?>


<?php function drawEditRestaurant(Restaurant $restaurant)
{?>

  <section class="user-edit-restaurant">
    <h1>Edit Restaurant</h1>
    <?php if(file_exists("../imgs/restaurants/medium/$restaurant->id.jpg")) { ?>
      <img src="../imgs/restaurants/medium/<?= $restaurant->id ?>.jpg">
    <?php } else { ?>
      <img src="../imgs/restaurants/default.jpg">
    <?php } ?>
    <form action="../actions/action_upload_img_restaurant.php" method="post" enctype="multipart/form-data">
      <input type="file" name="image">
      <input id="upload" type="submit" value="Upload Photo">
    </form>  
    <form>
      <label for="name">
        Name: <input type="text" id="name" name="name" value="<?=$restaurant->name?>">
      </label>
      <label for="PhoneNumber">
        Address: <input type="text" id="address" name="address" value="<?= $restaurant->address?>">
      </label>
        <label for="Address">
          Category: <input type="text" id="category" name="category" value="<?= $restaurant->category ?>">
        </label>
      <button formaction="../actions/action_edit_restaurant.php" formmethod="post">Save</button>
      <a id="remove-restaurant-btn">Remove Restaurant</a>
    </form>
  </section>

<?php } ?>

<?php function drawAddRestaurant()
{?>

  <section class="user-add-restaurant">
    <h1>Add a New Restaurant</h1>
    <form>
      <label for="name">
        Name: <input type="text" id="name" name="name" placeholder="Your restaurant's name">
      </label>
      <label for="address">
        Address: <input type="text" id="address" name="address" placeholder="Your restaurant's address">
      </label>
        <label for="category">
          Category: <input type="text" id="category" name="category" placeholder="Your restaurant's category">
        </label>
      <button formaction="../actions/action_add_restaurant.php" formmethod="post">Submit</button>
    </form>
  </section>

<?php } ?>

<?php function drawAddRestaurantUpload(?int $id)
{?>
  <section class="user-add-restaurant">
    <h1>Add a New Restaurant</h1>
    <?php if(file_exists("../imgs/restaurants/medium/$id.jpg")) { ?>
      <img src="../imgs/restaurants/medium/<?= $id ?>.jpg">
    <?php } else { ?>
      <img src="../imgs/restaurants/default.jpg">
    <?php } ?>
    <form action="../actions/action_upload_img_restaurant.php" method="post" enctype="multipart/form-data">
      <input type="file" name="image">
      <input id="upload" type="submit" value="Upload Photo">
    </form>
    <?php if(file_exists("../imgs/restaurants/medium/$id.jpg")) { ?>
      <a id="go-back" href="../pages/profile.php">Go Back</a>
    <?php } ?>
  </section>

<?php } ?>


<?php function drawRemoveRestaurantForm() { ?>

<section class="container" id="popup-remove-restaurant">
<span class="overlay"></span>
  <section class=content id="remove-restaurant">
    <a id="close-remove-btn">Close</a>
    <h1>Are you sure you want to remove this restaurant?</h1>
    <p>This action is irreversible.</p>
    <section class="remove">
    <form>
      <a id="remove-cancel">Cancel</a>
      <button id="remove-submit" formaction="../actions/action_remove_restaurant.php" formmethod="post">Remove</button>
    </form>
    </section>
  </section>
</section>

<?php } ?>