<?php
require_once __DIR__ . '/../../app/helpers.php';
require_once __DIR__ . '/../../app/repositories/TicketRepository.php';
require_once __DIR__ . '/../../app/repositories/UserRepository.php';

if (isGet()) {
    $ticketRepo = new TicketRepository();
    $id = (int) $_GET['id'];
    $ticket = $ticketRepo->findById($id);
    $user_id = (int) $ticket['user_id'];
    $userRepo = new UserRepository();
    $user = $userRepo->findById($user_id);
}
?>
<!doctype html>
<html lang="sr">

<head>
    <meta charset="utf-8">
    <title>Help Desk - Ticket List</title>
</head>

<body>
    <h1>Ticket Details</h1>
    <p><a href="list.php">Nazad</a></p>
    <h3>User: </h3>
    <p><?php echo e($user['username']) ?></p>
    <h3>Title: </h3>
    <p><?php echo e($ticket['title']) ?></p>
    <h3>Description: </h3>
    <p><?php echo e($ticket['description']) ?></p>
    <h3>Category: </h3>
    <p><?php echo e($ticket['category']) ?></p>
    <h3>Priority: </h3>
    <p><?php echo e($ticket['priority']) ?></p>
    <h3>Status: </h3>
    <p><?php echo e($ticket['status']) ?></p>
</body>

</html>