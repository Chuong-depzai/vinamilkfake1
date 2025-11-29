<?php
// Lưu ý: Các biến $product, $reviews, $ratingInfo phải được truyền từ ProductController::show()
// $reviews là array danh sách review, $ratingInfo chứa avg_rating và total

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Hàm hiển thị sao
function display_stars($rating)
{
    $output = '';
    $rating = round($rating);
    for ($i = 1; $i <= 5; $i++) {
        $output .= ($i <= $rating) ? '<span class="star-filled">★</span>' : '<span class="star-empty">☆</span>';
    }
    return $output;
}

// Tính điểm trung bình và tổng số đánh giá
$averageRating = $ratingInfo['avg_rating'] ?? 0;
$totalReviews = $ratingInfo['total'] ?? 0;
?>
<?php
// Debug - kiểm tra dữ liệu
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<!-- DEBUG INFO -->";
echo "<!-- Product ID: " . ($product['id'] ?? 'NULL') . " -->";
echo "<!-- Reviews count: " . count($reviews ?? []) . " -->";
echo "<!-- Rating info: " . print_r($ratingInfo ?? [], true) . " -->";
?>

<div class="page-container">
    <div class="product-detail-container">
        <div class="product-detail-image-section">
            <?php
            $imagePath = "uploads/" . htmlspecialchars($product['image'] ?? '');
            if (!empty($product['image']) && file_exists(__DIR__ . '/../uploads/' . $product['image'] ?? '')):
            ?>
                <img src="<?php echo $imagePath; ?>" alt="<?php echo htmlspecialchars($product['name'] ?? ''); ?>" class="product-detail-image">
            <?php else: ?>
                <div class="product-image-placeholder-large">
                    <span class="placeholder-text">Không có ảnh</span>
                </div>
            <?php endif; ?>
        </div>

        <div class="product-detail-info-section">
            <h1 class="product-detail-name"><?php echo htmlspecialchars($product['name'] ?? ''); ?></h1>

            <div class="product-detail-price-box">
            <span class="product-detail-price"><?php echo number_format($product['price'] ?? 0, 0, ',', '.'); ?> VNĐ</span>
            </div>

            <div class="product-rating-summary" style="margin-bottom: 20px;">
            <span class="rating-stars-lg">
                <?php echo display_stars($averageRating); ?>
            </span>
            <span class="rating-text">
                (<?php echo number_format($averageRating, 1); ?>/5 sao từ <?php echo $totalReviews; ?> đánh giá)
            </span>
            </div>
            <div class="product-detail-meta">
            <div class="product-meta-item">
                <span class="product-meta-label">Loại sản phẩm:</span>
                <span class="product-meta-value"><?php echo htmlspecialchars($product['type'] ?? ''); ?></span>
            </div>
            <div class="product-meta-item">
                <span class="product-meta-label">Quy cách đóng gói:</span>
                <span class="product-meta-value"><?php echo htmlspecialchars($product['packaging'] ?? ''); ?></span>
            </div>
            </div>

            <div class="product-detail-description">
            <h3 class="section-title">Mô tả sản phẩm</h3>
            <p><?php echo nl2br(htmlspecialchars($product['description'] ?? '')); ?></p>
            </div>

            <div class="product-detail-ingredients">
            <h3 class="section-title">Thành phần</h3>
            <p><?php echo nl2br(htmlspecialchars($product['ingredients'] ?? '')); ?></p>
            </div>
            
            <form action="index.php?controller=cart&action=add" method="POST" class="add-to-cart-form">
            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
            <input type="hidden" name="quantity" value="1">
            <button type="submit" class="btn-add-to-cart">
                🛒 Thêm vào Giỏ hàng
            </button>
            </form>

            <?php 
            $inWishlist = false;
            if (isset($_SESSION['user_id'])) {
                require_once __DIR__ . '/../models/Wishlist.php';
                $wishlist = new Wishlist();
                $inWishlist = $wishlist->isInWishlist($_SESSION['user_id'], $product['id']);
            }
            ?>
            
            <button class="btn-wishlist <?php echo $inWishlist ? 'in-wishlist' : ''; ?>" 
                onclick="toggleWishlist(<?php echo $product['id']; ?>)">
            <?php echo $inWishlist ? '💔 Bỏ yêu thích' : '❤️ Thêm vào yêu thích'; ?>
            </button>
        </div>
    </div>

    <div class="product-reviews-container">
        <h2 class="section-title-large">Đánh giá & Bình luận</h2>

        <?php if (isset($_SESSION['user_id'])): ?>
            <div class="review-form-wrapper">
                <h3>Gửi đánh giá của bạn</h3>
                <form action="index.php?controller=review&action=create" method="POST" class="review-form">
                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">

                    <div class="form-group-review">
                        <label for="rating" class="form-label-review">Chọn số sao:</label>
                        <select name="rating" id="rating" class="form-select-review" required>
                            <option value="5">⭐⭐⭐⭐⭐ (Tuyệt vời)</option>
                            <option value="4">⭐⭐⭐⭐ (Tốt)</option>
                            <option value="3">⭐⭐⭐ (Bình thường)</option>
                            <option value="2">⭐⭐ (Tệ)</option>
                            <option value="1">⭐ (Rất tệ)</option>
                        </select>
                    </div>

                    <div class="form-group-review">
                        <textarea name="comment" rows="4" placeholder="Chia sẻ cảm nhận của bạn về sản phẩm..." class="form-textarea-review" required></textarea>
                    </div>

                    <button type="submit" class="btn-submit-review">Gửi đánh giá</button>
                </form>
            </div>
        <?php else: ?>
            <div class="login-prompt-review">
                <p>Vui lòng <a href="index.php?controller=auth&action=showLogin">đăng nhập</a> để viết đánh giá.</p>
            </div>
        <?php endif; ?>

        <div class="reviews-list">
            <h3>Tất cả đánh giá (<?php echo $totalReviews; ?>)</h3>
            <?php if (!empty($reviews)): ?>
                <?php foreach ($reviews as $review): ?>
                    <div class="review-item">
                        <div class="review-header">
                            <strong class="review-user-name"><?php echo htmlspecialchars($review['full_name'] ?? 'Ẩn danh'); ?></strong>
                            <span class="review-stars">
                                <?php echo display_stars($review['rating']); ?>
                            </span>
                        </div>
                        <p class="review-comment"><?php echo nl2br(htmlspecialchars($review['comment'])); ?></p>
                        <small class="review-date"><?php echo date('d/m/Y H:i', strtotime($review['created_at'])); ?></small>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Chưa có đánh giá nào cho sản phẩm này.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    async function toggleWishlist(productId) {
        try {
            const formData = new FormData();
            formData.append('product_id', productId);

            const response = await fetch('index.php?controller=wishlist&action=toggle', {
                method: 'POST',
                body: formData
            });

            const data = await response.json();

            if (data.success) {
                alert(data.message);

                // Cập nhật nút
                const btn = event.target;
                if (data.action === 'added') {
                    btn.textContent = '💔 Bỏ yêu thích';
                    btn.classList.add('in-wishlist');
                } else {
                    btn.textContent = '❤️ Thêm vào yêu thích';
                    btn.classList.remove('in-wishlist');
                }

                // Cập nhật badge đếm wishlist (nếu có)
                const badge = document.getElementById('wishlist-count-badge');
                if (badge) {
                    badge.textContent = data.count;
                    badge.style.display = data.count > 0 ? 'inline' : 'none';
                }
            } else {
                if (data.redirect) {
                    alert(data.message);
                    window.location.href = data.redirect;
                } else {
                    alert(data.message || 'Có lỗi xảy ra');
                }
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Có lỗi xảy ra khi thêm vào yêu thích');
        }
    }
</script>