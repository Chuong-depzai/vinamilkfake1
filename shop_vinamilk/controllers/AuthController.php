<?php
require_once __DIR__ . '/../models/User.php';

class AuthController
{
    private $userModel;

    public function __construct()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        $this->userModel = new User();
    }

    // Hiển thị trang đăng nhập
    public function showLogin()
    {
        // Nếu đã đăng nhập rồi thì chuyển về trang chủ
        if (isset($_SESSION['user_id'])) {
            header("Location: index.php");
            exit;
        }

        require_once __DIR__ . '/../views/header.php';
        require_once __DIR__ . '/../views/login.php';
        require_once __DIR__ . '/../views/footer.php';
    }

    // Xử lý đăng nhập
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->showLogin();
            return;
        }

        $phone = $_POST['phone'] ?? '';
        $password = $_POST['password'] ?? '';
        $error = '';

        // Validate
        if (empty($phone) || empty($password)) {
            $error = 'Vui lòng nhập đầy đủ số điện thoại và mật khẩu';
        } else {
            // Đăng nhập
            $user = $this->userModel->login($phone, $password);

            if ($user) {
                // Lưu thông tin vào session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_phone'] = $user['phone'];
                $_SESSION['user_name'] = $user['full_name'];

                // Chuyển về trang chủ
                header("Location: index.php");
                exit;
            } else {
                $error = 'Số điện thoại hoặc mật khẩu không đúng';
            }
        }

        // Nếu có lỗi, hiển thị lại form
        require_once __DIR__ . '/../views/header.php';
        require_once __DIR__ . '/../views/login.php';
        require_once __DIR__ . '/../views/footer.php';
    }

    // Hiển thị trang đăng ký
    public function showRegister()
    {
        // Nếu đã đăng nhập rồi thì chuyển về trang chủ
        if (isset($_SESSION['user_id'])) {
            header("Location: index.php");
            exit;
        }

        require_once __DIR__ . '/../views/header.php';
        require_once __DIR__ . '/../views/register.php';
        require_once __DIR__ . '/../views/footer.php';
    }

    // Xử lý đăng ký
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->showRegister();
            return;
        }

        $phone = $_POST['phone'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';
        $full_name = $_POST['full_name'] ?? '';
        $email = $_POST['email'] ?? '';
        $error = '';

        // Validate
        if (empty($phone) || empty($password)) {
            $error = 'Vui lòng nhập đầy đủ số điện thoại và mật khẩu';
        } elseif (strlen($password) < 6) {
            $error = 'Mật khẩu phải có ít nhất 6 ký tự';
        } elseif ($password !== $confirm_password) {
            $error = 'Mật khẩu xác nhận không khớp';
        } elseif (!preg_match('/^[0-9]{10}$/', $phone)) {
            $error = 'Số điện thoại không hợp lệ (phải có 10 số)';
        } else {
            // Đăng ký
            $result = $this->userModel->register($phone, $password, $full_name, $email);

            if ($result) {
                // Đăng ký thành công, tự động đăng nhập
                $user = $this->userModel->findByPhone($phone);
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_phone'] = $user['phone'];
                $_SESSION['user_name'] = $user['full_name'];

                // Chuyển về trang chủ
                header("Location: index.php");
                exit;
            } else {
                $error = 'Số điện thoại đã được đăng ký';
            }
        }

        // Nếu có lỗi, hiển thị lại form
        require_once __DIR__ . '/../views/header.php';
        require_once __DIR__ . '/../views/register.php';
        require_once __DIR__ . '/../views/footer.php';
    }

    // Đăng xuất
    public function logout()
    {
        // Xóa thông tin user
        unset($_SESSION['user_id']);
        unset($_SESSION['user_phone']);
        unset($_SESSION['user_name']);

        // Xóa giỏ hàng - QUAN TRỌNG
        unset($_SESSION['cart']);

        // Hoặc có thể destroy toàn bộ session (khuyến nghị)
        session_destroy();
        session_start(); // Mở lại session mới

        // Chuyển về trang chủ
        header("Location: index.php");
        exit;
    }

    // Kiểm tra đã đăng nhập chưa
    public static function isLoggedIn()
    {
        return isset($_SESSION['user_id']);
    }

    // Lấy thông tin user hiện tại
    public static function getCurrentUser()
    {
        if (self::isLoggedIn()) {
            return [
                'id' => $_SESSION['user_id'],
                'phone' => $_SESSION['user_phone'],
                'name' => $_SESSION['user_name']
            ];
        }
        return null;
    }
}
