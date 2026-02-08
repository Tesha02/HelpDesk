<?php
require_once __DIR__ . '/../../app/auth.php';
require_once __DIR__ . '/../../app/repositories/TicketRepository.php';
require_once __DIR__ . '/../../app/repositories/UserRepository.php';
require_once __DIR__ . '/../../app/helpers.php';

$ticketRepo = new TicketRepository();
$order = $_GET['sort'] ?? 'created_at';
$tickets = $ticketRepo->AllTickets($order);

?>

<!doctype html>
<html lang="sr">

<head>
    <meta charset="utf-8">
    <title>Help Desk - Ticket List</title>
</head>

<body>
    <h1>Lista svih Tiketa</h1>
    <p><a href="../dashboard.php">Nazad</a></p>
    <p><a href="?sort=priority">Sortiraj po prioritetu</a>
        || <a href="?sort=status">Sortiraj po statusu</a>
        || <a href="tickets.php">Sortiraj po datumu</a>
    </p>
    <table>
        <tr>
            <th>Korisnik</th>
            <th>Title</th>
            <th>Priority</th>
            <th>Status</th>
        </tr>
        <?php foreach ($tickets as $t): ?>
            <tr>
                <?php
                $user_id = (int) $t['user_id'];
                $userRepo = new UserRepository();
                $user = $userRepo->findById($user_id);
                ?>
                <td><?php echo e($user['username']) ?></td>
                <td><?php echo e($t['title']) ?></td>
                <td><?php echo e($t['priority']) ?></td>
                <td><?php echo e($t['status']) ?></td>
                <td>
                    <?php $href = "manage.php?id=" . $t['id']; ?>
                    <a href=<?php echo e($href) ?>>Detalji</a>
                </td>
            </tr>
        <?php endforeach; ?>

    </table>
</body>

</html>