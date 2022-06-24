<?php 
  declare(strict_types = 1); 

  require_once(__DIR__. '/../utils/session.php');
  require_once(__DIR__. '/../database/favorites.db.php');
?>

<?php function drawDishes(array $dishes, Session $session)
{ ?>
  <section class="Dishes_header">
    <h2>Dishes</h2>
    <section class="search-filters-dishes">
        <input id="searchdish" placeholder="Search Dishes" type="text" name="search">
        <i class='bx bx-search searchicon'></i>
    </section> 
  </section>
  <section id="dishes">
  <?php foreach ($dishes as $dish) { ?>
    <article>
      <a href="../pages/dish.php?id=<?= $dish->id ?>">
        <img class="shop-item-image" src="../imgs/dishes/small/<?= $dish->id ?>.jpg">
      </a>
      <p class="shop-item-price"><?= $dish->price ?>€</p>
      <a class="shop-item-name" href="../pages/dish.php?id=<?= $dish->id ?>"><?= $dish->name ?></a>
      <?php if ($session->isLoggedIn() && $session->getUsertype() == 0) { ?>
        <a class="shop-item-button" id="<?= $dish->id ?>">Add to Cart</a>
      <?php } ?> 
    </article>
  <?php } ?>
  </section>

<?php } ?>

<?php function drawDish(PDO $db, Dish $dish, Session $session)
{ ?>
  <section id="Restaurant_Dish">
    <img src="../imgs/dishes/medium/<?= $dish->id ?>.jpg">
    <p id="Name"><?= $dish->name ?></p>
  </section>
  <article id="Dish_info">
    <?php if ($session->isLoggedIn() && $session->getUsertype() == 0) { ?>
      <article id="Dish_info_buttons">
      <a class="shop-item-button" id="<?= $dish->id ?>">Add to Cart</a>
      <?php if(!isFavDish($db, $session->getId(), $session->getDishId())) { ?>
      <a href="../actions/action_fav_dish.php" class="favorite-item-button" id="<?= $dish->id ?>">Add to Favorites</a>
      </article>
      <?php }else{ ?> 
        <a href="../actions/action_remove_fav_dish.php" class="favorite-remove-item-button" id="<?= $dish->id ?>">Remove from Favorites</a>
        <?php }?>
    <?php } ?> 
    <h3>Descrição:</h3>
    <p id="Description"><?= $dish->description ?></p>
    <p id="Price">Preço: <?= $dish->price ?>€</p>
    <p id="Category">Categoria: <?= $dish->category ?></p>
  </article>

<?php } ?>


<?php function drawDishesEditRestaurant(array $dishes) { ?>
 <!-- Draw Restaurant Icons on profile.php -->
    <section class="Dishes_header">
        <h2>Your Restaurant's Dishes</h2>
        <form>
            <button name="add" formaction="../pages/add_dish.php" formmethod="post">Add Dish</button>
        </form>
        <form class="searchdish-profile" method="get">
            <input id="searchdish-profile" placeholder="Search Dishes" type="text" name="search">
            <i class='bx bx-search searchicon'></i>
        </form> 
    </section>
    <section id="dishes-edit">
<?php foreach ($dishes as $dish) { ?>
    <article>
    <?php $id = $dish->id;
    if(file_exists("../imgs/dishes/originals/$id.jpg")) { ?>
        <img src="../imgs/dishes/originals/<?=$id?>.jpg" width="300" height="300">
    <?php } else { ?>
      <img src="../imgs/dishes/default.jpg">
    <?php } ?>
        <form>
            <input id="edit-id" type="text" name="edit-id" value="<?=$dish->id?>">
            <button name="edit" formaction="../pages/edit_dish.php" formmethod="post">Edit</button>
        </form>
        <a href="../pages/dish.php?id=<?=$dish->id?>"><?=$dish->name?></a>
    </article>
<?php } ?>
</section>
<?php } ?>

