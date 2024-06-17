<?php
require_once 'DataControl.php';

if (isset($_POST['product_id'])) {
    $dataControl = new DataControl();
    $products = $dataControl->load_products("../../data/db.json");

    foreach ($products['products'] as $product) {
        if ($product['id'] == $_POST['product_id']) {
            echo $product['name'];
            exit;
        }
    }
    echo "";
}
