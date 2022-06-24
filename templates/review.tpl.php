<?php 
  declare(strict_types = 1); 

  require_once(__DIR__. '/../database/user.class.php');
  require_once(__DIR__. '/../database/review.class.php');
  require_once(__DIR__. '/../database/restaurant.class.php');

  require_once(__DIR__. '/../utils/session.php');
?>

<?php function drawReviews(PDO $db, array $reviews, Session $session) { ?>
    
  <section class="reviews_header">
    <h2>Reviews</h2>
    <?php if ($session->isLoggedIn() && $session->getUsertype() == 0) { ?>
      <a id="add-review-btn">Add Review</a>
    <?php } ?>
  </section>
  <section class="reviews">
    <?php if ($reviews == NULL) { ?>
      <p>There aren't any reviews on this Restaurant. Be the first to add one!</p>
    <?php } ?>
    <?php foreach ($reviews as $review) { ?>
      <section class="review-container">
        <article>
          <?php $user = User::getUser($db, intval($review->user_id)); 
          $revid = $review->user_id;
          $restaurant = Restaurant::getRestaurant($db, intval($review->restaurant_id));
            if(file_exists("../imgs/profile/users/small/$revid.jpg")) { ?>
              <img src="../imgs/profile/users/small/<?=$review->user_id?>.jpg" alt="Profile Picture">
            <?php } else { ?>
              <img src="../imgs/profile/default.jpg" alt="Profile Picture" style="width: 100px; height: 100px;">
            <?php } ?>
          <section id="<?=$review->id?>" class="info">
            <p><?=$review->date?></p>
            <h3 class="nome"><?=$user->name?></h3>
            <?php for ($i = 1; $i <= 5; $i++) { ?>
              <?php if ($i <= $review->rating) { ?>
                <i class='bx bxs-star' ></i>
              <?php }else { ?>
                <i class='bx bx-star' ></i>
              <?php } ?>
            <?php } ?>
          </section>
          <p id="user-comment"><?=$review->comment?></p>
          <?php if ($session->isLoggedIn() && $session->getUsertype() == 0 && $session->getId() == $revid) { ?>
            <form id="delete-form">
              <input id="remove-review-id" type="text" name="edit-id" value="<?=$review->id?>">
              <button id="delete-review-btn" name="edit" formaction="../actions/action_remove_review.php" formmethod="post"><i class="fa-solid fa-trash"></i></button>
            </form>
            <a id="<?=$review->id?>" class="edit-review-btn"> <i class="fa-solid fa-pen"></i> </a>
          <?php } elseif ($session->getUsertype() == 1 && $restaurant->owner_id == $session->getId()) { ?>
            <a id="<?=$review->id?>" class="add-comment-btn"><i class="fa-solid fa-comment"></i> </a>
          <?php } ?>
        </article>
        <section class="comment<?=$review->id?>" id="owner-comments"> </section>
      </section>
    <?php } ?>
  </section>

<?php } ?>


<?php function drawReviewForm() { ?>

    <section class="container" id="popup-review">
    <span class="overlay"></span>
      <section class=content id="review">
        <a id="close-review-btn">Close</a>
        <h1>Write your review</h1>
        <section class="rating">
        <form>
            <section class="starrate">
              <input type="radio" id="star5" name="rate" value="5" />
              <label for="star5" title="text">5 stars</label>
              <input type="radio" id="star4" name="rate" value="4" />
              <label for="star4" title="text">4 stars</label>
              <input type="radio" id="star3" name="rate" value="3" />
              <label for="star3" title="text">3 stars</label>
              <input type="radio" id="star2" name="rate" value="2" />
              <label for="star2" title="text">2 stars</label>
              <input type="radio" id="star1" name="rate" value="1" />
              <label for="star1" title="text">1 star</label>
            </section>
            <textarea name="review" id="review-text" cols="50" rows="10" placeholder="Write your review"></textarea>
            <button id="review-submit" formaction="../actions/action_submit_review.php" formmethod="post">Submit</button>
          </form>
        </section>
      </section>
    </section>

<?php } ?>

<?php function drawEditReview() { ?>

<section class="container" id="popup-edit-review">
<span class="overlay"></span>
  <section class=content id="review-edit">
    <a id="close-edit-review-btn">Close</a>
    <h1>Write your review</h1>
    <section class="rating">
    <form>
        <section class="starrate">
          <input type="radio" id="edit-star5" name="rate" value="5" />
          <label for="edit-star5" title="text">5 stars</label>
          <input type="radio" id="edit-star4" name="rate" value="4" />
          <label for="edit-star4" title="text">4 stars</label>
          <input type="radio" id="edit-star3" name="rate" value="3" />
          <label for="edit-star3" title="text">3 stars</label>
          <input type="radio" id="edit-star2" name="rate" value="2" />
          <label for="edit-star2" title="text">2 stars</label>
          <input type="radio" id="edit-star1" name="rate" value="1" />
          <label for="edit-star1" title="text">1 star</label>
        </section>
        <input id="edit-review-id" name="edit-review-id">
        <textarea name="review" id="review-edit-text" cols="50" rows="10" placeholder="Write your review"></textarea>
        <button id="review-edit-btn" formaction="../actions/action_edit_review.php" formmethod="post">Submit</button>
      </form>
    </section>
  </section>
</section>

<?php } ?>

<?php function drawCommentForm() { ?>

<section class="container" id="popup-comment">
<span class="overlay"></span>
  <section class=content id="review-comment-form">
    <a id="close-comment-form-btn">Close</a>
    <h1>Write your Comment</h1>
    <form>
      <input type="text" id="add-comment-id" name="add-comment-id"> </input>
      <textarea name="comment" id="comment-text" cols="50" rows="10" placeholder="Write your comment"></textarea>
      <button id="comment-submit" formaction="../actions/action_add_comment.php" formmethod="POST">Submit</button>
    </form>
  </section>
</section>

<?php } ?>

