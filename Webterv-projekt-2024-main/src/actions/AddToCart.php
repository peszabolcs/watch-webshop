<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['product'])) {
      addToCart($_POST['product']);
      if (isset($_SERVER['HTTP_REFERER'])) {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
      }
      else {
        header('Location: ../../pages/products.php');
      }
      exit;
    }
  }

function addToCart($product) {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    foreach($_SESSION['cart'] as &$cartProduct) {
        if (is_array($cartProduct) && $cartProduct['name'] === $product['name']) {
            $cartProduct['quantity']++;
            return;
        }
    }

    $product['quantity'] = 1;
    array_push($_SESSION['cart'], $product);
}
