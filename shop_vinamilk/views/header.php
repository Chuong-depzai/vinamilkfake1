<?php
if (!isset($_SESSION)) {
    session_start();
}
require_once __DIR__ . '/../models/Cart.php';
$cartModel = new Cart();
$cartCount = $cartModel->getCount();
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vinamilk - Cửa hàng trực tuyến</title>
    <style>
        <?php include __DIR__ . '/../css/style.css'; ?>
    </style>
</head>

<body>
    <nav class="navbar">
        <div class="navbar-container">
            <a href="/shop_vinamilk/" class="navbar-logo">
                <span class="logo-text">Vinamilk</span>
            </a>
            <ul class="navbar-menu">
                <li class="navbar-item">
                    <a href="/shop_vinamilk/" class="navbar-link">Danh mục sản phẩm</a>
                </li>
                <li class="navbar-item">
                    <a href="/shop_vinamilk/index.php?controller=cart&action=view" class="navbar-link">
                        Giỏ hàng
                        <?php if ($cartCount > 0): ?>
                            <span class="cart-badge"><?php echo $cartCount; ?></span>
                        <?php endif; ?>
                    </a>
                </li>
                <li class="navbar-item">
                    <a href="/shop_vinamilk/index.php?controller=product&action=admin" class="navbar-link">Quản lý sản phẩm</a>
                </li>
            </ul>
        </div>
    </nav>
    <main class="main-content"></main>