<?php
require_once 'DataControl.php';

if (isset($_POST['user_id'])) {
    $userId = intval($_POST['user_id']);

    $dataControl = new DataControl();
    $users = $dataControl->load_users("../../data/db.json");
    $found = false;

    foreach ($users['users'] as $key => $user) {
        if ($user['id'] == $userId) {
            unset($users['users'][$key]);
            $dataControl->save_users("../../data/db.json", $users);
            $found = true;
            header("Location: ../../pages/admin.php?success=user-deleted");
            exit;
        }
    }

    if (!$found) {
        header("Location: ../../pages/admin.php?error=user-invalid");
        exit;
    }
}
