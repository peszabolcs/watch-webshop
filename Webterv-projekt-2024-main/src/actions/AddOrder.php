<?php
require_once 'DataControl.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../../pages/login.php?error=login-to-order");
    exit;
}

$dataControl = new DataControl();

$rendelesek = $dataControl->load_products("../../data/db.json");

function addIdToOrder() {
    global $rendelesek;
    $maxId = 0;
    foreach ($rendelesek['orders'] as $order) {
        if ($order['id'] > $maxId) {
            $maxId = $order['id'];
        }
    }
    return ($maxId + 1);
}

if (isset($_POST['submit_order'])) {
    if (empty($_SESSION['cart'])) {
        header("Location: ../../pages/cart.php?error=EmptyCart");
        exit;
    }

    $availableProducts = $dataControl->load_products("../../data/products.json");
    foreach ($_SESSION['cart'] as $productId => $quantity) {
        $productExists = true;
        foreach ($availableProducts['products'] as $product) {
            if ($product['id'] != $productId) {
                $productExists = false;
            }
        }
        if (!$productExists) {
            header("Location: ../../pages/cart.php?error=UnavailableProducts");
            exit;
        }
    }

    $userId = $_SESSION['user']['id'];
    $productIds = $_SESSION['cart'];
    $orderDate = date('Y-m-d H:i:s');
    $orderTotal = calculateOrderTotal($productIds);

    $newOrder = [
        'id' => addIdToOrder(),
        'user_id' => $userId,
        'products' => $productIds,
        'date' => $orderDate,
        'total' => $orderTotal
    ];
    $dataControl->add_order("../../data/db.json", $newOrder);

    unset($_SESSION['cart']);

    header("Location: ../../pages/profile.php?success=OrderPlaced");
} else {
    header("Location: ../../pages/cart.php?error=InvalidRequest");
}
exit;

function calculateOrderTotal($cart) {
    $total = 0;

    if (!empty($cart)) {
        foreach ($cart as $productId => $quantity) {
            $productPrice = $_SESSION['cart'][$productId]['price'];
            $productQuantity = $_SESSION['cart'][$productId]['quantity'];
            $subtotal = $productPrice * $productQuantity;
            $total += $subtotal;
        }
    }

    return $total;
}