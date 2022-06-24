<?php function drawOrders(array $orders) { ?>

    <section class="Order_header">
        <h2>Your Orders</h2>
        <form class="searchorder" method="get">
            <input id="searchorder" placeholder="Search Orders" type="text" name="search">
            <i class='bx bx-search searchicon'></i>
        </form> 
    </section>
    <section id="orders-user">
        <?php if (empty($orders)) { ?>
            <p>There aren't any orders.</p>
        <?php } else { ?>
        <?php foreach ($orders as $order) { ?>
            <?php if ($order->status == 'canceled') { ?>
                <article class="order canceled">
            <?php } else { ?>
                <article class="order">
            <?php } ?>
                <section class="order-info">
                    <h2><?=$order->restaurant_name?></h2>
                    <p id="order">Order #<?=$order->id?></p>
                    <p id="total">Total: <?=$order->total?>€</p>
                    <p id="date"><?=$order->date?></p>
                </section>
                <section class="order-status">
                    <h3 id="<?=$order->status?>"><?=$order->status?></h3>
                    <p id="estimated-time">Estimated delivery time: 20:53</p>
                </section>
                <section class="order-buttons">
                    <a href="../pages/receipt.php?id=<?=$order->id?>">Details</a>
                    <a class="cancel-order-button">Cancel</a>
                </section>
            </article>
        <?php } ?>
    <?php } ?>

    </section>

<?php } ?>


<?php function drawOrdersOwner(array $restaurants) { ?>
    
    <section class="Restaurant_header">
        <h2>Your Restaurants</h2>
    </section>
    <section id="restaurants-orders-owner">
    <?php foreach ($restaurants as $restaurant) { ?>
        <article>
            <?php $restid = $restaurant->id;
            if(file_exists("../imgs/restaurants/small/$restid.jpg")) { ?>
                <img src="../imgs/restaurants/small/<?=$restaurant->id?>.jpg">
            <?php } else { ?>
            <img src="../imgs/restaurants/default.jpg">
            <?php } ?>
            <a href="../pages/restaurant.php?id=<?=$restaurant->id?>"><?=$restaurant->name?></a>
            <a id="<?=$restaurant->id?> "class="show-orders-buttons">Show Orders</a>
        </article>
        
    <?php } ?>
        </section>
        <section id="orders-owner">
        </section>
<?php } ?>

<?php function drawCancelOrderForm() { ?>

<section class="container" id="popup-cancel-order">
<span class="overlay"></span>
  <section class=content id="cancel-order">
    <a id="close-remove-btn">Close</a>
    <h1>Are you sure you want to cancel this order?</h1>
    <p>This action is irreversible.</p>
    <section class="remove">
    <form>
      <input id="cancel-order-id" type="text" name="cancel-order-id">
      <a id="remove-cancel">Go back</a>
      <button id="remove-submit" formaction="../actions/action_cancel_order.php" formmethod="post">Cancel</button>
    </form>
    </section>
  </section>
</section>

<?php } ?>


<?php function drawReceipt(?Order $order, array $OrderDishes) { ?>
    <section class="cart">
      <article class="cart-order">
         <section class="indicators">
            <h2><a target="_blank" href="../pages/restaurant.php?id=<?=$order->RestaurantId?>"><?=$order->restaurant_name?></a></h2>
            <p id="cart-indicators-product">Product</p>
            <p id="cart-indicators-quantity">Quantity</p>
            <p id="cart-indicators-price">Price</p>
         </section>
         <?php foreach ($OrderDishes as $dish) { ?>
               <section class="cart-item">
                  <img src="../imgs/dishes/small/<?= $dish['DishId']?>.jpg" alt="">
                  <p class="cart-item-name"><a target="_blank" href="../pages/dish.php?id=<?= $dish['DishId'] ?>"><?= $dish['Name']?></a></p>
                  <section class="cart-quantity-buttons">
                     <p class="cart-order-quantity"><?=$dish['Quantity']?></p>
                  </section>
                  <p class="cart-item-price"><?=$dish['Price']?>€</p>
               </section>
         <?php } ?>   
      </article>

      <section class="order-summary">
            <p class="order-summary-txt">Order Summary</p>
            <section class="info">
               <section class="order-subtotal">
                  <p>Subtotal</p>
                  <p id="order-subtotal-value"><?=$order->total?>€</p>
               </section>
               <section class="order-shipping">
                  <p>Shipping</p>
                  <p id="order-shipping-value">5€</p>
               </section>
            </section>
            <section class="order-total">
               <p class="order-total">Total</p>
               <p id="order-total-value"><?=$order->total + 5?>€</p>
            </section>
      </section>
    </section>

<?php } ?>