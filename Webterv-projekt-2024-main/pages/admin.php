<?php
include_once '../src/actions/UserControl.php';
include_once '../src/actions/DataControl.php';
if(session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
$userControl = new UserControl('../data/db.json');
$dataControl = new DataControl();

if( isset($_POST["remove_user"]) ) {
    $id = $_POST["user_id"];
    echo "Processing removal of user with ID: $id\n";
    $userControl->remove_user($id);
    $users = $userControl->get_users();
    $dataControl->save_users("../data/db.json", $users);
    echo "Final users list: " . json_encode($users);
}

$adminbool = false;
$user = $_SESSION['user'] ?? null;
$data = $dataControl->load_admins('../data/db.json');
foreach( $data['admins'] as $admin ) {
    if( $user['id'] === $admin['id'] ) {
        $adminbool = true;
    }
}
if (!$adminbool) {
    header("Location: login.php?error=none-admin-user");
    exit();
}

?>

<!doctype html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Webshop - Admin</title>
    <link rel="stylesheet" type="text/css" href="../src/css/style.css">
    <link rel="icon" type="image/png" href="../src/img/logo.png">
</head>
<body>
    <?php include 'elements/navbar.php'; ?>
    <?php
    if (isset($_GET['success'])) {
        $success_message = "";
        $product = false;
        $user = false;
        switch ($_GET['success']) {
            case "product-deleted":
                $product = true;
                $success_message = "A termék sikeresen eltávolítva.";
                break;
            case "user-deleted":
                $user = true;
                $success_message = "A felhasználó sikeresen eltávolítva.";
                break;
            default:
                $success_message = "Sikeres törlés!";
                break;
        }
        echo "<span class='admin-message' style='color: red;text-align: center;'>$success_message</span>";
    }

    if (isset($_GET['error'])) {
        $errorMessage = $_GET['error'];
        $errorMessage = match ($errorMessage) {
            "product-invalid" => "Ilyen azonosítóval rendelkező termék nem létezik!",
            "login-to-order" => "Kérem jelentkezzen be a rendelés leadásához!",
            "user-invalid" => "Ilyen azonosítóval rendelkező felhasználó nem létezik!",
            "add-product-fail" => "Hiba történt a termék hozzáadásakor (valószínűleg PNG képfájlt adott meg JPEG helyett)!",
            default => "Ismeretlen hiba történt!",
        };
        echo "<span class='admin-message' style='color: red;text-align: center;'>$errorMessage</span>";
    }

    ?>
    <div class="admin-interface">
        <div class="user-management">
            <h2>Felhasználók kezelése</h2>
            <form action="../src/actions/AddUser.php" method="POST">
                <label for="username">Felhasználónév:</label>
                <input type="text" id="username" class="card" name="username" placeholder="John Doe" required>
                <label for="email">Email:</label>
                <input type="email" id="email" class="card" name="email" placeholder="johndoe@gmail.com" required>
                <label for="password">Jelszó:</label>
                <input type="password" id="password" class="card" name="password" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;" required>
                <button class="button-blue" type="submit" name="add_user">Felhasználó hozzáadása</button>
            </form>
            <form action="../src/actions/RemoveUser.php" method="POST">
                <label for="user_id">Felhasználó ID:</label>
                <input type="text" id="user_id" class="card" name="user_id" placeholder="#1" required>
                <button class="button-blue" type="submit" name="remove_user">Felhasználó eltávolítása</button>
            </form>
        </div>
        <div class="product-management">
            <?php if (isset($_GET['success']) && $product) { echo '<div class="alert alert-success" role="alert">' . $success_message  . '</div>';} ?>
            <script>
                function previewImage(event) {
                    var reader = new FileReader();
                    reader.onload = function() {
                        var output = document.getElementById('imagePreview');
                        output.src = reader.result;
                        output.style.display = 'block';
                    }
                    reader.readAsDataURL(event.target.files[0]);
                }
            </script>
            <h2>Termékek kezelése</h2>
            <form action="../src/actions/AddProduct.php" method="POST" enctype="multipart/form-data">
                <label for="item_image">Termék kép:</label>
                <p style="margin: 0;font-size: 15px;">JPG formátum, max 500kb</p>
                <img id="imagePreview" src="#" alt="Előnézet" style="max-width: 200px; max-height: 200px;">
                <input type="file" id="item_image" name="item_image" accept="image/*" onchange="previewImage(event)" required>
                <label for="item_name">Termék neve:</label>
                <input type="text" id="item_name" class="card" name="item_name" placeholder="Rolex Submariner" required>
                <label for="item_price">Termék ára:</label>
                <input type="number" id="item_price" class="card" name="item_price" placeholder="6000" required>
                <button class="button-blue" type="submit" name="add_item">Termék hozzáadása</button>
            </form>
            <form action="../src/actions/RemoveProduct.php" method="POST">
                <label for="item_id">Termék ID:</label>
                <input type="number" id="item_id" class="card" name="item_id" placeholder="#1" required>
                <button class="button-blue" type="submit">Termék eltávolítása</button>
            </form>
        </div>
    </div>
    <script src="../src/js/getUserData.js"></script>
    <script src="../src/js/getProductData.js"></script>
    <?php include 'elements/footer.php'; ?>
</body>
</html>
