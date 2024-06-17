<?php
    include_once "DataControl.php";
    if (session_id() == '') {
        session_start();
    }

    $data = new DataControl();
    $fiokok = $data->load_users("../../data/db.json");
    $hibak = [];
    $success = FALSE;

    function addIdToUser() {
        global $fiokok;
        $maxId = 0;
        foreach ($fiokok['users'] as $user) {
            if ($user['id'] > $maxId) {
                $maxId = $user['id'];
            }
        }
        return ($maxId + 1);
    }

    if (isset($_POST["signup"])) {
        if (!isset($_POST["username"]) || trim($_POST["username"]) === "")
            $hibak[] = "A felhasználónév megadása kötelező!";

        if (!isset($_POST["email"]) || trim($_POST["email"]) === "")
            $hibak[] = "Az email cím megadása kötelező!";

        if (!isset($_POST["password"]) || trim($_POST["password"]) === "" || !isset($_POST["password2"]) || trim($_POST["password2"]) === "")
            $hibak[] = "A jelszó és az ellenőrző jelszó megadása kötelező!";

        $felhasznalonev = $_POST["username"];
        $email = $_POST["email"];
        $jelszo = $_POST["password"];
        $jelszo2 = $_POST["password2"];

        foreach ($fiokok as $fiok) {
            if ($fiok["username"] === $felhasznalonev || $fiok["email"] === $email)
                $hibak[] = "A felhasználónév már foglalt!";
        }

        if (strlen($jelszo) < 5)
            $hibak[] = "A jelszónak legalább 5 karakter hosszúnak kell lennie!";

        if ($jelszo !== $jelszo2)
            $hibak[] = "A jelszó és az ellenőrző jelszó nem egyezik!";

        if (count($hibak) === 0) {
            $jelszo = password_hash($jelszo, PASSWORD_DEFAULT);

            $newUser = [
                "id" => addIdToUser(),
                "username" => $felhasznalonev,
                "password" => $jelszo,
                "email" => $email
            ];
            $data->add_user("../../data/db.json", $newUser);
            $success = TRUE;
        } else {
            foreach ($hibak as $hiba) {
                echo "<p>" . $hiba . "</p>";
            }
        }
    }

    if ($success) {
        header("Location: ../../pages/login.php?success=login-newuser");
    } else {
        $_SESSION['hibak'] = $hibak;
        header("Location: ../../pages/register.php");
    }

?>
