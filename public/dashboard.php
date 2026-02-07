<?php
require_once "../app/helpers.php";
require_once "../app/auth.php";


?>

<!doctype html>
<html lang="sr">

<head>
    <meta charset="utf-8">
    <title>Help Desk - Dashboard</title>
</head>

<body>
    <h1>DASHBOARD</h1>
    <h3>Zdravo, <?php echo currentUser()['username']; ?></h3>
    <nav>
        <a href="tickets/list.php">Lista tiketa</a>
        <a href="tickets/create.php">Napravi tiket</a>
        <?php if (isAdmin()): ?>
            <a href="admin/tickets.php">Admin tiketi</a>
        <?php endif ?>
        <a href="logout.php">Logout</a>
    </nav>
</body>

</html>