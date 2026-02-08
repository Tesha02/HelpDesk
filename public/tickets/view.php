<?php
require_once __DIR__ . '/../../app/helpers.php';
require_once __DIR__ . '/../../app/auth.php';
require_once __DIR__ . '/../../app/repositories/TicketRepository.php';
require_once __DIR__ . '/../../app/repositories/UserRepository.php';
require_once __DIR__ . '/../../app/repositories/CommentRepository.php';
require_once __DIR__ . '/../../app/middleware.php';

$ticketRepo = new TicketRepository();
$userRepo = new UserRepository();

$id = (int) $_GET['id'];
$ticket = $ticketRepo->findById($id);
$user = currentUser();
requireTicket($user, $ticket);

$commRepo = new CommentRepository();
if (isPost()) {
    $text = trim($_POST['comm']);
    if (strlen($text) === 0)
        return;
    $commRepo->create($ticket['id'], $user['id'], $text);
}

$comments = $commRepo->commByTicketId($ticket['id']);
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
    <p>User: </p>
    <p><?php echo e($user['username']) ?></p>
    <p>Title: </p>
    <p><?php echo e($ticket['title']) ?></p>
    <p>Description: </p>
    <p><?php echo e($ticket['description']) ?></p>
    <p>Category: </p>
    <p><?php echo e($ticket['category']) ?></p>
    <p>Priority: </p>
    <p><?php echo e($ticket['priority']) ?></p>
    <p>Status: </p>
    <p><?php echo e($ticket['status']) ?></p>
    <h3>KOMENTARI: </h3>
    <?php foreach ($comments as $c):
        $user = $userRepo->findById($c['user_id']); ?>
        <p>User: <?php echo e($user['username']) ?></p>
        <p>Text: <?php echo e($c['body']) ?></p>
    <?php endforeach; ?>

    <form method="POST">
        <label>Komentar: </label><br>
        <textarea name="comm" rows="5" cols="40"></textarea><br>
        <button type="submit">Komentarisi</button>
    </form>
</body>

</html>