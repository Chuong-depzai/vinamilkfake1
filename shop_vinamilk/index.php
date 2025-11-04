<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/controllers/ProductController.php';
require_once __DIR__ . '/controllers/CartController.php';

$controller = isset($_GET['controller']) ? $_GET['controller'] : 'product';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';
$id = isset($_GET['id']) ? intval($_GET['id']) : null;

switch ($controller) {
    case 'product':
        $productController = new ProductController();
        switch ($action) {
            case 'show':
                if ($id) {
                    $productController->show($id);
                } else {
                    $productController->index();
                }
                break;
            case 'admin':
                $productController->admin();
                break;
            case 'create':
                $productController->create();
                break;
            case 'edit':
                if ($id) {
                    $productController->edit($id);
                } else {
                    $productController->admin();
                }
                break;
            case 'delete':
                if ($id) {
                    $productController->delete($id);
                } else {
                    $productController->admin();
                }
                break;
            default:
                $productController->index();
                break;
        }
        break;

    case 'cart':
        $cartController = new CartController();
        switch ($action) {
            case 'view':
                $cartController->view();
                break;
            case 'add':
                $cartController->add();
                break;
            case 'update':
                $cartController->update();
                break;
            case 'remove':
                $cartController->remove();
                break;
            case 'clear':
                $cartController->clear();
                break;
            case 'checkout':
                $cartController->checkout();
                break;
            default:
                $cartController->view();
                break;
        }
        break;

    default:
        $productController = new ProductController();
        $productController->index();
        break;
}
