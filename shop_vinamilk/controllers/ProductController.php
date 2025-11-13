<?php
require_once __DIR__ . '/../models/Product.php';
class ProductController
{
    private $productModel;

    public function __construct()
    {
        $this->productModel = new Product();
    }

    // Trang hiển thị danh sách sản phẩm
    public function index()
    {
        $products = $this->productModel->getAll();
        require_once __DIR__ . '/../views/header.php';
        require_once __DIR__ . '/../views/product_list.php';
        require_once __DIR__ . '/../views/footer.php';
    }

    // Trang chi tiết sản phẩm
    public function show($id)
    {
        $product = $this->productModel->getById($id);
        if (!$product) {
            header("Location: /index.php");
            exit;
        }

        require_once __DIR__ . '/../views/header.php';
        require_once __DIR__ . '/../views/product_detail.php';
        require_once __DIR__ . '/../views/footer.php';
    }

    // Trang quản trị sản phẩm
    public function admin()
    {
        $products = $this->productModel->getAll();
        require_once __DIR__ . '/../views/header.php';
        require_once __DIR__ . '/../views/admin_products.php';
        require_once __DIR__ . '/../views/footer.php';
    }

    // Trang thêm sản phẩm mới
    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Debug - kiểm tra dữ liệu POST và FILES
            error_log("POST data: " . print_r($_POST, true));
            error_log("FILES data: " . print_r($_FILES, true));

            $data = $this->handleUpload();
            if ($data) {
                $this->productModel->create($data);
                header("Location: index.php?controller=product&action=admin");
                exit;
            } else {
                echo "<div style='background:red;color:white;padding:20px;'>Lỗi khi upload! Kiểm tra console để xem chi tiết.</div>";
            }
        }

        require_once __DIR__ . '/../views/header.php';
        require_once __DIR__ . '/../views/product_form.php';
        require_once __DIR__ . '/../views/footer.php';
    }
    // Trang sửa sản phẩm
    public function edit($id)
    {
        $product = $this->productModel->getById($id);
        if (!$product) {
            header("Location: /index.php?controller=product&action=admin");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $this->handleUpload($product['image']);
            if ($data) {
                $this->productModel->update($id, $data);
                header("Location: /index.php?controller=product&action=admin");
                exit;
            }
        }

        require_once __DIR__ . '/../views/header.php';
        require_once __DIR__ . '/../views/product_form.php';
        require_once __DIR__ . '/../views/footer.php';
    }

    // Xóa sản phẩm
    public function delete($id)
    {
        $product = $this->productModel->getById($id);
        if ($product && file_exists(__DIR__ . '/../uploads/' . $product['image'])) {
            unlink(__DIR__ . '/../uploads/' . $product['image']);
        }

        $this->productModel->delete($id);
        header("Location: /index.php?controller=product&action=admin");
        exit;
    }

    // Xử lý upload ảnh
    private function handleUpload($oldImage = null)
    {
        $data = [
            'name' => $_POST['name'] ?? '',
            'price' => $_POST['price'] ?? 0,
            'type' => $_POST['type'] ?? '',
            'description' => $_POST['description'] ?? '',
            'ingredients' => $_POST['ingredients'] ?? '',
            'packaging' => $_POST['packaging'] ?? 'Hộp',
            'image' => $oldImage ?? ''
        ];

        // Kiểm tra nếu có upload ảnh
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            // Đường dẫn tuyệt đối đến thư mục uploads
            $uploadDir = __DIR__ . '/../uploads/';

            // Tạo thư mục nếu chưa tồn tại
            if (!file_exists($uploadDir)) {
                if (!mkdir($uploadDir, 0777, true)) {
                    echo "Lỗi: Không thể tạo thư mục uploads!";
                    return false;
                }
            }

            // Kiểm tra quyền ghi
            if (!is_writable($uploadDir)) {
                echo "Lỗi: Thư mục uploads không có quyền ghi!";
                return false;
            }

            // Tạo tên file an toàn
            $extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            $fileName = time() . '_' . uniqid() . '.' . $extension;
            $targetPath = $uploadDir . $fileName;

            // Kiểm tra loại file
            $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
            $fileType = $_FILES['image']['type'];

            if (!in_array($fileType, $allowedTypes)) {
                echo "Lỗi: Chỉ chấp nhận file JPG, PNG, GIF!";
                return false;
            }

            // Kiểm tra kích thước file (max 5MB)
            if ($_FILES['image']['size'] > 5 * 1024 * 1024) {
                echo "Lỗi: File không được vượt quá 5MB!";
                return false;
            }

            // Upload file
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                // Xóa ảnh cũ nếu có
                if ($oldImage && file_exists($uploadDir . $oldImage)) {
                    unlink($uploadDir . $oldImage);
                }
                $data['image'] = $fileName;
            } else {
                echo "Lỗi: Không thể upload file! Error code: " . $_FILES['image']['error'];
                return false;
            }
        }

        return $data;
    }
}
