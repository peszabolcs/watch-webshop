<?php
require_once '../src/actions/DataControl.php';

$dataControl = new DataControl();
$data = $dataControl->load_products("../data/db.json");
?>
<!doctype html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Webshop - Termékek</title>
    <link rel="stylesheet" type="text/css" href="/src/css/style.css">
    <link rel="icon" type="image/png" href="../src/img/logo.png">
</head>
<body>
    <?php include 'elements/navbar.php'; ?>
    <div class="products content">
        <div class="products-header">
            <h2>Óra választékunk</h2>
        </div>
        <div class="products-container">

            <?php
                foreach ($data['products'] as $product) {
                    echo '<div class="product-card">';
                    echo '<form action="../src/actions/AddToCart.php" method="post">';
                    echo '<img src="../src/img/products/' . $product['image'] . '" alt="termek">';
                    echo '<p class="name">' . $product['name'] . '</p>';
                    echo '<p class="price">' . $product['price'] . ' USD$</p>';
                    echo '<div class="tocart">';
                    echo '<input type="hidden" name="product[name]" value="' . $product['name'] . '">';
                    echo '<input type="hidden" name="product[price]" value="' . $product['price'] . '">';
                    echo '<button class="button-blue">';
                    echo '<img src="/src/img/tocart.png" alt="kosarba">';
                    echo '</button>';
                    echo '</div>';
                    echo '</form>';
                    echo '</div>';
                }
            ?>

        </div>
        </div>
        </form>
        
    </div> 
    
    <?php include 'elements/footer.php'; ?>

</body>
</html>
