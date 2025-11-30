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
    <title>Sữa Tươi | Vinamilk </title>
    <link rel="icon" type="image/png" href="uploads/logo.png">
    <link rel="shortcut icon" href="uploads/logo.png" type="image/png">
    <link rel="apple-touch-icon" href="uploads/logo.png">

    <link rel="stylesheet" href="css/new-style.css">
    <link rel="stylesheet" href="css/style.css">

</head>

<body>
    <!-- Header -->
    <header class="site-header">
        <!-- Top bar -->
        <div class="header-top">
            <div class="container-header">
                <div class="header-top-content">
                    <div class="header-top-left">
                        <span>📞 Hotline: 1900 636 979</span>
                        <span>|</span>
                        <a href="index.php?controller=store">🏪 Hệ thống cửa hàng</a>
                    </div>
                    <div class="header-top-right">
                        <?php if ($isLoggedIn): ?>
                            <div class="user-dropdown-wrapper">
                                <span class="user-greeting">
                                    👤 Xin chào, <?php echo htmlspecialchars($currentUser['name'] ?: $currentUser['phone']); ?>
                                </span>
                                <div class="user-dropdown-menu">
                                    <a href="index.php?controller=user&action=profile">Thông tin cá nhân</a>
                                    <a href="index.php?controller=order&action=history">Đơn hàng của tôi</a>
                                    <a href="index.php?controller=wishlist">Danh sách yêu thích</a>
                                    <a href="index.php?controller=auth&action=logout">Đăng xuất</a>
                                </div>
                            </div>
                        <?php else: ?>
                            <a href="index.php?controller=auth&action=showLogin">Đăng nhập</a>
                            <span>|</span>
                            <a href="index.php?controller=auth&action=showRegister">Đăng ký</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main header -->
        <div class="header-main">
            <div class="container-header">
                <div class="header-main-content">
                    <!-- Logo -->
                    <a href="index.php" class="site-logo">
                        <img src="uploads\vinamilk-logo_brandlogos.net_quayf.png"
                            alt="Vinamilk"
                            class="logo-img">
                    </a>

                    <!-- Navigation -->
                    <nav class="main-nav">
                        <ul class="nav-menu">
                            <li class="nav-item">
                                <a href="index.php" class="nav-link">Trang chủ</a>
                            </li>

                            <li class="nav-item has-dropdown">
                                <a href="index.php?controller=product&action=productList" class="nav-link">
                                    Sản phẩm
                                    <svg class="dropdown-icon" width="12" height="8" viewBox="0 0 12 8" fill="none">
                                        <path d="M1 1L6 6L11 1" stroke="currentColor" stroke-width="2" />
                                    </svg>
                                </a>
                                <div class="mega-menu">
                                    <div class="mega-menu-content">
                                        <div class="mega-menu-column">
                                            <h4 class="mega-menu-title">Sữa bột trẻ em</h4>
                                            <ul class="mega-menu-list">
                                                <li><a href="?type=optimum">Optimum Gold</a></li>
                                                <li><a href="?type=yoko">YokoGold +</a></li>
                                                <li><a href="?type=dielac">Dielac Alpha Gold</a></li>
                                                <li><a href="?type=ridielac">Ridielac</a></li>
                                            </ul>
                                        </div>
                                        <div class="mega-menu-column">
                                            <h4 class="mega-menu-title">Sữa tươi</h4>
                                            <ul class="mega-menu-list">
                                                <li><a href="?type=100">Sữa tươi 100%</a></li>
                                                <li><a href="?type=green-farm">Green Farm</a></li>
                                                <li><a href="?type=organic">Sữa tươi Organic</a></li>
                                            </ul>
                                        </div>
                                        <div class="mega-menu-column">
                                            <h4 class="mega-menu-title">Sữa chua</h4>
                                            <ul class="mega-menu-list">
                                                <li><a href="?type=vinamilk-yogurt">Sữa chua uống</a></li>
                                                <li><a href="?type=probi">Probi</a></li>
                                                <li><a href="?type=yo">Sữa chua Yo</a></li>
                                            </ul>
                                        </div>
                                        <div class="mega-menu-column">
                                            <h4 class="mega-menu-title">Sản phẩm khác</h4>
                                            <ul class="mega-menu-list">
                                                <li><a href="?type=condensed-milk">Sữa đặc</a></li>
                                                <li><a href="?type=ice-cream">Kem</a></li>
                                                <li><a href="?type=cheese">Phô mai</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <li class="nav-item">
                                <a href="index.php?controller=store" class="nav-link">Cửa hàng</a>
                            </li>

                            <li class="nav-item">
                                <a href="#about" class="nav-link">Về Vinamilk</a>
                            </li>

                            <?php if ($isLoggedIn): ?>
                                <li class="nav-item">
                                    <a href="index.php?controller=product&action=admin" class="nav-link">Quản lý</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>

                    <!-- Header actions -->
                    <div class="header-actions">
                        <!-- Search -->
                        <button class="action-btn search-btn" onclick="toggleSearch()">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path d="M19 19L13 13M15 8C15 11.866 11.866 15 8 15C4.13401 15 1 11.866 1 8C1 4.13401 4.13401 1 8 1C11.866 1 15 4.13401 15 8Z" stroke="currentColor" stroke-width="2" />
                            </svg>
                        </button>

                        <!-- Wishlist -->
                        <?php if ($isLoggedIn): ?>
                            <a href="index.php?controller=wishlist" class="action-btn wishlist-btn">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                                    <path d="M10 18L2 10C0.5 8.5 0 6.5 1 4.5C2 2.5 4 2 6 3C7 3.5 8 4.5 10 7C12 4.5 13 3.5 14 3C16 2 18 2.5 19 4.5C20 6.5 19.5 8.5 18 10L10 18Z" stroke="currentColor" stroke-width="2" />
                                </svg>
                                <span id="wishlist-count-badge" class="badge" style="display: none;">0</span>
                            </a>
                        <?php endif; ?>

                        <!-- Cart -->
                        <a href="index.php?controller=cart&action=view" class="action-btn cart-btn">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path d="M1 1H4L6 13H16L18 5H5" stroke="currentColor" stroke-width="2" />
                                <circle cx="7" cy="17" r="1" fill="currentColor" />
                                <circle cx="15" cy="17" r="1" fill="currentColor" />
                            </svg>
                            <?php if ($cartCount > 0): ?>
                                <span class="badge"><?php echo $cartCount; ?></span>
                            <?php endif; ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search overlay -->
        <div class="search-overlay" id="searchOverlay">
            <div class="search-overlay-content">
                <button class="search-close" onclick="toggleSearch()">×</button>
                <form class="search-form" action="index.php" method="GET">
                    <input type="hidden" name="controller" value="product">
                    <input type="hidden" name="action" value="search">
                    <input type="text"
                        name="keyword"
                        class="search-input"
                        placeholder="Tìm kiếm sản phẩm...">
                    <button type="submit" class="search-submit">Tìm kiếm</button>
                </form>
            </div>
        </div>
    </header>

    <main class="site-content">

        <script>
            function toggleSearch() {
                document.getElementById('searchOverlay').classList.toggle('active');
            }

            // Load wishlist count
            <?php if ($isLoggedIn): ?>
                fetch('index.php?controller=wishlist&action=getCount')
                    .then(res => res.json())
                    .then(data => {
                        const badge = document.getElementById('wishlist-count-badge');
                        if (badge && data.count > 0) {
                            badge.textContent = data.count;
                            badge.style.display = 'flex';
                        }
                    });
            <?php endif; ?>
        </script>