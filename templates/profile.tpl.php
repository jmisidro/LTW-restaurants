<?php 
  declare(strict_types = 1); 

  require_once(__DIR__. '/../utils/session.php');
?>

<?php function drawOwner(Owner $owner, Session $session)
{?>
  <?php 
    if ($session->getUsertype() === 0) {
      $userType = 'users';
    }
    else if ($session->getUsertype() === 1) {
      $userType = 'owners';
      $session->setOwner(true);
    }
  ?>
  <section class="user-profile">
    <h1>User Information</h2>
    <?php if ($userType == 'owners' && $session->isOwner()) { ?>
      <a id="switch-usertype" href="../actions/action_switch_user.php" >View as Customer</a>
    <?php } else if ($userType == 'users' && $session->isOwner()){ ?>
      <a id="switch-usertype" href="../actions/action_switch_user.php">View as Owner</a>
    <?php } ?>
    <?php if(file_exists("../imgs/profile/$userType/medium/$owner->id.jpg")) { ?>
      <img src="../imgs/profile/<?= $userType ?>/medium/<?= $owner->id ?>.jpg">
    <?php } else { ?>
      <img src="../imgs/profile/default.jpg">
    <?php } ?>
    <p id="Name">Name: <?= $owner->name ?></p>
    <p id="PhoneNumber">Phone Number: <?=$owner->phonenumber ?></p>
    <?php if ($userType == 'users') { ?>
      <p id="Address">Address: </p>
    <?php } ?>
    <p id="Email">Email: <?= $owner->email ?></p>
    <a id="edit-profile-btn" href="edit_profile.php">Edit Profile</a>
  </section>

<?php } ?>

<?php function drawUser(User $user, Session $session)
{?>
  <?php 
    if ($session->getUsertype() === 0) {
      $userType = 'users';
    }
    else if ($session->getUsertype() === 1) {
      $userType = 'owners';
      $session->setOwner(true);
    }
  ?>
  <section class="user-profile">
    <h1>User Information</h2>
    <?php if ($userType == 'owners' && $session->isOwner()) { ?>
      <a id="switch-usertype" href="../actions/action_switch_user.php" >View as Customer</a>
    <?php } else if ($userType == 'users' && $session->isOwner()){ ?>
      <a id="switch-usertype" href="../actions/action_switch_user.php">View as Owner</a>
    <?php } ?>
    <?php if(file_exists("../imgs/profile/$userType/medium/$user->id.jpg")) { ?>
      <img src="../imgs/profile/<?= $userType ?>/medium/<?= $user->id ?>.jpg">
    <?php } else { ?>
      <img src="../imgs/profile/default.jpg">
    <?php } ?>
    <p id="Name">Name: <?= $user->name ?></p>
    <p id="PhoneNumber">Phone Number: <?=$user->phonenumber ?></p>
    <?php if ($userType == 'users') { ?>
      <p id="Address">Address: <?= $user->address ?></p>

    <?php } ?>
    <p id="Email">Email: <?= $user->email ?></p>
    <a id="edit-profile-btn" href="edit_profile.php">Edit Profile</a>
  </section>

<?php } ?>


<?php function drawEditProfile(Object $profile, Session $session)
{?>

  <?php 
    if ($session->getUsertype() === 0) {
      $userType = 'users';
    }
    else if ($session->getUsertype() === 1) {
      $userType = 'owners';
      $session->setOwner(true);
    }
  ?>
  <section class="user-edit-profile">
    <h1>Edit Profile</h1>
    <?php if(file_exists("../imgs/profile/$userType/medium/$profile->id.jpg")) { ?>
      <img src="../imgs/profile/<?= $userType ?>/medium/<?= $profile->id ?>.jpg">
    <?php } else { ?>
      <img src="../imgs/profile/default.jpg">
    <?php } ?>
    <form action="../actions/action_upload_img_profile.php" method="post" enctype="multipart/form-data">
      <input type="file" name="image">
      <input id="upload" type="submit" value="Upload Photo">
    </form>  
    <form>
      <label for="name">
        Name: <input type="text" id="name" name="name" value="<?=$profile->name?>">
      </label>
      <label for="PhoneNumber">
        Phone Number: <input type="tel" id="PhoneNumber" name="PhoneNumber" value="<?= $profile->phonenumber ?>" pattern="^[0-9]{9}|[0-9]{3}-[0-9]{3}-[0-9]{3}" required>
      </label>
      <?php if ($userType == 'users') { ?>
        <label for="Address">
          Address: <input type="text" id="Address" name="Address" value="<?= $profile->address ?>">
        </label>
      <?php } ?>
      <button formaction="../actions/action_edit_profile.php" formmethod="post">Save Profile</button>
    </form>
  </section>

<?php } ?>