<nav id="navigacio" class="card">
    <img src="/src/img/logo.png" alt="logo" id="logo">
    <ul class="pages">
        <li class="page-links">
            <div class="text-menu">
                <ul>
                    <li><a <?php if ($_SERVER['PHP_SELF'] == "/index.php") echo 'class="active"' ?> href="/index.php">Kezdőlap</a></li>
                    <li><a <?php if ($_SERVER['PHP_SELF'] == "/pages/products.php") echo 'class="active"' ?> href="/pages/products.php">Termékek</a></li>

                    <li <?php if(!(isset($_SESSION['admin']) && $_SESSION['admin'])) {echo 'id="admin_nonactive"';} ?>><a <?php if ($_SERVER['PHP_SELF'] == "/pages/admin.php") echo 'class="active"' ?> href="/pages/admin.php">Admin</a></li>

                    <?php
                        $user_online = false;
                        if (isset($_SESSION['user'])) {$user_online = true;}
                    ?>
                    <li <?php if($user_online) {echo 'id="user_active_h"';} ?> ><a <?php if ($_SERVER['PHP_SELF'] == "/pages/login.php") echo 'class="active"' ?> href="/pages/login.php">Bejelentkezés</a></li>
                    <li <?php if($user_online) {echo 'id="user_active_h"';} ?> ><a <?php if ($_SERVER['PHP_SELF'] == "/pages/register.php") echo 'class="active"' ?> href="/pages/register.php">Regisztráció</a></li>
                    <li <?php if(!$user_online) {echo 'id="user_active_l"';} ?> > <a href="/src/actions/Logout.php">Kijelentkezés</a> </li>
                </ul>
            </div>
        </li>
        <li>
            <div class="icon-menu">
                <ul>
                    <li <?php if(!$user_online) {echo 'class="user_active_h"';} ?>  id="icon2"><a <?php if ($_SERVER['PHP_SELF'] == "/pages/profile.php") echo 'class="active"' ?> href="/pages/profile.php">
                            <img class="nav-icon" src="/src/img/user.png" alt="profil">
                        </a></li>
                    <li id="icon1"><a <?php if ($_SERVER['PHP_SELF'] == "/pages/cart.php") echo 'class="active"' ?> href="/pages/cart.php">
                            <img class="nav-icon" src="/src/img/cart.png" alt="kosar">
                        </a></li>
                </ul>
            </div>
        </li>
    </ul>
</nav>