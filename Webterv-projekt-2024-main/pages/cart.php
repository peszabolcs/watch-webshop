<!doctype html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Webshop - Kosár</title>
    <link rel="stylesheet" type="text/css" href="../src/css/style.css">
    <link rel="icon" type="image/png" href="../src/img/logo.png">
</head>
<body>
    <?php
    session_start(); 
    if(isset($_POST['clear_cart'])) {
        unset($_SESSION['cart']);
    }
    include 'elements/navbar.php'; ?>
    <div class="container">
        <div class="cart">
            <h1>Kosár</h1>
            <div class="table-div">
                <table class="order">
                    <thead>
                    <tr>
                        <th>Termék</th>
                        <th>Mennyiség</th>
                        <th>Ár</th>
                        <th>Összesen</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if(isset($_SESSION['cart'])) {
                        foreach ($_SESSION['cart'] as $product) {
                            if(is_array($product)) {
                                $subtotal = $product['price'] * $product['quantity'];
                                echo "<tr>";
                                echo "<td>" . $product['name'] . "</td>";
                                echo "<td>" . $product['quantity'] . "</td>";
                                echo "<td>" . $product['price'] . "</td>";
                                echo "<td>" . $subtotal . " USD</td>";
                                echo "</tr>";
                            }
                            
                        }
                    }
                    ?>
                </table>
                <table class="sum">
                    <?php
                    if(isset($_SESSION['cart'])) {
                        $total = 0;
                        foreach ($_SESSION['cart'] as $product) {
                            if(is_array($product)) {
                                $total += $product['price'] * $product['quantity'];
                            }
                        }
                        echo "<tr>";
                        echo "<td>Összesen:</td>";
                        echo "<td>" . $total . " USD</td>";
                        echo "</tr>";
                    }
                    ?>
                </table>
            </div>
            <div class="navbuttons">
                <a href="products.php" class="button-blue">Vissza a termékekhez</a>
                <form method="post" action="../src/actions/AddOrder.php">
                    <button type="submit" name="submit_order" class="button-blue">Megrendelés leadása</button>
                </form>
                <form method="post">
                    <button type="submit" name="clear_cart" class="button-blue">Kosár kiürítése</button>
                </form>
            </div>
        </div>
    </div>
    <?php include 'elements/footer.php'; ?>
</body>
</html>
