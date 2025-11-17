<?php
session_start();

$current = basename($_SERVER['PHP_SELF']);

$is_admin_file = str_contains($_SERVER['PHP_SELF'], '/admin/');

$root_prefix = $is_admin_file ? '..' : '.';

$admin_logged = isset($_SESSION['admin_logged']);
?>
<header class="site-header">
    <div class="wrap nav-flex">
        <h1><a class="brand" href="<?= $root_prefix ?>/index.php">GariMD</a></h1>

        <nav>

            <a href="<?= $root_prefix ?>/index.php" class="<?= $current=='index.php'?'active':'' ?>">Home</a>

            <?php if (!$admin_logged): ?>
                <a href="<?= $root_prefix ?>/mechanic_availability.php" class="<?= $current=='mechanic_availability.php'?'active':'' ?>">
                    Mechanic Availability
                </a>
            <?php endif; ?>

            <a href="<?= $root_prefix ?>/help.php" class="<?= $current=='help.php'?'active':'' ?>">Help</a>

            <?php if ($admin_logged): ?>
                <a href="<?= $root_prefix ?>/admin/dashboard.php" class="<?= $current=='dashboard.php'?'active':'' ?>">Dashboard</a>
                <a href="<?= $root_prefix ?>/admin/mechanics.php" class="<?= $current=='mechanics.php'?'active':'' ?>">Mechanics</a>
                <a href="<?= $root_prefix ?>/admin/availability.php" class="<?= $current=='availability.php'?'active':'' ?>">Mechanic Availability</a>
                <a href="<?= $root_prefix ?>/admin/logout.php">Logout</a>

            <?php else: ?>
                <a href="<?= $root_prefix ?>/admin/login.php" class="<?= $current=='login.php'?'active':'' ?>">Admin</a>
            <?php endif; ?>

        </nav>
    </div>
</header>
