<?php
  class Session {
    private array $messages;
    private array $cartitems;

    public function __construct() {
      session_start();

      $this->messages = isset($_SESSION['messages']) ? $_SESSION['messages'] : array();
      $this->cartitems = isset($_SESSION['cartitems']) ? $_SESSION['cartitems'] : array();
      unset($_SESSION['messages']);
    }

    public function isLoggedIn() : bool {
      return isset($_SESSION['id']);    
    }

    public function logout() {
      session_destroy();
    }

    public function getId() : ?int {
      return isset($_SESSION['id']) ? $_SESSION['id'] : null;    
    }

    public function getUsername() : ?string {
      return isset($_SESSION['username']) ? $_SESSION['username'] : null;
    }

    public function getUsertype() : ?int {
      return isset($_SESSION['usertype']) ? $_SESSION['usertype'] : null;    
    }

    public function isOwner() : ?bool {
      return isset($_SESSION['isowner']) ? $_SESSION['isowner'] : null;    
    }
    
    public function getRestaurantId() : ?int {
      return isset($_SESSION['restaurantid']) ? $_SESSION['restaurantid'] : null;    
    }

    public function clearRestaurantId() {
      unset($_SESSION['restaurantid']);   
    }

    public function clearDishId() {
      unset($_SESSION['dishid']);   
    }

    public function getDishId() : ?int {
      return isset($_SESSION['dishid']) ? $_SESSION['dishid'] : null;    
    }

    public function getPage() : ?string {
      return isset($_SESSION['currpage']) ? $_SESSION['currpage'] : null;
    }

    public function setId(int $id) {
      $_SESSION['id'] = $id;
    }

    public function setUsername(string $username) {
      $_SESSION['username'] = $username;
    }

    public function setUsertype(int $usertype) {
      $_SESSION['usertype'] = $usertype;
    }

    public function setOwner(bool $boolean) {
      $_SESSION['isowner'] = $boolean;
    }

    public function setRestaurantId(int $restaurantid) {
      $_SESSION['restaurantid'] = $restaurantid;
    }

    public function setDishId(int $dishid) {
      $_SESSION['dishid'] = $dishid;
    }

    public function setPage(string $page) {
      $_SESSION['currpage'] = $page;
    }

    public function addMessage(string $type, string $text) {
      $_SESSION['messages'][] = array('type' => $type, 'text' => $text);
    }

    public function getMessages() {
      return $this->messages;
    }

    public function setCartRestaurantId(int $restaurantid) {
      $_SESSION['cartrestaurantid'] = $restaurantid;
    }

    public function getCartRestaurantId() : ?int {
      return isset($_SESSION['cartrestaurantid']) ? $_SESSION['cartrestaurantid'] : null;    
    }

    public function clearCartRestaurantId() {
      unset($_SESSION['cartrestaurantid']);    
    }

    public function addCartitem(string $dishid) {

      if (isset($_SESSION['cartitems'][$dishid]))
        $_SESSION['cartitems'][$dishid]++;
      else
        $_SESSION['cartitems'][$dishid] = 1;
    }

    public function decreaseCartitem(string $dishid) {

      if (isset($_SESSION['cartitems'][$dishid]) && $_SESSION['cartitems'][$dishid] > 1)
        $_SESSION['cartitems'][$dishid]--;
    }

    public function removeCartitem(string $dishid) {
      if (isset($_SESSION['cartitems'][$dishid])) {
        $quantity = intval($_SESSION['cartitems'][$dishid]);
        if (isset($_SESSION['cartquantity']))
          $_SESSION['cartquantity'] = intval($_SESSION['cartquantity']) - $quantity;

        if ($_SESSION['cartquantity'] == 0) {
          unset($_SESSION['cartitems']);  
          unset($_SESSION['cartquantity']);
          unset($_SESSION['cartrestaurantid']);  
        }

        unset($_SESSION['cartitems'][$dishid]);
      }
    }

    public function getCartItems() {
      return $this->cartitems;
    }

    public function increaseCartQuantity() {
      if (isset($_SESSION['cartquantity']))
        $_SESSION['cartquantity']++;
      else
        $_SESSION['cartquantity'] = 1;
    }

    public function decreaseCartQuantity() {
      if (isset($_SESSION['cartquantity']) && $_SESSION['cartquantity'] > 1)
        $_SESSION['cartquantity']--;
    }

    public function getCartQuantity() : ?int {
      return isset($_SESSION['cartquantity']) ? $_SESSION['cartquantity'] : null;    
    }

    public function clearCart() {
      unset($_SESSION['cartitems']);  
      unset($_SESSION['cartquantity']);
    }
  }
?>