<?php
// models/Order.php
require_once __DIR__ . '/../db.php';

class Order
{
    private $db;

    public function __construct()
    {
        $this->db = getDB();
    }

    // Tạo đơn hàng mới
    public function create($userId, $cartItems, $shippingInfo)
    {
        try {
            $this->db->beginTransaction();

            // Tính tổng tiền
            $totalAmount = 0;
            foreach ($cartItems as $item) {
                $totalAmount += $item['subtotal'];
            }

            // Insert đơn hàng
            $sql = "INSERT INTO orders (user_id, total_amount, shipping_name, shipping_phone, shipping_address, notes) 
                    VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                $userId,
                $totalAmount,
                $shippingInfo['name'] ?? '',
                $shippingInfo['phone'] ?? '',
                $shippingInfo['address'] ?? '',
                $shippingInfo['notes'] ?? ''
            ]);

            $orderId = $this->db->lastInsertId();

            // Insert chi tiết đơn hàng
            $sql = "INSERT INTO order_items (order_id, product_id, product_name, product_price, quantity, subtotal) 
                    VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $this->db->prepare($sql);

            foreach ($cartItems as $item) {
                $stmt->execute([
                    $orderId,
                    $item['id'],
                    $item['name'],
                    $item['price'],
                    $item['quantity'],
                    $item['subtotal']
                ]);
            }

            $this->db->commit();
            return $orderId;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    // Lấy đơn hàng theo user
    public function getByUserId($userId)
    {
        $sql = "SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    // Lấy chi tiết đơn hàng
    public function getById($orderId)
    {
        $sql = "SELECT o.*, u.full_name, u.phone, u.email 
                FROM orders o
                JOIN users u ON o.user_id = u.id
                WHERE o.id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$orderId]);
        return $stmt->fetch();
    }

    // Lấy các sản phẩm trong đơn hàng
    public function getOrderItems($orderId)
    {
        $sql = "SELECT * FROM order_items WHERE order_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$orderId]);
        return $stmt->fetchAll();
    }

    // Cập nhật trạng thái đơn hàng
    public function updateStatus($orderId, $status)
    {
        $sql = "UPDATE orders SET status = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$status, $orderId]);
    }

    // Hủy đơn hàng
    public function cancel($orderId, $userId)
    {
        $sql = "UPDATE orders SET status = 'cancelled' WHERE id = ? AND user_id = ? AND status = 'pending'";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$orderId, $userId]);
    }

    // Đếm số đơn hàng theo trạng thái
    public function countByStatus($userId, $status = null)
    {
        if ($status) {
            $sql = "SELECT COUNT(*) FROM orders WHERE user_id = ? AND status = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$userId, $status]);
        } else {
            $sql = "SELECT COUNT(*) FROM orders WHERE user_id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$userId]);
        }
        return $stmt->fetchColumn();
    }
}
