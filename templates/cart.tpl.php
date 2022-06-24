<?php 
  declare(strict_types = 1); 

  require_once(__DIR__. '/../utils/session.php');
  require_once(__DIR__. '/../database/restaurant.class.php');
?>

<?php function drawCart(array $dishes, ?Restaurant $restaurant, array $quantities, Session $session) { ?>
   <?php $count = 0;
      if (!empty($dishes)) { ?>
    <section class="cart">
      <article class="cart-order">
         <section class="indicators">
            <h2><a target="_blank" href="../pages/restaurant.php?id=<?=$restaurant->id?>"><?=$restaurant->name?></a></h2>
            <p id="cart-indicators-product">Product</p>
            <p id="cart-indicators-quantity">Quantity</p>
            <p id="cart-indicators-price">Price</p>
         </section>
         <?php foreach ($dishes as $dish) { ?>
               <section class="cart-item">
                  <img src="../imgs/dishes/small/<?=$dish->id?>.jpg" alt="">
                  <p class="cart-item-name"><a target="_blank" href="../pages/dish.php?id=<?= $dish->id ?>"><?= $dish->name?></a></p>
                  <section class="cart-quantity-buttons">
                     <a class="cart-order-quantity-decrease"><i class='bx bx-minus-circle bx-sm'></i></a>
                     <p class="cart-order-quantity"><?=$quantities[$count++]?></p>
                     <a class="cart-order-quantity-increase"><i class='bx bx-plus-circle bx-sm'></i></a>
                  </section>
                  <p class="cart-item-price"><?=$dish->price?>€</p>
                  <a id="<?= $dish->id ?>" class="delete-button"><i class='bx bxs-x-circle bx-md'></i></a>  
               </section>
         <?php } ?>   
         <section class="cart-order-button">
            <a id="cart-clear">Clear Cart</a>
            <a id="cart-continue" href="../pages/restaurant.php?id=<?=$restaurant->id?>">Continue Shopping</a>
         </section>
      </article>

      <section class="order-summary">
            <p class="order-summary-txt">Order Summary</p>
            <section class="info">
               <section class="order-subtotal">
                  <p>Subtotal</p>
                  <p id="order-subtotal-value">0€</p>
               </section>
               <section class="order-shipping">
                  <p>Shipping</p>
                  <p id="order-shipping-value">0€</p>
               </section>
            </section>
            <p class="infoComplete">Please fill out all your <a href="../pages/edit_profile.php">information!</a></p>
            <section class="order-total">
               <p class="order-total">Total</p>
               <p id="order-total-value">0€</p>
            </section>
            <button type="submit" id="checkout-button">CHECKOUT</button> 
      </section>
    </section>
    <?php } else {
         $session->addMessage('info', 'Your cart is empty.');
         header('Location: ' . $_SERVER['HTTP_REFERER']);
      } ?>

<?php } ?>