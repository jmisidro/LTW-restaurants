<?php 
  declare(strict_types = 1); 

  require_once(__DIR__. '/../utils/session.php');
?>

<?php function drawHeader(Session $session) { ?>
<!DOCTYPE html>
<html lang="en-US">
  <head>
    <title>Restaraunt Picker</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/style.css">
    <link rel="stylesheet" href="../styles/forms.css">
    <link rel="stylesheet" href="../styles/review.css">
    <link rel="stylesheet" href="../styles/popups.css">
    <link rel="stylesheet" href="../styles/responsive.css">
    <link rel="stylesheet" href="../styles/cart.css">
    <link rel="stylesheet" href="../styles/reservation.css">
    <link rel="stylesheet" href="../styles/calendar.css">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://kit.fontawesome.com/b9d42b9dd4.js" crossorigin="anonymous"></script>
    <script src="../javascript/popups.js" defer></script>
    <script src="../javascript/filters.js" defer></script>
    <script src="../javascript/restaurant.js" defer></script>
    <script src="../javascript/dish.js" defer></script>
    <script src="../javascript/navbar.js" defer></script>
    <script src="../javascript/sticky.js" defer></script>
    <script src="../javascript/reviews.js" defer></script>
    <script src="../javascript/add-cart.js" defer></script>
    <script src="../javascript/cart.js" defer></script>
    <script src="../javascript/order.js" defer></script>
    <script src="../javascript/order-owner.js" defer></script>
    <script src="../javascript/reservations.js" defer></script>
    <script src="../javascript/reservation-popup.js" defer></script>
    <script src="../javascript/reservation-owner.js" defer></script>
    <script src="../javascript/comments.js" defer></script>
    <script src="../javascript/search.js" defer></script>
  </head>
  <body>
    <header>
      <?php 
        if ($session->isLoggedIn()) drawNavBar_LoggedIn($session);
        else drawNavBar();
      ?>
    </header>

    <section id="messages">
      <?php foreach ($session->getMessages() as $messsage) { ?>
        <article class="<?=$messsage['type']?>">
          <?=$messsage['text']?>
        </article>
      <?php } ?>
    </section>

    <main>

<?php } ?>

<?php function drawNavBar() { ?>
  <nav>
    <section class="nav-bar">
      <h1><a href="../pages/index.php">Ventre plein</a></h1>
      <i class='bx bx-menu sidebarOpen' ></i>
      <section class="menu">
        <section class="logo-toggle">
          <span class="logo"><a href="../pages/index.php">Ventre plein</a></span>
          <i class='bx bx-x siderbarClose'></i>
        </section>
        <section class="nav-main">
          <ul class="nav-links">
            <li><a href="../pages/index.php"><i class='bx bxs-home'></i> Home</a></li>
            <li><a class="carticon" href="../pages/cart.php"><i class='bx bxs-cart'></i> Cart</a></li>
          </ul>
          <ul class="nav-buttons">
            <li>
              <section class="darkLight-searchBox">
                <span class="dark-light">
                  <i class='bx bx-moon moon'></i>
                  <i class='bx bx-sun sun'></i>
                </span>
              </section>
            </li>
            <li>
              <a id="loginbtn">Login</a>
              <a id="registerbtn">Register</a>
            </li>
          </ul>
        </section>
    </section>
  </nav>

<?php } ?>


