<?php
class UserControl
{
    private $users;

    function __construct(string $path)
    {
        if (!file_exists($path) || filesize($path) == 0) {
            $this->users = [];
        } else {
            $json = file_get_contents($path);
            $data = json_decode($json, true);
            $this->users = $data["users"] ?? [];
        }
    }

    function remove_user(string $id) {
        echo "Current users before removal: " . json_encode($this->users);
        $this->users = array_filter($this->users, function($user) use ($id) {
            return $user["id"] !== $id;
        });
        echo "Current users after removal: " . json_encode($this->users);
    }

    function get_users() {
        return $this->users;
    }

}