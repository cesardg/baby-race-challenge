<?php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../dao/ShopDAO.php';

class OrdersController extends Controller
{

  private $ShopDAO;

  function __construct()
  {
    $this->ShopDAO = new ShopDAO();
  }

  public function cart()
  {

    $this->set('title', 'Winkelbuggy');
    $this->set('currentPage', 'cart');

    if (!empty($_POST['action'])) {
      if ($_POST['action'] == 'add') {
        $this->_handleAdd();
        header('Location: index.php?page=shop');
        $_SESSION['info'] = '<p class="sessions__bold">Het item werd succesvol toegevoegd aan de winkelbuggy</p>';
        // header('Location: index.php?page=detail&id=' . $_POST['product_id']);
        exit();
      }
      if ($_POST['action'] == 'empty') {
        $_SESSION['cart'] = array();
      }
      if ($_POST['action'] == 'update') {
        $this->_handleUpdate();
      }
      header('Location: index.php?page=cart');
      exit();
    }
    if (!empty($_POST['remove'])) {
      $this->_handleRemove();
      header('Location: index.php?page=cart');
      exit();
    }
  }

  private function _handleCheckout()
  {
    header('Location: https://stripe.com/checkout');
    exit();
  }

  private function _handleAdd()
  {
    if (empty($_SESSION['cart'][$_POST['product_id']])) {
      $product = $this->ShopDAO->selectById($_POST['product_id']);
      if (empty($product)) {
        return;
      }
      $_SESSION['cart'][$_POST['product_id']] = array(
        'product' => $product,
        'quantity' => 0
      );
    }
    $_SESSION['cart'][$_POST['product_id']]['quantity']++;
  }

  private function _handleRemove()
  {
    if (isset($_SESSION['cart'][$_POST['remove']])) {
      unset($_SESSION['cart'][$_POST['remove']]);
    }
  }

  private function _handleUpdate()
  {
    foreach ($_POST['quantity'] as $productId => $quantity) {
      if (!empty($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId]['quantity'] = $quantity;
      }
    }
    $this->_removeWhereQuantityIsZero();
  }

  private function _removeWhereQuantityIsZero()
  {
    foreach ($_SESSION['cart'] as $productId => $info) {
      if ($info['quantity'] <= 0) {
        unset($_SESSION['cart'][$productId]);
      }
    }
  }
}
