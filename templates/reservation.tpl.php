<?php 
  declare(strict_types = 1); 

  require_once(__DIR__. '/../utils/session.php');
?>
<?php function drawCalendar() { ?>

    <section class="calendar-title">
        <h2>Make a Reservation</h2>
    </section>
    <section class="calendar">
        <section class="calendar-header">
            <span class="month-picker" id="month-picker">February</span>
            <section class="year-picker">
                <span class="year-change" id="prev-year">
                    <pre><</pre>
                </span>
                <span id="year">2021</span>
                <span class="year-change" id="next-year">
                    <pre>></pre>
                </span>
            </section>
        </section>
        <section class="calendar-body">
            <section class="calendar-week-day">
                <div>Sun</div>
                <div>Mon</div>
                <div>Tue</div>
                <div>Wed</div>
                <div>Thu</div>
                <div>Fri</div>
                <div>Sat</div>
            </section>
            <section class="calendar-days"></section>
        </section>
        <section class="calendar-footer">
            <a id="calendar-next">Next</a>
        </section>
        <section class="month-list"></section>
    </section>

<?php } ?>



<?php function drawReservations(array $reservations) { ?>

<section class="Reservation_header">
    <h2>Your Reservations</h2>
    <form class="searchreservation" method="get">
        <input id="searchreservation" placeholder="Search Reservations" type="text" name="search">
        <i class='bx bx-search searchicon'></i>
    </form> 
</section>
<section id="reservations-user">
    <?php if (empty($reservations)) { ?>
        <p>There aren't any reservations.</p>
    <?php } else { ?>
    <?php foreach ($reservations as $reservation) { ?>
        <?php if ($reservation->status == 'canceled') { ?>
            <article class="reservation canceled">
        <?php } else { ?>
            <article class="reservation">
        <?php } ?>
            <section class="reservation-info">
                <h2><?=$reservation->restaurant_name?></h2>
                <p id="reservation">Reservation #<?=$reservation->id?></p>
                <p id="quantity">Quantity: <?=$reservation->quantity?></p>
                <p id="datetime"><?=$reservation->datetime?></p>
            </section>
            <section class="reservation-status">
                <h3 id="<?=$reservation->status?>"><?=$reservation->status?></h3>
            </section>
            <section class="reservation-buttons">
                <a class="cancel-reservation-button">Cancel</a>
            </section>
        </article>
    <?php } ?>
<?php } ?>

</section>

<?php } ?>


<?php function drawReservationsOwner(array $restaurants) { ?>
    
    <section class="Restaurant_header">
        <h2>Your Restaurants</h2>
    </section>
    <section id="restaurants-reservations-owner">
    <?php foreach ($restaurants as $restaurant) { ?>
        <article>
            <?php $restid = $restaurant->id;
            if(file_exists("../imgs/restaurants/small/$restid.jpg")) { ?>
                <img src="../imgs/restaurants/small/<?=$restaurant->id?>.jpg">
            <?php } else { ?>
            <img src="../imgs/restaurants/default.jpg">
            <?php } ?>
            <a href="../pages/restaurant.php?id=<?=$restaurant->id?>"><?=$restaurant->name?></a>
            <a id="<?=$restaurant->id?> "class="show-reservations-buttons">Show Reservations</a>
        </article>
        
    <?php } ?>
        </section>
        <section id="reservations-owner">
        </section>
<?php } ?>

<?php function drawCancelReservationForm() { ?>

<section class="container" id="popup-cancel-reservation">
<span class="overlay"></span>
  <section class=content id="cancel-reservation">
    <a id="close-remove-btn">Close</a>
    <h1>Are you sure you want to cancel this reservation?</h1>
    <p>This action is irreversible.</p>
    <section class="remove">
    <form>
      <input id="cancel-reservation-id" type="text" name="cancel-reservation-id">
      <a id="remove-cancel">Go back</a>
      <button id="remove-submit" formaction="../actions/action_cancel_reservation.php" formmethod="post">Cancel</button>
    </form>
    </section>
  </section>
</section>

<?php } ?>