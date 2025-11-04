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
            header("Location: /shop_vinamilk/index.php");
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
            $data = $this->handleUpload();
            if ($data) {
                $this->productModel->create($data);
                header("Location: /shop_vinamilk/index.php?controller=product&action=admin");
                exit;
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
            header("Location: /shop_vinamilk/index.php?controller=product&action=admin");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $this->handleUpload($product['image']);
            if ($data) {
                $this->productModel->update($id, $data);
                header("Location: /shop_vinamilk/index.php?controller=product&action=admin");
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
        header("Location: /shop_vinamilk/index.php?controller=product&action=admin");
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
            $uploadDir = __DIR__ . '/../uploads/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true); // Tạo thư mục nếu chưa có
            }

            $fileName = time() . '_' . basename($_FILES['image']['name']);
            $targetPath = $uploadDir . $fileName;

            $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
            if (!in_array($_FILES['image']['type'], $allowedTypes)) {
                return false;
            }

            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                // Xóa ảnh cũ nếu có
                if ($oldImage && file_exists($uploadDir . $oldImage)) {
                    unlink($uploadDir . $oldImage);
                }
                $data['image'] = $fileName;
            }
        }

        return $data;
    }
}
