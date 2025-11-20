<?php
require_once __DIR__ . '/../db.php';

class User
{
    private $db;

    public function __construct()
    {
        $this->db = getDB();
    }

    public function register($phone, $password, $full_name = '', $email = '')
    {
        if ($this->findByPhone($phone)) {
            return false;
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (phone, password, full_name, email) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$phone, $hashedPassword, $full_name, $email]);
    }

    public function login($phone, $password)
    {
        $user = $this->findByPhone($phone);

        if (!$user) {
            return false;
        }

        if (password_verify($password, $user['password'])) {
            return $user;
        }

        return false;
    }

    public function findByPhone($phone)
    {
        $sql = "SELECT * FROM users WHERE phone = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$phone]);
        return $stmt->fetch();
    }

    // === METHOD MỚI ===
    public function findByEmail($email)
    {
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    public function findById($id)
    {
        $sql = "SELECT * FROM users WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function update($id, $full_name, $email)
    {
        $sql = "UPDATE users SET full_name = ?, email = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$full_name, $email, $id]);
    }

    public function changePassword($id, $newPassword)
    {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET password = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$hashedPassword, $id]);
    }
}
