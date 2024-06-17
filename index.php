<?php
require_once 'src/actions/DataControl.php';

$dataControl = new DataControl();
$data = $dataControl->load_products("data/db.json");
?>
<!doctype html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Webshop</title>
    <link rel="stylesheet" type="text/css" href="src/css/style.css">
    <link rel="icon" type="image/png" href="./src/img/logo.png">
</head>
<body>
    <?php include_once "pages/elements/navbar.php" ?>
    <div class="content">
        <div class="homepage">
            <h1>Üdvözöljük webshopunkban!</h1>
        </div>

        <div class="image-container">
            <div class="box">
                <img src="./src/img/homepage/homepage01.jpg" alt="A man wearing a watch">
            </div>
            <div class="box">
                <img src="./src/img/homepage/homepage02.jpg" alt="A man wearing a watch">
            </div>
        </div>

        <div class="top-products">
            <h2>Tekintse meg kiemelt termékeinket</h2>
            <div class="products-container">

                <?php
                    for ($i = 0; $i < min(4, count($data['products'])); $i++) {
                        $product = $data['products'][$i];
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
        <div class="homepage">
            <p>Fedezze fel széles választékunkat stílusos és elegáns óráinkból.</p>
            <a href="pages/products.php" class="btn">Vásárlás</a>
        </div>

        <div class="home-login">
        <?php if (!isset($_SESSION['user'])): ?>

                <h3>Ön rendelkezik már fiókkal?</h3>
                    <div class="login-container card">
                        <form action="../src/actions/Login.php" method="POST" id="login-form">
                            <h2>Bejelentkezés</h2>
                            <div class="input-mezo">
                                <label for="username">Felhasználónév</label>
                                <input type="text" placeholder="John Doe" id="username" name="username" class="card" required>
                            </div>
                            <div class="input-mezo">
                                <label for="password">Jelszó</label>
                                <input type="password" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;" id="password" name="password" class="card" required>
                            </div>
                            <div class="input-mezo extra">
                                <a class="forgot-password link" href="#">Elfelejtett jelszó</a>
                                <a class="register link" href="/pages/register.php">Regisztráció</a>
                            </div>
                            <input type="submit" value="Bejelentkezés" class="submit-button button-blue">
                        </form>
                    </div>
            </div>
    <?php endif; ?>
    </div>

    <footer class="card">
        <p>© 2024 Minden jog fenntartva.</p>
    </footer>
</body>
</html>