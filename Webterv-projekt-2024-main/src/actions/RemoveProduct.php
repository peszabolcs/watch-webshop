<?php
require_once 'DataControl.php';

if (isset($_POST['item_id'])) {
    $productId = intval($_POST['item_id']);

    $dataControl = new DataControl();
    $products = $dataControl->load_products("../../data/db.json");
    $found = false;

    foreach ($products['products'] as $key => $product) {
        if ($product['id'] == $productId) {
            unset($_GET['error']);
            unset($products['products'][$key]);
            $dataControl->save_products("../../data/db.json", $products);
            $found = true;
            header("Location: ../../pages/admin.php?success=product-deleted");
            exit;
        }
    }

    if (!$found) {
        header("Location: ../../pages/admin.php?error=product-invalid");
        exit;
    }
}

