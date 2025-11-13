<?php
require_once __DIR__ . '/../models/Cart.php';

class CartController
{
    private $cartModel;

    public function __construct()
    {
        $this->cartModel = new Cart();
    }

    private function redirect($controller, $action = '')
    {
        $url = 'index.php?controller=' . $controller;
        if ($action) {
            $url .= '&action=' . $action;
        }
        header("Location: " . $url);
        exit;
    }

    public function view()
    {
        $cartItems = $this->cartModel->getItems();
        $total = $this->cartModel->getTotal();
        require_once __DIR__ . '/../views/header.php';
        require_once __DIR__ . '/../views/cart_view.php';
        require_once __DIR__ . '/../views/footer.php';
    }

    public function add()
    {
        if (isset($_POST['product_id'])) {
            $productId = intval($_POST['product_id']);
            $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
            $this->cartModel->addItem($productId, $quantity);
        }
        $this->redirect('cart', 'view');
    }

    public function update()
    {
        if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
            $productId = intval($_POST['product_id']);
            $quantity = intval($_POST['quantity']);
            $this->cartModel->updateQuantity($productId, $quantity);
        }
        $this->redirect('cart', 'view');
    }

    public function remove()
    {
        if (isset($_GET['id'])) {
            $productId = intval($_GET['id']);
            $this->cartModel->removeItem($productId);
        }
        $this->redirect('cart', 'view');
    }

    public function clear()
    {
        $this->cartModel->clear();
        $this->redirect('cart', 'view');
    }

    public function checkout()
    {
        $cartItems = $this->cartModel->getItems();
        $total = $this->cartModel->getTotal();

        if (empty($cartItems)) {
            $this->redirect('cart', 'view');
        }

        $this->cartModel->clear();

        require_once __DIR__ . '/../views/header.php';
        echo '<div class="checkout-success-container">';
        echo '<div class="checkout-success-box">';
        echo '<h2 class="checkout-success-title">Đặt hàng thành công!</h2>';
        echo '<p class="checkout-success-message">Cảm ơn bạn đã đặt hàng. Chúng tôi sẽ liên hệ với bạn sớm nhất.</p>';
        echo '<p class="checkout-success-total">Tổng tiền: ' . number_format($total, 0, ',', '.') . ' VNĐ</p>';
        echo '<a href="index.php" class="checkout-continue-btn">Tiếp tục mua sắm</a>';
        echo '</div>';
        echo '</div>';
        require_once __DIR__ . '/../views/footer.php';
        exit;
    }
}
