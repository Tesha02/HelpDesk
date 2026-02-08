<?php
require_once __DIR__ . "/../db.php";

class TicketRepository
{
    private $pdo;
    public function __construct()
    {
        global $pdo;
        $this->pdo = $pdo;
    }

    public function create($user_id, $title, $description, $category, $priority, $attachment_path = "")
    {
        $sql = "INSERT INTO tickets(user_id,title,description,category,priority,status,attachment_path)
        VALUES (:user_id,:title,:description,:category,:priority,:status,:attachment_path)";
        $stmt = $this->pdo->prepare($sql);
        $ok = $stmt->execute([
            'user_id' => $user_id,
            'title' => $title,
            'description' => $description,
            'category' => $category,
            'priority' => $priority,
            'status' => 'open',
            'attachment_path' => $attachment_path
        ]);

        if (!$ok)
            return 0;
        return $this->pdo->lastInsertId();
    }

    public function AllTickets()
    {
        $sql = "SELECT * FROM tickets";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        $tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $tickets;
    }

    public function findById(int $id)
    {
        $sql = "SELECT * FROM tickets WHERE tickets.id= :id LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);

        $ticket = $stmt->fetch(PDO::FETCH_ASSOC);
        return $ticket ?? null;
    }

    public function getByUser(int $user_id, string $order, string $direction = 'DESC')
    {
        if ($order === 'created_at') {
            $sql = "
            SELECT * FROM tickets
            WHERE user_id = :user_id
            ORDER BY created_at DESC
            ";
        } else {
            $sql = "SELECT * FROM tickets
            WHERE user_id = :user_id
            ORDER BY
                CASE status
                    WHEN 'open' THEN 1
                    WHEN 'closed' THEN 2
                END,
                CASE priority
                    WHEN 'high' THEN 1
                    WHEN 'medium' THEN 2
                    WHEN 'low' THEN 3
                END";
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['user_id' => $user_id]);

        $tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $tickets;
    }
}


?>