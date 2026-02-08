<?php
function requireLogin()
{
    if (!isset($_SESSION["user_id"])) {
        redirect("index.php");
        exit;
    }
}

function requireAdmin()
{
    requireLogin();
    $role = $_SESSION["role"] ?? "";
    if ($role !== 'admin') {
        abort(403);
        exit;
    }
}

function requireTicket($user, $ticket)
{
    requireLogin();
    if (!($user['id'] === $ticket['user_id'] || currentUser()['role'] === 'admin')) {
        abort(403);
        exit;
    }
}

?>