<?php
    require_once '../src/actions/DataControl.php';
?>
<!doctype html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Webshop - Profil</title>
    <link rel="stylesheet" type="text/css" href="../src/css/style.css">
    <link rel="icon" type="image/png" href="../src/img/logo.png">
</head>
<body>
    <?php
    $dataControl = new DataControl();
    $username = $_SESSION['user']['username'] ?? '';
    $email = $_SESSION['user']['email'] ?? '';
    $userId = $_SESSION['user']['id'];
    $orders = $dataControl->load_user_orders("../data/db.json", $userId);
    include 'elements/navbar.php'; ?>
    <script>
        function editProfile() {
            document.getElementById('editForm').style.display = 'block';
        }

        function cancelEdit() {
            var originalUsername = '<?php echo $username; ?>';
            var originalEmail = '<?php echo $email; ?>';
            document.getElementById('newUsername').value = originalUsername;
            document.getElementById('newEmail').value = originalEmail;
            document.getElementById('profileForm').reset();
            document.getElementById('editForm').style.display = 'none';
        }

    </script>

    <div class="profile content">
        <div class="profile-container card">
            <h2>Profil adatok</h2>
            <img src="/src/img/profilepic.png" alt="profilkep">
            <p class="name"><?php echo $username; ?></p>
            <p class="email"><?php echo $email; ?></p>
            <div class="functions">
                <a href="#" class="link" onclick="editProfile()">Szerkesztés</a>
            </div>
            <div id="editForm" style="display: none;">
                <form id="profileForm" action="../src/actions/UpdateUser.php" method="POST">
                    <label for="newUsername">Felhasználónév:</label>
                    <input type="text" id="newUsername" name="newUsername" <?php echo 'value="' . $username . '"' ?> >
                    <label for="newEmail">Email:</label>
                    <input type="email" id="newEmail" name="newEmail" <?php echo 'value="' . $email . '"' ?> >
                    <button type="submit" name="saveChanges">Mentés</button>
                    <button type="button" onclick="cancelEdit()">Mégse</button>
                </form>
            </div>
        </div>

        <div class="profile-orders-container card">
            <h2>Korábbi rendelések</h2>
            <table class="megrendelesek-table">
                <thead>
                <tr>
                    <th>Dátum</th>
                    <th>Ár</th>
                    <th>Azonosító</th>
                    <th>Tételek</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($orders as $order) : ?>
                    <tr>
                        <td><?= $order['date'] ?></td>
                        <td><?= $order['total'] ?> USD</td>
                        <td><?= $order['id'] ?></td>
                        <td class="tetelek">
                            <ul>
                                <?php foreach ($order['products'] as $item) : ?>
                                    <li><?= $item['name'] ?? '' ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>
    <?php include 'elements/footer.php'; ?>
</body>
</html>
