<?php
require_once 'DataControl.php';

if (isset($_POST['user_id'])) {
    $dataControl = new DataControl();
    $users = $dataControl->load_users("../../data/db.json");

    foreach ($users['users'] as $user) {
        if ($user['id'] == $_POST['user_id']) {
            echo $user['email'];
            exit;
        }
    }

    echo "";
}