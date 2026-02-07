<?php
require_once __DIR__ . "/../db.php";

class UserRepository
{
    private PDO $pdo;

    public function __construct()
    {
        global $pdo;
        $this->pdo = $pdo;
    }

    public function findByEmail(string $email)
    {
        $sql = "SELECT * FROM users WHERE users.email= :email LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['email' => $email]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ?? null;
    }

    public function findById(int $id)
    {
        $sql = "SELECT * FROM users WHERE users.id= :id LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ?? null;
    }

    public function create(string $username, string $email, string $password_hash, string $role): int
    {
        $sql = "INSERT INTO users (username, email, password_hash, role)
        VALUES(:username,:email,:pass,:role)";
        $stmt = $this->pdo->prepare($sql);
        $ok = $stmt->execute(['username' => $username, 'email' => $email, 'pass' => $password_hash, 'role' => $role]);
        if (!$ok) {
            return 0;
        }

        return (int) $this->pdo->lastInsertId();
    }
}

?>