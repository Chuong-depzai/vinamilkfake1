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
            </form>

            <a href="index.php" class="btn-back">← Quay lại danh sách</a>

        </div>
    </div>
</div>