<?php function drawNavBar_LoggedIn(Session $session) { ?>
  <nav>
    <section class="nav-bar">
      <h1><a href="../pages/index.php">Ventre plein</a></h1>
      <i class='bx bx-menu sidebarOpen' ></i>
      <section class="menu">
        <section class="logo-toggle">
          <span class="logo"><a href="../pages/index.php">Ventre plein</a></span>
          <i class='bx bx-x siderbarClose'></i>
        </section>
        <section class="nav-main">
          <ul class="nav-links loggedin">
            <li><a href="../pages/index.php"><i class='bx bxs-home'></i> Home</a></li>
            <li><a href="../pages/reservation.php"><i class='bx bxs-calendar' ></i> Reservations</a></li>
            <p class="shop-item-quantity"><?= $session->getCartQuantity() ?></p>
            <li>
              <a class="carticon" href="../pages/cart.php"><i class='bx bxs-cart'></i> Cart</a>
            </li>
            <li><a href="../pages/order.php"><i class='bx bxs-bookmark-alt-minus' ></i> Orders</a></li>
          </ul>
          <ul class="nav-buttons loggedin">
            <li>
              <section class="darkLight-searchBox">
                <span class="dark-light">
                  <i class='bx bx-moon moon'></i>
                  <i class='bx bx-sun sun'></i>
                </span>
              </section>
            </li>
            <li>
              <span class="profileicon">
                <a href="../pages/profile.php"><i class='bx bxs-user-circle'></i></a>
              </span>
            </li>
            <li>
              <a href="../actions/action_logout.php" id="logoutbtn">Logout</a>
            </li>
          </ul>
        </section>
    </section>
  </nav>

<?php } ?>


<?php function drawFooter() { ?>
    </main>

    <footer>
        <span>Ventre plein</span>
        <span>LTW-t04-g03 Copyright &copy 2022</span>
        <a id="credits" href="../pages/credits.php">Credits</a>
    </footer>
    </body>
</html>

<?php } ?>


<?php function drawLoginForm() { ?>
  <section class="container" id="popup-login">
    <span class="overlay"></span>
      <section class=content id="login">
        <a id="close-login-btn">Close</a>
        <h1>Login</h1>
        <form>
          <label>
            Username <input type="text" name="username">
          </label>
          <label>
            Password <input type="password" name="password">
          </label>
          <button formaction="../actions/action_login.php" formmethod="post">Login</button>
        </form>
      </section>
  </section>

<?php } ?>


<?php function drawRegisterForm() { ?>
  <section class="container" id="popup-register">
    <span class="overlay"></span>
      <section class=content id="register">
        <a id="close-register-btn">Close</a>
        <h1>Register</h1>
        <form>
          <label>
            Username <input type="text" name="username">
          </label>
          <label>
            E-mail <input type="email" name="email">
          </label>
          <label>
            Password <input type="password" name="password">
          </label>
          <select name="account_type" > 
            <option value="Customer">Customer</option>
            <option value="Owner">Owner</option>
          </select>
          <button formaction="../actions/action_register.php" formmethod="post">Register</button>
        </form>
      </section>
  </section>

<?php } ?>

<?php function drawFiltersForm(Session $session, array $categories) { ?>
  <section class="container" id="popup-filters">
    <span class="overlay"></span>
      <section class=content id="filters">
        <a id="close-filters-btn">Close</a>
        <h1>Filters</h1>
        <form>
          <label>
            Sort by 
            <select name="sort" > 
              <option value="none">None</option>
              <option value="name">Name</option>
              <option value="category">Category</option>
              <option value="price">Price</option>
            </select>
          </label>
          <label>
            Price 
            <select name="price" > 
              <option value="None">None</option>
              <option value="1">€</option>
              <option value="2">€€</option>
              <option value="3">€€€</option>
              <option value="4">€€€€</option>
            </select>
          </label>
          <label>
            Category 
            <input id="category-input" name="category" list="category">
            <datalist id="category" > 
              <option value="None">None</option>
              <?php foreach ($categories as $category) { ?>
                <option value="<?=$category?>"><?=$category?></option>
              <?php } ?>
            </datalist>
          </label>
          <?php if ($session->isLoggedIn() && $session->getUsertype() == 0) { ?>
            <label>
              Favorite Restaurants
              <input type="checkbox" class="checkbox" name="fav" value="fav">
            </label>
          <?php } ?>
          <span id="arrows">
            <i class='bx bxs-up-arrow-alt active' ></i>
            <i class='bx bxs-down-arrow-alt' ></i>
          </span>
        </form>
      </section>
  </section>

<?php } ?>


<?php function drawCredits() { ?>
  <section class="credits">
    <h2>Credits:</h2>
      <ul>
          <li><a href="https://github.com/zmiguel2011">José Miguel</a></li>
          <li><a href="">Leandro Silva</a></li>
          <li><a href="">Miguel Nogueira</a></li>
      </ul>
</section>

<?php } ?>