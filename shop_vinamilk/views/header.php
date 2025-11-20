<?php
if (!isset($_SESSION)) {
    session_start();
}
require_once __DIR__ . '/../models/Cart.php';
require_once __DIR__ . '/../controllers/AuthController.php';

$cartModel = new Cart();
$cartCount = $cartModel->getCount();

$isLoggedIn = AuthController::isLoggedIn();
$currentUser = AuthController::getCurrentUser();
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vinamilk </title>
    <style>
        <?php include __DIR__ . '/../css/style.css'; ?>
    </style>
</head>

<body>
    <nav class="navbar">
        <div class="navbar-container">
            <a href="index.php" class="navbar-logo">
                <span class="logo-text">Vinamilk</span>
            </a>
            <ul class="navbar-menu">
                <li class="navbar-item">
                    <a href="index.php" class="navbar-link">Danh mục sản phẩm</a>
                </li>
                <li class="navbar-item">
                    <a href="index.php?controller=cart&action=view" class="navbar-link">
                        Giỏ hàng
                        <?php if ($cartCount > 0): ?>
                            <span class="cart-badge"><?php echo $cartCount; ?></span>
                        <?php endif; ?>
                    </a>
                </li>
                <li class="navbar-item">
                    <a href="index.php?controller=store" class="navbar-link"> Cửa Hàng</a>
                </li>

                <?php if ($isLoggedIn): ?>
                    <!-- ✅ CHỈ HIỂN THỊ KHI ĐÃ ĐĂNG NHẬP -->
                    <li class="navbar-item">
                        <a href="index.php?controller=product&action=admin" class="navbar-link">Quản lý sản phẩm</a>
                    </li>

                    <li class="navbar-item user-menu">
                        <div class="navbar-link user-name">
                            👤 <?php echo htmlspecialchars($currentUser['name'] ?: $currentUser['phone']); ?>
                        </div>

                        <div class="user-dropdown">
                            <a href="index.php?controller=auth&action=logout" class="dropdown-item">
                                Đăng xuất
                            </a>
                        </div>
                    </li>
                <?php else: ?>
                    <!-- Nếu chưa đăng nhập -->
                    <li class="navbar-item">
                        <a href="index.php?controller=auth&action=showLogin" class="navbar-link">Đăng nhập</a>
                    </li>
                    <li class="navbar-item">
                        <a href="index.php?controller=auth&action=showRegister" class="navbar-link-register">Đăng ký</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
    <main class="main-content">