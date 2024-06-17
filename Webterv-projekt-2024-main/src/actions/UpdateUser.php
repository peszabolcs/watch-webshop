<?php
require_once 'DataControl.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../../pages/login.php");
    exit;
}

if (isset($_POST['saveChanges'])) {
    $dataControl = new DataControl();

    if (!isset($_POST['newUsername']) || !isset($_POST['newEmail'])) {
        header("Location: ../../pages/profile.php?error=BadRequest");
        exit;
    }

    $userId = $_SESSION['user']['id'];
    $newUsername = $_POST['newUsername'];
    $newEmail = $_POST['newEmail'];

    $updateSuccess = $dataControl->update_user("../../data/db.json", $userId, ['username' => $newUsername, 'email' => $newEmail]);

    if ($updateSuccess) {
        $_SESSION['user']['username'] = $newUsername;
        $_SESSION['user']['email'] = $newEmail;
        header("Location: ../../pages/profile.php?success=ProfileSuccessfullyUpdated");
    } else {
        header("Location: ../../pages/profile.php?error=InternalServerError");
    }
} else {
    header("Location: ../../pages/profile.php?error=MethodNotAllowed");
}
exit;