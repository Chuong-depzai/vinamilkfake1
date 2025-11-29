<div class="page-container">
    <div class="product-detail-container">
        <div class="product-detail-image-section">
            <?php
            $imagePath = "uploads/" . htmlspecialchars($product['image']);
            if (file_exists(__DIR__ . '/../uploads/' . $product['image'])):
            ?>
                <img src="<?php echo $imagePath; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="product-detail-image">
            <?php else: ?>
                <div class="product-image-placeholder-large">
                    <span class="placeholder-text">Không có ảnh</span>
                </div>
            <?php endif; ?>
        </div>

        <div class="product-detail-info-section">
            <h1 class="product-detail-name"><?php echo htmlspecialchars($product['name']); ?></h1>

            <div class="product-detail-price-box">
                <span class="product-detail-price"><?php echo number_format($product['price'], 0, ',', '.'); ?> VNĐ</span>
            </div>

            <div class="product-detail-meta">
                <div class="product-meta-item">
                    <span class="product-meta-label">Loại sản phẩm:</span>
                    <span class="product-meta-value"><?php echo htmlspecialchars($product['type']); ?></span>
                </div>

                <div class="product-meta-item">
                    <span class="product-meta-label">Quy cách đóng gói:</span>
                    <span class="product-meta-value"><?php echo htmlspecialchars($product['packaging']); ?></span>
                </div>
            </div>

            <div class="product-detail-section">
                <h2 class="product-section-title">Mô tả sản phẩm</h2>
                <p class="product-section-text"><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
            </div>

            <?php if (!empty($product['ingredients'])): ?>
                <div class="product-detail-section">
                    <h2 class="product-section-title">Thành phần</h2>
                    <p class="product-section-text"><?php echo nl2br(htmlspecialchars($product['ingredients'])); ?></p>
                </div>
            <?php endif; ?>

            <form method="POST" action="index.php?controller=cart&action=add" class="add-to-cart-form">
                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                <div class="quantity-selector">
                    <label for="quantity" class="quantity-label">Số lượng:</label>
                    <input type="number" id="quantity" name="quantity" value="1" min="1" max="100" class="quantity-input">
                </div>
                <button type="submit" class="btn-add-to-cart">Thêm vào giỏ hàng</button>
                <button type="button"
                    class="btn-add-to-wishlist"
                    onclick="toggleWishlist(<?php echo $product['id']; ?>)">
                    ❤️ Thêm vào yêu thích
                </button>
            </form>

            <a href="index.php" class="btn-back">← Quay lại danh sách</a>

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
</div>