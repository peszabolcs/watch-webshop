<?php
require_once "DataControl.php";

$dataControl = new DataControl();

$termekek = $dataControl->load_products("../../data/db.json");

function addIdToProduct() {
    global $termekek;
    $maxId = 0;
    foreach ($termekek['products'] as $product) {
        if ($product['id'] > $maxId) {
            $maxId = $product['id'];
        }
    }
    return ($maxId + 1);
}

if (isset($_POST["add_item"])) {
    $target_dir = "../img/products/";
    $target_file = $target_dir . basename($_FILES["item_image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $check = getimagesize($_FILES["item_image"]["tmp_name"]);
    if ($check === false) {
        $_SESSION['hibak'][] = "A feltöltött fájl nem egy kép.";
        header("Location: ../../index.php");
        exit;
    }

    if ($_FILES["item_image"]["size"] > 500000) {
        $_SESSION['hibak'][] = "A kép mérete túl nagy. Maximum 500KB lehet.";
        header("Location: ../../index.php");
        exit;
    }

    $id = addIdToProduct();

    $newFileName = $id . "." . $imageFileType;
    $target_file = $target_dir . $newFileName;

    if (!move_uploaded_file($_FILES["item_image"]["tmp_name"], $target_file)) {
        $_SESSION['hibak'][] = "Hiba történt a kép feltöltése közben.";
        header("Location: ../../index.php");
        exit;
    }

    $maxWidth = 200;
    $maxHeight = 300;

    list($width, $height) = getimagesize($target_file);

    $newWidth = $width;
    $newHeight = $height;

    if ($newWidth > $maxWidth || $newHeight > $maxHeight) {
        $ratio = $width / $height;

        if ($maxWidth / $maxHeight > $ratio) {
            $maxWidth = $maxHeight * $ratio;
        } else {
            $maxHeight = $maxWidth / $ratio;
        }

        $newWidth = $maxWidth;
        $newHeight = $maxHeight;
    }

    $thumb = imagecreatetruecolor($newWidth, $newHeight);
    $image = imagecreatefromjpeg($target_file);

    imagecopyresampled($thumb, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

    imagejpeg($thumb, $target_file, 90);

    imagedestroy($thumb);
    imagedestroy($image);

    $itemName = $_POST['item_name'];
    $itemPrice = $_POST['item_price'];

    $newProduct = [
        "id" => $id,
        "image" => $newFileName,
        "name" => $itemName,
        "price" => $itemPrice
    ];

    $dataControl->add_product("../../data/db.json", $newProduct);
    header("Location: ../../index.php");

} else {
    header("Location: ../../pages/admin.php?error=add-product-fail");
}
exit;
