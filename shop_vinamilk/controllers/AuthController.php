<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/PasswordReset.php';
require_once __DIR__ . '/../services/EmailService.php';

class AuthController
{
    private $userModel;
    private $passwordResetModel;
    private $emailService;

    public function __construct()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        $this->userModel = new User();
        $this->passwordResetModel = new PasswordReset();
        $this->emailService = new EmailService();
    }

    public function showLogin()
    {
        if (isset($_SESSION['user_id'])) {
            header("Location: index.php");
            exit;
        }

        require_once __DIR__ . '/../views/header.php';
        require_once __DIR__ . '/../views/login.php';
        require_once __DIR__ . '/../views/footer.php';
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->showLogin();
            return;
        }

        $phone = $_POST['phone'] ?? '';
        $password = $_POST['password'] ?? '';
        $error = '';

        if (empty($phone) || empty($password)) {
            $error = 'Vui lòng nhập đầy đủ số điện thoại và mật khẩu';
        } else {
            $user = $this->userModel->login($phone, $password);

            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_phone'] = $user['phone'];
                $_SESSION['user_name'] = $user['full_name'];

                header("Location: index.php");
                exit;
            } else {
                $error = 'Số điện thoại hoặc mật khẩu không đúng';
            }
        }

        require_once __DIR__ . '/../views/header.php';
        require_once __DIR__ . '/../views/login.php';
        require_once __DIR__ . '/../views/footer.php';
    }

    public function showRegister()
    {
        if (isset($_SESSION['user_id'])) {
            header("Location: index.php");
            exit;
        }

        require_once __DIR__ . '/../views/header.php';
        require_once __DIR__ . '/../views/register.php';
        require_once __DIR__ . '/../views/footer.php';
    }

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

        if (empty($phone) || empty($password)) {
            $error = 'Vui lòng nhập đầy đủ số điện thoại và mật khẩu';
        } elseif (strlen($password) < 6) {
            $error = 'Mật khẩu phải có ít nhất 6 ký tự';
        } elseif ($password !== $confirm_password) {
            $error = 'Mật khẩu xác nhận không khớp';
        } elseif (!preg_match('/^[0-9]{10}$/', $phone)) {
            $error = 'Số điện thoại không hợp lệ (phải có 10 số)';
        } else {
            $result = $this->userModel->register($phone, $password, $full_name, $email);

            if ($result) {
                $user = $this->userModel->findByPhone($phone);
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_phone'] = $user['phone'];
                $_SESSION['user_name'] = $user['full_name'];

                header("Location: index.php");
                exit;
            } else {
                $error = 'Số điện thoại đã được đăng ký';
            }
        }

        require_once __DIR__ . '/../views/header.php';
        require_once __DIR__ . '/../views/register.php';
        require_once __DIR__ . '/../views/footer.php';
    }

    public function logout()
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_phone']);
        unset($_SESSION['user_name']);
        unset($_SESSION['cart']);

        session_destroy();
        session_start();

        header("Location: index.php");
        exit;
    }

    public static function isLoggedIn()
    {
        return isset($_SESSION['user_id']);
    }

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

    // === QUÊN MẬT KHẨU - GỬI EMAIL THẬT ===

    public function showForgotPassword()
    {
        require_once __DIR__ . '/../views/header.php';
        require_once __DIR__ . '/../views/forgot_password.php';
        require_once __DIR__ . '/../views/footer.php';
    }

    public function sendResetCode()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->showForgotPassword();
            return;
        }

        $email = trim($_POST['email'] ?? '');
        $error = '';

        if (empty($email)) {
            $error = 'Vui lòng nhập email';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = 'Email không hợp lệ';
        } else {
            // Kiểm tra email có tồn tại không
            $user = $this->userModel->findByEmail($email);

            if (!$user) {
                $error = 'Email không tồn tại trong hệ thống';
            } else {
                // Tạo mã xác nhận
                $code = $this->passwordResetModel->createResetCode($email);

                if ($code) {
                    // GỬI EMAIL THẬT
                    $emailSent = $this->emailService->sendResetCode(
                        $email,
                        $code,
                        $user['full_name']
                    );

                    if ($emailSent) {
                        $_SESSION['reset_email'] = $email;
                        header("Location: index.php?controller=auth&action=showVerifyCode");
                        exit;
                    } else {
                        $error = 'Lỗi khi gửi email. Vui lòng kiểm tra cấu hình SMTP';
                    }
                } else {
                    $error = 'Lỗi khi tạo mã xác nhận. Vui lòng thử lại';
                }
            }
        }

        require_once __DIR__ . '/../views/header.php';
        require_once __DIR__ . '/../views/forgot_password.php';
        require_once __DIR__ . '/../views/footer.php';
    }

    public function showVerifyCode()
    {
        if (!isset($_SESSION['reset_email'])) {
            header("Location: index.php?controller=auth&action=showForgotPassword");
            exit;
        }

        require_once __DIR__ . '/../views/header.php';
        require_once __DIR__ . '/../views/verify_code.php';
        require_once __DIR__ . '/../views/footer.php';
    }

    public function resetPassword()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->showVerifyCode();
            return;
        }

        $email = $_SESSION['reset_email'] ?? '';
        $code = trim($_POST['code'] ?? '');
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        $error = '';

        if (empty($code)) {
            $error = 'Vui lòng nhập mã xác nhận';
        } elseif (empty($newPassword) || empty($confirmPassword)) {
            $error = 'Vui lòng nhập mật khẩu mới';
        } elseif (strlen($newPassword) < 6) {
            $error = 'Mật khẩu phải có ít nhất 6 ký tự';
        } elseif ($newPassword !== $confirmPassword) {
            $error = 'Mật khẩu xác nhận không khớp';
        } else {
            // Kiểm tra mã xác nhận
            $resetData = $this->passwordResetModel->verifyCode($email, $code);

            if (!$resetData) {
                $error = 'Mã xác nhận không đúng hoặc đã hết hạn';
            } else {
                // Lấy user theo email
                $user = $this->userModel->findByEmail($email);

                if ($user) {
                    // Đổi mật khẩu
                    $updated = $this->userModel->changePassword($user['id'], $newPassword);

                    if ($updated) {
                        // Đánh dấu mã đã sử dụng
                        $this->passwordResetModel->markAsUsed($email, $code);

                        // Xóa session
                        unset($_SESSION['reset_email']);

                        // Thông báo thành công
                        $_SESSION['reset_success'] = 'Đổi mật khẩu thành công! Vui lòng đăng nhập';
                        header("Location: index.php?controller=auth&action=showLogin");
                        exit;
                    } else {
                        $error = 'Lỗi khi cập nhật mật khẩu';
                    }
                } else {
                    $error = 'Không tìm thấy tài khoản';
                }
            }
        }

        require_once __DIR__ . '/../views/header.php';
        require_once __DIR__ . '/../views/verify_code.php';
        require_once __DIR__ . '/../views/footer.php';
    }
}
