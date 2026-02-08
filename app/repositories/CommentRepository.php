<?php
require_once __DIR__ . "/../db.php";


class CommentRepository
{
    private $pdo;
    public function __construct()
    {
        global $pdo;
        $this->pdo = $pdo;
    }

    public function create(int $ticket_id, int $user_id, $body)
    {
        $sql = "INSERT INTO comments (ticket_id, user_id, body)
        VALUES(:ticket_id,:user_id,:body)";
        $stmt = $this->pdo->prepare($sql);
        $ok = $stmt->execute(['ticket_id' => $ticket_id, 'user_id' => $user_id, 'body' => $body]);
        if (!$ok) {
            return 0;
        }
        return (int) $this->pdo->lastInsertId();
    }

    public function commByTicketId($ticket_id)
    {
        $sql = "SELECT * FROM comments WHERE ticket_id= :ticket_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['ticket_id' => $ticket_id]);

        $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ;
        return $comments ?? null;
    }
}

?>