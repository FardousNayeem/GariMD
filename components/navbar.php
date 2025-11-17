<?php
$current = basename($_SERVER['PHP_SELF']);
$is_admin = str_contains($_SERVER['PHP_SELF'], '/admin/');

$root_prefix = $is_admin ? '..' : '.';
?>
<header class="site-header">
    <div class="wrap nav-flex">
        <h1><a class="brand" href="<?= $root_prefix ?>/index.php">GariMD</a></h1>

        <nav>
            <a href="<?= $root_prefix ?>/index.php" class="<?= $current=='index.php'?'active':'' ?>">Home</a>
            <a href="<?= $root_prefix ?>/mechanic_availability.php" class="<?= $current=='mechanic_availability.php'?'active':'' ?>">Mechanic Availability</a>
            <a href="<?= $root_prefix ?>/help.php" class="<?= $current=='help.php'?'active':'' ?>">Help</a>

            <?php if ($is_admin): ?>
                <a href="dashboard.php" class="<?= $current=='dashboard.php'?'active':'' ?>">Dashboard</a>
                <a href="mechanics.php" class="<?= $current=='mechanics.php'?'active':'' ?>">Mechanics</a>
                <a href="availability.php" class="<?= $current=='availability.php'?'active':'' ?>">Mechanic Availability</a>
                <a href="logout.php">Logout</a>
            <?php else: ?>
                <a href="<?= $root_prefix ?>/admin/login.php" class="<?= $current=='login.php'?'active':'' ?>">Admin</a>
            <?php endif; ?>
        </nav>
    </div>
</header>
