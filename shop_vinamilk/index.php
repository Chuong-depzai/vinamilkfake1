<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/controllers/ProductController.php';
require_once __DIR__ . '/controllers/CartController.php';
require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/controllers/StoreController.php';
require_once __DIR__ . '/controllers/ReviewController.php'; // Đã thêm file này ở Bước 3

$controller = isset($_GET['controller']) ? $_GET['controller'] : 'product';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';
$id = isset($_GET['id']) ? intval($_GET['id']) : null;

switch ($controller) {
    case 'product':
        $productController = new ProductController();
        switch ($action) {
            case 'show':
                if ($id) $productController->show($id);
                else $productController->index();
                break;
            case 'admin':
                $productController->admin();
                break;
            case 'create':
                $productController->create();
                break;
            case 'edit':
                if ($id) $productController->edit($id);
                else $productController->admin();
                break;
            case 'delete':
                if ($id) $productController->delete($id);
                else $productController->admin();
                break;
            default:
                $productController->index();
                break;
        }
        break;

    case 'cart':
        $cartController = new CartController();
        switch ($action) {
            case 'view': $cartController->view(); break;
            case 'add': $cartController->add(); break;
            case 'update': $cartController->update(); break;
            case 'remove': $cartController->remove(); break;
            case 'clear': $cartController->clear(); break;
            case 'checkout': $cartController->checkout(); break;
            default: $cartController->view(); break;
        }
        break;

    case 'auth':
        $authController = new AuthController();
        switch ($action) {
            case 'showLogin': $authController->showLogin(); break;
            case 'login': $authController->login(); break;
            case 'showRegister': $authController->showRegister(); break;
            case 'register': $authController->register(); break;
            case 'logout': $authController->logout(); break;
            case 'showForgotPassword': $authController->showForgotPassword(); break;
            case 'sendResetCode': $authController->sendResetCode(); break;
            case 'showVerifyCode': $authController->showVerifyCode(); break;
            case 'resetPassword': $authController->resetPassword(); break;
            default: $authController->showLogin(); break;
        }
        break;

    case 'store':
        $storeController = new StoreController();
        switch ($action) {
            case 'api': $storeController->api(); break;
            default: $storeController->index(); break;
        }
        break;

    case 'review':
        $reviewController = new ReviewController();
        switch ($action) {
            case 'create':
                $reviewController->create();
                break;
            case 'load':
                $reviewController->load();
                break;
            default:
                header("HTTP/1.0 404 Not Found");
                exit;
        }
        break;
} // ✅ Đã đóng ngoặc switch controller
?>