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
    <title>Vinamilk - Cửa hàng trực tuyến</title>

    <!-- CSS -->
    <style>
        <?php include __DIR__ . '/../css/style.css'; ?>
    </style>

    <!-- ✅ JavaScript - ĐẶT Ở CUỐI HEAD HOẶC CUỐI BODY -->
    <!-- Tạm thời comment lại vì chưa có file này -->
    <!-- <script src="js/wishlist.js" defer></script> -->
</head>

<body>
    <nav class="navbar">
        <div class="navbar-container">
            <a href="index.php" class="navbar-logo">
                <span class="logo-text">🥛 Vinamilk</span>
            </a>

            <ul class="navbar-menu">
                <li class="navbar-item">
                    <a href="index.php" class="navbar-link">Trang chủ</a>
                </li>

                <li class="navbar-item">
                    <a href="index.php?controller=product" class="navbar-link">Sản phẩm</a>
                </li>

                <li class="navbar-item">
                    <a href="index.php?controller=store" class="navbar-link">Cửa hàng</a>
                </li>

                <li class="navbar-item">
                    <a href="index.php?controller=cart&action=view" class="navbar-link">
                        🛒 Giỏ hàng
                        <?php if ($cartCount > 0): ?>
                            <span class="cart-badge"><?php echo $cartCount; ?></span>
                        <?php endif; ?>
                    </a>
                </li>

                <?php if ($isLoggedIn): ?>
                    <!-- Khi đã đăng nhập -->
                    <li class="navbar-item">
                        <a href="index.php?controller=wishlist" class="navbar-link">
                            ❤️ Yêu thích
                            <span id="wishlist-count-badge" class="cart-badge" style="display: none;">0</span>
                        </a>
                    </li>

                    <li class="navbar-item">
                        <a href="index.php?controller=product&action=admin" class="navbar-link">⚙️ Quản lý</a>
                    </li>

                    <li class="navbar-item user-menu">
                        <div class="navbar-link user-name">
                            👤 <?php echo htmlspecialchars($currentUser['name'] ?: $currentUser['phone']); ?>
                        </div>
                        <div class="user-dropdown">
                            <a href="index.php?controller=user&action=profile" class="dropdown-item">
                                Thông tin cá nhân
                            </a>
                            <a href="index.php?controller=order&action=history" class="dropdown-item">
                                Lịch sử đơn hàng
                            </a>
                            <a href="index.php?controller=auth&action=logout" class="dropdown-item">
                                Đăng xuất
                            </a>
                        </div>
                    </li>

                <?php else: ?>
                    <!-- Khi chưa đăng nhập -->
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