<?php
require_once __DIR__ . '/../db.php';

class User
{
    private $db;

    public function __construct()
    {
        $this->db = getDB();
    }

    // Đăng ký user mới
    public function register($phone, $password, $full_name = '', $email = '')
    {
        // Kiểm tra số điện thoại đã tồn tại chưa
        if ($this->findByPhone($phone)) {
            return false; // Số điện thoại đã được đăng ký
        }

        // Mã hóa mật khẩu
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (phone, password, full_name, email) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$phone, $hashedPassword, $full_name, $email]);
    }

    // Đăng nhập
    public function login($phone, $password)
    {
        $user = $this->findByPhone($phone);

        if (!$user) {
            return false; // Không tìm thấy user
        }

        // Kiểm tra mật khẩu
        if (password_verify($password, $user['password'])) {
            return $user; // Đăng nhập thành công, trả về thông tin user
        }

        return false; // Sai mật khẩu
    }

    // Tìm user theo số điện thoại
    public function findByPhone($phone)
    {
        $sql = "SELECT * FROM users WHERE phone = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$phone]);
        return $stmt->fetch();
    }

    // Tìm user theo ID
    public function findById($id)
    {
        $sql = "SELECT * FROM users WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // Cập nhật thông tin user
    public function update($id, $full_name, $email)
    {
        $sql = "UPDATE users SET full_name = ?, email = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$full_name, $email, $id]);
    }

    // Đổi mật khẩu
    public function changePassword($id, $newPassword)
    {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET password = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$hashedPassword, $id]);
    }
}
