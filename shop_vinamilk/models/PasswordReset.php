<?php

require_once __DIR__ . '/../db.php';

class PasswordReset
{
    private $db;

    public function __construct()
    {
        $this->db = getDB();
    }

    // Tạo mã xác nhận 6 số
    public function generateCode()
    {
        return str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
    }

    // Lưu mã xác nhận (hết hạn sau 15 phút)
    public function createResetCode($email)
    {
        // Xóa các mã cũ của email này
        $this->deleteOldCodes($email);

        $code = $this->generateCode();
        $expiresAt = date('Y-m-d H:i:s', strtotime('+2 hours'));
        $sql = "INSERT INTO password_resets (email, code, expires_at) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);

        if ($stmt->execute([$email, $code, $expiresAt])) {
            return $code;
        }
        return false;
    }

    // Kiểm tra mã có hợp lệ không
    public function verifyCode($email, $code)
    {
        $sql = "SELECT * FROM password_resets 
                WHERE email = ? 
                AND code = ? 
                AND is_used = 0 
                AND expires_at > NOW()
                ORDER BY created_at DESC 
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$email, $code]);
        return $stmt->fetch();
    }

    // Đánh dấu mã đã sử dụng
    public function markAsUsed($email, $code)
    {
        $sql = "UPDATE password_resets SET is_used = 1 WHERE email = ? AND code = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$email, $code]);
    }

    // Xóa mã cũ của email
    private function deleteOldCodes($email)
    {
        $sql = "DELETE FROM password_resets WHERE email = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$email]);
    }

    // Xóa các mã đã hết hạn (chạy định kỳ)
    public function cleanExpiredCodes()
    {
        $sql = "DELETE FROM password_resets WHERE expires_at < NOW()";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute();
    }
}
