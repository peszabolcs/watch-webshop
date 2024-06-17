<?php
session_start();
unset($_SESSION['hibak']);
class DataControl
{
    function add_user(string $path, array $newUser) {
        $users = $this->load_users($path);
        $users['users'][] = $newUser;
        $this->save_users($path, $users);
    }

    function save_users(string $path, array $users) {
        $json_data = json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        file_put_contents($path, $json_data);
    }

    function load_users(string $path): array {
        if (!file_exists($path) || filesize($path) == 0) {
            return ['users' => []];
        }
        $json = file_get_contents($path);
        $data = json_decode($json, true);
        if ($data === null) {
            return ['users' => []];
        }
        return $data;
    }

    function update_user(string $path, int $userId, array $userData) {
        $users = $this->load_users($path);
        $index = array_search($userId, array_column($users['users'], 'id'));
        if ($index !== false) {
            foreach ($users['users'] as $key => $user) {
                if ($user['id'] !== $userId && ($user['username'] === $userData['username'] || $user['email'] === $userData['email'])) {
                    return false;
                }
            }

            $users['users'][$index] = array_merge($users['users'][$index], $userData);
            $this->save_users($path, $users);
            return true;
        } else {
            return false;
        }
    }

    function add_product(string $path, array $newProduct) {
        $products = $this->load_products($path);
        $products['products'][] = $newProduct;
        $this->save_products($path, $products);
    }

    function save_products(string $path, array $products) {
        $json_data = json_encode($products, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        file_put_contents($path, $json_data);
    }

    function load_products(string $path): array {
        if (!file_exists($path) || filesize($path) == 0) {
            return ['products' => []];
        }
        $json = file_get_contents($path);
        $data = json_decode($json, true);
        if ($data === null) {
            return ['products' => []];
        }
        return $data;
    }

    function add_order(string $path, array $newOrder) {
        $orders = $this->load_orders($path);
        $orders['orders'][] = $newOrder;
        $this->save_orders($path, $orders);
    }

    function save_orders(string $path, array $orders) {
        $json_data = json_encode($orders, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        file_put_contents($path, $json_data);
    }

    function load_user_orders(string $path, int $userId): array {
        $orders = $this->load_orders($path);
        $userOrders = [];

        foreach ($orders['orders'] as $order) {
            if ($order['user_id'] == $userId) {
                $userOrders[] = $order;
            }
        }

        return $userOrders;
    }

    function load_orders(string $path): array {
        if (!file_exists($path) || filesize($path) == 0) {
            return ['orders' => []];
        }
        $json = file_get_contents($path);
        $data = json_decode($json, true);
        if ($data === null) {
            return ['orders' => []];
        }
        return $data;
    }

    function load_admins(string $path): array {
        if (!file_exists($path) || filesize($path) == 0) {
            return ['admins' => []];
        }
        $json = file_get_contents($path);
        $data = json_decode($json, true);
        if ($data === null) {
            return ['admins' => []];
        }
        return $data;
    }

}