<?php function drawEditDish(Dish $dish)
{?>

  <section class="user-edit-dish">
    <h1>Edit Dish</h1>
    <?php if(file_exists("../imgs/dishes/medium/$dish->id.jpg")) { ?>
      <img src="../imgs/dishes/medium/<?= $dish->id ?>.jpg">
    <?php } else { ?>
      <img src="../imgs/dishes/default.jpg">
    <?php } ?>
    <form action="../actions/action_upload_img_dish.php" method="post" enctype="multipart/form-data">
      <input type="file" name="image">
      <input id="upload" type="submit" value="Upload Photo">
    </form>  
    <form>
      <label for="name">
        Name: <input type="text" id="name" name="name" value="<?=$dish->name?>">
      </label>
      <label for="description">
        Description: <input type="text" id="description" name="description" value="<?= $dish->description?>">
      </label>
      <label for="price">
        Price: <input type="text" id="price" name="price" value="<?= $dish->price?>">
      </label>
      <label for="category">
        Category: <input type="text" id="category" name="category" value="<?= $dish->category?>">
      </label>
      <button formaction="../actions/action_edit_dish.php" formmethod="post">Save</button>
      <a id="remove-dish-btn">Remove Dish</a>
    </form>
  </section>


<?php } ?>


<?php function drawAddDish()
{?>

  <section class="user-add-dish">
    <h1>Add a New Dish</h1>
    <form>
      <label for="name">
        Name: <input type="text" id="name" name="name" placeholder="Your dish's name">
      </label>
      <label for="description">
        Description: <input type="text" id="description" name="description" placeholder="Your dish's description">
      </label>
      <label for="price">
        Price: <input type="text" id="price" name="price" placeholder="Your dish's price">
      </label>
      <label for="category">
        Category: <input type="text" id="category" name="category" placeholder="Your dish's category">
      </label>
      <button formaction="../actions/action_add_dish.php" formmethod="post">Submit</button>
    </form>
  </section>

<?php } ?>

<?php function drawAddDishUpload(?int $id)
{?>
  <section class="user-add-dish">
    <h1>Add a New Dish</h1>
    <?php if(file_exists("../imgs/dishes/medium/$id.jpg")) { ?>
      <img src="../imgs/dishes/medium/<?= $id ?>.jpg">
    <?php } else { ?>
      <img src="../imgs/dishes/default.jpg">
    <?php } ?>
    <form action="../actions/action_upload_img_dish.php" method="post" enctype="multipart/form-data">
      <input type="file" name="image">
      <input id="upload" type="submit" value="Upload Photo">
    </form>
    <?php if(file_exists("../imgs/dishes/medium/$id.jpg")) { ?>
      <a id="go-back" href="../pages/profile.php">Go Back</a>
    <?php } ?>
  </section>

<?php } ?>


<?php function drawRemoveDishForm() { ?>

<section class="container" id="popup-remove-dish">
<span class="overlay"></span>
  <section class=content id="remove-dish">
    <a id="close-remove-btn">Close</a>
    <h1>Are you sure you want to remove this dish?</h1>
    <p>This action is irreversible.</p>
    <section class="remove">
    <form>
      <a id="remove-cancel">Cancel</a>
      <button id="remove-submit" formaction="../actions/action_remove_dish.php" formmethod="post">Remove</button>
    </form>
    </section>
  </section>
</section>
<?php } ?>

<?php function drawFavoriteDishesProfile(array $dishes) { ?>
 <!-- Draw Favorite dishes Icons on profile.php -->
    <section class="Dish_header">
        <h2>Your Favorite Dishes</h2> 
    </section>
    <section id="dishes" class="dishes_profile">
      <?php if($dishes == NULL) { ?>
        <p>You haven't favorited any dishes!</p>
      <?php } ?>
      <?php foreach ($dishes as $dish) { ?>
    <article>
        <?php $restid = $dish->id;
        if(file_exists("../imgs/dishes/originals/$restid.jpg")) { ?>
          <img src="../imgs/dishes/originals/<?=$dish->id?>.jpg" height="300" width="300">
        <?php } else { ?>
          <img src="../imgs/dishes/default.jpg">
        <?php } ?>
        <form>
            <input id="remove-id" type="text" name="remove-id" value="<?=$dish->id?>">
            <button name="remove" class='favorite-remove-item-profile-button' formaction="../actions/action_remove_fav_dish.php" formmethod="post">Remove</button>
        </form>
        <a href="../pages/dish.php?id=<?=$dish->id?>"><?=$dish->name?></a>
    </article>
  <?php } ?>
    </section>
<?php } ?>

